<?php
$sqlConnection = null;
include_once 'config.php';


$sqlConnection = connectToDatabase();
if ($sqlConnection != null) {
    $sqlQuery = "SELECT * FROM Players";

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
        $(document).ready(function () {
    });
   
  
    function updateScore(){
            var playerName =   $('#username').val();
            var playerName2 = $('#username2').val();

            $.ajax({
                url: 'ajax/tictactoeAjax.php',
                cache: false,
                type: 'POST',
                data: {
                    'request': 'updateScore',
                    'playerName': playerName,
                    'playerName2': playerName2

                },
                dataType: 'json',
                success: function (data)
                {
                   document.forms['newGame'].submit();
                },
                error: function (data)
                {

                    alert('error in calling ajax page');
                }

            });
        }
//        function inputNewPlayer()
//        {
//        var username = $('#username').val();
//        var username2 = $('#username').val();
//        $.ajax({
//        url: 'ajax/tictactoeAjax.php',
//                cache: false,
//                type: 'POST',
//                data: {
//
//                'request': 'login',
//                        'playerName': username,
//                        'playerName2': username2,
//                },
//                dataType: 'json',
//                success: function (data)
//                {
//
//                document.forms['newGame'].submit();
//                },
//      
//                error: function (data)
//                {
//
//                alert('error in calling ajax page');
//                }
//
//        });
//    }
        
    </script>
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
        <form name='newGame' action='tictactoe2.php' method='post' id="frm">
            <div id='labels'>
                <div class='login'>  
                    <h2> Menu </h2>
                   Player 1 
                        <input type='text'id='username' name='username' placeholder="Enter username">
                    </p>
                    <label <b>Player2</b> </label>
                    <p>
                        <input type='text'id='username2' name ='username2' placeholder="Enter username">
                    </p>

                    <button type='button' onclick='updateScore()'>Play</button>

                </div>  

            </div>  
        </form>
    </body>





</html>