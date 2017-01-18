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

            $("#dialog-confirm").dialog({
                resizable: false,
                height: "auto",
                width: 400,
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
        });


        var turn = 0;
        var scorePX = 0;
        var scorePO = 0;
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

            //alert(contents);
            //to see who has won
            var winLine = contents[0] + contents[1] + contents[2];
            if ((winLine == "XXX") || (winLine == "OOO")) {
                winner(winLine);
            }
            //alert('hi')
            winLine = contents[0] + contents[3] + contents[6];
            if ((winLine == "XXX") || (winLine == "OOO")) {
                winner(winLine);
            }
            winLine = contents[1] + contents[4] + contents[7];
            if ((winLine == "XXX") || (winLine == "OOO")) {
                winner(winLine);
            }
            winLine = contents[2] + contents[5] + contents[8];
            if ((winLine == "XXX") || (winLine == "OOO")) {
                winner(winLine);
                ;
            }
            winLine = contents[3] + contents[4] + contents[5];
            if ((winLine == "XXX") || (winLine == "OOO")) {
                winner(winLine);
            }
            winLine = contents[6] + contents[7] + contents[8];
            if ((winLine == "XXX") || (winLine == "OOO")) {
                winner(winLine);
            }
            winLine = contents[2] + contents[4] + contents[6];
            if ((winLine == "XXX") || (winLine == "OOO")) {
                winner(winLine);
            }
            winLine = contents[0] + contents[4] + contents[8];
            if ((winLine == "XXX") || (winLine == "OOO")) {
                winner(winLine);
            }
        }

        function winner(winLine)
        {
            if (winLine == "XXX")
            {
                scorePX++;
                $('#dialog-confirm').html('Player X has scored:' + scorePX +'Player O has scored:' + scorePO );
                $('#plyr1score').html('Player O :' + scorePO +'Player X :' + scorePX);
                $('#plyr2score').hide();
                
            }
            if (winLine == "OOO")
            {  
                scorePO++;
                $('#dialog-confirm').html('Player O has scored:' + scorePO +'Player X has scored:' + scorePX);
                $('#plyr2score').html('Player O:' + scorePO +'Player X:' + scorePX);
                 $('#plyr1score').hide();
           }


            $("#dialog-confirm").dialog("open");
        }


        function resetTable()
        {

            contents = ["", "", "", "", "", "", "", "", ""];
            //alert(contents);
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
    </style>
    <body>
      
        <div id='player1'>
            <p>
            <h2>Player 1</h2>  </p>
            <div id='plyr1score'>
           
        </div>
       
    </div>   
        
    <div id='player2'>
     
        <h2>Player 2</h2>
        <div id='plyr2score'>
            
        </div>
    </div>
    <div id='dialog-confirm'>

    </div>

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






</body>    





</html>