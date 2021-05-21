<?php
require_once 'redirectionIndex.php';
require_once 'out.php';

$con = new PDO('mysql:host=localhost;dbname=app_projet', 'root', '');
$rec = $_GET['rec'];

$que_del = "delete from reclamation where num_recla = " . $rec;
$rs_del = $con -> prepare($que_del);
$rs_del -> execute();

header("location:home.php");

?>