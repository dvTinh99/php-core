<?php 

class Request {
    public function post($name) {
        return $_POST[$name];
    }

    public function get($name) {
        return $_GET[$name];
    }
}