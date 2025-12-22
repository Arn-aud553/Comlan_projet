<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Langue;

class LangueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $langues = [
            ['nom_langue' => 'Français', 'code_langue' => 'FR', 'description' => 'Langue officielle'],
            ['nom_langue' => 'Fon', 'code_langue' => 'FON', 'description' => 'Langue majoritaire du sud'],
            ['nom_langue' => 'Yoruba', 'code_langue' => 'YOR', 'description' => 'Langue du sud-est'],
            ['nom_langue' => 'Bariba', 'code_langue' => 'BAR', 'description' => 'Langue du nord'],
            ['nom_langue' => 'Dendi', 'code_langue' => 'DEN', 'description' => 'Langue du nord'],
            ['nom_langue' => 'Goun', 'code_langue' => 'GUN', 'description' => 'Langue de Porto-Novo'],
            ['nom_langue' => 'Mina', 'code_langue' => 'MIN', 'description' => 'Langue de la côte'],
        ];

        foreach ($langues as $langue) {
            Langue::updateOrCreate(['code_langue' => $langue['code_langue']], $langue);
        }
    }
}