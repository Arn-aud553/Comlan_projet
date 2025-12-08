<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobBatch;

class JobBatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobBatch::factory(10)->create();
    }
}