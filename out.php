<?php
$email = $_SESSION['profil'];
$con = new PDO('mysql:host=localhost; dbname=app_projet', 'root', '');
$query = "select activate from personne where email = '" . $email . "'";
$rs = $con -> prepare($query);
$rs -> execute();
$et = $rs ->fetch(pdo::FETCH_ASSOC);

if($et['activate'] == 0){
    require_once 'redirectionIndex.php';
    require_once 'LogOut.php';
}
else {
    
}
?>