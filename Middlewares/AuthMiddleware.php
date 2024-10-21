<?php 

class AuthMiddleware {
    
    public static function run() {
        return true;
    }

    public function fallback() {
        echo json_encode([
            "message" => "not pass auth",
            "code" => 401
        ]);
    } 
}