<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Livre - CULTURE BENIN</title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            /* Palette Premium - Chic & Modern */
            --chic-primary: #1e293b;   /* Slate 800 */
            --chic-secondary: #b45309; /* Amber 700 */
            --chic-accent: #0f172a;    /* Slate 900 */
            --chic-bg: #f8fafc;        /* Slate 50 */
            --card-bg: #ffffff;
            --text-main: #334155;
            --text-light: #64748b;
            
            --shadow-card: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        
        body {
            background-color: var(--chic-bg);
            color: var(--text-main);
            padding: 40px;
            background-image: radial-gradient(#e2e8f0 1px, transparent 1px);
            background-size: 24px 24px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 30px;
            color: var(--chic-primary);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        .back-link:hover { color: var(--chic-secondary); }

        .info-section {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: var(--shadow-card);
            margin-bottom: 40px;
        }
        
        .info-title {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            color: var(--chic-primary);
            margin-bottom: 20px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 10px;
        }
        
        .text-content {
            margin-bottom: 30px;
            line-height: 1.8;
            color: var(--text-main);
        }

        /* Product Grids */
        .product-mini-card {
            background: #fff;
            padding: 10px;
            border-radius: 8px;
            transition: transform 0.3s;
        }
        .product-mini-card:hover { transform: translateY(-5px); }
    </style>
</head>
<body>

    <div class="container">
        <a href="{{ route('client.contenus.manage') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>

        <!-- Header for the specific book -->
        <div class="page-header" style="background: white; padding: 30px; border-radius: 20px; box-shadow: var(--shadow-card); margin-bottom: 40px; text-align: left; display: flex; gap: 30px; align-items: flex-start;">
            <div style="background: var(--chic-primary); width: 120px; height: 160px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="fas fa-book fa-3x" style="color: rgba(255,255,255,0.2);"></i>
            </div>
            <div>
                <h1 style="font-family: 'Playfair Display', serif; font-size: 32px; color: var(--chic-primary); margin-bottom: 10px;">{{ $contenu->titre }}</h1>
                <p style="color: var(--text-light); font-size: 18px;">
                    Par {{ $contenu->auteur ? ($contenu->auteur->nom_complet ?? $contenu->auteur->name) : 'Auteur inconnu' }}
                </p>
                
                @php
                    $rating = rand(3, 5); // Mock rating as it's not yet in DB
                @endphp

                <div class="rating" style="color: #fbbf24; margin-top: 10px;">
                    @for($i = 0; $i < 5; $i++)
                        @if($i < $rating)
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                    <span style="color: #64748b; font-size: 14px; margin-left: 5px;">({{ $rating }}.0)</span>
                </div>
            </div>
        </div>

        <!-- Content details -->
        <div class="info-section">
            <h2 class="info-title">Description</h2>
            
            <div class="text-content">
                {!! nl2br(e($contenu->texte)) !!}
            </div>

            <h3 style="color: var(--chic-secondary); margin-bottom: 15px; font-size: 20px;">Détails</h3>
            <div class="product-details-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 40px;">
                <div class="detail-item"><strong>Date de création :</strong> {{ $contenu->date_creation ? $contenu->date_creation->format('d/m/Y') : 'N/A' }}</div>
                <div class="detail-item"><strong>Langue :</strong> {{ $contenu->langue->nom_langue ?? 'Français' }}</div>
                <div class="detail-item"><strong>Région :</strong> {{ $contenu->region->nom_region ?? 'N/A' }}</div>
                <div class="detail-item"><strong>Type :</strong> {{ $contenu->typeContenu->nom ?? 'Livre' }}</div>
                
                <div class="detail-item" style="grid-column: span 2;">
                    <strong>Classement des lectures :</strong> {{ rand(100, 5000) }} vues<br>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2 class="info-title">Titres similaires</h2>
            <div class="products-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; text-align: center;">
                @forelse($popularBooks as $popBook)
                <a href="{{ route('client.book.details', ['id' => $popBook->id_contenu]) }}" style="text-decoration: none; color: inherit; display: block;">
                    <div class="product-mini-card">
                        <div class="mini-book-cover" style="height: 150px; background: #e2e8f0; margin-bottom: 10px; display: flex; align-items: center; justify-content: center; color: var(--text-light); border-radius: 4px;">
                            <i class="fas fa-book fa-3x"></i>
                        </div>
                        <h4 style="font-size: 14px; margin-bottom: 5px; color: var(--chic-primary);">{{ \Illuminate\Support\Str::limit($popBook->titre, 40) }}</h4>
                        <!-- Mock rating for list items -->
                        @php $popRating = rand(3, 5); @endphp
                        <div class="mini-rating" style="color: #fbbf24; font-size: 12px; margin-bottom: 5px;">
                            @for($i=0; $i<$popRating; $i++) <i class="fas fa-star"></i> @endfor
                        </div>
                    </div>
                </a>
                @empty
                <p>Aucun titre similaire trouvé.</p>
                @endforelse
            </div>
        </div>

        <div class="info-section">
            <h2 class="info-title">D'autres lectures suggérées</h2>
            <div class="products-grid" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px; text-align: center;">
                @forelse($relatedBooks as $relBook)
                <a href="{{ route('client.book.details', ['id' => $relBook->id_contenu]) }}" style="text-decoration: none; color: inherit; display: block;">
                    <div class="product-mini-card">
                        <div class="mini-book-cover" style="height: 120px; background: #f1f5f9; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; color: var(--text-light); border-radius: 4px;">
                            <i class="fas fa-book-open fa-2x"></i>
                        </div>
                        <h4 style="font-size: 12px; margin-bottom: 4px; color: var(--text-main); height: 30px; overflow: hidden;">{{ \Illuminate\Support\Str::limit($relBook->titre, 30) }}</h4>
                        @php $relRating = rand(3, 5); @endphp
                        <div class="mini-rating" style="color: #fbbf24; font-size: 10px; margin-bottom: 4px;">
                            @for($i=0; $i<$relRating; $i++) <i class="fas fa-star"></i> @endfor
                        </div>
                    </div>
                </a>
                @empty
                <p>Aucune suggestion pour le moment.</p>
                @endforelse
            </div>
        </div>

        <div class="info-section">
            <h2 class="info-title">Avis des lecteurs</h2>
            <div class="reviews-container" style="display: flex; align-items: center; gap: 30px;">
                <div class="average-rating" style="text-align: center;">
                    <div style="font-size: 48px; font-weight: 700; color: var(--chic-primary);">{{ $rating }},0</div>
                    <div class="stars" style="color: #fbbf24; font-size: 18px; margin: 5px 0;">
                        @for($i=0; $i<5; $i++)
                            @if($i < $rating) <i class="fas fa-star"></i> @else <i class="far fa-star"></i> @endif
                        @endfor
                    </div>
                </div>
                
                <div class="rating-breakdown" style="flex: 1;">
                    <!-- Static breakdown for visual placeholder -->
                    <div class="bar-row" style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                        <span style="font-size: 13px; width: 40px;">5 étoiles</span>
                        <div class="bar-bg" style="flex: 1; height: 10px; background: #e2e8f0; border-radius: 5px; overflow: hidden;">
                            <div class="bar-fill" style="width: 60%; height: 100%; background: #fbbf24;"></div>
                        </div>
                    </div>
                    <div class="bar-row" style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                        <span style="font-size: 13px; width: 40px;">4 étoiles</span>
                        <div class="bar-bg" style="flex: 1; height: 10px; background: #e2e8f0; border-radius: 5px; overflow: hidden;">
                            <div class="bar-fill" style="width: 30%; height: 100%; background: #fbbf24;"></div>
                        </div>
                    </div>
                </div>
                
                <button onclick="openReviewModal()" class="btn-write-review" style="padding: 12px 24px; background: transparent; border: 2px solid var(--chic-primary); color: var(--chic-primary); font-weight: 600; border-radius: 8px; cursor: pointer; transition: all 0.3s; white-space: nowrap;">
                    Écrire un avis
                </button>
            </div>
        </div>

    </div>

    <!-- Review Modal -->
    <div id="reviewModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
        <div style="background: white; width: 500px; padding: 30px; border-radius: 12px; position: relative; animation: slideIn 0.3s ease;">
            <button onclick="closeReviewModal()" style="position: absolute; top: 15px; right: 15px; border: none; background: none; font-size: 20px; cursor: pointer; color: #64748b;">&times;</button>
            
            <h2 style="font-family: 'Playfair Display', serif; color: var(--chic-primary); margin-bottom: 20px;">Écrire un avis</h2>
            
            <form onsubmit="submitReview(event)">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Votre Note</label>
                    <div class="rating-input" style="color: #cbd5e1; font-size: 24px; cursor: pointer;">
                        <i class="far fa-star" onclick="setRating(1)"></i>
                        <i class="far fa-star" onclick="setRating(2)"></i>
                        <i class="far fa-star" onclick="setRating(3)"></i>
                        <i class="far fa-star" onclick="setRating(4)"></i>
                        <i class="far fa-star" onclick="setRating(5)"></i>
                    </div>
                    <input type="hidden" id="ratingValue" required>
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Votre Nom</label>
                    <input type="text" class="input-field" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;">
                </div>
                
                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 500;">Votre Commentaire</label>
                    <textarea class="input-field" rows="4" required style="width: 100%; padding: 10px; border: 1px solid #e2e8f0; border-radius: 6px;"></textarea>
                </div>
                
                <button type="submit" style="width: 100%; padding: 12px; background: var(--chic-secondary); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">Envoyer</button>
            </form>
        </div>
    </div>

    <script>
        function openReviewModal() {
            document.getElementById('reviewModal').style.display = 'flex';
        }

        function closeReviewModal() {
            document.getElementById('reviewModal').style.display = 'none';
        }

        function setRating(val) {
            document.getElementById('ratingValue').value = val;
            const stars = document.querySelectorAll('.rating-input i');
            stars.forEach((star, index) => {
                if (index < val) {
                    star.classList.remove('far');
                    star.classList.add('fas');
                    star.style.color = '#fbbf24';
                } else {
                    star.classList.remove('fas');
                    star.classList.add('far');
                    star.style.color = '#cbd5e1';
                }
            });
        }

        function submitReview(e) {
            e.preventDefault();
            const btn = e.target.querySelector('button[type="submit"]');
            const originalText = btn.innerText;
            btn.innerText = 'Envoi...';
            btn.disabled = true;

            setTimeout(() => {
                alert('Merci ! Votre avis a été soumis avec succès.');
                closeReviewModal();
                btn.innerText = originalText;
                btn.disabled = false;
                e.target.reset();
                setRating(0); 
            }, 1000);
        }

        document.getElementById('reviewModal').addEventListener('click', function(e) {
            if (e.target === this) closeReviewModal();
        });
    </script>

    <style>
        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .input-field:focus { outline: 2px solid var(--chic-secondary); border-color: transparent; }
    </style>
</body>
</html>
