<?php

require_once "objets/Cluster.php";

class DaoCluster {
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

    public function getCluster(int $num_cluster) {
        $result     = [];
        $statement  = $this->db->prepare("SELECT * FROM cluster WHERE num_cluster = :num");
        $statement->bindParam(":num", $num_cluster);
        $statement->execute();

        $c = $statement->fetch();
        $cluster = new Cluster($c['num_cluster'], $c['description']);

        return $cluster;
    }
}