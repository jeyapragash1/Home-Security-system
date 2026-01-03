<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Logger.php';

class DbConnector {

    private $hostname;
    private $dbname;
    private $dbuser;
    private $dbpwd;

    public function __construct() {
        $this->hostname = Config::get('DB_HOST', 'localhost');
        $this->dbname = Config::get('DB_NAME', 'home-security-system');
        $this->dbuser = Config::get('DB_USER', 'root');
        $this->dbpwd = Config::get('DB_PASS', '');
    }

    public function getConnection() {
        $dsn = "mysql:host=" . $this->hostname . ";dbname=" . $this->dbname . ";charset=utf8mb4";

        try {
            $con = new PDO($dsn, $this->dbuser, $this->dbpwd);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            return $con;
        } catch (PDOException $ex) {
            Logger::error("Database connection failed: " . $ex->getMessage());
            
            if (Config::get('APP_DEBUG', 'false') === 'true') {
                die("Database connection error. Please check your configuration.");
            } else {
                die("System error. Please contact administrator.");
            }
        }
    }

}