@extends('layouts.admin')

@section('title', 'Tableau de bord - Culture Bénin')

@section('content')
<style>
    /* ===== IMPORTS ===== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    
    /* ===== VARIABLES ===== */
    :root {
        --primary: #6366f1;
        --primary-dark: #4f46e5;
        --primary-light: #818cf8;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --info: #06b6d4;
        
        --bg-primary: #fafafa;
        --bg-secondary: #ffffff;
        --bg-card: #ffffff;
        --bg-hover: #f5f5f5;
        
        --text-primary: #18181b;
        --text-secondary: #71717a;
        --text-tertiary: #a1a1aa;
        
        --border: #e4e4e7;
        --border-hover: #d4d4d8;
        
        --glow: rgba(99, 102, 241, 0.1);
        --glow-strong: rgba(99, 102, 241, 0.2);
    }
    
    /* ===== RESET ===== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: var(--bg-primary);
        color: var(--text-primary);
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        overflow-x: hidden;
    }
    
    /* ===== ANIMATED BACKGROUND ===== */
    .dashboard-wrapper {
        min-height: 100vh;
        padding: 2rem;
        position: relative;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }
    
    .dashboard-wrapper::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: 
            radial-gradient(at 40% 20%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
            radial-gradient(at 80% 0%, rgba(16, 185, 129, 0.1) 0px, transparent 50%),
            radial-gradient(at 0% 50%, rgba(245, 158, 11, 0.1) 0px, transparent 50%),
            radial-gradient(at 80% 50%, rgba(6, 182, 212, 0.1) 0px, transparent 50%),
            radial-gradient(at 0% 100%, rgba(236, 72, 153, 0.1) 0px, transparent 50%),
            radial-gradient(at 80% 100%, rgba(99, 102, 241, 0.1) 0px, transparent 50%),
            radial-gradient(at 0% 0%, rgba(16, 185, 129, 0.1) 0px, transparent 50%);
        animation: backgroundShift 20s ease-in-out infinite;
        pointer-events: none;
        z-index: 0;
    }
    
    @keyframes backgroundShift {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }
    
    .dashboard-container {
        max-width: 1800px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }
    
    /* ===== HEADER ===== */
    .dashboard-header {
        margin-bottom: 3rem;
        position: relative;
    }
    
    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
    }
    
    .header-left h1 {
        font-size: 2.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ffffff 0%, #a1a1aa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }
    
    .header-left p {
        color: var(--text-secondary);
        font-size: 1.125rem;
    }
    
    .header-right {
        display: flex;
        gap: 1rem;
        align-items: center;
    }
    
    .header-btn {
        padding: 0.75rem 1.5rem;
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 12px;
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    
    .header-btn:hover {
        background: var(--primary);
        border-color: var(--primary);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px var(--glow-strong);
        text-decoration: none;
        color: white;
    }
    
    .header-btn i {
        font-size: 1rem;
    }
    
    /* ===== STATS GRID ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, var(--primary) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
        pointer-events: none;
    }
    
    .stat-card:hover {
        border-color: var(--border-hover);
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3), 0 0 0 1px var(--border-hover);
    }
    
    .stat-card:hover::before {
        opacity: 0.05;
    }
    
    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }
    
    .stat-icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    
    .stat-icon-wrapper::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--icon-color) 0%, transparent 100%);
        opacity: 0.15;
    }
    
    .stat-icon-wrapper i {
        font-size: 1.75rem;
        position: relative;
        z-index: 1;
    }
    
    .stat-card.users .stat-icon-wrapper {
        --icon-color: #6366f1;
        color: #6366f1;
    }
    
    .stat-card.regions .stat-icon-wrapper {
        --icon-color: #10b981;
        color: #10b981;
    }
    
    .stat-card.langues .stat-icon-wrapper {
        --icon-color: #f59e0b;
        color: #f59e0b;
    }
    
    .stat-card.contenus .stat-icon-wrapper {
        --icon-color: #ec4899;
        color: #ec4899;
    }
    
    .stat-card.commentaires .stat-icon-wrapper {
        --icon-color: #06b6d4;
        color: #06b6d4;
    }
    
    .stat-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }
    
    .stat-value {
        font-size: 3rem;
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1;
        margin-bottom: 1rem;
        letter-spacing: -0.03em;
    }
    
    .stat-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 1rem;
        border-top: 1px solid var(--border);
    }
    
    .stat-trend {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--success);
    }
    
    .stat-trend i {
        font-size: 0.75rem;
    }
    
    .stat-period {
        font-size: 0.75rem;
        color: var(--text-tertiary);
    }
    
    /* ===== MAIN GRID ===== */
    .main-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    /* ===== CARD ===== */
    .card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 2rem;
        transition: all 0.3s ease;
    }
    
    .card:hover {
        border-color: var(--border-hover);
    }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
    }
    
    .card-action {
        font-size: 0.875rem;
        color: var(--primary-light);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }
    
    .card-action:hover {
        color: var(--primary);
        text-decoration: none;
    }
    
    /* ===== CHART ===== */
    .chart-container {
        position: relative;
        height: 300px;
    }
    
    /* ===== ACTIVITY FEED ===== */
    .activity-list {
        list-style: none;
    }
    
    .activity-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border);
        transition: all 0.2s;
    }
    
    .activity-item:hover {
        background: rgba(255, 255, 255, 0.02);
        margin: 0 -1rem;
        padding: 1rem;
        border-radius: 8px;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        position: relative;
        overflow: hidden;
    }
    
    .activity-avatar::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--avatar-color) 0%, transparent 100%);
        opacity: 0.15;
    }
    
    .activity-avatar i {
        font-size: 1.25rem;
        position: relative;
        z-index: 1;
    }
    
    .activity-avatar.user {
        --avatar-color: #6366f1;
        color: #6366f1;
    }
    
    .activity-avatar.content {
        --avatar-color: #ec4899;
        color: #ec4899;
    }
    
    .activity-avatar.comment {
        --avatar-color: #06b6d4;
        color: #06b6d4;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-title {
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }
    
    .activity-time {
        font-size: 0.8125rem;
        color: var(--text-tertiary);
    }
    
    /* ===== QUICK ACTIONS ===== */
    .actions-grid {
        display: grid;
        gap: 0.75rem;
    }
    
    .action-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--bg-secondary);
        border: 1px solid var(--border);
        border-radius: 12px;
        text-decoration: none;
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .action-item::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--primary) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .action-item:hover {
        border-color: var(--primary);
        transform: translateX(4px);
        text-decoration: none;
        color: var(--text-primary);
    }
    
    .action-item:hover::before {
        opacity: 0.1;
    }
    
    .action-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(99, 102, 241, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-light);
        flex-shrink: 0;
        position: relative;
        z-index: 1;
    }
    
    .action-text {
        position: relative;
        z-index: 1;
    }
    
    /* ===== BOTTOM GRID ===== */
    .bottom-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 1.5rem;
    }
    
    /* ===== PROGRESS CARD ===== */
    .progress-item {
        margin-bottom: 1.5rem;
    }
    
    .progress-item:last-child {
        margin-bottom: 0;
    }
    
    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }
    
    .progress-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-primary);
    }
    
    .progress-value {
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--text-secondary);
    }
    
    .progress-bar-container {
        height: 8px;
        background: var(--bg-secondary);
        border-radius: 999px;
        overflow: hidden;
        position: relative;
    }
    
    .progress-bar {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, var(--bar-color) 0%, var(--bar-color-light) 100%);
        transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    
    .progress-bar::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.3) 50%, transparent 100%);
        animation: shimmer 2s infinite;
    }
    
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    
    /* ===== RESPONSIVE ===== */
    @media (max-width: 1200px) {
        .main-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .dashboard-wrapper {
            padding: 1rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .stat-value {
            font-size: 2.5rem;
        }
    }
    
    /* ===== ANIMATIONS ===== */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .stat-card {
        animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) backwards;
    }
    
    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }
    .stat-card:nth-child(5) { animation-delay: 0.5s; }
    
    .card {
        animation: fadeInUp 0.6s cubic-bezier(0.4, 0, 0.2, 1) backwards;
        animation-delay: 0.6s;
    }
