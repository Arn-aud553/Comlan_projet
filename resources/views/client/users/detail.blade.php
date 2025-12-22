<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de {{ $user->name }} - Culture Bénin</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #e0e7ff;
            --secondary: #64748b;
            --text-main: #1e293b;
            --text-secondary: #64748b;
            --bg-body: #f1f5f9;
            --card-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Hero Header with Pattern */
        .profile-header {
            background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
            padding: 5rem 2rem 10rem;
            text-align: center;
            color: white;
            position: relative;
            background-image: radial-gradient(circle at 20% 150%, rgba(255,255,255,0.1) 0%, transparent 50%),
                              radial-gradient(circle at 80% -50%, rgba(255,255,255,0.15) 0%, transparent 50%);
        }

        .container {
            max-width: 900px;
            margin: -8rem auto 4rem;
            padding: 0 1.5rem;
            position: relative;
            z-index: 10;
        }

        /* Glassmorphism Card Effect */
        .profile-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255,255,255,0.5);
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .profile-cover {
            height: 200px;
            background: linear-gradient(to right, #818cf8, #c084fc);
            position: relative;
            opacity: 0.8;
        }

        .profile-avatar-wrapper {
            width: 160px;
            height: 160px;
            margin: -80px auto 1.5rem;
            border-radius: 50%;
            border: 6px solid white;
            overflow: hidden;
            background: white;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            position: relative;
        }

        .profile-avatar {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-body {
            padding: 0 3rem 4rem;
        }

        .user-intro {
            text-align: center;
            margin-bottom: 3rem;
        }

        .big-name {
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        .big-role {
            font-size: 1rem;
            color: #64748b;
            font-weight: 500;
            background: #f1f5f9;
            padding: 0.5rem 1.5rem;
            border-radius: 99px;
            display: inline-block;
        }

        .info-cards-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .info-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.05);
            border-color: #c7d2fe;
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .icon-blue { background: #eff6ff; color: #3b82f6; }
        .icon-purple { background: #f3e8ff; color: #9333ea; }
        .icon-green { background: #ecfdf5; color: #10b981; }
        .icon-orange { background: #fff7ed; color: #f97316; }

        .info-content h4 {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 0.25rem;
            font-weight: 600;
        }

        .info-content p {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1e293b;
        }

        .back-btn {
            position: absolute;
            top: 2rem;
            left: 2rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            background: rgba(255,255,255,0.15);
            padding: 0.75rem 1.5rem;
            border-radius: 99px;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.2s;
        }
        
        .back-btn:hover { background: rgba(255,255,255,0.25); transform: translateX(-4px); }

        .culture-footer {
            margin-top: auto;
            background: linear-gradient(135deg, #fff1f2 0%, #fce7f3 100%);
            border-top: 1px solid #fecdd3;
            padding: 4rem 3rem 2rem;
            color: #1e293b;
            text-align: center;
        }

        .footer-bottom {
            font-size: 0.875rem;
            color: #64748b;
        }

        @media (max-width: 640px) {
            .info-cards-grid { grid-template-columns: 1fr; }
            .profile-body { padding: 0 1.5rem 3rem; }
            .big-name { font-size: 1.75rem; }
        }
    </style>
</head>
<body>

    <header class="profile-header">
        <a href="{{ route('client.users.index') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <h1 style="font-family: 'Outfit'; font-size: 2.5rem; font-weight: 700; opacity: 0.9;">Fiche Profil</h1>
    </header>

    <div class="container">
        <div class="profile-card">
            <div class="profile-cover"></div>
            
            <div class="profile-avatar-wrapper">
                @if($user->profile_photo_path)
                    <img src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}" class="profile-avatar">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff&size=500&bold=true" alt="{{ $user->name }}" class="profile-avatar">
                @endif
            </div>

            <div class="profile-body">
                <div class="user-intro">
                    <div class="big-name">{{ $user->name }}</div>
                    <div class="big-role">{{ ucfirst($user->role ?? 'Membre') }}</div>
                </div>

                <div class="info-cards-grid">
                    <!-- Nom Complet -->
                    <div class="info-card">
                        <div class="icon-box icon-blue">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="info-content">
                            <h4>Nom Complet</h4>
                            <p>{{ $user->name }}</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="info-card">
                        <div class="icon-box icon-purple">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <h4>Email de contact</h4>
                            <p>{{ $user->email }}</p>
                        </div>
                    </div>

                    <!-- Date d'inscription -->
                    <div class="info-card">
                        <div class="icon-box icon-green">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="info-content">
                            <h4>Date d'inscription</h4>
                            <p>{{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Dernière MAJ -->
                    <div class="info-card">
                        <div class="icon-box icon-orange">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="info-content">
                            <h4>Dernière mise à jour</h4>
                            <p>{{ $user->updated_at ? $user->updated_at->diffForHumans() : 'Jamais' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Elegant Footer -->
    <footer class="culture-footer">
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Culture Bénin. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>
