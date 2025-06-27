<?php
ini_set('display_errors', 1);

require_once "cntrlApp.php";
require_once "Utils.php";

$method = $_SERVER["REQUEST_METHOD"];
$uri    = explode("?", $_SERVER["REQUEST_URI"])[0];

$cntrlApp = new CntrlApp();

switch ($method) {
    case "GET":
        //Pages require
        if ($uri == "/accueil") require_once("pages/accueil.php");
        elseif($uri == "/boat") require_once("pages/boat.php");
        elseif($uri == "/about") require_once("pages/about.php");

        //AJAX request handle
        elseif($uri == "/updatestatships") $cntrlApp->updateStatShips();
        elseif($uri == "/obtainpositions") $cntrlApp->obtainPositions();
        elseif($uri == '/predicttrajectory') $cntrlApp->predictTrajectory();
        elseif($uri == "/maps") $cntrlApp->getMapPage();
        elseif($uri == '/get/nboats') $cntrlApp->getNThBoat();

        elseif ($uri == "/info") phpinfo();
        // else require_once("pages/accueil.php");
        break;
    
    case "POST":
        if ($uri == "/insertboat") $cntrlApp->insertBoat();
        break;
        
        case "PUT":
            if ($uri == "/edit/vesseltype") $cntrlApp->editVesselType();
        break;
    
    case "DELETE":
        break;
}
