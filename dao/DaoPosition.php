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

    public function getLatestPos(string $mmsi) {
        $statement = $this->db->prepare("SELECT * FROM position WHERE mmsi = ? LIMIT 1");
        $statement->execute([$mmsi]);
        return $statement->fetch();
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