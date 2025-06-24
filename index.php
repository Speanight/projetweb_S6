<?php
$method = $_SERVER["REQUEST_METHOD"];
$uri    = explode("?", $_SERVER["REQUEST_URI"])[0];

switch ($method) {
    case "GET":
        if ($uri == "/accueil") require_once("pages/accueil.php");
        if($uri == "/boat") require_once("pages/boat.php");

        else require_once("pages/accueil.php");
        break;
    
    case "POST":
        break;
    
    case "PUT":
        break;
    
    case "DELETE":
        break;
}
