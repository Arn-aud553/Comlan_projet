@extends('layouts.admin')

@section('title','Médias')

@section('content')
<div class="container-fluid">
    <h1>Médias</h1>
    <a href="{{ route('media.create') }}" class="btn btn-primary mb-3">Ajouter</a>
    <div class="table-responsive">
      <table id="media-table" class="table table-hover table-striped table-sm">
        <thead><tr><th>Utilisateur</th><th>Langue</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($media as $m)
            <tr>
                <td>{{ optional($m->utilisateur)->nom }}</td>
                <td>{{ optional($m->langue)->nom_langue }}</td>
                <td>
                    @include('partials.datatable_actions', [
                      'showUrl' => route('media.show', $m),
                      'editUrl' => route('media.edit', $m),
                      'deleteUrl' => route('media.destroy', $m),
                      'id' => $m->id ?? 0,
                      'deleteName' => optional($m->langue)->nom_langue ?? ''
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
            $('#media-table').DataTable({});
        });
    </script>
@endpush
</div>
@endsection
