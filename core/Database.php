<?php

class Database {

    private static $instance = null;

    public static function getConnection() {
        
        if (!self::$instance) {
            $config = require __DIR__ . '/../config/database.php';

            self::$instance = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']}",
                $config['username'],
                $config['password']
            );
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }
}

// $obj = new Database();
// $db = $obj->getConnection();
// print_r($db);die;

?>