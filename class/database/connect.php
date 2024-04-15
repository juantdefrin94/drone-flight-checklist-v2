<?php

class Connect{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "drone_flight_check";
    private $conn = null;

    public function __construct(){
        $this->getConnection();        
    }

    private function getConnection(){
        if($this->conn == null){
            $newConn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            // Check connection
            if ($newConn->connect_error) {
                die("Connection failed: " . $newConn->connect_error);
            }
            $this->conn = $newConn;
        }
        return $this->conn;
    }


// Create connection

}


