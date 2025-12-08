<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Client - Culture Bénin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            padding: 40px;
            width: 100%;
            max-width: 500px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="text-center mb-4">
            <img src="{{ asset('admin/img/ballon-benin.jpg') }}" alt="Logo" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
            <h2 class="mt-3">Inscription</h2>
            <p class="text-muted">Veuillez créer votre compte </p>
        </div>

        <form method="POST" action="{{ route('client.register') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nom" class="form-label">Nom *</label>
                    <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" value="{{ old('nom') }}" required>
                    @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="prenoms" class="form-label">Prénoms *</label>
                    <input id="prenoms" type="text" class="form-control @error('prenoms') is-invalid @enderror" name="prenoms" value="{{ old('prenoms') }}" required>
                    @error('prenoms')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Sexe *</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sexe" id="sexe_m" value="M" {{ old('sexe') == 'M' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="sexe_m">Masculin</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sexe" id="sexe_f" value="F" {{ old('sexe') == 'F' ? 'checked' : '' }} required>
                        <label class="form-check-label" for="sexe_f">Féminin</label>
                    </div>
                </div>
                @error('sexe')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="telephone" class="form-label">Téléphone *</label>
                <input id="telephone" type="tel" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone') }}" required>
                @error('telephone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Adresse Email *</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de Passe *</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le Mot de Passe *</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">S'inscrire</button>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary">Déjà un compte ? Se connecter</a>
            </div>
        </form>
    </div>
</body>
</html>