<?php 


require './Controllers/UsersController.php';
require 'Router.php';

$userController = new UsersController();

$router = new Router();
$router->add('GET', '/', [UsersController::class, 'logout']); 
$router->add('GET', '/logout', [UsersController::class, 'logout']); 

$router->dispatch($uri); 

// if (str_contains($uri, '/api/')) {
//     header('Content-Type: application/json');
//     require 'api.php';
// } else {
//     require 'web.php';
    
// }

