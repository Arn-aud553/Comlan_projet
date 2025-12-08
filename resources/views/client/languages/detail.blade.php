<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $langue->nom_langue }} - Détails - Culture Bénin</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --header-bg: #1e293b; /* Midnight Blue */
            --bg-color: #f8fafc;
            --text-color: #334155;
            --primary-color: #8b5cf6;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            margin: 0;
            padding: 0;
            color: var(--text-color);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header-section {
            text-align: center;
            padding: 80px 20px;
            background: var(--header-bg);
            color: white;
            margin-bottom: 50px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 700;
            margin: 0;
            line-height: 1.3;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 40px;
            flex: 1;
        }

        .content-card {
            background: white;
            border-radius: 12px;
            padding: 50px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
            line-height: 1.8;
            font-size: 16px;
            color: #1e293b;
            white-space: pre-wrap; /* Preserves line breaks from database */
        }
        
        .content-card h3 {
            color: var(--primary-color);
            margin-top: 30px;
            font-family: 'Playfair Display', serif;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: white;
            color: var(--primary-color);
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            margin-bottom: 40px;
            transition: all 0.2s;
        }

        .back-btn:hover {
            transform: translateX(-5px);
            background: #f1f5f9;
        }

        /* Footer */
        .custom-footer {
            background-color: #0f172a;
            color: #94a3b8;
            padding: 60px 40px;
            font-size: 14px;
            margin-top: 60px;
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
        <h1 class="page-title">{{ $langue->nom_langue }}</h1>
        <p style="margin-top: 15px; opacity: 0.9; font-size: 18px;">Détails et informations</p>
    </header>

    <div class="container">
        <a href="{{ route('client.languages.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>

        <div class="content-card">
            {{ $langue->description ?? "Aucune description disponible pour cette langue." }}
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
