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
        $timestamp  = new DateTime($_POST['timestamp']);
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

        $cluster = $daoCluster->getCluster(8);

        if ($type == null || $cluster == null) {
            $result['type'] = 'error';
            $result['message'] = 'Error getting the boat type or cluster!';
        }
        else {
            $ship->set_type($type);
            $ship->set_cluster($cluster);

            // print_r($type);
    
            $daoShip->addShip($ship);
        }

        // ['message': <message à afficher> registered, 'type': 'success/error/warning']

        print_r(json_encode($result));
    }

    public function getMapPage() {
        $daoPosition = new DaoPosition(DBHOST, DBNAME, PORT, USER, PASS);

        $positions = $daoPosition->getNPos(0, TABLE_AMOUNT);

        $pageMax = ceil($daoPosition->getAmountPos() / TABLE_AMOUNT);

        require_once "pages/maps.php";
    }

    public function getNThBoat() {
        $page = $_GET['page'];

        $daoPosition = new DaoPosition(DBHOST, DBNAME, PORT, USER, PASS);

        $positions = $daoPosition->getNPos(($page-1) * TABLE_AMOUNT, TABLE_AMOUNT);

        $ret = [];

        foreach ($positions as $p) {
            array_push($ret, $p->toArrayFlat());
        }

        print_r(json_encode($ret));
    }

    public function predictTrajectory() {
        $result = [];
        // TODO: response.position et response.time à return après predict.
        $id = $_GET['id'];
        $delta_sec = $_GET['timestamp'];
        $mmsi = $_GET['mmsi'];

        $daoPosition = new DaoPosition(DBHOST, DBNAME, PORT, USER, PASS);
        $pos = $daoPosition->getPositionById((int) $id);
        // Conversion minutes to seconds:
        $delta_sec = $delta_sec * 60;

        $utils = new Utils();

        $arr = $pos->toArrayFlat();
        $arr['delta_sec'] = $delta_sec;
        $arr['VesselType'] = $arr['type'];

        $utils->predict('trajNavire', $arr);
        $json = json_decode(file_get_contents('assets/json/' . $mmsi . '.json'));
        $result['LON'] = (int) $json->{'result'}[0][0];
        $result['LAT'] = (int) $json->{'result'}[0][1];
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

    public function updateStatShips(){
        $daoShip = new DaoShip(DBHOST, DBNAME, PORT, USER, PASS);
        $daoPosition = new DaoPosition(DBHOST, DBNAME, PORT, USER, PASS);
        $nShips = $daoShip->getAmountOfShips();
        $nDockedShips = count($daoShip->getDockedShip());
        $randomShips = $daoShip->getNRandomShips(3);

        foreach ($randomShips as $index => $ship){
            //TODO Get a position of the ship and insert it
            $randomShips[$index] = $ship->toArray();
        }

        print_r(json_encode(["numShipsTracked" => $nShips, "numShipsDocked" => $nDockedShips, "ships" => $randomShips]));
    }

    public function obtainPositions(){
        $n = 20000;
        $daoPosition = new DaoPosition(DBHOST, DBNAME, PORT, USER, PASS);
        if(empty($_GET)){ //no filters
            $positions = $daoPosition->getPos($n);
            print_r(json_encode($positions));
        }
        else{ //format filter string
            $filters = [];
            // Gestion des types
            $types = [];
            if (isset($_GET['passenger']) && intval($_GET['passenger']) != 0) {
                $types[] = intval($_GET['passenger']);
            }
            if (isset($_GET['cargo']) && intval($_GET['cargo']) != 0) {
                $types[] = intval($_GET['cargo']);
            }
            if (isset($_GET['tanker']) && intval($_GET['tanker']) != 0) {
                $types[] = intval($_GET['tanker']);
            }
            if (!empty($types)) {
                $type_conditions = array_map(function($t) {
                    return "type = " . intval($t);
                }, $types);
                $filters[] = '(' . implode(' OR ', $type_conditions) . ')';
            }

            // Gestion du MMSI
            if (isset($_GET['mmsi']) && trim($_GET['mmsi']) !== '') {
                $filters[] = "s.mmsi = '" . addslashes($_GET['mmsi']) . "'";
            }
            // Construction de la clause WHERE
            $fs = '';
            if (!empty($filters)) {
                $fs = 'WHERE ' . implode(' AND ', $filters);
            }
            $positions = $daoPosition->getPos($n, $fs);
            print_r(json_encode($positions));

        }
    }

    public function updateClusters(){
        $daoPosition = new DaoPosition(DBHOST, DBNAME, PORT, USER, PASS);
        $daoShip = new DaoShip(DBHOST, DBNAME, PORT, USER, PASS);
        $daoType = new DaoVesselType(DBHOST, DBNAME, PORT, USER, PASS);
        $daoCluster = new DaoCluster(DBHOST, DBNAME, PORT, USER, PASS);
        $utils = new Utils();

        $amount = $daoShip->getAmountOfShips();

        // TODO: remplacer 100 par $amount.
        $positions = $daoPosition->getPos($amount, "", true);
        $utils->predict('Cluster', $positions, '0', 'clusters');

        $file = json_decode(file_get_contents('assets/json/clusters.json'), true);
        $result = $file['result'];

        // print_r($file['bateau']);

        $i = 0;
        foreach ($file['bateau'] as $b) {
            $cluster = $daoCluster->getCluster($result[$i]);
            $ship = new Ship($b['mmsi'], $b['vesselName'], $b['imo'], $b['Length'], $b['Width'], $b['Draft'], null, $cluster);
            $daoShip->updateCluster($ship);

            $i++;
        }

        $result = [];
        $result['type'] = 'success';
        $result['message'] = 'Clusters have been successfully updated!';

        print_r(json_encode($result));

    }

    public function obtainAllMMSI(): void
    {
        $daoShip = new DaoShip(DBHOST, DBNAME, PORT, USER, PASS);
        print_r(json_encode($daoShip->getAllMMSI()));
    }
}