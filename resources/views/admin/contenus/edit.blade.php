@extends('layouts.admin')

@section('title', 'Modifier le Contenu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-pencil-square fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Modifier le Contenu</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    {{ $contenu->titre }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admin.contenus.show', $contenu->id_contenu) }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-eye me-2"></i> Voir
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.contenus.update', $contenu->id_contenu) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="bi bi-card-text me-2"></i>Informations Principales</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre', $contenu->titre) }}" required>
                                            @error('titre')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description / Contenu <span class="text-danger">*</span></label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="10" required>{{ old('description', $contenu->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="bi bi-sliders me-2"></i>Attributs & Métadonnées</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="id_type_contenu" class="form-label">Type de Contenu <span class="text-danger">*</span></label>
                                            <select class="form-select @error('id_type_contenu') is-invalid @enderror" id="id_type_contenu" name="id_type_contenu" required>
                                                <option value="">Sélectionner...</option>
                                                @foreach($types as $type)
                                                    <option value="{{ $type->id_type_contenu ?? $type->id }}" {{ old('id_type_contenu', $contenu->id_type_contenu) == ($type->id_type_contenu ?? $type->id) ? 'selected' : '' }}>
                                                        {{ $type->nom }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_type_contenu')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="id_langue" class="form-label">Langue</label>
                                            <select class="form-select @error('id_langue') is-invalid @enderror" id="id_langue" name="id_langue">
                                                <option value="">Sélectionner...</option>
                                                @foreach($langues as $langue)
                                                    <option value="{{ $langue->id_langue }}" {{ old('id_langue', $contenu->id_langue) == $langue->id_langue ? 'selected' : '' }}>
                                                        {{ $langue->nom_langue }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_langue')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="id_region" class="form-label">Région</label>
                                            <select class="form-select @error('id_region') is-invalid @enderror" id="id_region" name="id_region">
                                                <option value="">Sélectionner...</option>
                                                @foreach($regions as $region)
                                                    <option value="{{ $region->id_region }}" {{ old('id_region', $contenu->id_region) == $region->id_region ? 'selected' : '' }}>
                                                        {{ $region->nom_region }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_region')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="prix" class="form-label">Prix (FCFA)</label>
                                            <input type="number" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ old('prix', $contenu->prix) }}" min="0">
                                            @error('prix')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="statut" class="form-label">Statut</label>
                                            <select class="form-select @error('statut') is-invalid @enderror" id="statut" name="statut">
                                                <option value="en attente" {{ old('statut', $contenu->statut) == 'en attente' ? 'selected' : '' }}>En attente</option>
                                                <option value="publie" {{ old('statut', $contenu->statut) == 'publie' ? 'selected' : '' }}>Publié</option>
                                                <option value="archivé" {{ old('statut', $contenu->statut) == 'archivé' ? 'selected' : '' }}>Archivé</option>
                                                <option value="supprimé" {{ old('statut', $contenu->statut) == 'supprimé' ? 'selected' : '' }}>Supprimé</option>
                                            </select>
                                            @error('statut')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Auteur</label>
                                            <input type="text" class="form-control" value="{{ $contenu->auteur->name ?? 'Inconnu' }}" disabled>
                                            <input type="hidden" name="id_auteur" value="{{ $contenu->id_auteur }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0"><i class="bi bi-images me-2"></i>Gestion des Médias</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Ajout de nouveaux médias -->
                                        <div class="mb-4">
                                            <label for="medias" class="form-label fw-bold">Ajouter des fichiers</label>
                                            <input class="form-control @error('medias') is-invalid @enderror" type="file" id="medias" name="medias[]" multiple>
                                            <div class="form-text">Vous pouvez sélectionner plusieurs fichiers.</div>
                                            @error('medias')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            @error('medias.*')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Liste des médias existants -->
                                        @if($contenu->media->count() > 0)
                                            <hr>
                                            <h6 class="fw-bold mb-3">Médias existants ({{ $contenu->media->count() }})</h6>
                                            <div class="row g-3">
                                                @foreach($contenu->media as $media)
                                                    <div class="col-sm-6 col-md-4 col-lg-3">
                                                        <div class="card h-100 border-0 shadow-sm">
                                                            <div class="position-relative" style="height: 120px; overflow: hidden; background: #f8f9fa;">
                                                                @if(in_array($media->type_fichier, ['image', 'photo']))
                                                                    <img src="{{ asset('storage/' . $media->chemin_fichier) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $media->titre }}">
                                                                @elseif($media->type_fichier == 'video')
                                                                    <div class="d-flex align-items-center justify-content-center h-100">
                                                                        <i class="bi bi-play-circle fs-1 text-secondary"></i>
                                                                    </div>
                                                                @else
                                                                    <div class="d-flex align-items-center justify-content-center h-100">
                                                                        <i class="bi bi-file-earmark fs-1 text-secondary"></i>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="card-body p-2">
                                                                <p class="card-text small text-truncate mb-1" title="{{ $media->nom_fichier }}">{{ $media->nom_fichier }}</p>
                                                                <small class="text-muted d-block">{{ strtoupper($media->extension) }}</small>
                                                            </div>
                                                            <div class="card-footer bg-white p-2 border-top-0">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="delete_media[]" value="{{ $media->id_media }}" id="media_{{ $media->id_media }}">
                                                                    <label class="form-check-label small text-danger" for="media_{{ $media->id_media }}">
                                                                        Supprimer
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="alert alert-info py-2">
                                                <small><i class="bi bi-info-circle me-1"></i> Aucun média associé.</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 border-top pt-4">
                            <a href="{{ route('admin.contenus.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Retour à la liste
                            </a>
                            <button type="submit" class="btn btn-action-primary text-white px-4">
                                <i class="bi bi-check-circle me-2"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
