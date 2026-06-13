{{-- View: admin.activities.edit | Role: admin | Module: Activities --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Modifier l\'Activité') }}: {{ $activity->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('admin.activities.update', $activity->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium">Nom de l'activité</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $activity->name) }}" class="mt-1 block w-full rounded-md dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-black dark:text-white" required>
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium">Description</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-black dark:text-white">{{ old('description', $activity->description) }}</textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="scheduled_date" class="block text-sm font-medium">Date</label>
                                <input type="date" name="scheduled_date" id="scheduled_date" value="{{ old('scheduled_date', $activity->scheduled_date) }}" class="mt-1 block w-full rounded-md dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-black dark:text-white" required>
                                @error('scheduled_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="scheduled_time" class="block text-sm font-medium">Heure</label>
                                <input type="time" name="scheduled_time" id="scheduled_time" value="{{ old('scheduled_time', \Carbon\Carbon::parse($activity->scheduled_time)->format('H:i')) }}" class="mt-1 block w-full rounded-md dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-black dark:text-white" required>
                                @error('scheduled_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="educator_id" class="block text-sm font-medium">Éducateur</label>
                                <select name="educator_id" id="educator_id" class="mt-1 block w-full rounded-md dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-black dark:text-white" required>
                                    <option value="">-- Sélectionner --</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ old('educator_id', $activity->educator_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->nom }} {{ $teacher->prenom }}</option>
                                    @endforeach
                                </select>
                                @error('educator_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label for="max_participants" class="block text-sm font-medium">Max Participants</label>
                                <input type="number" name="max_participants" id="max_participants" value="{{ old('max_participants', $activity->max_participants) }}" class="mt-1 block w-full rounded-md dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-black dark:text-white" required>
                                @error('max_participants') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.activities.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline mr-4">Annuler</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
