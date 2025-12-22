<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\TypeContenu;
use App\Models\Langue;
use App\Models\Region;
use App\Models\User;

class ContenuSeeder extends Seeder
{
    public function run(): void
    {
        $typeContenu = TypeContenu::first();
        $langue = Langue::first();
        $region = Region::first();
        $auteur = User::first();

        if (!$typeContenu || !$langue || !$region || !$auteur) {
            return;
        }

        $contenus = [
            ['titre' => 'Les Rois du Dahomey : Histoire et Heritage', 'texte' => 'Histoire des rois du Dahomey.'],
            ['titre' => 'Le Vodoun : Spiritualite et Philosophie Beninoise', 'texte' => 'Philosophie du Vodoun.'],
            ['titre' => 'L\'Art du Bronze au Benin : Chef-d\'oeuvre de l\'Humanite', 'texte' => 'Art du bronze.'],
            ['titre' => 'La Gastronomie Beninoise : Saveurs et Traditions', 'texte' => 'Cuisine du Benin.'],
            ['titre' => 'Les Danses Traditionnelles : Expression de l\'Ame Beninoise', 'texte' => 'Danses du Benin.'],
            ['titre' => 'Les Langues du Benin : Diversite Linguistique', 'texte' => 'Langues du Benin.'],
            ['titre' => 'L\'Artisanat Beninois : Savoir-faire Ancestral', 'texte' => 'Artisanat du Benin.'],
            ['titre' => 'La Route de l\'Esclave : Memoire et Reconciliation', 'texte' => 'Histoire de Ouidah.'],
        ];

        foreach ($contenus as $contenuData) {
            DB::statement("
                INSERT INTO contenus (titre, texte, statut, id_region, id_langue, id_type_contenu, id_auteur, id_moderateur, date_creation, created_at, updated_at, is_active)
                VALUES (?, ?, 'brouillon', ?, ?, ?, ?, ?, NOW(), NOW(), NOW(), false)
            ", [
                $contenuData['titre'],
                $contenuData['texte'],
                $region->id_region,
                $langue->id_langue,
                $typeContenu->id_type_contenu,
                $auteur->id,
                $auteur->id
            ]);
        }

        DB::statement("UPDATE contenus SET statut = 'publie', is_active = true WHERE statut = 'brouillon'");
    }
}