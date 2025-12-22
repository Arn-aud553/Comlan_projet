<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Contenu;
use App\Models\User;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        $contenu = Contenu::first();
        $user = User::first();
        
        if (!$contenu || !$user) return;

        $medias = [
            [
                'nom_fichier' => 'culture_benin.jpg',
                'titre' => 'Culture du Benin',
                'description' => 'Image representative de la culture beninoise',
                'chemin_fichier' => 'media/culture_benin.jpg',
                'type_fichier' => 'image',
                'extension' => 'jpg',
                'taille_fichier' => 1024567,
                'mime_type' => 'image/jpeg',
                'prix' => 0,
            ],
            [
                'nom_fichier' => 'danse_traditionnelle.mp4',
                'titre' => 'Danse Traditionnelle',
                'description' => 'Video d\'une danse traditionnelle au sud du Benin',
                'chemin_fichier' => 'media/danse_traditionnelle.mp4',
                'type_fichier' => 'video',
                'extension' => 'mp4',
                'taille_fichier' => 15024567,
                'mime_type' => 'video/mp4',
                'prix' => 500,
            ]
        ];

        foreach ($medias as $media) {
            DB::table('media')->insert(array_merge($media, [
                'id_contenu' => $contenu->id_contenu,
                'id_utilisateur' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}