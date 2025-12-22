@extends('layouts.admin')

@section('title', 'Gestion des Types de Contenu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/type_contenus.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête avec Actions Export -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 search-filter-title">
                <i class="bi bi-tags"></i> TYPES DE CONTENUS
            </h1>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-export btn-export-copy"><i class="bi bi-clipboard"></i> Copier</button>
            <button class="btn btn-export btn-export-excel"><i class="bi bi-file-earmark-excel"></i> Excel</button>
            <button class="btn btn-export btn-export-pdf"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
            <button class="btn btn-export btn-export-print"><i class="bi bi-printer"></i> Imprimer</button>
            <a href="{{ route('admin.type_contenus.create') }}" class="btn btn-primary d-flex align-items-center ms-3">
                 <i class="bi bi-plus-circle me-2"></i> Nouveau
            </a>
        </div>
    </div>

    <!-- Carte Recherche & Filtres -->
    <div class="search-filter-container">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold text-uppercase small text-muted">Recherche</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="customSearch" class="form-control border-start-0 ps-0" placeholder="Nom ou ID...">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold text-uppercase small text-muted">Contenus Associés</label>
                <select id="customFilter" class="form-select">
                    <option value="">Tous</option>
                    <option value="avec">Avec contenus</option>
                    <option value="sans">Sans contenu</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="typesContenusTable" class="table table-admin table-hover mb-0 w-100">
                    <thead class="bg-light">
                        <tr>
                            <th width="10%"># ID</th>
                            <th width="40%">TYPE</th>
                            <th width="20%">CONTENUS</th>
                            <th width="15%">DATE CRÉATION</th>
                            <th width="15%" class="text-end">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($typesContenu as $type)
                            <tr>
                                <td>
                                    <span class="badge-id">{{ str_pad($type->id_type_contenu, 3, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="badge-code me-3">{{ strtoupper(substr($type->nom, 0, 2)) }}</span>
                                        <span class="fw-bold text-dark">{{ $type->nom }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-count">
                                        <i class="bi bi-file-text"></i> {{ $type->contenus_count }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-column text-muted small">
                                        <span><i class="bi bi-calendar3 me-1"></i> {{ $type->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div class="action-btn-group">
                                        <a href="{{ route('admin.type_contenus.show', $type->id_type_contenu) }}" 
                                           class="btn-action btn-action-view" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.type_contenus.edit', $type->id_type_contenu) }}" 
                                           class="btn-action btn-action-edit" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.type_contenus.destroy', $type->id_type_contenu) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Supprimer ce type ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete" title="Supprimer">
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


@endsection

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#typesContenusTable').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
        },
        dom: 'rtip', // Hide default search box
        pageLength: 10,
        columnDefs: [
            { orderable: false, targets: 4 }
        ]
    });

    // Custom Search
    $('#customSearch').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Custom Filter
    $('#customFilter').on('change', function() {
        var val = this.value;
        // Ceci est une simplification, pour un vrai filtre colonne, on ciblerait la colonne spécifique
        // Ici on filtre globalement pour l'exemple, ou on implémente une regex sur la colonne contenus
        if(val === 'avec') {
             table.column(2).search('[1-9]', true, true).draw();
        } else if(val === 'sans') {
             table.column(2).search('0', true, true).draw(); // Cherche "0"
        } else {
             table.column(2).search('').draw();
        }
    });
});
</script>
@endpush