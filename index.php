<?php
include 'class_lib.php';
?>
<?php
$stefan = new person("Stefan Mischook");
$jimmy = new person ("Nick Waddles");
//using a constructor saves us from writting the code below 
//$stefan->set_name("Stefan Mischook");
//$jimmy-> set_name("Nick Waddles");
echo "Stefan's full name:".$stefan->get_name();
echo "Nick's full name:".$jimmy->get_name();
//direclty accessing properties in a class is a no no 
$james = new employee ("Johnny Fingers");
echo "New enployee".$james->get_name();



?>