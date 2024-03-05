<?php 

abstract class Database {
    public function create($data){}
    public function update($data){}
    public function get($table){}
    public function find($table, $id){}
    public function delete($id){}
}