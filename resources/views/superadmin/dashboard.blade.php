<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Console SuperAdmin SmartKids</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Welcome card --}}
            <div class="card-premium p-6 bg-gradient-to-r from-slate-900 to-indigo-900 text-white">
                <h3 class="text-2xl font-bold">Tableau de bord SaaS</h3>
                <p class="text-slate-300 mt-1">Vue d'ensemble du parc SmartKids : kindergartens, utilisateurs, revenus.</p>
            </div>

            {{-- Top stats --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="card-premium p-5">
                    <p class="text-xs text-slate-400 uppercase tracking-wider">Kindergartens actifs</p>
                    <p class="text-3xl font-bold text-teal-600 mt-1">{{ $activeAdminsCount }}</p>
                </div>
                <div class="card-premium p-5">
                    <p class="text-xs text-slate-400 uppercase tracking-wider">Gelés</p>
                    <p class="text-3xl font-bold text-rose-600 mt-1">{{ $frozenAdminsCount }}</p>
                </div>
                <div class="card-premium p-5">
                    <p class="text-xs text-slate-400 uppercase tracking-wider">MRR estimé</p>
                    <p class="text-3xl font-bold text-indigo-600 mt-1">{{ number_format($mrrEstimate, 0, ',', ' ') }} <span class="text-base">TND</span></p>
                </div>
                <div class="card-premium p-5">
                    <p class="text-xs text-slate-400 uppercase tracking-wider">Revenu cumulé</p>
                    <p class="text-3xl font-bold text-emerald-600 mt-1">{{ number_format($totalRevenue, 0, ',', ' ') }} <span class="text-base">TND</span></p>
                </div>
            </div>

            {{-- User counts chart --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="card-premium p-6 lg:col-span-2">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Utilisateurs par rôle</h3>
                    <canvas id="userRolesChart" height="120"></canvas>
                </div>
                <div class="card-premium p-6">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Plan {{ $plan['name'] }}</h3>
                    <ul class="space-y-2 text-sm text-slate-600 dark:text-slate-300">
                        <li><strong>Mensuel :</strong> {{ number_format($plan['monthly_price'], 3, ',', ' ') }} TND</li>
                        <li><strong>Annuel :</strong> {{ number_format($plan['annual_price'], 3, ',', ' ') }} TND <span class="text-emerald-600 font-semibold">(-{{ (int) $plan['annual_discount'] }}%)</span></li>
                    </ul>
                    <a href="{{ route('superadmin.admins.create') }}" class="mt-4 block w-full text-center py-2 rounded-lg bg-teal-600 hover:bg-teal-700 text-white font-bold transition-colors">+ Nouveau kindergarten</a>
                </div>
            </div>

            {{-- Top kindergartens table --}}
            <div class="card-premium p-6">
                <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Top 10 kindergartens</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                        <thead class="bg-slate-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-4 py-2 text-left font-semibold text-slate-600 dark:text-slate-300">Établissement</th>
                                <th class="px-4 py-2 text-right font-semibold text-slate-600 dark:text-slate-300">Tarif mensuel</th>
                                <th class="px-4 py-2 text-right font-semibold text-slate-600 dark:text-slate-300">Parents</th>
                                <th class="px-4 py-2 text-right font-semibold text-slate-600 dark:text-slate-300">Éducateurs</th>
                                <th class="px-4 py-2 text-left font-semibold text-slate-600 dark:text-slate-300">Statut</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($topKindergartens as $k)
                                <tr>
                                    <td class="px-4 py-2 font-medium text-slate-800 dark:text-slate-100">{{ $k->name }}</td>
                                    <td class="px-4 py-2 text-right text-slate-600 dark:text-slate-400">{{ $k->monthly_tuition_tnd ? number_format($k->monthly_tuition_tnd, 0, ',', ' ').' TND' : '—' }}</td>
                                    <td class="px-4 py-2 text-right font-semibold">{{ $k->parents_count }}</td>
                                    <td class="px-4 py-2 text-right font-semibold">{{ $k->educators_count }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                            {{ $k->subscription_status === 'frozen' ? 'bg-rose-100 text-rose-700' : 'bg-teal-100 text-teal-700' }}">
                                            {{ $k->subscription_status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-4 py-6 text-center text-slate-400">Aucun kindergarten enregistré.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('userRolesChart')?.getContext('2d');
            if (!ctx) return;
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['SuperAdmin', 'Admins', 'Éducateurs', 'Parents'],
                    datasets: [{
                        data: [
                            {{ $userCounts['superadmin'] }},
                            {{ $userCounts['admin'] }},
                            {{ $userCounts['educateur'] }},
                            {{ $userCounts['parent'] }},
                        ],
                        backgroundColor: ['#0f172a', '#0d9488', '#6366f1', '#f59e0b'],
                        borderRadius: 8,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, precision: 0 } }
                }
            });
        });
    </script>
</x-app-layout>
