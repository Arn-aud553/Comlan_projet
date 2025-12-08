<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CacheLock;

class CacheLockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CacheLock::factory(10)->create();
    }
}