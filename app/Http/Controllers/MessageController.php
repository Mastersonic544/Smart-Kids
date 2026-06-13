<?php

namespace App\Http\Controllers;

use App\Services\Messages\MessageService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller handling Messenger-clone internal messaging between users.
 */
class MessageController extends Controller
{
    protected $messageService;

    /**
     * Inject MessageService.
     *
     * @param MessageService $messageService
     */
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * Show the Messenger-clone inbox.
     *
     * @return \Illuminate\View\View
     */
    public function inbox()
    {
        $conversations = $this->messageService->getInbox(Auth::id());
        $users = $this->messageService->getContactableUsers(Auth::user());
        return view('shared.messages.inbox', compact('conversations', 'users'));
    }

    /**
     * Show the new conversation user picker.
     *
     * @return \Illuminate\View\View
     */
    public function newConversation()
    {
        $users = $this->messageService->getContactableUsers(Auth::user());
        return view('shared.messages.new', compact('users'));
    }

    /**
     * Search users for the new conversation picker (AJAX).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchUsers(Request $request)
    {
        $query = $request->get('q', '');
        $users = $this->messageService->searchUsers(Auth::user(), $query);
        return response()->json($users);
    }

    /**
     * Show a specific conversation.
     *
     * @param int $userId
     * @return \Illuminate\View\View
     */
    public function conversation($userId)
    {
        $otherUser = User::findOrFail($userId);
        $messages = $this->messageService->getConversation(Auth::id(), $userId);

        // Mark messages from this user as read
        $this->messageService->markConversationAsRead(Auth::id(), $userId);

        return view('shared.messages.conversation', compact('otherUser', 'messages'));
    }

    /**
     * Send a new message.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'body' => 'required|string|max:5000',
        ]);

        $message = $this->messageService->sendMessage(
            Auth::id(),
            $request->receiver_id,
            $request->body
        );

        // Support AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return redirect()->route('messages.conversation', $request->receiver_id);
    }

    /**
     * Mark conversation messages as read.
     *
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead($userId)
    {
        $this->messageService->markConversationAsRead(Auth::id(), $userId);
        return response()->json(['success' => true]);
    }

    /**
     * Poll for new messages in a conversation (AJAX).
     *
     * @param Request $request
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function poll(Request $request, $userId)
    {
        $afterId = $request->get('after', 0);
        $messages = $this->messageService->getNewMessages(Auth::id(), $userId, $afterId);
        $this->messageService->markConversationAsRead(Auth::id(), $userId);

        return response()->json([
            'messages' => $messages,
        ]);
    }
}
