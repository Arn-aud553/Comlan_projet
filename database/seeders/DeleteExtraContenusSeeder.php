<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contenu;
use Illuminate\Support\Facades\DB;

class DeleteExtraContenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Garder seulement 3 contenus (les plus récents)
        $contenusToKeep = Contenu::orderBy('id_contenu', 'desc')
            ->take(3)
            ->pluck('id_contenu')
            ->toArray();

        echo "Contenus à garder: " . implode(', ', $contenusToKeep) . "\n";

        // Supprimer tous les autres contenus
        $deleted = Contenu::whereNotIn('id_contenu', $contenusToKeep)->delete();

        echo "Contenus supprimés: $deleted\n";
        echo "Contenus restants: " . Contenu::count() . "\n";
    }
}
