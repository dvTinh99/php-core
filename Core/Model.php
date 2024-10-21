<?php 

abstract class Model {

    protected static $db;
    protected $table;
    public function __construct() {
        // load db connect
        global $configs;
        $host = $configs['database']['host'];
        $connect = $configs['database']['connection'];
        $port = $configs['database']['port'];
        $username = $configs['database']['username'];
        $password = $configs['database']['password'];
        $database = $configs['database']['database'];

        try {
            $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
          }
          

        self::$db = $conn;
    }

    public static function get() {
        
    }

    
    public function find($id) {
        
        if (!isset(self::$db)) {
            throw new Exception('Database connection not set.');
        }

        $table = $this->table;
        $sql = "SELECT * FROM $table where user_ID = :id";

        
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function where($column, $value) {
        
        if (!isset(self::$db)) {
            throw new Exception('Database connection not set.');
        }

        $table = $this->table;
        $sql = "SELECT * FROM $table where $column = :val";

        
        $stmt = self::$db->prepare($sql);
        $stmt->bindParam(':val', $value);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function create($data){}
    public function update($data){}
    public function delete($id){}
}