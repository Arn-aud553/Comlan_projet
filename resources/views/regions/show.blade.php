@extends('layouts.admin')

@section('title', 'Détails de la Région')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/regions.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4 regions-container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient-regions py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-geo-alt fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Détails de la Région</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    {{ $region->nom_region }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('regions.index') }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-arrow-left me-2"></i> Retour
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Corps de la carte -->
                <div class="card-body p-4">
                    <!-- Statistiques -->
                    <div class="stats-region mb-4">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="stat-item-region">
                                    <div class="stat-number-region">{{ $region->contenus_count }}</div>
                                    <div class="stat-label-region">Contenus associés</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informations détaillées -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informations Générales</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">Nom de la région</label>
                                            <div class="p-3 bg-light rounded">
                                                <strong>{{ $region->nom_region }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">Code région</label>
                                            <div class="p-3 bg-light rounded">
                                                <span class="badge badge-nom-region">ID: {{ $region->id_region }}</span>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label text-muted small">Description</label>
                                            <div class="p-3 bg-light rounded min-h-100">
                                                @if($region->description)
                                                    {{ $region->description }}
                                                @else
                                                    <span class="text-muted">Aucune description disponible</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">Date de création</label>
                                            <div class="p-3 bg-light rounded">
                                                {{ $region->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">Dernière modification</label>
                                            <div class="p-3 bg-light rounded">
                                                {{ $region->updated_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Actions Rapides</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('regions.edit', $region->id_region) }}" class="btn btn-region-primary">
                                            <i class="bi bi-pencil me-2"></i> Modifier la région
                                        </a>
                                        <a href="{{ route('contenus.index') }}?region={{ $region->id_region }}" class="btn btn-outline-primary">
                                            <i class="bi bi-file-text me-2"></i> Voir les contenus
                                        </a>
                                        <form action="{{ route('regions.destroy', $region->id_region) }}" method="POST" onsubmit="return confirmDeleteRegion({{ $region->contenus_count }})">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="bi bi-trash me-2"></i> Supprimer la région
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contenus associés -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="bi bi-file-text me-2"></i>Contenus Associés ({{ $contenus->total() }})</h6>
                            <a href="{{ route('contenus.create') }}?region={{ $region->id_region }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Ajouter un contenu
                            </a>
                        </div>
                        <div class="card-body">
                            @if($contenus->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Titre</th>
                                            <th>Langue</th>
                                            <th>Type</th>
                                            <th>Statut</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contenus as $contenu)
                                        <tr>
                                            <td>
                                                <strong>{{ Str::limit($contenu->titre, 40) }}</strong>
                                            </td>
                                            <td>
                                                @if($contenu->langue)
                                                    <span class="badge bg-info">{{ $contenu->langue->nom_langue }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($contenu->type_contenu)
                                                    <span class="badge bg-secondary">{{ $contenu->type_contenu->nom }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $badgeClass = 'bg-secondary';
                                                    if($contenu->statut == 'publié') $badgeClass = 'bg-success';
                                                    if($contenu->statut == 'en attente') $badgeClass = 'bg-warning';
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ $contenu->statut }}</span>
                                            </td>
                                            <td>
                                                <small>{{ $contenu->created_at->format('d/m/Y') }}</small>
                                            </td>
                                            <td>
                                                <div class="action-buttons-regions">
                                                    <a href="{{ route('contenus.show', $contenu->id_contenu) }}" 
                                                       class="action-btn-region action-btn-info-region" 
                                                       title="Voir">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('contenus.edit', $contenu->id_contenu) }}" 
                                                       class="action-btn-region action-btn-warning-region" 
                                                       title="Modifier">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Pagination -->
                            @if($contenus->hasPages())
                            <div class="mt-3">
                                {{ $contenus->links('vendor.pagination.bootstrap-5') }}
                            </div>
                            @endif
                            
                            @else
                            <div class="text-center py-4">
                                <i class="bi bi-file-text display-4 text-muted mb-3"></i>
                                <p class="text-muted">Aucun contenu associé à cette région pour le moment.</p>
                                <a href="{{ route('contenus.create') }}?region={{ $region->id_region }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i> Créer le premier contenu
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDeleteRegion(contenusCount) {
    if (contenusCount > 0) {
        return confirm('Cette région est associée à ' + contenusCount + ' contenu(s). Êtes-vous sûr de vouloir la supprimer ?');
    }
    return confirm('Êtes-vous sûr de vouloir supprimer cette région ?');
}
</script>
@endsection