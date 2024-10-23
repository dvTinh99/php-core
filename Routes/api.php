<?php 


require './Controllers/UsersController.php';
require './Controllers/FileController.php';
require 'Router.php';
require_once './Middlewares/AuthMiddleware.php';

$router = new Router();
$router->get('/', [UsersController::class, 'logout'])->middleware([AuthMiddleware::class]); 
$router->get('/logout', [UsersController::class, 'logout']); 
$router->post('/api/import', [FileController::class, 'import']); 

$router->dispatch($uri);