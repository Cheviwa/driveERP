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
        var turn = "O";
        var boxes = ["", "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""];
        var noColumns = Math.sqrt(boxes.length);
        function input(boxNo)
        {

            //find the bottom cell for the row clicked....
            var bottomCell = boxNo;
            var boxId = "";
            var i = boxNo;
            while (i >= noColumns)
            {
                //get the bottom cell number
                i = i - noColumns;
            }
            var y = i;
            for (y = i; y < boxes.length; y = y + noColumns)
            {
                //check if empty cell
                if (boxes[y] == "")
                {
                    boxes[y] = turn;
                    boxId = "#box" + y;
                    $(boxId).html(turn);
                    if (turn == "O")
                        turn = "X";
                    else if (turn == "X")
                        turn = "O";

                    break;
                }
            }
//            if ( boxId < 12) 
//            {
//                alert('Oops Column full');
//                
//            }        
            if (boxes[y] != "" && boxes[y + 4] != "")
            {
                alert('column full');
            }

            var winLine = boxes[0] + boxes[4] + boxes[8] + boxes[12];
            {win

            winline = boxes[0] + boxes[4] + boxes[8] + boxes[12];

        }
    }


//        function checkWinner(winLine)
//        {
//            if (winLine == "OOOO")
//            {
//                alert('O is the winner');
//            }
//            if (winline == "XXXX")
//            {
//                alert('X is the winner');
//            }
//
//        }




    </script>
    <style>
        table
        {
            height: 70%;
            width: 70%;
            margin-left: 18%;
            border: 2px solid;
        }
        td 
        {
            width:120px;
            height: 120px;
            border: 2px solid;

        }



    </style>
    <body>

        <table>

            <tr>

                <td  id='box12' onclick='input(12)'>
                </td>
                <td  id='box13' onclick='input(13)'>
                </td>
                <td  id='box14' onclick='input(14)'>
                </td>
                <td  id='box15' onclick='input(15)'>
                </td>
            </tr>
            <tr>
                <td id='box8' onclick='input(8)'>
                </td>
                <td  id='box9' onclick='input(9)'>
                </td>
                <td id='box10' onclick='input(10)' >
                </td>
                <td  id='box11' onclick='input(11)'>
                </td>
            </tr>
            <tr>
                <td   id='box4' onclick='input(4)'>
                </td>
                <td   id='box5' onclick='input(5)'>
                </td>
                <td  id='box6' onclick='input(6)'>
                </td>
                <td  id='box7' onclick='input(7)'>
                </td>
            </tr>
            <tr>
                <td id='box0' onclick='input(0)'>
                </td>
                <td id='box1' onclick='input(1)'>
                </td>
                <td  id='box2' onclick='input(2)'>
                </td>
                <td  id='box3' onclick='input(3)'>
                </td>
            </tr>
        </table>




    </body>





</html>