@extends('layouts.client')

@section('title', 'Contenus Culturels')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/client-contenus.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
    /* Styles personnalisés pour la page des contenus */
    .card-header-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .icon-wrapper {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .table-contenus {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    
    .table-contenus thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .table-contenus th {
        border: none;
        padding: 15px;
        font-weight: 600;
    }
    
    .table-contenus tbody tr {
        transition: all 0.3s ease;
    }
    
    .table-contenus tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .badge-contenu {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .badge-region { background-color: #e3f2fd; color: #1976d2; }
    .badge-langue { background-color: #f3e5f5; color: #7b1fa2; }
    .badge-type { background-color: #e8f5e9; color: #388e3c; }
    
    .badge-statut {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    
    .badge-publie { background-color: #d4edda; color: #155724; }
    .badge-attente { background-color: #fff3cd; color: #856404; }
    .badge-valide { background-color: #d1ecf1; color: #0c5460; }
    .badge-rejete { background-color: #f8d7da; color: #721c24; }
    .badge-brouillon { background-color: #e2e3e5; color: #383d41; }
    
    .action-buttons {
        display: flex;
        gap: 5px;
    }
    
    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .action-btn-info { background-color: #e3f2fd; color: #1976d2; }
    .action-btn-warning { background-color: #fff3cd; color: #ffc107; }
    .action-btn-danger { background-color: #f8d7da; color: #dc3545; border: none; }
    
    .action-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .truncate-text {
        max-width: 300px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
        position: relative;
    }
    
    .truncate-text:hover::after {
        content: attr(data-fulltext);
        position: absolute;
        left: 0;
        top: 100%;
        background: white;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        z-index: 1000;
        max-width: 400px;
        white-space: normal;
        word-wrap: break-word;
    }
    
    .date-validation {
        font-size: 0.85rem;
        color: #666;
    }
    
    .auteur-info {
        font-size: 0.9rem;
        color: #555;
    }
    
    .filtres-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    
    .contenu-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .contenu-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    
    .price-tag {
        position: absolute;
        top: 15px;
        right: 15px;
        z-index: 2;
    }
    
    .card-img-top-container {
        height: 200px;
        overflow: hidden;
        position: relative;
    }
    
    .card-img-top-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .category-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 2;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4 contenu-container">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header card-header-gradient py-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-book-fill fs-2"></i>
                            </div>
                            <div>
                                <h1 class="h2 mb-1">Contenus Culturels</h1>
                                <p class="mb-0 opacity-75">
                                    Découvrez notre collection de livres, articles et médias culturels
                                </p>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('client.dashboard') }}" class="btn btn-light btn-sm d-flex align-items-center">
                                <i class="bi bi-arrow-left me-2"></i>
                                Tableau de bord
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-primary border-3 h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col me-2">
                            <div class="text-xs fw-bold text-primary mb-1">Total des contenus</div>
                            <div class="h5 mb-0 fw-bold">{{ $contenus->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-book fs-1 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-success border-3 h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col me-2">
                            <div class="text-xs fw-bold text-success mb-1">Contenus gratuits</div>
                            <div class="h5 mb-0 fw-bold">{{ $contenus->where('prix', 0)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-currency-euro fs-1 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-warning border-3 h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col me-2">
                            <div class="text-xs fw-bold text-warning mb-1">Contenus payants</div>
                            <div class="h5 mb-0 fw-bold">{{ $contenus->where('prix', '>', 0)->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-currency-euro fs-1 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-info border-3 h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col me-2">
                            <div class="text-xs fw-bold text-info mb-1">Pages disponibles</div>
                            <div class="h5 mb-0 fw-bold">{{ $contenus->lastPage() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-file-text fs-1 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="row">
        <div class="col-lg-3">
            <!-- Filtres latéraux -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filtres</h5>
                </div>
                <div class="card-body">
                    <!-- Recherche -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Recherche</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light">
                                <i class="bi bi-search text-secondary"></i>
                            </span>
                            <input type="text" class="form-control" id="searchInput" placeholder="Rechercher...">
                        </div>
                    </div>
                    
                    <!-- Filtre par prix -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Prix</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input price-filter" type="radio" name="priceFilter" id="priceAll" value="" checked>
                            <label class="form-check-label" for="priceAll">
                                Tous les prix
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input price-filter" type="radio" name="priceFilter" id="priceFree" value="free">
                            <label class="form-check-label" for="priceFree">
                                Gratuits seulement
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input price-filter" type="radio" name="priceFilter" id="pricePaid" value="paid">
                            <label class="form-check-label" for="pricePaid">
                                Payants seulement
                            </label>
                        </div>
                    </div>
                    
                    <!-- Filtre par statut -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Statut</label>
                        <select class="form-select form-select-sm" id="statusFilter">
                            <option value="">Tous les statuts</option>
                            <option value="publié">Publié</option>
                            <option value="en attente">En attente</option>
                            <option value="validé">Validé</option>
                            <option value="brouillon">Brouillon</option>
                        </select>
                    </div>
                    
                    <!-- Filtre par date -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Date</label>
                        <select class="form-select form-select-sm" id="dateFilter">
                            <option value="">Toutes les dates</option>
                            <option value="today">Aujourd'hui</option>
                            <option value="week">Cette semaine</option>
                            <option value="month">Ce mois</option>
                            <option value="year">Cette année</option>
                        </select>
                    </div>
                    
                    <!-- Boutons filtres -->
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" id="applyFilters">
                            <i class="bi bi-check-circle me-1"></i> Appliquer les filtres
                        </button>
                        <button class="btn btn-outline-secondary" id="resetFilters">
                            <i class="bi bi-arrow-clockwise me-1"></i> Réinitialiser
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Catégories -->
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0"><i class="bi bi-tags me-2"></i>Catégories</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category-filter" data-category="all">
                            Toutes les catégories
                            <span class="badge bg-primary rounded-pill">{{ $contenus->total() }}</span>
                        </a>
                        @if(isset($categories) && $categories->count() > 0)
                            @foreach($categories as $category)
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center category-filter" data-category="{{ $category->id }}">
                                    {{ $category->nom }}
                                    <span class="badge bg-secondary rounded-pill">{{ $category->contenus_count ?? 0 }}</span>
                                </a>
                            @endforeach
                        @else
                            <div class="alert alert-info py-2">
                                <small><i class="bi bi-info-circle me-1"></i> Aucune catégorie disponible</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <!-- Barre d'actions -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary active" data-view="grid">
                                <i class="bi bi-grid-3x3-gap"></i> Grille
                            </button>
                            <button type="button" class="btn btn-outline-primary" data-view="list">
                                <i class="bi bi-list-ul"></i> Liste
                            </button>
                        </div>
                        <div class="d-flex gap-2">
                            <select class="form-select form-select-sm" id="sortSelect" style="width: auto;">
                                <option value="recent">Plus récents</option>
                                <option value="oldest">Plus anciens</option>
                                <option value="title_asc">A-Z</option>
                                <option value="title_desc">Z-A</option>
                                <option value="price_asc">Prix croissant</option>
                                <option value="price_desc">Prix décroissant</option>
                            </select>
                            <select class="form-select form-select-sm" id="perPageSelect" style="width: auto;">
                                <option value="12">12 par page</option>
                                <option value="24">24 par page</option>
                                <option value="48">48 par page</option>
                                <option value="96">96 par page</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenus (vue grille) -->
            <div id="gridView" class="row">
                @forelse($contenus as $contenu)
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4 contenu-item" 
                         data-title="{{ strtolower($contenu->titre) }}"
                         data-price="{{ $contenu->prix }}"
                         data-status="{{ $contenu->statut }}"
                         data-category="{{ $contenu->id_type_contenu ?? '' }}"
                         data-date="{{ $contenu->date_creation }}">
                        <div class="card contenu-card h-100">
                            <div class="position-relative">
                                <div class="card-img-top-container">
                                    @if($contenu->media && $contenu->media->first() && in_array($contenu->media->first()->type_fichier, ['image', 'photo']))
                                        <img src="{{ asset('storage/' . $contenu->media->first()->chemin_fichier) }}" 
                                             alt="{{ $contenu->titre }}" 
                                             class="card-img-top">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                            <i class="bi bi-book fs-1 text-secondary"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="price-tag">
                                    @if($contenu->prix > 0)
                                        <span class="badge bg-warning fs-6 px-3 py-2">
                                            <i class="bi bi-currency-euro"></i> {{ number_format($contenu->prix, 2) }}
                                        </span>
                                    @else
                                        <span class="badge bg-success fs-6 px-3 py-2">GRATUIT</span>
                                    @endif
                                </div>
                                <div class="category-badge">
                                    @if($contenu->typeContenu)
                                        <span class="badge bg-info">
                                            {{ $contenu->typeContenu->nom }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title" style="height: 3rem; overflow: hidden;">
                                    {{ Str::limit($contenu->titre, 50) }}
                                </h5>
                                <p class="card-text text-muted small" style="height: 4rem; overflow: hidden;">
                                    {{ Str::limit(strip_tags($contenu->texte), 120) }}
                                </p>
                                <div class="mb-3">
                                    @if($contenu->region)
                                        <span class="badge bg-primary badge-region me-1">
                                            {{ $contenu->region->nom_region }}
                                        </span>
                                    @endif
                                    @if($contenu->langue)
                                        <span class="badge bg-secondary badge-langue me-1">
                                            {{ $contenu->langue->nom_langue }}
                                        </span>
                                    @endif
                                    <span class="badge-statut {{ $contenu->statut == 'publié' ? 'badge-publie' : ($contenu->statut == 'en attente' ? 'badge-attente' : 'badge-brouillon') }}">
                                        {{ $contenu->statut }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar"></i> 
                                        {{ \Carbon\Carbon::parse($contenu->date_creation)->format('d/m/Y') }}
                                    </small>
                                    @if($contenu->auteur)
                                        <small class="text-muted">
                                            <i class="bi bi-person"></i> 
                                            {{ Str::limit($contenu->auteur->name, 10) }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0 pt-0">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('client.contenus.detail', $contenu->id_contenu) }}" 
                                       class="btn btn-primary">
                                        <i class="bi bi-eye me-1"></i> Voir détails
                                    </a>
                                    @if($contenu->prix > 0)
                                        <a href="{{ route('client.contenus.paiement', $contenu->id_contenu) }}" 
                                           class="btn btn-outline-warning">
                                            <i class="bi bi-cart me-1"></i> Acheter
                                        </a>
                                    @else
                                        <a href="{{ route('client.contenus.detail', $contenu->id_contenu) }}" 
                                           class="btn btn-outline-success">
                                            <i class="bi bi-download me-1"></i> Télécharger
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="bi bi-book fs-1 text-muted mb-3"></i>
                                <h4>Aucun contenu disponible</h4>
                                <p class="text-muted">Aucun contenu n'a été publié pour le moment.</p>
                                <a href="{{ route('client.dashboard') }}" class="btn btn-primary">
                                    <i class="bi bi-arrow-left me-1"></i> Retour au tableau de bord
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Contenus (vue liste - cachée par défaut) -->
            <div id="listView" class="d-none">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="contenusTable">
                                <thead>
                                    <tr>
                                        <th>Titre</th>
                                        <th>Type</th>
                                        <th>Région</th>
                                        <th>Langue</th>
                                        <th>Prix</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contenus as $contenu)
                                        <tr>
                                            <td>
                                                <strong>{{ $contenu->titre }}</strong>
                                                <div class="text-muted small">
                                                    {{ Str::limit(strip_tags($contenu->texte), 100) }}
                                                </div>
                                            </td>
                                            <td>
                                                @if($contenu->typeContenu)
                                                    <span class="badge bg-info">
                                                        {{ $contenu->typeContenu->nom }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($contenu->region)
                                                    {{ $contenu->region->nom_region }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($contenu->langue)
                                                    {{ $contenu->langue->nom_langue }}
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($contenu->prix > 0)
                                                    <span class="badge bg-warning">
                                                        {{ number_format($contenu->prix, 2) }} €
                                                    </span>
                                                @else
                                                    <span class="badge bg-success">Gratuit</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge-statut {{ $contenu->statut == 'publié' ? 'badge-publie' : ($contenu->statut == 'en attente' ? 'badge-attente' : 'badge-brouillon') }}">
                                                    {{ $contenu->statut }}
                                                </span>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($contenu->date_creation)->format('d/m/Y') }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('client.contenus.detail', $contenu->id_contenu) }}" 
                                                       class="btn btn-outline-primary" title="Voir">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    @if($contenu->prix > 0)
                                                        <a href="{{ route('client.contenus.paiement', $contenu->id_contenu) }}" 
                                                           class="btn btn-outline-warning" title="Acheter">
                                                            <i class="bi bi-cart"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if($contenus->hasPages())
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">
                                            Affichage de {{ $contenus->firstItem() }} à {{ $contenus->lastItem() }} 
                                            sur {{ $contenus->total() }} contenus
                                        </small>
                                    </div>
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center mb-0">
                                            <!-- Previous Page Link -->
                                            @if($contenus->onFirstPage())
                                                <li class="page-item disabled">
                                                    <span class="page-link">
                                                        <i class="bi bi-chevron-left"></i>
                                                    </span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $contenus->previousPageUrl() }}">
                                                        <i class="bi bi-chevron-left"></i>
                                                    </a>
                                                </li>
                                            @endif

                                            <!-- Pagination Elements -->
                                            @for($i = 1; $i <= $contenus->lastPage(); $i++)
                                                <li class="page-item {{ $contenus->currentPage() == $i ? 'active' : '' }}">
                                                    <a class="page-link" href="{{ $contenus->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endfor

                                            <!-- Next Page Link -->
                                            @if($contenus->hasMorePages())
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $contenus->nextPageUrl() }}">
                                                        <i class="bi bi-chevron-right"></i>
                                                    </a>
                                                </li>
                                            @else
                                                <li class="page-item disabled">
                                                    <span class="page-link">
                                                        <i class="bi bi-chevron-right"></i>
                                                    </span>
                                                </li>
                                            @endif
                                        </ul>
                                    </nav>
                                    <div>
                                        <small class="text-muted">
                                            Page {{ $contenus->currentPage() }} sur {{ $contenus->lastPage() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    // Initialiser DataTable pour la vue liste
    $('#contenusTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
        },
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        responsive: true,
        autoWidth: false,
        order: [[6, 'desc']], // Tri par date par défaut
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
    });

    // Basculer entre les vues grille et liste
    $('[data-view="grid"]').on('click', function() {
        $(this).addClass('active').siblings().removeClass('active');
        $('#gridView').removeClass('d-none');
        $('#listView').addClass('d-none');
    });

    $('[data-view="list"]').on('click', function() {
        $(this).addClass('active').siblings().removeClass('active');
        $('#listView').removeClass('d-none');
        $('#gridView').addClass('d-none');
    });

    // Filtrage côté client
    $('#applyFilters').on('click', function() {
        applyFilters();
    });

    $('#resetFilters').on('click', function() {
        resetFilters();
    });

    function applyFilters() {
        const searchTerm = $('#searchInput').val().toLowerCase();
        const priceFilter = $('input[name="priceFilter"]:checked').val();
        const statusFilter = $('#statusFilter').val();
        const dateFilter = $('#dateFilter').val();
        const selectedCategory = $('.category-filter.active').data('category');

        $('.contenu-item').each(function() {
            const $item = $(this);
            const title = $item.data('title');
            const price = parseFloat($item.data('price'));
            const status = $item.data('status');
            const category = $item.data('category');
            const date = new Date($item.data('date'));
            const today = new Date();

            // Vérifier chaque condition de filtre
            let show = true;

            // Filtre par recherche
            if (searchTerm && !title.includes(searchTerm)) {
                show = false;
            }

            // Filtre par prix
            if (priceFilter === 'free' && price > 0) {
                show = false;
            } else if (priceFilter === 'paid' && price <= 0) {
                show = false;
            }

            // Filtre par statut
            if (statusFilter && status !== statusFilter) {
                show = false;
            }

            // Filtre par catégorie
            if (selectedCategory && selectedCategory !== 'all' && category != selectedCategory) {
                show = false;
            }

            // Filtre par date
            if (dateFilter) {
                const diffTime = Math.abs(today - date);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                if (dateFilter === 'today' && !isToday(date)) {
                    show = false;
                } else if (dateFilter === 'week' && diffDays > 7) {
                    show = false;
                } else if (dateFilter === 'month' && diffDays > 30) {
                    show = false;
                } else if (dateFilter === 'year' && diffDays > 365) {
                    show = false;
                }
            }

            // Afficher ou cacher l'élément
            $item.toggle(show);
        });

        // Mettre à jour le compteur
        updateItemCount();
    }

    function resetFilters() {
        $('#searchInput').val('');
        $('#priceAll').prop('checked', true);
        $('#statusFilter').val('');
        $('#dateFilter').val('');
        $('.category-filter').removeClass('active');
        $('.category-filter[data-category="all"]').addClass('active');
        
        $('.contenu-item').show();
        updateItemCount();
    }

    function isToday(date) {
        const today = new Date();
        return date.getDate() === today.getDate() &&
               date.getMonth() === today.getMonth() &&
               date.getFullYear() === today.getFullYear();
    }

    function updateItemCount() {
        const visibleItems = $('.contenu-item:visible').length;
        const totalItems = $('.contenu-item').length;
        
        if (visibleItems === 0) {
            $('#gridView').append(`
                <div class="col-12" id="noResults">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-search fs-1 text-muted mb-3"></i>
                            <h4>Aucun résultat trouvé</h4>
                            <p class="text-muted">Aucun contenu ne correspond à vos critères de recherche.</p>
                            <button class="btn btn-primary" onclick="resetFilters()">
                                <i class="bi bi-arrow-clockwise me-1"></i> Réinitialiser les filtres
                            </button>
                        </div>
                    </div>
                </div>
            `);
        } else {
            $('#noResults').remove();
        }
    }

    // Filtrage par catégorie
    $('.category-filter').on('click', function(e) {
        e.preventDefault();
        $('.category-filter').removeClass('active');
        $(this).addClass('active');
        applyFilters();
    });

    // Recherche en temps réel
    $('#searchInput').on('keyup', function(e) {
        if (e.key === 'Enter') {
            applyFilters();
        }
    });

    // Tri
    $('#sortSelect').on('change', function() {
        const sortBy = $(this).val();
        const $container = $('#gridView');
        const $items = $('.contenu-item');

        $items.sort(function(a, b) {
            const $a = $(a);
            const $b = $(b);

            switch (sortBy) {
                case 'recent':
                    return new Date($b.data('date')) - new Date($a.data('date'));
                case 'oldest':
                    return new Date($a.data('date')) - new Date($b.data('date'));
                case 'title_asc':
                    return $a.data('title').localeCompare($b.data('title'));
                case 'title_desc':
                    return $b.data('title').localeCompare($a.data('title'));
                case 'price_asc':
                    return parseFloat($a.data('price')) - parseFloat($b.data('price'));
                case 'price_desc':
                    return parseFloat($b.data('price')) - parseFloat($a.data('price'));
                default:
                    return 0;
            }
        }).appendTo($container);
    });

    // Changer le nombre d'éléments par page
    $('#perPageSelect').on('change', function() {
        // Ici vous devriez recharger la page avec le nouveau paramètre
        // Pour l'instant, nous allons simplement simuler
        const perPage = $(this).val();
        alert(`Changement du nombre d'éléments par page à ${perPage}. Cette fonctionnalité nécessite un rechargement de la page.`);
        // window.location.href = window.location.pathname + '?per_page=' + perPage;
    });

    // Tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush