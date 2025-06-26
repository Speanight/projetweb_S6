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

        $daoShip = new DaoShip(DBHOST, DBNAME, PORT, USER, PASS);
        $ship = new Ship($mmsi, $vesselname, $imo, $length, $width, $draft, null, null);

        // AI script to estimate ship type and cluster.
        $utils = new Utils();

        $utils->predict('typeNavire', $ship);

        $daoShip->addShip($ship);
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
        $daoPosition = new DaoPosition(DBHOST, DBNAME, PORT, USER, PASS);
        if(empty($_GET)){ //no filters
            $positions = $daoPosition->getPos(100);
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
            $positions = $daoPosition->getPos(100, $fs);
            print_r(json_encode($positions));

        }

    }
}