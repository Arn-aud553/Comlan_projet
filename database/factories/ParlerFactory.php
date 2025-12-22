<?php

namespace Database\Factories;

use App\Models\Parler;
use App\Models\User;
use App\Models\Langue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Parler>
 */
class ParlerFactory extends Factory
{
    protected $model = Parler::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_utilisateur' => function() { return User::factory()->create()->id; },
            'id_langue' => function() { return Langue::factory()->create()->id_langue; },
        ];
    }
}
