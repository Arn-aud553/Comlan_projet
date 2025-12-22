@extends('layouts.admin')

@section('title', 'Détails de l\'Utilisateur')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-person-badge fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Détails de l'Utilisateur</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    {{ $user->name }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-arrow-left me-2"></i> Retour
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-3 shadow" style="width: 120px; height: 120px; font-size: 3rem;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <h5 class="fw-bold">{{ $user->name }}</h5>
                                    <p class="text-muted mb-2">{{ $user->email }}</p>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger rounded-pill px-3 py-2">Administrateur</span>
                                    @elseif($user->role === 'auteur')
                                        <span class="badge bg-info rounded-pill px-3 py-2">Auteur</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">Utilisateur</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Informations Personnelles</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="small text-muted text-uppercase fw-bold">Nom Complet</label>
                                            <p class="fw-bold">{{ $user->name }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small text-muted text-uppercase fw-bold">Email</label>
                                            <p>{{ $user->email }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small text-muted text-uppercase fw-bold">Langue Préférée</label>
                                            <p>
                                                @switch($user->langue)
                                                    @case('fr') <span class="badge bg-light text-dark border">Français</span> @break
                                                    @case('en') <span class="badge bg-light text-dark border">Anglais</span> @break
                                                    @case('fon') <span class="badge bg-light text-dark border">Fon</span> @break
                                                    @case('yor') <span class="badge bg-light text-dark border">Yoruba</span> @break
                                                    @default <span class="badge bg-light text-dark border">{{ $user->langue ?? 'N/A' }}</span>
                                                @endswitch
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small text-muted text-uppercase fw-bold">Statut Email</label>
                                            <p>
                                                @if($user->email_verified_at)
                                                    <span class="text-success"><i class="bi bi-check-circle-fill me-1"></i> Vérifié le {{ $user->email_verified_at->format('d/m/Y') }}</span>
                                                @else
                                                    <span class="text-warning"><i class="bi bi-exclamation-triangle-fill me-1"></i> Non vérifié</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small text-muted text-uppercase fw-bold">Date d'inscription</label>
                                            <p>{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="small text-muted text-uppercase fw-bold">Dernière mise à jour</label>
                                            <p>{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="bi bi-lightning-charge me-2"></i>Actions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-action-primary text-white flex-grow-1">
                                            <i class="bi bi-pencil me-2"></i> Modifier
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ? Cette action est irréversible.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="bi bi-trash me-2"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
