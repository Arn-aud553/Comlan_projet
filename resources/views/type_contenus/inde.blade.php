@extends('layouts.admin')

@section('title','Types de contenus')

@section('content')
<div class="container-fluid">
    <h1>Types de contenus</h1>
    <a href="{{ route('type_contenus.create') }}" class="btn btn-primary mb-3">Ajouter</a>
    <div class="table-responsive">
      <table id="type-contenus-table" class="table table-hover table-striped table-sm">
        <thead><tr><th>Nom</th><th>Actions</th></tr></thead>
        <tbody>
            @foreach($types as $t)
            <tr>
                <td>{{ $t->nom }}</td>
                <td>
                    @include('partials.datatable_actions', [
                      'showUrl' => route('type_contenus.show', $t),
                      'editUrl' => route('type_contenus.edit', $t),
                      'deleteUrl' => route('type_contenus.destroy', $t),
                      'id' => $t->id ?? 0,
                      'deleteName' => $t->nom ?? ''
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
            $('#type-contenus-table').DataTable({});
        });
    </script>
@endpush
</div>
@endsection
