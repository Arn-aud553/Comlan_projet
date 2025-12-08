@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Détails de l'utilisateur</h3>
                    <div class="card-tools">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            Retour à la liste
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> {{ $user->id }}</p>
                            <p><strong>Nom:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>Créé le:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Mis à jour le:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                            Modifier
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection