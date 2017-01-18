<?php
$sqlConnection = null;
include_once 'config.php';

$sqlConnection = connectToDatabase();
if ($sqlConnection != null) {
    //joins the customer Name and the customer Id
    $sqlQuery = "SELECT * FROM OrderHeader JOIN Customers ON OrderHeader.CustomerId = Customers.customerId ";
    //$results = sqlsrv_query($sqlConnection,$sqlQuery);

    $result = $sqlConnection->prepare($sqlQuery);
    $result->execute();
    $rs = $result->fetchAll();
    //print_r($rs);
    // print_r($result->rowCount());
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



    </head>
    <script>

        $(function () {
            var duedate = $("#duedate").datepicker();
        });
        function AddNew(OrderId)
        {
            //Adds customer's details into the database before customers selects items.


            var customerId = $('#customerId').val();
            var duedate = $('#duedate').val();
            var email = $('#email').val();
            var telNo = $('#telNo').val();
            var currency = $('#currency').val();

            $.ajax({
                //connecting this ajax to the appropriate page.
                url: 'ajax/ordersAjax.php',
                cache: false,
                type: 'POST',
                data: {
                    //this puts the data from the variable into the ajax page
                    'request': 'createOrder',
                    'customerId': customerId,
                    'duedate': duedate,
                    'email': email,
                    'telNo': telNo,
                    'currency': currency,
                    'OrderId':OrderId

                },
                dataType: 'json',
                success: function (data)
                {
                    if (duedate == "" || email == "" || telNo == "")
                    {
                        alert('You have to enter a value in each form');
                    } else
                    {
//                        window.location.href = 'items.php';

                        $('#OrderId').val(data.OrderId);
                        document.forms['frmOrderId'].submit();
                    }
                },
                error: function (data)
                {

                    alert('error in calling ajax page');
                }

            });
        }



    </script>
    <style>


        #customersForm
        {
            width: 80%;
            height: 80%;
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

        label{
            border:1px solid #cccccc;
            width: 12%;

        }
        .tb1
        {
            width: 80%;
            height: 80%;

        }
        #input
        {
            width: 60%;
            height: 60%;
            padding-left: 10px;
        }
        #datepicker
        {
            width: 100px;       
        }
        #email
        {
            width: 35%;
        }




    </style>
    <body>
        <?php
        include_once 'erpTop.php';
        ?>

        <div id="customersForm">
            <div id='input'>
                <label for='customerId'> Customer ID</label>
                <select id='customerId'> 
                    <option value="12"> Tesco </option>
                    <option value="13">Sainsbury</option>  
                    <option value="14">Asda</option>
                    <option value="15">Morrisons</option>
                    <option value="16">M&S</option>
                </select>

                <div class="tbl">
                    <label for="duedate"> Due Date </label>
                    <input type='text' id='duedate'>
                </div>

                <div class="tbl">
                    <label for='email' > Email </label>
                    <input type='email' id="email"  > 
                </div>
                <div class="tbl">
                    <label for="telNo"> Tell No.</label>
                    <input type="tel" id="telNo"   > 
                </div>
                <div class="tbl">
                    <label for="currency">Currency</label>

                    <select  id="currency"> 
                        <option value="GBP" > GBP </option>
                        <option value="EURO" > EURO </option>

                    </select> 
                    <br>
                    <input type='button' value='Create' onclick='AddNew()' id='btnAdd'> 
                </div>
            </div> 
            <form action='items.php' method='post' name="frmOrderId">
                <input type='hidden' name='OrderId' id='OrderId'>  
            </form>
        </div> 








        <?php
        include_once 'erpFooter.php';
        ?>
    </body>    





</html>