<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Univers Culturel - Patrimoine du Bénin</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            /* Palette Culturelle & Professionnelle */
            --primary: #1e293b;   /* Bleu Nuit Profond */
            --secondary: #d97706; /* Or Antique / Ambre */
            --accent: #9f1239;    /* Rouge Terracotta / Bordeaux */
            --light: #f8fafc;     /* Blanc Cassé */
            --dark: #0f172a;      /* Noir Ardoise */
            --glass: rgba(255, 255, 255, 0.95);
            --glass-card: rgba(255, 255, 255, 0.8);
            
            --gradient-hero: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.85) 100%);
            --gradient-card: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
            
            --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            overflow-x: hidden;
        }

        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
        }

        /* Header Premium */
        header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 15px 40px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-img {
            height: 50px;
            border-radius: 8px;
            box-shadow: var(--shadow-sm);
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: -0.5px;
        }
        
        .logo-text span {
            color: var(--secondary);
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-outline {
            border: 1px solid var(--primary);
            color: var(--primary);
            background: transparent;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .btn-filled {
            background: var(--secondary);
            color: white;
            box-shadow: 0 4px 15px rgba(217, 119, 6, 0.3);
        }

        .btn-filled:hover {
            background: #b45309;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(217, 119, 6, 0.4);
        }

        /* Hero Immersif */
        .hero {
            height: 90vh;
            background: var(--gradient-hero), url('{{ asset("admin/img/PAGEAC.png") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            margin-bottom: 60px;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background: linear-gradient(to top, var(--light), transparent);
        }

        .hero-content {
            max-width: 800px;
            padding: 40px;
            z-index: 2;
        }

        .hero h1 {
            font-size: 4rem;
            margin-bottom: 20px;
            text-shadow: 0 4px 10px rgba(0,0,0,0.3);
            line-height: 1.1;
        }

        .hero p {
            font-size: 1.4rem;
            opacity: 0.9;
            margin-bottom: 40px;
            font-weight: 300;
        }

        .hero-btn {
            padding: 16px 40px;
            background: white;
            color: var(--primary);
            font-weight: 700;
            border-radius: 50px;
            text-decoration: none;
            transition: transform 0.3s;
            display: inline-block;
        }

        .hero-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(255,255,255,0.2);
        }

        /* Sections */
        .section-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 60px 20px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-header h2 {
            font-size: 2.5rem;
            color: var(--primary);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-header h2::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: var(--secondary);
            margin: 15px auto 0;
        }

        .section-header p {
            color: #64748b;
            font-size: 1.1rem;
        }

        /* Cartes Catégories */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .category-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.4s ease;
            position: relative;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .category-img-wrapper {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .category-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .category-card:hover .category-img-wrapper img {
            transform: scale(1.1);
        }

        .category-content {
            padding: 25px;
            text-align: center;
        }

        .category-icon {
            width: 60px;
            height: 60px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary);
            font-size: 24px;
            margin: -55px auto 15px;
            position: relative;
            border: 4px solid white;
            box-shadow: var(--shadow-sm);
        }

        .category-title {
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .category-desc {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .btn-link {
            color: var(--secondary);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: gap 0.2s;
        }

        .btn-link:hover {
            gap: 10px;
            color: var(--primary);
        }

        /* Section Vocation (Mission) */
        .mission-section {
            background: white;
            position: relative;
            overflow: hidden;
        }

        .mission-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 60px;
        }

        .mission-content h3 {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 25px;
        }

        .mission-content p {
            color: #475569;
            line-height: 1.8;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .mission-img {
            border-radius: 20px;
            box-shadow: -20px 20px 0 var(--secondary);
            width: 100%;
        }

        /* Footer */
        footer {
            background: var(--primary);
            color: white;
            padding: 80px 0 30px;
            margin-top: 80px;
        }

        .footer-grid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 50px;
            margin-bottom: 60px;
        }

        .footer-col h4 {
            color: var(--secondary);
            font-size: 1.2rem;
            margin-bottom: 25px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 15px;
        }

        .footer-links a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: white;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: white;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: var(--secondary);
            transform: translateY(-3px);
        }

        .copyright {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #94a3b8;
            font-size: 0.9rem;
        }

        @media (max-width: 900px) {
            .mission-grid {
                grid-template-columns: 1fr;
            }
            .hero h1 {
                font-size: 2.5rem;
            }
            .hero p {
                font-size: 1.1rem;
            }
            header {
                padding: 10px 20px;
            }
            .nav-buttons {
                display: none;
            }
            .logo-text {
                font-size: 18px;
            }
            .mobile-menu-btn {
                display: block !important;
                background: none;
                border: none;
                font-size: 24px;
                color: var(--primary);
                cursor: pointer;
            }
        }

        .mobile-nav {
            position: fixed;
            top: 70px;
            left: 0;
            width: 100%;
            background: white;
            padding: 20px;
            box-shadow: var(--shadow-md);
            display: none;
            flex-direction: column;
            gap: 15px;
            z-index: 999;
        }

        .mobile-nav.active {
            display: flex;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <div class="logo-container">
            <img src="{{ asset('admin/img/Benin.png') }}" alt="Benin Logo" class="logo-img">
            <div class="logo-text">CULTURE <span>BENIN</span></div>
        </div>
        <nav class="nav-buttons">
            <a href="{{ route('login') }}" class="btn btn-outline"><i class="bi bi-box-arrow-in-right"></i> Connexion</a>
            <a href="{{ route('register') }}" class="btn btn-filled"><i class="bi bi-person-plus"></i> S'inscrire</a>
        </nav>
        <button class="mobile-menu-btn" style="display: none;" onclick="toggleMobileMenu()">
            <i class="bi bi-list"></i>
        </button>
    </header>

    <!-- Mobile Nav -->
    <div class="mobile-nav" id="mobileNav">
        <a href="{{ route('login') }}" class="btn btn-outline" style="text-align: center;"><i class="bi bi-box-arrow-in-right"></i> Connexion</a>
        <a href="{{ route('register') }}" class="btn btn-filled" style="text-align: center;"><i class="bi bi-person-plus"></i> S'inscrire</a>
    </div>

    <script>
        function toggleMobileMenu() {
            const nav = document.getElementById('mobileNav');
            nav.classList.toggle('active');
        }
    </script>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>L'Ame du Bénin à portée de clic</h1>
            <p>Bienvenue sur la plateforme numérique dédiée à la valorisation, la préservation et la promotion du patrimoine culturel béninois.</p>
            <a href="{{ route('register') }}" class="hero-btn">Explorer Maintenant</a>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="section-container">
        <div class="section-header">
            <h2>Explorez notre Richesse</h2>
            <p>Plongez au cœur de la diversité culturelle à travers nos thématiques</p>
        </div>

        <div class="categories-grid">
            <!-- Musique -->
            <div class="category-card">
                <div class="category-img-wrapper">
                    <img src="{{ asset('admin/img/MUSIC.jpg') }}" alt="Musique">
                </div>
                <div class="category-content">
                    <div class="category-icon"><i class="fas fa-music"></i></div>
                    <h3 class="category-title">Musique Traditionnelle</h3>
                    <p class="category-desc">Des rythmes ancestraux aux sonorités modernes, découvrez l'histoire musicale du Bénin.</p>
                    <a href="{{ route('musique') }}" class="btn-link">Découvrir <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>

            <!-- Danse -->
            <div class="category-card">
                <div class="category-img-wrapper">
                    <img src="{{ asset('admin/img/Danses.jpg') }}" alt="Danse">
                </div>
                <div class="category-content">
                    <div class="category-icon"><i class="fas fa-running"></i></div>
                    <h3 class="category-title">Danses & Rituels</h3>
                    <p class="category-desc">La danse comme expression du sacré et du social. Un voyage en mouvement.</p>
                    <a href="{{ route('danse') }}" class="btn-link">Découvrir <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>

            <!-- Art de Rue -->
            <div class="category-card">
                <div class="category-img-wrapper">
                    <img src="{{ asset('admin/img/RUE.jpg') }}" alt="Art">
                </div>
                <div class="category-content">
                    <div class="category-icon"><i class="fas fa-paint-brush"></i></div>
                    <h3 class="category-title">Arts de la Rue</h3>
                    <p class="category-desc">Théâtre, performances et arts visuels qui animent nos espaces publics.</p>
                    <a href="{{ route('art-rue') }}" class="btn-link">Découvrir <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="section-container mission-section">
        <div class="mission-grid">
            <div class="mission-content">
                <h3>Notre Vocation</h3>
                <p>
                    Cette plateforme est née d'une volonté farouche de numériser et de rendre accessible l'immense patrimoine du Bénin. 
                    Nous croyons que la culture est le pilier du développement et de l'identité.
                </p>
                <p>
                    En connectant les artistes, les historiens et le public, nous tissons une toile numérique qui préserve notre passé tout en inspirant notre futur.
                </p>
                <a href="{{ route('themes') }}" class="btn btn-filled">Voir tous les thèmes</a>
            </div>
            <div>
                <img src="{{ asset('admin/img/LADANSE.jpg') }}" alt="Culture Benin" class="mission-img">
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-grid">
            <div class="footer-col">
                <div class="logo-container" style="color: white; margin-bottom: 20px;">
                    <img src="{{ asset('admin/img/Benin.png') }}" alt="Logo" style="height: 40px; border-radius: 4px;">
                    <span style="font-size: 20px; font-weight: 700;">CULTURE <span style="color: var(--secondary);">BENIN</span></span>
                </div>
                <p style="color: #cbd5e1; line-height: 1.6;">
                    La référence numérique pour la découverte et la promotion de la culture béninoise.
                </p>
            </div>
            <div class="footer-col">
                <h4>Navigation</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('themes') }}">Thématiques</a></li>
                    <li><a href="{{ route('login') }}">Connexion</a></li>
                    <li><a href="{{ route('register') }}">Inscription</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact</h4>
                <ul class="footer-links">
                    <li><a href="#"><i class="bi bi-envelope"></i> contact@culture.bj</a></li>
                    <li><a href="#"><i class="bi bi-telephone"></i> +229 01 23 45 67</a></li>
                    <li><a href="#"><i class="bi bi-geo-alt"></i> Cotonou, Bénin</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Suivez-nous</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2024 Culture Bénin. Tous droits réservés.</p>
        </div>
    </footer>

</body>
</html>