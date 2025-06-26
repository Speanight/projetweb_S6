<?php

require_once "objets/VesselType.php";

class DaoVesselType {
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

    public function getType(int $type) {
        $result     = [];
        $statement  = $this->db->prepare("SELECT * FROM vesseltype WHERE type = :type");
        $statement->bindParam(":type", $type);
        $statement->execute();

        $t = $statement->fetch();
        $type = new VesselType($t['type'], $t['description']);

        return $type;
    }
}