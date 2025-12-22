@extends('layouts.client')

@section('title', 'Studio Musical & Audios')

@push('styles')
<style>
    /* Premium Audio Studio Styles */
    .audio-hero {
        background: linear-gradient(135deg, #831843 0%, #4c0519 100%);
        padding: 5rem 0;
        margin-top: -2rem;
        border-radius: 0 0 40px 40px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .audio-hero::before {
        content: '';
        position: absolute;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        top: -100px;
        right: -100px;
    }

    .hero-title {
        font-family: 'Playfair Display', serif;
        font-size: 3rem;
        font-weight: 800;
        letter-spacing: -1px;
    }

    .audio-container {
        max-width: 1100px;
        margin: -3rem auto 4rem;
        padding: 0 1rem;
    }

    .audio-card-list {
        background: white;
        border-radius: 30px;
        padding: 2rem;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .audio-track {
        display: grid;
        grid-template-columns: 80px 1fr auto;
        align-items: center;
        gap: 1.5rem;
        padding: 1.25rem;
        border-radius: 20px;
        transition: all 0.3s ease;
        margin-bottom: 0.75rem;
        border: 1px solid transparent;
    }

    .audio-track:hover {
        background: #f8fafc;
        border-color: #e2e8f0;
        transform: scale(1.01);
    }

    .track-artwork {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #db2777 0%, #9d174d 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.75rem;
        box-shadow: 0 8px 16px rgba(219, 39, 119, 0.2);
    }

    .track-info {
        min-width: 0;
    }

    .track-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .track-meta {
        font-size: 0.85rem;
        color: #64748b;
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .track-player {
        margin-top: 0.75rem;
        width: 100%;
        height: 32px;
    }

    /* Custom Audio Player Styling for Chrome/Safari */
    .track-player::-webkit-media-controls-panel {
        background-color: #f1f5f9;
    }

    .track-actions {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .btn-play-now {
        width: 45px;
        height: 45px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-play-now:hover {
        background: #db2777;
        color: white;
        box-shadow: 0 4px 12px rgba(219, 39, 119, 0.3);
    }

    .price-tag {
        background: rgba(219, 39, 119, 0.1);
        color: #db2777;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .empty-music {
        text-align: center;
        padding: 6rem 2rem;
        color: #94a3b8;
    }

    .empty-music i {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }
</style>
@endpush

@section('content')
<div class="audio-hero">
    <div class="container text-center">
        <h1 class="hero-title mb-3">Studio Musical</h1>
        <p class="lead opacity-75">Écoutez la voix du Bénin, entre tradition et modernité</p>
    </div>
</div>

<div class="audio-container">
    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <a href="{{ route('client.dashboard') }}" class="btn-dashboard" style="background: white; color: var(--primary); border: 1px solid var(--border-subtle); box-shadow: none;">
            <i class="fas fa-arrow-left me-2"></i> Tableau de bord
        </a>
        <div class="badge bg-white text-dark py-2 px-3 rounded-pill shadow-sm border">
            {{ $audios->total() }} morceaux
        </div>
    </div>

    @if($audios->isEmpty())
        <div class="audio-card-list">
            <div class="empty-music">
                <i class="fas fa-music"></i>
                <h3>Partition vide</h3>
                <p>Aucun fichier audio n'a encore été ajouté à la bibliothèque.</p>
            </div>
        </div>
    @else
        <div class="audio-card-list">
            @foreach($audios as $audio)
                <div class="audio-track shadow-sm">
                    <div class="track-artwork">
                        <i class="fas fa-headphones-alt"></i>
                    </div>
                    
                    <div class="track-info">
                        <h3 class="track-title">{{ $audio->titre ?? $audio->contenu->titre ?? 'Melodie Sans Nom' }}</h3>
                        <div class="track-meta">
                            <span><i class="fas fa-microphone-alt me-1"></i> {{ $audio->contenu->auteur->nom ?? 'Artiste Inconnu' }}</span>
                            <span><i class="far fa-calendar-alt me-1"></i> {{ $audio->created_at->format('d M Y') }}</span>
                            @if($audio->prix && $audio->prix > 0)
                                <span class="price-tag">{{ number_format($audio->prix, 0, ',', ' ') }} FCFA</span>
                            @else
                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill">GRATUIT</span>
                            @endif
                        </div>
                        <audio controls class="track-player" controlsList="nodownload">
                            <source src="{{ asset('storage/' . $audio->chemin_fichier) }}" type="{{ $audio->mime_type }}">
                        </audio>
                    </div>

                    <div class="track-actions">
                        <a href="{{ route('client.media.detail', ['id' => $audio->id_media ?? $audio->id]) }}" class="btn-play-now" title="Détails du média">
                            <i class="fas fa-info-circle"></i>
                        </a>
                    </div>
                </div>
            @endforeach

            <div class="mt-5 d-flex justify-content-center">
                {{ $audios->links() }}
            </div>
        </div>
    @endif
</div>
@endsection

