<?php
require_once 'redirectionIndex.php';
require_once 'Menu.php';
require_once 'out.php';

$con = new PDO('mysql:host=localhost;dbname=app_projet', 'root', '');

$que_rec_non_aff = "select * from reclamation c, type_incident t where c.code_incedent = t.code_incedent and statut = -2";
$rs_rec_non_aff = $con -> prepare($que_rec_non_aff);
$rs_rec_non_aff -> execute();
$cou = $rs_rec_non_aff -> rowCount();
?>

<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css">
	</head>
	<body>
		<div class="col-md-10 col-md-offset-1" style="margin-top: 8%">
			<form method="post" action="affecter.php">
				<div class="panel panel-info">
					<div class="panel-heading">Affectation des Reclamations : ( <?php echo $cou ?> Non Affecter )</div>
					<div class="panel-body">
					<?php if($cou != 0){ ?>
						<table class="table table-inverse">
							<tr> 
								<th>Ref Reclamation</th> 
								<th>Objet</th>
								<th>Incident</th>
								<th>Affectation</th>
							</tr>
							<?php while ($data_rec_non_aff = $rs_rec_non_aff -> fetch()){ ?>
								<tr>
									<td><?php echo $data_rec_non_aff['num_recla'] ?></td> 
									<td><?php echo $data_rec_non_aff['objet'] ?></td> 
									<td><?php echo $data_rec_non_aff['type_incedent'] ?></td> 
									<td><a href="aff.php?rec=<?php echo $data_rec_non_aff['num_recla'] ?>&obj=<?php echo $data_rec_non_aff['objet'] ?>&inc=<?php echo $data_rec_non_aff['type_incedent'] ?>" class="btn btn-success">Affecter</a></td>
								</tr>
							<?php } ?>
						</table>
					<?php } else { ?>
								<?php echo '<div class= "alert alert-success" style="text-align:center;font-size:18px;">No Reclamation for Today Hyper</div>' ?>
					<?php } ?>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>