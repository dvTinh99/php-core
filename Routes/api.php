<?php 


switch ($method | $uri) {
    
    /*
    * Path: GET /api/users
    * Task: show all the users
    */
    case ($method == 'GET' && $uri == '/api/users'):
        $userController->getAll();
        break;
    /*
    * Path: GET /api/users/{id}
    * Task: get one user
    */
    case ($method == 'GET' && preg_match('/\/api\/users\/[1-9]/', $uri)):
        $id = basename($uri);
        UsersController::detail($id);
        break;
    /*
    * Path: POST /api/users
    * Task: store one user
    */
    case ($method == 'POST' && $uri == '/api/users'):
        // echo 'create';
        break;
    /*
    * Path: PUT /api/users/{id}
    * Task: update one user
    */
    case ($method == 'PUT' && preg_match('/\/api\/users\/[1-9]/', $uri)):
        echo 'update';
        break;
    /*
    * Path: DELETE /api/users/{id}
    * Task: delete one user
    */
    case ($method == 'DELETE' && preg_match('/\/api\/users\/[1-9]/', $uri)):
        echo 'delete';
        break;
    /*
    * Path: ?
    * Task: this path doesn't match any of the defined paths
    *      throw an error
    */
    default:
        echo 'api not found';
        break;
 }