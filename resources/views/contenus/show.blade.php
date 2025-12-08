@extends('layouts.admin')

@section('title', 'Détails du Contenu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/contenus.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4 contenus-container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient-contenus py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-file-text fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Détails du Contenu</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    {{ $contenu->titre }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('contenus.index') }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-arrow-left me-2"></i> Retour
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Corps de la carte -->
                <div class="card-body p-4">
                    <!-- Statistiques -->
                    <div class="stats-contenu mb-4">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="stat-item">
                                    <div class="stat-number">{{ $contenu->media_count ?? 0 }}</div>
                                    <div class="stat-label">Médias</div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="stat-item">
                                    <div class="stat-number">{{ $contenu->commentaires_count ?? 0 }}</div>
                                    <div class="stat-label">Commentaires</div>
                                </div>
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <div class="stat-item">
                                    @php
                                        $badgeClass = 'bg-secondary';
                                        if($contenu->statut == 'publié') $badgeClass = 'bg-success';
                                        if($contenu->statut == 'en attente') $badgeClass = 'bg-warning';
                                        if($contenu->statut == 'rejeté') $badgeClass = 'bg-danger';
                                    @endphp
                                    <div class="stat-number">
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst($contenu->statut) }}</span>
                                    </div>
                                    <div class="stat-label">Statut</div>
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
                                        <div class="col-12 mb-3">
                                            <label class="form-label text-muted small">Titre</label>
                                            <div class="p-3 bg-light rounded">
                                                <strong>{{ $contenu->titre }}</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">Auteur</label>
                                            <div class="p-3 bg-light rounded">
                                                @if($contenu->auteur)
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-person-circle me-2"></i>
                                                    <span>{{ $contenu->auteur->name }}</span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">Modérateur</label>
                                            <div class="p-3 bg-light rounded">
                                                @if($contenu->moderateur)
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-shield-check me-2"></i>
                                                    <span>{{ $contenu->moderateur->name }}</span>
                                                </div>
                                                @else
                                                <span class="text-muted">Non modéré</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label text-muted small">Langue</label>
                                            <div class="p-3 bg-light rounded">
                                                @if($contenu->langue)
                                                    <span class="badge badge-langue">{{ $contenu->langue->nom_langue }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label text-muted small">Région</label>
                                            <div class="p-3 bg-light rounded">
                                                @if($contenu->region)
                                                    <span class="badge badge-region">{{ $contenu->region->nom_region }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label text-muted small">Type</label>
                                            <div class="p-3 bg-light rounded">
                                                @if($contenu->typeContenu)
                                                    <span class="badge badge-type">{{ $contenu->typeContenu->nom }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">Date de création</label>
                                            <div class="p-3 bg-light rounded">
                                                <i class="bi bi-calendar-plus me-2"></i>
                                                {{ $contenu->date_creation->format('d/m/Y H:i') }}
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label text-muted small">Date de validation</label>
                                            <div class="p-3 bg-light rounded">
                                                @if($contenu->date_validation)
                                                <i class="bi bi-check-circle me-2 text-success"></i>
                                                {{ $contenu->date_validation->format('d/m/Y H:i') }}
                                                @else
                                                <span class="text-muted">Non validé</span>
                                                @endif
                                            </div>
                                        </div>
                                        @if($contenu->parent)
                                        <div class="col-12 mb-3">
                                            <label class="form-label text-muted small">Contenu parent</label>
                                            <div class="p-3 bg-light rounded">
                                                <a href="{{ route('contenus.show', $contenu->parent->id_contenu) }}">
                                                    <i class="bi bi-arrow-up me-2"></i>
                                                    {{ $contenu->parent->titre }}
                                                </a>
                                            </div>
                                        </div>
                                        @endif
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
                                        <a href="{{ route('contenus.edit', $contenu->id_contenu) }}" class="btn btn-contenu-primary">
                                            <i class="bi bi-pencil me-2"></i> Modifier
                                        </a>
                                        @if(in_array(Auth::user()->role, ['moderateur', 'admin']) && $contenu->peutEtreValide())
                                        <form action="{{ route('contenus.valider', $contenu->id_contenu) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="bi bi-check-circle me-2"></i> Valider et publier
                                            </button>
                                        </form>
                                        @endif
                                        <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#changeStatutModal">
                                            <i class="bi bi-arrow-repeat me-2"></i> Changer statut
                                        </button>
                                      <form action="{{ route('contenus.destroy', $contenu->id_contenu) }}" method="POST" onsubmit="return confirmDeleteContenu({{ $contenu->media_count ?? 0 }}, {{ $contenu->commentaires_count ?? 0 }})">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="bi bi-trash me-2"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contenu textuel -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-text-paragraph me-2"></i>Contenu</h6>
                        </div>
                        <div class="card-body">
                            <div class="contenu-text">
                                {!! nl2br(e($contenu->texte)) !!}
                            </div>
                        </div>
                    </div>

                    <!-- Sous-contenus -->
                    @if($contenu->enfants && $contenu->enfants->count() > 0)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="bi bi-folder me-2"></i>Sous-contenus ({{ $contenu->enfants_count }})</h6>
                            <a href="{{ route('contenus.create') }}?parent_id={{ $contenu->id_contenu }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Ajouter
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Titre</th>
                                            <th>Statut</th>
                                            <th>Auteur</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contenu->enfants as $enfant)
                                        <tr>
                                            <td>
                                                <strong>{{ Str::limit($enfant->titre, 50) }}</strong>
                                            </td>
                                            <td>
                                                @php
                                                    $badgeClass = 'bg-secondary';
                                                    if($enfant->statut == 'publié') $badgeClass = 'bg-success';
                                                    if($enfant->statut == 'en attente') $badgeClass = 'bg-warning';
                                                    if($enfant->statut == 'rejeté') $badgeClass = 'bg-danger';
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">{{ ucfirst($enfant->statut) }}</span>
                                            </td>
                                            <td>
                                                @if($enfant->auteur)
                                                {{ $enfant->auteur->name }}
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ $enfant->date_creation->format('d/m/Y') }}</small>
                                            </td>
                                            <td>
                                                <div class="action-buttons-contenus">
                                                    <a href="{{ route('contenus.show', $enfant->id_contenu) }}" 
                                                       class="action-btn-contenu action-btn-info-contenu" 
                                                       title="Voir">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('contenus.edit', $enfant->id_contenu) }}" 
                                                       class="action-btn-contenu action-btn-warning-contenu" 
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
                        </div>
                    </div>
                    @endif

                    <!-- Médias associés -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="bi bi-images me-2"></i>Médias Associés ({{ $contenu->media_count ?? 0 }})</h6>
                            <a href="{{ route('media.create') }}?contenu={{ $contenu->id_contenu }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Ajouter
                            </a>
                        </div>
                        <div class="card-body">
                            @if($contenu->media && $contenu->media->count() > 0)
                            <div class="row">
                                @foreach($contenu->media as $media)
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100">
                                        @if($media->type == 'image')
                                        <img src="{{ asset('storage/' . $media->chemin) }}" class="card-img-top" alt="{{ $media->titre }}" style="height: 150px; object-fit: cover;">
                                        @else
                                        <div class="text-center py-4">
                                            <i class="bi bi-file-earmark-text display-4 text-muted"></i>
                                        </div>
                                        @endif
                                        <div class="card-body">
                                            <h6 class="card-title">{{ Str::limit($media->titre, 30) }}</h6>
                                            <p class="card-text small text-muted">{{ $media->type }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="bi bi-images display-4 text-muted mb-3"></i>
                                <p class="text-muted">Aucun média associé à ce contenu pour le moment.</p>
                                <a href="{{ route('media.create') }}?contenu={{ $contenu->id_contenu }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i> Ajouter le premier média
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

<!-- Modal pour changer le statut -->
<div class="modal fade" id="changeStatutModal" tabindex="-1" aria-labelledby="changeStatutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeStatutModalLabel">Changer le statut du contenu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changeStatutForm" method="POST" action="{{ route('contenus.changer-statut', $contenu->id_contenu) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="statut" class="form-label">Nouveau statut</label>
                        <select name="statut" id="statut" class="form-select" required>
                            <option value="brouillon" {{ $contenu->statut == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                            <option value="en attente" {{ $contenu->statut == 'en attente' ? 'selected' : '' }}>En attente</option>
                            <option value="publié" {{ $contenu->statut == 'publié' ? 'selected' : '' }}>Publié</option>
                            <option value="rejeté" {{ $contenu->statut == 'rejeté' ? 'selected' : '' }}>Rejeté</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('changeStatutForm').submit()">Changer le statut</button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDeleteContenu(mediaCount, commentairesCount) {
    let message = 'Êtes-vous sûr de vouloir supprimer ce contenu ?';
    
    if (mediaCount > 0 || commentairesCount > 0) {
        message = 'Ce contenu est associé à ' + 
                  mediaCount + ' média(s) et ' + 
                  commentairesCount + ' commentaire(s). ' +
                  'Êtes-vous sûr de vouloir le supprimer ?';
    }
    
    return confirm(message);
}
</script>
@endsection