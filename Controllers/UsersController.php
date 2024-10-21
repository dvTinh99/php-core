<?php 

class UsersController extends Controller{

    protected $User;

    public function __construct() {
        
        $this->loadModel('User');
    }
    
    public function getAll() {
        echo $this->returnSuccess($this->User->getAll());
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

    public function logout() {
        $data = $this->User::find(1);
        echo $this->returnSuccess($data);
    }
}