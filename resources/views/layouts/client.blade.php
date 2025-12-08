<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Client - CULTURE BENIN</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            /* Palette Premium - Chic & Modern */
            --chic-primary: #1e293b;   /* Slate 800 - Deep Navy */
            --chic-secondary: #b45309; /* Amber 700 - Antique Gold */
            --chic-accent: #0f172a;    /* Slate 900 */
            --chic-bg: #f8fafc;        /* Slate 50 - Very soft gray */
            --card-bg: #ffffff;
            --text-main: #334155;      /* Slate 700 */
            --text-light: #64748b;     /* Slate 500 */
            
            --gradient-primary: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            --gradient-gold: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            
            --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --shadow-card: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
            --shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background-color: var(--chic-bg);
            color: var(--text-main);
            min-height: 100vh;
            padding: 20px;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 24px 24px;
        }
        
        .culture-container {
            max-width: 1400px;
            margin: 0 auto;
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: var(--shadow-card);
            overflow: hidden;
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        
        /* Header Styles */
        .culture-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 40px;
            background: var(--card-bg);
            border-bottom: 1px solid #e2e8f0;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        
        .culture-logo {
            width: 50px;
            height: 50px;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fbbf24; /* Gold text */
            font-size: 22px;
            box-shadow: var(--shadow-soft);
            transform: rotate(-5deg);
        }
        
        .site-title h1 {
            font-size: 22px;
            font-weight: 700;
            color: var(--chic-primary);
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }
        
        .site-title p {
            font-size: 13px;
            color: var(--chic-secondary);
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        
        .culture-nav {
            display: flex;
            gap: 32px;
            background: #f1f5f9;
            padding: 8px 12px;
            border-radius: 50px;
        }
        
        .nav-link {
            text-decoration: none;
            color: var(--text-light);
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s;
            padding: 8px 16px;
            border-radius: 20px;
        }
        
        .nav-link:hover {
            color: var(--chic-primary);
            background: white;
            box-shadow: var(--shadow-soft);
        }
        
        .header-buttons {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        
        .btn-dashboard {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: var(--shadow-soft);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-dashboard:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            color: white;
        }
        
        .btn-logout {
            background: transparent;
            color: var(--text-light);
            border: 1px solid #e2e8f0;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-logout:hover {
            border-color: #ef4444;
            color: #ef4444;
            background: #fef2f2;
        }
        
        /* Stats Section - Redesigned */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            padding: 40px;
            background: #fafafa;
        }
        
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: var(--shadow-soft);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
        }
        
        .stat-green::before { background: #10b981; } /* Emerald */
        .stat-yellow::before { background: #f59e0b; } /* Amber */
        .stat-blue::before { background: #3b82f6; }   /* Blue */
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }
        
        .stat-number {
            font-size: 42px;
            font-weight: 800;
            color: var(--chic-primary);
            margin-bottom: 8px;
            letter-spacing: -1px;
        }
        
        .stat-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 12px;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 0.5px;
        }
        
        .stat-desc {
            color: var(--text-light);
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        
        .stat-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }
        
        .btn-manage, .btn-create, .btn-view {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-manage { background: #ecfdf5; color: #059669; }
        .btn-create { background: #fffbeb; color: #b45309; }
        .btn-view { background: #eff6ff; color: #2563eb; }
        
        .stat-link {
            color: var(--chic-primary);
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .stat-link:hover {
            color: var(--chic-secondary);
        }
        
        /* Recent Content & Guide */
        .content-guide-section {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            padding: 0 40px 40px;
            background: #fafafa;
        }
        
        .recent-content {
            background: white;
            border-radius: 16px;
            padding: 40px;
            box-shadow: var(--shadow-soft);
            border: 1px solid #f1f5f9;
        }
        
        .content-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--chic-primary);
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .content-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--chic-secondary);
        }
        
        .empty-content {
            margin: 40px 0;
            text-align: center;
            padding: 40px;
            background: #f8fafc;
            border-radius: 12px;
            border: 2px dashed #e2e8f0;
        }
        
        .file-icon {
            font-size: 64px;
            color: #cbd5e1;
            margin-bottom: 20px;
        }
        
        .empty-text {
            font-size: 18px;
            color: var(--text-light);
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .btn-create-content {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: var(--shadow-card);
        }
        
        .btn-create-content:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
            background: #0f172a;
        }
        
        .guide-container {
            background: var(--chic-primary);
            border-radius: 16px;
            padding: 32px;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .guide-container::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }
        
        .guide-title {
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 5px;
        }
        
        .guide-subtitle {
            color: #94a3b8;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .guide-list {
            list-style: none;
            margin-bottom: 30px;
        }
        
        .guide-item {
            display: flex;
            gap: 15px;
            margin-bottom: 24px;
            align-items: flex-start;
        }
        
        .guide-number {
            background: rgba(255,255,255,0.1);
            color: var(--chic-secondary);
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            flex-shrink: 0;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .guide-content h4 {
            color: white;
            margin-bottom: 3px;
            font-size: 16px;
            font-weight: 600;
        }
        
        .guide-content p {
            color: #cbd5e1;
            line-height: 1.4;
            font-size: 13px;
        }
        
        .motivation-box {
            background: rgba(255,255,255,0.08);
            padding: 20px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .motivation-text {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #fbbf24;
        }
        
        .motivation-box p:last-child {
            color: #e2e8f0;
            font-size: 13px;
        }
        
        /* Quick Actions */
        .quick-actions-section {
            padding: 0 40px 40px;
            background: #fafafa;
        }
        
        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--chic-primary);
            margin-bottom: 30px;
            padding-left: 20px;
            border-left: 4px solid var(--chic-secondary);
        }
        
        .action-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }
        
        .action-card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: var(--shadow-soft);
            transition: all 0.3s;
            border: 1px solid #f1f5f9;
            text-align: center;
        }
        
        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
            border-color: #cbd5e1;
        }
        
        .action-icon {
            font-size: 32px;
            margin-bottom: 20px;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        
        .green .action-icon { background: #ecfdf5; color: #059669; }
        .yellow .action-icon { background: #fffbeb; color: #b45309; }
        .turquoise .action-icon { background: #ecfeff; color: #0891b2; }
        .purple .action-icon { background: #fdf4ff; color: #9333ea; }
        
        .action-card h3 {
            font-size: 18px;
            color: var(--chic-primary);
            margin-bottom: 12px;
            font-weight: 600;
        }
        
        .action-card p {
            color: var(--text-light);
            line-height: 1.5;
            margin-bottom: 24px;
            font-size: 14px;
        }
        
        .action-btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            background: #f8fafc;
            color: var(--chic-primary);
            border: 1px solid #e2e8f0;
            text-decoration: none;
            display: inline-block;
        }
        
        .action-card:hover .action-btn {
            background: var(--chic-primary);
            color: white;
            border-color: var(--chic-primary);
        }
        
        /* Cultural Rules & Community */
        .cultural-rules {
            background: white;
            border-radius: 20px;
            padding: 40px;
            margin: 40px;
            box-shadow: var(--shadow-card);
            border: 1px solid #e2e8f0;
        }
        
        .rules-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--chic-primary);
            margin-bottom: 25px;
            text-align: center;
        }
        
        .rules-list {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
        }
        
        .rule-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 12px;
            transition: all 0.3s;
        }
        
        .rule-item:hover {
            background: #eff6ff;
        }
        
        .rule-icon {
            color: var(--chic-secondary);
            font-size: 24px;
            margin-top: 2px;
        }
        
        .community-section {
            padding: 60px 40px;
            background: var(--chic-primary);
            margin: 40px;
            border-radius: 20px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .community-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .community-section .section-title {
            color: white;
            border-left: none;
            padding-left: 0;
            margin-bottom: 10px;
            font-size: 32px;
        }
        
        .community-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-top: 40px;
            position: relative;
            z-index: 10;
        }
        
        .community-stat {
            text-align: center;
            padding: 24px;
            background: rgba(255,255,255,0.1);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.1);
        }
        
        .community-stat i {
            font-size: 32px;
            color: #fbbf24;
            margin-bottom: 16px;
        }
        
        .community-stat h3 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .community-stat p {
            color: #cbd5e1;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* Footer */
        .culture-footer {
            text-align: center;
            padding: 40px;
            background: var(--chic-primary);
            color: #94a3b8;
            margin-top: 60px;
            font-size: 14px;
            border-top: 1px solid #334155;
        }
        
        @media (max-width: 1200px) {
            .stats-section,
            .action-cards {
                grid-template-columns: repeat(2, 1fr);
            }
            .content-guide-section {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .stats-section,
            .action-cards,
            .community-stats,
            .rules-list {
                grid-template-columns: 1fr;
            }
            .culture-header {
                flex-direction: column;
                gap: 20px;
            }
            .culture-nav {
                flex-wrap: wrap;
                justify-content: center;
                background: transparent;
            }
        }
        /* Book List Styles */
        .books-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 30px;
        }
        
        .book-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: var(--shadow-soft);
            overflow: hidden;
            display: grid;
            grid-template-columns: 140px 1fr;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }
        
        .book-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-hover);
            border-color: var(--chic-secondary);
        }
        
        .book-image {
            background: var(--chic-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            min-height: 180px;
        }
        
        .book-image i {
            font-size: 40px;
            color: rgba(255,255,255,0.2);
        }
        
        .rank-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: var(--chic-secondary);
            color: white;
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 12px;
        }
        
        .book-details {
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        
        .book-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            color: var(--chic-primary);
            margin-bottom: 8px;
            font-weight: 700;
            line-height: 1.3;
        }
        
        .book-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 13px;
            margin-bottom: 12px;
            color: var(--text-light);
        }
        
        .book-meta span {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .book-meta i {
            color: var(--chic-secondary);
        }
        
        .rating {
            color: #fbbf24;
            font-size: 12px;
        }
        
        .book-plot {
            font-size: 13px;
            color: var(--text-light);
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .card-actions {
            margin-top: auto;
            display: flex;
            gap: 10px;
        }
        
        .btn-offer {
            /* flex: 1; */
            background: var(--chic-secondary);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            text-align: center;
        }
        
        .btn-offer:hover { background: #d97706; }
        
        @media (max-width: 768px) {
            .book-card { grid-template-columns: 1fr; }
            .book-image { height: 150px; min-height: 0; }
        }
    </style>
</head>
<body>
    <div class="culture-container">
        <!-- Header -->
        <header class="culture-header">
            <div class="logo-container">
                <div class="culture-logo">
                    <i class="fas fa-landmark"></i>
                </div>
                <div class="site-title">
                    <h1>CULTURE BENIN</h1>
                    <p>Patrimoine Culturel National</p>
                </div>
            </div>
            
            <nav class="culture-nav">
                <a href="{{ route('client.contenus.manage') }}" class="nav-link">Contenus</a>
                <a href="#" class="nav-link">Médias</a>
                <a href="#" class="nav-link">Régions</a>
                <a href="#" class="nav-link">Langues</a>
                <a href="#" class="nav-link">Contact</a>
            </nav>
            
            <div class="header-buttons">
                <a href="{{ route('client.dashboard') }}" class="btn-dashboard">
                    <i class="fas fa-tachometer-alt"></i> Tableau de Bord
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </header>

        {{-- Messages Flash de Succès/Erreur --}}
        @if(session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 20px; margin: 20px 40px; border-radius: 12px; border-left: 4px solid #10b981; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1); display: flex; align-items: center; gap: 15px; animation: slideIn 0.3s ease;">
                <i class="fas fa-check-circle" style="font-size: 24px;"></i>
                <div>
                    <strong style="display: block; margin-bottom: 4px;">Succès !</strong>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div style="background: #fee2e2; color: #991b1b; padding: 20px; margin: 20px 40px; border-radius: 12px; border-left: 4px solid #ef4444; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.1); display: flex; align-items: center; gap: 15px; animation: slideIn 0.3s ease;">
                <i class="fas fa-exclamation-circle" style="font-size: 24px;"></i>
                <div>
                    <strong style="display: block; margin-bottom: 4px;">Erreur</strong>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <style>
            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>

        <!-- Stats Section -->
        <section class="stats-section">
            <!-- Contenus Card -->
            <div class="stat-card stat-blue">
                <div class="stat-number">{{ $stats['contents'] }}</div>
                <h3 class="stat-title">Contenus Publiés</h3>
                <p class="stat-desc">Articles, livres et documents disponibles.</p>
                <div class="stat-actions">
                    <a href="{{ route('client.contenus.manage') }}" class="btn-manage" style="text-decoration: none;">Voir</a>
                    <a href="{{ route('client.contenus.manage') }}" class="stat-link">Voir tout <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <!-- Médias Card -->
            <div class="stat-card stat-yellow">
                <div class="stat-number">{{ $stats['medias'] }}</div>
                <h3 class="stat-title">MEDIAS NUMERIQUES</h3>
                <p class="stat-desc">Images et vidéos de la culture béninoise.</p>
                <div class="stat-actions">
                    <a href="{{ route('client.media.index') }}" class="btn-view" style="color: #b45309; background: #fffbeb;">Voir</a>
                    <a href="{{ route('client.media.index') }}" class="stat-link" style="color: #b45309;">Galerie <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <!-- Utilisateurs Card -->
            <div class="stat-card" style="border-top: 4px solid #ec4899;">
                <div class="stat-number" style="color: #ec4899;">{{ $stats['users'] ?? 0 }}</div>
                <h3 class="stat-title">Utilisateurs</h3>
                <p class="stat-desc">Membres de la communauté.</p>
                <div class="stat-actions">
                    <a href="{{ route('client.users.index') }}" class="btn-view" style="color: #be185d; background: #fce7f3;">Voir</a>
                    <a href="{{ route('client.users.index') }}" class="stat-link" style="color: #ec4899;">Annuaire <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <!-- Langues Card -->
            <div class="stat-card" style="border-top: 4px solid #8b5cf6;">
                <div class="stat-number" style="color: #8b5cf6;">{{ $stats['languages'] ?? 0 }}</div>
                <h3 class="stat-title">Langues</h3>
                <p class="stat-desc">Langues nationales répertoriées.</p>
                <div class="stat-actions">
                    <a href="{{ route('client.languages.index') }}" class="btn-view" style="color: #5b21b6; background: #ede9fe;">Voir</a>
                    <a href="{{ route('client.languages.index') }}" class="stat-link" style="color: #8b5cf6;">Explorer <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>

            <!-- Régions Card -->
            <div class="stat-card stat-teal" style="background: linear-gradient(135deg, #14b8a6 0%, #0f766e 100%); color: white;">
                <div class="stat-number" style="color: white;">{{ $stats['regions'] ?? 0 }}</div>
                <h3 class="stat-title" style="color: white;">Régions</h3>
                <p class="stat-desc" style="color: rgba(255,255,255,0.8);">Départements et zones culturelles.</p>
                <div class="stat-actions">
                    <a href="{{ route('client.regions.index') }}" class="btn-view" style="color: #0f766e; background: white;">Voir</a>
                    <a href="{{ route('client.regions.index') }}" class="stat-link" style="color: white;">Découvrir <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </section>

        <!-- Recent Content & Guide -->
        <section class="content-guide-section">
            <div class="recent-content">
                <h2 class="content-title">Vos Contenus Récents</h2>
                
                <h3 style="font-size: 18px; color: var(--chic-primary); margin-bottom: 15px; font-weight: 700; border-top: 1px solid #e2e8f0; padding-top: 30px;">
                     <i class="fas fa-file-alt" style="color: var(--chic-secondary); margin-right: 8px;"></i>
                     Autres Contenus
                </h3>
                
                @if(isset($recentContents) && $recentContents->count() > 0)
                    <div class="content-list" style="display: grid; gap: 20px;">
                        @foreach($recentContents as $content)
                            <div class="content-item" style="background: #f8fafc; padding: 20px; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <h4 style="color: var(--chic-primary); font-weight: 600; margin-bottom: 5px;">{{ $content->titre }}</h4>
                                    <p style="color: var(--text-light); font-size: 13px;">{{ Str::limit(strip_tags($content->texte), 80) }}</p>
                                    <div style="margin-top: 8px;">
                                        <span style="font-size: 11px; padding: 2px 8px; border-radius: 10px; background: #e0f2fe; color: #0284c7;">
                                            {{ $content->statut }}
                                        </span>
                                        <span style="font-size: 11px; color: #94a3b8; margin-left: 10px;">Récemment</span>
                                    </div>
                                </div>
                                <a href="#" style="color: var(--chic-secondary);"><i class="fas fa-chevron-right"></i></a>
                            </div>
                        @endforeach
                    </div>
                    <div style="margin-top: 20px; text-align: center;">
                        <a href="{{ route('client.content.create') }}" class="btn-create-content" style="text-decoration: none; display: inline-block; transform: scale(0.9);">
                            <i class="fas fa-plus-circle"></i> Nouveau
                        </a>
                    </div>
                @else
                    <div class="empty-content">
                        <div class="file-icon">
                            <i class="far fa-file-alt"></i>
                        </div>
                        <p class="empty-text">Aucun contenu récent</p>
                    </div>
                @endif
            </div>
            
            <div class="guide-container">
                <h2 class="guide-title">Guide</h2>
                <p class="guide-subtitle">Comment contribuer efficacement</p>
                
                <ol class="guide-list">
                    <li class="guide-item">
                        <div class="guide-number">1</div>
                        <div class="guide-content">
                            <h4>Créez du contenu qualitatif</h4>
                            <p>Partagez des informations vérifiées sur la culture béninoise avec des sources fiables.</p>
                        </div>
                    </li>
                    <li class="guide-item">
                        <div class="guide-number">2</div>
                        <div class="guide-content">
                            <h4>Illustrez avec des médias</h4>
                            <p>Ajoutez images et vidéos personnelles pour rendre votre contenu vivant.</p>
                        </div>
                    </li>
                    <li class="guide-item">
                        <div class="guide-number">3</div>
                        <div class="guide-content">
                            <h4>Interagissez avec la communauté</h4>
                            <p>Commentez et discutez pour enrichir les échanges culturels.</p>
                        </div>
                    </li>
                    <li class="guide-item">
                        <div class="guide-number">4</div>
                        <div class="guide-content">
                            <h4>Respectez les guidelines</h4>
                            <p>Suivez les règles de contribution pour maintenir la qualité des contenus.</p>
                        </div>
                    </li>
                </ol>
                
                <div class="motivation-box">
                    <p class="motivation-text">Vous contribuez à préserver notre héritage !</p>
                    <p>Chaque contribution enrichit notre patrimoine culturel collectif.</p>
                </div>
            </div>
        </section>

        <!-- Quick Actions -->
        <section class="quick-actions-section">
            <h2 class="section-title">Actions rapides</h2>
            
            <div class="action-cards">
                <div class="action-card green">
                    <div class="action-icon">
                        <i class="far fa-file-alt"></i>
                    </div>
                    <h3>Nouveau Contenu</h3>
                    <p>Créez et publiez un nouvel article ou document culturel sur le patrimoine béninois.</p>
                    <a href="#" class="action-btn">Créer maintenant</a>
                </div>
                
                <div class="action-card yellow">
                    <div class="action-icon">
                        <i class="fas fa-upload"></i>
                    </div>
                    <h3>Uploader Média</h3>
                    <p>Partagez des images, vidéos ou documents pour illustrer le patrimoine culturel.</p>
                    <a href="#" class="action-btn">Uploader</a>
                </div>
                
                <div class="action-card turquoise">
                    <div class="action-icon">
                        <i class="fas fa-globe-africa"></i>
                    </div>
                    <h3>Explorer</h3>
                    <p>Découvrez les contenus et médias partagés par la communauté culturelle.</p>
                    <a href="{{ route('home') }}" class="action-btn">Visiter le site</a>
                </div>
                
                <div class="action-card purple">
                    <div class="action-icon">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <h3>Paramètres</h3>
                    <p>Gérez votre compte et vos préférences de contribution culturelle.</p>
                    <a href="{{ route('profile.edit') }}" class="action-btn">Mon compte</a>
                </div>
            </div>
        </section>

        <!-- Cultural Rules -->
        <section class="cultural-rules">
            <h2 class="rules-title">Règles de contribution culturelle</h2>
            <div class="rules-list">
                <div class="rule-item">
                    <i class="fas fa-check-circle rule-icon"></i>
                    <div>
                        <h4>Authenticité & Rigueur</h4>
                        <p>Assurez-vous de la véracité des faits historiques. Privilégiez les sources vérifiées.</p>
                    </div>
                </div>
                <div class="rule-item">
                    <i class="fas fa-check-circle rule-icon"></i>
                    <div>
                        <h4>Respect du Patrimoine</h4>
                        <p>Adoptez un ton respectueux envers les traditions et les communautés.</p>
                    </div>
                </div>
                <div class="rule-item">
                    <i class="fas fa-check-circle rule-icon"></i>
                    <div>
                        <h4>Propriété Intellectuelle</h4>
                        <p>Ne partagez que des médias dont vous possédez les droits ou qui sont libres.</p>
                    </div>
                </div>
                <div class="rule-item">
                    <i class="fas fa-check-circle rule-icon"></i>
                    <div>
                        <h4>Qualité Rédactionnelle</h4>
                        <p>Soignez l'orthographe et la structure de vos articles pour une lecture agréable.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- New Community Section -->
        <section class="community-section">
            <h2 class="section-title">Communauté Culturelle</h2>
            <p style="color: #cbd5e1; margin-bottom: 20px;">Rejoignez les discussions, donnez votre avis et collaborez avec d'autres passionnés</p>
            
            <div class="community-stats">
                <div class="community-stat">
                    <i class="fas fa-heart"></i>
                    <h3>0</h3>
                    <p>Contenus aimés</p>
                </div>
                <div class="community-stat">
                    <i class="fas fa-star"></i>
                    <h3>0</h3>
                    <p>Notes données</p>
                </div>
                <div class="community-stat">
                    <i class="fas fa-comments"></i>
                    <h3>0</h3>
                    <p>Commentaires</p>
                </div>
                <div class="community-stat">
                    <i class="fas fa-users"></i>
                    <h3>0</h3>
                    <p>Membres actifs</p>
                </div>
            </div>
            
        </section>

        <!-- Footer -->
        <footer class="culture-footer">
            <div class="footer-links" style="margin-bottom: 20px;">
                <a href="#" style="color: #cbd5e1; text-decoration: none; margin: 0 10px;">Mentions Légales</a>
                <a href="#" style="color: #cbd5e1; text-decoration: none; margin: 0 10px;">Politique de Confidentialité</a>
                <a href="#" style="color: #cbd5e1; text-decoration: none; margin: 0 10px;">Contact</a>
            </div>
            <p>&copy; 2024 Culture Bénin. Tous droits réservés.</p>
        </footer>
    </div>
</body>
</html>