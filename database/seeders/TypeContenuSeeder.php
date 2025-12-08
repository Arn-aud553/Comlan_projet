<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeContenu;

class TypeContenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['nom' => 'Histoire & Traditions'],
            ['nom' => 'Art & Artisanat'],
            ['nom' => 'Musique & Danse'],
            ['nom' => 'Langues & Proverbes'],
            ['nom' => 'Gastronomie'],
            ['nom' => 'Littérature'],
            ['nom' => 'Cinéma & Audiovisuel'],
            ['nom' => 'Architecture'],
            ['nom' => 'Patrimoine'],
            ['nom' => 'Autre'],
        ];

        foreach ($types as $type) {
            TypeContenu::firstOrCreate(['nom' => $type['nom']], $type);
        }
    }
}