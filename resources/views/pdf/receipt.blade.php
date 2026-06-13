<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reçu de Paiement - SmartKids</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #0d9488; padding-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #0d9488; }
        .title { font-size: 20px; font-weight: bold; margin-top: 10px; color: #1e293b; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .details-table th, .details-table td { padding: 10px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .details-table th { width: 40%; color: #64748b; font-weight: normal; }
        .amount-box { background-color: #f0fdfa; border: 1px solid #0d9488; padding: 20px; text-align: center; margin-top: 20px; border-radius: 8px; }
        .amount { font-size: 24px; font-weight: bold; color: #0d9488; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">SmartKids Maternelle</div>
        <div class="title">REÇU DE PAIEMENT</div>
        <div>Date d'émission: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
    </div>

    <table class="details-table">
        <tr>
            <th>Reçu N°</th>
            <td>#{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <th>Date du paiement</th>
            <td>{{ $payment->paye_le ? \Carbon\Carbon::parse($payment->paye_le)->format('d/m/Y H:i') : \Carbon\Carbon::parse($payment->updated_at)->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <th>Élève</th>
            <td>{{ $payment->child->prenom }} {{ $payment->child->nom }}</td>
        </tr>
        <tr>
            <th>Parent</th>
            <td>{{ $payment->child->parent->name ?? 'N/A' }}</td>
        </tr>
        @if($payment->mois)
        <tr>
            <th>Mois concerné</th>
            <td>{{ $payment->mois }}</td>
        </tr>
        @endif
    </table>

    <div class="amount-box">
        <div style="font-size: 14px; color: #0f766e; margin-bottom: 5px;">Montant Total Payé</div>
        <div class="amount">{{ number_format($payment->montant, 3, ',', ' ') }} TND</div>
    </div>

    <div class="footer">
        Ceci est un document généré électroniquement. Ce reçu confirme que le paiement a bien été reçu et traité par l'administration de SmartKids.<br>
        SmartKids Maternelle — 123 Avenue de l'Éducation, Tunis, Tunisie — Tél: +216 71 000 000
    </div>
</body>
</html>
