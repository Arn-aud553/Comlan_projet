@extends('layouts.client')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg text-center">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success fa-5x"></i>
                    </div>
                    
                    <h2 class="mb-3 text-success">Paiement Réussi !</h2>
                    <p class="lead mb-4">
                        Merci pour votre achat. Vous avez maintenant accès au média :<br>
                        <strong>{{ $media->titre ?? $media->nom_fichier }}</strong>
                    </p>
                    
                    <div class="alert alert-light border mb-4">
                        <p class="mb-1">Montant payé : <strong>{{ $media->prix_formate }}</strong></p>
                        <p class="mb-0 text-muted small">ID Transaction : {{ $media->paiements->where('user_id', auth()->id())->last()->transaction_id ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="d-grid gap-3">
                        <a href="{{ route('client.media.detail', $media->id) }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-play-circle me-2"></i>
                            Accéder au média
                        </a>
                        <a href="{{ route('client.media.download', $media->id) }}" class="btn btn-outline-success">
                            <i class="fas fa-download me-2"></i>
                            Télécharger le fichier
                        </a>
                        <a href="{{ route('client.media.index') }}" class="btn btn-link text-muted">
                            Retour à la galerie
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
