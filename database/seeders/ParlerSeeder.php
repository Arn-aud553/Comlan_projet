<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parler;

class ParlerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Parler::factory(10)->create();
    }
}