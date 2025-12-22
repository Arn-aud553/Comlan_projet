<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Contenu;

class CommentaireSeeder extends Seeder
{
    public function run(): void
    {
        $contenu = Contenu::first();
        if (!$contenu) return;

        for ($i = 0; $i < 5; $i++) {
            DB::table('commentaires')->insert([
                'texte' => 'Commentaire de test ' . ($i + 1) . ' pour le contenu : ' . $contenu->titre,
                'note' => rand(1, 5),
                'id_contenu' => $contenu->id_contenu,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}