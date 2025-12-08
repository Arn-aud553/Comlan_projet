@extends('layouts.admin')

@section('title', 'Modifier le Contenu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/contenus.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4 contenus-container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient-contenus py-3">
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
                            <a href="{{ route('contenus.show', $contenu->id_contenu) }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-eye me-2"></i> Voir
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Formulaire -->
                <div class="card-body p-4">
                    <div class="form-card-contenu">
                        <form action="{{ route('contenus.update', $contenu->id_contenu) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Flash messages -->
                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Veuillez corriger les erreurs suivantes :</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            <div class="row">
                                <div class="col-12 mb-4">
                                    <label for="titre" class="form-label">
                                        <i class="bi bi-text-left me-1"></i> Titre *
                                    </label>
                                    <input type="text" 
                                           name="titre" 
                                           id="titre" 
                                           value="{{ old('titre', $contenu->titre) }}" 
                                           class="form-control @error('titre') is-invalid @enderror"
                                           required
                                           placeholder="Titre du contenu..."
                                           autofocus>
                                    @error('titre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Titre principal du contenu</div>
                                </div>

                                <div class="col-12 mb-4">
                                    <label for="texte" class="form-label">
                                        <i class="bi bi-text-paragraph me-1"></i> Texte *
                                    </label>
                                    <textarea name="texte" 
                                              id="texte" 
                                              class="form-control @error('texte') is-invalid @enderror"
                                              rows="10"
                                              required
                                              placeholder="Contenu textuel détaillé...">{{ old('texte', $contenu->texte) }}</textarea>
                                    @error('texte')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Contenu principal</div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="statut" class="form-label">
                                        <i class="bi bi-circle-fill me-1"></i> Statut *
                                    </label>
                                    <select name="statut" 
                                            id="statut" 
                                            class="form-select @error('statut') is-invalid @enderror"
                                            required>
                                        <option value="brouillon" {{ old('statut', $contenu->statut) == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                                        <option value="en attente" {{ old('statut', $contenu->statut) == 'en attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="publié" {{ old('statut', $contenu->statut) == 'publié' ? 'selected' : '' }}>Publié</option>
                                        <option value="rejeté" {{ old('statut', $contenu->statut) == 'rejeté' ? 'selected' : '' }}>Rejeté</option>
                                    </select>
                                    @error('statut')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="date_creation" class="form-label">
                                        <i class="bi bi-calendar-plus me-1"></i> Date de création
                                    </label>
                                    <input type="datetime-local" 
                                           name="date_creation" 
                                           id="date_creation" 
                                           value="{{ old('date_creation', $contenu->date_creation->format('Y-m-d\TH:i')) }}" 
                                           class="form-control @error('date_creation') is-invalid @enderror">
                                    @error('date_creation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label for="id_langue" class="form-label">
                                        <i class="bi bi-translate me-1"></i> Langue *
                                    </label>
                                    <select name="id_langue" 
                                            id="id_langue" 
                                            class="form-select @error('id_langue') is-invalid @enderror"
                                            required>
                                        <option value="">Sélectionner une langue</option>
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

                                <div class="col-md-4 mb-4">
                                    <label for="id_region" class="form-label">
                                        <i class="bi bi-geo-alt me-1"></i> Région *
                                    </label>
                                    <select name="id_region" 
                                            id="id_region" 
                                            class="form-select @error('id_region') is-invalid @enderror"
                                            required>
                                        <option value="">Sélectionner une région</option>
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

                                <div class="col-md-4 mb-4">
                                    <label for="id_type_contenu" class="form-label">
                                        <i class="bi bi-tag me-1"></i> Type de contenu *
                                    </label>
                                    <select name="id_type_contenu" 
                                            id="id_type_contenu" 
                                            class="form-select @error('id_type_contenu') is-invalid @enderror"
                                            required>
                                        <option value="">Sélectionner un type</option>
                                        @foreach($typesContenu as $type)
                                        <option value="{{ $type->id_type_contenu }}" {{ old('id_type_contenu', $contenu->id_type_contenu) == $type->id_type_contenu ? 'selected' : '' }}>
                                            {{ $type->nom }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('id_type_contenu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="id_auteur" class="form-label">
                                        <i class="bi bi-person me-1"></i> Auteur *
                                    </label>
                                    <select name="id_auteur" 
                                            id="id_auteur" 
                                            class="form-select @error('id_auteur') is-invalid @enderror"
                                            required>
                                        @foreach($auteurs as $auteur)
                                        <option value="{{ $auteur->id }}" {{ old('id_auteur', $contenu->id_auteur) == $auteur->id ? 'selected' : '' }}>
                                            {{ $auteur->name }} ({{ $auteur->role }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('id_auteur')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="id_moderateur" class="form-label">
                                        <i class="bi bi-shield-check me-1"></i> Modérateur
                                    </label>
                                    <select name="id_moderateur" 
                                            id="id_moderateur" 
                                            class="form-select @error('id_moderateur') is-invalid @enderror">
                                        <option value="">Sélectionner un modérateur</option>
                                        @foreach($moderateurs as $moderateur)
                                        <option value="{{ $moderateur->id }}" {{ old('id_moderateur', $contenu->id_moderateur) == $moderateur->id ? 'selected' : '' }}>
                                            {{ $moderateur->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('id_moderateur')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Assigné automatiquement lors de la validation</div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="date_validation" class="form-label">
                                        <i class="bi bi-calendar-check me-1"></i> Date de validation
                                    </label>
                                    <input type="datetime-local" 
                                           name="date_validation" 
                                           id="date_validation" 
                                           value="{{ old('date_validation', $contenu->date_validation ? $contenu->date_validation->format('Y-m-d\TH:i') : '') }}" 
                                           class="form-control @error('date_validation') is-invalid @enderror">
                                    @error('date_validation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Date de validation (si statut = publié)</div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="{{ route('contenus.show', $contenu->id_contenu) }}" class="btn btn-contenu-secondary">
                                                <i class="bi bi-x-circle me-2"></i> Annuler
                                            </a>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('contenus.index') }}" class="btn btn-outline-secondary">
                                                <i class="bi bi-arrow-left me-2"></i> Retour à la liste
                                            </a>
                                            <button type="submit" class="btn btn-contenu-primary">
                                                <i class="bi bi-check-circle me-2"></i> Mettre à jour
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Mettre le focus sur le premier champ
document.getElementById('titre').focus();

// Validation en temps réel
document.getElementById('titre').addEventListener('input', function() {
    if (this.value.length > 0) {
        this.classList.remove('is-invalid');
    }
});

// Si le statut est publié et pas de date de validation, suggérer la date actuelle
document.getElementById('statut').addEventListener('change', function() {
    const dateValidationField = document.getElementById('date_validation');
    if (this.value === 'publié' && !dateValidationField.value) {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        
        dateValidationField.value = `${year}-${month}-${day}T${hours}:${minutes}`;
    }
});

// Éditeur de texte simple pour le champ texte
document.getElementById('texte').addEventListener('input', function() {
    if (this.value.length > 0) {
        this.classList.remove('is-invalid');
    }
});
</script>
@endpush
@endsection