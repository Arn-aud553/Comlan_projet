@extends('layouts.admin')

@section('title', 'Créer une Région')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/regions.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4 regions-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient-regions py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-plus-circle fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Créer une Nouvelle Région</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    Ajouter une région au catalogue
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

                <!-- Formulaire -->
                <div class="card-body p-4">
                    <div class="form-card-region">
                        <form action="{{ route('regions.store') }}" method="POST">
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
                                <div class="col-md-12 mb-4">
                                    <label for="nom_region" class="form-label">
                                        <i class="bi bi-geo-alt me-1"></i> Nom de la région *
                                    </label>
                                    <input type="text" 
                                           name="nom_region" 
                                           id="nom_region" 
                                           value="{{ old('nom_region') }}" 
                                           class="form-control @error('nom_region') is-invalid @enderror"
                                           required
                                           placeholder="Ex: Atlantique, Borgou, Zou..."
                                           autofocus>
                                    @error('nom_region')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Nom complet de la région</div>
                                </div>

                                <div class="col-12 mb-4">
                                    <label for="description" class="form-label">
                                        <i class="bi bi-text-paragraph me-1"></i> Description
                                    </label>
                                    <textarea name="description" 
                                              id="description" 
                                              class="form-control @error('description') is-invalid @enderror"
                                              rows="6"
                                              placeholder="Description géographique, informations historiques, caractéristiques culturelles...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Informations détaillées sur la région</div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <button type="reset" class="btn btn-region-secondary">
                                                <i class="bi bi-arrow-clockwise me-2"></i> Réinitialiser
                                            </button>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('regions.index') }}" class="btn btn-outline-secondary">
                                                <i class="bi bi-x-circle me-2"></i> Annuler
                                            </a>
                                            <button type="submit" class="btn btn-region-primary">
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
document.getElementById('nom_region').focus();

// Validation en temps réel
document.getElementById('nom_region').addEventListener('input', function() {
    if (this.value.length > 0) {
        this.classList.remove('is-invalid');
    }
});
</script>
@endpush
@endsection