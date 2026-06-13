{{-- View: components.notification-bell | Role: shared | Module: Notifications --}}
@props(['notifications' => collect()])

<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="relative p-2 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none transition-all">
        <span class="sr-only">Notifications</span>
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        @if($notifications->count() > 0)
            <span class="absolute -top-0.5 -right-0.5 inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-rose-500 rounded-full shadow animate-pulse-dot">
                {{ $notifications->count() }}
            </span>
        @endif
    </button>

    <div x-show="open" @click.away="open = false"
         class="absolute right-0 mt-2 w-80 bg-white dark:bg-slate-800 rounded-2xl shadow-xl overflow-hidden z-50 border border-slate-200 dark:border-slate-700"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95">

        <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
            <h3 class="text-sm font-bold text-slate-800 dark:text-white">Notifications</h3>
            @if($notifications->count() > 0)
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    <button type="submit" class="text-xs text-teal-600 hover:text-teal-700 font-medium">Tout marquer comme lu</button>
                </form>
            @endif
        </div>

        <div class="divide-y divide-slate-100 dark:divide-slate-700 max-h-80 overflow-y-auto custom-scrollbar">
            @forelse($notifications->take(5) as $notification)
                <div class="px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                    <p class="text-sm font-semibold text-slate-800 dark:text-white">
                        {{ $notification->data['title'] ?? 'Notification' }}
                    </p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        {{ $notification->data['message'] ?? '' }}
                    </p>
                    <p class="text-[10px] text-slate-400 mt-1">
                        {{ $notification->created_at->diffForHumans() }}
                    </p>
                </div>
            @empty
                <div class="px-4 py-8 text-center">
                    <div class="w-12 h-12 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    </div>
                    <p class="text-sm text-slate-400">Aucune notification</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
