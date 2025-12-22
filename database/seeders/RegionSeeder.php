<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            ['nom_region' => 'Alibori', 'description' => 'Département du Nord'],
            ['nom_region' => 'Atacora', 'description' => 'Département du Nord-Ouest'],
            ['nom_region' => 'Atlantique', 'description' => 'Département du Sud'],
            ['nom_region' => 'Borgou', 'description' => 'Département du Nord-Est'],
            ['nom_region' => 'Collines', 'description' => 'Département du Centre'],
            ['nom_region' => 'Couffo', 'description' => 'Département du Sud-Ouest'],
            ['nom_region' => 'Donga', 'description' => 'Département du Nord-Ouest'],
            ['nom_region' => 'Littoral', 'description' => 'Département de Cotonou'],
            ['nom_region' => 'Mono', 'description' => 'Département du Sud-Ouest'],
            ['nom_region' => 'Ouémé', 'description' => 'Département de Porto-Novo'],
            ['nom_region' => 'Plateau', 'description' => 'Département du Sud-Est'],
            ['nom_region' => 'Zou', 'description' => 'Département du Centre'],
        ];

        foreach ($regions as $region) {
            Region::updateOrCreate(['nom_region' => $region['nom_region']], $region);
        }
    }
}