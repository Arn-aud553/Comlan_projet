@extends('layouts.admin')

@section('title', 'Modifier le Type de Contenu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/type_contenus.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4 types-contenus-container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient-types-contenus py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-pencil-square fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Modifier le Type de Contenu</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    Modifier les informations du type de contenu
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('type_contenus.index') }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-arrow-left me-2"></i> Retour
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Formulaire -->
                <div class="card-body p-4">
                    <div class="form-card-type-contenu">
                        <form action="{{ route('type_contenus.update', $typeContenu->id_type_contenu) }}" method="POST">
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
                                    <div class="info-type-contenu mb-3 p-3 bg-light rounded">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-dark me-2">ID: {{ $typeContenu->id_type_contenu }}</span>
                                                <span class="text-muted">
                                                    Créé le: {{ $typeContenu->created_at->format('d/m/Y H:i') }}
                                                </span>
                                            </div>
                                            <div>
                                                <span class="badge bg-info">
                                                    <i class="bi bi-file-text me-1"></i>
                                                    {{ $typeContenu->contenus()->count() }} contenu(s)
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <label for="nom" class="form-label">
                                        <i class="bi bi-tag me-1"></i> Nom du type de contenu *
                                    </label>
                                    <input type="text" 
                                           name="nom" 
                                           id="nom" 
                                           class="form-control @error('nom') is-invalid @enderror"
                                           value="{{ old('nom', $typeContenu->nom) }}"
                                           required
                                           placeholder="Ex: Article, Vidéo, Image, Podcast...">
                                    @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Maximum 100 caractères. Le nom doit être unique.
                                    </div>
                                    <div class="mt-2 small text-muted" id="charCount">{{ strlen($typeContenu->nom) }}/100 caractères</div>
                                </div>

                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="{{ route('type_contenus.show', $typeContenu->id_type_contenu) }}" 
                                               class="btn btn-outline-info me-2">
                                                <i class="bi bi-eye me-2"></i> Voir
                                            </a>
                                            <button type="reset" class="btn btn-type-contenu-secondary">
                                                <i class="bi bi-arrow-clockwise me-2"></i> Réinitialiser
                                            </button>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('type_contenus.index') }}" class="btn btn-outline-secondary">
                                                <i class="bi bi-x-circle me-2"></i> Annuler
                                            </a>
                                            <button type="submit" class="btn btn-type-contenu-primary">
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
$(document).ready(function() {
    // Compteur de caractères
    $('#nom').on('input', function() {
        var length = $(this).val().length;
        $('#charCount').text(length + '/100 caractères');
        
        if (length > 100) {
            $('#charCount').addClass('text-danger');
        } else {
            $('#charCount').removeClass('text-danger');
        }
    });

    // Vérification en temps réel de l'unicité (excluant le type courant)
    $('#nom').on('blur', function() {
        var nom = $(this).val();
        var currentId = {{ $typeContenu->id_type_contenu }};
        
        if (nom.length > 0 && nom !== '{{ $typeContenu->nom }}') {
            $.ajax({
                url: '/api/check-type-contenu',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    nom: nom,
                    exclude_id: currentId
                },
                success: function(response) {
                    if (response.exists) {
                        $('#nom').addClass('is-invalid');
                        $('#nom').next('.invalid-feedback').remove();
                        $('#nom').after('<div class="invalid-feedback">Ce type de contenu existe déjà.</div>');
                    } else {
                        $('#nom').removeClass('is-invalid');
                        $('#nom').next('.invalid-feedback').remove();
                    }
                }
            });
        }
    });
});
</script>
@endpush
@endsection