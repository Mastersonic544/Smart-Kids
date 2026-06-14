<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <div>
                <h2 class="font-bold text-xl text-slate-800 dark:text-white">Codes d'accès — {{ $admin->name }}</h2>
                <p class="text-sm text-slate-500">{{ $admin->email }}</p>
            </div>
            <a href="{{ route('superadmin.admins.index') }}" class="px-4 py-2 rounded-lg bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-semibold text-sm text-center">← Retour aux kindergartens</a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8" x-data="{ reveal: {} }">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-indigo-900 text-white p-6 shadow-xl">
                <p class="text-indigo-200 text-sm uppercase tracking-wider font-semibold">⚠️ Données sensibles</p>
                <p class="text-indigo-50 text-sm mt-2 max-w-2xl">
                    Cette page liste tous les codes à 6 chiffres parents et éducateurs de cet établissement.
                    Cliquez sur l'œil pour révéler un code et ne le partagez qu'avec la personne concernée.
                </p>
            </div>

            {{-- Educators --}}
            <div class="card-premium overflow-hidden">
                <div class="px-6 py-4 bg-indigo-50 dark:bg-indigo-900/30 border-b border-indigo-200 dark:border-indigo-700">
                    <h3 class="font-bold text-indigo-800 dark:text-indigo-200">Éducateurs ({{ $educators->count() }})</h3>
                </div>
                @if($educators->isEmpty())
                    <p class="px-6 py-8 text-center text-slate-400 text-sm">Aucun éducateur dans cet établissement.</p>
                @else
                    <div class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($educators as $edu)
                            <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-800 dark:text-white truncate">{{ $edu->name }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ $edu->email }}{{ $edu->phone ? ' • '.$edu->phone : '' }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="font-mono font-bold text-2xl tracking-[0.3em] bg-slate-100 dark:bg-slate-800 rounded-lg px-4 py-2 select-all"
                                         x-text="reveal['edu-{{ $edu->id }}'] ? '{{ $edu->passcode ?? '——————' }}' : '• • • • • •'"></div>
                                    <button type="button" @click="reveal['edu-{{ $edu->id }}'] = !reveal['edu-{{ $edu->id }}']"
                                            class="p-2 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 transition-colors"
                                            :title="reveal['edu-{{ $edu->id }}'] ? 'Masquer' : 'Révéler'">
                                        <svg x-show="!reveal['edu-{{ $edu->id }}']" class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="reveal['edu-{{ $edu->id }}']" x-cloak class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Parents --}}
            <div class="card-premium overflow-hidden">
                <div class="px-6 py-4 bg-teal-50 dark:bg-teal-900/30 border-b border-teal-200 dark:border-teal-700">
                    <h3 class="font-bold text-teal-800 dark:text-teal-200">Parents ({{ $parents->count() }})</h3>
                </div>
                @if($parents->isEmpty())
                    <p class="px-6 py-8 text-center text-slate-400 text-sm">Aucun parent dans cet établissement.</p>
                @else
                    <div class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($parents as $p)
                            <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="font-semibold text-slate-800 dark:text-white truncate">{{ $p->name }}</p>
                                    <p class="text-xs text-slate-500 truncate">{{ $p->email }}{{ $p->phone ? ' • '.$p->phone : '' }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="font-mono font-bold text-2xl tracking-[0.3em] bg-slate-100 dark:bg-slate-800 rounded-lg px-4 py-2 select-all"
                                         x-text="reveal['par-{{ $p->id }}'] ? '{{ $p->passcode ?? '——————' }}' : '• • • • • •'"></div>
                                    <button type="button" @click="reveal['par-{{ $p->id }}'] = !reveal['par-{{ $p->id }}']"
                                            class="p-2 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 transition-colors"
                                            :title="reveal['par-{{ $p->id }}'] ? 'Masquer' : 'Révéler'">
                                        <svg x-show="!reveal['par-{{ $p->id }}']" class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="reveal['par-{{ $p->id }}']" x-cloak class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
