<?php
$sqlConnection = null;
include_once 'config.php';
$OrderId = $_POST['OrderId'];

if ($OrderId != "") {
    //amending a product
    $sqlConnection = connectToDatabase();
    if ($sqlConnection != null) {


        $sqlQuery = "SELECT * FROM OrderHeader WHERE OrderId = $OrderId";
        $sqlQuery = "SELECT CustomerName FROM Customers WHERE customerId ";

//echo $sqlQuery;
        //$results = sqlsrv_query($sqlConnection,$sqlQuery);

        try {

            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
            //print_r($rs);
            foreach ($rs as $dataSet) {

                $OrderId = $dataSet['OrderId'];
                $customerId = $dataSet['CustomerId'];
            }
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();
            $errFlg = 1;
        }
    } else {
        $errMsg = "No product Found";
        $errFlag = 1;
    }
}
?>
<html>
    <head>
        <meta charset="windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="jQuery/jquery-min.js"></script>
        <script src="jQuery/jquery-ui.min.js"></script>
        <link rel='stylesheet' type='text/css' href= 'css/style.css'>
        <link rel='stylesheet' type='text/css' href= 'jquery/jquery-ui.min.css'>
        <script>
            $(document).ready(function () {
                $("#dialog-confirm").dialog({
                resizable: false,
                height: 200,
                width: 500,
                modal: true,
                autoOpen: false,
                buttons: {
                    "Yes": function () {
                       
                        $(this).dialog("close");
                    },
                    Cancel: function () {
                         $('#productinfo').hide();
                         
                        $(this).dialog("close");
                    }
                }
            });

                $('#productinfo').hide();
                $('#itemsBasket').hide();

            });
            
            function addAnotherprod()
            {
                $('#input').show();
                $('#itemsBasket').hide();
            }

            var char;
            var totsOrder = 0;
            var prdctDescShrt;
            var amntOfItem;

            function searchProducts()
            {
                char = $('#searchbar').val();
                //searches for products in the database and displays them 
                if (char.length > 3)
                {

                    $.ajax({
                        url: 'ajax/products_ajax.php',
                        cache: false,
                        type: 'POST',
                        data: {

                            'request': 'searchItems',
                            'char': char
                        },
                        dataType: 'json',
                        success: function (data)
                        {
                            //this displays and allows the product to be clicked
                            $('#quantity').show();
                            for (var i = 0; i < data.resultArray.length; i++) {
                                $('#table').append("<tr><td onclick = 'itemDets(" + data.resultArray[i].ProductId + ")'>" + data.resultArray[i].ProductDescShort + '</tr>');
                            }

                        },
                        error: function (data)
                        {

                            alert('error in calling ajax page');
                        }

                    });

                }
            }

            var itemPrice = 0;
            function itemDets(productId)
            {
                //this gets the product and shows the info.

                $.ajax({

                    url: 'ajax/products_ajax.php',
                    cache: false,
                    type: 'POST',
                    data: {

                        'request': 'gettingProducts',
                        'ProductId': productId

                    },
                    dataType: 'json',
                    success: function (data)
                    {

                        $('#prodId').hide();
                        $('#searchbar').val("");
                        $('#productinfo').show();
                        $('#prodId').html(productId);
                        $('#productCode').html("Product Code: " + data.productCode);
                        $('#productDescriptshrt').html("Product: " + data.productDescriptshrt);
                        $('#table').html("");
                        $('#searchbar').focus();
                        $('#price').show();
                        $('#quantity').val("");
                        itemPrice = data.Cost;

                        if (prdctDescShrt == data.productDescriptshrt)
                        {
                            $("#dialog-confirm").dialog("open");
                            $('#dialog-confirm').html("You already have this product at an amount of " + amntOfItem + "<br>" + "Do you want to continue?" );
                           
                        }
                    },
                    error: function (data)
                    {

                        alert('error in calling ajax page');
                    }

                });
            }

            function addItem()
            { //gets quantity and calculates the cost and then adds item to the database
                var quantity = $('#quantity').val();
                var productId = $('#prodId').html();
                var price = $('#itemValue').html();
                var OrderId = $('#OrderId').html();


                $.ajax({

                    url: 'ajax/products_ajax.php',
                    cache: false,
                    type: 'POST',
                    data: {

                        'request': 'addItems',
                        'ProductId': productId,
                        'quantity': quantity,
                        'price': price,
                        'OrderId': OrderId

                    },
                    dataType: 'json',
                    success: function (data)
                    {
                        for (var i = 0; i < data.resultArray.length; i++) {
                            $('#table2').append("<tr><td> " + data.resultArray[i].ProductDescShort + "</td><td>" + data.resultArray[i].qty + "</td><td> " + data.resultArray[i].itemValue);
                        }

                        $('#itemsBasket').show();
                        $('#productinfo').hide();
                        $('#table').show();
                        $('#input').hide();
                        $('#price').hide();

                        for (var i = 0; i < data.resultArray.length; i++) {
                            totsOrder += data.resultArray[i].itemValue << 0;
                        }

                        totalOrder = totsOrder.toFixed(2);
                        $('#Totsprice').html(totalOrder);
                        $('#itemValue').html("");

                        for (var i = 0; i < data.resultArray.length; i++) {
                            prdctDescShrt = data.resultArray[i].ProductDescShort;
                            amntOfItem = data.resultArray[i].qty;
                        }




                    },
                    error: function (data)
                    {

                        alert('error in calling ajax page');
                    }

                });

            }
            function calcValue()
            {
                var quantity = $('#quantity').val();

                var itemVals = quantity * itemPrice;
                var itemValue = itemVals.toFixed(2);
                $('#itemValue').html(itemValue);
            }

        </script>

        <style>


            #customersForm
            {
                width: 80%;
                height: 80%;
            }
            #table
            {
                height: 10%; 
                width: 40%;
                border:1px solid black;
                padding:15px;
            }
            #divAdd 
            {
                width: 100%;
                height: 80%;
            }

            td{
                height: 10px; 
                width: 20px;
                border:1px solid black;
                padding:15px;
            }
            th
            {
                width: 100px;
                height: 60px;
            }
            #img
            {
                padding-bottom: 2px;
            }
            .iteminfo
            {
                width: 30%;
                height:10%;
                border:1px solid #cccccc;
                background-color: #dbdde0;
            }

            #input
            {

                display: inline-block;
                width: 60%;
                height: 80%;
                padding-left: 20px;
                overflow: hidden;
            }
            #itemsBasket
            {
                border: 1px solid #cccccc;
                display: inline-block;
                width: 50%;
                height: 80%;
                padding-left: 20px;
                overflow: hidden;

            }

            #productinfo
            {
                float: left;
                overflow: hidden;
                width: 60%;
                height:80%;
                display: inline-block;
            }
            #searchbar
            {
                width: 40%;
                height: 50px;
            }

            td
            {
                width:75px;
                height:60px;
                border: 2px solid #cccccc;
            }
            tr:nth-child(even) {background-color: #dbdde0}

            #Totsprice
            {
                width: 15%;
                height:30px;
                border:1px solid #cccccc;   
            }
            #itemValue
            {
                width: 12%;
                height:30px;
                border:1px solid #cccccc;
                float: left;

            }
            #quantity
            {
                width:20%; 
            }
            #btnAdd
            {
                background-color: black;
                color: white;
            }



        </style>
    </head>
    <body>

<?php
include_once 'erpTop.php';
?>

        <div id='input'>
            <div id='dialog-confirm'> </div>
            <div id='search'>
                Your Order ID: <div id='OrderId'><?php echo $OrderId ?></div> <?php echo $customerId ?>
                <input type='hidden' value='<?php echo $OrderId ?> ' id='OrderId'>
                <input type='search' placeholder='Search for product' id='searchbar'  onkeyup='searchProducts()'>
                <img src='images/edit.png' width='50px' height= '50px' id='img' onclick='searchProducts()'> 
            </div>

            <table id="table"> 


            </table>   

            <div id='productinfo'>
                <div id='prodId'> </div>
                <div id='productCode' class='iteminfo'>  </div>
                <div id='productDescriptshrt' class='iteminfo'> </div>
                <br>

                <label for="Quantity"> Quantity: </label> <br>
                <input type='number' id='quantity' onchange='calcValue()'> 
                <br>

                Price: <br>
                <div id='itemValue'> </div> 
                <br><br>
                <input type='button' value='Add' onclick='addItem()' id='btnAdd'> 

            </div> 

        </div> 
        <div id='itemsBasket'>
            <h1>Order List </h1>  
            <table id='table2'>  <td> Product </td> <td> Quantity </td> <td> Price </td></table>
            Total Price:<div id='Totsprice'> </div>
            <br> <br>
            <input type='button' value='Add another item' onclick='addAnotherprod()' id='addAnotherProd'>
            <input type='button' value='Order Finished' onclick='orderFinished()' id='btnOrderfnshd'> 
        </div>



        <!--            <div id='finalOrder'>
                        <table>
                            <table id="table"> <tr id = row> <td> Quantity </td> <td>Product Id</td>  <td> Total Price </td> </tr>
                            </table>
                    </div>-->








    </body>    

<?php
include_once 'erpFooter.php';
?>



</html>