<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeMedia;

class TypeMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeMedia::create(['nom_media' => 'Image']);
        TypeMedia::create(['nom_media' => 'Vidéo']);
        TypeMedia::create(['nom_media' => 'Audio']);
    }
}