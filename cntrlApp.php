<?php
// DAO
require_once "dao/DaoCluster.php";
require_once "dao/DaoShip.php";
require_once "dao/DaoVesselType.php";
require_once "dao/DaoPosition.php";

// OBJECTS
require_once "objets/Cluster.php";
require_once "objets/Position.php";
require_once "objets/Ship.php";
require_once "objets/VesselType.php";

class CntrlApp {
    public function insertBoat() {
        $result = [];
        $result['message']  = 'Your ship has been registered';
        $result['type']     = 'success';

        // Ship
        $mmsi       = $_POST['mmsi'];
        $vesselname = $_POST['vesselname'];
        $imo        = 'xxxxxxx';
        $length     = (float) $_POST['length'];
        $width      = (float) $_POST['width'];
        $draft      = (float) $_POST['draft'];

        // Position
        $lat        = $_POST['lat'];
        $lon        = $_POST['lon'];
        $timestamp  = strtotime($_POST['timestamp']);
        $sog        = $_POST['sog'];
        $cog        = $_POST['cog'];
        $heading    = $_POST['heading'];
        $status     = $_POST['status'];

        $utils = new Utils();

        $daoShip = new DaoShip(DBHOST, DBNAME, PORT, USER, PASS);
        $daoType = new DaoVesselType(DBHOST, DBNAME, PORT, USER, PASS);
        $daoCluster = new DaoCluster(DBHOST, DBNAME, PORT, USER, PASS);
        $daoPosition = new DaoPosition(DBHOST, DBNAME, PORT, USER, PASS);

        $ship = new Ship($mmsi, $vesselname, $imo, $length, $width, $draft, null, null);
        $pos = new Position(null, $lat, $lon, $timestamp, $sog, $cog, $heading, $status, $ship);

        // AI script to estimate ship type and cluster.
        $utils->predict('typeNavire', $pos->toArrayFlat(), '0');
        $json = json_decode(file_get_contents('assets/json/' . $mmsi . '.json'));
        $type = $daoType->getType((int) $json->{'result'}[0]);

        $utils->predict('Cluster', $pos->toArrayFlat(), '0');
        $json = json_decode(file_get_contents('assets/json/' . $mmsi . '.json'));
        $cluster = $daoCluster->getCluster((int) $json->{'result'}[0]);

        if ($type == null || $cluster == null) {
            $result['type'] = 'error';
            $result['message'] = 'Error getting the boat type or cluster!';
        }
        else {
            $ship->set_type($type);
            $ship->set_cluster($cluster);

            print_r($type);
    
            $daoShip->addShip($ship);
        }

        // ['message': <message à afficher> registered, 'type': 'success/error/warning']

        print_r(json_encode($result));
    }

    public function getMapPage() {
        $daoPosition = new DaoPosition(DBHOST, DBNAME, PORT, USER, PASS);
        $daoShip = new DaoShip(DBHOST, DBNAME, PORT, USER, PASS);

        $ships = $daoShip->getShips();
        $positions = [];

        foreach ($ships as $s) {
            $positions[$s->get_mmsi()] = $daoPosition->getPositionsOfBoat($s);
        }

        require_once "pages/maps.php";
    }

    public function predictTrajectory() {
        $result = [];
        // TODO: response.position et response.time à return après predict.
        $id = $_GET['id'];
        $delta_sec = $_GET['timestamp'];
        $mmsi = $_GET['mmsi'];

        $daoPosition = new DaoPosition(DBHOST, DBNAME, PORT, USER, PASS);
        $pos = $daoPosition->getPositionById($id);
        // Conversion minutes to seconds:
        $delta_sec = $delta_sec * 60;

        $utils = new Utils();

        $arr = $pos->toArrayFlat();
        $arr['delta_sec'] = $delta_sec;
        $arr['VesselType'] = $arr['type'];

        $utils->predict('trajNavire', $arr);
        $json = json_decode(file_get_contents('assets/json/' . $mmsi . '.json'));
        // while ($json->{'scriptStatus'} == 1) {
        //     $json = json_decode(file_get_contents('assets/json/' . $mmsi . '.json'));
        // }
        $result['LON'] = (int) $json->{'result'}[0];
        $result['LAT'] = (int) $json->{'result'}[1];
        $result['time'] = $delta_sec/60;

        print_r(json_encode($result));
    }

    public function editVesselType() {
        parse_str(file_get_contents("php://input"), $_PUT);

        $mmsi = $_PUT['mmsi'];
        $typeId = $_PUT['type'];

        $daoShip = new DaoShip(DBHOST, DBNAME, PORT, USER, PASS);
        $daoType = new DaoVesselType(DBHOST, DBNAME, PORT, USER, PASS);

        $type = $daoType->getType($typeId);
        $ship = $daoShip->getShipByMMSI($mmsi);

        $ship->set_type($type);

        $result = [];

        if ($typeId == 60) $result['color'] = "text-red-600";
        if ($typeId == 70) $result['color'] = "text-lime-600";
        if ($typeId == 80) $result['color'] = "text-sky-600";

        $daoShip->setType($ship);

        $result['descr'] = $type->get_description();
        $result['type'] = $type->get_type();

        print_r(json_encode($result));
    }
}