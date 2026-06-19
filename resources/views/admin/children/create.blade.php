{{-- View: admin.children.create | Role: admin | Module: Children --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ajouter un Enfant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('admin.children.store') }}">
                        @csrf
                        
                        <!-- Nom -->
                        <div class="mb-4">
                            <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom</label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-black dark:text-gray-300" required>
                            @error('nom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Prénom -->
                        <div class="mb-4">
                            <label for="prenom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prénom</label>
                            <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-black dark:text-gray-300" required>
                            @error('prenom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Date de Naissance -->
                        <div class="mb-4">
                            <label for="date_naissance" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date de Naissance</label>
                            <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-black dark:text-gray-300" required>
                            @error('date_naissance') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Allergies -->
                        <div class="mb-4">
                            <label for="allergies" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Allergies (Optionnel)</label>
                            <textarea name="allergies" id="allergies" rows="3" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-black dark:text-gray-300">{{ old('allergies') }}</textarea>
                            @error('allergies') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Parent -->
                        <div class="mb-4">
                            <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Parent Associé</label>
                            <select name="parent_id" id="parent_id" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-black dark:text-gray-300" required>
                                <option value="">-- Sélectionner un parent --</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }} ({{ $parent->email }})</option>
                                @endforeach
                            </select>
                            @error('parent_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Classe -->
                        <div class="mb-4">
                            <label for="classroom_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Classe (Optionnel)</label>
                            <select name="classroom_id" id="classroom_id" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-black dark:text-gray-300">
                                <option value="">-- Aucune classe --</option>
                                @foreach($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}" {{ old('classroom_id') == $classroom->id ? 'selected' : '' }}>{{ $classroom->nom }}</option>
                                @endforeach
                            </select>
                            @error('classroom_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.children.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white mr-4">Annuler</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
