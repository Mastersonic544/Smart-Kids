{{-- View: shared.messages.inbox | Role: shared | Module: Messaging --}}
<x-app-layout>
    <div class="flex h-[calc(100vh-4rem)]">
        {{-- Sidebar: Conversation List --}}
        <div class="w-full md:w-96 bg-white dark:bg-slate-800 border-r border-slate-200 dark:border-slate-700 flex flex-col">
            {{-- Header --}}
            <div class="p-4 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-xl font-bold text-slate-800 dark:text-white">Messages</h2>
                    <a href="{{ route('messages.new') }}" class="w-9 h-9 bg-teal-600 rounded-full flex items-center justify-center text-white hover:bg-teal-700 transition-colors shadow-md" title="Nouvelle conversation">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    </a>
                </div>
                {{-- Search --}}
                <div class="relative">
                    <input type="text" placeholder="Rechercher une conversation..." class="w-full pl-10 pr-4 py-2.5 bg-slate-100 dark:bg-slate-700 border-0 rounded-xl text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:ring-2 focus:ring-teal-500">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            {{-- Conversation List --}}
            <div class="flex-1 overflow-y-auto custom-scrollbar">
                @forelse($conversations as $contactId => $lastMessage)
                    @php
                        $otherUser = $lastMessage->sender_id == Auth::id() ? $lastMessage->receiver : $lastMessage->sender;
                        $isUnread = $lastMessage->receiver_id == Auth::id() && !$lastMessage->read_at;
                    @endphp
                    <a href="{{ route('messages.conversation', $contactId) }}" class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors border-b border-slate-100 dark:border-slate-700/50 {{ $isUnread ? 'bg-teal-50/50 dark:bg-teal-900/10' : '' }}">
                        <div class="relative flex-shrink-0">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-teal-500 to-cyan-500 flex items-center justify-center text-white font-bold text-lg shadow">
                                {{ substr($otherUser->name, 0, 1) }}
                            </div>
                            <div class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-emerald-500 border-2 border-white dark:border-slate-800 rounded-full"></div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-slate-800 dark:text-white truncate {{ $isUnread ? 'text-teal-700 dark:text-teal-400' : '' }}">
                                    {{ $otherUser->name }}
                                </p>
                                <span class="text-[11px] text-slate-400 dark:text-slate-500 flex-shrink-0 ml-2">
                                    {{ $lastMessage->created_at->diffForHumans(null, true) }}
                                </span>
                            </div>
                            <p class="text-sm text-slate-500 dark:text-slate-400 truncate mt-0.5">
                                @if($lastMessage->sender_id == Auth::id())
                                    <span class="text-slate-400">Vous: </span>
                                @endif
                                {{ Str::limit($lastMessage->body, 40) }}
                            </p>
                        </div>
                        @if($isUnread)
                            <div class="w-2.5 h-2.5 rounded-full bg-teal-500 flex-shrink-0 animate-pulse-dot"></div>
                        @endif
                    </a>
                @empty
                    <div class="flex flex-col items-center justify-center py-16 px-6 text-center">
                        <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 font-medium">Aucune conversation</p>
                        <p class="text-sm text-slate-400 mt-1">Commencez par envoyer un message</p>
                        <a href="{{ route('messages.new') }}" class="btn-primary mt-4 text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Nouveau message
                        </a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Main: Empty state (select a conversation) --}}
        <div class="hidden md:flex flex-1 items-center justify-center bg-slate-50 dark:bg-slate-900">
            <div class="text-center">
                <div class="w-20 h-20 bg-slate-200 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <h3 class="text-lg font-semibold text-slate-600 dark:text-slate-400">Sélectionnez une conversation</h3>
                <p class="text-sm text-slate-400 mt-1">Ou commencez-en une nouvelle</p>
            </div>
        </div>
    </div>
</x-app-layout>
