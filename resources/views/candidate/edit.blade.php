
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un candidat - JobPilot</title>
</head>
<body>
    <h1>Modifier le candidat</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('candidate.update', $candidate) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="firstname">Prénom</label>
            <input
                type="text"
                id="firstname"
                name="firstname"
                value="{{ old('firstname', $candidate->firstname) }}"
                required
            >
        </div>

        <div>
            <label for="lastname">Nom</label>
            <input
                type="text"
                id="lastname"
                name="lastname"
                value="{{ old('lastname', $candidate->lastname) }}"
                required
            >
        </div>

        <button type="submit">Enregistrer les modifications</button>
    </form>

    <p><a href="{{ route('candidate.show', $candidate) }}">Annuler</a></p>
</body>
</html>
