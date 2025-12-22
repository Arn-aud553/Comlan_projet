<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Client - CULTURE BENIN</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Localized Assets -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="{{ asset('vendor/jquery/jquery-3.7.0.min.js') }}"></script>

    @stack('styles')
    
    <style>
        :root {
            /* Palette Supreme - Professional & Sublime */
            --bg-body: #f8fafc;
            --bg-card: #ffffff;
            --primary: #4f46e5;      /* Indigo 600 */
            --primary-dark: #3730a3; /* Indigo 800 */
            --primary-light: #e0e7ff; /* Indigo 100 */
            --secondary: #0ea5e9;    /* Sky 500 */
            --accent: #f59e0b;       /* Amber 500 */
            --text-main: #0f172a;    /* Slate 900 */
            --text-secondary: #64748b; /* Slate 500 */
            --border-subtle: #e2e8f0;
            
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            --radius-xl: 1.5rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            background-image: 
                radial-gradient(at 0% 0%, rgba(79, 70, 229, 0.05) 0px, transparent 50%),
                radial-gradient(at 100% 0%, rgba(14, 165, 233, 0.05) 0px, transparent 50%);
            background-attachment: fixed;
            padding: 0;
            margin: 0;
        }

        .culture-container {
            max-width: 1440px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.9);
            min-height: 100vh;
        }

        /* Header redesign */
        .culture-header {
            padding: 1rem 2rem;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .culture-logo {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            box-shadow: var(--shadow-sm);
        }

        .site-title h1 {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--text-main);
            letter-spacing: -0.01em;
        }

        .site-title p {
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .culture-nav {
            display: flex;
            gap: 0.5rem;
            background: var(--bg-body);
            padding: 0.25rem;
            border-radius: 9999px;
            border: 1px solid var(--border-subtle);
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-secondary);
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.2s;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
        }

        .nav-link:hover {
            color: var(--primary);
            background: white;
            box-shadow: var(--shadow-sm);
        }

        .header-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-dashboard, .btn-logout {
            padding: 0.5rem 1rem;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid transparent;
        }
        
        .btn-dashboard {
            background: var(--primary);
            color: white;
            box-shadow: var(--shadow-sm);
        }
        
        .btn-dashboard:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-logout {
            color: var(--text-secondary);
            border: 1px solid var(--border-subtle);
            background: white;
        }

        .btn-logout:hover {
            background: #fee2e2;
            color: #ef4444;
            border-color: #fca5a5;
        }

        /* Welcome Section */
        .welcome-hero {
            padding: 4rem 3rem;
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
            color: white;
            position: relative;
            overflow: hidden;
            border-radius: 0 0 var(--radius-xl) var(--radius-xl);
            margin-bottom: 3rem;
            box-shadow: var(--shadow-lg);
        }

        .welcome-hero::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: 0;
            width: 50%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 2.24 5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 2.24 5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%239C92AC' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.6;
        }

        .welcome-content {
            position: relative;
            z-index: 10;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: linear-gradient(to right, #fff, #a5b4fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .welcome-text {
            color: #c7d2fe;
            font-size: 1.125rem;
            max-width: 600px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            padding: 3rem;
            margin-top: -6rem;
            position: relative;
            z-index: 20;
        }

        .modern-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255,255,255,0.8);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modern-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
            border-color: var(--primary-light);
        }

        .card-action {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-subtle);
            display: flex;
            justify-content: flex-end;
        }

        .btn-card-arrow {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: var(--bg-body);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-card-arrow:hover {
            background: var(--primary);
            color: white;
            transform: translateX(4px);
        }

        .icon-blue { background: #eff6ff; color: #3b82f6; }
        .icon-purple { background: #f5f3ff; color: #8b5cf6; }
        .icon-amber { background: #fffbeb; color: #f59e0b; }
        .icon-emerald { background: #ecfdf5; color: #10b981; }

        .card-value {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-main);
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .card-label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Content Section */
        .main-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            padding: 0 3rem 3rem;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .section-heading {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .list-card {
            background: white;
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border-subtle);
        }

        .content-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-subtle);
        }

        .content-item:last-child { border-bottom: none; }

        .item-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--bg-body);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            margin-right: 1rem;
        }

        .item-info { flex: 1; }

        .item-title {
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 0.25rem;
        }

        .item-meta {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-published { background: #ecfdf5; color: #059669; }
        .status-draft { background: #fef2f2; color: #ef4444; }

        /* Footer Redesign */
        .culture-footer {
            margin-top: auto;
            background: linear-gradient(135deg, #fff1f2 0%, #fce7f3 100%);
            border-top: 1px solid #fecdd3;
            padding: 4rem 3rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 4rem;
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 10;
        }

        .footer-brand {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--text-main);
        }

        .footer-logo i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .footer-desc {
            color: var(--text-secondary);
            line-height: 1.6;
            max-width: 300px;
        }

        .footer-heading {
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .footer-link {
            text-decoration: none;
            color: var(--text-secondary);
            font-size: 0.875rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-link:hover {
            color: var(--primary);
            transform: translateX(4px);
        }

        .footer-social {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-body);
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s;
        }

        .social-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .footer-bottom {
            margin-top: 4rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-subtle);
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.875rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        @media (max-width: 1024px) {
            .footer-content { grid-template-columns: 1fr 1fr; gap: 3rem; }
        }
        @media (max-width: 640px) {
            .footer-content { grid-template-columns: 1fr; gap: 2rem; }
            .footer-bottom { flex-direction: column; gap: 1rem; }
            .culture-footer { padding: 3rem 1.5rem 1.5rem; }
        }

        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); padding: 2rem; margin-top: -4rem; }
            .main-content { grid-template-columns: 1fr; padding: 0 2rem 2rem; }
        }
        @media (max-width: 640px) {
            .stats-grid { grid-template-columns: 1fr; margin-top: -3rem; }
            .culture-header { flex-direction: column; gap: 1rem; }
            .welcome-hero { padding: 3rem 1.5rem; }
            .culture-nav { flex-wrap: wrap; justify-content: center; }
        }
        
        /* Mobile Menu Toggle */
        .nav-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--text-main);
            cursor: pointer;
            z-index: 100;
        }

        @media (max-width: 991px) {
            .nav-toggle { display: block; }
            
            .culture-nav {
                position: fixed;
                top: 0;
                right: -100%;
                width: 280px;
                height: 100vh;
                background: white;
                flex-direction: column;
                padding: 5rem 1.5rem 2rem;
                border-radius: 0;
                transition: right 0.3s ease;
                box-shadow: var(--shadow-xl);
                z-index: 90;
                gap: 1rem;
            }

            .culture-nav.active {
                right: 0;
            }

            .nav-link {
                width: 100%;
                padding: 1rem 1.5rem;
                border-radius: var(--radius-md);
            }

            .header-buttons {
                display: none; /* We'll move them inside the mobile nav or handle differently */
            }

            .culture-nav .header-buttons-mobile {
                display: flex;
                flex-direction: column;
                gap: 1rem;
                margin-top: 2rem;
                padding-top: 2rem;
                border-top: 1px solid var(--border-subtle);
            }
        }

        @media (max-width: 640px) {
            .culture-header { padding: 1rem; }
            .site-title h1 { font-size: 1rem; }
            .welcome-hero { margin-bottom: 2rem; }
            .welcome-title { font-size: 1.75rem; }
        }
    </style>
