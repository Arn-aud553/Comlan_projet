@extends('layouts.admin')

@section('title', 'Gestion des Contenus')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-file-earmark-text"></i> Gestion des Contenus
                        </h5>
                        <a href="{{ route('contenus.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Nouveau Contenu
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Table DataTable -->
                    <div class="table-responsive">
                        <table id="contenusTable" class="table table-striped table-hover datatable-buttons" style="width:100%">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Titre</th>
                                    <th>Texte</th>
                                    <th>Région</th>
                                    <th>Langue</th>
                                    <th>Type</th>
                                    <th>Statut</th>
                                    <th>Date Validation</th>
                                    <th>Auteur</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contenus as $contenu)
                                <tr>
                                    <td>{{ $contenu->id_contenu }}</td>
                                    <td>
                                        <strong>{{ $contenu->titre }}</strong>
                                    </td>
                                    <td>
                                        {{ Str::limit($contenu->texte, 80) }}
                                    </td>
                                    <td>
                                        @if($contenu->region)
                                            <span class="badge bg-primary">{{ $contenu->region->nom ?? 'N/A' }}</span>
                                        @else
                                            <span class="badge bg-secondary">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($contenu->langue)
                                            <span class="badge bg-info">{{ $contenu->langue->nom ?? 'N/A' }}</span>
                                        @else
                                            <span class="badge bg-secondary">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($contenu->typeContenu)
                                            <span class="badge bg-secondary">{{ $contenu->typeContenu->nom ?? 'N/A' }}</span>
                                        @else
                                            <span class="badge bg-secondary">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = 'bg-secondary';
                                            if($contenu->statut == 'publié') $badgeClass = 'bg-success';
                                            if($contenu->statut == 'en attente') $badgeClass = 'bg-warning';
                                            if($contenu->statut == 'rejeté') $badgeClass = 'bg-danger';
                                            if($contenu->statut == 'validé') $badgeClass = 'bg-primary';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $contenu->statut ?? 'Non défini' }}</span>
                                    </td>
                                    <td>
                                        <small>{{ $contenu->date_validation ? $contenu->date_validation->format('d/m/Y') : 'Non validé' }}</small>
                                    </td>
                                    <td>
                                        @if($contenu->auteur)
                                            <small>{{ $contenu->auteur->name ?? 'ID: ' . $contenu->id_auteur }}</small>
                                        @else
                                            <small>ID: {{ $contenu->id_auteur }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('contenus.show', $contenu->id_contenu) }}" class="btn btn-info" title="Voir">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('contenus.edit', $contenu->id_contenu) }}" class="btn btn-warning" title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('contenus.destroy', $contenu->id_contenu) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contenu ?')">
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

<style>
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
    }
</style>
@endsection