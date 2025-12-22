@extends('layouts.admin')

@section('title', 'Gestion des Types de Contenu')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestion des Types de Contenu</h1>
        <a href="{{ route('admin.type_contenus.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nouveau Type
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Liste des Types</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Date de création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($typesContenu as $type)
                            <tr>
                                <td>{{ ($typesContenu->currentPage() - 1) * $typesContenu->perPage() + $loop->iteration }}</td>
                                <td>{{ $type->nom }}</td>
                                <td>{{ $type->created_at ? $type->created_at->format('d/m/Y') : 'N/A' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.type_contenus.edit', $type->id_type_contenu ?? $type->id) }}" class="btn btn-sm btn-warning" title="Éditer">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.type_contenus.destroy', $type->id_type_contenu ?? $type->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce type ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Aucun type de contenu trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $typesContenu->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
