<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thématiques - La Culture du Bénin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .header {
            background-color: #343a40;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 2rem;
            flex: 1;
        }
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
            text-decoration: none;
            color: inherit;
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin: 1rem;
        }
        .card-footer {
            display: flex;
            justify-content: flex-end;
            padding: 0.5rem 1rem;
        }
        .card-footer i {
            font-size: 1.5rem;
            color: #007bff;
        }
        .footer {
            background-color: #2c3e50; /* Fond noir clair */
            color: white;
            padding: 2rem 0;
            margin-top: auto;
        }
        .footer h5 {
            color: #f8f9fa;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }
        .footer a {
            color: #adb5bd;
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer a:hover {
            color: white;
            text-decoration: underline;
        }
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 1rem 0;
            flex-wrap: wrap;
        }
        .footer-contact {
            text-align: center;
            margin: 1rem 0;
        }
        .footer-copyright {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #495057;
            color: #adb5bd;
        }
    </style>
</head>
<body>
    <div class="header d-flex justify-content-between align-items-center">
        <img src="{{ asset('admin/img/Bine.jpg') }}" alt="Logo gauche" style="height: 50px;">
        <h1>LA CULTURE DU BENIN</h1>
        <img src="{{ asset('admin/img/Bine.jpg') }}" alt="Logo droite" style="height: 50px;">
    </div>
    <div class="grid">
        @php
            $cards = [
                ['title' => 'Arts et traditions', 'image' => asset('admin/img/Traditions.jpg'), 'slug' => 'arts-et-traditions'],
                ['title' => 'Histoires et patrimoines', 'image' => asset('admin/img/photo1.png'), 'slug' => 'histoires-et-patrimoines'],
                ['title' => 'Langues et ethnies', 'image' => asset('admin/img/Langue.png'), 'slug' => 'langues-et-ethnies'],
                ['title' => 'Gastronomie', 'image' => asset('admin/img/Gastronomie.jpg'), 'slug' => 'gastronomie'],
                ['title' => 'Littératures et arts modernes', 'image' => asset('admin/img/litterature.jpg'), 'slug' => 'litteratures-et-arts-modernes'],
                ['title' => 'Symboles et identités', 'image' => asset('admin/img/Symboles.jpg'), 'slug' => 'symboles-et-identites'],
                ['title' => 'Danses', 'image' => asset('admin/img/Danses.jpg'), 'slug' => 'danses'],
                ['title' => 'Média culturelle', 'image' => asset('admin/img/media.jpg'), 'slug' => 'media-culturelle'],
                ['title' => 'Culture et territoires', 'image' => asset('admin/img/Cultures.jpg'), 'slug' => 'culture-et-territoires'],
            ];
        @endphp

        @foreach ($cards as $card)
            <a href="{{ route('theme.detail', ['slug' => $card['slug']]) }}" class="card">
                <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}">
                <div class="card-title">{{ $card['title'] }}</div>
                <div class="card-footer">
                    <i class="bi bi-arrow-right-circle"></i>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-4">
                    <h5>Rejoignez notre communauté</h5>
                    <p class="mb-3">Contribuez à préserver la culture béninoise pour les générations futures</p>
                    
                    <div class="footer-links">
                        <a href="{{ url('/admin') }}">Accéder au tableau de bord</a>
                        <a href="#">Fonctionnalités</a>
                        <a href="#">À propos</a>
                        <a href="#">Contact</a>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="footer-contact">
                        <p class="mb-2">
                            <strong>Culture Bénin – Plateforme de promotion du patrimoine culturel et linguistique béninois</strong>
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-envelope me-2"></i>arisculture66@gmail.com
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-telephone me-2"></i>+229 0158820815
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="footer-copyright">
                        <p class="mb-0">© 2025 Culture Bénin. Tous droits réservés.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>