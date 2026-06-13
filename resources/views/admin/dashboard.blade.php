{{-- View: admin.dashboard | Role: admin | Module: AdminDashboard --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Tableau de Bord Administration</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome --}}
            <div class="card-premium p-6 bg-gradient-to-r from-slate-800 to-slate-900 text-white">
                <h3 class="text-2xl font-bold flex items-center gap-2">Console d'administration <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></h3>
                <p class="text-slate-300 mt-1">Vue d'ensemble de votre établissement SmartKids.</p>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="stat-card stat-teal">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-teal-100 font-medium">Total Enfants</div>
                            <div class="text-3xl font-bold mt-1">{{ $stats['total_children'] }}</div>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="stat-card stat-indigo">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-indigo-100 font-medium">Total Enseignants</div>
                            <div class="text-3xl font-bold mt-1">{{ $stats['total_teachers'] }}</div>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                        </div>
                    </div>
                </div>
                <div class="stat-card stat-amber">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-amber-100 font-medium">Inscriptions en Attente</div>
                            <div class="text-3xl font-bold mt-1">{{ $stats['pending_enrollments'] }}</div>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                        </div>
                    </div>
                </div>
                <div class="stat-card stat-rose">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-rose-100 font-medium">Paiements en Attente</div>
                            <div class="text-3xl font-bold mt-1">{{ $stats['overdue_payments'] }}</div>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('admin.children.index') }}" class="card-premium p-5 text-center group">
                    <div class="w-12 h-12 bg-teal-100 dark:bg-teal-900/30 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <p class="font-semibold text-sm text-slate-800 dark:text-white">Gérer Enfants</p>
                </a>
                <a href="{{ route('admin.teachers.index') }}" class="card-premium p-5 text-center group">
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                    </div>
                    <p class="font-semibold text-sm text-slate-800 dark:text-white">Gérer Enseignants</p>
                </a>
                <a href="{{ route('admin.activities.index') }}" class="card-premium p-5 text-center group">
                    <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                    </div>
                    <p class="font-semibold text-sm text-slate-800 dark:text-white">Gérer Activités</p>
                </a>
                <a href="{{ route('admin.meals.index') }}" class="card-premium p-5 text-center group">
                    <div class="w-12 h-12 bg-rose-100 dark:bg-rose-900/30 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    </div>
                    <p class="font-semibold text-sm text-slate-800 dark:text-white">Gérer Repas</p>
                </a>
            </div>

            {{-- Recent Summary --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="card-premium p-6">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4 flex items-center gap-2"><svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg> Répartition par classe</h3>
                    @foreach($stats['classrooms'] ?? [] as $classroom)
                        <div class="flex items-center justify-between py-2 border-b border-slate-100 dark:border-slate-700 last:border-0">
                            <span class="font-medium text-slate-700 dark:text-slate-300">{{ $classroom->nom }}</span>
                            <span class="badge badge-info">{{ $classroom->children_count }} enfants</span>
                        </div>
                    @endforeach
                    @if(empty($stats['classrooms'] ?? []) || count($stats['classrooms'] ?? []) === 0)
                        <p class="text-slate-400 text-sm">Aucune donnée de classe disponible.</p>
                    @endif
                </div>
                <div class="card-premium p-6">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4 flex items-center gap-2"><svg class="w-5 h-5 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg> Messages récents</h3>
                    <p class="text-slate-400 text-sm mb-4">Accédez à votre messagerie pour communiquer avec les parents et éducateurs.</p>
                    <a href="{{ route('messages.inbox') }}" class="btn-primary">
                        Ouvrir la messagerie
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
