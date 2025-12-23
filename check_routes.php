<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$routes = collect(Illuminate\Support\Facades\Route::getRoutes())->map(function($r) {
    return $r->getName();
})->filter()->countBy()->filter(function($c) {
    return $c > 1;
});

echo "Duplicate Route Names:\n";
print_r($routes->toArray());

$brokenRoutes = [];
foreach (Illuminate\Support\Facades\Route::getRoutes() as $route) {
    $action = $route->getAction();
    if (isset($action['controller']) && is_string($action['controller']) && str_contains($action['controller'], '@')) {
        $parts = explode('@', $action['controller']);
        $class = $parts[0];
        $method = $parts[1] ?? null;
        if (!class_exists($class)) {
            $brokenRoutes[] = "Missing Class: $class for route " . $route->uri();
        } elseif ($method && !method_exists($class, $method)) {
            $brokenRoutes[] = "Missing Method: $class@$method for route " . $route->uri();
        }
    }
}

echo "\nBroken Routes (Missing Controller/Method):\n";
print_r($brokenRoutes);
