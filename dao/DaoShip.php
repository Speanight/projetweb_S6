<?php
require_once "objets/Ship.php";
require_once "dao/DaoCluster.php";
require_once "dao/DaoVesselType.php";

class DaoShip {
    private string $host;
    private string $dbname;
    private int $port;
    private string $user;
    private string $pass;
    private PDO $db;
    public function __construct(string $host, string $dbname, int $port, string $user, string $pass){
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->pass = $pass;

        try {
            $this->db = new PDO("pgsql:dbname=" . $dbname . ";host=" . $host . ";port=" . $port, $user, $pass);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getShips(?int $n = null) {
        if ($n == null) $query = "SELECT * FROM ship";
        else            $query = "SELECT * FROM ship LIMIT " . $n;

        $result     = [];
        $statement  = $this->db->prepare($query);
        $statement->execute();

        $ships = $statement->fetchAll();

        $daoCluster = new DaoCluster(DBHOST, DBNAME, PORT, USER, PASS);
        $daoVessel = new DaoVesselType(DBHOST, DBNAME, PORT, USER, PASS);

        foreach ($ships as $s) {
            $cluster = $daoCluster->getCluster($s['num_cluster']);
            $type = $daoVessel->getType($s['type']);
            $ship = new Ship($s['mmsi'], $s['vesselname'], $s['imo'], $s['length'], $s['width'], $s['draft'], $type, $cluster);
            array_push($result, $ship);
        }

        return $result;
    }

    public function getNRandomShips(int $n = 3) {
        $result = [];

        $statement = $this->db->prepare("SELECT * FROM ship ORDER BY random() LIMIT " . $n);
        $statement->execute();

        $ships = $statement->fetchAll();

        $daoCluster = new DaoCluster(DBHOST, DBNAME, PORT, USER, PASS);
        $daoVessel = new DaoVesselType(DBHOST, DBNAME, PORT, USER, PASS);

        foreach ($ships as $s) {
            $cluster = $daoCluster->getCluster($s['num_cluster']);
            $type = $daoVessel->getType($s['type']);
            $ship = new Ship($s['mmsi'], $s['vesselname'], $s['imo'], $s['length'], $s['width'], $s['draft'], $type, $cluster);
            array_push($result, $ship);
        }

        return $result;
    }

    public function getAmountOfShips() {
        $statement = $this->db->prepare("SELECT COUNT(*) FROM ship");
        $statement->execute();
        $result = $statement->fetch();

        return $result['count'];
    }

    
    public function getShipByMMSI(string $mmsi) {
        $result     = [];
        $statement  = $this->db->prepare("SELECT * FROM ship WHERE mmsi = :mmsi");
        $statement->bindParam(":mmsi", $mmsi);
        $statement->execute();

        $s = $statement->fetch();

        $daoCluster = new DaoCluster(DBHOST, DBNAME, PORT, USER, PASS);
        $daoVessel = new DaoVesselType(DBHOST, DBNAME, PORT, USER, PASS);


        $cluster = $daoCluster->getCluster($s['num_cluster']);
        $type = $daoVessel->getType($s['type']);
        $ship = new Ship($s['mmsi'], $s['vesselname'], $s['imo'], $s['length'], $s['width'], $s['draft'], $type, $cluster);

        return $ship;
    }

    public function getDockedShip() {
        $result = [];
        $statement = $this->db->prepare("SELECT * FROM ship INNER JOIN position ON ship.mmsi = position.mmsi WHERE status = 1");
        $statement->execute();

        $ships = $statement->fetchAll();

        $daoCluster = new DaoCluster(DBHOST, DBNAME, PORT, USER, PASS);
        $daoVessel = new DaoVesselType(DBHOST, DBNAME, PORT, USER, PASS);

        foreach ($ships as $s) {
            $cluster = $daoCluster->getCluster($s['num_cluster']);
            $type = $daoVessel->getType($s['type']);
            $ship = new Ship($s['mmsi'], $s['vesselname'], $s['imo'], $s['length'], $s['width'], $s['draft'], $type, $cluster);

            array_push($result, $ship);
        }

        return $ships;
    }
    

    public function addShip(Ship $ship){
        $statement = $this->db->prepare('INSERT INTO ship (mmsi, vesselname, imo, length, width, draft) VALUES (:mmsi, :type, :imo, :length, :width, :draft)');
        $statement->bindParam(":beg", $beginning);
        $statement->bindParam(":end", $ending);
        $statement->bindParam(":id_place", $idPlace);
        $statement->bindParam(":id_user", $idUser);
        $statement->bindParam(":mmsi", $ship->get_mmsi());
        $statement->bindParam(":type", $ship->get_type()->get_type());
        $statement->bindParam(":imo", $ship->get_imo());
        $statement->bindParam(":length", $ship->get_length());
        $statement->bindParam(":width", $ship->get_width());
        $statement->bindParam(":draft", $ship->get_draft());

        return $statement->execute();
    }

    public function getFilteredBoats(?int $type = null, ?string $mmsi = null) {
        $result = [];
        $query = "SELECT * FROM ship";

        if ($type != null && $mmsi != null) $query = $query . " WHERE type = " . $type . " AND mmsi = '" . $mmsi . "'";
        else {
            if ($type != null) $query = $query . " WHERE type = " . $type;
            if ($mmsi != null) $query = $query . " WHERE mmsi = '" . $mmsi . "'";
        }

        $statement = $this->db->prepare($query);
        $statement->execute();
        $ships = $statement->fetchAll();

        $daoCluster = new DaoCluster(DBHOST, DBNAME, PORT, USER, PASS);
        $daoVessel = new DaoVesselType(DBHOST, DBNAME, PORT, USER, PASS);

        foreach ($ships as $s) {
            $cluster = $daoCluster->getCluster($s['num_cluster']);
            $type = $daoVessel->getType($s['type']);
            $ship = new Ship($s['mmsi'], $s['vesselname'], $s['imo'], $s['length'], $s['width'], $s['draft'], $type, $cluster);

            array_push($result, $ship);
        }

        return $result;
    }
}