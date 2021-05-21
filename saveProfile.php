<?php
require_once 'redirectionIndex.php';
require_once 'out.php';
require_once 'Menu.php';
$con = new PDO('mysql:host=localhost; dbname=app_projet','root', '');

$cin = $_POST['cin'];
$nom = $_POST['nom'];
$pre = $_POST['prenom'];
$sexe = $_POST['sexe'];
$tel = $_POST['phone'];
$mail = $_POST['email'];
$ville = $_POST['ville'];
$adr = $_POST['adr'];
$spe = $_POST['spe'];
$role = $_POST['role'];

$photo = $_FILES['photo']['name'];
$tmp_photo = $_FILES['photo']['tmp_name'];
move_uploaded_file($tmp_photo, "./img/$photo");

$login = $nom . "." . $pre; 
$pwd = $nom . "@" . $cin;



$query = "select * from personne where email = '" . $mail . "' or cin = '" . $cin . "'";

$statement = $con -> prepare($query);
$statement -> execute();
$count = $statement -> rowCount();
if($count != 0){
    $message = '<div class = "alert alert-danger" style="margin-top:10%; text-align:center; font-size:30px; paddin-top:30px;">This E-mail and / or CIN already used !!</div>';
    echo $message;
}
else{
    $sql = "insert into personne (cin, nom, prenom, sex, tele, email, ville_trav, role, photo, id_spec, adresse_entreprise, login, password) values ('$cin', '$nom','$pre', '$sexe','$tel','$mail','$ville', '$role', '$photo', $spe, '$adr', '$login', '$pwd')";
    $state = $con -> prepare($sql);
    $state -> execute();
    header("location:home.php");
}
  

?> 

<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css">
	</head>
	<body>
	
	
	</body>
</html>