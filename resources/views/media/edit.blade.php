@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Modifier un média</h3>
            <a href="{{ route('media.show', ['medium' => $media->id_media]) }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Retour
            </a>
        </div>
        <div class="card-body">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <form action="{{ route('media.update', ['medium' => $media->id_media]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <h5>Informations actuelles</h5>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th width="40%">Nom du fichier</th>
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
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h5>Aperçu</h5>
                        <div class="border p-2 text-center" style="max-height: 200px; overflow: hidden; background: #f8f9fa;">
                            @if($media->isImage())
                                <img src="{{ $media->url }}" alt="{{ $media->nom_fichier }}" style="max-height: 180px; max-width: 100%;">
                            @else
                                <i class="bi bi-file-earmark" style="font-size: 60px; color: #6c757d;"></i>
                            @endif
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <h5>Modifier les associations</h5>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_utilisateur" class="form-label">Utilisateur *</label>
                        <select name="id_utilisateur" id="id_utilisateur" class="form-select" required>
                            <option value="">-- Choisir --</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ old('id_utilisateur', $media->id_utilisateur) == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_utilisateur') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="id_contenu" class="form-label">Contenu associé</label>
                        <select name="id_contenu" id="id_contenu" class="form-select">
                            <option value="">-- Aucun --</option>
                            @foreach($contenus as $c)
                                <option value="{{ $c->id_contenu }}" {{ old('id_contenu', $media->id_contenu) == $c->id_contenu ? 'selected' : '' }}>
                                    {{ $c->titre }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_contenu') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="titre" class="form-label">Titre</label>
                        <input type="text" name="titre" id="titre" class="form-control" 
                               value="{{ old('titre', $media->titre) }}" maxlength="255" placeholder="Titre du média (optionnel)">
                        @error('titre') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3" placeholder="Description du média (optionnel)">{{ old('description', $media->description) }}</textarea>
                        @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nom_fichier" class="form-label">Nom d'affichage *</label>
                        <input type="text" name="nom_fichier" id="nom_fichier" class="form-control" 
                               value="{{ old('nom_fichier', $media->nom_fichier) }}" required maxlength="255">
                        <small class="text-muted">Le nom affiché pour ce fichier</small>
                        @error('nom_fichier') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="type_fichier" class="form-label">Type de fichier *</label>
                        <select name="type_fichier" id="type_fichier" class="form-select" required>
                            <option value="image" {{ old('type_fichier', $media->type_fichier) == 'image' ? 'selected' : '' }}>Image</option>
                            <option value="video" {{ old('type_fichier', $media->type_fichier) == 'video' ? 'selected' : '' }}>Vidéo</option>
                            <option value="document" {{ old('type_fichier', $media->type_fichier) == 'document' ? 'selected' : '' }}>Document</option>
                            <option value="livre" {{ old('type_fichier', $media->type_fichier) == 'livre' ? 'selected' : '' }}>Livre</option>
                        </select>
                        @error('type_fichier') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="extension" class="form-label">Extension *</label>
                    <input type="text" name="extension" id="extension" class="form-control" 
                           value="{{ old('extension', $media->extension) }}" required maxlength="10">
                    <small class="text-muted">Extension du fichier (ex: jpg, mp4, pdf)</small>
                    @error('extension') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    <strong>Note :</strong> Le fichier physique ne peut pas être modifié. Pour changer le fichier, supprimez ce média et créez-en un nouveau.
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Enregistrer les modifications
                    </button>
                    <a href="{{ route('media.show', $media) }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection