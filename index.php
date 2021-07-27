<?php
include_once 'router.php';

//Cors config
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$request = $_SERVER['REQUEST_URI'];

$router = new Router();

$router->routes($request);
