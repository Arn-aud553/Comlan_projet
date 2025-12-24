<?php
/**
 * Diagnostic script for Laravel on Railway
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Laravel Diagnostic Script</h1>";

echo "<h2>0. URL & Domain Verification</h2>";
echo "Current URL being visited: <strong>" . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]</strong><br>";
echo "Server Hostname: <strong>" . gethostname() . "</strong><br>";

echo "<h2>1. Environment Variables Check</h2>";
$required_vars = ['APP_KEY', 'DB_CONNECTION', 'DB_HOST', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD', 'DATABASE_URL', 'PGHOST', 'APP_URL'];
echo "<ul>";
foreach ($required_vars as $var) {
    if (isset($_SERVER[$var])) {
        $val = $_SERVER[$var];
    } elseif (isset($_ENV[$var])) {
        $val = $_ENV[$var];
    } else {
        $val = getenv($var);
    }
    
    $status = $val ? "✅ getenv() OK" : "❌ getenv() MISSING";
    if (preg_match("/(PASS|KEY|SECRET|TOKEN|AUTH)/i", $var)) $mask = "********"; else $mask = $val;
    echo "<li><strong>$var</strong>: $status ($mask)</li>";
}
echo "</ul>";

echo "<h3>FULL \$_SERVER Dump:</h3>";
echo "<ul>";
foreach ($_SERVER as $key => $value) {
    if (is_array($value)) $value = "Array(" . count($value) . ")";
    if (preg_match("/(PASS|KEY|SECRET|TOKEN|AUTH)/i", $key)) $value = "********";
    echo "<li><strong>$key</strong>: $value</li>";
}
echo "</ul>";

echo "<h3>.env File Check:</h3>";
if (file_exists('../.env')) {
    echo "✅ .env file exists.<br>";
    echo "<pre>" . shell_exec('cat ../.env | sed -E "s/=(.*)/=********/"') . "</pre>";
} else {
    echo "❌ .env file does NOT exist.<br>";
}

echo "<h2>2. PHP Extensions Check</h2>";
$extensions = ['pdo_pgsql', 'pdo_sqlite', 'mbstring', 'openssl', 'gd'];
foreach ($extensions as $ext) {
    echo "Extension <strong>$ext</strong>: " . (extension_loaded($ext) ? "✅ OK" : "❌ MISSING") . "<br>";
}

echo "<h2>3. Database Discovery</h2>";
try {
    if (file_exists(__DIR__.'/../vendor/autoload.php')) {
        require_once __DIR__.'/../vendor/autoload.php';
        if (file_exists(__DIR__.'/../bootstrap/app.php')) {
            $app = require_once __DIR__.'/../bootstrap/app.php';
            echo "✅ Application bootstrapped.<br>";
            if (function_exists('config')) {
                echo "Default connection: " . config('database.default') . "<br>";
            }
        }
    }
} catch (Exception $e) {
    echo "❌ DB Discovery failed: " . $e->getMessage() . "<br>";
}

echo "<h2>4. Directory Permissions Check</h2>";
$dirs = ['../storage' => 0775, '../storage/logs' => 0775, '../bootstrap/cache' => 0775];
foreach ($dirs as $path => $perm) {
    $fullPath = realpath($path);
    echo "Directory <strong>$path</strong>: " . ($fullPath && is_writable($fullPath) ? "✅ Writable" : "❌ NOT WRITABLE") . "<br>";
}

echo "<hr><p>End of diagnostics.</p>";
