@extends('layouts.admin')

@section('title', 'Modifier le Commentaire')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/commentaires.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4 commentaires-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient-commentaires py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-pencil-square fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Modifier le Commentaire</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    #{{ $commentaire->id_commentaire }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('commentaires.show', $commentaire->id_commentaire) }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-eye me-2"></i> Voir
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Formulaire -->
                <div class="card-body p-4">
                    <div class="form-card-commentaire">
                        <form action="{{ route('commentaires.update', $commentaire->id_commentaire) }}" method="POST">
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
                                    <label for="texte" class="form-label">
                                        <i class="bi bi-chat-left-text me-1"></i> Texte du commentaire *
                                    </label>
                                    <textarea name="texte" 
                                              id="texte" 
                                              class="form-control @error('texte') is-invalid @enderror"
                                              rows="6"
                                              required
                                              placeholder="Saisissez le texte du commentaire...">{{ old('texte', $commentaire->texte) }}</textarea>
                                    @error('texte')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Maximum 2000 caractères</div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label">
                                        <i class="bi bi-star me-1"></i> Note (optionnelle)
                                    </label>
                                    <div class="star-rating">
                                        @for($i = 5; $i >= 1; $i--)
                                            <input type="radio" 
                                                   id="star{{ $i }}" 
                                                   name="note" 
                                                   value="{{ $i }}"
                                                   {{ old('note', $commentaire->note) == $i ? 'checked' : '' }}>
                                            <label for="star{{ $i }}" title="{{ $i }} étoiles">
                                                <i class="bi bi-star-fill"></i>
                                            </label>
                                        @endfor
                                        <input type="radio" 
                                               id="star0" 
                                               name="note" 
                                               value=""
                                               {{ old('note', $commentaire->note) === null || old('note', $commentaire->note) === '' ? 'checked' : '' }}
                                               style="display: none;">
                                        <label for="star0" class="ms-2 text-muted small">
                                            Aucune note
                                        </label>
                                    </div>
                                    @error('note')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="id_contenu" class="form-label">
                                        <i class="bi bi-file-text me-1"></i> Contenu associé *
                                    </label>
                                    <select name="id_contenu" 
                                            id="id_contenu" 
                                            class="form-select @error('id_contenu') is-invalid @enderror"
                                            required>
                                        <option value="">Sélectionnez un contenu</option>
                                        @foreach($contenus ?? [] as $contenu)
                                            <option value="{{ $contenu->id_contenu }}" 
                                                    {{ old('id_contenu', $commentaire->id_contenu) == $contenu->id_contenu ? 'selected' : '' }}>
                                                {{ $contenu->titre }} (ID: {{ $contenu->id_contenu }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_contenu')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label for="id_utilisateur" class="form-label">
                                        <i class="bi bi-person me-1"></i> Utilisateur (optionnel)
                                    </label>
                                    <select name="id_utilisateur" 
                                            id="id_utilisateur" 
                                            class="form-select @error('id_utilisateur') is-invalid @enderror">
                                        <option value="">Sélectionnez un utilisateur</option>
                                        @foreach($utilisateurs ?? [] as $utilisateur)
                                            <option value="{{ $utilisateur->id }}" 
                                                    {{ old('id_utilisateur', $commentaire->id_utilisateur) == $utilisateur->id ? 'selected' : '' }}>
                                                {{ $utilisateur->name }} ({{ $utilisateur->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_utilisateur')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="{{ route('commentaires.show', $commentaire->id_commentaire) }}" class="btn btn-commentaire-secondary">
                                                <i class="bi bi-x-circle me-2"></i> Annuler
                                            </a>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('commentaires.index') }}" class="btn btn-outline-secondary">
                                                <i class="bi bi-arrow-left me-2"></i> Retour à la liste
                                            </a>
                                            <button type="submit" class="btn btn-commentaire-primary">
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
// Charger les contenus et utilisateurs via AJAX si nécessaire
$(document).ready(function() {
    // Si les listes ne sont pas fournies, les charger via AJAX
    if ($('#id_contenu option').length <= 1) {
        $.get('/api/contenus', function(data) {
            $('#id_contenu').empty().append('<option value="">Sélectionnez un contenu</option>');
            $.each(data, function(index, contenu) {
                $('#id_contenu').append('<option value="' + contenu.id_contenu + '">' + contenu.titre + ' (ID: ' + contenu.id_contenu + ')</option>');
            });
            $('#id_contenu').val('{{ old("id_contenu", $commentaire->id_contenu) }}');
        });
    }

    if ($('#id_utilisateur option').length <= 1) {
        $.get('/api/utilisateurs', function(data) {
            $('#id_utilisateur').empty().append('<option value="">Sélectionnez un utilisateur</option>');
            $.each(data, function(index, utilisateur) {
                $('#id_utilisateur').append('<option value="' + utilisateur.id + '">' + utilisateur.name + ' (' + utilisateur.email + ')</option>');
            });
            $('#id_utilisateur').val('{{ old("id_utilisateur", $commentaire->id_utilisateur) }}');
        });
    }
});
</script>
@endpush
@endsection