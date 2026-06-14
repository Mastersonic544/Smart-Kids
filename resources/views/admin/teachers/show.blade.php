<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">{{ $teacher->prenom }} {{ $teacher->nom }}</h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            {{-- Identity card --}}
            <div class="card-premium overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-indigo-600 to-cyan-600 text-white">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center text-3xl font-bold">
                            {{ substr($teacher->prenom, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold">{{ $teacher->prenom }} {{ $teacher->nom }}</h3>
                            <p class="text-indigo-100 text-sm">{{ $teacher->email }}</p>
                            @if($teacher->telephone)
                                <p class="text-indigo-100 text-sm">📞 {{ $teacher->telephone }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="rounded-lg bg-slate-50 dark:bg-slate-700/50 p-4">
                        <p class="text-xs text-slate-400 uppercase tracking-wider">Classe</p>
                        <p class="font-bold text-slate-800 dark:text-white mt-1">{{ $teacher->classroom?->nom ?? 'Non assignée' }}</p>
                    </div>
                    <div class="rounded-lg bg-slate-50 dark:bg-slate-700/50 p-4">
                        <p class="text-xs text-slate-400 uppercase tracking-wider">Activités menées</p>
                        <p class="font-bold text-slate-800 dark:text-white mt-1">{{ $teacher->activities->count() }}</p>
                    </div>
                    <div class="rounded-lg bg-slate-50 dark:bg-slate-700/50 p-4">
                        <p class="text-xs text-slate-400 uppercase tracking-wider">Compte utilisateur</p>
                        <p class="font-bold mt-1 {{ $teacher->user ? 'text-teal-600' : 'text-rose-600' }}">
                            {{ $teacher->user ? 'Actif' : 'Aucun' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.teachers.edit', $teacher) }}" class="flex-1 px-5 py-3 rounded-lg bg-teal-600 hover:bg-teal-700 text-white font-bold text-center shadow-md">Modifier la fiche</a>
                @if($teacher->user)
                    <a href="{{ route('messages.conversation', $teacher->user_id) }}" class="flex-1 px-5 py-3 rounded-lg bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-center">Envoyer un message</a>
                @endif
                <a href="{{ route('admin.teachers.index') }}" class="flex-1 px-5 py-3 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-semibold text-center">← Retour</a>
            </div>

            {{-- Recent activities --}}
            @if($teacher->activities->isNotEmpty())
                <div class="card-premium p-6">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Activités récentes</h3>
                    <div class="space-y-2">
                        @foreach($teacher->activities->take(8) as $act)
                            <div class="flex items-center justify-between p-3 rounded-lg bg-slate-50 dark:bg-slate-700/40">
                                <div>
                                    <p class="font-semibold text-slate-800 dark:text-white">{{ $act->name }}</p>
                                    <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($act->scheduled_date)->translatedFormat('d M Y') }}</p>
                                </div>
                                @if($act->status instanceof \App\Enums\ActivityStatus)
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-{{ $act->status->color() }}-100 text-{{ $act->status->color() }}-700">
                                        {{ $act->status->label() }}
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
