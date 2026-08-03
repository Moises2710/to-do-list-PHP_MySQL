<?php

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Require Composer Autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Fetch routing dispatcher
$dispatcher = require_once __DIR__ . '/../routes/web.php';

// Fetch HTTP Method and URI
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

// Dispatch route
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo "<h1>404 - Page Not Found</h1><p><a href='/'>Return to Home</a></p>";
        break;
        
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        http_response_code(405);
        echo "<h1>405 - Method Not Allowed</h1>";
        break;
        
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        
        $class = new $handler[0]();
        $method = $handler[1];
        
        call_user_func_array([$class, $method], $vars);
        break;
}
