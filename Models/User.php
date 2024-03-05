<?php 

class User extends Model {
    
    public $name = 'tinhdoan';
    public function getAll() {
        return $GLOBALS["database"]->get('users');
            }
    public function find($id) {
        return $GLOBALS["database"]->find('users', $id);
    }
}