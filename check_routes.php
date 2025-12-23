<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$routes = Route::getRoutes();

$duplicates = [];
$brokenRoutes = [];
$routeNames = [];

foreach ($routes as $route) {
    // Check for duplicate names
    $name = $route->getName();
    if ($name) {
        if (isset($routeNames[$name])) {
            $duplicates[] = $name;
        }
        $routeNames[$name] = true;
    }

    // Check for missing controllers/methods
    $action = $route->getAction();
    if (isset($action['controller'])) {
        if (strpos($action['controller'], '@') !== false) {
            list($controller, $method) = explode('@', $action['controller']);
            if (!class_exists($controller)) {
                $brokenRoutes[] = "Missing Controller: $controller";
            } else {
                if (!method_exists($controller, $method)) {
                    $brokenRoutes[] = "Missing Method: $controller@$method for route " . $route->uri();
                }
            }
        }
    }
}

// Output results
$output = "Duplicate Route Names:\n" . print_r($duplicates, true) . "\n\n";
$output .= "Broken Routes (Missing Controller/Method):\n" . print_r($brokenRoutes, true) . "\n";

file_put_contents('broken_report.txt', $output);
echo "Report written to broken_report.txt\n";
