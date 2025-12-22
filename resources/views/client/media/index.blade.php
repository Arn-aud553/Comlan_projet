<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Images Historiques du Bénin - Culture Bénin</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --chic-primary: #1e293b;
            --chic-secondary: #b45309;
            --bg-color: #f8fafc;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            padding: 0;
            color: #334155;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header-section {
            text-align: center;
            padding: 50px 20px;
            background: white;
            border-bottom: 1px solid #e2e8f0;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 700;
            color: #000000; /* Requested Black */
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
            position: relative;
            display: inline-block;
        }

        .page-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: var(--chic-secondary);
            margin: 15px auto 0;
        }

        .gallery-container {
            max-width: 1400px;
            margin: 50px auto;
            padding: 0 40px;
            flex: 1;
        }

        .gallery-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: flex-start; /* Aligns items to the left */
        }

        /* Ensure link acts as a refined flex item */
        .gallery-link {
            display: block; 
            text-decoration: none; 
            color: inherit;
            width: calc(33.333% - 20px); /* 3 cards per row on desktop */
            min-width: 280px;
        }

        @media (max-width: 1024px) {
            .gallery-link { width: calc(50% - 15px); }
        }

        @media (max-width: 640px) {
            .gallery-link { width: 100%; }
            .gallery-container { padding: 0 20px; }
            .header-section { padding: 30px 20px; }
            .page-title { font-size: 24px; }
        }
        /* ... existing styles ... */
        .gallery-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .image-wrapper {
            width: 100%;
            height: 250px;
            overflow: hidden;
            position: relative;
            background: #f1f5f9;
        }

        .gallery-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-item:hover .gallery-img {
            transform: scale(1.05);
        }

        .item-content {
            padding: 25px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .item-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--chic-primary);
            margin-bottom: 12px;
        }

        .item-desc {
            font-size: 14px;
            line-height: 1.6;
            color: #64748b;
            flex-grow: 1;
        }

        .arrow-icon {
            color: var(--chic-secondary);
            font-size: 18px;
            margin-left: 10px;
            transition: transform 0.3s ease;
        }

        .gallery-item:hover .arrow-icon {
            transform: translateX(5px);
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--chic-primary);
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 30px;
            transition: color 0.2s;
        }

        .back-btn:hover {
            color: var(--chic-secondary);
        }

        .custom-footer {
            background: linear-gradient(135deg, #b45309 0%, #1e293b 100%); /* Marron + Indigo */
            color: #cbd5e1;
            padding: 60px 40px;
            font-size: 14px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            padding-bottom: 40px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .footer-col h4 {
            color: white;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: #fbbf24;
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 40px auto 0;
            text-align: center;
            color: #94a3b8;
        }
        
        .contact-info {
            color: #fbbf24; 
            margin-bottom: 15px;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <header class="header-section">
        <h1>LES IMAGES HISTORIQUES DU BENIN</h1>
    </header>

    <div class="gallery-container">
        <a href="{{ route('client.dashboard') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour au tableau de bord
        </a>

        <div class="gallery-grid">
            @foreach($images as $image)
            <a href="{{ route('client.media.detail', ['id' => $image->id_media ?? $image->id]) }}" class="gallery-link">
                <div class="gallery-item">
                    <div class="image-wrapper">
                        <img src="{{ asset('admin/img/' . $image->nom_fichier) }}" alt="{{ $image->titre ?? $image->contenu->titre ?? $image->nom_fichier }}" class="gallery-img">
                    </div>
                    <div class="item-content">
                        <div class="d-flex justify-content-between align-items-start">
                            <h3 class="item-title">{{ $image->titre ?? $image->contenu->titre ?? pathinfo($image->nom_fichier, PATHINFO_FILENAME) }}</h3>
                            <span class="arrow-icon"><i class="fas fa-arrow-right"></i></span>
                        </div>
                        <p class="item-desc">{{ Str::limit(strip_tags($image->description ?? $image->contenu->texte ?? ''), 100) }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <footer class="custom-footer">
        <div class="footer-content">
            <div class="footer-col">
                <h4>Fonctionnalités</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('client.media.index') }}">Galerie</a></li>
                    <li><a href="{{ route('client.contenus.manage') }}">Articles</a></li>
                    <li><a href="#">Contributions</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>À propos</h4>
                <ul class="footer-links">
                    <li><a href="#">Notre Mission</a></li>
                    <li><a href="#">L'Équipe</a></li>
                    <li><a href="#">Partenaires</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <p style="margin-bottom: 15px; color: #e2e8f0;">Culture Bénin – Plateforme de promotion du patrimoine culturel et linguistique béninois</p>
                <p class="contact-info">arisculture66@gmail.com | +229 0158820815</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Culture Bénin. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>
