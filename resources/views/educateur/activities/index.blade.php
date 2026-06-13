{{-- View: educateur.activities.index | Role: educateur | Module: EducateurActivities --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Mes Activités</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($activities->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($activities as $activity)
                        <div class="card-premium p-6">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="font-bold text-lg text-slate-800 dark:text-white">{{ $activity->name }}</h3>
                                <span class="badge badge-info">{{ $activity->children->count() }} inscrits</span>
                            </div>
                            <p class="text-sm text-slate-500 mb-3">{{ $activity->description }}</p>
                            <div class="flex items-center gap-4 text-sm text-slate-500">
                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> {{ \Carbon\Carbon::parse($activity->scheduled_date)->translatedFormat('d F Y') }}</span>
                                @if($activity->scheduled_time)
                                    <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> {{ $activity->scheduled_time }}</span>
                                @endif
                            </div>
                            @if($activity->children->isNotEmpty())
                                <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-700">
                                    <p class="text-xs text-slate-400 uppercase tracking-wider mb-2">Enfants inscrits</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($activity->children as $child)
                                            <span class="badge badge-success">{{ $child->prenom }} {{ $child->nom }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card-premium p-8 text-center">
                    <p class="text-slate-500">Aucune activité planifiée.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
