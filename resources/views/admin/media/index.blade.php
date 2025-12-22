@extends('layouts.admin')

@section('title', 'Gestion des Médias')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 search-filter-title">
                <i class="bi bi-images"></i> GESTION DES MÉDIAS
            </h1>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-export btn-export-copy"><i class="bi bi-clipboard"></i> Copier</button>
            <button class="btn btn-export btn-export-excel"><i class="bi bi-file-earmark-excel"></i> Excel</button>
            <button class="btn btn-export btn-export-pdf"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
            <button class="btn btn-export btn-export-print"><i class="bi bi-printer"></i> Imprimer</button>
            <a href="{{ route('admin.media.create') }}" class="btn btn-primary d-flex align-items-center ms-3">
                 <i class="bi bi-plus-circle me-2"></i> Nouveau Média
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
                    <input type="text" id="customSearch" class="form-control border-start-0 ps-0" placeholder="Nom fichier, Auteur...">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold text-uppercase small text-muted">Type de Fichier</label>
                <select id="customFilter" class="form-select">
                    <option value="">Tous les types</option>
                    <option value="image">Image</option>
                    <option value="video">Vidéo</option>
                    <option value="audio">Audio</option>
                    <option value="document">Document</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="mediaTable" class="table table-admin table-hover mb-0 w-100">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="8%">APERÇU</th>
                            <th width="25%">NOM FICHIER</th>
                            <th width="10%">TYPE</th>
                            <th width="15%">AUTEUR</th>
                            <th width="12%">PRIX</th>
                            <th width="10%">DATE</th>
                            <th width="20%" class="text-end">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($medias as $media)
                            <tr>
                                <td>
                                    <span class="badge-id">{{ ($medias->currentPage() - 1) * $medias->perPage() + $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center overflow-hidden" style="width: 50px; height: 50px; border: 1px solid #e3e6f0;">
                                        @if($media->type_fichier == 'image')
                                            <img src="{{ asset('storage/'.$media->chemin_fichier) }}" alt="Aperçu" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <i class="bi bi-file-earmark-text text-muted fs-4"></i>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark d-block text-truncate" style="max-width: 200px;">{{ $media->nom_fichier }}</span>
                                    @if($media->contenu)
                                        <small class="text-muted d-block"><i class="bi bi-link-45deg"></i> {{ Str::limit($media->contenu->titre, 20) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border text-uppercase">{{ $media->type_fichier }}</span>
                                </td>
                                <td>
                                    <span class="small text-muted">{{ $media->auteur->name ?? 'Inconnu' }}</span>
                                </td>
                                <td>
                                    @if($media->prix > 0)
                                        <span class="text-success fw-bold">{{ number_format($media->prix, 0, ',', ' ') }} F</span>
                                    @else
                                        <span class="badge bg-success">Gratuit</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted small">{{ $media->created_at->format('d/m/Y') }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="action-btn-group">
                                        <a href="{{ route('admin.media.show', $media->id_media) }}" 
                                           class="btn-action btn-action-view" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.media.edit', $media->id_media) }}" 
                                           class="btn-action btn-action-edit" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.media.destroy', $media->id_media) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce média ?');">
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
                                    Aucun média trouvé
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-3 border-top">
                {{ $medias->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#mediaTable').DataTable({
        language: { url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json" },
        dom: 'Brtip',
        paging: false,
        info: false,
        columnDefs: [{ orderable: false, targets: 6 }]
    });

    $('#customSearch').on('keyup', function() {
        table.search(this.value).draw();
    });

    $('#customFilter').on('change', function() {
        var val = this.value;
        if(val) table.column(2).search(val).draw();
        else table.column(2).search('').draw();
    });
});
</script>
@endpush
@endsection
