<?php
$sqlConnection = null;
include_once 'config.php';
$errFlg = 0;
$errMsg = "";

$jsonVal = new stdClass();
$username = $_POST['username'];
$password = $_POST['password'];
$request = $_POST['request'];

        
$sqlConnection = connectToDatabase();


    if ($request == "login") {
        $validLogin =0;
    if ($sqlConnection != null) {
        $sqlQuery ="SELECT * FROM login WHERE username= '$username' AND password='$password'";
        //echo $sqlQuery;
        try {

            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
            //print_r($rs);
            if ($rs !=null)
            {
               $validLogin =1; 
            }
                
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();
            $errFlg = 1;
        }
    }
    $jsonVal->errMsg = $errMsg;
    $jsonVal->validLogin = $validLogin;
}

echo json_encode($jsonVal);
?>