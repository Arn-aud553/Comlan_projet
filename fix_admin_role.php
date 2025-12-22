<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

$user = User::where('email', 'maurice.comlan@uac.bj')->first();

if ($user) {
    echo "Updating role for: " . $user->name . "\n";
    
    // Force update using DB to bypass any model events or mutators if necessary, 
    // but Model update is safer for timestamps.
    // Let's use direct DB update to be surgical.
    
    DB::table('users')
        ->where('id', $user->id)
        ->update(['role' => 'admin']);
        
    echo "Role updated to 'admin'.\n";
    
    $updatedUser = User::find($user->id);
    echo "New Role in DB: '" . $updatedUser->role . "'\n";
    echo "Is Admin now? " . ($updatedUser->estAdmin() ? 'YES' : 'NO') . "\n";
    
} else {
    echo "User not found.\n";
}
