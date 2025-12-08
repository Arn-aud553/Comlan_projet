<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cache;

class CacheSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cache::factory(10)->create();
    }
}