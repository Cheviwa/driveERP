<?php ?>

<html>

    <head>
        <meta charset="windows-1252">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="jQuery/jquery-min.js"></script>
        <script src="jQuery/jquery-ui.min.js"></script>
        <link rel='stylesheet' type='text/css' href= 'css/style.css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css" 
              integrity="sha384-AysaV+vQoT3kOAXZkl02PThvDr8HYKPZhNT5h/CXfBThSRXQ6jW5DO2ekP5ViFdi"
              crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" 
                integrity="sha384-BLiI7JTZm+JWlgKa0M0kGRpJbF2J8q+qreVrKBC47e3K6BW78kGLrCkeRX6I9RoK" 
        crossorigin="anonymous"></script>
    </head>

    <body>
        <?php
        include_once'erpTop.php';
        ?>       
        <br>

        <div id='welcomeback'>

            <h1> Today's Top Tips</h1>
            <div id='main'>

                <h2>  Eating Healthy</h2>
                <img src='images/EatingSalad.png'width='200' height="200">
                <p>
                    Unhealthy eating habits have contributed to the obesity epidemic in the United States: about one-third of U.S. adults (33.8%)
                    are obese and approximately 17% (or 12.5 million) of children 
                </p>
                <h2 id="topics">Best Way To Start Your Day</h2>
                <img src='images/coffee.png'width='200' height="200">  
                <p>Give yourself at least 15 minutes of no screen time
                    Besides turning off an alarm that might be on your phone, resist the urge to check your email or social media....
            </div>


            <div id="welcome">
                <h1>Walkers Products  </h1>

            </div>
            <div id="forhim"> 
<!--                <img src='images/giorgio.png'width='300' height="300">
                <p>Giorgio <br> Armani code <br> Price: 30 </p>
                <img src='images/joop.png'width='300' height="300"> 
                <p> Joop! <br> Homme <br> Price: 28</p>-->
            </div>
            <div id="last">
                <!--                <h3> How Running Improves Your Health </h3>
                                <img src='images/Running Guy.png'width='200' height="200">  
                                <p>Running makes you happier.If you've been working out regularly, you've already discovered it: 
                                    No matter how good or bad you feel at any given moment, exercise will make you feel better</p>-->
            </div>

        </div>





        <?php
        include_once 'erpFooter.php';
        ?>
    </body>    





</html>