</style>

<div class="dashboard-wrapper">
    <div class="dashboard-container">
        <!-- Header -->
        <div class="dashboard-header">
            <div class="header-content">
                <div class="header-left">
                    <h1>Dashboard</h1>
                    <p>Bienvenue, {{ Auth::user()->name }}</p>
                </div>
                <div class="header-right">
                    <a href="{{ route('admin.contenus.create') }}" class="header-btn">
                        <i class="bi bi-plus-lg"></i>
                        Nouveau contenu
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Stats Grid -->
        <div class="stats-grid">
            <!-- Users -->
            <div class="stat-card users">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Utilisateurs</div>
                    </div>
                    <div class="stat-icon-wrapper">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="stat-value counter">{{ $users_count }}</div>
                <div class="stat-footer">
                    <div class="stat-trend">
                        <i class="bi bi-arrow-up"></i>
                        <span>+12.5%</span>
                    </div>
                    <div class="stat-period">vs mois dernier</div>
                </div>
            </div>
            
            <!-- Regions -->
            <div class="stat-card regions">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Régions</div>
                    </div>
                    <div class="stat-icon-wrapper">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                </div>
                <div class="stat-value counter">{{ $regions_count }}</div>
                <div class="stat-footer">
                    <div class="stat-trend">
                        <i class="bi bi-arrow-up"></i>
                        <span>+5.2%</span>
                    </div>
                    <div class="stat-period">vs mois dernier</div>
                </div>
            </div>
            
            <!-- Langues -->
            <div class="stat-card langues">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Langues</div>
                    </div>
                    <div class="stat-icon-wrapper">
                        <i class="bi bi-translate"></i>
                    </div>
                </div>
                <div class="stat-value counter">{{ $langues_count }}</div>
                <div class="stat-footer">
                    <div class="stat-trend">
                        <i class="bi bi-arrow-up"></i>
                        <span>+8.1%</span>
                    </div>
                    <div class="stat-period">vs mois dernier</div>
                </div>
            </div>
            
            <!-- Contenus -->
            <div class="stat-card contenus">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Contenus</div>
                    </div>
                    <div class="stat-icon-wrapper">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                </div>
                <div class="stat-value counter">{{ $contenus_count }}</div>
                <div class="stat-footer">
                    <div class="stat-trend">
                        <i class="bi bi-arrow-up"></i>
                        <span>+24.3%</span>
                    </div>
                    <div class="stat-period">vs mois dernier</div>
                </div>
            </div>
            
            <!-- Commentaires -->
            <div class="stat-card commentaires">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Commentaires</div>
                    </div>
                    <div class="stat-icon-wrapper">
                        <i class="bi bi-chat-left-text"></i>
                    </div>
                </div>
                <div class="stat-value counter">{{ $commentaires_count }}</div>
                <div class="stat-footer">
                    <div class="stat-trend">
                        <i class="bi bi-arrow-up"></i>
                        <span>+18.7%</span>
                    </div>
                    <div class="stat-period">vs mois dernier</div>
                </div>
            </div>
        </div>
        
        <!-- Main Grid -->
        <div class="main-grid">
            <!-- Chart Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Activité des 30 derniers jours</h3>
                    <a href="#" class="card-action">Voir détails →</a>
                </div>
                <div class="chart-container">
                    <canvas id="mainChart"></canvas>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Actions rapides</h3>
                </div>
                <div class="actions-grid">
                    <a href="{{ route('admin.users.index') }}" class="action-item">
                        <div class="action-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <span class="action-text">Gérer les utilisateurs</span>
                    </a>
                    <a href="{{ route('admin.contenus.index') }}" class="action-item">
                        <div class="action-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <span class="action-text">Gérer les contenus</span>
                    </a>
                    <a href="{{ route('admin.langues.index') }}" class="action-item">
                        <div class="action-icon">
                            <i class="bi bi-translate"></i>
                        </div>
                        <span class="action-text">Gérer les langues</span>
                    </a>
                    <a href="{{ route('admin.regions.index') }}" class="action-item">
                        <div class="action-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <span class="action-text">Gérer les régions</span>
                    </a>
                    <a href="{{ route('admin.media.index') }}" class="action-item">
                        <div class="action-icon">
                            <i class="bi bi-image"></i>
                        </div>
                        <span class="action-text">Gérer les médias</span>
                    </a>
                    <a href="{{ route('admin.moderation.comments') }}" class="action-item">
                        <div class="action-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <span class="action-text">Modération</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Bottom Grid -->
        <div class="bottom-grid">
            <!-- Activity Feed -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Activité récente</h3>
                    <a href="#" class="card-action">Voir tout →</a>
                </div>
                <ul class="activity-list">
                    @php
                        $activities = [
                            ['type' => 'user', 'title' => 'Nouvel utilisateur inscrit', 'time' => 'Il y a 2 heures'],
                            ['type' => 'content', 'title' => 'Nouveau contenu publié', 'time' => 'Il y a 5 heures'],
                            ['type' => 'comment', 'title' => 'Nouveau commentaire posté', 'time' => 'Il y a 1 jour'],
                            ['type' => 'user', 'title' => 'Utilisateur vérifié', 'time' => 'Il y a 2 jours'],
                            ['type' => 'content', 'title' => 'Contenu modéré', 'time' => 'Il y a 3 jours'],
                        ];
                    @endphp
                    
                    @foreach($activities as $activity)
                        <li class="activity-item">
                            <div class="activity-avatar {{ $activity['type'] }}">
                                @switch($activity['type'])
                                    @case('user')
                                        <i class="bi bi-person-plus"></i>
                                        @break
                                    @case('content')
                                        <i class="bi bi-file-earmark-plus"></i>
                                        @break
                                    @case('comment')
                                        <i class="bi bi-chat-left"></i>
                                        @break
                                @endswitch
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">{{ $activity['title'] }}</div>
                                <div class="activity-time">{{ $activity['time'] }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            <!-- Performance Card -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Performance du mois</h3>
                </div>
                <div class="progress-item">
                    <div class="progress-header">
                        <span class="progress-label">Contenus publiés</span>
                        <span class="progress-value">{{ $contenus_count }}/100</span>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="width: {{ min(($contenus_count / 100) * 100, 100) }}%; --bar-color: #6366f1; --bar-color-light: #818cf8;"></div>
                    </div>
                </div>
                <div class="progress-item">
                    <div class="progress-header">
                        <span class="progress-label">Utilisateurs actifs</span>
                        <span class="progress-value">{{ $users_count }}/200</span>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="width: {{ min(($users_count / 200) * 100, 100) }}%; --bar-color: #10b981; --bar-color-light: #34d399;"></div>
                    </div>
                </div>
                <div class="progress-item">
                    <div class="progress-header">
                        <span class="progress-label">Engagement</span>
                        <span class="progress-value">{{ $commentaires_count }}/150</span>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="width: {{ min(($commentaires_count / 150) * 100, 100) }}%; --bar-color: #f59e0b; --bar-color-light: #fbbf24;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animated Counters
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.textContent);
        let current = 0;
        const increment = target / 60;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = Math.floor(current);
        }, 16);
    });
    
    // Main Chart
    const ctx = document.getElementById('mainChart');
    if (ctx) {
        const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.3)');
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'],
                datasets: [{
                    label: 'Contenus',
                    data: [30, 45, 38, 55, 48, 65, 58, 72, 68, 85, 78, 92],
                    borderColor: '#6366f1',
                    backgroundColor: gradient,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#6366f1',
                    pointBorderColor: '#0a0a0f',
                    pointBorderWidth: 3,
                    pointRadius: 5,
                    pointHoverRadius: 7,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1a1a24',
                        titleColor: '#ffffff',
                        bodyColor: '#a1a1aa',
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            title: function(context) {
                                return context[0].label;
                            },
                            label: function(context) {
                                return context.parsed.y + ' contenus';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.04)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#71717a',
                            font: {
                                size: 12
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#71717a',
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }
});
</script>
@endsection