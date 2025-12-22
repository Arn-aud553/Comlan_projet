@extends('layouts.client')

@section('content')
<style>
    /* Profile Styles */
    .profile-hero {
        background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
        border-radius: 20px 20px 0 0;
        padding: 3rem 2rem 5rem;
        text-align: center;
        color: white;
        position: relative;
        margin-bottom: 4rem;
    }

    .profile-avatar-wrapper {
        width: 140px;
        height: 140px;
        margin: -70px auto 1rem;
        border-radius: 50%;
        border: 5px solid white;
        overflow: hidden;
        background: white;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        position: relative;
        z-index: 10;
    }

    .profile-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-card-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 15px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .info-card-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        background: white;
    }

    .info-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .icon-blue { background: #eff6ff; color: #3b82f6; }
    .icon-purple { background: #f3e8ff; color: #9333ea; }
    .icon-green { background: #ecfdf5; color: #10b981; }
    .icon-orange { background: #fff7ed; color: #f97316; }
    .icon-pink { background: #fdf2f8; color: #db2777; }
    .icon-teal { background: #f0fdfa; color: #14b8a6; }

    .edit-section {
        background: white;
        border-top: 1px solid #e2e8f0;
        padding-top: 2rem;
        margin-top: 3rem;
    }
</style>

<div class="settings-container">
    <div class="modern-card" style="padding: 0; overflow: hidden; border: none;">
        
        <!-- Hero Section -->
        <div class="profile-hero">
            <h1 style="margin: 0; font-size: 2rem; font-weight: 700;">Mon Profil</h1>
            <p style="opacity: 0.9; margin-top: 0.5rem;">Gérez vos informations personnelles</p>
        </div>

        <div style="padding: 0 2rem 3rem;">
            <!-- Avatar -->
            <div class="profile-avatar-wrapper">
                @if($user->profile_photo_path)
                    <img src="{{ Storage::url($user->profile_photo_path) }}?t={{ time() }}" alt="{{ $user->name }}" class="profile-avatar">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366f1&color=fff&size=500&bold=true" alt="{{ $user->name }}" class="profile-avatar">
                @endif
            </div>

            <!-- Identity -->
            <div style="text-align: center; margin-bottom: 3rem;">
                <h2 style="font-size: 1.75rem; color: #1e293b; margin-bottom: 0.5rem; font-weight: 700;">{{ $user->name }}</h2>
                <div style="display: inline-block; background: #e0e7ff; color: #4338ca; padding: 0.25rem 1rem; border-radius: 99px; font-weight: 600; font-size: 0.875rem;">
                    {{ $user->role_libelle ?? ucfirst($user->role) }}
                </div>
            </div>

            @if(session('success'))
                <div style="background: #ecfdf5; color: #065f46; padding: 1rem; border-radius: 12px; border: 1px solid #10b981; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div style="background: #fef2f2; color: #991b1b; padding: 1rem; border-radius: 12px; border: 1px solid #ef4444; margin-bottom: 2rem;">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Info Grid -->
            <div class="info-grid">
                <!-- Nom -->
                <div class="info-card-item">
                    <div class="info-icon icon-blue"><i class="fas fa-user"></i></div>
                    <div>
                        <div style="font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 600;">Nom Complet</div>
                        <div style="font-weight: 600; color: #1e293b;">{{ $user->name }}</div>
                    </div>
                </div>

                <!-- Email -->
                <div class="info-card-item">
                    <div class="info-icon icon-purple"><i class="fas fa-envelope"></i></div>
                    <div>
                        <div style="font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 600;">Email</div>
                        <div style="font-weight: 600; color: #1e293b;">{{ $user->email }}</div>
                    </div>
                </div>

                <!-- Sexe -->
                <div class="info-card-item">
                    <div class="info-icon icon-pink"><i class="fas fa-venus-mars"></i></div>
                    <div>
                        <div style="font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 600;">Sexe</div>
                        <div style="font-weight: 600; color: #1e293b;">{{ $user->sexe_libelle ?? ($user->sexe == 'M' ? 'Masculin' : ($user->sexe == 'F' ? 'Féminin' : 'Non spécifié')) }}</div>
                    </div>
                </div>

                <!-- Âge -->
                <div class="info-card-item">
                    <div class="info-icon icon-teal"><i class="fas fa-birthday-cake"></i></div>
                    <div>
                        <div style="font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 600;">Âge</div>
                        <div style="font-weight: 600; color: #1e293b;">{{ $user->age ? $user->age . ' ans' : 'Non spécifié' }}</div>
                    </div>
                </div>

                <!-- Langue -->
                <div class="info-card-item">
                    <div class="info-icon icon-orange"><i class="fas fa-language"></i></div>
                    <div>
                        <div style="font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 600;">Langue</div>
                        <div style="font-weight: 600; color: #1e293b;">{{ $user->langue_libelle ?? strtoupper($user->langue) }}</div>
                    </div>
                </div>

                <!-- Date Inscription -->
                <div class="info-card-item">
                    <div class="info-icon icon-green"><i class="fas fa-calendar-check"></i></div>
                    <div>
                        <div style="font-size: 0.75rem; text-transform: uppercase; color: #64748b; font-weight: 600;">Membre depuis</div>
                        <div style="font-weight: 600; color: #1e293b;">{{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}</div>
                    </div>
                </div>
            </div>

            <!-- Edit Form Section -->
            <div class="edit-section">
                <!-- Using fresh user data to ensure updates are visible -->
                @php $user = auth()->user()->fresh(); @endphp
                
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                    <h3 style="margin: 0; font-size: 1.25rem; color: #1e293b;">Modifier mes informations</h3>
                    <button type="button" onclick="document.getElementById('editForm').style.display = document.getElementById('editForm').style.display === 'none' ? 'block' : 'none'" style="background: none; border: 1px solid #cbd5e1; padding: 0.5rem 1rem; border-radius: 8px; cursor: pointer; color: #64748b;">
                        <i class="fas fa-pen"></i> Modifier
                    </button>
                </div>

                <form id="editForm" action="{{ route('client.settings.update', 'profile') }}" method="POST" enctype="multipart/form-data" style="display: none;" data-turbo="false" onsubmit="console.log('Form submitting...');">
                    @csrf
                    
                    <div style="display: grid; gap: 1.5rem;">
                        <!-- Photo Upload -->
                        <div>
                            <input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
                            <label for="photo" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Changer la photo</label>
                            <input type="file" id="photo" name="photo" class="form-control" accept="image/*">
                        </div>

                        <!-- Basic Fields -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div>
                                <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nom complet</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px;">
                            </div>
                            <div>
                                <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px;">
                            </div>
                        </div>

                        <!-- Details Fields -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
                            <div>
                                <label for="sexe" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Sexe</label>
                                <select id="sexe" name="sexe" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px;">
                                    <option value="">Non précisé</option>
                                    <option value="M" {{ old('sexe', $user->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
                                    <option value="F" {{ old('sexe', $user->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
                                    <option value="Autre" {{ old('sexe', $user->sexe) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                </select>
                            </div>
                            <div>
                                <label for="age" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Âge</label>
                                <input type="number" id="age" name="age" value="{{ old('age', $user->age) }}" class="form-control" min="0" max="120" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px;">
                            </div>
                            <div>
                                <label for="langue" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Langue</label>
                                <select id="langue" name="langue" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px;">
                                    <option value="fr" {{ old('langue', $user->langue) == 'fr' ? 'selected' : '' }}>Français</option>
                                    <option value="en" {{ old('langue', $user->langue) == 'en' ? 'selected' : '' }}>Anglais</option>
                                    <option value="fon" {{ old('langue', $user->langue) == 'fon' ? 'selected' : '' }}>Fon</option>
                                    <option value="yor" {{ old('langue', $user->langue) == 'yor' ? 'selected' : '' }}>Yoruba</option>
                                </select>
                            </div>
                        </div>

                        <!-- Password -->
                        <div style="border-top: 1px solid #e2e8f0; padding-top: 1.5rem;">
                            <h4 style="margin: 0 0 1rem;">Sécurité (Laisser vide si inchangé)</h4>
                            <div style="display: grid; gap: 1rem;">
                                <input type="password" name="current_password" placeholder="Mot de passe actuel" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px;">
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                    <input type="password" name="password" placeholder="Nouveau mot de passe" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px;">
                                    <input type="password" name="password_confirmation" placeholder="Confirmer le nouveau mot de passe" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #cbd5e1; border-radius: 8px;">
                                </div>
                            </div>
                        </div>

                        <div style="text-align: right;">
                            <button type="submit" class="btn-dashboard" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; font-size: 1rem;">
                                <i class="fas fa-save"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

