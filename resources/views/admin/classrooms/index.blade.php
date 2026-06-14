<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-bold text-xl text-slate-800 dark:text-white">Classes</h2>
            <a href="{{ route('admin.classrooms.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 rounded-lg bg-teal-600 hover:bg-teal-700 text-white font-semibold text-sm shadow-md transition-colors">
                + Nouvelle classe
            </a>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            @if(session('success'))
                <div class="rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3 text-sm">{{ session('success') }}</div>
            @endif

            @if($classrooms->isEmpty())
                <div class="card-premium p-8 sm:p-12 text-center">
                    <div class="w-16 h-16 bg-teal-100 dark:bg-teal-900/30 rounded-2xl mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-1">Aucune classe pour l'instant</h3>
                    <p class="text-sm text-slate-500 mb-5">Créez votre première classe pour regrouper les enfants par niveau et leur affecter un éducateur.</p>
                    <a href="{{ route('admin.classrooms.create') }}" class="inline-flex items-center px-5 py-2.5 rounded-lg bg-teal-600 hover:bg-teal-700 text-white font-bold">+ Créer une classe</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($classrooms as $classroom)
                        <div class="card-premium p-5 flex flex-col">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h3 class="font-bold text-lg text-slate-800 dark:text-white">{{ $classroom->nom }}</h3>
                                    <p class="text-xs text-slate-400 uppercase tracking-wider mt-0.5">Niveau {{ $classroom->niveau }}</p>
                                </div>
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-teal-100 text-teal-700">
                                    {{ $classroom->children_count }}/{{ $classroom->capacite }}
                                </span>
                            </div>
                            <div class="text-sm text-slate-500 dark:text-slate-400 mb-4 flex-1">
                                <p class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                                    {{ $classroom->teacher ? $classroom->teacher->prenom.' '.$classroom->teacher->nom : 'Aucun éducateur assigné' }}
                                </p>
                            </div>
                            <div class="flex gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                                <a href="{{ route('admin.classrooms.edit', $classroom) }}" class="flex-1 text-center py-2 rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 hover:bg-slate-200 text-sm font-semibold">Modifier</a>
                                <form action="{{ route('admin.classrooms.destroy', $classroom) }}" method="POST" class="flex-1" onsubmit="return confirm('Supprimer la classe « {{ $classroom->nom }} » ?');">
                                    @csrf @method('DELETE')
                                    <button class="w-full py-2 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 text-sm font-semibold">Supprimer</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
