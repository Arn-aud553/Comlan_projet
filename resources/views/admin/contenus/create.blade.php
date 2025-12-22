@extends('layouts.admin')

@section('title', 'Nouveau Contenu')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ajouter un Contenu</h1>
        <a href="{{ route('admin.contenus.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulaire de création</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.contenus.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre') }}" required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description / Contenu <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="10" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="id_type_contenu" class="form-label">Type de Contenu <span class="text-danger">*</span></label>
                            <select class="form-select @error('id_type_contenu') is-invalid @enderror" id="id_type_contenu" name="id_type_contenu" required>
                                <option value="">Sélectionner...</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id_type_contenu ?? $type->id }}" {{ old('id_type_contenu') == ($type->id_type_contenu ?? $type->id) ? 'selected' : '' }}>
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
                                    <option value="{{ $langue->id_langue }}" {{ old('id_langue') == $langue->id_langue ? 'selected' : '' }}>
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
                                    <option value="{{ $region->id_region }}" {{ old('id_region') == $region->id_region ? 'selected' : '' }}>
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
                            <input type="number" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ old('prix', 0) }}" min="0">
                            <small class="text-muted">Laisser à 0 pour gratuit</small>
                            @error('prix')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="statut" class="form-label">Statut</label>
                            <select class="form-select @error('statut') is-invalid @enderror" id="statut" name="statut">
                                <option value="en attente" {{ old('statut') == 'en attente' ? 'selected' : '' }}>En attente</option>
                                <option value="publie" {{ old('statut') == 'publie' ? 'selected' : '' }}>Publié</option>
                                <option value="archivé" {{ old('statut') == 'archivé' ? 'selected' : '' }}>Archivé</option>
                            </select>
                            @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_auteur" class="form-label">Auteur <span class="text-danger">*</span></label>
                            <select class="form-select @error('id_auteur') is-invalid @enderror" id="id_auteur" name="id_auteur" required>
                                <option value="">Sélectionner...</option>
                                @foreach($auteurs as $auteur)
                                    <option value="{{ $auteur->id }}" {{ old('id_auteur', Auth::id()) == $auteur->id ? 'selected' : '' }}>
                                        {{ $auteur->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_auteur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-12 mt-3">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="bi bi-images me-2"></i>Médias (Photos / Vidéos)</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="medias" class="form-label">Sélectionner des fichiers</label>
                                    <input class="form-control @error('medias') is-invalid @enderror" type="file" id="medias" name="medias[]" multiple>
                                    <div class="form-text">Vous pouvez sélectionner plusieurs fichiers (images ou vidéos).</div>
                                    @error('medias')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('medias.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
