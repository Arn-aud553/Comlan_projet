{{-- resources/views/layouts/sector.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Culture Bénin')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: #ffffff;
        }
        
        /* Header */
        .sector-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
            min-height: 80px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        
        .sector-header .logo {
            height: 60px;
        }
        
        .sector-header .logo img {
            height: 100%;
            width: auto;
            border-radius: 8px;
            border: 3px solid rgba(255, 215, 0, 0.2);
            background: rgba(255, 255, 255, 0.1);
            padding: 4px;
        }
        
        .sector-header .page-title {
            color: white;
            font-size: 24px;
            font-weight: 700;
            text-align: center;
            flex: 1;
        }
        
        /* Main Content */
        .sector-main {
            padding: 80px 40px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            min-height: calc(100vh - 80px - 200px);
        }
        
        .content-wrapper {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        
        .content-title {
            text-align: center;
            color: #1a1a1a;
            font-size: 42px;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid #6a11cb;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .content-text {
            font-size: 18px;
            line-height: 1.8;
            color: #333;
            text-align: justify;
            margin-bottom: 25px;
        }
        
        .content-text strong {
            color: #6a11cb;
            font-weight: 700;
        }
        
        .content-list {
            list-style-type: none;
            margin: 30px 0;
            padding-left: 20px;
        }
        
        .content-list li {
            padding: 10px 0;
            font-size: 17px;
            color: #444;
            position: relative;
            padding-left: 30px;
        }
        
        .content-list li:before {
            content: '•';
            color: #2575fc;
            font-size: 24px;
            position: absolute;
            left: 0;
            top: 5px;
        }
        
        /* Footer */
        .sector-footer {
            background: #000000;
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        
        .footer-nav {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            gap: 30px;
        }
        
        .footer-nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 18px;
        }
        
        .footer-nav a:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        .footer-text {
            margin: 10px 0;
            color: white;
            font-size: 18px;
        }
        
        .footer-text i {
            margin-right: 8px;
            color: #2575fc;
        }
        
        .footer-copyright {
            margin-top: 20px;
            font-size: 16px;
            color: #aaa;
        }
        
        /* Back Button */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            background: #6a11cb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            margin-top: 30px;
        }
        
        .back-button:hover {
            background: #2575fc;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 117, 252, 0.3);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .d-none-mobile {
                display: none !important;
            }
            .sector-header {
                flex-direction: column;
                padding: 15px 20px;
                gap: 15px;
            }
            
            .sector-header .logo {
                height: 50px;
            }
            
            .sector-header .page-title {
                font-size: 20px;
                order: -1;
            }
            
            .sector-main {
                padding: 40px 20px;
            }
            
            .content-wrapper {
                padding: 30px 20px;
            }
            
            .content-title {
                font-size: 32px;
            }
            
            .content-text {
                font-size: 16px;
            }
            
            .footer-nav {
                flex-direction: column;
                gap: 15px;
            }
            
            .footer-nav a {
                width: 100%;
                max-width: 200px;
                margin: 0 auto;
            }
        }
        
        @media (max-width: 480px) {
            .content-title {
                font-size: 28px;
            }
            
            .content-wrapper {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="sector-header">
        <div class="logo">
            <img src="{{ asset('admin/img/CULTURE.png') }}" alt="Culture Bénin">
        </div>
        <h1 class="page-title">@yield('page-title')</h1>
        <div class="logo d-none-mobile">
            <img src="{{ asset('admin/img/CULTURE.png') }}" alt="Culture Bénin">
        </div>
    </header>

    <!-- Main Content -->
    <main class="sector-main">
        <div class="content-wrapper">
            @yield('content')
            
            <!-- Back to Home Button -->
            <a href="{{ url('/') }}" class="back-button">
                <i class="bi bi-arrow-left"></i> Retour à l'accueil
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="sector-footer">
        <div class="footer-nav">
            <a href="#">Fonctionnalités</a>
            <a href="#">À propos</a>
            <a href="#">Contact</a>
        </div>
        <p class="footer-text">Culture Bénin – Plateforme de promotion du patrimoine culturel et linguistique béninois</p>
        <p class="footer-text">
            <i class="bi bi-envelope"></i> arisculture66@gmail.com | <i class="bi bi-telephone"></i> +229 0158820815
        </p>
        <p class="footer-copyright">© 2025 Culture Bénin. Tous droits réservés.</p>
    </footer>
</body>
</html>