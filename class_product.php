<?php

//class to show the order item list
// 25/01/2017       C Mudzingwa

include_once 'connection.php';

class class_product {

    var $sqlClass = null;
    var $sqlConnection = null;

    public function __Construct() {
        $this->sqlClass = new connection();
        $this->sqlConnection = $this->sqlClass->sqlConnect();
    }

    public function getOrderItem($productId, $quantity) {
        //get order items
        $rs = null;
        $sqlQuery = "SELECT ProductDescShort, RRP AS price, RRP * {$quantity} AS itemValue, {$quantity} AS qty FROM product WHERE ProductId = $productId";
//echo $this->sqlQuery;
        try {
            $result = $this->sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();
            $errFlg = 1;
        }

        return $rs;
    }

}

class orderEnquiry
//class to show an Order 
{
    var $sqlClass = NULL;
    var $sqlConnection = NULL;

    public function __Construct() {
        $this->sqlClass = new connection();
        $this->sqlConnection = $this->sqlClass->sqlConnect();
    }

    public function getOrderEnquiry($OrderId) {

        $rs = null;
        $sqlQuery = "SELECT  OrderItems.OrderId,  OrderItems.quantity, OrderItems.price, product.ProductCode, product.ProductDescShort
FROM   OrderItems INNER JOIN
                         product ON OrderItems.productId = product.ProductId WHERE OrderId = $OrderId";
                       
        try {

            $result = $this->sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();
            $errFlg = 1;
        }
        return $rs;
    }

}

?>