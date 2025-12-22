<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du média - Culture Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .media-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .media-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 20px;
        }
        .media-preview {
            text-align: center;
            margin-bottom: 20px;
        }
        .media-preview img {
            max-width: 100%;
            max-height: 500px;
            border-radius: 8px;
        }
        .price-badge {
            font-size: 1.5rem;
            padding: 10px 20px;
        }
        .btn-pay {
            font-size: 1.2rem;
            padding: 15px 30px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="media-container">
        <div class="media-card">
            <a href="{{ route('client.media.index') }}" class="btn btn-outline-secondary mb-4">
                <i class="fas fa-arrow-left"></i> Retour à la galerie
            </a>
            
            <div class="row">
                <div class="col-md-8">
                    <div class="media-preview">
                        @if($media->isImage())
                            <img src="{{ $media->url }}" alt="{{ $media->titre }}" class="img-fluid">
                        @elseif($media->isVideo())
                            <div class="ratio ratio-16x9">
                                <video controls>
                                    <source src="{{ $media->url }}" type="video/mp4">
                                    Votre navigateur ne supporte pas la vidéo.
                                </video>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-file fa-5x text-secondary"></i>
                                <p class="mt-3">Document: {{ $media->nom_fichier }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <h1>{{ $media->titre ?? $media->nom_fichier }}</h1>
                    
                    @if($media->description)
                        <div class="mb-4">
                            <h5>Description:</h5>
                            <p>{{ $media->description }}</p>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-tag"></i> Type:</strong> {{ ucfirst($media->type_fichier) }}</p>
                            <p><strong><i class="fas fa-hdd"></i> Taille:</strong> {{ $media->taille_formattee }}</p>
                            <p><strong><i class="fas fa-calendar"></i> Date d'ajout:</strong> {{ $media->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong><i class="fas fa-user"></i> Auteur:</strong> {{ $media->utilisateur->name ?? 'Inconnu' }}</p>
                            <p><strong><i class="fas fa-file-alt"></i> Extension:</strong> {{ $media->extension }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow">
                        <div class="card-body text-center">
                            <h4 class="card-title">Accès au média</h4>
                            
                            <div class="my-4">
                                @if($media->prix > 0)
                                    <span class="badge bg-success price-badge">
                                        <i class="fas fa-money-bill-wave"></i> {{ $media->prix_formate }}
                                    </span>
                                @else
                                    <span class="badge bg-info price-badge">
                                        <i class="fas fa-gift"></i> Gratuit
                                    </span>
                                @endif
                            </div>
                            
                            @php
                                $hasPaid = $media->estPayeParUtilisateur();
                            @endphp
                            
                            @if($media->prix > 0 && !$hasPaid)
                                <p class="text-muted">
                                    <i class="fas fa-lock"></i> Ce média nécessite un paiement
                                </p>
                                <a href="{{ route('client.media.paiement', $media->id) }}" 
                                   class="btn btn-success btn-pay w-100 mb-3">
                                    <i class="fas fa-shopping-cart"></i> Acheter maintenant
                                </a>
                                
                                <div class="alert alert-info mt-3">
                                    <small>
                                        <i class="fas fa-info-circle"></i> Après paiement, vous pourrez télécharger et visualiser ce média.
                                    </small>
                                </div>
                            @else
                                <p class="text-success">
                                    <i class="fas fa-check-circle"></i> Vous avez accès à ce média
                                </p>
                                <a href="{{ $media->url }}" 
                                   class="btn btn-primary btn-pay w-100 mb-3"
                                   target="_blank">
                                    <i class="fas fa-download"></i> Télécharger
                                </a>
                                
                                @if($hasPaid)
                                    <div class="alert alert-success mt-3">
                                        <small>
                                            <i class="fas fa-check"></i> Acheté le: 
                                            {{ $media->paiements->where('user_id', auth()->id())->first()->created_at->format('d/m/Y') ?? '' }}
                                        </small>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                    
                    <div class="card mt-3 border-0 shadow">
                        <div class="card-body">
                            <h5><i class="fas fa-shield-alt"></i> Paiement sécurisé</h5>
                            <p class="small text-muted">
                                Tous les paiements sont sécurisés via FedaPay. Vos informations bancaires ne sont jamais stockées sur nos serveurs.
                            </p>
                            <div class="text-center">
                                <img src="https://fedapay.com/img/logos/logo-blue.svg" alt="FedaPay" style="height: 30px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>