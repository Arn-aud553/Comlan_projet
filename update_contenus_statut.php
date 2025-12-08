<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $titres = [
        'Les Rois du Dahomey : Histoire et Héritage',
        'Le Vodoun : Spiritualité et Philosophie Béninoise',
        'L\'Art du Bronze au Bénin : Chef-d\'œuvre de l\'Humanité',
        'La Gastronomie Béninoise : Saveurs et Traditions',
        'Les Danses Traditionnelles : Expression de l\'Âme Béninoise',
        'Les Langues du Bénin : Diversité Linguistique',
        'L\'Artisanat Béninois : Savoir-faire Ancestral',
        'La Route de l\'Esclave : Mémoire et Réconciliation',
    ];

    $updated = 0;
    foreach ($titres as $titre) {
        $result = DB::update(
            "UPDATE contenus SET statut = ?, date_validation = NOW(), id_moderateur = 1 WHERE titre = ? AND statut = ?",
            ['publié', $titre, 'brouillon']
        );
        $updated += $result;
        echo "✓ Mis à jour: {$titre} ({$result} ligne(s))" . PHP_EOL;
    }

    echo PHP_EOL . "Total: {$updated} contenus mis à jour vers 'publié'" . PHP_EOL;

    // Vérification
    $publies = DB::table('contenus')->where('statut', 'publié')->count();
    echo "Contenus publiés en base: {$publies}" . PHP_EOL;

} catch (Exception $e) {
    echo "ERREUR: " . $e->getMessage() . PHP_EOL;
    echo "Trace: " . $e->getTraceAsString() . PHP_EOL;
}
