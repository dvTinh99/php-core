<?php 
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$cores = scandir('./Core', SCANDIR_SORT_ASCENDING);

foreach ($cores as $value) {
    if (is_file('./Core/' . $value)) {
        require './Core/' . $value;
    };
}

$configsAutoload = scandir('./Configs', SCANDIR_SORT_ASCENDING);

foreach ($configsAutoload as $value) {
    if (is_file('./Configs/' . $value)) {
        require './Configs/' . $value;
    };
}

//load db connect
$databaseConnect = ucfirst($configs['database']['connection']).'Connection';
require './Database/' . $databaseConnect .'.php';
$GLOBALS["database"] = new $databaseConnect($configs['database']);
require 'Routes/routes.php';
?>