<?php
class Cluster {
    private int $num_cluster;
    private string $description;

    public function __construct(int $num_cluster, string $description) {
        $this->num_cluster = $num_cluster;
        $this->description = $description;
    }


    public function get_num_cluster() {
        return $this->num_cluster;
    }

    public function get_description() {
        return $this->description;
    }


    public function set_num_cluster($num_cluster) {
        $this->num_cluster = $num_cluster;
    }

    public function set_description($description) {
        $this->description = $description;
    }

    public function toJSON() {
        $result = [];
        $result['num_cluster'] = $this->num_cluster;
        $result['description'] = $this->description;

        return json_encode($result);
    }

    public function toArray() {
        $result = [];
        $result['num_cluster'] = $this->num_cluster;
        $result['description'] = $this->description;

        return $result;
    }
}