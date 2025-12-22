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
        User::factory(10)->create();

        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create Admin user
        User::updateOrCreate(
            ['email' => 'maurice.comlan@uac.bj'],
            [
                'name' => 'M. Maurice COMLAN',
                'password' => 'Eneam123',
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create Manager user
        User::updateOrCreate(
            ['email' => 'arnaudkpodji@gmail.com'],
            [
                'name' => 'Arnaud KPODJI',
                'password' => 'Eneam123',
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            RegionSeeder::class,
            LangueSeeder::class,
            TypeContenuSeeder::class,
            ContenuSeeder::class,
            CommentaireSeeder::class,
            MediaSeeder::class,
            // ParlerSeeder::class,
            // CacheSeeder::class,
            // CacheLockSeeder::class,
            // JobSeeder::class,
            // JobBatchSeeder::class,
            TypeMediaSeeder::class,
        ]);
    }
}
