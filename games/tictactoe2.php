<?php
$sqlConnection = null;
include_once 'config.php';
$errFlg = 0;
$errMsg = "";

$jsonVal = new stdClass();

$request = $_POST['request'];
$playerName = $_POST['username'];
$playerName2 = $_POST['username2'];
$playerIds = $_POST['playerId'];
$playerWins = $_POST['playerWins'];
$playerX = $playerName2;
$playerO = $playerName;


$sqlConnection = connectToDatabase();
if ($sqlConnection != null) {
    $sqlQuery = "SELECT * FROM Players WHERE PlayerName= '$playerName'";
    //$results = sqlsrv_query($sqlConnection,$sqlQuery);

    $result = $sqlConnection->prepare($sqlQuery);
    $result->execute();
    $rs = $result->fetchAll();
    foreach ($rs as $dataset) {
      $player1score = $dataset['PlayerWins'];
        
//       $player2 = $dataset['PlayerWins'];
    }
   // print_r($rs);
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
        ;
        //dialog when player wins 
        $("#dialog-confirm").dialog({
        resizable: false,
                height: 200,
                width: 500,
                modal: true,
                autoOpen: false,
                buttons: {
                "Play again?": function () {
                resetTable();
                $(this).dialog("close");
                },
                        Cancel: function () {
                        $(this).dialog("close");
                        }
                }
        });
        $('#player1').show();
        $('#player2').hide();
//            $('#table').hide();
        });
        var turn = 0;
        var scorePX = 0;
        var scorePO = 0;
        var playerName;
      var winLine;
        var playerO = '<?php echo $playerO; ?>';
        var playerX = '<?php echo $playerX; ?>';
        //player 0 = O
        //player 1 = X

        var contents = ["", "", "", "", "", "", "", "", ""];
        function input(boxNo)
        {
        //player clicked on a box
        var boxId = "#box" + boxNo;
        //alert(boxNo);
        //Is box empty ? - If no alert and exit
        var boxContent = $(boxId).html();
        if ($.trim(boxContent) != "")
        {
//                alert('invalid box');
        return;
        }
        //if empty - set it to the players char
        if (turn == 0)
        {
        $('#player2').show();
        $('#player1').hide();
        $(boxId).html("<img src='images/circle.png' width=50px height=50px id='image'>");
        turn = 1;
        contents[boxNo - 1] = "O";
        } else
        {
        //x's turn
        $('#player2').hide();
        $('#player1').show();
        $(boxId).html("<img src='images/playX.png' width=50px height=50px id='image2'>");
        turn = 0;
        contents[boxNo - 1] = "X";
        }
        
        //to see whos won X or O and then calls function to update the players score 
        winLine = contents[0] + contents[1] + contents[2];  
         //alert(contents);
        if (winLine == "XXX")
        {
      
        addScore(playerX);
        }
        if (winLine == "OOO")
        {
        addScore(playerO);       
        }
        winLine = contents[0] + contents[3] + contents[6];
        if (winLine == "XXX")
        {
        addScore(playerX);
        }
        if (winLine == "OOO")
        {
        addScore(playerO);
        }
        winLine = contents[1] + contents[4] + contents[7];
        if (winLine == "XXX")
        {
        addScore(playerX);
        }
        if (winLine == "OOO")
        {
        addScore(playerO);
        }

        winLine = contents[2] + contents[5] + contents[8];
        if (winLine == "XXX")
        {
        addScore(playerX);
        }
        if (winLine == "OOO")
        {
        addScore(playerO);
        }
        winLine = contents[3] + contents[4] + contents[5];
        if (winLine == "XXX")
        {
        addScore(playerX);
        }
        if (winLine == "OOO")
        {
        addScore(playerO);
        }
        winLine = contents[6] + contents[7] + contents[8];
        if (winLine == "XXX")
        {
        addScore(playerX);
        }
        if (winLine == "OOO")
        {
        addScore(playerO);
        }
        winLine = contents[2] + contents[4] + contents[6];
        if (winLine == "XXX")
        {
        addScore(playerX);
        }
        if (winLine == "OOO")
        {
        addScore(playerO);
        }
        winLine = contents[0] + contents[4] + contents[8];
        if (winLine == "XXX")
        {
        addScoreX(playerX);
        }
        if (winLine == "OOO")
        {
        addScore(playerO);
        }
        }
       

        function resetTable()
        {
        contents = ["", "", "", "", "", "", "", "", ""];
        //this resets the table when someone wins 
        $('#box1').html('');
        $('#box2').html('');
        $('#box3').html('');
        $('#box4').html('');
        $('#box5').html('');
        $('#box6').html('');
        $('#box7').html('');
        $('#box8').html('');
        $('#box9').html('');
        }
   //updating playerO's score
        function addScore(playerName)
        {
            //this updates winner's score.
        $("#dialog-confirm").dialog("open");
        //scorePO++;
        //var playerWins = scorePO;
       
        $.ajax({
        url: 'ajax/tictactoeAjax.php',
                cache: false,
                type: 'POST',
                data: {
                'request': 'addScore',
                        'playerName': playerName,
                        
                },
                dataType: 'json',
                success: function (data)
                {
             //this displays playerScore by using data.playerScore 
                $('#dialog-confirm').html('Winner has scored:' + data.playerScore);
                  //displays winner's
                $('#scorePO').html('Winner has Scored :'+ data.playerScore);
                
                },
                error: function (data)
                {

                alert('error in calling ajax page');
                }

        });
        }
 



    </script>
    <style>

        table
        {

            height: 70%;
            width: 70%;
            margin-left: 18%;


        }
        .boxes
        {
            height: 200px;
            border: 4px solid #990099;
            width: 200px;
        }

        #player1
        {
            height: 80px;
            width: 100px;
            margin-right: 250px;

        }
        #player2
        {
            height:80px;
            width: 100px;
            margin-right: 250px;
        }

        td 
        {
            width:120px;
            height: 120px;

        }
        #image
        {
            align-content: center;
            margin-left: 150px;   
        }
        #image2
        {
            align-content: center;
            margin-left: 150px;

        }
        #btnReset
        {
            width: 60px;
            height: 50px;
            float: left;
        }
        #plyr1score
        {
            width: 160px;
            height: 150px;
        }
        #plyr2score
        {
            width: 160px;
            height: 150px;
        }
        /*        button
                {
                    width: 30px;
                    height: 30px;
                    display: inline-block;
                }*/
        #dialog-confirm
        {
            width: 60px;
        }
        #scorePO
        {
            width: 240px; 
        }
    </style>
    <body>
        PLAYERS TURN
        <div id='player1'>
            <p>
            <h2> <?php echo $playerName; ?> </h2>  </p>
        <div id='plyr1score'>
            <div id='dialog-confirm'>

            </div> 
        </div>

    </div>   

    <div id='player2'>

        <h2><?php echo $playerName2; ?></h2>
        <div id='plyr2score'>

        </div>
    </div>

    <div id='updateScore'>
        <label for='playerName'> 1st Player: 
<?php echo $playerName; ?> </label> 
    
        <br> <label for='playerName'> 2nd Player: </label> 
<?php echo $playerName2; ?>  
        <div id='scorePO'> <p> </p></div>
    </div>
    
       
    <div id='table'>
        <table>
            <tr>
                <td class='boxes' id='box1' onclick='input(1)'>

                </td>

                <td class='boxes' id='box2' onclick='input(2)'>

                </td>

                <td class='boxes' id='box3' onclick='input(3)' >

                </td>
            </tr>

            <tr>
                <td class='boxes' class='boxes' id='box4' onclick='input(4)'>


                </td>

                <td class='boxes' class='boxes' id='box5' onclick='input(5)'>

                </td>

                <td class='boxes'class='boxes' id='box6' onclick='input(6)'>

                </td>
            </tr>

            <tr>
                <td class='boxes' class='boxes' id='box7' onclick='input(7)'>


                </td>

                <td class='boxes' class='boxes' id='box8' onclick='input(8)'>

                </td>

                <td class='boxes' class='boxes' id='box9' onclick='input(9)'>

                </td>
            </tr>
        </table>

    </div>




</body>    





</html>