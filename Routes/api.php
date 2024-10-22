<?php 


require './Controllers/UsersController.php';
require './Controllers/FileController.php';
require 'Router.php';
require_once './Middlewares/AuthMiddleware.php';

$router = new Router();
$router->add('GET', '/', [UsersController::class, 'logout'])->middleware([AuthMiddleware::class]); 
$router->add('GET', '/logout', [UsersController::class, 'logout']); 
$router->add('POST', '/api/import', [FileController::class, 'import']); 

$router->dispatch($uri);