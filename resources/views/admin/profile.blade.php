@extends('layouts.admin')

@section('title', 'Mon Profil - Administration')

@section('content')
<style>
    .profile-wrapper {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: calc(100vh - 100px);
        padding: 2rem;
    }
    
    .profile-container {
        max-width: 1400px;
        margin: 0 auto;
    }
    
    /* Header Card */
    .profile-header {
        background: white;
        border-radius: 16px;
        padding: 0;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .profile-cover {
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
    }
    
    .profile-cover::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: 
            radial-gradient(at 40% 20%, rgba(255, 255, 255, 0.1) 0px, transparent 50%),
            radial-gradient(at 80% 0%, rgba(255, 255, 255, 0.08) 0px, transparent 50%),
            radial-gradient(at 0% 50%, rgba(255, 255, 255, 0.05) 0px, transparent 50%);
    }
    
    .profile-info {
        padding: 0 2rem 2rem;
        position: relative;
    }
    
    .profile-avatar-wrapper {
        position: relative;
        margin-top: -80px;
        margin-bottom: 1.5rem;
    }
    
    .profile-avatar {
        width: 160px;
        height: 160px;
        border-radius: 50%;
        border: 6px solid white;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        font-weight: 700;
        color: white;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        position: relative;
        z-index: 1;
    }
    
    .profile-badge {
        position: absolute;
        bottom: 10px;
        right: 10px;
        width: 40px;
        height: 40px;
        background: #10b981;
        border-radius: 50%;
        border: 4px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }
    
    .profile-name {
        font-size: 2rem;
        font-weight: 700;
        color: #18181b;
        margin-bottom: 0.5rem;
    }
    
    .profile-role {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 999px;
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }
    
    .profile-meta {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
        color: #71717a;
        font-size: 0.9375rem;
    }
    
    .profile-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .profile-meta-item i {
        color: #6366f1;
    }
    
    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--stat-color);
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }
    
    .stat-card.primary { --stat-color: #6366f1; }
    .stat-card.success { --stat-color: #10b981; }
    .stat-card.warning { --stat-color: #f59e0b; }
    .stat-card.info { --stat-color: #06b6d4; }
    
    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    
    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        background: var(--stat-bg);
        color: var(--stat-color);
    }
    
    .stat-card.primary .stat-icon { --stat-bg: rgba(99, 102, 241, 0.1); }
    .stat-card.success .stat-icon { --stat-bg: rgba(16, 185, 129, 0.1); }
    .stat-card.warning .stat-icon { --stat-bg: rgba(245, 158, 11, 0.1); }
    .stat-card.info .stat-icon { --stat-bg: rgba(6, 182, 212, 0.1); }
    
    .stat-label {
        font-size: 0.875rem;
        color: #71717a;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: #18181b;
        line-height: 1;
    }
    
    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }
    
    .card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    
    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #18181b;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .card-title i {
        color: #6366f1;
    }
    
    /* Info List */
    .info-list {
        list-style: none;
    }
    
    .info-item {
        padding: 1.25rem 0;
        border-bottom: 1px solid #e4e4e7;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 600;
        color: #71717a;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .info-label i {
        color: #6366f1;
        font-size: 1.125rem;
    }
    
    .info-value {
        font-weight: 600;
        color: #18181b;
    }
    
    /* Activity List */
    .activity-list {
        list-style: none;
    }
    
    .activity-item {
        padding: 1rem;
        border-bottom: 1px solid #e4e4e7;
        transition: all 0.2s;
    }
    
    .activity-item:hover {
        background: #f9fafb;
        border-radius: 8px;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-title {
        font-weight: 600;
        color: #18181b;
        margin-bottom: 0.25rem;
    }
    
    .activity-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.8125rem;
        color: #a1a1aa;
    }
    
    .activity-meta span {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    /* Responsive */
    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .profile-wrapper {
            padding: 1rem;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .profile-avatar {
            width: 120px;
            height: 120px;
            font-size: 3rem;
        }
        
        .profile-name {
            font-size: 1.5rem;
        }
    }
</style>

<div class="profile-wrapper">
    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-cover"></div>
            <div class="profile-info">
                <div class="profile-avatar-wrapper">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                        <div class="profile-badge">
                            <i class="bi bi-shield-check"></i>
                        </div>
                    </div>
                </div>
                
                <h1 class="profile-name">{{ $user->name }}</h1>
                
                <div class="profile-role">
                    <i class="bi bi-star-fill"></i>
                    <span>Administrateur</span>
                </div>
                
                <div class="profile-meta">
                    <div class="profile-meta-item">
                        <i class="bi bi-envelope-fill"></i>
                        <span>{{ $user->email }}</span>
                    </div>
                    <div class="profile-meta-item">
                        <i class="bi bi-calendar-check"></i>
                        <span>Membre depuis {{ $stats['membre_depuis']->format('F Y') }}</span>
                    </div>
                    <div class="profile-meta-item">
                        <i class="bi bi-clock-fill"></i>
                        <span>Dernière connexion {{ $stats['derniere_connexion']->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card primary">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Total Contenus</div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $stats['total_contenus'] }}</div>
            </div>
            
            <div class="stat-card success">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Publiés</div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-check-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $stats['contenus_publies'] }}</div>
            </div>
            
            <div class="stat-card warning">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Brouillons</div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $stats['contenus_brouillon'] }}</div>
            </div>
            
            <div class="stat-card info">
                <div class="stat-header">
                    <div>
                        <div class="stat-label">Commentaires</div>
                    </div>
                    <div class="stat-icon">
                        <i class="bi bi-chat-left-text"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $stats['total_commentaires'] }}</div>
            </div>
        </div>
        
        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Informations détaillées -->
            <div class="card">
                <h3 class="card-title">
                    <i class="bi bi-info-circle-fill"></i>
                    Informations du compte
                </h3>
                <ul class="info-list">
                    <li class="info-item">
                        <span class="info-label">
                            <i class="bi bi-person-fill"></i>
                            Nom complet
                        </span>
                        <span class="info-value">{{ $user->name }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">
                            <i class="bi bi-envelope-fill"></i>
                            Email
                        </span>
                        <span class="info-value">{{ $user->email }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">
                            <i class="bi bi-shield-check"></i>
                            Rôle
                        </span>
                        <span class="info-value">Administrateur</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">
                            <i class="bi bi-calendar-plus"></i>
                            Date d'inscription
                        </span>
                        <span class="info-value">{{ $user->created_at->format('d/m/Y à H:i') }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">
                            <i class="bi bi-clock-history"></i>
                            Dernière mise à jour
                        </span>
                        <span class="info-value">{{ $user->updated_at->diffForHumans() }}</span>
                    </li>
                    <li class="info-item">
                        <span class="info-label">
                            <i class="bi bi-check-circle-fill"></i>
                            Email vérifié
                        </span>
                        <span class="info-value">
                            @if($user->email_verified_at)
                                <span style="color: #10b981;">✓ Vérifié le {{ $user->email_verified_at->format('d/m/Y') }}</span>
                            @else
                                <span style="color: #f59e0b;">Non vérifié</span>
                            @endif
                        </span>
                    </li>
                </ul>
            </div>
            
            <!-- Dernières activités -->
            <div class="card">
                <h3 class="card-title">
                    <i class="bi bi-activity"></i>
                    Dernières activités
                </h3>
                <ul class="activity-list">
                    @forelse($dernieres_activites as $activite)
                        <li class="activity-item">
                            <div class="activity-title">{{ Str::limit($activite->titre, 40) }}</div>
                            <div class="activity-meta">
                                <span>
                                    <i class="bi bi-calendar"></i>
                                    {{ $activite->created_at ? $activite->created_at->format('d/m/Y') : 'N/A' }}
                                </span>
                                <span>
                                    <i class="bi bi-tag"></i>
                                    {{ ucfirst($activite->statut) }}
                                </span>
                            </div>
                        </li>
                    @empty
                        <li class="activity-item">
                            <div class="activity-title" style="color: #a1a1aa; text-align: center;">
                                Aucune activité récente
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
