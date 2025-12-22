@extends('layouts.client')

@section('title', 'Avis des Utilisateurs - Médiathèque')

@push('styles')
<style>
    .reviews-hero {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        padding: 4rem 2rem;
        border-radius: 30px;
        color: white;
        margin-bottom: 3rem;
        text-align: center;
        box-shadow: 0 20px 40px rgba(217, 119, 6, 0.2);
    }

    .reviews-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
    }

    .review-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        border: 1px solid var(--border-subtle);
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .review-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .review-user {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .user-avatar {
        width: 48px;
        height: 48px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-weight: 700;
        font-size: 1.2rem;
    }

    .user-info {
        flex: 1;
    }

    .user-name {
        font-weight: 600;
        color: var(--text-main);
        font-size: 1rem;
    }

    .review-date {
        font-size: 0.8rem;
        color: var(--text-secondary);
    }

    .rating-stars {
        color: #f59e0b;
        display: flex;
        gap: 2px;
    }

    .review-text {
        color: var(--text-main);
        line-height: 1.6;
        font-style: italic;
    }

    .review-content-link {
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid var(--border-subtle);
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
        color: var(--primary);
        font-weight: 500;
    }

    .content-badge {
        background: var(--bg-body);
        padding: 4px 12px;
        border-radius: 10px;
        font-size: 0.8rem;
        color: var(--text-secondary);
    }
</style>
@endpush

@section('content')
<div class="container py-4">
    <div class="reviews-hero">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 3rem; margin-bottom: 1rem;">La Voix de notre Communauté</h1>
        <p style="font-size: 1.2rem; opacity: 0.9;">Découvrez les avis et appréciations partagés par les membres de notre médiathèque.</p>
    </div>

    @if($reviews->count() > 0)
        <div class="reviews-grid">
            @foreach($reviews as $review)
                <div class="review-card">
                    <div class="review-user">
                        <div class="user-avatar">
                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ $review->user->name }}</div>
                            <div class="review-date">{{ $review->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->note ? 'fas' : 'far' }} fa-star"></i>
                            @endfor
                        </div>
                    </div>
                    
                    <div class="review-text">
                        "{{ $review->texte }}"
                    </div>

                    @if($review->contenu)
                        <a href="{{ route('client.contenus.detail', $review->id_contenu) }}" class="review-content-link">
                            <span><i class="fas fa-book-open"></i> {{ Str::limit($review->contenu->titre, 30) }}</span>
                            <span class="content-badge">Voir le contenu</span>
                        </a>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $reviews->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="far fa-comments fa-4x mb-4" style="color: var(--border-subtle);"></i>
            <h3>Aucun avis pour le moment</h3>
            <p class="text-muted">Soyez le premier à partager votre expérience !</p>
            <a href="{{ route('client.contenus.index') }}" class="btn btn-primary mt-3">Explorer le contenu</a>
        </div>
    @endif
</div>
@endsection
