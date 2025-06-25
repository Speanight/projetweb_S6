<?php
const DBHOST = "localhost";
const DBNAME = "titanisen";
const PORT = 5432;
const USER = "postgres";
const PASS = "Isen44N";

const SCRIPT_PATH = '/var/www/projetweb_S6/process.py';

class Utils {
    /**
     * 
     * @param mixed $script
     * @param mixed $ship - Array contenant les valeurs du bateau.
     * @return void
     */
    public function predict($script, $ship) {
        $file = 'assets/json/' . $ship['mmsi'] . ".json";
        $data = [];
        $data['bateau'] = $ship;
        $data['scriptStatus'] = 1; // Status de 1 indique que l'on attend une réponse.

        file_put_contents($file, json_encode($data));
        shell_exec("python3 process.py " . $script . " " . $file . ' 2>&1');
    }
}