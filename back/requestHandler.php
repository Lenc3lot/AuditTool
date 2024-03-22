<?php
/*****
/* This file is basically the router to all controllers in here !
/* The most simple php router in the world (...of mon quartier à Marseille bb)
 *****/
error_reporting(E_ALL);
ini_set('display_errors', '1');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: text/html; charset=utf-8');
ini_set('default_charset', 'UTF-8');
date_default_timezone_set('Europe/Paris');
include('./functions.php');
$liaison = CallDatabase();
$included = false;
$routes = [
    'recherche' => './controller/rechercheController.php',
    'serviceInfo' => './controller/serviceInfoController.php',
    'service' => './controller/serviceController.php',
    'client' => './controller/clientController.php',
    'login' => './controller/consultantsnsController.php'
];

// if (isset($_POST['pwd'])) $pwd = $_POST['pwd']; else $pwd = '';
if (isset($_POST['id'])) $id = $_POST['id']; else $id = 0;
if (isset($_POST['ap'])) $ap = $_POST['ap']; else $ap = ''; // adminPass or adminToken
$myServerAddress = 'localhost';
$joker = true;
if (isset($_POST['req']))
{
    $route = $routes[$_POST['req']];
    // if($req=='login' || $req=='contact') $joker = true;
} 
else $req=0;

if($joker) {
    $included = true;
    include($route);
}
else echo "<h1>No credentials sent !</h1>";