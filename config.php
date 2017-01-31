<?php

//connect


function connectToDatabase() {
    $dbName = "login";
    $sqlUser = "erpuser";
    $sqlPassword = "erpuser";
    $host = "DESKTOP-RGPHF2R";
    
    $conn = new PDO('sqlsrv:Server=DESKTOP-RGPHF2R; Database=login; ConnectionPooling=0', $sqlUser, $sqlPassword);
 
    if ($conn === false) {
        die(print_r(sqlsrv_errors(), true));
    }
     return $conn;
}


?>
