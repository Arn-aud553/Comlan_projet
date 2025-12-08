<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Contenu;
use App\Models\TypeContenu;
use App\Models\Langue;
use App\Models\Region;
use App\Models\User;

try {
    $typeContenu = TypeContenu::first();
    $langue = Langue::first();
    $region = Region::first();
    $auteur = User::first();

    echo "Type: " . ($typeContenu ? $typeContenu->id_type_contenu : 'NULL') . PHP_EOL;
    echo "Langue: " . ($langue ? $langue->id_langue : 'NULL') . PHP_EOL;
    echo "Region: " . ($region ? $region->id_region : 'NULL') . PHP_EOL;
    echo "User: " . ($auteur ? $auteur->id : 'NULL') . PHP_EOL;

    // Test 1: avec statut 'brouillon' (valeur par défaut)
    try {
        $contenu1 = Contenu::create([
            'titre' => 'Test Brouillon',
            'texte' => 'Ceci est un test.',
            'statut' => 'brouillon',
            'id_type_contenu' => $typeContenu->id_type_contenu,
            'id_langue' => $langue->id_langue,
            'id_region' => $region->id_region,
            'id_auteur' => $auteur->id,
        ]);
        echo "SUCCESS Test 1: Contenu 'brouillon' créé avec ID " . $contenu1->id_contenu . PHP_EOL;
        $contenu1->delete();
    } catch (Exception $e) {
        echo "ERROR Test 1 (brouillon): " . $e->getMessage() . PHP_EOL;
    }

    // Test 2: avec statut 'publié'
    try {
        $contenu2 = Contenu::create([
            'titre' => 'Test Publié',
            'texte' => 'Ceci est un test.',
            'statut' => 'publié',
            'id_type_contenu' => $typeContenu->id_type_contenu,
            'id_langue' => $langue->id_langue,
            'id_region' => $region->id_region,
            'id_auteur' => $auteur->id,
        ]);
        echo "SUCCESS Test 2: Contenu 'publié' créé avec ID " . $contenu2->id_contenu . PHP_EOL;
        $contenu2->delete();
    } catch (Exception $e) {
        echo "ERROR Test 2 (publié): " . $e->getMessage() . PHP_EOL;
    }

    // Test 3: Sans spécifier le statut (utilise la valeur par défaut)
    try {
        $contenu3 = Contenu::create([
            'titre' => 'Test Sans Statut',
            'texte' => 'Ceci est un test.',
            'id_type_contenu' => $typeContenu->id_type_contenu,
            'id_langue' => $langue->id_langue,
            'id_region' => $region->id_region,
            'id_auteur' => $auteur->id,
        ]);
        echo "SUCCESS Test 3: Contenu sans statut créé avec ID " . $contenu3->id_contenu . PHP_EOL;
        $contenu3->delete();
    } catch (Exception $e) {
        echo "ERROR Test 3 (sans statut): " . $e->getMessage() . PHP_EOL;
    }

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . PHP_EOL;
    echo "Trace: " . $e->getTraceAsString() . PHP_EOL;
}
