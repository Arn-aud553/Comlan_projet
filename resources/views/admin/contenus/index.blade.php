@extends('layouts.admin')

@section('title', 'Gestion des Contenus')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 search-filter-title">
                <i class="bi bi-file-text"></i> GESTION DES CONTENUS
            </h1>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-export btn-export-copy"><i class="bi bi-clipboard"></i> Copier</button>
            <button class="btn btn-export btn-export-excel"><i class="bi bi-file-earmark-excel"></i> Excel</button>
            <button class="btn btn-export btn-export-pdf"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
            <button class="btn btn-export btn-export-print"><i class="bi bi-printer"></i> Imprimer</button>
            <a href="{{ route('admin.contenus.create') }}" class="btn btn-primary d-flex align-items-center ms-3">
                 <i class="bi bi-plus-circle me-2"></i> Nouveau
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
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
                    <input type="text" id="customSearch" class="form-control border-start-0 ps-0" placeholder="Titre, Auteur, Code...">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold text-uppercase small text-muted">Statut</label>
                <select id="customFilter" class="form-select">
                    <option value="">Tous les statuts</option>
                    <option value="publie">Publié</option>
                    <option value="en_attente">En attente</option>
                    <option value="brouillon">Brouillon</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="contenusTable" class="table table-admin table-hover mb-0 w-100">
                    <thead class="bg-light">
                        <tr>
                            <th width="8%"># ID</th>
                            <th width="30%">TITRE</th>
                            <th width="12%">TYPE</th>
                            <th width="15%">AUTEUR</th>
                            <th width="10%">STATUT</th>
                            <th width="10%">DATE</th>
                            <th width="15%" class="text-end">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contenus as $contenu)
                            <tr>
                                <td>
                                    <span class="badge-id">{{ ($contenus->currentPage() - 1) * $contenus->perPage() + $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                            <span class="fw-bold text-primary">{{ strtoupper(substr($contenu->titre, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <span class="fw-bold text-dark d-block text-truncate" style="max-width: 250px;">{{ $contenu->titre }}</span>
                                            <small class="text-muted">{{ $contenu->langue->nom_langue ?? 'N/A' }} • {{ $contenu->region->nom_region ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $contenu->typeContenu->nom ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="small text-muted"><i class="bi bi-person me-1"></i> {{ $contenu->auteur->name ?? 'Inconnu' }}</span>
                                </td>
                                <td>
                                    @if($contenu->statut == 'publie')
                                        <span class="badge bg-success-subtle text-success border border-success px-2 py-1 rounded-pill">Publié</span>
                                    @elseif($contenu->statut == 'en attente')
                                        <span class="badge bg-warning-subtle text-warning border border-warning px-2 py-1 rounded-pill">En attente</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary px-2 py-1 rounded-pill">{{ ucfirst($contenu->statut) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted small">{{ $contenu->created_at ? $contenu->created_at->format('d/m/Y') : '-' }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="action-btn-group">
                                        <a href="{{ route('admin.contenus.show', $contenu->id_contenu) }}" 
                                           class="btn-action btn-action-view" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.contenus.edit', $contenu->id_contenu) }}" 
                                           class="btn-action btn-action-edit" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.contenus.destroy', $contenu->id_contenu) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce contenu ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-action-delete" title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Aucun contenu trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-3 border-top">
                {{ $contenus->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#contenusTable').DataTable({
        language: { url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json" },
        dom: 'Brtip',
        paging: false, // Pagination handled by Laravel
        info: false,
        columnDefs: [{ orderable: false, targets: 6 }]
    });

    $('#customSearch').on('keyup', function() {
        table.search(this.value).draw();
    });

    $('#customFilter').on('change', function() {
        var val = this.value;
        if(val === 'publie') table.column(4).search('Publié').draw();
        else if(val === 'en_attente') table.column(4).search('En attente').draw();
        else if(val === 'brouillon') table.column(4).search('Brouillon').draw();
        else table.column(4).search('').draw();
    });
});
</script>
@endpush
@endsection
