<?php
require_once "objets/Ship.php";

class Position {
    private ?int $id;
    private float $lat;
    private float $lon;
    private int $timestamp;
    private float $sog;
    private float $cog;
    private float $heading;
    private int $status;
    private Ship $ship;

    public function __construct($id = null, $lat, $lon, $timestamp, $sog, $cog, $heading, $status, $ship) {
        $this->id = $id;
        $this->lat = $lat;
        $this->lon = $lon;
        $this->timestamp = $timestamp;
        $this->sog = $sog;
        $this->cog = $cog;
        $this->heading = $heading;
        $this->status = $status;
        $this->ship = $ship;
    }


    public function get_id() {
        return $this->id;
    }

    public function get_lat() {
        return $this->lat;
    }

    public function get_lon() {
        return $this->lon;
    }

    public function get_timestamp() {
        return $this->timestamp;
    }

    public function get_sog() {
        return $this->sog;
    }

    public function get_cog() {
        return $this->cog;
    }

    public function get_heading() {
        return $this->heading;
    }

    public function get_status() {
        return $this->status;
    }

    public function get_ship() {
        return $this->ship;
    }


    public function set_id($id) : void {
        $this->id = $id;
    }

    public function set_lat($lat) : void {
        $this->lat = $lat;
    }

    public function set_lon($lon) : void {
        $this->lon = $lon;
    }

    public function set_timestamp($timestamp) : void {
        $this->timestamp = $timestamp;
    }

    public function set_sog($sog) : void {
        $this->sog = $sog;
    }

    public function set_cog($cog) : void {
        $this->cog = $cog;
    }

    public function set_heading($heading) : void {
        $this->heading = $heading;
    }

    public function set_status($status) : void {
        $this->status = $status;
    }

    public function set_ship($ship) : void {
        $this->ship = $ship;
    }

    public function toJSON() {
        $result = [];
        $result['id'] = $this->id;
        $result['lat'] = $this->lat;
        $result['lon'] = $this->lon;
        $result['timestamp'] = $this->timestamp;
        $result['sog'] = $this->sog;
        $result['cog'] = $this->cog;
        $result['heading'] = $this->heading;
        $result['status'] = $this->status;
        $result['ship'] = $this->ship->toJSON();

        return json_encode($result);
    }

    public function toArray() {
        $result = [];
        $result['id'] = $this->id;
        $result['lat'] = $this->lat;
        $result['lon'] = $this->lon;
        $result['timestamp'] = $this->timestamp;
        $result['sog'] = $this->sog;
        $result['cog'] = $this->cog;
        $result['heading'] = $this->heading;
        $result['status'] = $this->status;
        $result['ship'] = $this->ship->toArray();

        return $result;
    }

    // Array completely flattened for python script.
    public function toArrayFlat() {
        $result = [];
        $result['id'] = $this->id;
        $result['LAT'] = $this->lat;
        $result['LON'] = $this->lon;
        $result['timestamp'] = $this->timestamp;
        $result['SOG'] = $this->sog;
        $result['COG'] = $this->cog;
        $result['Heading'] = $this->heading;
        $result['status'] = $this->status;
        
        $result = array_merge($result, $this->ship->toArrayFlat());

        return $result;
    }
}