<?php

namespace Database\Factories;

use App\Models\Langue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Langue>
 */
class LangueFactory extends Factory
{
    protected $model = Langue::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom_langue' => fake()->word(),
            'code_langue' => strtoupper(fake()->lexify('??')),
            'description' => fake()->sentence(),
        ];
    }
}
