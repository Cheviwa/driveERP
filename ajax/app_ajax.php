<?php
    include_once 'erp/classes/class_AddProd.php';
$sqlConnection = null;
//include_once 'config.php';
$errFlg = 0;
$errMsg = "";

$jsonVal = new stdClass();
$productId = $_POST['ProductId'];
$productCode = $_POST['productCode'];
$productDescriptShrt = $_POST ['productDescriptShrt'];
$productDescriptLng = $_POST['productDescriptLng'];
//$productDescriptLng = htmlspecialchars($productDescriptLng, ENT_QUOTES);
$productEan = $_POST['productEan'];
$productCat = $_POST['ProductCat'];
$Cost = $_POST['Cost'];
$RRP = $_POST['RRP'];
$Weight = $_POST['Weight'];
$request = $_POST['request'];
$char = $_POST['char'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
$OrderId = $_POST['OrderId'];


//$sqlConnection = connectToDatabase();
include_once '../connection.php';
$sqlClass = new connection();
$sqlConnection = $sqlClass->sqlConnect();

if ($request == "getProducts") {
    //this actually gets the data thats inserted 
$sqlgetProds = new displayProducts();
$rs = $sqlgetProds->displayProd();   

    }
    
    $jsonVal->errMsg = $errMsg;
    $jsonVal->resultArray = $rs;

echo json_encode($jsonVal);