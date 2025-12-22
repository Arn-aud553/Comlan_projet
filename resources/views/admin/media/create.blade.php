@extends('layouts.admin')

@section('content')
  <div class="container-fluid">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title">Ajouter un média</h3>
        <a href="{{ route('admin.media.index') }}" class="btn btn-secondary btn-sm">Retour</a>
      </div>
      <div class="card-body">
        <form action="{{ route('admin.media.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="row">
            <div class="col-md-6 mb-3">
              {{-- Utilisateur selection removed or hidden as admin creates it? 
                   Wait, the controller passes $contenus, but the previous view used $users too.
                   Let's check the controller createMedia method again. It only passes $contenus.
                   So I should probably remove the user selection or handle it differently if not passed.
                   For now, I'll assume current auth user or let the controller handle it.
                   Actually, looking at the error log, createMedia only compacts 'contenus'.
               --}}
               {{-- 
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
              --}}
            </div>

            <div class="col-md-12 mb-3">
              <label for="id_contenu" class="form-label">Contenu associé (optionnel)</label>
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
                <label for="type_fichier" class="form-label">Type de fichier</label>
                <select name="type_fichier" id="type_fichier" class="form-select" required>
                    <option value="image">Image</option>
                    <option value="video">Vidéo</option>
                    <option value="audio">Audio</option>
                    <option value="document">Document</option>
                    <option value="pdf">PDF</option>
                </select>
                @error('type_fichier') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-12 mb-3">
              <textarea name="description" id="description" class="form-control" rows="3" placeholder="Description du média (optionnel)">{{ old('description') }}</textarea>
              @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
            
            <div class="col-md-12 mb-3">
              <label for="prix" class="form-label">Prix (FCFA)</label>
              <input type="number" name="prix" id="prix" class="form-control" 
                     value="{{ old('prix', 0) }}" min="0" step="100" placeholder="0 pour gratuit">
              <small class="text-muted">Laissez à 0 ou vide pour rendre ce média gratuit.</small>
              @error('prix') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>
          </div>

          <div class="mb-3">
            <label for="fichier" class="form-label">Fichier média *</label>
            <input type="file" name="fichier" id="fichier" class="form-control" required>
            <small class="text-muted">Formats acceptés : Images, Vidéos, Audios, Documents. Max 500MB</small>
            @error('fichier') <div class="text-danger small">{{ $message }}</div> @enderror
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Créer</button>
            <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">Annuler</a>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
