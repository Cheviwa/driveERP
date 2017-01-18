<?php
$sqlConnection = null;
include_once 'config.php';
$prodId = $_POST['productId'];
$productId = $_POST['productId'];

//this connects it to database and gets the data from the table
$sqlQuery = "SELECT * FROM  product WHERE productID = $prodId";

$sqlConnection = connectToDatabase();
if (trim($prodId) != "") {
    try {
        $result = $sqlConnection->prepare($sqlQuery);
        $result->execute();
        $rs = $result->fetchAll();

        foreach ($rs as $dataSet) {
            $prodId = $dataSet['productId'];
            $productCode = $dataSet['ProductCode'];
            $productDescriptshrt = $dataSet['ProductDescShort'];
            $productDescriptLng = $dataSet['ProductDescLong'];
            $productEan = $dataSet['ProductEAN'];
            $productCat = $dataSet['ProductCat'];
            $Cost = $dataSet['Cost'];
            $RRP = $dataSet['RRP'];
            $weight = $dataSet['Weight'];
            $prodImagePath = $dataSet['productImagePath'];
        }
    } catch (PDOExeption $e) {
        $errMsg = $e->getMessage();
        $errFlg = 1;
    }
} else {
    $errMsg = "No product Found";
    $errFlag = 1;
}
?>


