<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//auth
//$routes->get('/', 'Home::index');
$routes->get('/auth/login', 'Auth::login');
