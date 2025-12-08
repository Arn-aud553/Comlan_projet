@extends('layouts.admin')

@section('title', 'Tableau de bord - Culture Bénin')

@section('content')
<style>
    /* Styles spécifiques au dashboard */
    .dashboard-wrapper {
        background-color: #f8f9fa;
        min-height: calc(100vh - 130px);
        padding: 20px;
    }
    
    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .dashboard-header {
        background: linear-gradient(135deg, #2c3e50 0%, #4a6491 100%);
        color: white;
        padding: 30px;
        position: relative;
    }
    
    .dashboard-header h1 {
        font-size: 2.5rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .dashboard-header h1 i {
        font-size: 2.2rem;
    }
    
    .dashboard-header .subtitle {
        margin-top: 10px;
        opacity: 0.9;
        font-size: 1.1rem;
    }
    
    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        padding: 30px;
        background: #f8f9fa;
    }
    
    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-left: 4px solid;
        display: flex;
        align-items: center;
        justify-content: space-between;
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
        transform: translateY(20px);
    }
    
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .stat-card:hover {
        transform: translateY(-5px) !important;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }
    
    .stat-card.users { border-left-color: #3498db; }
    .stat-card.regions { border-left-color: #2ecc71; }
    .stat-card.langues { border-left-color: #9b59b6; }
    .stat-card.contenus { border-left-color: #e74c3c; }
    .stat-card.commentaires { border-left-color: #f39c12; }
    
    .stat-info h3 {
        margin: 0 0 8px 0;
        font-size: 1rem;
        color: #6c757d;
        font-weight: 500;
    }
    
    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #2c3e50;
        line-height: 1;
    }
    
    .stat-icon {
        font-size: 3rem;
        opacity: 0.2;
        color: #2c3e50;
    }
    
    .stat-card.users .stat-icon { color: #3498db; }
    .stat-card.regions .stat-icon { color: #2ecc71; }
    .stat-card.langues .stat-icon { color: #9b59b6; }
    .stat-card.contenus .stat-icon { color: #e74c3c; }
    .stat-card.commentaires .stat-icon { color: #f39c12; }
    
    .dashboard-content {
        padding: 40px 30px;
    }
    
    .welcome-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 10px;
        padding: 40px;
        text-align: center;
        border: 1px solid #e0e0e0;
        margin-bottom: 30px;
    }
    
    .welcome-card h2 {
        color: #2c3e50;
        margin-bottom: 15px;
        font-size: 1.8rem;
    }
    
    .welcome-card p {
        color: #5a6c7d;
        font-size: 1.1rem;
        line-height: 1.6;
        max-width: 700px;
        margin: 0 auto;
    }
    
    .welcome-icon {
        font-size: 4rem;
        color: #3498db;
        margin-bottom: 20px;
        opacity: 0.8;
    }
    
    .recent-activity {
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        margin-top: 30px;
    }
    
    .recent-activity h3 {
        color: #2c3e50;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .activity-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .activity-item {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: background-color 0.2s ease;
    }
    
    .activity-item:hover {
        background-color: #f8f9fa;
        border-radius: 8px;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    
    .activity-icon.user { background: #3498db; }
    .activity-icon.content { background: #e74c3c; }
    .activity-icon.comment { background: #f39c12; }
    .activity-icon.langue { background: #9b59b6; }
    .activity-icon.region { background: #2ecc71; }
    
    .activity-details {
        flex: 1;
    }
    
    .activity-details h4 {
        margin: 0 0 5px 0;
        font-size: 1rem;
        color: #2c3e50;
    }
    
    .activity-time {
        font-size: 0.85rem;
        color: #95a5a6;
    }
    
    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 30px;
    }
    
    .action-btn {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
        text-decoration: none;
        color: #2c3e50;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
    
    .action-btn:hover {
        background: #3498db;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
        text-decoration: none;
    }
    
    .action-btn i {
        font-size: 2rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-stats {
            grid-template-columns: 1fr;
        }
        
        .dashboard-header {
            padding: 20px;
        }
        
        .dashboard-header h1 {
            font-size: 2rem;
        }
        
        .stat-card {
            padding: 20px;
        }
        
        .stat-value {
            font-size: 2rem;
        }
        
        .quick-actions {
            grid-template-columns: 1fr;
        }
    }
    
    /* Animation for counters */
    .counter {
        display: inline-block;
    }
</style>

@php
// Récupérer les statistiques depuis les variables passées par le controller
$users_count = $users_count ?? 0;
$regions_count = $regions_count ?? 0;
$langues_count = $langues_count ?? 0;
$contenus_count = $contenus_count ?? 0;
$commentaires_count = $commentaires_count ?? 0;
@endphp

<div class="dashboard-wrapper">
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>
                <i class="bi bi-speedometer2"></i>
                Tableau de bord
            </h1>
            <p class="subtitle">
                Statistiques et aperçu de votre plateforme culturelle
            </p>
        </div>
        
        <div class="dashboard-stats">
            <!-- Carte Utilisateurs -->
            <div class="stat-card users" style="animation-delay: 0.1s;">
                <div class="stat-info">
                    <h3>Utilisateurs</h3>
                    <div class="stat-value counter" id="users-counter">{{ $users_count }}</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            
            <!-- Carte Régions -->
            <div class="stat-card regions" style="animation-delay: 0.2s;">
                <div class="stat-info">
                    <h3>Régions</h3>
                    <div class="stat-value counter" id="regions-counter">{{ $regions_count }}</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-geo-alt-fill"></i>
                </div>
            </div>
            
            <!-- Carte Langues -->
            <div class="stat-card langues" style="animation-delay: 0.3s;">
                <div class="stat-info">
                    <h3>Langues</h3>
                    <div class="stat-value counter" id="langues-counter">{{ $langues_count }}</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-translate"></i>
                </div>
            </div>
            
            <!-- Carte Contenus -->
            <div class="stat-card contenus" style="animation-delay: 0.4s;">
                <div class="stat-info">
                    <h3>Contenus</h3>
                    <div class="stat-value counter" id="contenus-counter">{{ $contenus_count }}</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
            </div>
            
            <!-- Carte Commentaires -->
            <div class="stat-card commentaires" style="animation-delay: 0.5s;">
                <div class="stat-info">
                    <h3>Commentaires</h3>
                    <div class="stat-value counter" id="commentaires-counter">{{ $commentaires_count }}</div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-chat-left-text"></i>
                </div>
            </div>
        </div>
        
        <div class="dashboard-content">
            <div class="welcome-card">
                <div class="welcome-icon">
                    <i class="bi bi-house-door"></i>
                </div>
                <h2>Bienvenue dans l'administration</h2>
                <p>Utilisez le menu de gauche pour gérer les différentes sections de votre plateforme culturelle. Vous pouvez ajouter, modifier et supprimer des contenus, gérer les utilisateurs, les langues, les régions et les commentaires.</p>
            </div>
            
            <!-- Quick Actions -->
            <div class="quick-actions">
                <a href="{{ route('admin.users.index') }}" class="action-btn">
                    <i class="bi bi-people-fill text-primary"></i>
                    <span>Gérer les utilisateurs</span>
                </a>
                <a href="{{ route('admin.contenus.index') }}" class="action-btn">
                    <i class="bi bi-file-earmark-text text-danger"></i>
                    <span>Gérer les contenus</span>
                </a>
                <a href="{{ route('admin.langues.index') }}" class="action-btn">
                    <i class="bi bi-translate text-purple"></i>
                    <span>Gérer les langues</span>
                </a>
                <a href="{{ route('admin.regions.index') }}" class="action-btn">
                    <i class="bi bi-geo-alt-fill text-success"></i>
                    <span>Gérer les régions</span>
                </a>
                <a href="{{ route('admin.moderation.comments') }}" class="action-btn">
                    <i class="bi bi-chat-left-text text-warning"></i>
                    <span>Gérer les commentaires</span>
                </a>
            </div>
            
            <!-- Section Activité récente -->
            <div class="recent-activity">
                <h3>
                    <i class="bi bi-clock-history"></i>
                    Activité récente
                </h3>
                <div class="activity-list">
                    @php
                        // Récupérer les dernières activités (exemples)
                        $activities = [
                            ['type' => 'user', 'title' => 'Nouvel utilisateur inscrit', 'time' => 'Il y a 2 heures'],
                            ['type' => 'content', 'title' => 'Nouveau contenu ajouté', 'time' => 'Il y a 5 heures'],
                            ['type' => 'comment', 'title' => 'Nouveau commentaire posté', 'time' => 'Il y a 1 jour'],
                            ['type' => 'langue', 'title' => 'Nouvelle langue ajoutée', 'time' => 'Il y a 2 jours'],
                            ['type' => 'region', 'title' => 'Nouvelle région ajoutée', 'time' => 'Il y a 3 jours'],
                        ];
                    @endphp
                    
                    @foreach($activities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon {{ $activity['type'] }}">
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
                                    @case('langue')
                                        <i class="bi bi-translate"></i>
                                        @break
                                    @case('region')
                                        <i class="bi bi-geo-alt"></i>
                                        @break
                                @endswitch
                            </div>
                            <div class="activity-details">
                                <h4>{{ $activity['title'] }}</h4>
                                <div class="activity-time">{{ $activity['time'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Animation pour les compteurs
document.addEventListener('DOMContentLoaded', function() {
    // Animation d'entrée pour les cartes de statistiques
    const statCards = document.querySelectorAll('.stat-card');
    
    statCards.forEach((card, index) => {
        setTimeout(() => {
            card.style.animation = 'fadeInUp 0.5s ease forwards';
        }, index * 100);
    });
    
    // Optionnel: Animation pour les compteurs (si tu veux qu'ils comptent de 0 à la valeur)
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
        const target = parseInt(counter.textContent);
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            counter.textContent = Math.floor(current);
        }, 20);
    });
    
    // Ajouter des styles pour les couleurs des icônes d'actions rapides
    const style = document.createElement('style');
    style.textContent = `
        .text-purple { color: #9b59b6; }
        .action-btn:hover .text-primary,
        .action-btn:hover .text-danger,
        .action-btn:hover .text-purple,
        .action-btn:hover .text-success,
        .action-btn:hover .text-warning {
            color: white !important;
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection