@extends('layouts.admin')

@section('title', 'Gestion des Régions')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 search-filter-title">
                <i class="bi bi-geo-alt"></i> GESTION DES RÉGIONS
            </h1>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-export btn-export-copy"><i class="bi bi-clipboard"></i> Copier</button>
            <button class="btn btn-export btn-export-excel"><i class="bi bi-file-earmark-excel"></i> Excel</button>
            <button class="btn btn-export btn-export-pdf"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
            <button class="btn btn-export btn-export-print"><i class="bi bi-printer"></i> Imprimer</button>
            <a href="{{ route('admin.regions.create') }}" class="btn btn-primary d-flex align-items-center ms-3">
                 <i class="bi bi-plus-circle me-2"></i> Nouvelle Région
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Carte Recherche & Filtres -->
    <div class="search-filter-container">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold text-uppercase small text-muted">Recherche</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="customSearch" class="form-control border-start-0 ps-0" placeholder="Nom Région...">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold text-uppercase small text-muted">Contenus</label>
                <select id="customFilter" class="form-select">
                    <option value="">Tous les volumes</option>
                    <option value="0">Aucun contenu</option>
                    <option value="1-10">1 à 10 contenus</option>
                    <option value="10+">Plus de 10 contenus</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="regionsTable" class="table table-admin table-hover mb-0 w-100">
                    <thead class="bg-light">
                        <tr>
                            <th width="8%"># ID</th>
                            <th width="25%">RÉGION</th>
                            <th width="40%">DESCRIPTION</th>
                            <th width="12%">CONTENUS</th>
                            <th width="15%" class="text-end">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($regions as $region)
                        <tr>
                            <td>
                                <span class="badge-id">{{ str_pad($region->id_region, 3, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>
                                <strong class="text-dark">{{ $region->nom_region }}</strong>
                            </td>
                            <td>
                                <div class="text-muted small text-truncate" style="max-width: 300px;">
                                    {{ $region->description ?? 'Aucune description' }}
                                </div>
                            </td>
                            <td>
                                <span class="badge-count">
                                    <i class="bi bi-file-text me-1"></i>
                                    {{ $region->contenus_count }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="action-btn-group">
                                    <a href="{{ route('admin.regions.show', $region->id_region) }}" 
                                       class="btn-action btn-action-view" 
                                       title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.regions.edit', $region->id_region) }}" 
                                       class="btn-action btn-action-edit" 
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.regions.destroy', $region->id_region) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette région ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn-action btn-action-delete" 
                                                title="Supprimer">
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
            <div class="px-3 py-3 border-top">
                {{ $regions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialisation DataTable simplifiée et unifiée
    var table = $('#regionsTable').DataTable({
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json" },
        dom: 'rtip', 
        paging: false,
        info: false,
        columnDefs: [{ orderable: false, targets: 4 }] // Colonne Actions (index 4)
    });
    
    // Recherche
    $('#customSearch').on('keyup', function() {
        table.search(this.value).draw();
    });
    
    // Filtre Custom Contenus (Colonne 3)
    $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
        var min = 0;
        var max = 999999;
        var filterVal = $('#customFilter').val();
         
        if (filterVal == "0") { min = 0; max = 0; }
        if (filterVal == "1-10") { min = 1; max = 10; }
        if (filterVal == "10+") { min = 11; max = 999999; }
        if (filterVal == "") return true;

        var count = parseInt(data[3].replace(/[^0-9]/g, '')) || 0;
        return (count >= min && count <= max);
    });

    $('#customFilter').on('change', function() {
        table.draw();
    });
});
</script>
@endpush