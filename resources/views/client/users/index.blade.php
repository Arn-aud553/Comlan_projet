<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membres Actifs - Culture Bénin</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --indigo-header: #4338ca; /* Indigo 700 */
            --bg-color: #f8fafc;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --card-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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
            background: var(--indigo-header);
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

        /* Decorative line under title */
        .page-title::after {
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background: #fbbf24; /* Amber/Gold accent */
            margin: 20px auto 0;
            border-radius: 2px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
            flex: 1;
        }

        .users-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-bottom: 60px;
        }

        .user-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            width: auto; /* Reset width */
        }

        @media (max-width: 1100px) {
            .users-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 900px) {
            .users-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .users-grid {
                grid-template-columns: 1fr;
            }
        }

        .user-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--card-hover);
            border-color: #c7d2fe; /* Light indigo border on hover */
        }

        /* Top colored bar on card */
        .user-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, #4338ca, #6366f1);
        }

        .user-avatar-wrapper {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            padding: 4px;
            background: white;
            border-radius: 50%;
            border: 2px solid #e2e8f0;
            position: relative;
        }

        .user-avatar {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-name {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .user-role-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: #e0e7ff; /* Indigo 100 */
            color: #4338ca;      /* Indigo 700 */
            margin-bottom: 20px;
        }
        
        /* Role variations */
        .role-admin { background: #fee2e2; color: #b91c1c; } /* Red */
        .role-editeur { background: #fef3c7; color: #b45309; } /* Amber */
        .role-visiteur { background: #ecfccb; color: #4d7c0f; } /* Lime/Green */

        .user-meta {
            font-size: 14px;
            color: #64748b;
            border-top: 1px solid #f1f5f9;
            padding-top: 15px;
            margin-top: 15px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: white;
            color: #4338ca;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            margin-bottom: 40px;
            transition: all 0.2s;
        }

        .back-btn:hover {
            background: #f1f5f9;
            transform: translateX(-5px);
        }

        .custom-footer {
            background-color: #0f172a; /* Bleu nuit requested */
            color: #94a3b8;
            padding: 60px 40px;
            font-size: 14px;
            margin-top: auto; /* Push to bottom */
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
            color: #94a3b8;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-bottom {
            max-width: 1200px;
            margin: 40px auto 0;
            text-align: center;
            color: #64748b;
        }
        
        .contact-info {
            color: white; 
            margin-bottom: 15px;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <header class="header-section">
        <div style="max-width: 900px; margin: 0 auto;">
            <h1 class="page-title">Découvrez ici la liste complète des membres actifs du site.</h1>
        </div>
    </header>

    <div class="container">
        <a href="{{ route('client.dashboard') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour au tableau de bord
        </a>

        <div class="users-grid">
            @foreach($users as $user)
            <div class="user-card">
                <div class="user-avatar-wrapper">
                    <!-- Dynamic Avatar based on Name -->
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff&size=256&bold=true" alt="{{ $user->name }}" class="user-avatar">
                </div>
                
                <h3 class="user-name">{{ $user->name }}</h3>
                
                <span class="user-role-badge role-{{ $user->role }}">
                    {{ ucfirst($user->role ?? 'Membre') }}
                </span>

                <div class="user-meta">
                    @if($user->email)
                    <div class="meta-item" title="Email vérifié">
                         <i class="fas fa-envelope" style="color: #cbd5e1;"></i>
                         <span>Contact</span>
                    </div>
                    @endif
                    <div class="meta-item">
                        <i class="fas fa-calendar-alt" style="color: #cbd5e1;"></i>
                        <span>{{ $user->created_at ? $user->created_at->format('M Y') : 'N/A' }}</span>
                    </div>
                </div>
            </div>
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
