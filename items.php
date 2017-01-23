<?php
$sqlConnection = null;

$OrderId = $_POST['OrderId'];
if ($OrderId == "") {
    header('Location: Orders.php');
}
include_once 'config.php';
if ($OrderId != "") {
    //amending a product
    $sqlConnection = connectToDatabase();
    if ($sqlConnection != null) {


        $sqlQuery = "SELECT * FROM OrderHeader WHERE OrderId = $OrderId";


//echo $sqlQuery;
        //$results = sqlsrv_query($sqlConnection,$sqlQuery);

        try {

            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
            //print_r($rs);
            foreach ($rs as $dataSet) {

                $OrderId = $dataSet['OrderId'];
                
            }
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();
            $errFlg = 1;
        }
    } else {
        $errMsg = "No product Found";
        $errFlag = 1;
    }
//    $sqlQuery = "SELECT OrderHeader.CustomerId, Customers.customerName
//FROM OrderHeader CROSS JOIN  Customers WHERE OrderId = $OrderId ";
//  
//     try {
//
//            $result = $sqlConnection->prepare($sqlQuery);
//            $result->execute();
//            $rs = $result->fetchAll();
////            print_r($rs);
//            foreach ($rs as $dataSet) {
//                $customerName = $dataSet['CustomerName'];
//            }
//             
//        } catch (PDOExeption $e) {
//            $errMsg = $e->getMessage();
//            $errFlg = 1;
//        }
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
        <link rel="stylesheet" href="css/bootstrap.min.css">
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
                            $('#search').show();
                             $(this).dialog("close");
                        }
                    }

                });

                $(function () {
                    $("#dialog-message").dialog({
                        modal: true,
                        autoOpen: false,
                        buttons: {
                            Ok: function () {
                              
                                 document.forms['frmOrderId'].submit();
//                                window.location.href = 'fpdf/pdf.php';
                                $(this).dialog("close");
                            }
                        }
                    });
                });

                $('#productinfo').hide();
                $('#itemsBasket').hide();


            });

            function addAnotherprod()
            {
                $('#input').show();
                $('#itemsBasket').hide();
                $('#search').show();
            }

            var char;
            var totsValue = 0;
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
                        $('#productCode').html("<strong> Product Code: </strong>" + data.productCode);
                        $('#productDescriptshrt').html(" <strong> Product:</strong> " + data.productDescriptshrt);
                        $('#RRP').html("<strong> Price: </strong>" + data.RRP);
                        $('#table').html("");
                        $('#searchbar').focus();
                        $('#price').show();
                        $('#quantity').val("");
                        $('#search').hide();
                        itemPrice = data.RRP;

                        if (prdctDescShrt == data.productDescriptshrt)
                        {
                            $("#dialog-confirm").dialog("open");
                            $('#dialog-confirm').html("You already have this product at an amount of " + amntOfItem + "<br>" + "Do you want to continue?");

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
                            totsValue += data.resultArray[i].itemValue << 0;
                        }

                        totalValue = totsValue.toFixed(2);
                        $('#Totsprice').html(totalValue);
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

            function orderFinished()
            {
//                $("#dialog-message").dialog("open");
                
                 document.forms['frmOrderId'].submit();
            }
            


        </script>

        <style>
            body {
/*                background-color: #ebf0f7  !important; */
            }
#f7f2eb



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
                background-color: #E8E8E6;
                width:75px;
                height:60px;
                text-align: center;
            }

            #img
            {
                padding-bottom: 2px;
            }
            .iteminfo
            {
                width: 80%;
                height:10%;
                font-size: 20px;
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
                width: 100%;
                height:100%;
                display: inline-block;
                margin-right: 65%;
                background-color:#f7f2eb;

            }
            #searchbar
            {
                width: 50%;
                height: 50px;
                border-radius: 15px 50px 30px;
                border: solid darkgrey;
                text-align: center;

            }
            #table2
            {
                width: 100%
            }
            td
            {

                border: 2px solid #cccccc;
                background-color: white;
                width: 20%;
            }
            tr:nth-child {
                background-color: #cccccc }

            #Totsprice
            {
                width: 12%;
                height:30px;
                display: inline-block;
                font-size: 20px;
            }
            #itemValue
            {
                width: 12%;
                height:30px;
                display: inline-block;
                font-size: 20px;

            }
            #quantity
            {
                width:15%; 
                display: inline-block;
                font-size: 20px
            }
            #btnAdd
            {
                background-color:#E8E8E6!important;
                font-size: 20px !important;
                font-weight: 600 !important;

            }
            .button:active {
                background-color: #3e8e41;
            }
            #addAnotherProd
            {
                background-color: #ABB1B3;
                color: black;
            }
            #btnOrderfnshd
            {
                background-color: #ABB1B3;
                color: black;
            }
            #OrderIdx
            {
                display: inline-block;
                font-size: 20px;
            }
            #para
            {
                display: inline-block;
                font-size: 20px; 

            }
            .label
            {
                display: inline-block;
                font-size: 20px; 
                font-weight: 600;
            }

            #productCode
            {
                background-color: #E8E8E6;
                width: 100%;
            }
            #RRP
            {
                background-color: #E8E8E6;
                width: 100%;    
            }
            .btn btn-default
            {
                background-color:#E8E8E6!important;
                font-size: 10px !important;
                font-weight: 300 !important;
            }


        </style>
    </head>
    <body>

        <?php
        include_once 'erpTop.php';
        ?>

        <div id='input'>
            <div id='dialog-confirm'> </div>
            <div id='dialog-message'> <p> Thank you! Your order has been recieved.</p></div>
            <p id='para'>Your Order ID is:</p> <div id='OrderIdx'class='inputSi'><?php echo $OrderId ?> <?php echo $customerName ?></div> 
            <div id='search'>
                <input type='search' placeholder='Search for product' id='searchbar'  onkeyup='searchProducts()'>
                <img src='images/edit.png' width='50px' height= '50px' id='img' onclick='searchProducts()'> 
            </div>

            <table id="table"> 


            </table>   

            <div id='productinfo'>
                <div id='prodId'> </div>
                <div id='productCode' class='iteminfo'>  </div>
                <div id='productDescriptshrt' class='iteminfo'> </div>
                <div id='RRP' class='iteminfo'> </div>
                <br>
                <div id='prices'>
                    <label for="Quantity" class='label'> Quantity: </label> 
                    <input type='number' id='quantity' onchange='calcValue()'> 
                    &nbsp;
                    <p class="label"> Value:</p> 
                    <div id='itemValue'> </div> 

                </div> 
                <input type='button' value='Add' class="btn btn-default" id='btnAdd' onclick='addItem()' > 

            </div> 

        </div> 
        <div id='itemsBasket'>
            <h1>Order List </h1>  
            <table id='table2'>  <th> Product </th> <th> Quantity </th> <th> Price </th></table>
             <label for='Totsprice' class='label'> Total Value: &nbsp; &pound;</label><div id='Totsprice'> </div>
            <br> <br> 
            <input type='button' value='Add another item' class="btn btn-default" onclick='addAnotherprod()' id='addAnotherProd'>
            <input type='button' value='Order Finished'class="btn btn-default" onclick='orderFinished()' id='btnOrderfnshd'> 
        </div>
        <form action='fpdf/pdf.php' method='post' name="frmOrderId">
            <input type='hidden' name='OrderId' id='OrderId' value='<?php echo $OrderId ?>'>  
            </form>


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