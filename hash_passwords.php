?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Update Admin password
$user = User::where('email', 'maurice.comlan@uac.bj')->first();
if ($user) {
    $user->password = Hash::make('Eneam123');
    $user->save();
    echo "Admin password updated successfully.\n";
} else {
    echo "Admin user not found.\n";
}

// Update Manager password
$user = User::where('email', 'arnaudkpodji@gmail.com')->first();
if ($user) {
    $user->password = Hash::make('Eneam123');
    $user->save();
    echo "Manager password updated successfully.\n";
} else {
    echo "Manager user not found.\n";
}
