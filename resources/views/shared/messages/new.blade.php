{{-- View: shared.messages.new | Role: shared | Module: Messaging --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('messages.inbox') }}" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                <svg class="w-5 h-5 text-slate-600 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="font-bold text-xl text-slate-800 dark:text-white">Nouvelle conversation</h2>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="card-premium p-6">
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Choisir un destinataire</label>
                    <input type="text" id="user-search" placeholder="Rechercher par nom..."
                           class="w-full px-4 py-3 bg-slate-100 dark:bg-slate-700 border-0 rounded-xl text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:ring-2 focus:ring-teal-500">
                </div>

                <div class="space-y-2 max-h-96 overflow-y-auto custom-scrollbar" id="user-list">
                    @foreach($users as $user)
                        <a href="{{ route('messages.conversation', $user->id) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/50 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-teal-500 to-cyan-500 flex items-center justify-center text-white font-bold shadow">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-800 dark:text-white text-sm">{{ $user->name }}</p>
                                <p class="text-xs text-slate-400">{{ $user->email }}</p>
                            </div>
                            <div class="ml-auto">
                                <span class="badge badge-info">{{ $user->getRoleNames()->first() ?? 'Utilisateur' }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('user-search').addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('#user-list > a').forEach(function(el) {
                const name = el.querySelector('.font-semibold').textContent.toLowerCase();
                el.style.display = name.includes(query) ? 'flex' : 'none';
            });
        });
    </script>
</x-app-layout>
