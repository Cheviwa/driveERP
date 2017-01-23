<?php

$sqlConnection = null;
include_once 'config.php';
$errFlg = 0;
$errMsg = "";
$jsonVal = new stdClass();
$request = $_POST['request'];
$customerId = $_POST['customerId'];
//$Dt = date("Y-m-d", strtotime($_POST['txtDate']));
$duedate = $_POST['duedate'];
$email = $_POST['email'];
$telNo = $_POST['telNo'];
$currency = $_POST['currency'];
$Quantity = $_POST['Quantity'];


$sqlConnection = connectToDatabase();
if ($request == "createOrder") {
    //code to make sure the user's input is inserted into the database table
    if ($sqlConnection != null) { {
            //code to make sure the user's input is inserted into the database table

            $sqlQuery = "INSERT INTO OrderHeader(CustomerId, DueDate,Email,TelNo,Currency) VALUES ($customerId,'$datepicker','$email',$telNo,'$currency')";
        }
        //echo $sqlQuery;

        try {

            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $OrderId = $sqlConnection->lastInsertId();
            $rs = $result->fetchAll();
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();      //set error message
            $errFlg = 1;
        }
    }
   $jsonVal->OrderId = $OrderId;
    $jsonVal->errMsg = $errMsg;
}


echo json_encode($jsonVal);
?>