@extends('layouts.client')

@section('content')
    <!-- Welcome Hero -->
    <div class="welcome-hero">
        <div class="welcome-content">
            <h2 class="welcome-title">Heureux de vous revoir, {{ explode(' ', Auth::user()->name)[0] }} !</h2>
            <p class="welcome-text">Voici un aperçu de vos contributions et de l'activité culturelle récente. Prêt à inspirer le monde ?</p>
        </div>
    </div>

    {{-- Messages Flash --}}
    @if(session('success'))
        <div class="mx-md-5 mx-3 mb-4" style="background: #ecfdf5; color: #065f46; padding: 1rem; border-radius: var(--radius-md); border: 1px solid #10b981; display: flex; align-items: center; gap: 10px; animation: slideIn 0.3s ease;">
            <i class="fas fa-check-circle" style="color: #10b981;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mx-md-5 mx-3 mb-4" style="background: #fef2f2; color: #991b1b; padding: 1rem; border-radius: var(--radius-md); border: 1px solid #ef4444; display: flex; align-items: center; gap: 10px; animation: slideIn 0.3s ease;">
            <i class="fas fa-exclamation-circle" style="color: #ef4444;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="modern-card">
            <div class="card-icon-wrapper icon-blue">
                <i class="fas fa-layer-group"></i>
            </div>
            <div class="card-value">{{ $stats['contents'] ?? 0 }}</div>
            <div class="card-label">Contenus publiés</div>
            <div class="card-action">
                <a href="{{ route('client.contenus.index') }}" class="btn-card-arrow" title="Voir les contenus">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="modern-card">
            <div class="card-icon-wrapper icon-amber">
                <i class="fas fa-photo-video"></i>
            </div>
            <div class="card-value">{{ $stats['medias'] ?? 0 }}</div>
            <div class="card-label">Médias partagés</div>
            <div class="card-action">
                <a href="{{ route('client.media.index') }}" class="btn-card-arrow" title="Voir la galerie">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        
        <div class="modern-card">
            <div class="card-icon-wrapper icon-purple">
                <i class="fas fa-language"></i>
            </div>
            <div class="card-value">{{ $stats['languages'] ?? 0 }}</div>
            <div class="card-label">Langues actives</div>
            <div class="card-action">
                <a href="{{ route('client.languages.index') }}" class="btn-card-arrow" title="Explorer les langues">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="modern-card">
            <div class="card-icon-wrapper icon-emerald">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-value">{{ $stats['users'] ?? 0 }}</div>
            <div class="card-label">Utilisateurs</div>
            <div class="card-action">
                <a href="{{ route('client.users.index') }}" class="btn-card-arrow" title="Voir les utilisateurs">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="main-content">
        <!-- Left Column: Recent Content -->
        <div class="content-column">
            <div class="section-header">
                <h3 class="section-heading">Récemment ajouté</h3>
                <a href="{{ route('client.contenus.manage') }}" class="btn-dashboard" style="background: white; color: var(--primary); border: 1px solid var(--border-subtle); box-shadow: none;">
                    Tout voir <i class="fas fa-arrow-right" style="font-size: 0.75rem;"></i>
                </a>
            </div>

            <div class="list-card">
                @if(isset($recentContents) && $recentContents->count() > 0)
                    @foreach($recentContents as $content)
                        <div class="content-item">
                            <div class="item-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="item-info">
                                <div class="item-title">{{ $content->titre }}</div>
                                <div class="item-meta">
                                    {{ $content->created_at ? $content->created_at->diffForHumans() : 'Date inconnue' }} • 
                                    <span class="status-badge {{ $content->statut == 'publié' ? 'status-published' : 'status-draft' }}">
                                        {{ ucfirst($content->statut ?? 'brouillon') }}
                                    </span>
                                </div>
                                @include('partials.media-type-indicators', ['contenu' => $content, 'size' => '25px', 'fontSize' => '0.7rem'])
                            </div>
                            <a href="{{ route('client.contenus.detail', ['id' => $content->id_contenu]) }}" class="btn-icon">
                                <i class="fas fa-chevron-right" style="color: var(--text-secondary);"></i>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: 2rem; color: var(--text-secondary);">
                        <i class="far fa-folder-open" style="font-size: 2rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p>Aucun contenu récent trouvé.</p>
                        <a href="{{ route('client.contenus.create') }}" class="btn-dashboard" style="margin-top: 1rem; display: inline-flex;">Créer un contenu</a>
                    </div>
                @endif
            </div>
            
            <!-- Section Guide intégrée dans la colonne de gauche mais plus bas -->
            <div class="list-card" style="margin-top: 2rem; background: linear-gradient(135deg, #1e293b, #0f172a); color: white; border: none;">
                <h3 style="margin-bottom: 1rem; font-size: 1.125rem;">Guide du contributeur</h3>
                <ul style="padding-left: 1.5rem; color: #cbd5e1; line-height: 1.6;">
                    <li>Privilégiez les sources vérifiées pour vos articles.</li>
                    <li>Ajoutez des images de haute qualité pour illustrer.</li>
                    <li>Respectez les droits d'auteur et la propriété intellectuelle.</li>
                </ul>
            </div>
        </div>

        <!-- Right Column: Quick Actions -->
        <div class="actions-column">
            <div class="section-header">
                <h3 class="section-heading">Accès rapide</h3>
            </div>

            <div class="list-card" style="display: flex; flex-direction: column; gap: 1rem;">
                <!-- Section Médiathèque -->
                <div style="margin-bottom: 0.5rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--border-subtle);">
                    <h4 class="item-title" style="margin-bottom: 1rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; color: var(--text-secondary);">Médiathèque</h4>
                    
                    <a href="{{ route('client.media.audio') }}" class="modern-card" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; box-shadow: none; border: 1px solid var(--border-subtle); text-decoration: none; margin-bottom: 1rem;">
                        <div class="card-icon-wrapper" style="margin-bottom: 0; width: 40px; height: 40px; font-size: 1rem; background: rgba(236, 72, 153, 0.1); color: #db2777;">
                            <i class="fas fa-music"></i>
                        </div>
                        <div>
                            <div class="item-title">Musique</div>
                            <div class="item-meta">Écouter les audios</div>
                        </div>
                    </a>

                    <a href="{{ route('client.media.video') }}" class="modern-card" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; box-shadow: none; border: 1px solid var(--border-subtle); text-decoration: none; margin-bottom: 1rem;">
                        <div class="card-icon-wrapper" style="margin-bottom: 0; width: 40px; height: 40px; font-size: 1rem; background: rgba(59, 130, 246, 0.1); color: #2563eb;">
                            <i class="fas fa-video"></i>
                        </div>
                        <div>
                            <div class="item-title">Vidéos</div>
                            <div class="item-meta">Regarder les vidéos</div>
                        </div>
                    </a>

                    <a href="{{ route('client.media.reviews') }}" class="modern-card" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; box-shadow: none; border: 1px solid var(--border-subtle); text-decoration: none;">
                        <div class="card-icon-wrapper" style="margin-bottom: 0; width: 40px; height: 40px; font-size: 1rem; background: rgba(245, 158, 11, 0.1); color: #d97706;">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <div class="item-title">Avis</div>
                            <div class="item-meta">Notes et commentaires</div>
                        </div>
                    </a>
                </div>

                <a href="{{ route('client.library.index') }}" class="modern-card" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; box-shadow: none; border: 1px solid var(--border-subtle); text-decoration: none;">
                    <div class="card-icon-wrapper icon-emerald" style="margin-bottom: 0; width: 40px; height: 40px; font-size: 1rem;">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <div>
                        <div class="item-title">Ma Bibliothèque</div>
                        <div class="item-meta">Vos contenus achetés</div>
                    </div>
                </a>

                <a href="{{ route('client.library.favorites') }}" class="modern-card" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; box-shadow: none; border: 1px solid var(--border-subtle); text-decoration: none;">
                    <div class="card-icon-wrapper icon-amber" style="margin-bottom: 0; width: 40px; height: 40px; font-size: 1rem;">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div>
                        <div class="item-title">Mes Favoris</div>
                        <div class="item-meta">Vos coups de cour</div>
                    </div>
                </a>

                <a href="{{ route('client.settings.account') }}" class="modern-card" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; box-shadow: none; border: 1px solid var(--border-subtle); text-decoration: none;">
                    <div class="card-icon-wrapper icon-purple" style="margin-bottom: 0; width: 40px; height: 40px; font-size: 1rem;">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <div>
                        <div class="item-title">Mon Profil</div>
                        <div class="item-meta">Paramètres du compte</div>
                    </div>
                </a>
                
                <a href="{{ route('home') }}" class="modern-card" style="display: flex; align-items: center; gap: 1rem; padding: 1rem; box-shadow: none; border: 1px solid var(--border-subtle); text-decoration: none;">
                    <div class="card-icon-wrapper icon-blue" style="margin-bottom: 0; width: 40px; height: 40px; font-size: 1rem;">
                        <i class="fas fa-globe-africa"></i>
                    </div>
                    <div>
                        <div class="item-title">Explorer le site</div>
                        <div class="item-meta">Voir la page d'accueil</div>
                    </div>
                </a>
            </div>
            
            <!-- Community Mini Stats -->
            <div class="list-card" style="margin-top: 2rem;">
                <h4 class="item-title" style="margin-bottom: 1rem;">Communauté</h4>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; text-align: center;">
                    <div style="background: var(--bg-body); padding: 1rem; border-radius: 12px;">
                        <div style="font-weight: 700; color: var(--primary); font-size: 1.25rem;">{{ $stats['users'] ?? 0 }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary);">Membres</div>
                    </div>
                    <div style="background: var(--bg-body); padding: 1rem; border-radius: 12px;">
                        <div style="font-weight: 700; color: var(--accent); font-size: 1.25rem;">{{ $stats['contents'] ?? 0 }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-secondary);">Contenus</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