<html>

    <head>
        <meta charset="windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="jQuery/jquery-min.js"></script>
        <script src="jQuery/jquery-ui.min.js"></script>
        <link rel='stylesheet' type='text/css' href= 'css/style.css'>
        <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>

    </head>
    <script>
        $(document).ready(function () {

            $('#divEdit').hide();
        });
        function ammendProduct()
        {
            //ammending the product and updating it
            var productId = $('#productId').val();
            var productCode = $('#productCode').val();
            var productDescriptShrt = $('#productDescriptShrt').val();
            var productDescriptionLng = tinyMCE.get('productDescriptLng').getContent();
            var productEan = $('#productEan').val();
            var ProductCat = $('#productCat').val();
            var Cost = $('#Cost').val();
            var RRP = $('#RRP').val();
            var Weight = $('#Weight').val();

            $.ajax({
                url: 'ajax/products_ajax.php',
                cache: false,
                type: 'POST',
                data: {
                    //getting data from ajax code
                    'request': 'updateProduct',
                    'ProductId': productId,
                    'productCode': productCode,
                    'productDescriptShrt': productDescriptShrt,
                    'productDescriptLng': productDescriptionLng,
                    'productEan': productEan,
                    'ProductCat': ProductCat,
                    'Cost': Cost,
                    'RRP': RRP,
                    'Weight': Weight
                },
                dataType: 'json',
                success: function (data)
                {
                    //window.location.href = 'products.php';

                },
                error: function (data)
                {

                    alert('error in calling ajax page');
                }

            });

        }
        tinymce.init({
            selector: '#productDescriptLng'
        });
        function ammendProducts()
        {
            //ammending the product and updating it
            var productId = $('#ProductId').val();
            var productCode = $('#productCode').val();
            var productDescriptShrt = $('#productDescriptShrt').val();
            var productDescriptionLng = tinyMCE.get('productDescriptLng').getContent();
            var productEan = $('#productEan').val();
            var ProductCat = $('#productCat').val();
            var Cost = $('#Cost').val();
            var RRP = $('#RRP').val();
            var Weight = $('#Weight').val();

            $.ajax({
                url: 'ajax/products_ajax.php',
                cache: false,
                type: 'POST',
                data: {
                    //getting data from ajax code which gets from the database
                    'request': 'updateProduct',
                    'ProductId': productId,
                    'productCode': productCode,
                    'productDescriptShrt': productDescriptShrt,
                    'productDescriptLng': productDescriptionLng,
                    'productEan': productEan,
                    'ProductCat': ProductCat,
                    'Cost': Cost,
                    'RRP': RRP,
                    'Weight': Weight
                },
                dataType: 'json',
                success: function (data)
                {
                    window.location.href = 'products.php';

                },
                error: function (data)
                {

                    alert('error in calling ajax page');
                }

            });
        }
        //the input box
        tinymce.init({
            selector: '#productDescriptLng'
        });




        function DoEditNew()
        {
            //this is to ammend the product by using the same page.
            $('#divEdit').show();
            $('#divBody').hide();
        }
      function userCost()
        {
            //this is to make sure the user doesn't increase the amount of money by a certain value. 
            var oldCost = <?php echo $Cost; ?>;
            var newCost = $('#Cost').val();
            if (newCost > oldCost + 2);
            {
                alert('Have you inserted the right amount?!');
            }
           
        }




        
    </script>
    <style>
        body
        {

        }

        #divbody
        {
            width: 100%;
            height: 100%; 
            clear: both;
            background-color:#B4B5B8;

        }
        #imgdiv
        {
            width: 20%;     
            height: 64%;
            border: 2px solid #cccccc; 
            float: left;
        }
        #prodesc
        {
            width: 70%;
            height: 90%;
            float: left;

        }
        #table
        {
            border : 2px solid #cccccc;
            width: 80%;
            height: 65%;

        }
        tr
        {
            border : 2px solid #cccccc;   
        }
        .td
        {
            border : 2px solid #cccccc;   
        }
        tr:nth-child(even) {background-color: #D8D9D4;}


    </style>
    <body>
        <?php
        include_once 'erpTop.php';
        ?>

        <?php
        if ($errFlag == 1) {
            echo $errMsg;
        } else {
            ?>


            <div id='divBody'>
                <div id="imgdiv">
                    <img src='<?php echo $prodImagePath
            ?>'>
                </div>
                <div id="prodesc">
                    <h1> <?php echo $productDescriptshrt; ?> </h1>


                    <?php
//                 echo nl2br('Product Code');
//                     echo $productCode;
//                       echo 'Product Description';
//                       echo $productDescriptLng;
                    ?>


                    <table id='table'>
                        <tr>

                            <td>  <strong> Product Code:</strong>
                                <?php echo $productCode; ?> </td>
                        </tr>
                        <tr>
                            <td> <strong> Product Description Short: </strong>
                                <?php echo $productDescriptshrt; ?> </td>
                        </tr>

                        <tr>
                            <td>  <strong > Product Description Long: </strong>
                                <?php echo $productDescriptLng; ?>  </td>
                        </tr>
                        <tr>
                            <td> <strong > Product EAN: </strong> 
                                <?php echo $productEan; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Cost:</strong> 
                                <?php echo $Cost; ?></td>
                        </tr>
                        <tr>
                            <td> <strong> Retail Recommended Price:</strong> 
                                <?php echo $RRP; ?> </td>
                        </tr>
                        <tr>
                            <td> <strong> Weight:</strong> 
                                <?php echo $weight; ?></td>
                        </tr>
                        <tr>
                            <td> <strong> Category:</strong> 
                                <?php echo $productCat; ?></td>
                        </tr>


                    </table>
                    <input type='button' value='Edit' id='btnAmmend' onclick='DoEditNew()'>
                    <input type='hidden' id='ProductId' value='<?php echo $productId; ?>'>


                </div>
            </div>
            <div id='divEdit'>
                <form action='products.php' method='post'>
                    <div id='divAdd'>
                        <label for='productCode'> Product Code </label>
                        <input type='text' id='productCode' name='productCode' value='<?php echo $productCode; ?>'>
                        <br>
                        <div class="tbl">
                            <label for="productDescriptShrt"> Product Description Short </label>
                            <input type='text' id='productDescriptShrt' name='productDescriptShrt' maxlength='varchar50' value='<?php echo $productDescriptshrt; ?>' >
                        </div>
                        <div id='divtextarea'>

                            <!--                    <label for='productDescriptLng' > Product Description Long </label>-->
                            <p><strong>Product Description Long </strong></p>
                            <textarea id="productDescriptLng" name="productDescriptLng" value='<?php echo $productDescriptLng; ?>'> <?php echo $productDescriptLng; ?> </textarea> 
                        </div>
                        <div class="tbl">
                            <label for='productEan' > Product EAN </label>
                            <input type='text' id="productEan" name="productEan"value='<?php echo $productEan; ?>'> 
                        </div>
                        <div class="tbl">
                            <label form="Cost">Cost(&pound)</label>
                            <input type="text" id="Cost" name="Cost"value='<?php echo $Cost; ?>' onchange='userCost()'>
                        </div>
                        <div class="tbl">
                            <label form="RRP"> Retail Recommended Price</label>
                            <input type="text" id="RRP" name="RRP"value='<?php echo $RRP; ?>'> 
                        </div>
                        <div class="tbl">
                            <label form="Weight"> Weight</label>
                            <input type="text" id="Weight" name="Weight" value='<?php echo $weight; ?>'>
                        </div>
                        <div class="tbl">
                            <label for='productCat' > Product CAT </label>
                            <select  id="productCat"> 
                                <option value="Raw Materials" > Raw Materials </option>
                                <option value="Finished Product">Finished Product</option>    
                            </select>  
                            <br>
                            <input type='button' value='Ammend' id='btnAmmend' onclick='ammendProducts()'>



                        </div>



                    </div>
                    <br>
                </form>

            </div>

            /<?php
            include_once 'erpFooter.php';
            ?> 
        <?php } ?>




    </body>


</html>
