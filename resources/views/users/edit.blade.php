@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Modifier l'utilisateur</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nom_complet">Nom complet *</label>
                                    <input type="text" name="nom_complet" id="nom_complet" class="form-control @error('nom_complet') is-invalid @enderror" value="{{ old('nom_complet', $user->nom_complet) }}" required>
                                    @error('nom_complet')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sexe">Sexe *</label>
                                    <select name="sexe" id="sexe" class="form-control @error('sexe') is-invalid @enderror" required>
                                        <option value="">Sélectionner</option>
                                        <option value="M" {{ old('sexe', $user->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
                                        <option value="F" {{ old('sexe', $user->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
                                        <option value="Autre" {{ old('sexe', $user->sexe) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                    </select>
                                    @error('sexe')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="age">Âge</label>
                                    <input type="number" name="age" id="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age', $user->age) }}" min="0" max="120">
                                    @error('age')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role">Rôle *</label>
                                    <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                        <option value="">Sélectionner</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                        <option value="editeur" {{ old('role', $user->role) == 'editeur' ? 'selected' : '' }}>Éditeur</option>
                                        <option value="visiteur" {{ old('role', $user->role) == 'visiteur' ? 'selected' : '' }}>Visiteur</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="langue">Langue préférée</label>
                                    <select name="langue" id="langue" class="form-control @error('langue') is-invalid @enderror">
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
                        
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Mettre à jour
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection