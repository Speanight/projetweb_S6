<?php
require_once "dao/DaoShip.php";
require_once "dao/DaoCluster.php";
require_once "dao/DaoVesselType.php";
require_once "objets/Position.php";
class DaoPosition
{
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

    public function addPosition($position) {
        $statement = $this->db->prepare("INSERT INTO position (lat, lon, timestamp, sog, cog, heading, status, mmsi) VALUES (:lat, :lon, :timestamp, :sog, :cog, :heading, :status, :mmsi)");
        $statement->bindParam(":lat", $position->get_lat());
        $statement->bindParam(":lon", $position->get_lon());
        $statement->bindParam(":timestamp", $position->get_timestamp());
        $statement->bindParam(":sog", $position->get_sog());
        $statement->bindParam(":cog", $position->get_cog());
        $statement->bindParam(":heading", $position->get_heading());
        $statement->bindParam(":status", $position->get_status());
        $statement->bindParam(":mmsi", $position->get_ship()->get_mmsi());
        $statement->execute();
    }

    public function getPositionsOfBoat($ship) {
        $result = [];

        $statement = $this->db->prepare("SELECT * FROM position WHERE mmsi = :mmsi");
        $statement->bindParam(":mmsi", $ship->get_mmsi());
        $statement->execute();

        $positions = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($positions as $p) {
            $pos = new Position($p['id'], $p['lat'], $p['lon'], new DateTime($p['timestamp']), $p['sog'], $p['cog'], $p['heading'], $p['status'], $ship);
            array_push($result, $pos);
        }

        return $result;
    }

    public function getPositionById($id) {
        $statement = $this->db->prepare("SELECT * FROM position WHERE id = :id");
        $statement->bindParam(":id", $id);
        $statement->execute();
        $p = $statement->fetch();

        $daoShip = new DaoShip(DBHOST, DBNAME, PORT, USER, PASS);
        $ship = $daoShip->getShipByMMSI($p['mmsi']);

        $pos = new Position($p['id'], $p['lat'], $p['lon'], new DateTime($p['timestamp']), $p['sog'], $p['cog'], $p['heading'], $p['status'], $ship);

        return $pos;
    }
    public function getLatestPos(string $mmsi) {
        $statement = $this->db->prepare("SELECT * FROM position WHERE mmsi = ? LIMIT 1");
        $statement->execute([$mmsi]);
        return $statement->fetch();
    }

    public function getAmountPos() {
        $statement = $this->db->prepare("SELECT COUNT(*) FROM position");
        $statement->execute();
        $value = $statement->fetch();

        return (int) $value['count'];
    }

    public function getNPos(int $start = 0, int $amount = 20) {
        $result = [];
        $statement = $this->db->prepare("SELECT * FROM position LIMIT :lim OFFSET :off");
        $statement->bindParam(":lim", $amount);
        $statement->bindParam(":off", $start);
        $statement->execute();

        $positions = $statement->fetchAll();

        $daoShip = new DaoShip(DBHOST, DBNAME, PORT, USER, PASS);

        foreach ($positions as $p) {
            $ship = $daoShip->getShipByMMSI($p['mmsi']);
            $pos = new Position($p['id'], $p['lat'], $p['lon'], new DateTime($p['timestamp']), $p['sog'], $p['cog'], $p['heading'], $p['status'], $ship);
            array_push($result, $pos);
        }

        return $result;
    }

    public function getPos(?int $n = 100, string $filterString = ""): array {
        $arr = [];
        $daoCluster = new DaoCluster(DBHOST, DBNAME, PORT, USER, PASS);
        $daoVessel = new DaoVesselType(DBHOST, DBNAME, PORT, USER, PASS);
        $statement = $this->db->prepare(
            "SELECT * FROM position p 
                        JOIN ship s ON s.mmsi = p.mmsi 
                        JOIN cluster c ON s.num_cluster = c.num_cluster 
                        " . $filterString . " 
                        GROUP BY p.mmsi, p.timestamp, p.id, s.mmsi, c.num_cluster 
                        ORDER BY p.timestamp 
                        LIMIT ?"
        );
        $statement->execute([$n]);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $l) {
            $cluster = $daoCluster->getCluster($l['num_cluster']);
            $type = $daoVessel->getType($l['type']);
            $ship = new Ship($l['mmsi'], $l['vesselname'], $l['imo'], $l['length'], $l['width'], $l['draft'], $type, $cluster);
            $pos = new Position($l['id'], $l['lat'], $l['lon'], new DateTime($l['timestamp']), $l['sog'], $l['cog'], $l['heading'], $l['status'], $ship);
            $arr[] = $pos->toArray();
        }
        return $arr;
    }





}