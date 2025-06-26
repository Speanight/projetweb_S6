<?php
class VesselType {
    private int $type;
    private string $description;

    public function __construct(int $type, string $description) {
        $this->type = $type;
        $this->description = $description;
    }


    public function get_type() {
        return $this->type;
    }

    public function get_description() {
        return $this->description;
    }


    public function set_type($type) {
        $this->type = $type;
    }

    public function set_description($description) {
        $this->description = $description;
    }

    public function toJSON() {
        $result = [];
        $result['type'] = $this->type;
        $result['description'] = $this->description;

        return json_encode($result);
    }

    public function toArray() {
        $result = [];
        $result['type'] = $this->type;
        $result['tdescription'] = $this->description;

        return $result;
    }
}