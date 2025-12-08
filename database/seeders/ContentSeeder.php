<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contenu;
use App\Models\User;
use App\Models\TypeContenu;
use App\Models\Langue;
use App\Models\Region;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have dependencies
        $user = User::first() ?? User::factory()->create();
        
        $photoType = TypeContenu::firstOrCreate(['nom' => 'Photo']);
        $videoType = TypeContenu::firstOrCreate(['nom' => 'Vidéo']);
        
        $langue = Langue::first() ?? Langue::create([
            'nom_langue' => 'Français', 
            'code_langue' => 'FR',
            'description' => 'Langue française'
        ]);

        $region = Region::first() ?? Region::create([
            'nom_region' => 'National', 
            'description' => 'Toute l\'étendue'
        ]);

        $categories = ['Danse', 'Musique', 'Art', 'Traditions', 'Rites', 'Monuments', 'Cuisine', 'Artisanat'];

        // Photos
        $totalPhotos = 1000;
        $this->command->info("Seeding $totalPhotos Photos...");
        
        $bar = $this->command->getOutput()->createProgressBar($totalPhotos);
        $bar->start();

        for ($i = 1; $i <= $totalPhotos; $i++) {
             $cat = $categories[array_rand($categories)];
             
             try {
                 Contenu::create([
                    'titre' => "Photo Culturelle #$i - $cat",
                    'texte' => "Une magnifique représentation de $cat...",
                    'date_creation' => now()->toDateTimeString(),
                    'statut' => 'brouillon',
'created_at' => now()->toDateTimeString(),
'updated_at' => now()->toDateTimeString(), // Safe ASCII
                    'id_region' => $region->id_region,
                    'id_langue' => $langue->id_langue,
                    'id_type_contenu' => $photoType->id_type_contenu,
                    'id_auteur' => $user->id,
                    'id_moderateur' => $user->id,
                    'date_validation' => now()->toDateTimeString(),
                 ]);
             } catch (\Exception $e) {
                 $this->command->error("Error at $i: " . $e->getMessage());
                 break;
             }
             $bar->advance();
        }
        $bar->finish();
        $this->command->info("");

        // Videos
        $totalVideos = 400;
        $this->command->info("Seeding $totalVideos Videos...");
        
        $bar = $this->command->getOutput()->createProgressBar($totalVideos);
        $bar->start();
        
        for ($i = 1; $i <= $totalVideos; $i++) {
             $cat = $categories[array_rand($categories)];
             try {
                Contenu::create([
                    'titre' => "Vidéo Découverte #$i - $cat",
                    'texte' => "Plongez au cœur de $cat...",
                    'date_creation' => now()->toDateTimeString(),
                    'statut' => 'brouillon',
'created_at' => now()->toDateTimeString(),
'updated_at' => now()->toDateTimeString(), // Safe ASCII
                    'id_region' => $region->id_region,
                    'id_langue' => $langue->id_langue,
                    'id_type_contenu' => $videoType->id_type_contenu,
                    'id_auteur' => $user->id,
                    'id_moderateur' => $user->id,
                    'date_validation' => now()->toDateTimeString(),
                ]);
             } catch (\Exception $e) {
                 $this->command->error("Error at Video $i: " . $e->getMessage());
                 break;
             }
             $bar->advance();
        }
        $bar->finish();
        
        $this->command->info("\nSeeding completed.");
    }
}
