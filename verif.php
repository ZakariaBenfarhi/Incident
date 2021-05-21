<?php
$con = new PDO('mysql:host=localhost; dbname=app_projet','root', '') ;


$mail = $_POST['email'];
$pwd = $_POST['pwd'];

$query = "select * from personne where (login='". $mail ."' or email = '" . $mail . "') and password = '" .  $pwd . "'";

$statement = $con -> prepare($query);
$statement->execute();
$count = $statement->rowCount();
$fetching  = $statement->fetch();
if( $count != 0 && $fetching['activate'] == 1 && $fetching['role'] == 'Admin'){
    session_start();
    $_SESSION['profil'] = $fetching['email'];
    header("location:home.php");
}
elseif ($count != 0 && $fetching['activate'] == 1 && $fetching['role'] == 'Employe'){
    session_start();
    $_SESSION['profil'] = $fetching['email'];
    header("location:home.php");
}
elseif ($count != 0 && $fetching['activate'] == 1 && $fetching['role'] == 'Technicien'){
    session_start();
    $_SESSION['profil'] = $fetching['email'];
    header("location:home.php");
}
elseif ($count != 0 && $fetching['activate'] == 0){
    $message = '<div class="alert alert-danger" style="margin-top:10%; text-align:center; font-size:30px; paddin-top:30px;"> This Account Has Been Disabled, Please Contact The Administration !! </div>';
    echo $message;
}
elseif ($mail == "" || $pwd == ""){
    $message = '<div class="alert alert-danger" style="margin-top:10%; text-align:center; font-size:30px; paddin-top:30px;"> The E-mail or User Name and Password are REQUIRED !! </div>';
    echo $message;
}
else {
    header("location:index.php");
}

?>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css">
	</head>
	<body>
	
	</body>
</html>
