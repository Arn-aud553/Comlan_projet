@extends('layouts.admin')

@section('title', 'Gestion des Régions')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/regions.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4 regions-container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient-regions py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-geo-alt fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Gestion des Régions</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    {{ $regions->total() }} régions au total
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('regions.create') }}" class="btn btn-primary btn-sm d-flex align-items-center">
                                <i class="bi bi-plus-circle me-2"></i>
                                <span>Nouvelle Région</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Corps de la carte -->
                <div class="card-body p-4">
                    <!-- Section Filtres -->
                    <div class="filtres-section-regions mb-4">
                        <div class="row align-items-end">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="filterNom" class="form-label">
                                            <i class="bi bi-search me-1"></i> Recherche
                                        </label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light">
                                                <i class="bi bi-search text-primary"></i>
                                            </span>
                                            <input type="text" id="filterNom" class="form-control shadow-none" placeholder="Nom de la région...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="filterContenus" class="form-label">
                                            <i class="bi bi-file-text me-1"></i> Contenus
                                        </label>
                                        <select id="filterContenus" class="form-select shadow-none">
                                            <option value="">Toutes</option>
                                            <option value="0">Sans contenus</option>
                                            <option value="1-10">1-10 contenus</option>
                                            <option value="10+">Plus de 10 contenus</option>
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
                        <table id="regionsTable" class="table table-regions">
                            <thead>
                                <tr>
                                    <th width="5%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-hash me-2"></i> ID
                                        </div>
                                    </th>
                                    <th width="25%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-geo-alt me-2"></i> Région
                                        </div>
                                    </th>
                                    <th width="40%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-text-paragraph me-2"></i> Description
                                        </div>
                                    </th>
                                    <th width="15%">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-file-text me-2"></i> Contenus
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
                                @foreach($regions as $region)
                                <tr>
                                    <td>
                                        <span class="badge bg-dark rounded-pill px-3 py-2">
                                            #{{ str_pad($region->id_region, 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong class="text-primary">{{ $region->nom_region }}</strong>
                                    </td>
                                    <td>
                                        <div class="description-region" data-fulldesc="{{ $region->description ?? 'Aucune description' }}">
                                            @if($region->description)
                                                {{ Str::limit($region->description, 80) }}
                                            @else
                                                <span class="text-muted">Aucune description</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-contenus-count-region">
                                            <i class="bi bi-file-text me-1"></i>
                                            {{ $region->contenus_count }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons-regions">
                                            <a href="{{ route('regions.show', $region->id_region) }}" 
                                               class="action-btn-region action-btn-info-region" 
                                               title="Voir les détails" 
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('regions.edit', $region->id_region) }}" 
                                               class="action-btn-region action-btn-warning-region" 
                                               title="Modifier" 
                                               data-bs-toggle="tooltip">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('regions.destroy', $region->id_region) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirmDeleteRegion({{ $region->contenus_count }})">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="action-btn-region action-btn-danger-region" 
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
    var table = $('#regionsTable').DataTable({
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
                targets: [2, 4], // Description et Actions
                orderable: false
            },
            {
                targets: [0, 3], // ID et Contenus
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
                title: 'Régions - Culture Bénin'
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger btn-sm',
                text: '<i class="bi bi-file-earmark-pdf me-2"></i>PDF',
                title: 'Régions - Culture Bénin'
            },
            {
                extend: 'print',
                className: 'btn btn-info btn-sm',
                text: '<i class="bi bi-printer me-2"></i>Imprimer',
                title: 'Régions - Culture Bénin'
            }
        ],
        initComplete: function() {
            // Ajouter les boutons d'export
            this.api().buttons().container().appendTo('.filtres-section-regions .col-md-4');
        }
    });
    
    // Filtre par nom
    $('#filterNom').on('keyup', function() {
        table.search(this.value).draw();
    });
    
    // Filtre par nombre de contenus
    // Filtre par nombre de contenus - CORRIGÉ
$('#filterContenus').on('change', function() {
    var value = this.value;
    
    // Réinitialiser le filtre précédent
    $.fn.dataTable.ext.search = [];
    
    if (value === '') {
        table.draw();
        return;
    }
    
    // Ajouter un nouveau filtre personnalisé
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        // Récupérer la cellule de la colonne 3 (Contenus)
        var cellData = data[3]; // Contient le HTML du badge
        
        // Extraire le nombre du HTML
        var count = 0;
        var match = cellData.match(/>(\d+)</);
        if (match && match[1]) {
            count = parseInt(match[1]);
        }
        
        // Appliquer le filtre selon la valeur sélectionnée
        switch(value) {
            case '0':
                return count === 0;
            case '1-10':
                return count >= 1 && count <= 10;
            case '10+':
                return count > 10;
            default:
                return true;
        }
    });
    
    table.draw();
});
    
    // Réinitialiser les filtres
    $('#resetFilters').on('click', function() {
        $('#filterNom').val('');
        $('#filterContenus').val('');
        table.search('').columns().search('').draw();
    });
    
    // Tooltips Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Confirmation de suppression personnalisée
    window.confirmDeleteRegion = function(contenusCount) {
        if (contenusCount > 0) {
            return confirm('Cette région est associée à ' + contenusCount + ' contenu(s). Êtes-vous sûr de vouloir la supprimer ?');
        }
        return confirm('Êtes-vous sûr de vouloir supprimer cette région ?');
    };
});
</script>
@endpush