<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== Mise à jour des contenus brouillon vers publie ===\n\n";

// Vérifier l'état actuel
echo "État AVANT mise à jour:\n";
echo "- Contenus 'brouillon': " . DB::table('contenus')->where('statut', 'brouillon')->count() . "\n";
echo "- Contenus 'publie': " . DB::table('contenus')->where('statut', 'publie')->count() . "\n";
echo "- Contenus 'en attente': " . DB::table('contenus')->where('statut', 'en attente')->count() . "\n";
echo "- Contenus avec is_active=1: " . DB::table('contenus')->where('is_active', 1)->count() . "\n\n";

// Mettre à jour tous les contenus brouillon vers publie
$updated = DB::table('contenus')
    ->where('statut', 'brouillon')
    ->update([
        'statut' => 'publie',
        'is_active' => true,
        'date_publication' => now()
    ]);

echo "✅ Nombre de contenus mis à jour: $updated\n\n";

// Vérifier l'état après
echo "État APRÈS mise à jour:\n";
echo "- Contenus 'brouillon': " . DB::table('contenus')->where('statut', 'brouillon')->count() . "\n";
echo "- Contenus 'publie': " . DB::table('contenus')->where('statut', 'publie')->count() . "\n";
echo "- Contenus 'en attente': " . DB::table('contenus')->where('statut', 'en attente')->count() . "\n";
echo "- Contenus avec is_active=1: " . DB::table('contenus')->where('is_active', 1)->count() . "\n\n";

// Afficher quelques exemples
echo "Exemples de contenus publiés:\n";
$contenus = DB::table('contenus')
    ->where('statut', 'publie')
    ->select('id_contenu', 'titre', 'statut', 'is_active')
    ->limit(5)
    ->get();

foreach ($contenus as $contenu) {
    echo sprintf(
        "  - [#%03d] %s | statut: %s | is_active: %s\n",
        $contenu->id_contenu,
        substr($contenu->titre, 0, 50),
        $contenu->statut,
        $contenu->is_active ? 'true' : 'false'
    );
}

echo "\n✅ Mise à jour terminée avec succès!\n";
