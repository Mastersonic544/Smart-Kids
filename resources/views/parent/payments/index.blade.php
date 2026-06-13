{{-- View: parent.payments.index | Role: parent | Module: Payments --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Historique des Paiements</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if(session('success'))
                <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-700 dark:text-emerald-400 font-medium">
                    <svg class="w-5 h-5 inline text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> {{ session('success') }}
                </div>
            @endif

            @forelse($paymentsByChild as $childId => $data)
                <div class="card-premium overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-slate-700 to-slate-800">
                        <h3 class="font-bold text-lg text-white flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg> {{ $data['child']->prenom }} {{ $data['child']->nom }}</h3>
                    </div>
                    <div class="p-0">
                        @if($data['payments']->isEmpty())
                            <p class="p-6 text-slate-500 text-center">Aucun historique de paiement trouvé.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                                    <thead class="bg-slate-50 dark:bg-slate-700/50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Montant</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Statut</th>
                                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-100 dark:divide-slate-700">
                                        @foreach($data['payments'] as $payment)
                                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300">{{ $payment->created_at->format('d/m/Y') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap font-bold text-slate-800 dark:text-white">{{ $payment->montant }} DT</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($payment->statut === 'payé')
                                                        <span class="badge badge-success flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Payé</span>
                                                    @else
                                                        <span class="badge badge-danger flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> En Attente</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($payment->statut !== 'payé')
                                                        <form method="POST" action="{{ route('parent.payments.pay', $payment) }}" onsubmit="return confirm('Confirmer le paiement de {{ $payment->montant }} DT ?')">
                                                            @csrf
                                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-teal-600 text-white text-xs font-bold rounded-lg hover:bg-teal-700 shadow-md transition-all gap-1">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg> Payer maintenant
                                                            </button>
                                                        </form>
                                                    @elseif($payment->pdf_path)
                                                        <a href="{{ $payment->pdf_path }}" target="_blank" class="text-teal-600 hover:text-teal-700 font-medium text-sm underline flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg> Télécharger reçu</a>
                                                    @else
                                                        <span class="text-slate-400 text-sm">—</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="card-premium p-8 text-center">
                    <p class="text-slate-500">Aucun enfant lié. Impossible d'afficher l'historique des paiements.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
