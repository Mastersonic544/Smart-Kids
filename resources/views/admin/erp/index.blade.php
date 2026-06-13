<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h2 class="font-bold text-xl text-slate-800 dark:text-white">ERP — Suivi des paiements et performances</h2>
            <a href="{{ route('admin.erp.exportPdf') }}" class="px-4 py-2 rounded-lg bg-slate-800 hover:bg-slate-900 text-white font-semibold text-sm">📄 Exporter en PDF</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Ledger summary --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="card-premium p-5">
                    <p class="text-xs text-slate-400 uppercase tracking-wider">Encaissé</p>
                    <p class="text-3xl font-bold text-teal-600 mt-1">{{ number_format($ledger['paid'], 0, ',', ' ') }} <span class="text-base">TND</span></p>
                </div>
                <div class="card-premium p-5">
                    <p class="text-xs text-slate-400 uppercase tracking-wider">En attente</p>
                    <p class="text-3xl font-bold text-amber-600 mt-1">{{ number_format($ledger['outstanding'], 0, ',', ' ') }} <span class="text-base">TND</span></p>
                </div>
                <div class="card-premium p-5">
                    <p class="text-xs text-slate-400 uppercase tracking-wider">Taux de recouvrement</p>
                    <p class="text-3xl font-bold text-indigo-600 mt-1">{{ $ledger['collection_rate'] }}%</p>
                </div>
                <div class="card-premium p-5">
                    <p class="text-xs text-slate-400 uppercase tracking-wider">En retard</p>
                    <p class="text-3xl font-bold text-rose-600 mt-1">{{ $ledger['overdue_count'] }}</p>
                </div>
            </div>

            {{-- Charts --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="card-premium p-6">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Revenus mensuels (6 mois)</h3>
                    <canvas id="revenueChart" height="160"></canvas>
                </div>
                <div class="card-premium p-6">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Revenu par classe</h3>
                    <canvas id="classroomChart" height="160"></canvas>
                </div>
            </div>

            {{-- Employee of the month --}}
            @if($employeeOfMonth)
                @php($winner = $employeeOfMonth['winner'])
                <div class="card-premium overflow-hidden">
                    <div class="px-6 py-5 bg-gradient-to-r from-amber-500 to-orange-500 text-white">
                        <p class="text-amber-100 text-sm uppercase tracking-wider font-semibold">🏆 Éducateur du mois</p>
                        <h3 class="text-2xl font-bold mt-1">{{ $winner['educator']->name }}</h3>
                        <p class="text-amber-100 text-sm">{{ $winner['activities'] }} activité(s) menée(s) • {{ $winner['work_hours'] }} pts de présence • score {{ $winner['score'] }}</p>
                    </div>
                    <div class="p-6">
                        <h4 class="font-semibold text-slate-700 dark:text-slate-300 mb-3">Classement du mois</h4>
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                            <thead>
                                <tr class="text-slate-500">
                                    <th class="px-3 py-2 text-left">Éducateur</th>
                                    <th class="px-3 py-2 text-right">Activités</th>
                                    <th class="px-3 py-2 text-right">Présence</th>
                                    <th class="px-3 py-2 text-right">Score</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach($employeeOfMonth['leaderboard'] as $row)
                                    <tr>
                                        <td class="px-3 py-2 font-medium">{{ $row['educator']->name }}</td>
                                        <td class="px-3 py-2 text-right">{{ $row['activities'] }}</td>
                                        <td class="px-3 py-2 text-right">{{ $row['work_hours'] }}</td>
                                        <td class="px-3 py-2 text-right font-bold">{{ $row['score'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Per-classroom revenue table --}}
            <div class="card-premium p-6">
                <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Détail par classe</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                        <thead class="bg-slate-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-4 py-2 text-left font-semibold">Classe</th>
                                <th class="px-4 py-2 text-right font-semibold">Enfants</th>
                                <th class="px-4 py-2 text-right font-semibold">Encaissé</th>
                                <th class="px-4 py-2 text-right font-semibold">En attente</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($revenueByClassroom as $row)
                                <tr>
                                    <td class="px-4 py-2 font-medium">{{ $row['classroom'] }}</td>
                                    <td class="px-4 py-2 text-right">{{ $row['children_count'] }}</td>
                                    <td class="px-4 py-2 text-right text-teal-600 font-semibold">{{ number_format($row['revenue'], 0, ',', ' ') }} TND</td>
                                    <td class="px-4 py-2 text-right text-amber-600">{{ number_format($row['outstanding'], 0, ',', ' ') }} TND</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-6 text-center text-slate-400">Aucune donnée.</td></tr>
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
            const monthlyData = @json($monthlyRevenue);
            new Chart(document.getElementById('revenueChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: monthlyData.map(p => p.label),
                    datasets: [{
                        label: 'Encaissé (TND)',
                        data: monthlyData.map(p => p.revenue),
                        borderColor: '#0d9488',
                        backgroundColor: 'rgba(13, 148, 136, 0.15)',
                        fill: true,
                        tension: 0.35,
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
            });

            const classroomData = @json($revenueByClassroom);
            new Chart(document.getElementById('classroomChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: classroomData.map(c => c.classroom),
                    datasets: [{
                        data: classroomData.map(c => c.revenue),
                        backgroundColor: ['#0d9488', '#6366f1', '#f59e0b', '#ef4444', '#10b981', '#a855f7']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        });
    </script>
</x-app-layout>
