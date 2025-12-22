@extends('layouts.client')

@section('content')
<div class="culture-container">
    <div class="welcome-hero" style="min-height: 200px; padding: 2rem;">
        <div class="welcome-content">
            <h2 class="welcome-title">Ma Bibliothèque</h2>
            <p class="welcome-text">Retrouvez ici tous vos contenus achetés et téléchargés.</p>
        </div>
    </div>

    <div class="main-content" style="padding-top: 2rem;">
        <div class="list-card">
            <div style="text-align: center; padding: 3rem;">
                <i class="fas fa-book-reader" style="font-size: 3rem; color: var(--primary); margin-bottom: 1rem; opacity: 0.5;"></i>
                <h3>Votre bibliothèque est vide pour le moment</h3>
                <p style="color: var(--text-secondary); margin-top: 0.5rem;">Explorez le catalogue pour enrichir votre collection.</p>
                <a href="{{ route('client.contenus.index') }}" class="btn-dashboard" style="margin-top: 1.5rem; display: inline-flex;">Explorer le catalogue</a>
            </div>
        </div>
    </div>
</div>
@endsection
