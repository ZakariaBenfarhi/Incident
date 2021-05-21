<?php
session_start();
if(!(isset($_SESSION['profil']))){
    header("location:index.php");
}
/*$email = $_SESSION['profil'];
$con = new PDO('mysql:host=localhost; dbname=app_projet', 'root', '');
$query = "select activate from personne where email = '" . $email . "'";
$rs = $con -> prepare($query);
$rs -> execute();
$et = $rs ->fetch(pdo::FETCH_ASSOC);

if($et['activate'] == 0){
    session_destroy();
    header("location:index.php");
}*/

?>