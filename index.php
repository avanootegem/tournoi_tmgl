<?php

require 'vendor/autoload.php';
require_once 'functions.php';

use Config\Config;
use App\Controllers\PageController;

session_start();
if(!isset($_SESSION['flash'])) {
    init_session();
}

$router = new AltoRouter();

//Les routes (tut tut)

$router->map('GET', '/', function(){
    $controller = new PageController();
    $controller->home();
});

$match = $router->match();

// call closure or throw 404 status
if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // no route was matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}