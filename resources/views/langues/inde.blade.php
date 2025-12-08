@extends('layouts.admin')

@section('title','Langues')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h3 class="card-title">Langues</h3>
          <a href="{{ route('langues.create') }}" class="btn btn-sm btn-success"><i class="bi bi-plus-circle"></i></a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="langues-table" class="table table-hover table-striped table-sm">
              <thead>
                <tr>
                  <th>Nom langue</th>
                  <th>Code langue</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($langues ?? [] as $langue)
                <tr>
                  <td>{{ $langue->nom_langue ?? $langue->name ?? '-' }}</td>
                  <td>{{ $langue->code_langue ?? $langue->iso ?? '-' }}</td>
                  <td>
                    @include('partials.datatable_actions', [
                      'showUrl' => route('langues.show', $langue->getKey()),
                      'editUrl' => route('langues.edit', $langue->getKey()),
                      'deleteUrl' => route('langues.destroy', $langue->getKey()),
                      'id' => $langue->getKey(),
                      'deleteName' => $langue->nom_langue ?? $langue->name ?? ''
                    ])
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

{{-- DataTables CSS loaded centrally in layout --}}

@push('scripts')
  <script>
    $(document).ready(function () {
      $('#langues-table').DataTable({
        // rely on global defaults (language/responsive) set in layout
      });
    });
  </script>
@endpush

@endsection
