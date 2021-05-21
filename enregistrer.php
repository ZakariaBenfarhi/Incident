<?php
require_once 'redirectionIndex.php';

$con = new PDO('mysql:host=localhost;dbname=app_projet', 'root', '');

$cin = $_GET['cin'];
$rec = $_GET['rec'];
$email = $_SESSION['profil'];

$que_cin_dsi ="select cin from personne where email = '" . $email . "'";
$rs_cin_dsi = $con -> prepare($que_cin_dsi);
$rs_cin_dsi -> execute();
$data_cin_dsi = $rs_cin_dsi -> fetch();
    
$cin_dsi = $data_cin_dsi['cin'];




echo $cin_dsi . "<br><br><br>            " . $cin . "        <br><br>  " . $rec . "         ";

$que_aff = "insert into affecter (id_dsi, id_ts, num_recla) values ('$cin_dsi', '$cin', $rec)";
$rs_aff = $con -> prepare($que_aff);
$rs_aff -> execute();

$que_rec = "update reclamation set statut = 0 where num_recla =" . $rec;
$rs_rec = $con -> prepare($que_rec);
$rs_rec -> execute();

header("location:affecter.php");
?>