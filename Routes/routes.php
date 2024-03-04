<?php 


require './Controllers/UsersController.php';

$userController = new UsersController();

if (str_contains($uri, '/api/')) {
    header('Content-Type: application/json');
    require 'api.php';
} else {
    require 'web.php';
    
}

