{{-- View: parent.activities.index | Role: parent | Module: ParentActivities --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Activités de mes enfants</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @forelse($activitiesByChild as $childId => $data)
                <div class="card-premium overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600">
                        <h3 class="font-bold text-lg text-white flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg> {{ $data['child']->prenom }} {{ $data['child']->nom }}</h3>
                        <p class="text-indigo-200 text-sm">{{ $data['child']->classroom?->nom ?? 'Pas de classe assignée' }}</p>
                    </div>
                    <div class="p-6">
                        @if($data['activities']->isEmpty())
                            <p class="text-slate-500 text-center py-4">Aucune activité enregistrée pour cet enfant.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($data['activities'] as $activity)
                                    <div class="flex items-start gap-4 p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-semibold text-slate-800 dark:text-white">{{ $activity->name }}</p>
                                            <p class="text-sm text-slate-500 mt-1">{{ $activity->description }}</p>
                                            <div class="flex items-center gap-3 mt-2 text-xs text-slate-400">
                                                <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> {{ \Carbon\Carbon::parse($activity->scheduled_date)->translatedFormat('d F Y') }}</span>
                                                @if($activity->educator)
                                                    <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg> {{ $activity->educator->prenom }} {{ $activity->educator->nom }}</span>
                                                @endif
                                            </div>
                                            <div class="mt-2">
                                                @if($activity->pivot->attended)
                                                    <span class="badge badge-success flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> A participé</span>
                                                @else
                                                    <span class="badge badge-warning flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg> Inscrit</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="card-premium p-8 text-center">
                    <p class="text-slate-500">Aucun enfant lié à votre compte.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
