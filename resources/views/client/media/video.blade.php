@extends('layouts.client')

@section('title', 'Vidéothèque Culturelle')

@push('styles')
<style>
    /* Premium Video Library Styles */
    .video-hero {
        background: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.9)), 
                    url('https://images.unsplash.com/photo-1485846234645-a62644f84728?auto=format&fit=crop&q=80&w=2059');
        background-size: cover;
        background-position: center;
        padding: 6rem 0;
        margin-top: -2rem;
        border-radius: 0 0 50px 50px;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .video-hero::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 150px;
        background: linear-gradient(to top, var(--bg-body), transparent);
    }

    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        background: linear-gradient(to right, #fff, #94a3b8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: fadeInDown 0.8s ease-out;
    }

    .video-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        padding: 2rem 0;
    }

    .video-card {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .video-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.4);
        border-color: rgba(37, 99, 235, 0.4);
    }

    .video-thumbnail {
        position: relative;
        height: 170px;
        overflow: hidden;
    }

    .video-thumbnail video {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .video-card:hover .video-thumbnail video {
        transform: scale(1.1);
    }

    .play-overlay {
        position: absolute;
        inset: 0;
        background: rgba(15, 23, 42, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .video-card:hover .play-overlay {
        opacity: 1;
        background: rgba(15, 23, 42, 0.6);
    }

    .play-btn-circle {
        width: 60px;
        height: 60px;
        background: var(--chic-secondary, #2563eb);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        transform: scale(0.8);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .video-card:hover .play-btn-circle {
        transform: scale(1);
        box-shadow: 0 0 30px rgba(37, 99, 235, 0.6);
    }

    .video-info {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        color: #1e293b;
        background: white;
    }

    .video-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .video-meta {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.85rem;
        color: #64748b;
        margin-top: auto;
    }

    .premium-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
        z-index: 10;
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush

@section('content')
<div class="video-hero">
    <div class="container">
        <h1 class="hero-title">Vidéothèque Culturelle</h1>
        <p class="lead opacity-75">Plongez dans l'héritage vivant à travers le regard de nos cinéastes</p>
    </div>
</div>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <a href="{{ route('client.dashboard') }}" class="btn-dashboard" style="background: white; color: var(--primary); border: 1px solid var(--border-subtle);">
            <i class="fas fa-arrow-left me-2"></i> Tableau de bord
        </a>
        <div class="text-muted">
            <i class="fas fa-film me-2"></i> {{ $videos->total() }} vidéos disponibles
        </div>
    </div>

    @if($videos->isEmpty())
        <div class="text-center py-5">
            <div class="empty-state-icon">
                <i class="fas fa-video-slash"></i>
            </div>
            <h3 class="mt-4">Silence sur le plateau</h3>
            <p class="text-muted">Aucune vidéo n'est disponible pour le moment.</p>
        </div>
    @else
        <div class="video-grid">
            @foreach($videos as $video)
                <a href="{{ route('client.media.detail', ['id' => $video->id_media ?? $video->id]) }}" class="text-decoration-none">
                    <div class="video-card">
                        @if($video->prix && $video->prix > 0)
                            <div class="premium-badge">
                                <i class="fas fa-star me-1"></i> PREMIUM
                            </div>
                        @endif
                        
                        <div class="video-thumbnail">
                            <video muted onmouseover="this.play()" onmouseout="this.pause(); this.currentTime = 0;">
                                <source src="{{ asset('storage/' . $video->chemin_fichier) }}" type="{{ $video->mime_type }}">
                            </video>
                            <div class="play-overlay">
                                <div class="play-btn-circle">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        </div>

                        <div class="video-info">
                            <h3 class="video-title text-dark">
                                {{ $video->titre ?? $video->contenu->titre ?? pathinfo($video->nom_fichier, PATHINFO_FILENAME) }}
                            </h3>
                            <p class="text-muted small mb-4">
                                {{ Str::limit(strip_tags($video->description ?? $video->contenu->texte ?? 'Une exploration visuelle unique de notre culture.'), 100) }}
                            </p>
                            
                            <div class="video-meta">
                                <span><i class="far fa-clock me-1"></i> {{ $video->created_at->diffForHumans() }}</span>
                                @if($video->prix && $video->prix > 0)
                                    <span class="ms-auto fw-bold text-primary">{{ number_format($video->prix, 0, ',', ' ') }} FCFA</span>
                                @else
                                    <span class="ms-auto badge bg-success bg-opacity-10 text-success">GRATUIT</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $videos->links() }}
        </div>
    @endif
</div>
@endsection

