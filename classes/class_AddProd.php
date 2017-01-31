<?php
//Class for sql to add the items selected by the user to the basket.
// 26/01/2017       C Mudzingwa
include_once 'connection.php';
class displayProducts
{
    
    var $sqlClass = null;
    var $sqlConnection = null;


public function __construct()
    {
        $this->sqlClass = new connection();
        $this->sqlConnection = $this->sqlClass->sqlConnect();
        
    }
 public function displayProd()
 {
 //sqlQuery to add the database. 
     $rs = NULL;
             $sqlQuery = "SELECT * FROM product";
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