<?php

//class to connect to sql
//01    25/01/17    created         C Mudzingwa

class connection {

    protected $dbName = "login";
    protected $sqlUser = "erpuser";
    protected $sqlPassword = "erpuser";
    protected $host = "DESKTOP-RGPHF2R";
    var $conn = NULL;

    function __construct() {
        
    }

    public function sqlConnect() {
        try {
            $this->conn = new PDO("sqlsrv:Server=DESKTOP-RGPHF2R; Database=login;", "$this->sqlUser", "$this->sqlPassword");
            $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            return $this->conn; 
        } catch (PDOException $e) {
            echo 'Unable to connect to database' . $e->getMessage();
        }
    }

    public function sqlCloseCon() {
        $this->conn = NULL;
    }

}

?>