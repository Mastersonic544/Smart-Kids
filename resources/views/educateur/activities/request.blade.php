<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Nouvelle demande d'activité</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="card-premium p-6">
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">
                    Proposez une activité pour vos élèves. Elle restera <strong>en attente d'approbation</strong>
                    par l'administration avant d'être visible aux parents.
                </p>

                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('educateur.activities.requestSubmit') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Nom de l'activité *</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required
                               class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 focus:ring-teal-500 focus:border-teal-500">
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Description</label>
                        <textarea id="description" name="description" rows="3"
                                  class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 focus:ring-teal-500 focus:border-teal-500">{{ old('description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="scheduled_date" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Date prévue *</label>
                            <input id="scheduled_date" name="scheduled_date" type="date" value="{{ old('scheduled_date') }}" required
                                   class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 focus:ring-teal-500 focus:border-teal-500">
                        </div>

                        <div>
                            <label for="scheduled_time" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Heure *</label>
                            <input id="scheduled_time" name="scheduled_time" type="time" value="{{ old('scheduled_time') }}" required
                                   class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 focus:ring-teal-500 focus:border-teal-500">
                        </div>
                    </div>

                    <div>
                        <label for="max_participants" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1">Nombre maximum de participants</label>
                        <input id="max_participants" name="max_participants" type="number" min="1" max="200" value="{{ old('max_participants', 30) }}"
                               class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 focus:ring-teal-500 focus:border-teal-500">
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-2">
                        <a href="{{ route('educateur.activities') }}" class="px-5 py-2.5 rounded-lg bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-semibold hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors text-center">
                            Annuler
                        </a>
                        <button type="submit" class="px-5 py-2.5 rounded-lg bg-teal-600 hover:bg-teal-700 text-white font-bold shadow-md transition-colors">
                            Envoyer la demande
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
