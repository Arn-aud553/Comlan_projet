@if($typeContenu->contenus->count() > 0)
<div class="contenus-list-modal">
    <div class="alert alert-info mb-3">
        <i class="bi bi-info-circle me-2"></i>
        <strong>{{ $typeContenu->contenus->count() }} contenu(s)</strong> utilisent ce type.
    </div>
    
    <div class="table-responsive">
        <table class="table table-sm table-hover">
            <thead class="table-light">
                <tr>
                    <th width="10%">ID</th>
                    <th width="50%">Titre</th>
                    <th width="20%">Statut</th>
                    <th width="20%">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($typeContenu->contenus as $contenu)
                <tr>
                    <td>
                        <span class="badge bg-dark">#{{ $contenu->id_contenu }}</span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-file-text me-2 text-primary"></i>
                            <div>
                                <strong>{{ Str::limit($contenu->titre, 40) }}</strong>
                                <div class="text-muted small">
                                    {{ $contenu->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($contenu->statut)
                            <span class="badge bg-success">Actif</span>
                        @else
                            <span class="badge bg-danger">Inactif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('contenus.show', $contenu) }}" 
                           class="btn btn-sm btn-outline-info" 
                           target="_blank"
                           title="Voir">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($typeContenu->contenus()->count() > 20)
    <div class="alert alert-warning mt-3">
        <i class="bi bi-exclamation-triangle me-2"></i>
        Affichage limité à 20 contenus. Total : {{ $typeContenu->contenus()->count() }} contenus.
    </div>
    @endif
</div>
@else
<div class="text-center py-5">
    <i class="bi bi-file-text display-1 text-muted mb-4"></i>
    <h5 class="text-muted">Aucun contenu associé</h5>
    <p class="text-muted mb-0">Ce type de contenu n'est pas encore utilisé.</p>
</div>
@endif