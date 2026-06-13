<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dossier d'Inscription - SmartKids</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #0d9488; padding-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #0d9488; }
        .title { font-size: 20px; font-weight: bold; margin-top: 10px; color: #1e293b; }
        .section-title { font-size: 16px; font-weight: bold; color: #0f766e; margin-top: 30px; margin-bottom: 10px; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; }
        .details-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .details-table th, .details-table td { padding: 8px; text-align: left; border-bottom: 1px dashed #e2e8f0; }
        .details-table th { width: 40%; color: #64748b; font-weight: normal; }
        .status-box { background-color: #f8fafc; border: 1px solid #cbd5e1; padding: 15px; text-align: center; margin-top: 20px; border-radius: 8px; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">SmartKids Maternelle</div>
        <div class="title">DOSSIER D'INSCRIPTION</div>
        <div>Date d'édition: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
    </div>

    <div class="status-box">
        Statut de la demande : <strong>{{ strtoupper($enrollment->statut) }}</strong><br>
        Date de la demande : {{ \Carbon\Carbon::parse($enrollment->created_at)->format('d/m/Y') }}
    </div>

    <div class="section-title">Informations de l'Enfant</div>
    <table class="details-table">
        <tr>
            <th>Nom complet</th>
            <td><strong>{{ $enrollment->child->prenom }} {{ $enrollment->child->nom }}</strong></td>
        </tr>
        <tr>
            <th>Date de naissance</th>
            <td>{{ \Carbon\Carbon::parse($enrollment->child->date_naissance)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <th>Allergies / Précautions</th>
            <td>{{ $enrollment->child->allergies ?: 'Aucune allergie signalée' }}</td>
        </tr>
        <tr>
            <th>Classe assignée</th>
            <td>{{ $enrollment->child->classroom->nom ?? 'En attente d\'affectation' }}</td>
        </tr>
    </table>

    <div class="section-title">Informations du Parent / Tuteur</div>
    <table class="details-table">
        <tr>
            <th>Nom complet</th>
            <td>{{ $enrollment->child->parent->name ?? '--' }}</td>
        </tr>
        <tr>
            <th>Email de contact</th>
            <td>{{ $enrollment->child->parent->email ?? '--' }}</td>
        </tr>
    </table>

    <div class="section-title">Pièces au dossier</div>
    @if($enrollment->documents_soumis && count($enrollment->documents_soumis) > 0)
        <ul>
            @foreach($enrollment->documents_soumis as $doc => $path)
                <li>{{ ucfirst(str_replace('_', ' ', $doc)) }} : <span style="color: #0d9488;">Fourni</span></li>
            @endforeach
        </ul>
    @else
        <p>Aucun document numérique enregistré dans ce dossier.</p>
    @endif

    <div class="footer">
        Document interne généré par le système d'inscription en ligne SmartKids.<br>
        Administration: admin@smartkids.tn
    </div>
</body>
</html>
