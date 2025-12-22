<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::orderBy('updated_at', 'desc')->first();
if ($user) {
    echo "User found: " . $user->name . " (ID: " . $user->id . ")\n";
    echo "Sexe: " . ($user->sexe ?? 'NULL') . "\n";
    echo "Age: " . ($user->age ?? 'NULL') . "\n";
    echo "Langue: " . ($user->langue ?? 'NULL') . "\n";
    echo "Photo Path: " . ($user->profile_photo_path ?? 'NULL') . "\n";
    
    // Check file existence
    if ($user->profile_photo_path) {
        $path = storage_path('app/public/' . $user->profile_photo_path);
        echo "File exists at storage/app/public? " . (file_exists($path) ? 'YES' : 'NO') . "\n";
        echo "Path: " . $path . "\n";
    }
} else {
    echo "No user found.\n";
}
