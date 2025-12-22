@extends('layouts.admin')

@section('title', $typeContenu->nom)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 mb-4">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-tags fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Détails du Type de Contenu</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    Informations complètes
                                </p>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.type_contenus.edit', $typeContenu->id_type_contenu) }}" 
                               class="btn btn-outline-light btn-sm">
                                <i class="bi bi-pencil me-2"></i> Modifier
                            </a>
                            <a href="{{ route('admin.type_contenus.index') }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-arrow-left me-2"></i> Retour
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Informations principales -->
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card border-0 shadow-sm p-3 rounded">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3 text-primary">
                                        <i class="bi bi-tag-fill fs-1"></i>
                                    </div>
                                    <div>
                                        <h4 class="mb-1">{{ $typeContenu->nom }}</h4>
                                        <span class="badge bg-dark">
                                            ID: {{ $typeContenu->id_type_contenu }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <div class="border rounded p-2">
                                                <div class="text-primary fs-3 fw-bold">
                                                    {{ $typeContenu->contenus()->count() }}
                                                </div>
                                                <div class="text-muted small">
                                                    <i class="bi bi-file-text me-1"></i> Contenus
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="border rounded p-2">
                                                <div class="text-success fs-3 fw-bold">
                                                    {{ $typeContenu->contenus()->where('statut', 1)->count() }}
                                                </div>
                                                <div class="text-muted small">
                                                    <i class="bi bi-check-circle me-1"></i> Actifs
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <div class="details-type-contenu p-3">
                                <h6 class="border-bottom pb-2 mb-3">
                                    <i class="bi bi-info-square me-2"></i> Informations
                                </h6>
                                <dl class="row mb-0">
                                    <dt class="col-sm-5">Créé le:</dt>
                                    <dd class="col-sm-7">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        {{ $typeContenu->created_at->format('d/m/Y') }}
                                        <small class="text-muted ms-2">
                                            {{ $typeContenu->created_at->format('H:i') }}
                                        </small>
                                    </dd>
                                    
                                    <dt class="col-sm-5">Modifié le:</dt>
                                    <dd class="col-sm-7">
                                        <i class="bi bi-clock-history me-1"></i>
                                        {{ $typeContenu->updated_at->format('d/m/Y') }}
                                        <small class="text-muted ms-2">
                                            {{ $typeContenu->updated_at->format('H:i') }}
                                        </small>
                                    </dd>
                                    
                                    <dt class="col-sm-5">Statut:</dt>
                                    <dd class="col-sm-7">
                                        @if($typeContenu->contenus()->count() > 0)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i> Utilisé
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-dash-circle me-1"></i> Non utilisé
                                            </span>
                                        @endif
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="col-lg-4">
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0">
                        <i class="bi bi-lightning-charge me-2"></i> Actions rapides
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.type_contenus.edit', $typeContenu->id_type_contenu) }}" 
                           class="btn btn-action-primary text-white">
                            <i class="bi bi-pencil-square me-2"></i> Modifier
                        </a>
                        
                        @if($typeContenu->contenus()->count() == 0)
                        <form action="{{ route('admin.type_contenus.destroy', $typeContenu->id_type_contenu) }}" 
                              method="POST" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce type de contenu ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="bi bi-trash me-2"></i> Supprimer
                            </button>
                        </form>
                        @else
                        <button class="btn btn-danger disabled" title="Impossible de supprimer un type utilisé" disabled>
                            <i class="bi bi-trash me-2"></i> Supprimer (non disponible)
                        </button>
                        @endif
                        
                        <a href="{{ route('admin.type_contenus.create') }}" class="btn btn-outline-primary">
                            <i class="bi bi-plus-circle me-2"></i> Nouveau Type
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section des contenus associés -->
    @if($typeContenu->contenus()->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="bi bi-file-text me-2"></i> 
                            Contenus de ce type 
                            <span class="badge bg-primary ms-2">{{ $typeContenu->contenus()->count() }}</span>
                        </h6>
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-download me-2"></i> Exporter
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Titre</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($typeContenu->contenus()->latest()->take(10)->get() as $contenu)
                                <tr>
                                    <td class="text-muted">{{ $contenu->id_contenu }}</td>
                                    <td>{{ Str::limit($contenu->titre, 50) }}</td>
                                    <td>
                                        @if($contenu->statut)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-danger">Inactif</span>
                                        @endif
                                    </td>
                                    <td>{{ $contenu->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.contenus.show', $contenu) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($typeContenu->contenus()->count() > 10)
                    <div class="card-footer bg-white text-center">
                        <a href="#" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-arrow-right-circle me-2"></i> Voir tous les contenus
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center py-5">
                    <i class="bi bi-file-text display-1 text-muted mb-4"></i>
                    <h5 class="text-muted mb-3">Aucun contenu associé à ce type</h5>
                    <p class="text-muted mb-4">Ce type de contenu n'est pas encore utilisé.</p>
                    <a href="{{ route('admin.contenus.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i> Créer un contenu
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialisation des tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush