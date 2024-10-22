<?php 

if (str_contains($uri, '/api/')) {
    header('Content-Type: application/json');
    require 'api.php';
} else {
    require 'web.php';
    
}

