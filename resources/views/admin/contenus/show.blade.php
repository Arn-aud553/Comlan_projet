@extends('layouts.admin')

@section('title', 'Détails du Contenu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient py-3">
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
                            <a href="{{ route('admin.contenus.index') }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-arrow-left me-2"></i> Retour
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Infos Principales -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informations Principales</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-4">
                                        <span class="badge bg-info me-2">{{ $contenu->typeContenu->nom ?? 'Type inconnu' }}</span>
                                        @if($contenu->statut == 'publié')
                                            <span class="badge bg-success">Publié</span>
                                        @elseif($contenu->statut == 'en attente')
                                            <span class="badge bg-warning text-dark">En attente</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($contenu->statut) }}</span>
                                        @endif
                                    </div>
                                    
                                    <h6 class="text-muted text-uppercase small fw-bold">Description</h6>
                                    <div class="p-3 bg-light rounded border mb-4">
                                        {!! nl2br(e($contenu->description)) !!}
                                    </div>

                                    @if($contenu->media->count() > 0)
                                        <h6 class="text-muted text-uppercase small fw-bold mt-4">Médias associés ({{ $contenu->media->count() }})</h6>
                                        <div class="row g-3">
                                            @foreach($contenu->media as $media)
                                                <div class="col-md-3">
                                                    <div class="card h-100 border shadow-sm">
                                                        @if($media->type_fichier == 'image')
                                                            <img src="{{ asset('storage/'.$media->chemin_fichier) }}" class="card-img-top" alt="{{ $media->nom_fichier }}" style="height: 120px; object-fit: cover;">
                                                        @else
                                                            <div class="card-body text-center d-flex align-items-center justify-content-center bg-light" style="height: 120px;">
                                                                <i class="bi bi-file-earmark fs-1 text-secondary"></i>
                                                            </div>
                                                        @endif
                                                        <div class="card-footer p-2 text-center bg-white border-top-0">
                                                            <small class="d-block text-truncate mb-2" title="{{ $media->nom_fichier }}">{{ $media->nom_fichier }}</small>
                                                            <a href="{{ route('admin.media.show', $media->id_media) }}" class="btn btn-sm btn-outline-primary w-100">
                                                                <i class="bi bi-eye"></i> Voir
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Actions -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Actions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.contenus.edit', $contenu->id_contenu) }}" class="btn btn-action-primary text-white">
                                            <i class="bi bi-pencil me-2"></i> Modifier
                                        </a>
                                        <form action="{{ route('admin.contenus.destroy', $contenu->id_contenu) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce contenu ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="bi bi-trash me-2"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Meta Data -->
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="bi bi-tags me-2"></i>Métadonnées</h6>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-hover mb-0">
                                        <tr>
                                            <td class="text-muted ps-4"><i class="bi bi-person me-2"></i>Auteur</td>
                                            <td class="fw-bold">{{ $contenu->auteur->name ?? 'Inconnu' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-4"><i class="bi bi-translate me-2"></i>Langue</td>
                                            <td class="fw-bold">{{ $contenu->langue->nom_langue ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-4"><i class="bi bi-geo-alt me-2"></i>Région</td>
                                            <td class="fw-bold">{{ $contenu->region->nom_region ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-4"><i class="bi bi-cash me-2"></i>Prix</td>
                                            <td class="fw-bold">
                                                @if($contenu->prix > 0)
                                                    {{ number_format($contenu->prix, 0, ',', ' ') }} FCFA
                                                @else
                                                    <span class="badge bg-success">Gratuit</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-4"><i class="bi bi-calendar me-2"></i>Créé le</td>
                                            <td>{{ $contenu->created_at ? $contenu->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-4"><i class="bi bi-calendar-check me-2"></i>Maj le</td>
                                            <td>{{ $contenu->updated_at ? $contenu->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
