{{-- View: admin.teachers.edit | Role: admin | Module: Teachers --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier un Enseignant') }}: {{ $teacher->prenom }} {{ $teacher->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('admin.teachers.update', $teacher->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nom -->
                        <div class="mb-4">
                            <label for="nom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom</label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom', $teacher->nom) }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-black dark:text-gray-300" required>
                            @error('nom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Prénom -->
                        <div class="mb-4">
                            <label for="prenom" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prénom</label>
                            <input type="text" name="prenom" id="prenom" value="{{ old('prenom', $teacher->prenom) }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-black dark:text-gray-300" required>
                            @error('prenom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $teacher->email) }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-black dark:text-gray-300" required>
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Téléphone -->
                        <div class="mb-4">
                            <label for="telephone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Téléphone (Optionnel)</label>
                            <input type="text" name="telephone" id="telephone" value="{{ old('telephone', $teacher->telephone) }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-black dark:text-gray-300">
                            @error('telephone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Document Contractuel -->
                        <div class="mb-4">
                            <label for="document_contractuel" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Document Contractuel (Optionnel)</label>
                            <input type="text" name="document_contractuel" id="document_contractuel" value="{{ old('document_contractuel', $teacher->document_contractuel) }}" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-black dark:text-gray-300">
                            @error('document_contractuel') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.teachers.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white mr-4">Annuler</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