</head>
<body>
    <div class="culture-container">
        <!-- Modern Header -->
        <header class="culture-header">
            <div class="logo-container">
                <div class="culture-logo">
                    <i class="fas fa-crown"></i>
                </div>
                <div class="site-title">
                    <h1>Culture Bénin</h1>
                    <p>Espace Client</p>
                </div>
            </div>
            
            <button class="nav-toggle" id="navToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <nav class="culture-nav" id="cultureNav">
                <a href="{{ route('client.contenus.manage') }}" class="nav-link">Contenus</a>
                <a href="{{ route('client.media.index') }}" class="nav-link">Médias</a>
                <a href="{{ route('client.regions.index') }}" class="nav-link">Régions</a>
                <a href="{{ route('client.languages.index') }}" class="nav-link">Langues</a>
                
                <div class="header-buttons-mobile d-lg-none">
                    @if(Auth::check() && Auth::user()->estAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn-dashboard">
                            <i class="fas fa-user-shield"></i> Espace Admin
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-logout w-100">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </nav>
            
            <div class="header-buttons d-none d-lg-flex">
                @if(Auth::check() && Auth::user()->estAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="btn-dashboard">
                        <i class="fas fa-user-shield"></i> Espace Admin
                    </a>
                @endif
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Déconnexion
                    </button>
                </form>
            </div>
        </header>

        {{-- Mobile Overlay --}}
        <div id="navOverlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:85;"></div>

        <div class="container mt-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        @yield('content')

        <!-- Footer -->
        <!-- Elegant Footer -->
        <footer class="culture-footer">
            <div class="footer-content">
                <!-- Brand Column -->
                <div class="footer-brand">
                    <div class="footer-logo">
                        <i class="fas fa-crown"></i>
                        <span>Culture Bénin</span>
                    </div>
                    <p class="footer-desc">
                        La première plateforme numérique dédiée à la préservation et la promotion du patrimoine culturel béninois.
                    </p>
                    <div class="footer-social">
                        <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <!-- Links Column 1 -->
                <div class="footer-column">
                    <h4 class="footer-heading">Découvrir</h4>
                    <div class="footer-links">
                        <a href="{{ route('client.contenus.manage') }}" class="footer-link">Contenus</a>
                        <a href="{{ route('client.media.index') }}" class="footer-link">Galerie Média</a>
                        <a href="{{ route('client.regions.index') }}" class="footer-link">Régions</a>
                        <a href="{{ route('client.languages.index') }}" class="footer-link">Langues</a>
                    </div>
                </div>

                <!-- Links Column 2 -->
                <div class="footer-column">
                    <h4 class="footer-heading">Communauté</h4>
                    <div class="footer-links">
                        <a href="#" class="footer-link">Devenir contributeur</a>
                        <a href="#" class="footer-link">Guide de rédaction</a>
                        <a href="#" class="footer-link">Événements</a>
                        <a href="#" class="footer-link">Forum</a>
                    </div>
                </div>

                <!-- Links Column 3 -->
                <div class="footer-column">
                    <h4 class="footer-heading">Légal & Aide</h4>
                    <div class="footer-links">
                        <a href="#" class="footer-link">Mentions Légales</a>
                        <a href="#" class="footer-link">Politique de confidentialité</a>
                        <a href="#" class="footer-link">CGU</a>
                        <a href="#" class="footer-link">Centre d'aide</a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} Culture Bénin. Tous droits réservés.</p>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <span style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.75rem;">
                        <i class="fas fa-circle" style="color: #10b981; font-size: 0.5rem;"></i> Système opérationnel
                    </span>
                </div>
            </div>
        </footer>
    </div>
    <!-- Localized JS -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            const navToggle = $('#navToggle');
            const cultureNav = $('#cultureNav');
            const navOverlay = $('#navOverlay');

            navToggle.on('click', function() {
                cultureNav.toggleClass('active');
                navOverlay.fadeToggle();
                $(this).find('i').toggleClass('fa-bars fa-times');
            });

            navOverlay.on('click', function() {
                cultureNav.removeClass('active');
                $(this).fadeOut();
                navToggle.find('i').addClass('fa-bars').removeClass('fa-times');
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>