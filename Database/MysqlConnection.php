<?php 

class MysqlConnection extends Database {

    protected $con;

    public function __construct($data) {
        // echo 'db connection';
        $mysqli = new mysqli("localhost:{$data['port']}","{$data['username']}","{$data['password']}","{$data['database']}");

        if ($mysqli -> connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
            exit();
        }

        $this->con = $mysqli;
    }

    public function create($data){}
    public function update($data){}
    public function get($table){
        $sql = "SELECT * from {$table}";
        $result = $this->con->query($sql);
        $returnValue = [];
        if ($result != null) {
            while ($returnValue[] = $result->fetch_array(MYSQLI_ASSOC));
        }
        return $returnValue;
    }
    public function find($table, $id){
        $sql = "SELECT * from {$table} where id = {$id}";
        // return $this->con->execute($sql);
        return json_encode([
            (object)["name" => "tinhdoan"]
        ]);;
    }
    public function delete($id){}
}