<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$class = 'App\Http\Controllers\ClientDashboardController';
echo "Class exists? " . (class_exists($class) ? 'YES' : 'NO') . "\n";
if (class_exists($class)) {
    echo "contenusIndex exists? " . (method_exists($class, 'contenusIndex') ? 'YES' : 'NO') . "\n";
    $c = new $class();
    echo "Instance check: " . (method_exists($c, 'contenusIndex') ? 'YES' : 'NO') . "\n";
}
