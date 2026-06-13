<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Abonnement SmartKids Pro</h2>
    </x-slot>

    <div class="py-8" x-data="{ period: '{{ $admin->billing_period ?? 'monthly' }}' }">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="rounded-lg bg-green-100 border border-green-400 text-green-700 px-4 py-3">{{ session('success') }}</div>
            @endif

            {{-- Plan card --}}
            <div class="card-premium overflow-hidden">
                <div class="px-6 py-5 bg-gradient-to-r from-teal-600 to-cyan-600 text-white">
                    <h3 class="text-2xl font-bold">{{ $plan['name'] }}</h3>
                    <p class="text-teal-100 text-sm mt-1">Plan unique avec toutes les fonctionnalités SmartKids.</p>
                </div>
                <div class="p-6 space-y-5">
                    {{-- Toggle --}}
                    <div class="inline-flex items-center bg-slate-100 dark:bg-slate-700 rounded-full p-1">
                        <button type="button" @click="period = 'monthly'"
                                :class="period === 'monthly' ? 'bg-white dark:bg-slate-900 shadow text-slate-800 dark:text-white' : 'text-slate-500'"
                                class="px-4 py-1.5 rounded-full text-sm font-semibold transition">Mensuel</button>
                        <button type="button" @click="period = 'annual'"
                                :class="period === 'annual' ? 'bg-white dark:bg-slate-900 shadow text-slate-800 dark:text-white' : 'text-slate-500'"
                                class="px-4 py-1.5 rounded-full text-sm font-semibold transition">Annuel <span class="text-emerald-600 font-bold">-{{ (int) $plan['annual_discount'] }}%</span></button>
                    </div>

                    {{-- Price --}}
                    <div>
                        <p class="text-5xl font-bold text-slate-800 dark:text-white"
                           x-text="period === 'monthly' ? '{{ number_format($plan['monthly_price'], 0, ',', ' ') }}' : '{{ number_format($plan['annual_price'], 0, ',', ' ') }}'">
                        </p>
                        <p class="text-slate-500 text-sm"
                           x-text="period === 'monthly' ? 'TND / mois' : 'TND / an (équivalent {{ number_format($plan['annual_price'] / 12, 0, ',', ' ') }} TND/mois)'">
                        </p>
                    </div>

                    {{-- Status --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                        <div class="rounded-lg bg-slate-50 dark:bg-slate-700/50 p-3">
                            <p class="text-xs text-slate-400 uppercase">Statut</p>
                            <p class="font-bold mt-1
                                {{ $admin->subscription_status === 'frozen' ? 'text-rose-600' : ($admin->subscription_status === 'grace' ? 'text-amber-600' : 'text-teal-600') }}">
                                {{ $admin->subscription_status }}
                            </p>
                        </div>
                        <div class="rounded-lg bg-slate-50 dark:bg-slate-700/50 p-3">
                            <p class="text-xs text-slate-400 uppercase">Prochaine échéance</p>
                            <p class="font-bold mt-1">{{ $admin->subscription_due_at?->format('d M Y') ?? '—' }}</p>
                        </div>
                        <div class="rounded-lg bg-slate-50 dark:bg-slate-700/50 p-3">
                            <p class="text-xs text-slate-400 uppercase">Cycle</p>
                            <p class="font-bold mt-1">{{ $admin->billing_period ?? '—' }}</p>
                        </div>
                    </div>

                    {{-- Pay button --}}
                    <form method="POST" action="{{ route('admin.subscription.pay') }}">
                        @csrf
                        <input type="hidden" name="billing_period" :value="period">
                        <button type="submit" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold shadow-lg shadow-teal-200 transition-colors">
                            Régler maintenant
                        </button>
                    </form>
                    <p class="text-xs text-slate-400">Paiement simulé — aucun prélèvement réel n'est effectué. La date d'échéance est prolongée immédiatement.</p>
                </div>
            </div>

            {{-- Receipts --}}
            <div class="card-premium p-6">
                <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Historique des reçus SaaS</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                        <thead class="bg-slate-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-4 py-2 text-left font-semibold">Date</th>
                                <th class="px-4 py-2 text-left font-semibold">Cycle</th>
                                <th class="px-4 py-2 text-right font-semibold">Montant</th>
                                <th class="px-4 py-2 text-left font-semibold">Période</th>
                                <th class="px-4 py-2 text-left font-semibold">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($receipts as $r)
                                <tr>
                                    <td class="px-4 py-2">{{ $r->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-2">{{ $r->period }}</td>
                                    <td class="px-4 py-2 text-right font-semibold">{{ number_format($r->amount_tnd, 3, ',', ' ') }} TND</td>
                                    <td class="px-4 py-2">{{ $r->period_start->format('d M') }} → {{ $r->period_end->format('d M Y') }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                            {{ $r->status === 'paid' ? 'bg-teal-100 text-teal-700' : ($r->status === 'overdue' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                                            {{ $r->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-4 py-6 text-center text-slate-400">Aucun paiement enregistré.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
