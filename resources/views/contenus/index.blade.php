@extends('layouts.admin')

@section('title', 'Gestion des Contenus')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/contenus.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4 contenus-container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient-contenus py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-file-text fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Gestion des Contenus</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    {{ $contenus->total() }} contenus au total
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admin.contenus.create') }}" class="btn btn-primary btn-sm d-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i>
                                <span>Nouveau Contenu</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Corps de la carte -->
                <div class="card-body p-4">
                    <!-- Section Filtres -->
                    <div class="filtres-section-contenus mb-4">
                        <div class="row align-items-end">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="filterTitre" class="form-label">
                                            <i class="bi bi-search me-1"></i> Recherche
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-search text-primary"></i>
                                            </span>
                                            <input type="text" id="filterTitre" class="form-control shadow-none" placeholder="Titre ou contenu...">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="filterLangue" class="form-label">
                                            <i class="bi bi-translate me-1"></i> Langue
                                        </label>
                                        <select id="filterLangue" class="form-select shadow-none">
                                            <option value="">Toutes</option>
                                            @foreach($langues as $langue)
                                            <option value="{{ $langue->id_langue }}">{{ $langue->nom_langue }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="filterRegion" class="form-label">
                                            <i class="bi bi-geo-alt me-1"></i> Région
                                        </label>
                                        <select id="filterRegion" class="form-select shadow-none">
                                            <option value="">Toutes</option>
                                            @foreach($regions as $region)
                                            <option value="{{ $region->id_region }}">{{ $region->nom_region }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="filterStatut" class="form-label">
                                            <i class="bi bi-circle-fill me-1"></i> Statut
                                        </label>
                                        <select id="filterStatut" class="form-select shadow-none">
                                            <option value="">Tous</option>
                                            <option value="publié">Publié</option>
                                            <option value="en attente">En attente</option>
                                            <option value="brouillon">Brouillon</option>
                                            <option value="rejeté">Rejeté</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filterAuteur" class="form-label">
                                            <i class="bi bi-person me-1"></i> Auteur
                                        </label>
                                        <select id="filterAuteur" class="form-select shadow-none">
                                            <option value="">Tous</option>
                                            @foreach($auteurs as $auteur)
                                            <option value="{{ $auteur->id }}">{{ $auteur->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-2">
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
                        <table id="contenusTable" class="table table-contenus">
                            <thead>
                                <tr>
                                    <th width="5%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-hash me-2"></i> ID
                                        </div>
                                    </th>
                                    <th width="20%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-text-left me-2"></i> Titre
                                        </div>
                                    </th>
                                    <th width="12%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person me-2"></i> Auteur
                                        </div>
                                    </th>
                                    <th width="10%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-translate me-2"></i> Langue
                                        </div>
                                    </th>
                                    <th width="10%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-circle-fill me-2"></i> Statut
                                        </div>
                                    </th>
                                    <th width="12%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-calendar me-2"></i> Date
                                        </div>
                                    </th>
                                    <th width="10%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-folder me-2"></i> Sous-contenus
                                        </div>
                                    </th>
                                    <th width="10%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-gear me-2"></i> Actions
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contenus as $contenu)
                                <tr>
                                    <td>
                                        <span class="badge bg-dark rounded-pill px-3 py-2">
                                            {{ str_pad($contenu->id_contenu, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong class="text-primary">{{ Str::limit($contenu->titre, 40) }}</strong>
                                        <div class="small text-muted mt-1">
                                            {{ Str::limit(strip_tags($contenu->texte), 60) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($contenu->auteur)
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-circle me-2 text-secondary"></i>
                                            <span>{{ $contenu->auteur->name }}</span>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($contenu->langue)
                                        <span class="badge badge-langue">
                                            {{ $contenu->langue->nom_langue }}
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = 'bg-secondary';
                                            if($contenu->statut == 'publié') $badgeClass = 'bg-success';
                                            if($contenu->statut == 'en attente') $badgeClass = 'bg-warning';
                                            if($contenu->statut == 'rejeté') $badgeClass = 'bg-danger';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            {{ ucfirst($contenu->statut) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="d-block">
                                            <i class="bi bi-calendar-plus text-primary"></i>
                                            {{ $contenu->date_creation->format('d/m/Y') }}
                                        </small>
                                        @if($contenu->date_validation)
                                        <small class="d-block text-success">
                                            <i class="bi bi-check-circle"></i>
                                            {{ $contenu->date_validation->format('d/m/Y') }}
                                        </small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-enfants-count">
                                            <i class="bi bi-folder me-1"></i>
                                            {{ $contenu->enfants_count }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons-contenus">
                                            <a href="{{ route('contenus.show', $contenu->id_contenu) }}" 
                                               class="action-btn-contenu action-btn-info-contenu" 
                                               title="Voir les détails" 
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('contenus.edit', $contenu->id_contenu) }}" 
                                               class="action-btn-contenu action-btn-warning-contenu" 
                                               title="Modifier" 
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            @if(in_array(Auth::user()->role, ['moderateur', 'admin']) && $contenu->peutEtreValide())
                                            <form action="{{ route('contenus.valider', $contenu->id_contenu) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Voulez-vous vraiment valider et publier ce contenu ?')">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" 
                                                        class="action-btn-contenu action-btn-success-contenu" 
                                                        title="Valider et publier" 
                                                        data-bs-toggle="tooltip">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>
                                            @endif
                                            <form action="{{ route('contenus.destroy', $contenu->id_contenu) }}" 
      method="POST" 
      class="d-inline"
      onsubmit="return confirmDeleteContenu({{ $contenu->media_count }}, {{ $contenu->commentaires_count }})">

                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="action-btn-contenu action-btn-danger-contenu" 
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
    var table = $('#contenusTable').DataTable({
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
                targets: [7], // Actions
                orderable: false
            },
            {
                targets: [0, 6], // ID et Sous-contenus
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
                title: 'Contenus - Culture Bénin'
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                text: '<i class="bi bi-file-earmark-pdf me-2"></i>PDF',
                title: 'Contenus - Culture Bénin'
            },
            {
                extend: 'print',
                className: 'btn btn-info btn-sm',
                text: '<i class="bi bi-printer me-2"></i>Imprimer',
                title: 'Contenus - Culture Bénin'
            }
        ],
        initComplete: function() {
            // Ajouter les boutons d'export
            this.api().buttons().container().appendTo('.filtres-section-contenus .col-md-2');
        }
    });
    
    // Filtre par titre/contenu
    $('#filterTitre').on('keyup', function() {
        table.search(this.value).draw();
    });
    
    // Filtre par langue
    $('#filterLangue').on('change', function() {
        var column = table.column(3); // Colonne langue (index 3)
        if (this.value === '') {
            column.search('').draw();
        } else {
            column.search('^' + $(this).find('option:selected').text() + '$', true, false).draw();
        }
    });
    
    // Filtre par région
    $('#filterRegion').on('change', function() {
        var column = table.column(4); // Colonne région
        if (this.value === '') {
            column.search('').draw();
        } else {
            column.search('^' + $(this).find('option:selected').text() + '$', true, false).draw();
        }
    });
    
    // Filtre par statut
    $('#filterStatut').on('change', function() {
        var column = table.column(4); // Colonne statut
        if (this.value === '') {
            column.search('').draw();
        } else {
            column.search('^' + this.value + '$', true, false).draw();
        }
    });
    
    // Filtre par auteur
    $('#filterAuteur').on('change', function() {
        var column = table.column(2); // Colonne auteur (index 2)
        if (this.value === '') {
            column.search('').draw();
        } else {
            column.search('^' + $(this).find('option:selected').text() + '$', true, false).draw();
        }
    });
    
    // Réinitialiser les filtres
    $('#resetFilters').on('click', function() {
        $('#filterTitre').val('');
        $('#filterLangue').val('');
        $('#filterRegion').val('');
        $('#filterStatut').val('');
        $('#filterAuteur').val('');
        table.search('').columns().search('').draw();
    });
    
    // Tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Confirmation de suppression personnalisée
 window.confirmDeleteContenu = function(mediaCount, commentairesCount) {
    let message = 'Êtes-vous sûr de vouloir supprimer ce contenu ?';
    
    if (mediaCount > 0 || commentairesCount > 0) {
        message = 'Ce contenu est associé à ' + 
                  mediaCount + ' média(s) et ' + 
                  commentairesCount + ' commentaire(s). ' +
                  'Êtes-vous sûr de vouloir le supprimer ?';
    }
    
    return confirm(message);
};
});
</script>
@endpush