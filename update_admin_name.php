<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $result = DB::table('users')
        ->where('id', 1)
        ->update(['name' => 'M. Maurice COMLAN']);
    
    echo "✓ Nom mis à jour avec succès ! Lignes affectées : " . $result . "\n";
    
    // Vérifier
    $user = DB::table('users')->where('id', 1)->first();
    echo "Nom actuel : " . $user->name . "\n";
    
} catch (Exception $e) {
    echo "✗ Erreur : " . $e->getMessage() . "\n";
}
