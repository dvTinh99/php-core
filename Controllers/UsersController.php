<?php 

class UsersController {
    
    public static function getAll() {
        echo 'get all in controller';
    }

    public static function detail($id) {
        echo "get detail id {$id} in controller";
    }
}