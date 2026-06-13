{{-- View: parent.meals.index | Role: parent | Module: Meals --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Menu de la Semaine</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($meal)
                <div class="text-center mb-6">
                    <p class="text-slate-500">Semaine du <strong class="text-slate-800 dark:text-white">{{ \Carbon\Carbon::parse($meal->week_start)->translatedFormat('d F Y') }}</strong></p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    @foreach(['monday' => 'Lundi', 'tuesday' => 'Mardi', 'wednesday' => 'Mercredi', 'thursday' => 'Jeudi', 'friday' => 'Vendredi'] as $dayKey => $dayName)
                        @php $dayMeal = $meal->$dayKey ?? []; @endphp
                        <div class="card-premium p-5 text-center">
                            <h3 class="font-bold text-teal-600 dark:text-teal-400 pb-2 mb-4 border-b border-slate-100 dark:border-slate-700">{{ $dayName }}</h3>
                            <div class="mb-4">
                                <span class="text-xs text-slate-400 uppercase tracking-wider block flex items-center gap-1 justify-center"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg> Petit Déjeuner</span>
                                <p class="font-semibold text-slate-800 dark:text-white mt-1 text-sm">{{ $dayMeal['breakfast'] ?? 'Non spécifié' }}</p>
                            </div>
                            <div class="mb-4">
                                <span class="text-xs text-slate-400 uppercase tracking-wider block flex items-center gap-1 justify-center"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg> Déjeuner</span>
                                <p class="font-semibold text-slate-800 dark:text-white mt-1 text-sm">{{ $dayMeal['lunch'] ?? 'Non spécifié' }}</p>
                            </div>
                            <div>
                                <span class="text-xs text-slate-400 uppercase tracking-wider block flex items-center gap-1 justify-center"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0A1.75 1.75 0 003 15.546V12a9 9 0 0118 0v3.546z"/></svg> Goûter</span>
                                <p class="font-semibold text-slate-800 dark:text-white mt-1 text-sm">{{ $dayMeal['snack'] ?? 'Non spécifié' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card-premium p-8 text-center">
                    <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    </div>
                    <p class="text-slate-500 text-lg">Aucun menu n'a encore été publié pour cette semaine.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
