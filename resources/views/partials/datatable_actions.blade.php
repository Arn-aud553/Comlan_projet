@php
  // Expected variables: showUrl (optional), editUrl (optional), deleteUrl (optional), id (optional), deleteName (optional)
  $showUrl = $showUrl ?? null;
  $editUrl = $editUrl ?? null;
  $deleteUrl = $deleteUrl ?? null;
  $id = $id ?? null;
  $deleteName = $deleteName ?? '';
@endphp
<div class="d-flex align-items-center">
  @if($showUrl)
    <a href="{{ $showUrl }}" class="btn btn-sm btn-action btn-show me-1" title="Voir">
      <i class="bi bi-eye"></i>
    </a>
  @endif

  @if($editUrl)
    <a href="{{ $editUrl }}" class="btn btn-sm btn-action btn-edit me-1" title="Modifier">
      <i class="bi bi-pencil-square"></i>
    </a>
  @endif

  @if($deleteUrl)
    <form action="{{ $deleteUrl }}" method="POST" style="display:inline;">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-sm btn-action btn-delete" onclick="return confirm('Confirmer la suppression {{ addslashes($deleteName) }} ?')" title="Supprimer">
        <i class="bi bi-trash"></i>
      </button>
    </form>
  @endif
</div>
