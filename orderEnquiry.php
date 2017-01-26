<?php
include_once 'connection.php';
include_once 'class_product.php';

$sqlClass = new connection();
$sqlConnection = $sqlClass->sqlConnect();


$OrderId = $_POST['orderEnquiry'];


$sqldisplayOrderEnquiry = new orderEnquiry();
$rs = $sqldisplayOrderEnquiry->getOrderEnquiry($OrderId);


?>

<html>
    <head>
        <meta charset="windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="jQuery/jquery-min.js"></script>
        <script src="jQuery/jquery-ui.min.js"></script>
        <link rel='stylesheet' type='text/css' href= 'css/style.css'>
        <link rel='stylesheet' type='text/css' href= 'jquery/jquery-ui.min.css'>
        <link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <style>
        #table2
        {
            width: 40%;
      
                
        }
        td
        {

            border: 2px solid #cccccc;
            background-color: white;
            width: 20%;
        }
        tr:nth-child {
            background-color: #cccccc }
        td{
            height: 10px; 
            width: 20px;
            border:1px solid black;
            padding:15px;
        }
        th
        {
            background-color: #E8E8E6;
            width:75px;
            height:60px;
            text-align: center;
        }
        #input
        {
            width: 100%;
         
        }

    </style>
    <body>
<?php
include_once 'erpTop.php';
?>
        <div id='input'>
        <h3>Order List for Order Id <?php echo $OrderId ?> </h3>  
        <table id='table2'>  <th> Product </th> <th> Product Code </th> <th> Quantity </th> <th> Price </th> 
<!--            <tr><td> <?php // echo $productDescShort ?></td> <td> <?php // echo $productCode ?></td> <td> <?php // echo $quantity ?></td> <td> <?php // echo $price ?></td>   </tr>-->
       
           <?php foreach ($rs as $dataSet) { echo "<tr>" . "<td>" . $dataSet['ProductDescShort'] .
                       "</td>" . "<td>" . $dataSet['ProductCode'] . "</td>" . "<td>" . $dataSet['quantity'] .
                        "</td>" . "<td>" . $dataSet['price'] . "</td>" .
                                           "</tr>";
           }
           ?>
       
         </table>
</div>





<?php
include_once 'erpFooter.php';
?>
    </body> 


</html>