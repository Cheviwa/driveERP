<?php

$sqlConnection = null;
include_once 'config.php';
$errFlg = 0;
$errMsg = "";

$jsonVal = new stdClass();

$request = $_POST['request'];
$playerName = $_POST['playerName'];
$playerWins = $_POST['playerWins'];
$playerName2 = $_POST['playerName2'];
$playerX =$_POST['playerX'];
$playerO = $_POST['playerO'];
 //echo $playerName;
//$playerId = $_POST['playerId'];



$sqlConnection = connectToDatabase();

if ($request == "updateScore") {

    if ($sqlConnection != null) {

        $sqlQuery = "IF NOT EXISTS (SELECT * FROM Players WHERE PlayerName ='$playerName') " .
                " INSERT INTO Players (PlayerName) VALUES('$playerName') ";


        try {
            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();

        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();
            $errFlg = 1;
        }
        $sqlQuery = "IF NOT EXISTS (SELECT * FROM Players WHERE PlayerName ='$playerName2') " .
                " INSERT INTO Players (PlayerName) VALUES('$playerName2') ";
        try {
            $result = $sqlConnection->prepare($sqlQuery);
            $result->execute();
            $rs = $result->fetchAll();
            
        } catch (PDOExeption $e) {
            $errMsg = $e->getMessage();
            $errFlg = 1;
        }
    }
     
    $jsonVal->errMsg = $errMsg;
  
}

if ($request == "addScore") {
//increment Score of the player 

    if ($sqlConnection != null) {
 
            $sqlQuery = " UPDATE Players SET PlayerWins = PlayerWins +1 WHERE PlayerName ='$playerName'";
     //echo $sqlQuery;
            try {
                $result = $sqlConnection->prepare($sqlQuery);
                $result->execute();
                //get this player's current score
               $sqlQuery = "SELECT * FROM Players WHERE PlayerName= '$playerName'";
                $result = $sqlConnection->prepare($sqlQuery);
                $result->execute();
                $rs = $result->fetchAll();
                //puts player current into $playerscore returned by the jsonVal
                  foreach ($rs as $dataset) {
                  $playerscore = $dataset['PlayerWins'];
                }
       
            } catch (PDOExeption $e) {
                $errMsg = $e->getMessage();
                $errFlg = 1;
            }
            
            
    }
 
    $jsonVal->errMsg = $errMsg;
   $jsonVal->playerScore = $playerscore;
   
    }  




    $jsonVal->errMsg = $errMsg;
    echo json_encode($jsonVal);
?>