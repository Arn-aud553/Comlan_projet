<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\Contenu;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom_fichier' => fake()->word() . '.' . fake()->fileExtension(),
            'titre' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'chemin_fichier' => 'media/' . fake()->word() . '.' . fake()->fileExtension(),
            'type_fichier' => fake()->randomElement(['image', 'video', 'document', 'livre']),
            'extension' => fake()->fileExtension(),
            'taille_fichier' => fake()->numberBetween(1000, 10000000),
            'mime_type' => fake()->mimeType(),
            'prix' => fake()->randomElement([0, 500, 1000, 2000, 5000]),
            'id_contenu' => function() { return Contenu::factory()->create()->id_contenu; },
            'id_utilisateur' => function() { return User::factory()->create()->id; },
        ];
    }
}
