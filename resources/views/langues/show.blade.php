@extends('layouts.admin')

@section('title', 'Détails de la Langue')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/langues.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4 langues-container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient-langues py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-translate fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Détails de la Langue</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    {{ $langue->nom_langue }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('langues.index') }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-arrow-left me-2"></i> Retour
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Corps de la carte -->
                <div class="card-body p-4">
                    <!-- Statistiques -->
                    <div class="stats-langue mb-4">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="stat-item">
                                    <div class="stat-number">{{ $langue->contenus_count ?? 0 }}</div>
                                    <div class="stat-label">Contenus</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="stat-item">
                                    <div class="stat-number">{{ $langue->media_count ?? 0 }}</div>
                                    <div class="stat-label">Médias</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="stat-item">
                                    <div class="stat-number">{{ $langue->users_count ?? 0 }}</div> <!-- CORRIGÉ: users_count au lieu de utilisateurs_count -->
                                    <div class="stat-label">Utilisateurs</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="stat-item">
                                    <div class="stat-number">{{ $langue->parlers_count ?? 0 }}</div>
                                    <div class="stat-label">Locuteurs</div>
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
                                            <label class="form-label text-muted small">Nom de la langue</label>
                                            <div class="p-3 bg-light rounded">
                                                <strong>{{ $langue->nom_langue }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">Code ISO</label>
                                            <div class="p-3 bg-light rounded">
                                                <span class="badge badge-code-langue">{{ $langue->code_langue }}</span>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label text-muted small">Description</label>
                                            <div class="p-3 bg-light rounded min-h-100">
                                                @if($langue->description)
                                                    {{ $langue->description }}
                                                @else
                                                    <span class="text-muted">Aucune description disponible</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">Date de création</label>
                                            <div class="p-3 bg-light rounded">
                                                {{ $langue->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">Dernière modification</label>
                                            <div class="p-3 bg-light rounded">
                                                {{ $langue->updated_at->format('d/m/Y H:i') }}
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
                                        <a href="{{ route('langues.edit', $langue->id_langue) }}" class="btn btn-langue-primary">
                                            <i class="bi bi-pencil me-2"></i> Modifier la langue
                                        </a>
                                        <a href="{{ route('contenus.index') }}?langue={{ $langue->id_langue }}" class="btn btn-outline-primary">
                                            <i class="bi bi-file-text me-2"></i> Voir les contenus
                                        </a>
                                        <form action="{{ route('langues.destroy', $langue->id_langue) }}" method="POST" onsubmit="return confirmDeleteLangue({{ $langue->contenus_count ?? 0 }})">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="bi bi-trash me-2"></i> Supprimer la langue
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
                            <a href="{{ route('contenus.create') }}?langue={{ $langue->id_langue }}" class="btn btn-sm btn-primary">
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
                                            <th>Type</th>
                                            <th>Région</th>
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
                                                @if($contenu->type_contenu)
                                                    <span class="badge bg-secondary">{{ $contenu->type_contenu->nom }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($contenu->region)
                                                    <span class="badge bg-primary">{{ $contenu->region->nom_region }}</span>
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
                                                <div class="action-buttons-langues">
                                                    <a href="{{ route('contenus.show', $contenu->id_contenu) }}" 
                                                       class="action-btn-langue action-btn-info-langue" 
                                                       title="Voir">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('contenus.edit', $contenu->id_contenu) }}" 
                                                       class="action-btn-langue action-btn-warning-langue" 
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
                                <p class="text-muted">Aucun contenu associé à cette langue pour le moment.</p>
                                <a href="{{ route('contenus.create') }}?langue={{ $langue->id_langue }}" class="btn btn-primary">
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
function confirmDeleteLangue(contenusCount) {
    if (contenusCount > 0) {
        return confirm('Cette langue est associée à ' + contenusCount + ' contenu(s). Êtes-vous sûr de vouloir la supprimer ?');
    }
    return confirm('Êtes-vous sûr de vouloir supprimer cette langue ?');
}
</script>
@endsection