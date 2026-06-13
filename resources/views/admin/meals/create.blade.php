{{-- View: admin.meals.create | Role: admin | Module: Meals --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Créer le Menu de la Semaine') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.meals.store') }}">
                @csrf
                <div class="mb-4 bg-white dark:bg-gray-800 p-6 rounded shadow">
                    <label class="block text-sm font-medium mb-2 dark:text-gray-300">Date du Lundi de la semaine</label>
                    <input type="date" name="week_start" class="w-full md:w-1/3 rounded border hover:border-gray-500 dark:bg-gray-900 dark:text-white dark:border-gray-700" required>
                    @error('week_start') <span class="text-red-500 block text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    @foreach(['monday' => 'Lundi', 'tuesday' => 'Mardi', 'wednesday' => 'Mercredi', 'thursday' => 'Jeudi', 'friday' => 'Vendredi'] as $dayKey => $dayName)
                        <div class="bg-white dark:bg-gray-800 shadow rounded p-4">
                            <h3 class="font-bold text-center mb-4 dark:text-gray-200">{{ $dayName }}</h3>
                            <div class="mb-3">
                                <label class="text-sm dark:text-gray-400">Petit Déjeuner</label>
                                <input type="text" name="{{ $dayKey }}[breakfast]" class="w-full text-sm rounded mt-1 dark:bg-gray-900 dark:text-white dark:border-gray-700">
                            </div>
                            <div class="mb-3">
                                <label class="text-sm dark:text-gray-400">Déjeuner</label>
                                <input type="text" name="{{ $dayKey }}[lunch]" class="w-full text-sm rounded mt-1 dark:bg-gray-900 dark:text-white dark:border-gray-700">
                            </div>
                            <div class="mb-3">
                                <label class="text-sm dark:text-gray-400">Goûter</label>
                                <input type="text" name="{{ $dayKey }}[snack]" class="w-full text-sm rounded mt-1 dark:bg-gray-900 dark:text-white dark:border-gray-700">
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 text-right">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">Enregistrer le Menu</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
