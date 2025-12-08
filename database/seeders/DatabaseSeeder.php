<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'maurice.comlan@uac.bj',
            'password' => Hash::make('Eneam123'),
        ]);

        // Create Manager user
        User::create([
            'name' => 'Manager',
            'email' => 'arnaudkpodji@gmail.com',
            'password' => Hash::make('Aristide229'),
        ]);

        $this->call([
            RegionSeeder::class,
            TypeContenuSeeder::class,
            ContenuSeeder::class,
            CommentaireSeeder::class,
            MediaSeeder::class,
            LangueSeeder::class,
            ParlerSeeder::class,
            CacheSeeder::class,
            CacheLockSeeder::class,
            JobSeeder::class,
            JobBatchSeeder::class,
            TypeMediaSeeder::class,
        ]);
    }
}
