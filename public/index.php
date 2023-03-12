<?php

require_once __DIR__ . '/../vendor/autoload.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = $path == '/' ? 'App' : trim($path, '/');
$path_ar = explode('/', $path);

if ($path_ar[0] == 'admin') {
    $controller_name = count($path_ar) == 1 ? 'Index' : trim($path_ar[1], '/');
    $controller_path = 'Src\\Controllers\\Admin\\' . ucfirst($controller_name) . 'Controller';
    $path_ar = array_slice($path_ar, 1);
}
else {
    $controller_path = 'Src\\Controllers\\' . ucfirst($path_ar[0]) . 'Controller';
}

$action = 'index';
if (count($path_ar) > 1) {
    $action = trim($path_ar[1], '/');
}

$app = new $controller_path;
$app->$action();