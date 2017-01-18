<?php
$sqlConnection = null;
include_once 'config.php';
//
//$sqlConnection = connectToDatabase();
//if ($sqlConnection != null) {
//    $sqlQuery = "SELECT * FROM  product WHERE productID = '$productID'";
//    //$results = sqlsrv_query($sqlConnection,$sqlQuery);
//
//    $result = $sqlConnection->prepare($sqlQuery);
//    $result->execute();
//    $rs = $result->fetchAll();
//    //print_r($rs);
//    // print_r($result->rowCount());
//}
//
?>
<html>
<head>
    <meta charset="windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jQuery/jquery-min.js"></script>
    <script src="jQuery/jquery-ui.min.js"></script>
    <link rel='stylesheet' type='text/css' href= 'css/style.css'>
      

</head>
<script>
    $(document).ready(function () {
      
       
        $.ajax({
            url: 'ajax/products_ajax.php',
            cache: false,
            type: 'POST',
            data: {

                'request': 'getProducts'
                
            },
            dataType: 'json',
            success: function (data)
            {
                for (var i = 0; i < data.resultArray.length; i++) {
                    $('#table').append('<tr><td>' + data.resultArray[i].ProductCode + '</td><td>' + data.resultArray[i].ProductDescShort + '</td><td>' + data.resultArray[i].ProductDescLong + '</td><td>' + data.resultArray[i].ProductEAN + '</td><td>' + data.resultArray[i].ProductCat + '</td><td>' + data.resultArray[i].Cost + '</td><td>' + data.resultArray[i].RRP + '</td><td>' + data.resultArray[i].Weight
                    + '</td><td>' + "<img src='images/edit.png'width=20px height=20px' onclick='doEdit(" + data.resultArray[i].ProductId + ")'>" + '</td><td>' + "<img src='images/view.png'width=20px height=20px' onclick='doView(" + data.resultArray[i].ProductId + ")'>" );
                }

            },
            error: function (data)
            {

                alert('error in calling ajax page');
            }

        });

    });
    function AddNew()
    {
        document.forms['frmEdit'].submit();
        
    }
    function doEdit(productId)
    {
        
        //submit via hidden form
        $('#prodId').val(productId);
        document.forms['frmEdit'].submit();
        
    }
   function doView (prodId)
   { 
      $('#productId').val(prodId);
     document.forms['frmProdinfo'].submit();
   }
    
   
</script>
<style>


    td{
        height: 20%; 
        width: 20%;
        border:1px solid black;
        padding:15px;
    }

    #btnAdd 
    {
        width: 5%;
        height: 5%;
    }

    #divProducts
    {
        width: 80%;
        height: 100%;
    }
    #table2
    {

        height: 20%; 
        width: 20%;
        border:1px solid black;
        padding:15px;
    }
    #divAdd 
    {
        width: 100%;
        height: 80%;

    }
    th
    {
        border: 1px solid;
    }
      tr:nth-child(even) {background-color: #dbdde0}


</style>
<body>
    <?php
    include_once 'erpTop.php';
    ?>

    <div id="divProducts">

        <table id="table"> <tr id = row> <th> Product Code</th> <th> Short Description </th> <th> Long Description</th>
                <th>Product EAN </th> <th> Product CAT</th> <th> Cost(&pound;) </th> <th> Recomended Retail Price(&pound)</th>
                <th>Weight (kg)</th> <th> Edit </th> <th> View Product </th>

            </tr>
   
        </table>
        <form action='productsEdit.php' method='post' name ='frmEdit'>
                <input type="hidden" name='prodId' id='prodId'>
             </form>
        
        <form action='productinfo.php'method='post'name='frmProdinfo'>
        <input type="hidden" name='productId' id='productId'>
         
</form>
        
        <input type='button' value='Add' onclick='AddNew()' id='btnAdd'> 
    </div> 








    <?php
    include_once 'erpFooter.php';
    ?>
</body>    





</html>