@extends('layouts.admin')

@section('title', 'Gestion des Types de Contenu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/type_contenus.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4 types-contenus-container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient-types-contenus py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-tags fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Gestion des Types de Contenu</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    {{ $typesContenu->total() }} types de contenu au total
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('type_contenus.create') }}" class="btn btn-primary btn-sm d-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i>
                                <span>Nouveau Type</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Corps de la carte -->
                <div class="card-body p-4">
                    <!-- Section Filtres - EXACTEMENT COMME COMMENTAIRE -->
                    <div class="filtres-section-types-contenus mb-4">
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="filterTexte" class="form-label">
                                            <i class="bi bi-search me-1"></i> Recherche
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-search text-primary"></i>
                                            </span>
                                            <input type="text" id="filterTexte" class="form-control shadow-none" placeholder="Nom du type de contenu...">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="filterStatut" class="form-label">
                                            <i class="bi bi-funnel me-1"></i> Filtre
                                        </label>
                                        <select id="filterStatut" class="form-select shadow-none">
                                            <option value="">Tous les types</option>
                                            <option value="avec">Avec contenus</option>
                                            <option value="sans">Sans contenu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button id="resetFilters" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                        <i class="bi bi-arrow-clockwise me-2"></i>
                                        Réinitialiser
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table DataTable -->
                    <div class="table-responsive">
                        <table id="typesContenusTable" class="table table-types-contenus">
                            <thead>
                                <tr>
                                    <th width="5%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-hash me-2"></i> ID
                                        </div>
                                    </th>
                                    <th width="40%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-tag me-2"></i> Nom du Type
                                        </div>
                                    </th>
                                    <th width="20%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-files me-2"></i> Contenus Associés
                                        </div>
                                    </th>
                                    <th width="20%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-calendar me-2"></i> Date de Création
                                        </div>
                                    </th>
                                    <th width="15%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-gear me-2"></i> Actions
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($typesContenu as $type)
                                <tr>
                                    <td>
                                        <span class="badge bg-dark rounded-pill px-3 py-2">
                                            #{{ str_pad($type->id_type_contenu, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="type-icon me-2">
                                                <i class="bi bi-tag-fill text-primary"></i>
                                            </div>
                                            <div>
                                                <strong class="d-block">{{ $type->nom }}</strong>
                                                <small class="text-muted">ID: {{ $type->id_type_contenu }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-search="{{ $type->contenus_count }}">
                                        @if($type->contenus_count > 0)
                                            <span class="badge badge-type-contenu badge-contenus">
                                                <i class="bi bi-file-text me-1"></i>
                                                {{ $type->contenus_count }} contenu(s)
                                            </span>
                                            <button class="btn btn-sm btn-outline-info ms-2 btn-view-contenus" 
                                                    data-id="{{ $type->id_type_contenu }}"
                                                    data-nom="{{ $type->nom }}"
                                                    title="Voir les contenus">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        @else
                                            <span class="badge bg-secondary">Aucun contenu</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="small">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                {{ $type->created_at->format('d/m/Y') }}
                                            </span>
                                            <span class="text-muted smaller">
                                                {{ $type->created_at->format('H:i') }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons-types-contenus">
                                            <a href="{{ route('type_contenus.show', $type->id_type_contenu) }}" 
                                               class="action-btn-type-contenu action-btn-info-type-contenu" 
                                               title="Voir les détails" 
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('type_contenus.edit', $type->id_type_contenu) }}" 
                                               class="action-btn-type-contenu action-btn-warning-type-contenu" 
                                               title="Modifier" 
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('type_contenus.destroy', $type->id_type_contenu) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce type de contenu ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="action-btn-type-contenu action-btn-danger-type-contenu" 
                                                        title="Supprimer" 
                                                        data-bs-toggle="tooltip">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
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
    </div>
</div>

<!-- Modal pour voir les contenus -->
<div class="modal fade" id="contenusModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header card-header-gradient-types-contenus">
                <h5 class="modal-title text-white">
                    <i class="bi bi-file-text me-2"></i>
                    <span id="modalTitle">Contenus associés</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContenusBody">
                <!-- Contenu chargé via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i> Fermer
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- LE SCRIPT EXACTEMENT COMME COMMENTAIRE (voir ci-dessus) -->
<script>
$(document).ready(function() {
    // ... (le script exact comme montré plus haut)
});
</script>
@endpush