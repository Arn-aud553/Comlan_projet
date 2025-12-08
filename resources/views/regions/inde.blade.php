@extends('layouts.admin')

@section('title','Régions')

@section('content')
<div class="container-fluid">
    <h1>Régions</h1>
    <a href="{{ route('regions.create') }}" class="btn btn-primary mb-3">Ajouter</a>

    <div class="table-responsive">
      <table id="regions-table" class="table table-hover table-striped table-sm">
        <thead>
            <tr><th>Nom</th><th>Description</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($regions as $r)
            <tr>
                <td>{{ $r->nom_region }}</td>
                <td>{{ Str::limit($r->description, 80) }}</td>
                <td>
                    @include('partials.datatable_actions', [
                      'showUrl' => route('regions.show', $r),
                      'editUrl' => route('regions.edit', $r),
                      'deleteUrl' => route('regions.destroy', $r),
                      'id' => $r->id ?? 0,
                      'deleteName' => $r->nom_region ?? ''
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
            $('#regions-table').DataTable({});
        });
    </script>
@endpush
</div>
@endsection
