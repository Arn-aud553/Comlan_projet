@extends('layouts.admin')

@section('title', 'Créer une Langue')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/langues.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4 langues-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient-langues py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-plus-circle fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Créer une Nouvelle Langue</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    Ajouter une langue au catalogue
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

                <!-- Formulaire -->
                <div class="card-body p-4">
                    <div class="form-card-langue">
                        <form action="{{ route('langues.store') }}" method="POST">
                            @csrf

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
                                <div class="col-md-6 mb-4">
                                    <label for="nom_langue" class="form-label">
                                        <i class="bi bi-translate me-1"></i> Nom de la langue *
                                    </label>
                                    <input type="text" 
                                           name="nom_langue" 
                                           id="nom_langue" 
                                           value="{{ old('nom_langue') }}" 
                                           class="form-control @error('nom_langue') is-invalid @enderror"
                                           required
                                           placeholder="Ex: Français, Fon, Yoruba..."
                                           autofocus>
                                    @error('nom_langue')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Le nom complet de la langue</div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="code_langue" class="form-label">
                                        <i class="bi bi-code me-1"></i> Code langue *
                                    </label>
                                    <input type="text" 
                                           name="code_langue" 
                                           id="code_langue" 
                                           value="{{ old('code_langue') }}" 
                                           class="form-control @error('code_langue') is-invalid @enderror"
                                           required
                                           placeholder="Ex: fr, fon, yor..."
                                           maxlength="5">
                                    @error('code_langue')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Code ISO (2-5 caractères)</div>
                                </div>

                                <div class="col-12 mb-4">
                                    <label for="description" class="form-label">
                                        <i class="bi bi-text-paragraph me-1"></i> Description
                                    </label>
                                    <textarea name="description" 
                                              id="description" 
                                              class="form-control @error('description') is-invalid @enderror"
                                              rows="5"
                                              placeholder="Description de la langue, informations historiques, usage...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Informations supplémentaires sur la langue</div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <button type="reset" class="btn btn-langue-secondary">
                                                <i class="bi bi-arrow-clockwise me-2"></i> Réinitialiser
                                            </button>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('langues.index') }}" class="btn btn-outline-secondary">
                                                <i class="bi bi-x-circle me-2"></i> Annuler
                                            </a>
                                            <button type="submit" class="btn btn-langue-primary">
                                                <i class="bi bi-check-circle me-2"></i> Enregistrer
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
document.getElementById('nom_langue').focus();

// Validation en temps réel
document.getElementById('nom_langue').addEventListener('input', function() {
    if (this.value.length > 0) {
        this.classList.remove('is-invalid');
    }
});

document.getElementById('code_langue').addEventListener('input', function() {
    // Convertir en minuscules
    this.value = this.value.toLowerCase();
    
    if (this.value.length >= 2 && this.value.length <= 5) {
        this.classList.remove('is-invalid');
    }
});
</script>
@endpush
@endsection