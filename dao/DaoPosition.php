<?php

require_once "objets/Position.php";
require_once "dao/DaoShip.php";

class DaoPosition {
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

        $positions = $statement->fetchAll();

        foreach ($positions as $p) {
            $pos = new Position($p['id'], $p['lat'], $p['lon'], strtotime($p['timestamp']), $p['sog'], $p['cog'], $p['heading'], $p['status'], $ship);
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

        $pos = new Position($p['id'], $p['lat'], $p['lon'], strtotime($p['timestamp']), $p['sog'], $p['cog'], $p['heading'], $p['status'], $ship);

        return $pos;
    }
}