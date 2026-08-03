<?php

use FastRoute\RouteCollector;

return FastRoute\simpleDispatcher(function (RouteCollector $r) {
    // Home / Landing page route
    $r->addRoute('GET', '/', ['App\Controllers\HomeController', 'index']);
    
    // Auth routes
    $r->addRoute('GET', '/signup', ['App\Controllers\AuthController', 'signUp']);
    $r->addRoute('POST', '/signup', ['App\Controllers\AuthController', 'register']);
    $r->addRoute('GET', '/signin', ['App\Controllers\AuthController', 'signIn']);
    $r->addRoute('POST', '/signin', ['App\Controllers\AuthController', 'login']);
    $r->addRoute('GET', '/logout', ['App\Controllers\AuthController', 'logout']);

    // Dashboard route
    $r->addRoute('GET', '/dashboard', ['App\Controllers\DashboardController', 'index']);
});
