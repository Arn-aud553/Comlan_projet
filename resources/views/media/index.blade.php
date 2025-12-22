@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gestion des Médias</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.media.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Nouveau Média
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Type</th>
                                    <th>Extension</th>
                                    <th>Taille</th>
                                    <th>Contenu</th>
                                    <th>Utilisateur</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($media as $item)
                                    <tr>
                                        <td>{{ $item->id_media }}</td>
                                        <td>
                                            <i class="bi bi-{{ $item->type_fichier == 'image' ? 'image' : ($item->type_fichier == 'video' ? 'camera-video' : ($item->type_fichier == 'livre' ? 'book' : 'file-earmark')) }}"></i>
                                            {{ Str::limit($item->nom_fichier, 30) }}
                                        </td>
                                        <td>
                                            @if($item->type_fichier == 'image')
                                                <span class="badge badge-primary">Image</span>
                                            @elseif($item->type_fichier == 'video')
                                                <span class="badge badge-success">Vidéo</span>
                                            @elseif($item->type_fichier == 'livre')
                                                <span class="badge badge-info">Livre</span>
                                            @else
                                                <span class="badge badge-secondary">Document</span>
                                            @endif
                                        </td>
                                        <td><code>{{ $item->extension }}</code></td>
                                        <td>{{ $item->taille_formattee ?? 'N/A' }}</td>
                                        <td>
                                            @if($item->contenu)
                                                <a href="{{ route('admin.contenus.show', $item->id_contenu) }}" class="text-primary">
                                                    {{ Str::limit($item->contenu->titre ?? 'N/A', 25) }}
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->utilisateur->name ?? 'N/A' }}</td>
                                        <td>{{ $item->created_at ? $item->created_at->format('d/m/Y') : 'N/A' }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ $item->url }}" target="_blank" class="btn btn-info" title="Voir">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.media.show', ['medium' => $item->id_media]) }}" class="btn btn-primary" title="Détails">
                                                    <i class="bi bi-info-circle"></i>
                                                </a>
                                                <a href="{{ route('admin.media.edit', ['medium' => $item->id_media]) }}" class="btn btn-warning" title="Modifier">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.media.destroy', ['medium' => $item->id_media]) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce média ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Supprimer">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox" style="font-size: 48px; display: block; margin-bottom: 10px;"></i>
                                            Aucun média trouvé
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $media->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
