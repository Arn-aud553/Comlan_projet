@extends('layouts.admin')

@section('title', 'Modifier le Média')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-pencil-square fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Modifier le Média</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    {{ $media->nom_fichier }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admin.media.show', $media->id_media) }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-eye me-2"></i> Voir
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.media.update', $media->id_media) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informations Modifiables</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="titre" class="form-label">Titre</label>
                                    <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre', $media->titre) }}" placeholder="Titre descriptif du média">
                                    @error('titre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Ce titre sera affiché à la place du nom de fichier si présent.</div>
                                </div>

                                <div class="mb-3">
                                    <label for="prix" class="form-label">Prix (FCFA)</label>
                                    <input type="number" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ old('prix', $media->prix) }}" min="0">
                                    @error('prix')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Si le média est payant à l'unité.</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('admin.media.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Retour à la liste
                            </a>
                            <button type="submit" class="btn btn-action-primary text-white">
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
