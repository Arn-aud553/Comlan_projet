<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Contenus - CULTURE BENIN</title>
    
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            /* Palette Premium - Chic & Modern (Matching Dashboard) */
            --chic-primary: #1e293b;   /* Slate 800 - Deep Navy */
            --chic-secondary: #b45309; /* Amber 700 - Antique Gold */
            --chic-accent: #0f172a;    /* Slate 900 */
            --chic-bg: #f8fafc;        /* Slate 50 */
            --card-bg: #ffffff;
            --text-main: #334155;
            --text-light: #64748b;
            
            --gradient-primary: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            
            --shadow-card: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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

        /* Header */
        .page-header {
            background: var(--card-bg);
            padding: 40px;
            border-radius: 20px;
            box-shadow: var(--shadow-card);
            margin-bottom: 40px;
            text-align: center;
            border-top: 5px solid var(--chic-secondary);
        }
        
        .page-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            color: var(--chic-primary);
            margin-bottom: 15px;
        }
        
        .page-header p {
            color: var(--text-light);
            font-size: 16px;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Book List */
        .books-list {
            display: flex;
            flex-direction: column;
            gap: 30px;
            margin-bottom: 60px;
        }
        
        .book-card {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow-card);
            overflow: hidden;
            display: grid;
            grid-template-columns: 200px 1fr;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }
        
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
            border-color: var(--chic-secondary);
        }
        
        .book-image {
            background: var(--chic-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .book-image i {
            font-size: 60px;
            color: rgba(255,255,255,0.2);
        }
        
        .rank-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: var(--chic-secondary);
            color: white;
            padding: 5px 10px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
        }
        
        .book-details {
            padding: 25px;
        }
        
        .book-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            color: var(--chic-primary);
            margin-bottom: 15px;
            font-weight: 700;
            line-height: 1.4;
        }
        
        .book-meta {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 10px;
            font-size: 14px;
            margin-bottom: 20px;
        }
        
        .meta-label {
            color: var(--text-light);
            font-weight: 500;
        }
        
        .meta-value {
            color: var(--text-main);
            font-weight: 600;
        }
        
        .rating {
            color: #fbbf24;
            margin-bottom: 15px;
        }
        
        .book-plot {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            font-size: 13px;
            color: var(--text-light);
            margin-bottom: 20px;
            border-left: 3px solid var(--chic-secondary);
        }
        
        .card-actions {
            display: flex;
            gap: 15px;
        }
        
        .btn-offer {
            flex: 1;
            background: var(--chic-secondary);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-offer:hover { background: #d97706; }
        
        .btn-critique {
            flex: 1;
            background: white;
            color: var(--chic-primary);
            border: 1px solid #e2e8f0;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-critique:hover { background: #f1f5f9; }

        /* Pagination (Ajouté pour gérer les résultats du contrôleur) */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        /* Styles supprimés (Info Section, Q&A, Tags, etc.) car le contenu statique a été retiré */
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 30px;
            color: var(--chic-primary);
            text-decoration: none;
            font-weight: 600;
        }
        
        @media (max-width: 768px) {
            .book-card { grid-template-columns: 1fr; }
            .book-image { height: 200px; }
        }
    </style>
</head>
<body>

    <div class="container">
        <a href="{{ route('client.dashboard') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Retour au Tableau de Bord
        </a>

            <header class="page-header">
            <div style="font-size: 48px; color: var(--chic-secondary); margin-bottom: 20px;">
                <i class="fas fa-book-reader"></i>
            </div>
            <h1>Gestion des Contenus</h1>
            <p>Explorez tous les contenus (livres, articles, etc.) publiés sur la plateforme. </p>
        </header>

            <h2 style="color: var(--chic-primary); margin-bottom: 30px; font-family: 'Playfair Display', serif;">Liste des Contenus ({{ $contenus->total() ?? 0 }})</h2>
        
        <div class="books-list">
                    @foreach($contenus as $contenu)
            <div class="book-card">
                <div class="book-image">
                                        <span class="rank-badge">#{{ ($contenus->currentPage() - 1) * $contenus->perPage() + $loop->iteration }}</span>
                    @if($contenu->media->isNotEmpty() && $contenu->media->first()->fichier_url)
                        <img src="{{ asset('storage/' . $contenu->media->first()->fichier_url) }}" alt="Couverture de {{ $contenu->titre }}" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <i class="fas fa-book"></i>
                    @endif

                    <!-- Media Type Icons Overlay -->
                    <div style="position: absolute; bottom: 10px; right: 10px;">
                        @include('partials.media-type-indicators', ['contenu' => $contenu, 'size' => '28px', 'fontSize' => '0.8rem'])
                    </div>
                </div>
                <div class="book-details">
                    <h3 class="book-title">{{ $contenu->titre ?? 'Titre non défini' }}</h3>
                    
                                        <div class="rating">
                        @php $rating = rand(3, 5); @endphp 
                        @for($i = 0; $i < 5; $i++)
                            @if($i < $rating)
                                <i class="fas fa-star"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                        <span style="color: #64748b; font-size: 13px; margin-left: 5px;">({{ $rating }}.0)</span>
                    </div>

                    <div class="book-meta">
                        <div class="meta-label">Type</div>
                        <div class="meta-value">{{ $contenu->typeContenu->nom ?? 'Inconnu' }}</div>
                        
                        <div class="meta-label">Auteur</div>
                        <div class="meta-value">{{ $contenu->auteur->nom ?? 'Anonyme' }}</div>
                        
                        <div class="meta-label">Langue</div>
                        <div class="meta-value">{{ $contenu->langue->nom ?? 'Français' }}</div>
                        
                        <div class="meta-label">Publication</div>
                        <div class="meta-value">{{ \Carbon\Carbon::parse($contenu->date_creation)->format('Y') }}</div>
                    </div>
                    
                    <div class="book-plot">
                        {{ \Illuminate\Support\Str::limit($contenu->resume ?? $contenu->texte, 200) }}
                    </div>
                    
                    <div class="card-actions">
                        <a href="{{ route('client.contenus.detail', ['id' => $contenu->id_contenu]) }}" class="btn-offer" style="text-decoration:none; display:inline-block; text-align:center;">Voir Détails</a>
                        <button class="btn-critique">Critiques</button>
                    </div>
                </div>
            </div>
            @endforeach
                    </div>

                @if(isset($contenus))
        <div class="pagination">
            {{ $contenus->links() }}
        </div>
        @endif
                        
                <div class="social-share" style="justify-content:center;">
            <button class="btn-social btn-fb"><i class="fab fa-facebook-f"></i> Facebook</button>
            <button class="btn-social btn-tw"><i class="fab fa-twitter"></i> Twitter</button>
            <button class="btn-social btn-pin"><i class="fab fa-pinterest-p"></i> Pinterest</button>
            <button class="btn-social btn-wa"><i class="fab fa-whatsapp"></i> WhatsApp</button>
        </div>
    </div>

</body>
</html>