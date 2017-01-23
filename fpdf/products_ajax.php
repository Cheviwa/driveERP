<?php

$sqlConnection = null;
include_once 'config.php';
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


$sqlConnection = connectToDatabase();
if ($request == "insertProduct") {
    //code to make sure the user's input is inserted into the database table
    if ($sqlConnection != null) { {
            //code to make sure the user's input is inserted into the database table

            $sqlQuery = "INSERT INTO product(ProductCode,ProductDescShort,ProductDescLong,ProductEan,ProductCat,Cost,RRP,Weight) VALUES ('$productCode','$productDescriptShrt','$productDescriptLng','$productEan','$productCat','$Cost','$RRP','$Weight')";
        }
        //echo $sqlQuery;

        try {

            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
        } catch (PDOExeption $e) {
            // echo 'hello';
            $errMsg = $e->getMessage();      //set error message
            $errFlg = 1;
        }
    }
    //echo $sqlQuery;
}

if ($request == "getProducts") {
    //this actually gets the data thats inserted 
    if ($sqlConnection != null) {
        $sqlQuery = "SELECT * FROM product";
        try {

            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();
            $errFlg = 1;
        }
    }
    $jsonVal->errMsg = $errMsg;
    $jsonVal->resultArray = $rs;
}

//echo $sqlQuery;
//this updates the new user input that is typed via the edit function. Where studentId makes sure only the products with studentId are updated 
if ($request == "updateProduct") {
    if ($sqlConnection != null) {
        $sqlQuery = "UPDATE product SET "
                . "ProductCode= " . $productCode . ", ProductDescShort='" . $productDescriptShrt . "', ProductDescLong = '" . $productDescriptLng . "', ProductEAN= '" . $productEan . "',ProductCat= '" . $productCat . "',Cost=$Cost , RRP= $RRP ,Weight=$Weight WHERE ProductId= $productId ";

//echo $sqlQuery;

        try {

            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();
            $errFlg = 1;
        }
    }
    $jsonVal->errMsg = $errMsg;
    $jsonVal->resultArray = $rs;
}
if ($request == "searchItems") {
    if ($sqlConnection != null) {

        $sqlQuery = "SELECT ProductDescShort, ProductId  FROM product WHERE ProductDescShort LIKE '%$char%'";
        //echo $sqlQuery;
        try {

            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();
            $errFlg = 1;
        }
    }
    $jsonVal->errMsg = $errMsg;
    $jsonVal->resultArray = $rs;
}
if ($request == "gettingProducts") {
    if ($sqlConnection != null) { {
            $sqlQuery = "SELECT ProductDescShort,ProductCode, RRP, productImagePath FROM product WHERE ProductId = $productId ";
        }
        //echo $sqlQuery;
        try {

            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
            {
                foreach ($rs as $dataSet) {

                    $productDescriptshrt = $dataSet['ProductDescShort'];
                    $RRP = $dataSet['RRP'];
                    $prodImagePath = $dataSet['productImagePath'];
                    $productCode = $dataSet['ProductCode'];
                }
            }
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();      //set error message
            $errFlg = 1;
        }
    }
    $jsonVal->errMsg = $errMsg;
    $jsonVal->productDescriptshrt = $productDescriptshrt;
    $jsonVal->RRP = $RRP;
    $jsonVal->productCode = $productCode;
}
if ($request == "checkStock") {
    if ($sqlConnection != null) { 
            $sqlQuery = "SELECT Stock WHERE ProductId= $productId ";
        }
        //echo $sqlQuery;
        try {

            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
        }
            
         catch (PDOExeption $e) {
            $errMsg = $e->getMessage();      //set error message
            $errFlg = 1;
        }
        $jsonVal->errMsg = $errMsg;
    }


if ($request == "addItems") {
    //code to make sure the user's input is inserted into the database table
    if ($sqlConnection != null) { {
            //code to make sure the user's input is inserted into the database table
        

            $sqlQuery = "INSERT INTO OrderItems(OrderId,productId, quantity,price) VALUES ($OrderId,$productId, $quantity,$price )";
            
        }
        //echo $sqlQuery;

        try {

            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();      //set error message
            $errFlg = 1;
        }
        
        $sqlQuery = "SELECT ProductDescShort, RRP AS price, RRP * $quantity AS itemValue, $quantity AS qty FROM product WHERE ProductId = $productId";
//echo $sqlQuery;

        try {

            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll(); {
//                foreach ($rs as $dataSet) {
//                    $value = $dataSet['VALUE'];
////                    $productDescriptShrt = $dataSet['ProductDescShort'];
////                }
               
            }
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();      //set error message
            $errFlg = 1;
        }
       
    $jsonVal->errMsg = $errMsg;
    $jsonVal->resultArray = $rs;
    }
}




echo json_encode($jsonVal);
?>