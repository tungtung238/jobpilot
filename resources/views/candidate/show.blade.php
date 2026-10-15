
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du candidat - JobPilot</title>
</head>
<body>
    <h1>Détail du candidat</h1>

    <p><strong>Prénom :</strong> {{ $candidate->firstname }}</p>
    <p><strong>Nom :</strong> {{ $candidate->lastname }}</p>
    <p><strong>ID :</strong> {{ $candidate->id }}</p>

    <a href="{{ route('candidate.index') }}">Retour à la liste</a>

    @if (Auth::user()->role === 'admin')
        <a href="{{ route('candidate.edit', $candidate) }}">Modifier</a>
    @endif
</body>
</html>

