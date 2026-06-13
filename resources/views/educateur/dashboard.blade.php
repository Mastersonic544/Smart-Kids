{{-- View: educateur.dashboard | Role: educateur | Module: EducateurDashboard --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Tableau de Bord Éducateur</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Welcome --}}
            <div class="card-premium p-6 bg-gradient-to-r from-teal-600 to-cyan-600 text-white">
                <h3 class="text-2xl font-bold flex items-center gap-2">Bonjour, {{ $teacher?->prenom ?? auth()->user()->name }} <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/></svg></h3>
                <p class="text-teal-100 mt-1">
                    @if($classroom)
                        Classe: <strong>{{ $classroom->nom }}</strong> — {{ $studentCount }} élèves
                    @else
                        Aucune classe assignée pour le moment.
                    @endif
                </p>
            </div>

            {{-- Stats Row --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="stat-card stat-teal">
                    <div class="text-3xl font-bold">{{ $studentCount }}</div>
                    <div class="text-sm text-teal-100 mt-1">Élèves dans ma classe</div>
                </div>
                <div class="stat-card stat-amber">
                    <div class="text-3xl font-bold">{{ $todayAttendance['present'] ?? 0 }}</div>
                    <div class="text-sm text-amber-100 mt-1">Présents aujourd'hui</div>
                </div>
                <div class="stat-card stat-rose">
                    <div class="text-3xl font-bold">{{ $todayAttendance['absent'] ?? 0 }}</div>
                    <div class="text-sm text-rose-100 mt-1">Absents aujourd'hui</div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Attendance CTA --}}
                <div class="card-premium p-6">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-3 flex items-center gap-2"><svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg> Faire l'appel</h3>
                    <p class="text-sm text-slate-500 mb-4">Enregistrez les présences pour aujourd'hui.</p>
                    <a href="{{ route('educateur.attendance') }}" class="btn-primary">
                        Gérer les présences
                    </a>
                </div>

                {{-- Students CTA --}}
                <div class="card-premium p-6">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-3 flex items-center gap-2"><svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg> Mes élèves</h3>
                    <p class="text-sm text-slate-500 mb-4">Consultez la liste de vos élèves et leurs informations.</p>
                    <a href="{{ route('educateur.students') }}" class="btn-primary">
                        Voir la liste
                    </a>
                </div>
            </div>

            {{-- Upcoming Activities --}}
            @if($upcomingActivities->isNotEmpty())
                <div class="card-premium p-6">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4 flex items-center gap-2"><svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Activités à venir</h3>
                    <div class="space-y-3">
                        @foreach($upcomingActivities as $activity)
                            <div class="flex items-center gap-4 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-slate-800 dark:text-white">{{ $activity->name }}</p>
                                    <p class="text-sm text-slate-500">{{ \Carbon\Carbon::parse($activity->scheduled_date)->translatedFormat('d F Y') }}</p>
                                </div>
                                <span class="badge badge-info">{{ $activity->children->count() }} inscrits</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
