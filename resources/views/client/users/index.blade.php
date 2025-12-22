<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communauté - Culture Bénin</title>
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
            --bg-body: #f8fafc;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --card-hover-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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

        /* Header Premium */
        .page-header {
            background: linear-gradient(135deg, #4f46e5 0%, #312e81 100%);
            padding: 4rem 2rem 6rem;
            text-align: center;
            color: white;
            position: relative;
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }

        .header-title {
            font-family: 'Outfit', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .header-subtitle {
            font-size: 1.125rem;
            color: #e0e7ff;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .container {
            max-width: 1280px;
            margin: -4rem auto 4rem;
            padding: 0 2rem;
            position: relative;
            z-index: 10;
        }

        /* Users Grid */
        .users-grid {
            display: grid;
            gap: 2rem;
            width: 100%;
            /* Default mobile/single column handled by media query below if needed, but let's start responsive */
            grid-template-columns: repeat(1, 1fr);
        }

        /* Responsive Breakpoints for Horizontal Layout */
        @media (min-width: 640px) {
            .users-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (min-width: 1024px) {
            .users-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (min-width: 1280px) {
            .users-grid { grid-template-columns: repeat(4, 1fr); }
        }

        /* User Card Premium */
        .user-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border: 1px solid rgba(255,255,255,0.5);
        }

        .user-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--card-hover-shadow);
        }

        .card-cover {
            height: 100px;
            background: linear-gradient(to right, #e0e7ff, #f3e8ff);
            position: relative;
        }

        .card-body {
            padding: 0 1.5rem 1.5rem;
            text-align: center;
        }

        .user-avatar-container {
            margin-top: -50px;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .user-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            object-fit: cover;
            background: white;
        }

        .status-indicator {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 16px;
            height: 16px;
            background: #10b981;
            border: 3px solid white;
            border-radius: 50%;
        }

        .user-name {
            font-family: 'Outfit', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.25rem;
        }

        .user-role {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: #f1f5f9;
            color: #64748b;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }
        
        .role-admin { background: #fee2e2; color: #b91c1c; }
        .role-editeur { background: #fef3c7; color: #b45309; }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
            text-align: left;
            background: #f8fafc;
            padding: 1rem;
            border-radius: 12px;
        }

        .info-item label {
            display: block;
            font-size: 0.75rem;
            color: #94a3b8;
            margin-bottom: 0.25rem;
        }

        .info-item span {
            font-size: 0.875rem;
            font-weight: 500;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-profile {
            display: block;
            width: 100%;
            padding: 0.875rem;
            background: white;
            color: var(--primary);
            border: 1px solid #e0e7ff;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-profile:hover {
            background: #4f46e5;
            color: white;
            border-color: #4f46e5;
        }

        .back-btn {
            position: absolute;
            top: 2rem;
            left: 2rem;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
            opacity: 0.8;
            transition: opacity 0.2s;
        }
        
        .back-btn:hover { opacity: 1; }

        /* Copy of new Footer Design */
        .culture-footer {
            margin-top: auto;
            background: linear-gradient(135deg, #fff1f2 0%, #fce7f3 100%);
            border-top: 1px solid #fecdd3;
            padding: 4rem 3rem 2rem;
            color: #1e293b;
        }

        .footer-bottom {
            text-align: center;
            font-size: 0.875rem;
            color: #64748b;
        }
        
        @media (max-width: 640px) {
            .users-grid { grid-template-columns: 1fr; }
            .page-header { padding: 3rem 1.5rem 5rem; }
        }
    </style>
</head>
<body>

    <header class="page-header">
        <a href="{{ route('client.dashboard') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
        <h1 class="header-title">Nos Membres</h1>
        <p class="header-subtitle">Découvrez la communauté dynamique de passionnés qui font vivre la culture béninoise.</p>
    </header>

    <div class="container">
        <div class="users-grid">
            @foreach($users as $user)
            <div class="user-card">
                <div class="card-cover"></div>
                
                <div class="card-body">
                    <div class="user-avatar-container">
                        @if($user->profile_photo_path)
                            <img src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}" class="user-avatar">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff&size=200&bold=true" alt="{{ $user->name }}" class="user-avatar">
                        @endif
                        <span class="status-indicator" title="En ligne"></span>
                    </div>

                    <h3 class="user-name">{{ $user->name }}</h3>
                    <span class="user-role role-{{ $user->role ?? 'membre' }}">
                        {{ ucfirst($user->role ?? 'Membre') }}
                    </span>

                    <div class="info-grid">
                        <div class="info-item">
                            <label>Membre depuis</label>
                            <span><i class="far fa-calendar-alt"></i> {{ $user->created_at ? $user->created_at->format('M Y') : 'N/A' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Statut</label>
                            <span style="color: #10b981;"><i class="fas fa-check-circle"></i> Actif</span>
                        </div>
                    </div>

                    <a href="{{ route('client.users.detail', $user->id) }}" class="btn-profile">
                        Voir le profil
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Elegant Footer (Simplified for consistency) -->
    <footer class="culture-footer">
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Culture Bénin. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>
