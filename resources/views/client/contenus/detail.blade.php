@extends('layouts.client')

@section('title', 'Détails du Contenu - ' . $contenu->titre)

@push('styles')
<style>
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 30px;
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s;
    }
    .back-link:hover { color: var(--secondary); }

    .info-section {
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: var(--shadow-md);
        margin-bottom: 30px;
    }
    
    .info-title {
        font-family: 'Playfair Display', serif;
        font-size: 28px;
        color: var(--text-main);
        margin-bottom: 20px;
        border-bottom: 2px solid var(--border-subtle);
        padding-bottom: 10px;
    }
    
    .text-content {
        margin-bottom: 30px;
        line-height: 1.8;
        color: var(--text-main);
    }

    .premium-badge {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 20px;
    }

    .preview-content {
        position: relative;
        max-height: 300px;
        overflow: hidden;
    }

    .preview-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100px;
        background: linear-gradient(to top, white, transparent);
    }

    .price-display {
        font-size: 32px;
        font-weight: 700;
        color: var(--secondary);
        margin: 20px 0;
    }

    .btn-buy {
        background: linear-gradient(135deg, #b45309, #d97706);
        color: white;
        border: none;
        padding: 15px 30px;
        font-size: 18px;
        font-weight: 600;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s;
        width: 100%;
    }

    .btn-buy:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(180, 83, 9, 0.3);
        color: white;
        text-decoration: none;
    }

    .access-badge {
        background: #10b981;
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .security-badge {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 15px;
        border-radius: 10px;
        margin-top: 20px;
        text-align: center;
    }

    .product-mini-card {
        background: #fff;
        padding: 10px;
        border-radius: 8px;
        transition: transform 0.3s;
        border: 1px solid #e2e8f0;
    }
    .product-mini-card:hover { 
        transform: translateY(-5px); 
        box-shadow: var(--shadow-md);
    }
</style>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
@endpush

@section('content')
<div class="container py-4">
    <a href="{{ route('client.contenus.manage') }}" class="back-link">
        <i class="fas fa-arrow-left"></i> Retour à la liste
    </a>

    <!-- Header with purchase info -->
    <div class="info-section">
        <div class="row">
            <div class="col-md-8">
                <h1 style="font-family: 'Playfair Display', serif; font-size: 32px; color: var(--text-main); margin-bottom: 10px;">
                    {{ $contenu->titre }}
                </h1>
                
                <div class="d-flex align-items-center gap-3 mb-3">
                    @if($contenu->est_payant)
                        <span class="premium-badge">
                            <i class="fas fa-crown"></i> Contenu Premium
                        </span>
                    @else
                        <span class="access-badge">
                            <i class="fas fa-unlock"></i> Accès Gratuit
                        </span>
                    @endif
                    
                    <span style="color: var(--text-secondary);">
                        <i class="fas fa-user"></i> {{ $contenu->auteur ? ($contenu->auteur->nom_complet ?? $contenu->auteur->name) : 'Auteur inconnu' }}
                    </span>
                </div>

                <!-- Content Preview/Full Content -->
                <div class="text-content">
                    @if($contenu->est_payant && !$contenu->estPayeParUtilisateur())
                        <!-- Preview for paid content -->
                        <div class="preview-content">
                            <div class="mb-3">
                                <h4><i class="fas fa-lock text-warning"></i> Contenu Protégé</h4>
                                <p>Ce contenu nécessite un achat pour être consulté en intégralité.</p>
                            </div>
                            
                            <div class="mb-4">
                                <h5>Aperçu du contenu :</h5>
                                <div style="background: #f8fafc; padding: 20px; border-radius: 10px; border-left: 4px solid var(--secondary);">
                                    {!! Str::limit(strip_tags($contenu->texte), 500) !!}
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <div class="preview-overlay"></div>
                                <button class="btn-buy" onclick="window.location.href='{{ route('client.contenus.paiement', $contenu->id_contenu) }}'">
                                    <i class="fas fa-shopping-cart"></i> Acheter pour lire la suite
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Full content for free or purchased content -->
                        <div class="article-content">
                            @if(isset($pdfUrl) && $pdfUrl)
                                <div class="ratio ratio-16x9 mb-4" style="height: 80vh;">
                                    <iframe src="{{ $pdfUrl }}" title="Lecteur PDF" allowfullscreen></iframe>
                                </div>
                                <div class="text-center mb-3">
                                    <a href="{{ $pdfUrl }}" class="btn btn-outline-primary" target="_blank">
                                        <i class="fas fa-external-link-alt"></i> Ouvrir dans un nouvel onglet
                                    </a>
                                </div>
                            @elseif($contenu->media->where('type_fichier', 'video')->count() > 0)
                                @foreach($contenu->media->where('type_fichier', 'video') as $video)
                                    <div class="ratio ratio-16x9 mb-4">
                                        <video controls controlsList="nodownload">
                                            <source src="{{ asset('storage/' . $video->chemin_fichier) }}" type="{{ $video->mime_type }}">
                                            Votre navigateur ne supporte pas la lecture de vidéos.
                                        </video>
                                    </div>
                                @endforeach

                                @if($contenu->media->where('type_fichier', 'audio')->count() > 0)
                                    <div class="audio-section mb-4">
                                        <h5 class="mb-3"><i class="fas fa-headphones text-secondary"></i> Audio</h5>
                                        @foreach($contenu->media->where('type_fichier', 'audio') as $audio)
                                            <div class="card border-0 shadow-sm mb-3">
                                                <div class="card-body">
                                                    <h6 class="mb-2">{{ $audio->titre ?? $audio->nom_fichier }}</h6>
                                                    <audio controls class="w-100" controlsList="nodownload">
                                                        <source src="{{ asset('storage/' . $audio->chemin_fichier) }}" type="{{ $audio->mime_type }}">
                                                        Votre navigateur ne supporte pas l'élément audio.
                                                    </audio>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="mt-4">
                                    {!! $contenu->texte !!}
                                </div>
                            @else
                                {!! $contenu->texte !!}
                            @endif
                        </div>
                        
                        @if($contenu->estPayeParUtilisateur() && $contenu->prix > 0)
                            @php
                                $paiement = $contenu->paiements->where('user_id', auth()->id())->first();
                            @endphp
                            @if($paiement)
                                <div class="alert alert-success mt-3">
                                    <i class="fas fa-check-circle"></i> Vous avez acheté ce contenu le 
                                    {{ $paiement->created_at->format('d/m/Y') }}
                                </div>
                            @endif
                        @endif
                    @endif
                </div>

                <!-- Details -->
                <h3 style="color: var(--secondary); margin-bottom: 15px; font-size: 20px;">
                    <i class="fas fa-info-circle"></i> Détails
                </h3>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-calendar"></i> Date de création :</strong> 
                           {{ $contenu->date_creation ? $contenu->date_creation->format('d/m/Y') : 'N/A' }}
                        </p>
                        <p><strong><i class="fas fa-language"></i> Langue :</strong> 
                           {{ $contenu->langue->nom_langue ?? 'Français' }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-map-marker-alt"></i> Région :</strong> 
                           {{ $contenu->region->nom_region ?? 'N/A' }}
                        </p>
                        <p><strong><i class="fas fa-tag"></i> Type :</strong> 
                           {{ $contenu->typeContenu->nom ?? 'Livre' }}
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar - Purchase Options -->
            <div class="col-md-4">
                <div class="card border-0 shadow-lg" style="border-radius: 15px;">
                    <div class="card-body">
                        <h4 class="card-title mb-4">
                            <i class="fas fa-shopping-bag"></i> Options d'Accès
                        </h4>
                        
                        <!-- Price Display -->
                        <div class="text-center mb-4">
                            @if($contenu->est_payant)
                                <div class="price-display">
                                    {{ $contenu->prix_formate }}
                                </div>
                                <p class="text-muted">Prix unique - Accès à vie</p>
                            @else
                                <div class="price-display text-success">
                                    Gratuit
                                </div>
                                <p class="text-muted">Accès immédiat</p>
                            @endif
                        </div>
                        
                        <!-- Purchase/Access Button -->
                        @if($contenu->est_payant)
                            @if($contenu->estPayeParUtilisateur())
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i> Vous avez déjà acheté ce contenu
                                </div>
                                <a href="{{ route('client.contenus.download', $contenu->id_contenu) }}" class="btn btn-primary w-100 mb-2">
                                    <i class="fas fa-download"></i> Télécharger
                                </a>
                                <a href="{{ route('client.contenus.read', $contenu->id_contenu) }}" class="btn btn-secondary w-100 mb-2">
                                    <i class="fas fa-book-reader"></i> Lire en ligne
                                </a>
                            @else
                                <a href="{{ route('client.contenus.paiement', $contenu->id_contenu) }}" 
                                   class="btn-buy mb-3">
                                    <i class="fas fa-shopping-cart"></i> Acheter maintenant
                                </a>
                                
                                <div class="security-badge">
                                    <i class="fas fa-shield-alt text-success"></i>
                                    <p class="small mb-0 mt-1">Paiement 100% sécurisé</p>
                                    <img src="https://fedapay.com/img/logos/logo-blue.svg" alt="FedaPay" style="height: 20px; margin-top: 10px;">
                                </div>
                            @endif
                        @else
                            <a href="{{ route('client.contenus.download', $contenu->id_contenu) }}" class="btn btn-success w-100 mb-3">
                                <i class="fas fa-download"></i> Télécharger gratuitement
                            </a>
                            <a href="{{ route('client.contenus.read', $contenu->id_contenu) }}" class="btn btn-secondary w-100 mb-3">
                                <i class="fas fa-book-reader"></i> Lire en ligne
                            </a>
                        @endif
                        
                        <!-- Features -->
                        <div class="mt-4">
                            <h6><i class="fas fa-star text-warning"></i> Ce que vous obtenez :</h6>
                            <ul class="list-unstyled mt-2">
                                <li class="mb-2"><i class="fas fa-check text-success"></i> Accès à vie</li>
                                <li class="mb-2"><i class="fas fa-check text-success"></i> Téléchargement illimité</li>
                                <li class="mb-2"><i class="fas fa-check text-success"></i> Support technique</li>
                                @if($contenu->est_payant)
                                <li class="mb-2"><i class="fas fa-check text-success"></i> Facture détaillée</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Related Media -->
                @if($contenu->media->count() > 0)
                <div class="card mt-3 border-0 shadow">
                    <div class="card-body">
                        <h5><i class="fas fa-images"></i> Médias associés</h5>
                        <div class="row mt-2">
                            @foreach($contenu->media->take(4) as $media)
                            <div class="col-6 mb-2">
                                @if($media->isImage())
                                <img src="{{ $media->url }}" class="img-thumbnail w-100" alt="{{ $media->titre }}" style="height: 80px; object-fit: cover;">
                                @else
                                <div class="text-center border rounded p-2">
                                    <i class="fas fa-file fa-2x text-secondary"></i>
                                    <p class="small mb-0">{{ $media->nom_fichier }}</p>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Ratings & Reviews Section -->
    <div class="info-section">
        <h2 class="info-title">
            <i class="fas fa-star text-warning"></i> Avis et Évaluations
        </h2>

        @auth
            @if(!$contenu->est_payant || $contenu->estPayeParUtilisateur())
                <div class="card border-0 bg-light mb-4" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <h5 class="mb-3">Laissez votre avis</h5>
                        <form id="ratingForm">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label d-block">Votre note :</label>
                                <div class="star-rating" style="font-size: 1.5rem; color: #cbd5e1; cursor: pointer;">
                                    <i class="far fa-star star-btn" data-value="1"></i>
                                    <i class="far fa-star star-btn" data-value="2"></i>
                                    <i class="far fa-star star-btn" data-value="3"></i>
                                    <i class="far fa-star star-btn" data-value="4"></i>
                                    <i class="far fa-star star-btn" data-value="5"></i>
                                    <input type="hidden" name="note" id="selectedNote" value="">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="texte" class="form-label">Votre commentaire :</label>
                                <textarea name="texte" id="texte" class="form-control" rows="3" placeholder="Partagez votre avis sur ce contenu..." style="border-radius: 10px;"></textarea>
                            </div>
                            <button type="button" onclick="submitReview()" class="btn btn-primary" style="border-radius: 10px; padding: 10px 25px;">
                                <i class="fas fa-paper-plane"></i> Publier mon avis
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Vous devez avoir accès à ce contenu pour laisser un avis.
                </div>
            @endif
        @endauth

        <div id="reviewsList" class="mt-4">
            @php
                $comments = \App\Models\Commentaire::where('id_contenu', $contenu->id_contenu)
                    ->with('user')
                    ->orderBy('created_at', 'desc')
                    ->get();
            @endphp

            @if($comments->count() > 0)
                <div class="row">
                    @foreach($comments as $comment)
                        <div class="col-md-6 mb-3">
                            <div class="p-3 border rounded-3 bg-white h-100 shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-primary-light text-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: bold; font-size: 0.8rem;">
                                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                        </div>
                                        <span class="fw-bold">{{ $comment->user->name }}</span>
                                    </div>
                                    <div class="text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $comment->note ? 'fas' : 'far' }} fa-star" style="font-size: 0.8rem;"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="mb-1 text-muted small">{{ $comment->created_at->diffForHumans() }}</p>
                                <p class="mb-0 italic">"{{ $comment->texte }}"</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-muted py-4">Aucun avis n'a été laissé pour ce contenu pour le moment.</p>
            @endif
        </div>
    </div>

    <!-- Related Content -->
    @if(isset($relatedBooks) && $relatedBooks->count() > 0)
    <div class="info-section">
        <h2 class="info-title">
            <i class="fas fa-book-open"></i> Contenus similaires
        </h2>
        <div class="row">
            @foreach($relatedBooks as $relBook)
            <div class="col-md-3 mb-3">
                <a href="{{ route('client.contenus.detail', $relBook->id_contenu) }}" style="text-decoration: none; color: inherit;">
                    <div class="product-mini-card h-100">
                        <div class="mini-book-cover" style="height: 150px; background: #e2e8f0; margin-bottom: 10px; display: flex; align-items: center; justify-content: center; color: var(--text-secondary); border-radius: 4px;">
                            <i class="fas fa-book fa-3x"></i>
                        </div>
                        <h5 style="font-size: 14px; margin-bottom: 5px; color: var(--text-main); height: 40px; overflow: hidden;">
                            {{ Str::limit($relBook->titre, 50) }}
                        </h5>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-secondary">
                                {{ $relBook->typeContenu->nom ?? 'Livre' }}
                            </span>
                            @if($relBook->prix > 0)
                            <span class="text-success fw-bold">
                                {{ number_format((float)$relBook->prix, 0, ',', ' ') }} FCFA
                            </span>
                            @else
                            <span class="text-muted">Gratuit</span>
                            @endif
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Call to Action -->
    @if($contenu->est_payant && !$contenu->estPayeParUtilisateur())
    <div class="info-section text-center" style="background: linear-gradient(135deg, #1e293b, #0f172a); color: white;">
        <h2 class="info-title" style="color: white; border-bottom-color: rgba(255,255,255,0.2);">
            <i class="fas fa-crown"></i> Débloquez ce contenu premium
        </h2>
        <p class="lead mb-4">Accédez à l'intégralité de ce contenu de qualité pour seulement {{ $contenu->prix_formate }}</p>
        <a href="{{ route('client.contenus.paiement', $contenu->id_contenu) }}" class="btn-buy" style="max-width: 300px; margin: 0 auto;">
            <i class="fas fa-unlock-alt"></i> Débloquer maintenant
        </a>
        <p class="mt-3 small opacity-75">
            <i class="fas fa-shield-alt"></i> Garantie de remboursement sous 30 jours
        </p>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Truncate text for preview
    function truncateText(element, maxLength) {
        const text = element.textContent;
        if (text.length > maxLength) {
            element.textContent = text.substring(0, maxLength) + '...';
        }
    }
    
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
        
        // Truncate long titles in mini cards
        document.querySelectorAll('.product-mini-card h5').forEach(title => {
            truncateText(title, 50);
        });

        // Star Rating Logic
        const starBtns = document.querySelectorAll('.star-btn');
        const selectedNoteInput = document.getElementById('selectedNote');

        starBtns.forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                const val = this.getAttribute('data-value');
                highlightStars(val);
            });

            btn.addEventListener('mouseleave', function() {
                highlightStars(selectedNoteInput.value || 0);
            });

            btn.addEventListener('click', function() {
                const val = this.getAttribute('data-value');
                selectedNoteInput.value = val;
                highlightStars(val);
            });
        });

        function highlightStars(count) {
            starBtns.forEach(btn => {
                const val = btn.getAttribute('data-value');
                if (val <= count) {
                    btn.classList.remove('far');
                    btn.classList.add('fas');
                    btn.style.color = '#f59e0b';
                } else {
                    btn.classList.remove('fas');
                    btn.classList.add('far');
                    btn.style.color = '#cbd5e1';
                }
            });
        }
    });

    function submitReview() {
        const note = document.getElementById('selectedNote').value;
        const texte = document.getElementById('texte').value;
        const form = document.getElementById('ratingForm');
        
        if (!note) {
            alert('Veuillez sélectionner une note.');
            return;
        }
        if (!texte) {
            alert('Veuillez entrer un commentaire.');
            return;
        }

        const formData = new FormData();
        formData.append('note', note);
        formData.append('texte', texte);
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("api.comment.add", ["type" => "contenu", "id" => $contenu->id_contenu]) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                location.reload(); // Recharger pour voir l'avis
            } else {
                alert('Erreur: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Une erreur est survenue.');
        });
    }
</script>
@endpush
