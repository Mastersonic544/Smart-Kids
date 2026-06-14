<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Mettre à jour un paiement</h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="card-premium p-6 sm:p-8">
                <div class="mb-6 rounded-lg bg-slate-50 dark:bg-slate-700/50 px-4 py-3 text-sm">
                    <p class="text-slate-500">Enfant : <strong class="text-slate-800 dark:text-white">{{ $payment->child?->prenom }} {{ $payment->child?->nom }}</strong></p>
                    <p class="text-slate-500">Mois : {{ $payment->mois ?? '—' }} • Montant : <strong>{{ number_format($payment->montant, 0, ',', ' ') }} TND</strong></p>
                    @if($payment->date_echeance)
                        <p class="text-slate-500">Échéance : {{ $payment->date_echeance->translatedFormat('d F Y') }}</p>
                    @endif
                </div>

                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 text-sm">
                        <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.payments.update', $payment) }}" class="space-y-5">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-3">Statut du paiement</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center gap-3 p-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 cursor-pointer has-[input:checked]:border-amber-500 has-[input:checked]:bg-amber-50 dark:has-[input:checked]:bg-amber-900/20">
                                <input type="radio" name="statut" value="en attente" @checked(old('statut', $payment->statut) === 'en attente') class="text-amber-600 focus:ring-amber-500">
                                <div>
                                    <p class="font-bold text-slate-800 dark:text-white">En attente</p>
                                    <p class="text-xs text-slate-500">Non encore réglé</p>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 p-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 cursor-pointer has-[input:checked]:border-teal-500 has-[input:checked]:bg-teal-50 dark:has-[input:checked]:bg-teal-900/20">
                                <input type="radio" name="statut" value="payé" @checked(old('statut', $payment->statut) === 'payé') class="text-teal-600 focus:ring-teal-500">
                                <div>
                                    <p class="font-bold text-slate-800 dark:text-white">Payé</p>
                                    <p class="text-xs text-slate-500">Reçu encaissé</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-2 border-t border-slate-100 dark:border-slate-700">
                        <a href="{{ route('admin.payments.index') }}" class="px-5 py-3 rounded-lg bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-semibold text-center">Annuler</a>
                        <button type="submit" class="px-5 py-3 rounded-lg bg-teal-600 hover:bg-teal-700 text-white font-bold shadow-md">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
