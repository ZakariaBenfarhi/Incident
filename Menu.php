<?php 
$con = new PDO('mysql:host=localhost; dbname=app_projet', 'root', '');
$email = $_SESSION['profil'];
$query = "select role from personne where email = '" . $email . "' and activate = 1";
$rs_query = $con -> prepare($query);
$rs_query -> execute();
$data = $rs_query -> fetch();

?>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css">
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
		<?php if($data['role'] == 'Admin'){ ?>
			<ul class="nav navbar-nav">
				<li><a href="home.php">Home</a></li>
				<li><a href="liste.php">Lister Reclamation</a></li>
				<li><a href="affecter.php">Affecter</a></li>
				<li><a href="Reclamation.php">Reclamer</a></li> 
				<li><a href="CreateProfile.php">Profiles</a></li> 
				<li><a href="Compte.php" style="margin-left: 650px" class="position-absolute">Mon Compte</a></li> 
				<li><a href="LogOut.php" style="margin-left: 30" class="position-absolute">Log Out [ <?php echo ((isset($_SESSION['profil']))?($_SESSION['profil']):"") ?> ]  </a></li> 
			</ul>
		<?php } elseif ($data['role'] == 'Employe'){ ?>
			<ul class="nav navbar-nav">
				<li><a href="home.php">Home</a></li>
				<li><a href="Reclamation.php">Reclamation</a></li> 
				<li><a href="Compte.php" style="left: 850%" class="position-absolute">Mon Compte</a></li> 
				<li><a href="LogOut.php" style="left: 500%" class="position-absolute">Log Out [ <?php echo ((isset($_SESSION['profil']))?($_SESSION['profil']):"") ?> ]  </a></li> 
			</ul>
		<?php } else { ?>
			<ul class="nav navbar-nav">
				<li><a href="home.php">Home</a></li>
				<li><a href="Reclamation.php">Reclamation</a></li> 
				<li><a href="Compte.php" style="left: 750%" class="position-absolute">Mon Compte</a></li> 
				<li><a href="LogOut.php" style="left: 300%" class="position-absolute">Log Out [ <?php echo ((isset($_SESSION['profil']))?($_SESSION['profil']):"") ?> ]  </a></li> 
			</ul>
		<?php } ?>
		</div>
	</body>
</html>