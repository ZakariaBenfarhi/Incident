<?php
require_once 'redirectionIndex.php';
require_once 'Menu.php';
require_once 'out.php';

$con = new PDO('mysql:host=localhost; dbname=app_projet', 'root', '');
$rec = $_GET['rec'];
$email = $_SESSION['profil'];


$que_tech_aff = "select * from affecter a, personne p, reclamation c, type_incident t where t.code_incedent = c.code_incedent and p.cin = a.id_ts and a.num_recla = c.num_recla and p.email = '" . $email . "' and a.num_recla = ". $rec; 
$rs_aff = $con -> prepare($que_tech_aff); 
$rs_aff -> execute(); 


$connection = "Presentiel";
?>

<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootsrap.min.css">
	</head>
	<body>
		<div class="col-md-10 col-md-offset-1" style="margin-top: 8%">
			<form method="get" action="resoRec.php">
				<div class="panel panel-info">
					<div class="panel-heading">Reclamation</div>
					<div class="panel-body">
						<?php while ($data = $rs_aff -> fetch()){ ?>
							<label class="label-form">Date Reclamation : <span style="color: blue;"><?php echo $data['date_recl'] ?></span></label><br>
							<label class="label-form">Ville & Adresse :  <span style="color: blue;"><?php echo $data['ville_trav'] . "  -  " . $data['adresse_entreprise'] ?></span></label><br>												
							<label class="label-form">L'Incident : <span style="color: blue;"><?php echo $data['type_incedent'] ?></span></label><br>
							<label class="label-form">Objet : <span style="color: blue;"><?php echo $data['objet'] ?></span></label><br>
							<label class="label-form">Description : <span style="color: blue;"><?php echo $data['description'] ?></span></label><br>
						<br><br>
							<?php if($data['statut_aff'] == 1 /* Affected */ ){ ?>
								<select name="connection" class="form-control">
									<option value="A Distance">A Distance</option> 
									<option value="Presentiel">Presentiel</option> 
								</select><br><br>
								
								<div class="">
									<a class="col-md-offset-1 col-md-2 alert alert-danger" style="text-align: center;" href="notsolved.php?rec=<?php echo $data['num_recla'] ?>&connection=<?php echo $connection ?>">Non Solved</a>
									<a class="col-md-offset-2 col-md-2 alert alert-info" style="text-align: center;" href="cours.php?rec=<?php echo $data['num_recla'] ?>&connection=<?php echo $connection ?>">En Cours</a>
									<a class="col-md-offset-2 col-md-2 alert alert-success" style="text-align: center;" href="solved.php?rec=<?php echo $rec ?>&connection=<?php echo $connection ?>">Solved</a>
								</div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>













