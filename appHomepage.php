<html>

    <!DOCTYPE html>
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
        <script>
            $(document).ready(function () {

//                $('#dropdowndivs').hide();

              $.ajax({
            url: 'ajax/app_ajax.php',
            cache: false,
            type: 'POST',
            data: {

                'request': 'getProducts'
                
            },
            dataType: 'json',
            success: function (data)
            {
                for (var i = 0; i < data.resultArray.length; i++) {
                    $('#dropdowndivs').append( '<br>' + data.resultArray[i].ProductDescShort  + '<br>' + 'Price' + data.resultArray[i].RRP + "<img src='images/basket.png'width=10px height=10px'>" 
                     );
                }

            },
            error: function (data)
            {

                alert('error in calling ajax page');
            }

        });

    });    
           
        </script>
        <style>
            #wrapper
            {
                width: 100%;
                background-color: F5F5F5;
                height: 150%;
                
      
            }
            #header
            {
                width: 100%;
                height: 5%;
                background-color:#68EFAD;
                border:2px solid #68EFAD;
            }
            #home
            {
                width: 100%
            }
            #Homebtn
            {
                width: 20%;
                height: 5%;
                color: white;
                font-size: 1em;
                margin-left: 37%;
                background-color: black;
                border: none;
                text-align: left;
                

            }
            #dropdowndivs
            {
          
                width: 31%;
                height: 100%;
                font-size: 1em;
                right: 80%;
             }
             #divtester
             {
               width: 31%;
                height: 100%;
                font-size: 1em;
                right: 80%;  
             }
        .divDropdowns
            {
                padding-bottom:10%;
                border: 1px solid black;
                border-radius: 12px;
                text-align: center;
                
                 }
                
            
              
                  </style>
        <body>
            <div id='wrapper'>
                <div id='header'> <h3> Walkers Crisps </h3> </div>
<!--                <div id='home' class="btn-group-vertical" role='group'>
                    <button type="button" class='btn btn-primary btn-md'id='Homebtn' onclick="showDivs()"> Home</button>
                </div>
-->                <div id='dropdowndivs'><!--
                    <div class="divDropdowns" > Products </div>
                     <div class="divDropdowns">  Order Enquiry </div>
                   <div class="divDropdowns"> Basket </div>
                   <div class="divDropdowns"> Contact </div>
-->            </div>
<div id='divtester'> </div>

        </body>












    </html>