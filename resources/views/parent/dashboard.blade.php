{{-- View: parent.dashboard | Role: parent | Module: ParentPortal --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Tableau de Bord Parent</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome --}}
            <div class="card-premium p-6 bg-gradient-to-r from-teal-600 to-cyan-600 text-white">
                <h3 class="text-2xl font-bold flex items-center gap-2">Bienvenue, {{ auth()->user()->name }} <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11"/></svg></h3>
                <p class="text-teal-100 mt-1">Retrouvez ici un résumé de la situation de vos enfants.</p>
            </div>

            @if(count($dashboardData) === 0)
                <div class="card-premium p-8 text-center">
                    <p class="text-slate-500">Aucun enfant n'est actuellement lié à votre compte.</p>
                </div>
            @else
                {{-- Children Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($dashboardData as $data)
                        <div class="card-premium overflow-hidden">
                            <div class="h-2 bg-gradient-to-r from-teal-500 to-cyan-500"></div>
                            <div class="p-6">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white font-bold text-lg shadow">
                                        {{ substr($data['child']->prenom, 0, 1) }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-lg text-slate-800 dark:text-white">{{ $data['child']->prenom }} {{ $data['child']->nom }}</h3>
                                        <p class="text-sm text-slate-500">{{ $data['child']->classroom->nom ?? 'En attente d\'affectation' }}</p>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-3">
                                        <span class="text-xs text-slate-400 uppercase tracking-wider">Présences ce mois</span>
                                        <p class="text-lg font-bold text-teal-600 dark:text-teal-400">{{ $data['attendance_count'] }} jours</p>
                                    </div>
                                    <div class="bg-slate-50 dark:bg-slate-700/50 rounded-xl p-3">
                                        <span class="text-xs text-slate-400 uppercase tracking-wider">Prochain Paiement</span>
                                        @if($data['next_payment'])
                                            <p class="text-lg font-bold text-rose-600 dark:text-rose-400">{{ $data['next_payment']->montant }} DT</p>
                                            <span class="badge badge-warning mt-1">{{ $data['next_payment']->statut }}</span>
                                        @else
                                            <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400 mt-1 flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> À jour !</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Quick Access --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('parent.activities') }}" class="card-premium p-5 text-center group">
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                        </div>
                        <p class="font-semibold text-sm text-slate-800 dark:text-white">Activités</p>
                    </a>
                    <a href="{{ route('parent.teachers') }}" class="card-premium p-5 text-center group">
                        <div class="w-12 h-12 bg-teal-100 dark:bg-teal-900/30 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                        </div>
                        <p class="font-semibold text-sm text-slate-800 dark:text-white">Enseignants</p>
                    </a>
                    <a href="{{ route('parent.meals') }}" class="card-premium p-5 text-center group">
                        <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        </div>
                        <p class="font-semibold text-sm text-slate-800 dark:text-white">Repas</p>
                    </a>
                    <a href="{{ route('parent.payments') }}" class="card-premium p-5 text-center group">
                        <div class="w-12 h-12 bg-rose-100 dark:bg-rose-900/30 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                            <svg class="w-7 h-7 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <p class="font-semibold text-sm text-slate-800 dark:text-white">Paiements</p>
                    </a>
                </div>
            @endif

            {{-- Current Menu --}}
            @if($currentMenu)
                <div class="card-premium overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-amber-500 to-orange-500">
                        <h3 class="font-bold text-white flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg> Menu de la semaine</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-slate-500 mb-4">Consultez les repas prévus pour les enfants cette semaine.</p>
                        <a href="{{ route('parent.meals') }}" class="btn-primary">Voir le menu complet</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
