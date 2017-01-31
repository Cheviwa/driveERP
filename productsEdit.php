<?php
$sqlConnection = null;
include_once 'config.php';


$prodId = $_POST['prodId'];
$prodCode = $_POST['productCode'];
$prodDescshrt = $_POST['productDescriptShrt'];
$prodDesclng = $_POST['productDescriptLng'];
$prodEAN = $_POST['productEan'];
$prodCat = $_POST['productCat'];
$cost = $_POST['Cost'];
$RRP = $_POST['RRP'];
$weight = $_POST['Weight'];

//echo $prodId;

if ($prodId != "") {
    //amending a product
    $sqlConnection = connectToDatabase();
    if ($sqlConnection != null) {


        $sqlQuery = "SELECT * FROM  product WHERE productID = $prodId";
//echo $sqlQuery;
        //$results = sqlsrv_query($sqlConnection,$sqlQuery);

        $result = $sqlConnection->prepare($sqlQuery);
        $result->execute();
        $rs = $result->fetchAll();
        //print_r($rs);
        foreach ($rs as $dataSet) {

            $productId = $dataSet['productId'];
            $productCode = $dataSet['ProductCode'];
            $productDescriptshrt = $dataSet['ProductDescShort'];
            $productDescriptLng = $dataSet['ProductDescLong'];
            $productEan = $dataSet['ProductEAN'];
            $productCat = $dataSet['ProductCat'];
            $Cost = $dataSet['Cost'];
            $RRP = $dataSet['RRP'];
            $weight = $dataSet['Weight'];
        }

        try {

            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();
            $errFlg = 1;
        }
    }
}
?>
<!DOCTYPE html>
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
            //checkError(<?php // echo $errFlg; ?>);
        });
        
    
        //this adds the user's input
        function AddNew()
        {
            
           //creating variables so they can be used in the ajax call to get a value from the user's input 
           //the # is the id from the input box
            var productCode = $('#productCode').val();
            var productDescriptionShrt = $('#productDescriptShrt').val();
            var productDescriptionLng = $('#productDescriptLng').val();
            var productEan = $('#productEan').val();
            var ProductCat = $('#productCat').val();
            var Cost = $('#Cost').val();
            var RRP = $('#RRP').val();
            var Weight = $('#Weight').val();
            $.ajax({
                //connecting this ajax to the appropriate page.
                url: 'ajax/products_ajax.php',
                cache: false,
                type: 'POST',
                data: {
                    //this puts the data from the variable into the ajax page
                    'request': 'insertProduct',
                    'productCode': productCode,
                    'productDescriptShrt': productDescriptionShrt,
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
                    if (productCode, productDescriptionShrt, productDescriptionLng, productEan, ProductCat, Cost, RRP, Weight === "")
                    {
                        alert('You have to enter a value in each form');
                        return false;
                    } else
                    {
                        window.location.href = 'products.php';
                    }
                },
                error: function (data)
                {

                    alert('error in calling ajax page');
                }

            });
        }
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
                    window.location.href = 'products.php';

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
        
        function userCost()
        {
//            var oldCost = <?php echo $Cost; ?>;
            var newCost = $('#Cost').val();
            if (newCost > oldCost + 2);
            {
                alert('Have you inserted the right amount?!');
            }
           
        }
        function validateEan()
        {
               var productEan = $('#productEan').val();
        $.ajax({
                url: 'ajax/products_ajax.php',
                cache: false,
                type: 'POST',
                data: {
                    //this puts the data from the variable into the ajax page
                    'request': 'clearEan',
                     'productEan': productEan
                  
                 
                },
                dataType: 'json',
                success: function (data)
                {
                    $('#productEAN').val('');
                        alert('i work');
                        

                },
                error: function (data)
                {

                    alert('error in calling ajax page');
                }

            });
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
        #productDescriptLng
        {
            width:15%;
            height: 50px;
        }
        #Cost
        {
            width: 50px;
        }
        #RRP
        {
            width: 50px;   
        }
        #Weight 
        {
            width: 50px; 
        }
        #divtextarea
        {
            width: 30%;

        }
    </style>
    <body>
        <?php
        include_once 'erpTop.php';
        ?>
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
                    <input type='text' id="productEan" name="productEan"value='<?php echo $productEan; ?>' onchange='validateEan()'> 
                </div>
                <div class="tbl">
                    <label form="Cost">Cost(&pound)</label>

                    <input type="text" id="Cost" name="Cost"value='<?php echo $Cost; ?>' onchange='userCost()'>

                </div>
                <div class="tbl">
                    <label form="RRP"> Retail Recommended Price(&pound)</label>
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


                </div>
                <?php if ($prodId != "") { ?>
                    <input type='button' value='Ammend' id='btnAmmend' onclick='ammendProduct()'>

                <?php } else { ?>
                    <input type='button' value='Add' id='btnAdd' onclick="AddNew()">
                <?php } ?>
                <input type='hidden' id='productId' value='<?php echo $prodId; ?>'>


            </div>
            <br>
        </form >

        <form action='imageupload.php' method='post' enctype='multipart/form-data'>

            <input type='file' name='productImage' accept='image/'>
            <br>
            <input type='submit' value='upload'>
            <input type='hidden' name='productId' value='<?php echo $prodId; ?>'>

        </form>





        <?php
        include_once 'erpFooter.php';
        ?>

    </body>    

</html>