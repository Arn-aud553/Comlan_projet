@extends('layouts.admin')

@section('title', 'Modifier l\'Utilisateur')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-table.css') }}">
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <!-- En-tête avec gradient -->
                <div class="card-header card-header-gradient py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="bi bi-pencil-square fs-3"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0 fs-4">Modifier l'Utilisateur</h5>
                                <p class="mb-0 opacity-75" style="font-size: 0.9rem;">
                                    {{ $user->name }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-light btn-sm">
                                <i class="bi bi-eye me-2"></i> Voir
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>Informations du Compte</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nom Complet <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="role" class="form-label">Rôle <span class="text-danger">*</span></label>
                                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                            <option value="">Sélectionner...</option>
                                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                            <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                                            <option value="editeur" {{ old('role', $user->role) == 'editeur' ? 'selected' : '' }}>Éditeur</option>
                                            <option value="auteur" {{ old('role', $user->role) == 'auteur' ? 'selected' : '' }}>Auteur</option>
                                            <option value="visiteur" {{ old('role', $user->role) == 'visiteur' || old('role', $user->role) == 'user' ? 'selected' : '' }}>Utilisateur</option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="langue" class="form-label">Langue Préférée</label>
                                        <select class="form-select @error('langue') is-invalid @enderror" id="langue" name="langue">
                                            <option value="fr" {{ old('langue', $user->langue) == 'fr' ? 'selected' : '' }}>Français</option>
                                            <option value="en" {{ old('langue', $user->langue) == 'en' ? 'selected' : '' }}>Anglais</option>
                                            <option value="fon" {{ old('langue', $user->langue) == 'fon' ? 'selected' : '' }}>Fon</option>
                                            <option value="yor" {{ old('langue', $user->langue) == 'yor' ? 'selected' : '' }}>Yoruba</option>
                                        </select>
                                        @error('langue')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 border-top pt-4">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Retour à la liste
                            </a>
                            <button type="submit" class="btn btn-primary px-4 shadow">
                                <i class="bi bi-check-circle me-2"></i> Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
