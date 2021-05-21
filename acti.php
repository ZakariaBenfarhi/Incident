<?php

$con = new PDO('mysql:host=localhost; dbname=app_projet', 'root', '');
$cin = $_GET['cin'];



$query = "select * from personne where cin = '" . $cin . "'";
$statement = $con -> prepare($query);
$statement -> execute();
$et = $statement -> fetch();
if($et['activate'] == 1){
    $false = "update personne set activate = 0 where cin = ?";
    $params_f = array($cin);
    $state_false = $con -> prepare($false);
    $state_false -> execute($params_f);
}
else {
    $true = "update personne set activate = 1 where cin = ?";
    $params_t = array($cin);
    $state_true = $con -> prepare($true);
    $state_true -> execute($params_t);
}
header("location:home.php");

?>