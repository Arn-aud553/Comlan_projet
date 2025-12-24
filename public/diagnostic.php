<?php
/**
 * Diagnostic script for Laravel on Railway
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Laravel Diagnostic Script</h1>";

echo "<h2>1. Environment Variables Check</h2>";
$required_vars = ['APP_KEY', 'DB_CONNECTION', 'DB_HOST', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'];
echo "<ul>";
foreach ($required_vars as $var) {
    $val = getenv($var);
    $server_val = isset($_SERVER[$var]) ? "✅ In \$_SERVER" : "❌ No \$_SERVER";
    $env_val = isset($_ENV[$var]) ? "✅ In \$_ENV" : "❌ No \$_ENV";
    
    $status = $val ? "✅ getenv() OK" : "❌ getenv() MISSING";
    if ($var === 'APP_KEY' && $val) {
        $status .= " (Length: " . strlen($val) . ")";
    }
    echo "<li><strong>$var</strong>: $status | $server_val | $env_val</li>";
}
echo "</ul>";

echo "<h3>Raw Environment (shell_exec):</h3>";
echo "<pre>" . shell_exec('env | grep -E "^(APP_|DB_|PORT)"') . "</pre>";

echo "<h3>PHP getenv() Check:</h3>";
echo "<pre>";
print_r(array_filter(getenv(), function($k) { 
    return preg_match("/^(APP_|DB_|PORT)/", $k); 
}, ARRAY_FILTER_USE_KEY));
echo "</pre>";

echo "<h3>.env File Check:</h3>";
if (file_exists('../.env')) {
    echo "✅ .env file exists.<br>";
    echo "<pre>" . shell_exec('grep -E "^(APP_|DB_|PORT)" ../.env | sed "s/=.*/=********/"') . "</pre>";
} else {
    echo "❌ .env file does NOT exist.<br>";
}

echo "<h2>2. PHP Extensions Check</h2>";
$extensions = ['pdo_pgsql', 'mbstring', 'openssl', 'gd'];
foreach ($extensions as $ext) {
    echo "Extension <strong>$ext</strong>: " . (extension_loaded($ext) ? "✅ OK" : "❌ MISSING") . "<br>";
}

echo "<h2>3. Database Connectivity Check</h2>";
$driver = getenv('DB_CONNECTION');
$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: '5432';
$db = getenv('DB_DATABASE');
$user = getenv('DB_USERNAME');
$pass = getenv('DB_PASSWORD');

if ($driver === 'pgsql') {
    try {
        $dsn = "pgsql:host=$host;port=$port;dbname=$db";
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        echo "✅ Connection to PostgreSQL successful!<br>";
        
        $result = $pdo->query("SELECT current_user, current_database()");
        $row = $result->fetch();
        echo "Connected as: " . $row['current_user'] . " to database: " . $row['current_database'] . "<br>";
    } catch (Exception $e) {
        echo "❌ Connection failed: " . $e->getMessage() . "<br>";
    }
} else {
    echo "ℹ️ DB_CONNECTION is not 'pgsql' (current: $driver). Not testing PostgreSQL connection.<br>";
}

echo "<h2>4. Directory Permissions Check</h2>";
$dirs = [
    '../storage' => 0775,
    '../storage/logs' => 0775,
    '../storage/framework' => 0775,
    '../bootstrap/cache' => 0775,
];

foreach ($dirs as $path => $perm) {
    $fullPath = realpath($path);
    if ($fullPath) {
        $writable = is_writable($fullPath);
        echo "Directory <strong>$path</strong>: " . ($writable ? "✅ Writable" : "❌ NOT WRITABLE") . " (Perms: " . substr(sprintf('%o', fileperms($fullPath)), -4) . ")<br>";
    } else {
        echo "Directory <strong>$path</strong>: ❌ DOES NOT EXIST<br>";
    }
}

echo "<h2>5. Laravel Bootstrap Check</h2>";
try {
    require __DIR__.'/../vendor/autoload.php';
    echo "✅ Autoloader loaded.<br>";
    
    $app = require_once __DIR__.'/../bootstrap/app.php';
    echo "✅ Application bootstrapped.<br>";
    
    echo "Application Environment: " . $app->environment() . "<br>";
    echo "Debug Mode: " . (config('app.debug') ? "True" : "False") . "<br>";
    
} catch (Exception $e) {
    echo "❌ Bootstrap failed: " . $e->getMessage() . "<br>";
}

echo "<hr><p>End of diagnostics.</p>";
