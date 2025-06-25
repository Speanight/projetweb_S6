<?php
// DAO
require_once "dao/DaoCluster.php";
require_once "dao/DaoShip.php";
require_once "dao/DaoVesselType.php";

// OBJECTS
require_once "objets/Cluster.php";
require_once "objets/Position.php";
require_once "objets/Ship.php";
require_once "objets/VesselType.php";

class CntrlApp {
    public function insertBoat() {
        // Ship
        $mmsi       = $_POST['mmsi'];
        $vesselname = $_POST['vesselname'];
        $imo        = $_POST['imo'];
        $length     = $_POST['length'];
        $width      = $_POST['width'];
        $draft      = $_POST['draft'];

        // Position
        $lat        = $_POST['lat'];
        $lon        = $_POST['lon'];
        $timestamp  = $_POST['timestamp'];
        $sog        = $_POST['sog'];
        $cog        = $_POST['cog'];
        $heading    = $_POST['heading'];
        $status     = $_POST['status'];
        
    }
}