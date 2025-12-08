@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Créer un nouvel utilisateur</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> 
                            Un mot de passe par défaut a été généré automatiquement.
                        </div>
                    @endif
                    
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nom_complet">Nom complet *</label>
                                    <input type="text" name="nom_complet" id="nom_complet" class="form-control @error('nom_complet') is-invalid @enderror" value="{{ old('nom_complet') }}" required>
                                    @error('nom_complet')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Le mot de passe sera généré automatiquement (email + "123")</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sexe">Sexe *</label>
                                    <select name="sexe" id="sexe" class="form-control @error('sexe') is-invalid @enderror" required>
                                        <option value="">Sélectionner</option>
                                        <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                                        <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                                        <option value="Autre" {{ old('sexe') == 'Autre' ? 'selected' : '' }}>Autre</option>
                                    </select>
                                    @error('sexe')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="age">Âge</label>
                                    <input type="number" name="age" id="age" class="form-control @error('age') is-invalid @enderror" value="{{ old('age') }}" min="0" max="120">
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
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                        <option value="editeur" {{ old('role') == 'editeur' ? 'selected' : '' }}>Éditeur</option>
                                        <option value="visiteur" {{ old('role') == 'visiteur' ? 'selected' : '' }}>Visiteur</option>
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
                                        <option value="fr" {{ old('langue', 'fr') == 'fr' ? 'selected' : '' }}>Français</option>
                                        <option value="en" {{ old('langue') == 'en' ? 'selected' : '' }}>Anglais</option>
                                        <option value="fon" {{ old('langue') == 'fon' ? 'selected' : '' }}>Fon</option>
                                        <option value="yor" {{ old('langue') == 'yor' ? 'selected' : '' }}>Yoruba</option>
                                    </select>
                                    @error('langue')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-info mt-3">
                            <i class="bi bi-info-circle"></i>
                            <strong>Information :</strong> Un mot de passe par défaut sera généré automatiquement. 
                            L'utilisateur pourra le modifier plus tard depuis son profil.
                        </div>
                        
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Créer l'utilisateur
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