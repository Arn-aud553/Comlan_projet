@extends('layouts.admin')

@section('title', 'Modération des Commentaires')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 search-filter-title">
                <i class="bi bi-chat-dots"></i> MODÉRATION DES COMMENTAIRES
            </h1>
        </div>
    </div>

    <!-- Carte Recherche & Filtres -->
    <div class="search-filter-container">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-bold text-uppercase small text-muted">Recherche</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" id="customSearch" class="form-control border-start-0 ps-0" placeholder="Contenu, Auteur...">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold text-uppercase small text-muted">Statut</label>
                <select id="customFilter" class="form-select">
                    <option value="">Tous les statuts</option>
                    <option value="En attente">En attente</option>
                    <option value="Approuvé">Approuvé</option>
                    <option value="Rejeté">Rejeté</option>
                    <option value="Signalé">Signalé</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="commentsTable" class="table table-admin table-hover mb-0 w-100">
                    <thead class="bg-light">
                        <tr>
                            <th width="8%"># ID</th>
                            <th width="20%">AUTEUR</th>
                            <th width="30%">COMMENTAIRE</th>
                            <th width="15%">CONTENU</th>
                            <th width="12%">STATUT</th>
                            <th width="15%" class="text-end">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($commentaires as $commentaire)
                            <tr>
                                <td>{{ ($commentaires->currentPage() - 1) * $commentaires->perPage() + $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm bg-primary-light text-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                            {{ strtoupper(substr($commentaire->user->name ?? '?', 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $commentaire->user->name ?? 'Auteur inconnu' }}</div>
                                            <div class="small text-muted">{{ $commentaire->user->email ?? '' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-warning mb-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $commentaire->note ? 'fas' : 'far' }} fa-star small"></i>
                                        @endfor
                                    </div>
                                    <div class="comment-text text-wrap" style="max-width: 300px;">
                                        {{ $commentaire->texte }}
                                    </div>
                                    <div class="small text-muted mt-1">
                                        {{ $commentaire->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td>
                                    @if($commentaire->contenu)
                                        <a href="{{ route('admin.contenus.show', $commentaire->id_contenu) }}" class="text-decoration-none text-primary">
                                            {{ Str::limit($commentaire->contenu->titre, 30) }}
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusClass = match($commentaire->statut) {
                                            'approuve' => 'bg-success',
                                            'rejete' => 'bg-danger',
                                            'signale' => 'bg-info',
                                            default => 'bg-warning',
                                        };
                                        $statusText = match($commentaire->statut) {
                                            'approuve' => 'Approuvé',
                                            'rejete' => 'Rejeté',
                                            'signale' => 'Signalé',
                                            default => 'En attente',
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        @if($commentaire->statut !== 'approuve')
                                        <form action="{{ route('admin.moderation.approve', ['type' => 'comment', 'id' => $commentaire->id_commentaire]) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success" title="Approuver">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                        @endif

                                        @if($commentaire->statut !== 'rejete')
                                        <form action="{{ route('admin.moderation.reject', ['type' => 'comment', 'id' => $commentaire->id_commentaire]) }}" method="POST" class="d-inline ms-1">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger" title="Rejeter">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                        @endif

                                        @if($commentaire->statut === 'signale')
                                        <form action="{{ route('admin.moderation.unflag', ['type' => 'comment', 'id' => $commentaire->id_commentaire]) }}" method="POST" class="d-inline ms-1">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-info" title="Lever le signalement">
                                                <i class="bi bi-flag-fill"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-chat-left-dots fs-1 d-block mb-3"></i>
                                    Aucun commentaire trouvé.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#commentsTable').DataTable({
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json" },
        dom: 'rtip',
        paging: true,
        info: false,
        columnDefs: [{ orderable: false, targets: 5 }]
    });

    $('#customSearch').on('keyup', function() { table.search(this.value).draw(); });

    $('#customFilter').on('change', function() {
        var val = $(this).val();
        // Le texte affiché dans le badge est ce qu'on filtre (index 4 pour la colonne Statut)
        // Mais c'est plus précis de filtrer sur une valeur exacte si possible
        table.column(4).search(val ? val : '', true, false).draw();
    });
});
</script>
@endpush
@endsection
