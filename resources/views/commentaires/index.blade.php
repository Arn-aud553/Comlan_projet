@extends('layouts.admin')

@section('title', 'Gestion des Commentaires')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/commentaires.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4 commentaires-container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient-commentaires py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-chat-left-text fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Gestion des Commentaires</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    {{ $commentaires->total() }} commentaires au total
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('commentaires.create') }}" class="btn btn-primary btn-sm d-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i>
                                <span>Nouveau Commentaire</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Corps de la carte -->
                <div class="card-body p-4">
                    <!-- Section Filtres -->
                    <div class="filtres-section-commentaires mb-4">
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="filterTexte" class="form-label">
                                            <i class="bi bi-search me-1"></i> Recherche
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-search text-primary"></i>
                                            </span>
                                            <input type="text" id="filterTexte" class="form-control shadow-none" placeholder="Texte du commentaire...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="filterNote" class="form-label">
                                            <i class="bi bi-star me-1"></i> Note
                                        </label>
                                        <select id="filterNote" class="form-select shadow-none">
                                            <option value="">Toutes les notes</option>
                                            <option value="0">0 étoiles</option>
                                            <option value="1">1 étoile</option>
                                            <option value="2">2 étoiles</option>
                                            <option value="3">3 étoiles</option>
                                            <option value="4">4 étoiles</option>
                                            <option value="5">5 étoiles</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button id="resetFilters" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                                        <i class="bi bi-arrow-clockwise me-2"></i>
                                        Réinitialiser
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table DataTable -->
                    <div class="table-responsive">
                        <table id="commentairesTable" class="table table-commentaires">
                            <thead>
                                <tr>
                                    <th width="5%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-hash me-2"></i> ID
                                        </div>
                                    </th>
                                    <th width="30%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-chat-left-text me-2"></i> Commentaire
                                        </div>
                                    </th>
                                    <th width="10%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-star me-2"></i> Note
                                        </div>
                                    </th>
                                    <th width="20%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-file-text me-2"></i> Contenu
                                        </div>
                                    </th>
                                    <th width="15%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person me-2"></i> Utilisateur
                                        </div>
                                    </th>
                                    <th width="15%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-gear me-2"></i> Actions
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commentaires as $commentaire)
                                <tr>
                                    <td>
                                        <span class="badge bg-dark rounded-pill px-3 py-2">
                                            {{ str_pad($commentaire->id_commentaire, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="texte-commentaire" data-fulltexte="{{ $commentaire->texte }}">
                                            {{ Str::limit($commentaire->texte, 80) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($commentaire->note)
                                            <span class="badge badge-commentaire badge-note">
                                                <i class="bi bi-star-fill me-1"></i>
                                                {{ $commentaire->note }}/5
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Non noté</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($commentaire->contenu)
                                            <span class="badge badge-commentaire badge-contenu" title="{{ $commentaire->contenu->titre }}">
                                                {{ Str::limit($commentaire->contenu->titre, 25) }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Contenu supprimé</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($commentaire->utilisateur)
                                            <span class="badge badge-commentaire badge-utilisateur">
                                                {{ $commentaire->utilisateur->name ?? 'Utilisateur' }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Anonyme</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons-commentaires">
                                            <a href="{{ route('commentaires.show', $commentaire->id_commentaire) }}" 
                                               class="action-btn-commentaire action-btn-info-commentaire" 
                                               title="Voir les détails" 
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('commentaires.edit', $commentaire->id_commentaire) }}" 
                                               class="action-btn-commentaire action-btn-warning-commentaire" 
                                               title="Modifier" 
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('commentaires.destroy', $commentaire->id_commentaire) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="action-btn-commentaire action-btn-danger-commentaire" 
                                                        title="Supprimer" 
                                                        data-bs-toggle="tooltip">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialisation de DataTable
    var table = $('#commentairesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json'
        },
        pageLength: 15,
        lengthMenu: [[10, 15, 25, 50, 100], [10, 15, 25, 50, 100]],
        responsive: true,
        autoWidth: false,
        order: [[0, 'desc']],
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        columnDefs: [
            {
                targets: [1, 5], // Texte et Actions
                orderable: false
            },
            {
                targets: [0], // ID
                searchable: false
            }
        ],
        buttons: [
            {
                extend: 'copy',
                className: 'btn btn-secondary btn-sm',
                text: '<i class="bi bi-copy me-2"></i>Copier'
            },
            {
                extend: 'excel',
                className: 'btn btn-success btn-sm',
                text: '<i class="bi bi-file-earmark-excel me-2"></i>Excel',
                title: 'Commentaires - Culture Bénin'
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                text: '<i class="bi bi-file-earmark-pdf me-2"></i>PDF',
                title: 'Commentaires - Culture Bénin'
            },
            {
                extend: 'print',
                className: 'btn btn-info btn-sm',
                text: '<i class="bi bi-printer me-2"></i>Imprimer',
                title: 'Commentaires - Culture Bénin'
            }
        ],
        initComplete: function() {
            // Ajouter les boutons d'export
            this.api().buttons().container().appendTo('.filtres-section-commentaires .col-md-4');
        }
    });
    
    // Filtre par texte
    $('#filterTexte').on('keyup', function() {
        table.search(this.value).draw();
    });
    
    // Filtre par note
    $('#filterNote').on('change', function() {
        if (this.value === '') {
            table.column(2).search('').draw();
        } else {
            table.column(2).search('^' + this.value + '$', true, false).draw();
        }
    });
    
    // Réinitialiser les filtres
    $('#resetFilters').on('click', function() {
        $('#filterTexte').val('');
        $('#filterNote').val('');
        table.search('').columns().search('').draw();
    });
    
    // Tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endpush