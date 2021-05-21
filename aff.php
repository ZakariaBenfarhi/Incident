<?php
require_once 'redirectionIndex.php';
require_once 'Menu.php';
require_once 'out.php';

$con = new PDO('mysql:host=localhost;dbname=app_projet', 'root', '');

$rec = $_GET['rec'];
$obj = $_GET['obj'];
$inc = $_GET['inc'];

$que_aff = "select distinct * from personne p, specialite s, departement d where p.role = 'Technicien' and s.id_dept = d.id_dept and p.id_spec = s.id_spec or ( d.dept like '%$obj%' or d.dept like '%$inc%' or s.descrip like '%$obj%' or s.descrip like '%$inc%')";         
$rs_aff = $con -> prepare($que_aff);
$rs_aff -> execute();
$cou_aff = $rs_aff -> rowCount();
?>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css">
	</head>
	<body>
		<div class="col-md-10 col-md-offset-1" style="margin-top: 8%">
			<form method="get" action="aff.php">
				<div class="panel panel-info">
					<div class="panel-heading"> Les Techniciens : ( <?php echo $cou_aff ?> ) </div>
					<div class="panel-body">
						<div class="group-form">
							<table class="table table-inverse">
								<tr>
									<th>CIN</th> 
									<th>Nom</th> 
									<th>Prenom</th> 
									<th>Departement</th>
									<th>Specialite</th>
									<th></th>
								</tr>
								<?php while ($data_aff = $rs_aff -> fetch()){ ?>
								<tr>
									<td><?php echo $data_aff['cin'] ?></td> 
									<td><?php echo $data_aff['nom'] ?></td> 
									<td><?php echo $data_aff['prenom'] ?></td> 
									<td><?php echo $data_aff['dept'] ?></td> 
									<td><?php echo $data_aff['descrip'] ?></td> 
									<td><a href="enregistrer.php?cin=<?php echo $data_aff['cin'] ?>&rec=<?php echo $rec ?>">Affecter</a></td>
								</tr>
								<?php } ?>
							</table>
						</div>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>