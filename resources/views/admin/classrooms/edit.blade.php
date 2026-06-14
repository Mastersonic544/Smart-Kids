<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Modifier la classe « {{ $classroom->nom }} »</h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card-premium p-6 sm:p-8">
                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 text-sm">
                        <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.classrooms.update', $classroom) }}" class="space-y-5">
                    @csrf @method('PUT')

                    <div>
                        <label for="nom" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Nom de la classe <span class="text-rose-500">*</span></label>
                        <input id="nom" name="nom" type="text" required value="{{ old('nom', $classroom->nom) }}"
                               class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 py-3">
                    </div>

                    <div>
                        <label for="niveau" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Niveau <span class="text-rose-500">*</span></label>
                        <input id="niveau" name="niveau" type="text" required value="{{ old('niveau', $classroom->niveau) }}"
                               class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 py-3">
                    </div>

                    <div>
                        <label for="capacite" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Capacité <span class="text-rose-500">*</span></label>
                        <input id="capacite" name="capacite" type="number" min="1" max="100" required value="{{ old('capacite', $classroom->capacite) }}"
                               class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 py-3">
                    </div>

                    <div>
                        <label for="educator_id" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Éducateur principal</label>
                        <select id="educator_id" name="educator_id" class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 py-3">
                            <option value="">— Aucun —</option>
                            @foreach($teachers as $t)
                                <option value="{{ $t->id }}" @selected(old('educator_id', $classroom->educator_id) == $t->id)>{{ $t->prenom }} {{ $t->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-2 border-t border-slate-100 dark:border-slate-700">
                        <a href="{{ route('admin.classrooms.index') }}" class="px-5 py-3 rounded-lg bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-semibold text-center">Annuler</a>
                        <button type="submit" class="px-5 py-3 rounded-lg bg-teal-600 hover:bg-teal-700 text-white font-bold shadow-md">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
