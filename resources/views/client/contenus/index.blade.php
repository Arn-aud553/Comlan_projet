@extends('layouts.client')

@section('title', 'Découvrez nos Contenus Culturels')

@push('styles')
<style>
    /* Hero Section with Gradient */
    .hero-section {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 4rem 0 6rem;
        position: relative;
        overflow: hidden;
        margin-bottom: -3rem;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        top: -200px;
        right: -100px;
        animation: float 8s ease-in-out infinite;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        bottom: -100px;
        left: -50px;
        animation: float 6s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }

    .hero-content {
        position: relative;
        z-index: 10;
        color: white;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        animation: slideDown 0.8s ease-out;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        opacity: 0.95;
        margin-bottom: 2rem;
        animation: slideDown 0.8s ease-out 0.2s both;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Statistics Cards */
    .stats-container {
        position: relative;
        z-index: 20;
        margin-top: -2rem;
    }

    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        height: 100%;
        animation: fadeInUp 0.6s ease-out both;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .stat-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 70px;
        height: 70px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: rotate(10deg) scale(1.1);
    }

    .stat-icon-blue { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
    .stat-icon-green { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; }
    .stat-icon-orange { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; }
    .stat-icon-cyan { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); color: white; }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Filters Section */
    .filters-section {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 2rem;
        position: sticky;
        top: 20px;
    }

    .filter-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-group {
        margin-bottom: 1.5rem;
    }

    .filter-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        display: block;
    }

    .filter-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .filter-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .filter-radio {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0;
        cursor: pointer;
    }

    .filter-radio input[type="radio"] {
        width: 18px;
        height: 18px;
        accent-color: #667eea;
    }

    .btn-apply-filters {
        width: 100%;
        padding: 0.875rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        margin-top: 1rem;
    }

    .btn-apply-filters:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }

    .btn-reset-filters {
        width: 100%;
        padding: 0.875rem;
        background: white;
        color: #6b7280;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        margin-top: 0.5rem;
    }

    .btn-reset-filters:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }

    /* Content Cards */
    .content-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .content-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .content-image {
        position: relative;
        height: 240px;
        overflow: hidden;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    }

    .content-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .content-card:hover .content-image img {
        transform: scale(1.1);
    }

    .price-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-weight: 700;
        font-size: 0.875rem;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .price-free {
        background: rgba(16, 185, 129, 0.9);
        color: white;
    }

    .price-paid {
        background: rgba(245, 158, 11, 0.9);
        color: white;
    }

    .category-badge {
        position: absolute;
        bottom: 15px;
        left: 15px;
        padding: 0.375rem 0.875rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #667eea;
    }

    .content-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .content-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.75rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .content-description {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 1rem;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex: 1;
    }

    .content-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.75rem;
        color: #9ca3af;
        margin-bottom: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #f3f4f6;
    }

    .content-meta span {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .content-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    .btn-view {
        padding: 0.75rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.875rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        color: white;
    }

    .btn-buy {
        padding: 0.75rem;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.875rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .btn-buy:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
        color: white;
    }

    /* View Toggle */
    .view-toggle {
        display: flex;
        gap: 0.5rem;
        background: white;
        padding: 0.5rem;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .view-toggle-btn {
        padding: 0.5rem 1rem;
        background: transparent;
        border: none;
        border-radius: 8px;
        color: #6b7280;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .view-toggle-btn.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .empty-state-icon {
        font-size: 5rem;
        color: #e5e7eb;
        margin-bottom: 1rem;
    }

    .empty-state-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .empty-state-text {
        color: #6b7280;
        margin-bottom: 2rem;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 3rem;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
    }

    .page-link {
        padding: 0.75rem 1rem;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        color: #374151;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background: #f9fafb;
        border-color: #667eea;
        color: #667eea;
    }

    .page-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: transparent;
        color: white;
    }
    .media-type-badges {
        position: absolute;
        bottom: 50px;
        left: 15px;
        display: flex;
        gap: 8px;
        z-index: 15;
    }

    .media-type-icon {
        width: 35px;
        height: 35px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #764ba2;
        font-size: 0.9rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .media-type-icon:hover {
        transform: scale(1.15);
        background: white;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="hero-content text-center">
            <h1 class="hero-title">Découvrez Notre Collection</h1>
            <p class="hero-subtitle">Explorez des contenus culturels riches et variés du Bénin</p>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="container stats-container">
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon stat-icon-blue">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-value">{{ $contenus->total() }}</div>
                <div class="stat-label">Total des contenus</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon stat-icon-green">
                    <i class="fas fa-gift"></i>
                </div>
                <div class="stat-value">{{ $contenus->where('prix', 0)->count() }}</div>
                <div class="stat-label">Contenus gratuits</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon stat-icon-orange">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="stat-value">{{ $contenus->where('prix', '>', 0)->count() }}</div>
                <div class="stat-label">Contenus payants</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon stat-icon-cyan">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-value">{{ $contenus->lastPage() }}</div>
                <div class="stat-label">Pages disponibles</div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Filters Sidebar -->
        <div class="col-lg-3">
            <div class="filters-section">
                <h5 class="filter-title">
                    <i class="fas fa-filter"></i>
                    Filtres
                </h5>

                <form method="GET" action="{{ route('client.contenus.index') }}">
                    <!-- Search -->
                    <div class="filter-group">
                        <label class="filter-label">Recherche</label>
                        <input type="text" name="search" class="filter-input" placeholder="Rechercher..." value="{{ request('search') }}">
                    </div>

                    <!-- Price Filter -->
                    <div class="filter-group">
                        <label class="filter-label">Prix</label>
                        <label class="filter-radio">
                            <input type="radio" name="price" value="all" {{ request('price', 'all') == 'all' ? 'checked' : '' }}>
                            <span>Tous les prix</span>
                        </label>
                        <label class="filter-radio">
                            <input type="radio" name="price" value="free" {{ request('price') == 'free' ? 'checked' : '' }}>
                            <span>Gratuits seulement</span>
                        </label>
                        <label class="filter-radio">
                            <input type="radio" name="price" value="paid" {{ request('price') == 'paid' ? 'checked' : '' }}>
                            <span>Payants seulement</span>
                        </label>
                    </div>

                    <!-- Status Filter -->
                    <div class="filter-group">
                        <label class="filter-label">Statut</label>
                        <select name="status" class="filter-input">
                            <option value="">Tous les statuts</option>
                            <option value="publie" {{ request('status') == 'publie' ? 'selected' : '' }}>Publié</option>
                        </select>
                    </div>

                    <!-- Date Filter -->
                    <div class="filter-group">
                        <label class="filter-label">Date</label>
                        <select name="date" class="filter-input">
                            <option value="">Toutes les dates</option>
                            <option value="today" {{ request('date') == 'today' ? 'selected' : '' }}>Aujourd'hui</option>
                            <option value="week" {{ request('date') == 'week' ? 'selected' : '' }}>Cette semaine</option>
                            <option value="month" {{ request('date') == 'month' ? 'selected' : '' }}>Ce mois</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-apply-filters">
                        <i class="fas fa-check"></i> Appliquer les filtres
                    </button>
                    <a href="{{ route('client.contenus.index') }}" class="btn-reset-filters">
                        <i class="fas fa-redo"></i> Réinitialiser
                    </a>
                </form>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="col-lg-9">
            @if($contenus->count() > 0)
                <div class="row g-4">
                    @foreach($contenus as $contenu)
                        <div class="col-lg-4 col-md-6">
                            <div class="content-card">
                                <div class="content-image">
                                    @php
                                        $mainImage = $contenu->media->where('type_fichier', 'image')->first();
                                        $mediaTypes = $contenu->media->pluck('type_fichier')->unique();
                                    @endphp

                                    @if($mainImage)
                                        <img src="{{ asset('storage/' . $mainImage->chemin_fichier) }}" alt="{{ $contenu->titre }}">
                                    @else
                                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            <i class="fas fa-book" style="font-size: 4rem; color: white; opacity: 0.5;"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Media Type Icons -->
                                    <div class="media-type-badges" style="position: absolute; bottom: 50px; left: 15px; z-index: 15;">
                                        @include('partials.media-type-indicators', ['contenu' => $contenu])
                                    </div>
                                    
                                    @if($contenu->prix > 0)
                                        <div class="price-badge price-paid">
                                            <i class="fas fa-tag"></i> {{ number_format($contenu->prix, 0, ',', ' ') }} FCFA
                                        </div>
                                    @else
                                        <div class="price-badge price-free">
                                            <i class="fas fa-gift"></i> GRATUIT
                                        </div>
                                    @endif

                                    @if($contenu->typeContenu)
                                        <div class="category-badge">
                                            {{ $contenu->typeContenu->nom }}
                                        </div>
                                    @endif
                                </div>

                                <div class="content-body">
                                    <h3 class="content-title">{{ $contenu->titre }}</h3>
                                    <p class="content-description">{{ $contenu->description ?? 'Découvrez ce contenu culturel passionnant...' }}</p>

                                    <div class="content-meta">
                                        @if($contenu->auteur)
                                            <span>
                                                <i class="fas fa-user"></i>
                                                {{ $contenu->auteur->name }}
                                            </span>
                                        @endif
                                        <span>
                                            <i class="fas fa-calendar"></i>
                                            {{ $contenu->created_at->format('d/m/Y') }}
                                        </span>
                                    </div>

                                    <div class="content-actions">
                                        <a href="{{ route('client.contenus.detail', $contenu->id_contenu) }}" class="btn-view">
                                            <i class="fas fa-eye"></i>
                                            Voir détails
                                        </a>
                                        <a href="{{ route('client.contenus.download', $contenu->id_contenu) }}" class="btn-view" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                                            <i class="fas fa-download"></i>
                                            Télécharger
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($contenus->hasPages())
                    <div class="pagination-container">
                        {{ $contenus->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="empty-state-title">Aucun contenu trouvé</h3>
                    <p class="empty-state-text">Aucun contenu ne correspond à vos critères de recherche.</p>
                    <a href="{{ route('client.contenus.index') }}" class="btn-apply-filters" style="display: inline-block; width: auto; padding: 0.875rem 2rem;">
                        <i class="fas fa-redo"></i> Réinitialiser les filtres
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('vendor/jquery/jquery-3.7.0.min.js') }}"></script>
<script>
$(document).ready(function() {
    // Smooth scroll animations
    $('.content-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });

    // Add loading state to buttons
    $('.btn-view, .btn-buy').on('click', function() {
        const $btn = $(this);
        const originalText = $btn.html();
        $btn.html('<i class="fas fa-spinner fa-spin"></i> Chargement...');
        
        setTimeout(() => {
            $btn.html(originalText);
        }, 2000);
    });
});
</script>
@endpush