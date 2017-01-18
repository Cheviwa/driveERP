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
//            $(document).ready(function () {
//        ;
//        //dialog when player wins 
//        $("#dialog-confirm").dialog({
//        resizable: false,
//                height: 200,
//                width: 500,
//                modal: true,
//                autoOpen: false,
//                buttons: {
//                "Play again?": function () {
//                resetTable();
//                $(this).dialog("close");
//                },
//                        Cancel: function () {
//                        $(this).dialog("close");
//                        }
//                }
//            }
//        }); 
    var words = ["appletiser", "sparkling", "pen", "costa", "card", "book", "keyboard", "eight", "paper", "ten"];
//        function startGame()
//        {
//            var randWord = words[Math.floor(Math.random() * words.length)];
//            alert(randWord);
//          
//               var xpos = 0;
//               var linewidth = 50;
//               var nextpos = 20; 
//                for (i = 0; i < randWord.length; i++) 
//                {
//                    var canvas = document.getElementById("canvas");
//                    var ctx = canvas.getContext("2d");
//                    ctx.setLineDash([30, 20]);
//
//                    ctx.beginPath();
//                    ctx.moveTo(xpos, nextpos);
//                    ctx.lineTo(xpos, linewidth);
//                    ctx.stroke();
//                    xpos + 60;
//                    //break;
//                }
//        }
        function startGame()
        {
            var randWord = words[Math.floor(Math.random() * words.length)];
            //alert(randWord);
            if (randWord == "appletiser")
            {
                  $('#dialog-confirm').html('----------');


            }
            if (randWord == "sparkling")
            {
                alert('---------' + '9dashes');

            }
            if (randWord == "pen")
            {
                alert('---' + '3dashes');

            }
            if (randWord == "card")
            {
             alert('---' + '4 dashes');
            }
            if (randWord == "costa")
            {
                alert('-----' + '5 dashes');
              
            }
             if (randWord == "book")
            {
                alert('----' + '4 dashes');
              
            }
            
        }
        function checkAnswer(value)
        {
            var value = $('#word0').val();
            if (value == "appletiser")
                {
                alert('Correct');
            }
            if (value == "sparkling"){
                alert('Win');
            }
            if (value == "pen"){
                alert('Win');
            }
              if (value == "costa"){
                    alert('Correct');
                }
                 if (value == "appletiser")
                 {
                    alert('Win');
                }
                 if (value == "book")
                 {
                    alert('Win');
                }
              if (value == "keyboard")
                 {
                    alert('Correct!');
                }
        }
    </script>
    <style>
        #btnStart
        {
            width: 20%;
            height: 10%;

        }
        #table
        {
            width: 60%;
            height: 60%;
            border: 2px solid;
        }        
    </style>
    <body>

        <div id='table'>
            <input type='text'id='word0' maxlength='20'>
            <input type='submit' value='Submit'onclick='checkAnswer()'>
        </div>
        <div id='dialog-confirm'>

            </div> 


        <input type='button' value='START GAME'id='btnStart'onclick='startGame()'>
        <canvas id='canvas'></canvas>


    </body>





</html>