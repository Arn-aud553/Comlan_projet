<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $themeTitle }} - La Culture du Bénin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e6f7ff; /* Fond bleu ciel clair */
        }
        .header {
            background-color: white;
            color: black;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .content {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .theme-title {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: #0056b3;
            text-align: center;
        }
        .theme-content {
            font-size: 1.1rem;
            line-height: 1.6;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .content-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .content-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 2rem 0;
            margin-top: 3rem;
        }
        .footer h5 {
            color: #f8f9fa;
            margin-bottom: 1rem;
        }
        .footer a {
            color: #adb5bd;
            text-decoration: none;
        }
        .footer a:hover {
            color: white;
            text-decoration: underline;
        }
        .back-button {
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <p class="mb-0">« La culture béninoise, riche et variée, célèbre traditions, musiques, danses, arts, fêtes et patrimoine. »</p>
        </div>
    </div>

    <div class="content">
        <a href="{{ url('/themes') }}" class="btn btn-secondary back-button">
            <i class="bi bi-arrow-left"></i> Retour aux thématiques
        </a>
        
        <h1 class="theme-title">{{ $themeTitle }}</h1>
        
        <div class="theme-content">
            @if($contenus->count() > 0)
                <p class="mb-4">Découvrez {{ $contenus->total() }} contenu(s) sur le thème "{{ $themeTitle }}"</p>
                
                @foreach($contenus as $contenu)
                    <div class="content-card">
                        <h3>{{ $contenu->titre }}</h3>
                        <p class="text-muted">
                            <i class="bi bi-person"></i> {{ $contenu->auteur->nom_complet ?? 'Auteur inconnu' }} |
                            <i class="bi bi-calendar"></i> {{ $contenu->date_publication ? $contenu->date_publication->format('d/m/Y') : 'Non publié' }}
                            @if($contenu->region)
                                | <i class="bi bi-geo-alt"></i> {{ $contenu->region->nom_region }}
                            @endif
                        </p>
                        <p>{{ Str::limit($contenu->texte, 200) }}</p>
                        <a href="{{ route('contenus.show', $contenu->id_contenu) }}" class="btn btn-primary btn-sm">
                            Lire la suite <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                @endforeach

                <div class="mt-4">
                    {{ $contenus->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Aucun contenu disponible pour ce thème pour le moment.
                </div>
            @endif
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Rejoignez notre communauté</h5>
                    <p>Contribuez à préserver la culture béninoise pour les générations futures</p>
                </div>
                <div class="col-md-3">
                    <h5>Liens utiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Accéder au tableau de bord</a></li>
                        <li><a href="#">Fonctionnalités</a></li>
                        <li><a href="#">À propos</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <p>Culture Bénin – Plateforme de promotion du patrimoine culturel et linguistique béninois</p>
                    <p>arisculture66@gmail.com</p>
                    <p>+229 0158820815</p>
                </div>
            </div>
            <hr class="my-4" style="border-color: #6c757d;">
            <div class="text-center">
                <p class="mb-0">© 2025 Culture Bénin. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>