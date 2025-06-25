<?php
ini_set('display_errors', 1);

require_once "cntrlApp.php";
require_once "Utils.php";


///////////// TESTING ZONE ///////////////

require_once "dao/DaoShip.php";

$daoShip = new DaoShip(DBHOST, DBNAME, PORT, USER, PASS);
$utils = new Utils();

// $utils->predict('typeNavire', $ship->toArray());
/////////////////////////////////////////


$method = $_SERVER["REQUEST_METHOD"];
$uri    = explode("?", $_SERVER["REQUEST_URI"])[0];

$cntrlApp = new CntrlApp();

switch ($method) {
    case "GET":
        if ($uri == "/accueil") require_once("pages/accueil.php");
        elseif ($uri == "/info") phpinfo();
        // else require_once("pages/accueil.php");
        break;
    
    case "POST":
        if ($uri == "/insertboat") $cntrlApp->insertBoat();
        break;
    
    case "PUT":
        break;
    
    case "DELETE":
        break;
}
