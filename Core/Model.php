<?php 

abstract class Model {

    const CHUNKS_SIZE = 500;
    protected static $db;
    protected $fillable = [];
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
            self::$db = $conn;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
          

    }

    public function get() {
        return 'model class';
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
    
    public function insert($datas){
        
        $datas = array_chunk($datas, self::CHUNKS_SIZE);
        $table = $this->table;
        $fillable = join(',', $this->fillable);
        $placeHolder = '(' . implode(',', array_fill(0, count($this->fillable), '?')) . ')';
        try {
            self::$db->beginTransaction();
            foreach ($datas as $row)
            {
                $multiplePlaceHolder = implode(', ', array_fill(0, count($row), $placeHolder));
                $sql = "INSERT INTO $table ($fillable) VALUES $multiplePlaceHolder";
        
                $stmt = self::$db->prepare($sql);

                $data = [];
                foreach ($row as $rowData) {
                    foreach ($rowData as $rowField) {
                        $data[] = $rowField;
                    }
                }

                $stmt->execute($data);
            }
            self::$db->commit();
        }catch (Exception $e){
            self::$db->rollback();
            throw $e;
        }
        
    }


    public function update($data){}
    public function delete($id){}

}