@extends('layouts.admin')

@section('title', 'Modifier la Langue')

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
                                <i class="bi bi-pencil-square fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Modifier la Langue</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    {{ $langue->nom_langue }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('langues.show', $langue->id_langue) }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-eye me-2"></i> Voir
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Formulaire -->
                <div class="card-body p-4">
                    <div class="form-card-langue">
                        <form action="{{ route('langues.update', $langue->id_langue) }}" method="POST">
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
                                <div class="col-md-6 mb-4">
                                    <label for="nom_langue" class="form-label">
                                        <i class="bi bi-translate me-1"></i> Nom de la langue
                                    </label>
                                    <input type="text" 
                                           name="nom_langue" 
                                           id="nom_langue" 
                                           value="{{ old('nom_langue', $langue->nom_langue) }}" 
                                           class="form-control @error('nom_langue') is-invalid @enderror"
                                           required
                                           placeholder="Ex: Français, Fon, Yoruba...">
                                    @error('nom_langue')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Le nom complet de la langue</div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="code_langue" class="form-label">
                                        <i class="bi bi-code me-1"></i> Code langue
                                    </label>
                                    <input type="text" 
                                           name="code_langue" 
                                           id="code_langue" 
                                           value="{{ old('code_langue', $langue->code_langue) }}" 
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
                                              placeholder="Description de la langue, informations historiques, usage...">{{ old('description', $langue->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Informations supplémentaires sur la langue</div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="{{ route('langues.show', $langue->id_langue) }}" class="btn btn-langue-secondary">
                                                <i class="bi bi-x-circle me-2"></i> Annuler
                                            </a>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('langues.index') }}" class="btn btn-outline-secondary">
                                                <i class="bi bi-arrow-left me-2"></i> Retour à la liste
                                            </a>
                                            <button type="submit" class="btn btn-langue-primary">
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
@endsection