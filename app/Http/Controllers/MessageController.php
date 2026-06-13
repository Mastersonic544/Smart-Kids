<?php

namespace App\Http\Controllers;

use App\Http\Requests\Messages\SendMessageRequest;
use App\Models\User;
use App\Services\Messages\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Controller handling Messenger-clone internal messaging between users.
 */
class MessageController extends Controller
{
    protected $messageService;

    /**
     * Inject MessageService.
     */
    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * Show the Messenger-clone inbox.
     *
     * @return View
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
     * @return View
     */
    public function newConversation()
    {
        $users = $this->messageService->getContactableUsers(Auth::user());

        return view('shared.messages.new', compact('users'));
    }

    /**
     * Search users for the new conversation picker (AJAX).
     *
     * @return JsonResponse
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
     * @param  int  $userId
     * @return View
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
     * @param  Request  $request
     * @return RedirectResponse|JsonResponse
     */
    public function send(SendMessageRequest $request)
    {
        $data = $request->validated();

        $message = $this->messageService->sendMessage(
            Auth::id(),
            $data['receiver_id'],
            $data['body']
        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return redirect()->route('messages.conversation', $data['receiver_id']);
    }

    /**
     * Mark conversation messages as read.
     *
     * @param  int  $userId
     * @return JsonResponse
     */
    public function markAsRead($userId)
    {
        $this->messageService->markConversationAsRead(Auth::id(), $userId);

        return response()->json(['success' => true]);
    }

    /**
     * Poll for new messages in a conversation (AJAX).
     *
     * @param  int  $userId
     * @return JsonResponse
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
