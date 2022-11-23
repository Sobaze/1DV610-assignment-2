<?php


class ProductionSettings {

    public $dbServername;
    public $dbUserName ;
    public $dbPassword;
    public $dbName;

    public function __construct() {
        $url = getenv('JAWSDB_URL');
        $dbthings = parse_url($url);

        $this->dbServername = $dbthings['host'];
        $this->dbUserName = $dbthings['user'];
        $this->dbPassword = $dbthings['pass'];
        $this->dbName = ltrim($dbthings['path'], '/');
    }
}