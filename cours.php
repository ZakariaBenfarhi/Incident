<?php
$con = new PDO('mysql:host=localhost; dbname=app_projet', 'root', '');

$rec = $_POST['rec'];


$connection = $_POST['connection'];

$que_ok_rec = "update reclamation set statut = 1 where num_recla = " . $rec;
$rs_ok_rec = $con -> prepare($que_ok_rec);
$rs_ok_rec -> execute();

$que_ok_aff = "update affecter set statut_aff = 1 where num_recla = " . $rec;
$rs_ok_aff = $con -> prepare($que_ok_aff);
$rs_ok_aff -> execute();

$conn_ok_aff = "update affecter set connection = '" . $connection . "' where num_recla = " . $rec;
$rs_conn_ok_aff = $con -> prepare($conn_ok_aff);
$rs_conn_ok_aff -> execute();
header("location:home.php");