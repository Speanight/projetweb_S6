<?php
require_once "objets/Cluster.php";
require_once "objets/VesselType.php";

class Ship {
    private string $mmsi;
    private string $vesselName;
    private string $imo;
    private float $length;
    private float $width;
    private float $draft;
    private ?VesselType $type;
    private ?Cluster $cluster;

    public function __construct(string $mmsi, string $vesselName, string $imo = 'xxxxxxx', float $length, float $width, float $draft, ?VesselType $type, ?Cluster $cluster = null) {
        $this->mmsi = $mmsi;
        $this->vesselName = $vesselName;
        $this->imo = $imo;
        $this->length = $length;
        $this->width = $width;
        $this->draft = $draft;
        $this->type = $type;
        $this->cluster = $cluster;
    }


    public function get_mmsi(): string {
        return $this->mmsi;
    }

    public function get_vesselName(): string {
        return $this->vesselName;
    }

    public function get_imo(): string {
        return $this->imo;
    }

    public function get_length(): float {
        return $this->length;
    }

    public function get_width(): float {
        return $this->width;
    }

    public function get_draft(): float {
        return $this->draft;
    }

    public function get_type(): ?VesselType {
        return $this->type;
    }

    public function get_cluster(): Cluster {
        return $this->cluster;
    }


    public function set_mmsi($mmsi) {
        $this->mmsi = $mmsi;
    }

    public function set_vesselName($vesselName) {
        $this->vesselName = $vesselName;
    }

    public function set_imo($imo) {
        $this->imo = $imo;
    }

    public function set_length($length) {
        $this->length = $length;
    }

    public function set_width($width) {
        $this->width = $width;
    }

    public function set_draft($draft) {
        $this->draft = $draft;
    }

    public function set_type($type) {
        $this->type = $type;
    }

    public function set_cluster($cluster) {
        $this->cluster = $cluster;
    }

    public function toJSON() {
        $result                 = [];
        $result['mmsi']         = $this->mmsi;
        $result['vesselName']   = $this->vesselName;
        $result['imo']          = $this->imo;
        $result['length']       = $this->length;
        $result['width']        = $this->width;
        $result['draft']        = $this->draft;
        if ($this->type == null)    $result['type']     = null;
        else                        $result['type']     = $this->type->toJSON();
        if ($this->cluster == null) $result['cluster']  = null;
        else                        $result['cluster']  = $this->cluster->toJSON();

        return json_encode($result);
    }

    public function toArray() {
        $result = [];
        $result['mmsi']         = $this->mmsi;
        $result['vesselName']   = $this->vesselName;
        $result['imo']          = $this->imo;
        $result['length']       = $this->length;
        $result['width']        = $this->width;
        $result['draft']        = $this->draft;
        if ($this->type == null)    $result['type']     = null;
        else                        $result['type']     = $this->type->toArray();
        if ($this->cluster == null) $result['cluster']  = null;
        else                        $result['cluster']  = $this->cluster->toArray();

        return $result;
    }

    public function toArrayFlat() {
        $result = [];
        $result['mmsi']         = $this->mmsi;
        $result['vesselName']   = $this->vesselName;
        $result['imo']          = $this->imo;
        $result['Length']       = $this->length;
        $result['Width']        = $this->width;
        $result['Draft']        = $this->draft;
        if ($this->type != null) $result = array_merge($result, $this->type->toArray());
        if ($this->cluster != null) $result = array_merge($result, $this->cluster->toArray());

        return $result;
    }
}