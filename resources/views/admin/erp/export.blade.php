<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>SmartKids — Rapport ERP</title>
    <style>
        @page { margin: 28mm 16mm 20mm 16mm; }
        body { font-family: DejaVu Sans, sans-serif; color: #0f172a; font-size: 11px; }
        h1 { color: #0d9488; font-size: 22px; margin: 0; }
        h2 { color: #1e293b; font-size: 14px; margin-top: 22px; border-bottom: 2px solid #0d9488; padding-bottom: 4px; }
        .meta { color: #64748b; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { padding: 6px 8px; border-bottom: 1px solid #e2e8f0; }
        th { background: #f1f5f9; text-align: left; font-weight: 700; }
        td.num, th.num { text-align: right; }
        .kpis { width: 100%; margin: 8px 0 12px; }
        .kpis td { background: #f8fafc; border-radius: 6px; padding: 10px; text-align: center; border: 1px solid #e2e8f0; }
        .kpis .label { font-size: 9px; color: #64748b; text-transform: uppercase; letter-spacing: 1px; }
        .kpis .value { font-size: 18px; font-weight: 700; color: #0f172a; margin-top: 2px; }
    </style>
</head>
<body>
    <h1>SmartKids — Rapport ERP</h1>
    <p class="meta">Généré le {{ $generatedAt->translatedFormat('d F Y à H:i') }}</p>

    <h2>Indicateurs financiers</h2>
    <table class="kpis">
        <tr>
            <td><div class="label">Encaissé</div><div class="value">{{ number_format($ledger['paid'], 0, ',', ' ') }} TND</div></td>
            <td><div class="label">En attente</div><div class="value">{{ number_format($ledger['outstanding'], 0, ',', ' ') }} TND</div></td>
            <td><div class="label">Taux recouvrement</div><div class="value">{{ $ledger['collection_rate'] }}%</div></td>
            <td><div class="label">En retard</div><div class="value">{{ $ledger['overdue_count'] }}</div></td>
        </tr>
    </table>

    <h2>Revenu par classe</h2>
    <table>
        <thead>
            <tr><th>Classe</th><th class="num">Enfants</th><th class="num">Encaissé</th><th class="num">En attente</th></tr>
        </thead>
        <tbody>
            @forelse($revenueByClassroom as $row)
                <tr>
                    <td>{{ $row['classroom'] }}</td>
                    <td class="num">{{ $row['children_count'] }}</td>
                    <td class="num">{{ number_format($row['revenue'], 0, ',', ' ') }} TND</td>
                    <td class="num">{{ number_format($row['outstanding'], 0, ',', ' ') }} TND</td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center; color:#94a3b8;">Aucune donnée.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h2>Revenus des 6 derniers mois</h2>
    <table>
        <thead>
            <tr><th>Mois</th><th class="num">Encaissé</th></tr>
        </thead>
        <tbody>
            @foreach($monthlyRevenue as $row)
                <tr>
                    <td>{{ $row['label'] }}</td>
                    <td class="num">{{ number_format($row['revenue'], 0, ',', ' ') }} TND</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if($employeeOfMonth)
        @php($winner = $employeeOfMonth['winner'])
        <h2>Éducateur du mois</h2>
        <p><strong>{{ $winner['educator']->name }}</strong> — score {{ $winner['score'] }}
           ({{ $winner['activities'] }} activité(s), {{ $winner['work_hours'] }} pts présence)</p>
        <table>
            <thead><tr><th>Éducateur</th><th class="num">Activités</th><th class="num">Présence</th><th class="num">Score</th></tr></thead>
            <tbody>
                @foreach($employeeOfMonth['leaderboard'] as $row)
                    <tr>
                        <td>{{ $row['educator']->name }}</td>
                        <td class="num">{{ $row['activities'] }}</td>
                        <td class="num">{{ $row['work_hours'] }}</td>
                        <td class="num">{{ $row['score'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
