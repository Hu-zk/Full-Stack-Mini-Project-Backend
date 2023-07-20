<?php

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Access-Control-Max-Age: 3600');

    $db_host= "localhost";
    $db_user= "root";
    $db_pass= null;
    $db_name= "login_db";

    $mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if(!$mysqli){
        die('Failed to connect to the DataBase');
    }