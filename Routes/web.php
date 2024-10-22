<?php 
require './Controllers/UsersController.php';
require 'Router.php';

$userController = new UsersController();

switch ($method | $uri) {
    case ($method == 'GET' && $uri == '/users/register'):
        $userController->register();
        break;
    case ($method == 'GET' && $uri == '/users/login'):
        $userController->login();
        break;
    default:
        echo 'web not found';
        break;

}