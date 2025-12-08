<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Régions - Culture Bénin</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --teal-header: #14b8a6; /* Teal for Regions */
            --bg-color: #f8fafc;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --card-hover: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
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
            padding: 80px 20px;
            background: var(--teal-header);
            color: white;
            margin-bottom: 50px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            margin: 0;
            line-height: 1.3;
        }

        .page-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: #fcd34d; /* Amber/Yellow accent */
            margin: 20px auto 0;
            border-radius: 2px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
            flex: 1;
        }

        .regions-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 60px;
        }

        @media (max-width: 900px) {
            .regions-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 600px) {
            .regions-grid { grid-template-columns: 1fr; }
        }

        .region-card {
            background: white;
            border-radius: 12px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .region-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover);
            border-color: #5eead4;
        }
        
        /* Decorative circle */
        .region-card::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 80px;
            height: 80px;
            background: rgba(20, 184, 166, 0.1);
            border-radius: 50%;
        }

        .region-name {
            font-size: 24px;
            font-weight: 700;
            color: #0f766e;
            margin-bottom: 10px;
            font-family: 'Playfair Display', serif;
        }

        .region-desc {
            font-size: 14px;
            color: #64748b;
            line-height: 1.5;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: white;
            color: var(--teal-header);
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            margin-bottom: 40px;
            transition: all 0.2s;
        }

        .back-btn:hover {
            background: #f0fdfa;
            transform: translateX(-5px);
        }

        /* Using same footer styles */
        .custom-footer {
            background-color: #0f172a;
            color: #94a3b8;
            padding: 60px 40px;
            font-size: 14px;
            margin-top: auto;
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
        .footer-links { list-style: none; padding: 0; margin: 0; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a { color: #94a3b8; text-decoration: none; transition: color 0.2s; }
        .footer-links a:hover { color: white; }
        .footer-bottom { max-width: 1200px; margin: 40px auto 0; text-align: center; color: #64748b; }
        .contact-info { color: white; margin-bottom: 15px; font-weight: 500; }
    </style>
</head>
<body>

    <header class="header-section">
        <h1 class="page-title">Régions et Départements</h1>
        <p style="margin-top: 15px; font-size: 18px; opacity: 0.9;">Explorez la diversité culturelle de nos territoires.</p>
    </header>

    <div class="container">
        <a href="{{ route('client.dashboard') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour au tableau de bord
        </a>

        <div class="regions-grid">
            @forelse($regions as $region)
            <div class="region-card">
                <h3 class="region-name">{{ $region->nom_region }}</h3>
                <p class="region-desc">{{ Str::limit($region->description, 100) }}</p>
                <div style="margin-top: 20px; font-size: 13px; color: #14b8a6; font-weight: 600;">
                    <a href="{{ route('client.regions.detail', $region->id_region) }}" style="text-decoration: none; color: inherit;">
                        En savoir plus <i class="fas fa-arrow-right" style="font-size: 11px; margin-left: 4px;"></i>
                    </a>
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px;">
                <p style="font-size: 18px; color: #94a3b8;">Aucune région répertoriée pour le moment.</p>
            </div>
            @endforelse
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
