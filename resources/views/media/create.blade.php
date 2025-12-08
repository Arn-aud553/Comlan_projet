@extends('layouts.admin')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Ajouter un média</h3>
        <a href="{{ route('media.index') }}" class="btn btn-secondary btn-sm">Retour</a>
      </div>
      <div class="card-body">
        <form action="{{ route('media.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="id_utilisateur" class="form-label">Utilisateur</label>
              <select name="id_utilisateur" id="id_utilisateur" class="form-select" required>
                <option value="">-- Choisir --</option>
                @foreach($users as $u)
                  <option value="{{ $u->id }}" {{ old('id_utilisateur') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                @endforeach
              </select>
              @error('id_utilisateur') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
              <label for="id_contenu" class="form-label">Contenu (optionnel)</label>
              <select name="id_contenu" id="id_contenu" class="form-select">
                <option value="">-- Aucun --</option>
                @foreach($contenus as $c)
                  <option value="{{ $c->id_contenu }}" {{ old('id_contenu') == $c->id_contenu ? 'selected' : '' }}>{{ $c->titre }}</option>
                @endforeach
              </select>
              @error('id_contenu') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 mb-3">
              <label for="titre" class="form-label">Titre</label>
              <input type="text" name="titre" id="titre" class="form-control" 
                     value="{{ old('titre') }}" maxlength="255" placeholder="Titre du média (optionnel)">
              @error('titre') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-12 mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea name="description" id="description" class="form-control" rows="3" placeholder="Description du média (optionnel)">{{ old('description') }}</textarea>
              @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label for="fichier" class="form-label">Fichier média *</label>
            <input type="file" name="fichier" id="fichier" class="form-control" required>
            <small class="text-muted">Formats acceptés : Images (jpg, png, gif), Vidéos (mp4, avi, mov), Documents (pdf, doc, txt), Livres (epub, mobi). Max 500MB</small>
            @error('fichier') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Créer</button>
            <a href="{{ route('media.index') }}" class="btn btn-secondary">Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
