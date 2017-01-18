<?php ?>
<html>
    <head>
    </head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" crossorigin="anonymous"></script>
    <script>
        function logOut()
        {
            window.location.href = 'loginpage.php';
        }
    </script>
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