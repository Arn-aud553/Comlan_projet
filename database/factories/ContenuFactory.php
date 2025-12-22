<?php

namespace Database\Factories;

use App\Models\Contenu;
use App\Models\Langue;
use App\Models\Region;
use App\Models\TypeContenu;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contenu>
 */
class ContenuFactory extends Factory
{
    protected $model = Contenu::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titre' => fake()->sentence(),
            'texte' => fake()->paragraphs(3, true),
            'id_langue' => function() { return Langue::factory()->create()->id_langue; },
            'id_region' => function() { return Region::factory()->create()->id_region; },
            'id_type_contenu' => function() { return TypeContenu::factory()->create()->id_type_contenu; },
            'id_auteur' => function() { return User::factory()->create()->id; },
            'id_moderateur' => function() { return User::factory()->create()->id; },
            'statut' => 'publie',
            'prix' => fake()->randomElement([0, 0, 0, 500, 1000, 2000]),
            'is_active' => true,
            'date_creation' => now(),
        ];
    }
}
