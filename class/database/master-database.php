<?php

include 'class/database/connect.php';

class MasterDatabase {

    private $con = null;

    function __construct(){
        $con = new Connect();
    }

    function validateLogin($username, $password){

    }

}