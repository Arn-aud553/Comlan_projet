<?php

namespace Database\Factories;

use App\Models\TypeContenu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TypeContenu>
 */
class TypeContenuFactory extends Factory
{
    protected $model = TypeContenu::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->randomElement([
                'Danse', 'Musique', 'Art', 'Traditions', 'Rites', 
                'Monuments', 'Cuisine', 'Artisanat', 'Histoire', 'Littérature'
            ]),
        ];
    }
}
