<?php
ini_set('display_errors', 1);

require_once "cntrlApp.php";
require_once "Utils.php";


///////////// TESTING ZONE ///////////////


/////////////////////////////////////////


$method = $_SERVER["REQUEST_METHOD"];
$uri    = explode("?", $_SERVER["REQUEST_URI"])[0];

$cntrlApp = new CntrlApp();

switch ($method) {
    case "GET":
        //Pages require
        if ($uri == "/accueil") require_once("pages/accueil.php");
        else if($uri == "/boat") require_once("pages/boat.php");
        else if($uri == "/maps") require_once("pages/maps.php");
        else if($uri == "/about") require_once("pages/about.php");

        //AJAX request handle
        else if($uri == "/updatestatships") $cntrlApp->updateStatShips();
        else if($uri == "/obtainpositions") $cntrlApp->obtainPositions();


        elseif ($uri == "/info") phpinfo();
        else require_once("pages/accueil.php");
        break;
    
    case "POST":
        if ($uri == "/insertboat") $cntrlApp->insertBoat();
        break;
    
    case "PUT":
        break;
    
    case "DELETE":
        break;
}
