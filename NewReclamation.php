<?php
require_once 'redirectionIndex.php';
require_once 'Menu.php';
require_once 'out.php';

$con = new PDO('mysql:host=localhost;dbname=app_projet', 'root', '');

$email = $_SESSION['profil'];
$que_emp = "select cin from personne where email = '" . $email . "'";
$rs_emp = $con -> prepare($que_emp);
$rs_emp -> execute();
$data_emp = $rs_emp -> fetch();

$inc = $_POST['inc'];
$objet = $_POST['obj'];
$message = $_POST['mes'];
$emp = $data_emp['cin'];

echo "<br><br><br><br>". $inc . "<br>" . $objet . "<br>" . $message . "<br>" . $emp . "<br>";
if($inc != "" && $objet != "" && $message != "" && $emp != ""){
    $que_ins_rec = "insert into reclamation (code_incedent, objet, description, id_emp) values ($inc, '$objet', '$message', '$emp')";
    $rs_ins_rec = $con -> prepare($que_ins_rec);
    $rs_ins_rec -> execute();
    header("location:home.php");
}
else {
    header("location:reclamation.php");
}

?>