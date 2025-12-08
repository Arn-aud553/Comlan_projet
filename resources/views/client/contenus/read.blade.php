<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book['title'] }} - Lecture</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --paper-bg: #fdfbf7;
            --text-main: #2c3e50;
            --chic-primary: #1e293b;
        }

        body {
            font-family: 'Merriweather', serif;
            background-color: var(--paper-bg);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            line-height: 1.8;
        }

        .reader-header {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .book-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 18px;
            color: var(--chic-primary);
        }

        .back-link {
            text-decoration: none;
            color: var(--chic-primary);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .reader-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 40px;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            min-height: 80vh;
        }

        .chapter-title {
            text-align: center;
            margin-bottom: 40px;
            font-family: 'Playfair Display', serif;
            color: var(--chic-primary);
        }

        .content-text {
            font-size: 18px;
            text-align: justify;
        }

        .content-text p {
            margin-bottom: 20px;
            text-indent: 30px;
        }

        .pagination-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-family: 'Playfair Display', serif;
        }

        .page-btn {
            text-decoration: none;
            padding: 10px 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: var(--text-main);
            transition: all 0.3s;
        }

        .page-btn:hover {
            background: var(--chic-primary);
            color: white;
            border-color: var(--chic-primary);
        }

        .page-btn.disabled {
            opacity: 0.5;
            pointer-events: none;
        }

        .page-info {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <header class="reader-header">
        <a href="{{ route('client.book.details', ['id' => $book['id']]) }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Retour aux détails
        </a>
        <div class="book-title">{{ $book['title'] }}</div>
        <div style="width: 100px;"></div> <!-- Spacer -->
    </header>

    <div class="reader-container">
        <h2 class="chapter-title">Page {{ $currentPage }}</h2>
        
        <div class="content-text">
            @foreach($content as $paragraph)
                <p>{{ $paragraph }}</p>
            @endforeach
        </div>

        <div class="pagination-bar">
            <a href="{{ route('client.book.read', ['id' => $book['id'], 'page' => $currentPage - 1]) }}" class="page-btn {{ $currentPage <= 1 ? 'disabled' : '' }}">
                <i class="fas fa-chevron-left"></i> Précédent
            </a>
            
            <span class="page-info">Page {{ $currentPage }} sur {{ $totalPages }}</span>
            
            <a href="{{ route('client.book.read', ['id' => $book['id'], 'page' => $currentPage + 1]) }}" class="page-btn {{ $currentPage >= $totalPages ? 'disabled' : '' }}">
                Suivant <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>

</body>
</html>
