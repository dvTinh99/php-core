<?php 

class Controller {
    public static function returnSuccess($data){
        return json_encode([
            'data' => $data,
            'code' => 200
        ], JSON_PRETTY_PRINT);
    }
    public static function returnError($message){
        return json_encode([
            'message' => $message,
            'code' => 500
        ], JSON_PRETTY_PRINT);
    }

    public function loadView($viewName, $data = []) {
        if (count($data) > 0) extract($data);
        require './Views/' . $viewName . '.php';
    }

    public function loadModel($modelName) {
        $modelName = ucfirst($modelName);
        require './Models/' . $modelName . '.php';
        $this->{$modelName} = new $modelName();
    }
}