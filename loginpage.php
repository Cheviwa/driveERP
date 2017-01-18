<?php
$sqlConnection = null;
include_once 'config.php';

$sqlConnection = connectToDatabase();
if ($sqlConnection != null) {
    $sqlQuery = "SELECT * FROM login WHERE username= '$username',password='$password'";

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
        <title> </title>
        <meta charset="windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="jQuery/jquery-min.js"></script>
        <script src="jQuery/jquery-ui.min.js"></script>
        <link rel='stylesheet' type='text/css' href= 'jquery/jquery-ui.min.css'>
        
        <script>


            $(document).ready(function () {


            });
            function inputUsername()
            {
                var username = $('#username').val();
                var password = $('#password').val();


                $.ajax({
                    url: 'ajax/loginajax.php',
                    cache: false,
                    type: 'POST',
                    data: {

                        'request': 'login',
                        'username': username,
                        'password': password,
                    },
                    dataType: 'json',
                    success: function (data)
                    {
                        if (data.validLogin === 1) {
                            document.forms['frmLogin'].submit();
                        } else
                        {
                            alert('Invalid login');
                        }

                    },
                    error: function (data)
                    {

                        alert('error in calling ajax page');
                    }

                });

            }

        </script>
    </head> 
    <style>

        body{background-color: #f0f0f0;
        }

        input {
            font-size: 1.0em;
        }
        #labels 
        {
            margin: 50px auto;
            width: 60%;

        }
        .login 
        {
            position: relative;
            padding-left: 20%;
            padding-top: 5%;
            width: 50%;
        }
        input[type=text],input[type=password]{
            width: 100%;
            padding: 20px;
            margin: 8px 0;
            padding-left: 20%;
            display: inline-block;
            border: 1px solid;
            box-sizing: border-box;
        }
        button 
        {
            width: 40%;
            height: 5%;
            background-color: #666666;
            font-size: 1.0em;
        }
        form
        { border: 3px solid;
          width: 40%;
          margin-left:25%;
          margin-bottom: 25%;
          background-color: white;
        }


    </style>
    <body>

        <form name='frmLogin' action='homepage.php' method='post' id="frm">
            <div id='labels'>
                <div class='login'>  
                    <h2> Login </h2>
                    Username
                    <p>
                        <input type='text'id='username' name='username' placeholder="Enter username">
                    </p>
                    <label <b>Password</b> </label>
                    <p>
                        <input type='password'id='password' name ='password' placeholder="Enter password">
                    </p>

                    <button type='button' onclick='inputUsername()'>Login</button>

                </div>  
            </div>



        </form>


    </body>





</html>