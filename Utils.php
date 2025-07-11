<?php
const DBHOST = "localhost";
const DBNAME = "titanisen";
const PORT = 5432;
const USER = "postgres";
const PASS = "Isen44N";

const SCRIPT_PATH = '/var/www/projetweb_S6/process.py';

const TABLE_AMOUNT = 10;

class Utils {
    /**
     * 
     * @param mixed $script
     * @param mixed $ship - Array contenant les valeurs du bateau.
     * @return void
     */
    public function predict($script, $ship, int $ret = 0, string $filePath = null) {
        if ($filePath == null) $filePath = $ship['mmsi'];
        $file = 'assets/json/' . $filePath . ".json";
        $data = [];
        $data['bateau'] = $ship;
        $data['scriptStatus'] = 1; // Status de 1 indique que l'on attend une réponse.

        file_put_contents($file, json_encode($data));
        $value = shell_exec("python3 process.py " . $script . " " . $file . ' ' . $ret . ' 2>&1');

        return $value;
    }
}