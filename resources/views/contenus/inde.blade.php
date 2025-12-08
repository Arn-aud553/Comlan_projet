@extends('layouts.admin')

@section('title','Contenus')

@section('content')
<div class="container-fluid">
    <h1>Contenus</h1>
    <a href="{{ route('contenus.create') }}" class="btn btn-primary mb-3">Ajouter</a>

    <div class="table-responsive">
      <table id="contenus-table" class="table table-hover table-striped table-sm">
        <thead><tr><th>Titre</th><th>Statut</th><th>Auteur</th><th>Langue</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($contenus as $c)
            <tr>
                <td>{{ $c->titre }}</td>
                <td>{{ $c->statut }}</td>
                <td>{{ optional($c->auteur)->nom }}</td>
                <td>{{ optional($c->langue)->nom_langue }}</td>
                <td>
                    @include('partials.datatable_actions', [
                      'showUrl' => route('contenus.show', $c),
                      'editUrl' => route('contenus.edit', $c),
                      'deleteUrl' => route('contenus.destroy', $c),
                      'id' => $c->id ?? 0,
                      'deleteName' => $c->titre ?? ''
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
            $('#contenus-table').DataTable({});
        });
    </script>
@endpush
</div>
@endsection
