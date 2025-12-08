@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Détails du Média</h3>
                    <div>
                        <a href="{{ route('media.edit', ['medium' => $media->id_media]) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                        <a href="{{ route('media.index') }}" class="btn btn-secondary btn-sm">
                            <i class="bi bi-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Informations du fichier</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">ID</th>
                                    <td>{{ $media->id_media }}</td>
                                </tr>
                                <tr>
                                    <th>Nom du fichier</th>
                                    <td>{{ $media->nom_fichier }}</td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td>
                                        @if($media->type_fichier == 'image')
                                            <span class="badge badge-primary">Image</span>
                                        @elseif($media->type_fichier == 'video')
                                            <span class="badge badge-success">Vidéo</span>
                                        @elseif($media->type_fichier == 'livre')
                                            <span class="badge badge-info">Livre</span>
                                        @else
                                            <span class="badge badge-secondary">Document</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Extension</th>
                                    <td><code>{{ $media->extension }}</code></td>
                                </tr>
                                <tr>
                                    <th>Taille</th>
                                    <td>{{ $media->taille_formattee ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>MIME Type</th>
                                    <td><code>{{ $media->mime_type ?? 'N/A' }}</code></td>
                                </tr>
                                <tr>
                                    <th>Date de création</th>
                                    <td>{{ $media->created_at ? $media->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                </tr>
                            </table>

                            <h5 class="mt-4">Associations</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Contenu</th>
                                    <td>
                                        @if($media->contenu)
                                            <a href="{{ route('contenus.show', $media->id_contenu) }}">
                                                {{ $media->contenu->titre }}
                                            </a>
                                        @else
                                            <span class="text-muted">Aucun</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Utilisateur</th>
                                    <td>{{ $media->utilisateur->name ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h5>Aperçu</h5>
                            <div class="border p-3 text-center" style="min-height: 300px; background: #f8f9fa;">
                                @if($media->isImage())
                                    <img src="{{ $media->url }}" alt="{{ $media->nom_fichier }}" class="img-fluid" style="max-height: 400px;">
                                @elseif($media->isVideo())
                                    <video controls style="max-width: 100%; max-height: 400px;">
                                        <source src="{{ $media->url }}" type="{{ $media->mime_type }}">
                                        Votre navigateur ne supporte pas la lecture de vidéos.
                                    </video>
                                @else
                                    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px;">
                                        <i class="bi bi-file-earmark-text" style="font-size: 80px; color: #6c757d;"></i>
                                        <p class="mt-3 text-muted">Aperçu non disponible pour ce type de fichier</p>
                                        <a href="{{ $media->url }}" target="_blank" class="btn btn-primary mt-2">
                                            <i class="bi bi-download"></i> Télécharger
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-3">
                                <a href="{{ $media->url }}" target="_blank" class="btn btn-info btn-block">
                                    <i class="bi bi-eye"></i> Voir le fichier
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
