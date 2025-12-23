<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$config = config('database.connections.pgsql');
// Sanitize password for display
if (isset($config['password'])) $config['password'] = '********';

print_r($config);

echo "DB_DATABASE env: " . getenv('DB_DATABASE') . "\n";
echo "DB_DATABASE config: " . config('database.connections.pgsql.database') . "\n";
