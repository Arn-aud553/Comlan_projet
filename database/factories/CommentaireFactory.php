<?php

namespace Database\Factories;

use App\Models\Commentaire;
use App\Models\Contenu;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commentaire>
 */
class CommentaireFactory extends Factory
{
    protected $model = Commentaire::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'texte' => fake()->paragraph(),
            'note' => fake()->numberBetween(1, 5),
            'id_contenu' => function() { return Contenu::factory()->create()->id_contenu; },
        ];
    }
}
