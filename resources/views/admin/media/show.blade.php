@extends('layouts.admin')

@section('title', 'Détails du Média')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endpush

@section('content')
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
                                <i class="bi bi-file-earmark-play fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Détails du Média</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    {{ $media->nom_fichier }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admin.media.index') }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-arrow-left me-2"></i> Retour
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Aperçu -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="bi bi-image me-2"></i>Aperçu</h6>
                                </div>
                                <div class="card-body text-center bg-dark rounded-bottom p-5 d-flex align-items-center justify-content-center" style="min-height: 400px;">
                                    @if($media->type_fichier == 'image')
                                        <img src="{{ asset('storage/'.$media->chemin_fichier) }}" alt="{{ $media->nom_fichier }}" class="img-fluid rounded" style="max-height: 400px;">
                                    @elseif($media->type_fichier == 'video')
                                        <video controls class="w-100" style="max-height: 400px;">
                                            <source src="{{ asset('storage/'.$media->chemin_fichier) }}" type="{{ $media->mime_type }}">
                                            Votre navigateur ne supporte pas la lecture de vidéos.
                                        </video>
                                    @elseif($media->type_fichier == 'audio')
                                        <audio controls class="w-100">
                                            <source src="{{ asset('storage/'.$media->chemin_fichier) }}" type="{{ $media->mime_type }}">
                                            Votre navigateur ne supporte pas la lecture audio.
                                        </audio>
                                    @else
                                        <div class="py-5 text-white">
                                            <i class="bi bi-file-earmark-arrow-down fs-1 mb-3 d-block"></i>
                                            <p class="lead mb-3">{{ $media->nom_fichier }}</p>
                                            <a href="{{ asset('storage/'.$media->chemin_fichier) }}" class="btn btn-primary" target="_blank">
                                                <i class="bi bi-download me-2"></i> Télécharger
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <!-- Informations -->
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Métadonnées et Infos</h6>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-hover mb-0">
                                        <tr>
                                            <td class="text-muted ps-4" width="35%">Titre</td>
                                            <td class="fw-bold">{{ $media->titre ?? 'Aucun titre' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-4">Fichier</td>
                                            <td>{{ $media->nom_fichier }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-4">Type</td>
                                            <td><span class="badge bg-info">{{ ucfirst($media->type_fichier) }}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-4">Extension</td>
                                            <td><span class="badge bg-secondary">{{ $media->extension }}</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-4">Taille</td>
                                            <td>{{ number_format($media->taille_fichier / 1024, 2) }} Ko</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-4">Prix</td>
                                            <td>
                                                @if($media->prix > 0)
                                                    {{ number_format($media->prix, 0, ',', ' ') }} FCFA
                                                @else
                                                    <span class="badge bg-success">Gratuit</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-4">Auteur</td>
                                            <td>{{ $media->auteur->name ?? 'Inconnu' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-4">Contenu Associé</td>
                                            <td>
                                                @if($media->contenu)
                                                    <a href="{{ route('admin.contenus.show', $media->contenu->id_contenu) }}" class="text-decoration-none">
                                                        <i class="bi bi-box-arrow-up-right me-1"></i> {{ Str::limit($media->contenu->titre, 30) }}
                                                    </a>
                                                @else
                                                    <span class="text-muted fst-italic">Aucun</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="text-muted ps-4">Date d'ajout</td>
                                            <td>{{ $media->created_at->format('d/m/Y H:i') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Actions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.media.edit', $media->id_media) }}" class="btn btn-action-primary text-white">
                                            <i class="bi bi-pencil me-2"></i> Modifier le média
                                        </a>
                                        <form action="{{ route('admin.media.destroy', $media->id_media) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce média ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="bi bi-trash me-2"></i> Supprimer le média
                                            </button>
                                        </form>
                                    </div>
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
