{{-- View: admin.children.show | Role: admin | Module: Children --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Détails de l\'Enfant') }}: {{ $child->prenom }} {{ $child->nom }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Informations Personnelles</h3>
                            <p><strong>Nom:</strong> {{ $child->nom }}</p>
                            <p><strong>Prénom:</strong> {{ $child->prenom }}</p>
                            <p><strong>Date de Naissance:</strong> {{ $child->date_naissance }}</p>
                            <p><strong>Allergies:</strong> {{ $child->allergies ?: 'Aucune allergie signalée' }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold mb-2">Scolarité et Contact</h3>
                            <p><strong>Parent:</strong> {{ $child->parent->name ?? 'N/A' }} ({{ $child->parent->email ?? '' }})</p>
                            <p><strong>Classe:</strong> {{ $child->classroom->nom ?? 'Non assigné' }}</p>
                            <p><strong>Inscrit le:</strong> {{ $child->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('admin.children.edit', $child->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Modifier</a>
                        <a href="{{ route('admin.children.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Retour à la liste</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
