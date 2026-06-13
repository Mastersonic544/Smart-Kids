{{-- View: admin.meals.show | Role: admin | Module: Meals --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Menu de la Semaine du') }} {{ \Carbon\Carbon::parse($meal->week_start)->format('d/m/Y') }}
            </h2>
            <a href="{{ route('admin.meals.index') }}" class="text-gray-600 hover:underline">Retour</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-5 gap-4">
            @foreach(['monday' => 'Lundi', 'tuesday' => 'Mardi', 'wednesday' => 'Mercredi', 'thursday' => 'Jeudi', 'friday' => 'Vendredi'] as $dayKey => $dayName)
                @php $dayMeal = $meal->$dayKey ?? []; @endphp
                <div class="bg-white dark:bg-gray-800 shadow rounded p-4 text-center">
                    <h3 class="font-bold border-b border-gray-200 dark:border-gray-700 pb-2 mb-4 dark:text-gray-200">{{ $dayName }}</h3>
                    <div class="mb-4">
                        <span class="text-xs text-gray-500 uppercase tracking-wide block">Petit Déj</span>
                        <p class="font-medium dark:text-white">{{ $dayMeal['breakfast'] ?? '-' }}</p>
                    </div>
                    <div class="mb-4">
                        <span class="text-xs text-gray-500 uppercase tracking-wide block">Déjeuner</span>
                        <p class="font-medium dark:text-white">{{ $dayMeal['lunch'] ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-xs text-gray-500 uppercase tracking-wide block">Goûter</span>
                        <p class="font-medium dark:text-white">{{ $dayMeal['snack'] ?? '-' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
