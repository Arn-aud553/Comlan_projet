<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thématiques - La Culture du Bénin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" defer></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #343a40;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 2rem;
        }
        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin: 1rem;
        }
        .card-footer {
            display: flex;
            justify-content: flex-end;
            padding: 0.5rem 1rem;
        }
        .card-footer i {
            font-size: 1.5rem;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="header d-flex justify-content-between align-items-center">
        <img src="{{ asset('admin/img/Bine.jpg') }}" alt="Logo gauche" style="height: 50px;">
        <h1>LA CULTURE DU BENIN</h1>
        <img src="{{ asset('admin/img/Bine.jpg') }}" alt="Logo droite" style="height: 50px;">
    </div>
    <div class="grid">
        @php
            $cards = [
                ['title' => 'Média culturelle', 'image' => asset('admin/img/media.jpg')],
                ['title' => 'Symboles et identités', 'image' => asset('admin/img/Symboles.jpg')],
                ['title' => 'Culture et territoires', 'image' => asset('admin/img/Cultures.jpg')],
                ['title' => 'Langues et ethnies', 'image' => asset('admin/img/Langue.png')],
                ['title' => 'Histoires et patrimoines', 'image' => asset('admin/img/photo1.png')],
                ['title' => 'Littératures et arts modernes', 'image' => asset('admin/img/litterature.jpg')],
                ['title' => 'Gastronomie', 'image' => asset('admin/img/Gastronomie.jpg')],
                ['title' => 'Danses', 'image' => asset('admin/img/Danses.jpg')],
                ['title' => 'Art et traditions', 'image' => asset('admin/img/Traditions.jpg')],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="card" data-bs-toggle="modal" data-bs-target="#modal-{{ Str::slug($card['title'], '-') }}">
                <img src="{{ $card['image'] }}" alt="{{ $card['title'] }}">
                <div class="card-title">{{ $card['title'] }}</div>
                <div class="card-footer">
                    <i class="bi bi-arrow-right-circle"></i>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modal-{{ Str::slug($card['title'], '-') }}" tabindex="-1" aria-labelledby="modalLabel-{{ Str::slug($card['title'], '-') }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel-{{ Str::slug($card['title'], '-') }}">{{ $card['title'] }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Contenu détaillé pour "{{ $card['title'] }}".
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</body>
</html>