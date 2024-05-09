<?php

include 'config.php';

try {

    $dsn = "mysql:host=" .  DBHOST . ";dbname=" . DBNAME;
    $conn = new PDO($dsn, DBUSER, DBPASSWORD);

    return $conn;   

} catch (PDOException $e) {

    echo "" . $e->getMessage();
    
}