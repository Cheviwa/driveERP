<?php
$sqlConnection = null;
include_once 'config.php';
$target_dir = 'upload/';
$target_fileName =$target_dir . basename($_FILES['productImage']['name']);
$productId = $_POST['productId'];

//echo $productId;

if (move_uploaded_file($_FILES['productImage']['tmp_name'],$target_fileName))
{
    //echo 'upload';
    if ($productId != "") {
      $sqlConnection = connectToDatabase();
        if ($sqlConnection != null) {
            $sqlQuery = "UPDATE product SET productImagePath = '$target_fileName' WHERE productID = $productId";
            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
        }
    }
}

else 
{
    echo 'error uploading'.$_FILES['productImage']['tmp_name']; 
 }
     
        
?>