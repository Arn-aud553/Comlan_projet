@extends('layouts.admin')

@section('title','Commentaires')

@section('content')
<div class="container-fluid">
    <h1>Commentaires</h1>
    <div class="table-responsive">
      <table id="commentaires-table" class="table table-hover table-striped table-sm">
        <thead><tr><th>Texte</th><th>Note</th><th>Contenu</th><th>Utilisateur</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($commentaires as $cm)
            <tr>
                <td>{{ Str::limit($cm->texte, 120) }}</td>
                <td>{{ $cm->note }}</td>
                <td>{{ optional($cm->contenu)->titre }}</td>
                <td>{{ optional($cm->utilisateur)->nom }}</td>
                <td>
                    @include('partials.datatable_actions', [
                      'showUrl' => route('commentaires.show', $cm),
                      'editUrl' => route('commentaires.edit', $cm),
                      'deleteUrl' => route('commentaires.destroy', $cm),
                      'id' => $cm->id ?? 0,
                      'deleteName' => Str::limit($cm->texte, 20)
                    ])
                </td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
</div>

{{-- DataTables CSS loaded centrally in layout --}}

@push('scripts')
    <script>
        $(function(){
            $('#commentaires-table').DataTable({});
        });
    </script>
@endpush
</div>
@endsection
