{{-- View: shared.messages.conversation | Role: shared | Module: Messaging --}}
<x-app-layout>
    <div class="flex flex-col h-[calc(100vh-4rem)] bg-slate-50 dark:bg-slate-900">
        {{-- Chat Header --}}
        <div class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 px-4 sm:px-6 py-3">
            <div class="flex items-center gap-3">
                <a href="{{ route('messages.inbox') }}" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors md:hidden">
                    <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <a href="{{ route('messages.inbox') }}" class="hidden md:block p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <div class="relative">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-teal-500 to-cyan-500 flex items-center justify-center text-white font-bold shadow">
                        {{ substr($otherUser->name, 0, 1) }}
                    </div>
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-white dark:border-slate-800 rounded-full"></div>
                </div>
                <div>
                    <h3 class="font-semibold text-slate-800 dark:text-white">{{ $otherUser->name }}</h3>
                    <p class="text-xs text-emerald-500 font-medium">En ligne</p>
                </div>
            </div>
        </div>

        {{-- Messages Container --}}
        <div id="messages-container" class="flex-1 overflow-y-auto px-4 sm:px-6 py-4 space-y-3 custom-scrollbar">
            @php $lastDate = null; @endphp
            @foreach($messages as $message)
                @php
                    $msgDate = $message->created_at->format('d/m/Y');
                    $showDate = $msgDate !== $lastDate;
                    $lastDate = $msgDate;
                @endphp

                {{-- Date separator --}}
                @if($showDate)
                    <div class="flex items-center justify-center my-4">
                        <span class="px-3 py-1 bg-slate-200 dark:bg-slate-700 rounded-full text-xs text-slate-500 dark:text-slate-400 font-medium">
                            {{ $message->created_at->translatedFormat('d F Y') }}
                        </span>
                    </div>
                @endif

                {{-- Message bubble --}}
                <div class="flex {{ $message->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }} message-item" data-id="{{ $message->id }}">
                    @if($message->sender_id != Auth::id())
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-teal-500 to-cyan-500 flex items-center justify-center text-white font-bold text-xs mr-2 flex-shrink-0 mt-1">
                            {{ substr($otherUser->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="flex flex-col {{ $message->sender_id == Auth::id() ? 'items-end' : 'items-start' }} max-w-[75%]">
                        <span class="text-[10px] text-slate-500 mb-1 px-1">{{ $message->sender_id == Auth::id() ? 'Vous' : $otherUser->name }}</span>
                        <div class="{{ $message->sender_id == Auth::id() ? 'chat-bubble chat-bubble-sent' : 'chat-bubble chat-bubble-received' }}">
                            <p>{{ $message->body }}</p>
                            <div class="flex items-center justify-end gap-1 mt-1">
                                <span class="text-[10px] {{ $message->sender_id == Auth::id() ? 'text-teal-200' : 'text-slate-400' }}">
                                    {{ $message->created_at->format('H:i') }}
                                </span>
                                @if($message->sender_id == Auth::id())
                                    <svg class="w-3.5 h-3.5 {{ $message->read_at ? 'text-sky-300' : 'text-teal-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                        @if($message->read_at)
                                            <path d="M18 7l-1.41-1.41-6.34 6.34 1.41 1.41L18 7zm4.24-1.41L11.66 16.17 7.48 12l-1.41 1.41L11.66 19l12-12-1.42-1.41zM.41 13.41L6 19l1.41-1.41L1.83 12 .41 13.41z"/>
                                        @else
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                        @endif
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Message Input --}}
        <div class="bg-white dark:bg-slate-800 border-t border-slate-200 dark:border-slate-700 px-4 sm:px-6 py-3">
            <form id="message-form" class="flex items-center gap-3">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $otherUser->id }}">
                <div class="flex-1 relative">
                    <input type="text" name="body" id="message-input" placeholder="Tapez un message..."
                           class="w-full pl-4 pr-4 py-3 bg-slate-100 dark:bg-slate-700 border-0 rounded-2xl text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:ring-2 focus:ring-teal-500"
                           required autocomplete="off">
                </div>
                <button type="submit" class="w-11 h-11 bg-teal-600 rounded-full flex items-center justify-center text-white hover:bg-teal-700 transition-all shadow-md shadow-teal-200 dark:shadow-teal-900 hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </form>
        </div>
    </div>

    {{-- AJAX messaging script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('messages-container');
            const form = document.getElementById('message-form');
            const input = document.getElementById('message-input');
            const receiverId = {{ $otherUser->id }};
            const currentUserId = {{ Auth::id() }};
            let lastMessageId = {{ $messages->last()?->id ?? 0 }};

            // Scroll to bottom
            container.scrollTop = container.scrollHeight;

            // AJAX send
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const body = input.value.trim();
                if (!body) return;

                fetch('{{ route("messages.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ receiver_id: receiverId, body: body })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        appendMessage(data.message, true);
                        lastMessageId = data.message.id;
                        input.value = '';
                    }
                });
            });

            // Poll for new messages every 3 seconds
            setInterval(function() {
                fetch(`/messages/${receiverId}/poll?after=${lastMessageId}`, {
                    headers: { 
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Network or Auth Error');
                    const contentType = res.headers.get("content-type");
                    if (!contentType || !contentType.includes("application/json")) {
                        throw new TypeError("Oops, we haven't got JSON!");
                    }
                    return res.json();
                })
                .then(data => {
                    if (data.messages && data.messages.length > 0) {
                        data.messages.forEach(msg => {
                            if (msg.sender_id != currentUserId) {
                                appendMessage(msg, false);
                            }
                            lastMessageId = Math.max(lastMessageId, msg.id);
                        });
                    }
                })
                .catch(error => console.warn('Polling skipped this cycle:', error));
            }, 3000);

            function appendMessage(msg, isSent) {
                const div = document.createElement('div');
                div.className = `flex ${isSent ? 'justify-end' : 'justify-start'} message-item animate-fade-in-up`;
                div.dataset.id = msg.id;
                const time = new Date(msg.created_at).toLocaleTimeString('fr-FR', {hour:'2-digit', minute:'2-digit'});
                div.innerHTML = `
                    <div class="flex flex-col ${isSent ? 'items-end' : 'items-start'} max-w-[75%]">
                        <span class="text-[10px] text-slate-500 mb-1 px-1">${isSent ? 'Vous' : '{{ addslashes($otherUser->name) }}'}</span>
                        <div class="${isSent ? 'chat-bubble chat-bubble-sent' : 'chat-bubble chat-bubble-received'}">
                            <p>${msg.body}</p>
                            <div class="flex items-center justify-end gap-1 mt-1">
                                <span class="text-[10px] ${isSent ? 'text-teal-200' : 'text-slate-400'}">${time}</span>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(div);
                container.scrollTop = container.scrollHeight;
            }
        });
    </script>
</x-app-layout>
