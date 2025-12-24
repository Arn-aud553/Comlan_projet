<?php
/**
 * EMERGENCY Diagnostic script (No dependencies)
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Laravel Diagnostic Script v6 (Emergency)</h1>";
echo "<p>Si vous voyez cette page, le serveur web (Apache) fonctionne !</p>";

echo "<h2>1. Variables d'environnement de base</h2>";
echo "PORT: " . getenv('PORT') . "<br>";
echo "DATABASE_URL: " . (getenv('DATABASE_URL') ? "✅ Present" : "❌ Absent") . "<br>";
echo "APP_KEY: " . (getenv('APP_KEY') ? "✅ Present" : "❌ Absent") . "<br>";

echo "<h2>2. Hostname interne</h2>";
echo "Hostname : <strong>" . gethostname() . "</strong><br>";

echo "<h2>3. Logs de démarrage</h2>";
if (file_exists('/tmp/deploy.log')) {
    echo "<pre>" . file_get_contents('/tmp/deploy.log') . "</pre>";
} else {
    echo "❌ Aucun log trouvé dans /tmp/deploy.log.<br>";
}

echo "<h2>4. Super-globales</h2>";
echo "<pre>";
print_r(array_filter($_SERVER, function($k) { 
    return preg_match('/RAILWAY|SERVICE|PROJECT|PORT|HTTP_HOST/', $k); 
}, ARRAY_FILTER_USE_KEY));
echo "</pre>";

echo "<hr><p>Fin du diagnostic d'urgence.</p>";
