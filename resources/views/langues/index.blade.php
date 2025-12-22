@extends('layouts.admin')

@section('title', 'Gestion des Langues')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 search-filter-title">
                <i class="bi bi-translate"></i> GESTION DES LANGUES
            </h1>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-export btn-export-copy"><i class="bi bi-clipboard"></i> Copier</button>
            <button class="btn btn-export btn-export-excel"><i class="bi bi-file-earmark-excel"></i> Excel</button>
            <button class="btn btn-export btn-export-pdf"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
            <button class="btn btn-export btn-export-print"><i class="bi bi-printer"></i> Imprimer</button>
            <a href="{{ route('admin.langues.create') }}" class="btn btn-primary d-flex align-items-center ms-3">
                 <i class="bi bi-plus-circle me-2"></i> Nouvelle Langue
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
            <div class="col-md-12">
                <label class="form-label fw-bold text-uppercase small text-muted">Recherche</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="customSearch" class="form-control border-start-0 ps-0" placeholder="Nom, Code...">
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="languesTable" class="table table-admin table-hover mb-0 w-100">
                    <thead class="bg-light">
                        <tr>
                            <th width="10%"># ID</th>
                            <th width="25%">LANGUE</th>
                            <th width="10%">CODE</th>
                            <th width="40%">DESCRIPTION</th>
                            <th width="15%" class="text-end">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($langues as $langue)
                        <tr>
                            <td>
                                <span class="badge-id">{{ str_pad($langue->id_langue, 3, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>
                                <strong class="text-dark">{{ $langue->nom_langue }}</strong>
                            </td>
                            <td>
                                <span class="badge-code">{{ $langue->code_langue }}</span>
                            </td>
                            <td>
                                <div class="text-muted small text-truncate" style="max-width: 300px;">
                                    {{ $langue->description ?? 'Aucune description' }}
                                </div>
                            </td>

                            <td class="text-end">
                                <div class="action-btn-group">
                                    <a href="{{ route('admin.langues.show', $langue->id_langue) }}" 
                                       class="btn-action btn-action-view" 
                                       title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.langues.edit', $langue->id_langue) }}" 
                                       class="btn-action btn-action-edit" 
                                       title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.langues.destroy', $langue->id_langue) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette langue ?');">
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
                {{ $langues->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialisation DataTable simplifiée
    var table = $('#languesTable').DataTable({
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json" },
        dom: 'rtip', // Table sans header/footer par défaut car on a nos filtres customs
        paging: false,
        info: false,
        columnDefs: [{ orderable: false, targets: 4 }]
    });
    
    // Recherche et Filtres Customs
    $('#customSearch').on('keyup', function() {
        table.search(this.value).draw();
    });
    

});
</script>
@endpush