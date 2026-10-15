
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un candidat - JobPilot</title>
</head>
<body>
    <h1>Ajouter un candidat</h1>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('candidate.store') }}" method="POST">
        @csrf

        <div>
            <label for="prenom">Prénom</label>
            <input
                type="text"
                id="prenom"
                name="prenom"
                value="{{ old('prenom') }}"
                required
            >
        </div>

        <div>
            <label for="nom">Nom</label>
            <input
                type="text"
                id="nom"
                name="nom"
                value="{{ old('nom') }}"
                required
            >
        </div>

        <button type="submit">Enregistrer</button>
    </form>

    <a href="{{ route('candidate.index') }}">Retour à la liste</a>
</body>
</html>
