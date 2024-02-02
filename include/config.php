<?php
class dbConfig {
    protected $serverName;
    protected $userName;
    protected $password;
    protected $dbName;
    function dbConfig() {
        $this -> serverName = 'localhost';
        $this -> userName = 'root';
        $this -> password = 'alirimon01816042';
        $this -> dbName = 'managementapp';
    }
}
?>