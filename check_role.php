<?php

use App\Models\User;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

$user = User::find(1);

if ($user) {
    echo "User found: " . $user->name . "\n";
    echo "Email: " . $user->email . "\n";
    echo "Role in DB: '" . $user->role . "'\n";
    echo "Is Admin (estAdminResult): " . ($user->estAdmin() ? 'TRUE' : 'FALSE') . "\n";
} else {
    echo "User 1 not found.\n";
}
