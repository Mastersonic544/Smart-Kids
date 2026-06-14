<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Paiements des familles</h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            @if(session('success'))
                <div class="rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3 text-sm">{{ session('success') }}</div>
            @endif

            @if($payments->isEmpty())
                <div class="card-premium p-8 sm:p-12 text-center">
                    <p class="text-slate-500">Aucun paiement enregistré pour le moment.</p>
                </div>
            @else
                <div class="card-premium overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                            <thead class="bg-slate-50 dark:bg-slate-800">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-600 dark:text-slate-300">Enfant</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-600 dark:text-slate-300">Mois</th>
                                    <th class="px-4 py-3 text-right font-semibold text-slate-600 dark:text-slate-300">Montant</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-600 dark:text-slate-300">Échéance</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-600 dark:text-slate-300">Statut</th>
                                    <th class="px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach($payments as $p)
                                    <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40">
                                        <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-100">
                                            {{ $p->child?->prenom }} {{ $p->child?->nom }}
                                        </td>
                                        <td class="px-4 py-3 text-slate-500">{{ $p->mois ?? '—' }}</td>
                                        <td class="px-4 py-3 text-right font-bold">{{ number_format($p->montant, 0, ',', ' ') }} TND</td>
                                        <td class="px-4 py-3 text-slate-500">{{ $p->date_echeance?->format('d M Y') ?? '—' }}</td>
                                        <td class="px-4 py-3">
                                            @php($isPaid = $p->statut === 'payé')
                                            @php($isOverdue = ! $isPaid && $p->date_echeance && $p->date_echeance->isPast())
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                                {{ $isPaid ? 'bg-teal-100 text-teal-700' : ($isOverdue ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                                                {{ $isPaid ? 'Payé' : ($isOverdue ? 'En retard' : 'En attente') }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <a href="{{ route('admin.payments.edit', $p) }}" class="text-teal-600 hover:text-teal-800 text-sm font-semibold">Modifier</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-t border-slate-100 dark:border-slate-700">
                        {{ $payments->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
