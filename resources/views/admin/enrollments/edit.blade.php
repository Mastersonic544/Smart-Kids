<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Traiter une inscription</h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card-premium p-6 sm:p-8">
                <div class="mb-6 rounded-lg bg-slate-50 dark:bg-slate-700/50 px-4 py-3 text-sm">
                    <p class="text-slate-500">Enfant : <strong class="text-slate-800 dark:text-white">{{ $enrollment->child?->prenom }} {{ $enrollment->child?->nom }}</strong></p>
                    <p class="text-slate-500">Reçue le {{ $enrollment->created_at->format('d M Y') }}</p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 text-sm">
                        <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.enrollments.update', $enrollment) }}" class="space-y-5">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">Décision</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            @foreach(['en attente' => ['amber','En attente'], 'approuvé' => ['teal','Approuver'], 'rejeté' => ['rose','Refuser']] as $val => [$color, $label])
                                <label class="flex items-center justify-center gap-2 p-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 cursor-pointer has-[input:checked]:border-{{ $color }}-500 has-[input:checked]:bg-{{ $color }}-50 dark:has-[input:checked]:bg-{{ $color }}-900/20">
                                    <input type="radio" name="statut" value="{{ $val }}" @checked(old('statut', $enrollment->statut) === $val) class="text-{{ $color }}-600 focus:ring-{{ $color }}-500">
                                    <span class="font-bold text-slate-800 dark:text-white text-sm">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-1.5">Notes internes</label>
                        <textarea id="notes" name="notes" rows="3" placeholder="Optionnel — visible uniquement par l'administration."
                                  class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 py-3">{{ old('notes', $enrollment->notes) }}</textarea>
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-2 border-t border-slate-100 dark:border-slate-700">
                        <a href="{{ route('admin.enrollments.index') }}" class="px-5 py-3 rounded-lg bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-semibold text-center">Annuler</a>
                        <button type="submit" class="px-5 py-3 rounded-lg bg-teal-600 hover:bg-teal-700 text-white font-bold shadow-md">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
