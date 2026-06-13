{{-- View: admin.activities.show | Role: admin | Module: Activities --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Détails de l\'Activité') }}: {{ $activity->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Info and Report -->
            <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-2">Informations</h3>
                    <p><strong>Date et Heure:</strong> {{ $activity->scheduled_date }} à {{ \Carbon\Carbon::parse($activity->scheduled_time)->format('H:i') }}</p>
                    <p><strong>Éducateur:</strong> {{ $activity->educator->nom ?? 'N/A' }}</p>
                    <p><strong>Max Participants:</strong> {{ $activity->max_participants }}</p>
                    <p class="mt-2 text-sm">{{ $activity->description }}</p>
                </div>
                <div class="text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 p-4 rounded">
                    <h3 class="text-lg font-bold mb-2">Rapport de Présence</h3>
                    <p><strong>Enfants Inscrits:</strong> {{ $report['total_enrolled'] }} / {{ $activity->max_participants }}</p>
                    <p><strong>Présents:</strong> {{ $report['attended'] }}</p>
                    <p><strong>Taux de Présence:</strong> {{ $report['attendance_rate'] }}%</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Enrollment Form -->
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Inscrire un Enfant</h3>
                    <form action="{{ route('admin.activities.enroll', $activity->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sélectionner l'enfant</label>
                            <select name="child_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 text-black dark:text-gray-300" required>
                                <option value="">-- Choisir --</option>
                                @foreach($allChildren as $child)
                                    <option value="{{ $child->id }}">{{ $child->nom }} {{ $child->prenom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Inscrire
                        </button>
                    </form>
                </div>

                <!-- Attendance Checklist -->
                <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Marquer les Présences</h3>
                    <form action="{{ route('admin.activities.attendance', $activity->id) }}" method="POST">
                        @csrf
                        <div class="space-y-4 max-h-60 overflow-y-auto">
                            @forelse($activity->children as $child)
                                <div class="flex items-center">
                                    <input type="checkbox" name="attended_children[]" value="{{ $child->id }}" 
                                        {{ $child->pivot->attended ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <label class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                                        {{ $child->nom }} {{ $child->prenom }}
                                    </label>
                                </div>
                            @empty
                                <p class="text-gray-500">Aucun enfant n'est inscrit à cette activité.</p>
                            @endforelse
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Sauvegarder les présences
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
