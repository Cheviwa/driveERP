<?php ?>
<html>
    <head>
    </head>
 <link rel="stylesheet" href="css/bootstrap.min.css">
    <script>
        function logOut()
        {
            window.location.href = 'loginpage.php';
        }
        
    </script>
    <style>
        .navbar-header
        {
            color: black!important;
        }
        a
        {
            color: black !important;
        }
    </style>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Welcome</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href='homepage.php'>Home</a></li>
                    <li> <a href='products.php'> Products </a> </li>
                    <li> <a href='Orders.php'> Order </a> </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                   
                    <li id="logout" onclick="logOut()"><span class="glyphicon glyphicon-user"></span> Log Out </li>
                </ul>

            </div>    
        </nav>
        <!--        <div id='header'>
        
                    <ul>
                        >
        
        
                        <li>  My Purchases </li>
        
                        <li id="logout" onclick="logOut()"> Log Out </li>
                    </ul>
        
                </div>-->



    </body>



</html>