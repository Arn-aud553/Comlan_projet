@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 search-filter-title">
                <i class="bi bi-people"></i> GESTION DES UTILISATEURS
            </h1>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-export btn-export-copy"><i class="bi bi-clipboard"></i> Copier</button>
            <button class="btn btn-export btn-export-excel"><i class="bi bi-file-earmark-excel"></i> Excel</button>
            <button class="btn btn-export btn-export-pdf"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
            <button class="btn btn-export btn-export-print"><i class="bi bi-printer"></i> Imprimer</button>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary d-flex align-items-center ms-3">
                 <i class="bi bi-plus-circle me-2"></i> Nouvel Utilisateur
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
                    <input type="text" id="customSearch" class="form-control border-start-0 ps-0" placeholder="Nom, Email...">
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold text-uppercase small text-muted">Rôle</label>
                <select id="customFilter" class="form-select">
                    <option value="">Tous les rôles</option>
                    <option value="admin">Administrateur</option>
                    <option value="user">Utilisateur</option>
                    <option value="auteur">Auteur</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow mb-4 border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="usersTable" class="table table-admin table-hover mb-0 w-100">
                    <thead class="bg-light">
                        <tr>
                            <th width="8%"># ID</th>
                            <th width="25%">UTILISATEUR</th>
                            <th width="25%">EMAIL</th>
                            <th width="12%">RÔLE</th>
                            <th width="10%">STATUT</th>
                            <th width="10%">INSCRIT LE</th>
                            <th width="10%" class="text-end">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>
                                    <span class="badge-id">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                            <span class="fw-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <span class="fw-bold text-dark d-block">{{ $user->name }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif($user->role === 'manager')
                                        <span class="badge bg-warning text-dark">Manager</span>
                                    @elseif($user->role === 'editeur')
                                        <span class="badge bg-primary">Éditeur</span>
                                    @elseif($user->role === 'auteur')
                                        <span class="badge bg-info">Auteur</span>
                                    @else
                                        <span class="badge bg-secondary">Utilisateur</span>
                                    @endif
                                </td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success-subtle text-success border border-success px-2 py-1 rounded-pill">Vérifié</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning px-2 py-1 rounded-pill">Non vérifié</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted small">{{ $user->created_at->format('d/m/Y') }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="action-btn-group">
                                        <a href="{{ route('admin.users.show', $user->id) }}" 
                                           class="btn-action btn-action-view" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                           class="btn-action btn-action-edit" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Supprimer cet utilisateur ?');">
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
            <div class="px-3 py-3 border-top">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    var table = $('#usersTable').DataTable({
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json" },
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
        if(val) table.column(3).search(val, true, false).draw(); // Recherche exacte pour le rôle
        else table.column(3).search('').draw();
    });
});
</script>
@endpush
@endsection
