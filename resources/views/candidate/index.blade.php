<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des candidats - JobPilot</title>
</head>
<body>
    <h1>Liste des candidats</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @forelse ($candidates as $candidate)
        <div>
            <strong>{{ $candidate->firstname }} {{ $candidate->lastname }}</strong>
        </div>
    @empty
        <p>Aucun candidat trouvé.</p>
    @endforelse
</body>
</html>
