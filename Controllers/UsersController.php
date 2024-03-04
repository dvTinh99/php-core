<?php 

class UsersController extends Controller{
    
    public static function getAll() {
        echo self::returnSuccess('get all in controller');
    }

    public static function detail($id) {
        echo self::returnSuccess("get detail id {$id} in controller");
    }

    public function register() {
        $data = [
            "name" => "tinh doan"
        ];
        return $this->loadView('user_register', $data);
    }

    public function login() {
        $data = [
            "name" => "tinh doan"
        ];
        return $this->loadView('user_login', $data);
    }
}