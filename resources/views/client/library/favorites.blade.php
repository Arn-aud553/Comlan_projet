@extends('layouts.client')

@section('content')
<div class="culture-container">
    <div class="welcome-hero" style="min-height: 200px; padding: 2rem;">
        <div class="welcome-content">
            <h2 class="welcome-title">Mes Favoris</h2>
            <p class="welcome-text">Vos contenus les plus consultés. (Basé sur votre historique de lecture)</p>
        </div>
    </div>

    <div class="main-content" style="padding-top: 2rem;">
        @if($contenus->count() > 0)
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                @foreach($contenus as $contenu)
                    <div class="modern-card" style="display: flex; flex-direction: column; overflow: hidden; height: 100%;">
                        <div style="height: 160px; background: #e2e8f0; position: relative; overflow: hidden;">
                            @if($contenu->media && $contenu->media->isNotEmpty())
                                @php
                                    $coverMedia = $contenu->media->where('type_fichier', 'image')->first();
                                @endphp
                                @if($coverMedia)
                                    <img src="{{ Storage::url($coverMedia->chemin_fichier) }}" alt="{{ $contenu->titre }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: linear-gradient(135deg, #cbd5e1 0%, #94a3b8 100%);">
                                        <i class="fas fa-book-open" style="font-size: 3rem; color: rgba(255,255,255,0.5);"></i>
                                    </div>
                                @endif
                            @else
                                <div style="display: flex; align-items: center; justify-content: center; height: 100%; background: linear-gradient(135deg, #cbd5e1 0%, #94a3b8 100%);">
                                    <i class="fas fa-book-open" style="font-size: 3rem; color: rgba(255,255,255,0.5);"></i>
                                </div>
                            @endif
                            <div style="position: absolute; top: 10px; right: 10px; background: rgba(0,0,0,0.6); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; backdrop-filter: blur(4px);">
                                {{ $contenu->typeContenu->nom ?? 'Article' }}
                            </div>
                        </div>
                        <div style="padding: 1.5rem; flex: 1; display: flex; flex-direction: column;">
                            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; line-height: 1.4;">{{ Str::limit($contenu->titre, 50) }}</h3>
                            <div style="margin-bottom: 1rem; color: var(--text-secondary); font-size: 0.875rem;">
                                Par {{ $contenu->auteur ? $contenu->auteur->name : 'Anonyme' }}
                            </div>
                            <div style="margin-top: auto;">
                                <a href="{{ route('client.contenus.detail', $contenu->id_contenu) }}" class="btn-dashboard" style="width: 100%; justify-content: center;">
                                    Lire à nouveau
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="list-card">
                <div style="text-align: center; padding: 3rem;">
                    <i class="fas fa-chart-line" style="font-size: 3rem; color: var(--accent); margin-bottom: 1rem; opacity: 0.5;"></i>
                    <h3>Aucun historique pour le moment</h3>
                    <p style="color: var(--text-secondary); margin-top: 0.5rem;">Commencez à lire des contenus pour qu'ils apparaissent ici comme vos favoris fréquents.</p>
                    <a href="{{ route('client.contenus.index') }}" class="btn-dashboard" style="margin-top: 1.5rem; display: inline-flex;">Explorer le catalogue</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
