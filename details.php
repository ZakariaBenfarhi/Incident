<?php
require_once 'redirectionIndex.php';
require_once 'Menu.php';
require_once 'out.php';

$email = $_SESSION['profil'];

$con = new PDO('mysql:host=localhost;dbname=app_projet', 'root', '');
$cin = $_GET['cin'];

// Récuperer les infos d'employe
$query = "select distinct * from personne p, departement d, specialite s where s.id_dept = d.id_dept and s.id_spec = p.id_spec and p.cin = '" . $cin . "'";
$rs = $con -> prepare($query);
$rs -> execute();

// Récuperer les infos Reclamations 
$que_rec = "select distinct * from personne p, reclamation c, type_incident t, departement d, specialite s where s.id_spec = p.id_spec and s.id_dept = d.id_dept and p.cin = c.id_emp and c.code_incedent = t.code_incedent and p.cin = '". $cin ."'";
$rs_rec = $con -> prepare($que_rec);
$rs_rec -> execute();
$cou_rec = $rs_rec -> rowCount();
?>

<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css">
		<meta charset="UTF-8">
		<meta http-equiv="pragma" content="no-cache" />
	</head>
	<body>
		<div class=" col-md-10 col-md-offset-1" style="margin-top: 8%;">
			<form method="get" action="details.php">
				<div class="panel panel-info">
					<div class="panel-heading"> Details Personnel :</div>
					<div class="panel-body">
					<?php while ($dataa = $rs -> fetch()) { ?>
						<div class="group-form">
							<div class="col-md-3">
								<img src="<?php echo ('img/'.$dataa['photo']) ?>" width="250" height="200" />
								<label>Last Update <?php echo $dataa['date_embauche'] ?></label>
							</div>
							<label class="" style="margin-top:0;font-size: 18px">Le Nom et Prenom : <span class="" style="color: blue;font-size: 18px"><?php echo $dataa['nom'] . " " . $dataa['prenom'] ?></span></label><br>
							<label class="" style="margin-top:0;font-size: 18px">Telephone : <span class="" style="color: blue;font-size: 18px"><?php echo $dataa['tele'] ?></span> -  E-mail : <span style="color: blue;font-size: 18px"><?php echo $dataa['email'] ?></span> </label><br>
							<label class="" style="margin-top:0;font-size: 18px">Role : <span class="" style="color: blue;font-size: 18px"><?php echo $dataa['role'] ?></span> - Activated : <span style="color: blue; font-size: 18px"><?php echo (($dataa['activate'] == 1)? "True" : "False" ) ?></span></label><br>
							<label class="" style="margin-top:0;font-size: 18px">Departement : <span style="color: blue;font-size: 18px"><?php echo $dataa['dept'] ?></span> - Specialite : <span style="color: blue; font-size: 18px"><?php echo $dataa['descrip'] ?></span></label><br>
							<label class="" style="margin-top:0;font-size: 18px">Ville : <span class="" style="color: blue;font-size: 18px"><?php echo $dataa['ville_trav'] ?></span> -  Adresse : <span style="color: blue;"><?php echo $dataa['adresse_entreprise'] ?></span></label><br>
							<?php if($dataa['role'] == 'Technicien'){ ?>
								<?php $que_tt = "select count(*) as tt from affecter a where a.id_ts = '" . $dataa['cin'] . "'"; ?>
								<?php $rs_tt = $con -> prepare($que_tt); ?>
								<?php $rs_tt -> execute(); ?>
								<?php $d_tt = $rs_tt -> fetch(); ?>
								
								<?php $que_stat_success = "select count(id_ts) as nb_suc, ROUND(count(id_ts) * 100 / ". $d_tt['tt'] .", 2) as cent_success from affecter a where a.id_ts = '" . $dataa['cin'] . "' and a.statut_aff = 2"; ?>
								<?php $rs_stat_success = $con -> prepare($que_stat_success); ?>
								<?php $rs_stat_success -> execute(); ?>
								<?php $d_success = $rs_stat_success -> fetch(); ?>
								
								<?php $que_stat_cours = "select count(id_ts) as nb_cours, ROUND(count(id_ts) * 100 / ". $d_tt['tt'] .", 2) as cent_cours from affecter a where a.id_ts = '" . $dataa['cin'] . "' and a.statut_aff = 1"; ?>
								<?php $rs_stat_cours = $con -> prepare($que_stat_cours); ?>
								<?php $rs_stat_cours -> execute(); ?>
								<?php $d_cours = $rs_stat_cours -> fetch(); ?>
								
								<?php $que_stat_fail = "select count(id_ts) as nb_fail, ROUND(count(id_ts) * 100 /". $d_tt['tt'] .", 2) as cent_fail from affecter a where a.id_ts = '" . $dataa['cin'] . "' and a.statut_aff = -1"; ?>
								<?php $rs_stat_fail = $con -> prepare($que_stat_fail); ?>
								<?php $rs_stat_fail -> execute(); ?>
								<?php $d_fail = $rs_stat_fail -> fetch(); ?>
								
								<label style="font-size: 18px" class="label-group">Statistiques en ( % ) : 
									<span class="text-success"><?php echo $d_success['cent_success'] . " Solved " ?></span> - 
									<span class="text-info"><?php echo  $d_cours['cent_cours'] . " En Cours " ?></span> - 
									<span class="text-danger"><?php echo $d_fail['cent_fail'] . " Failed " ?></span>							
								</label>
								<label style="font-size: 18px" class="label-group">Statistiques en ( Nombre d'Operations ) : 
									<span class="text-success"><?php echo $d_success['nb_suc'] . " Solved " ?></span> - 
									<span class="text-info"><?php echo  $d_cours['nb_cours'] . " En Cours " ?></span> - 
									<span class="text-danger"><?php echo $d_fail['nb_fail'] . " Failed " ?></span>							
								</label>
							<?php } ?>
						</div>
					<?php } ?>
					</div>
				</div>
				<div class="panel panel-info">
					<div class="panel-heading">Les Reclamations : ( <?php echo $cou_rec ?> Reclamations ) </div> 
					<div class="panel-body">
					<?php if($cou_rec != 0){ ?>
						<table class="table table-inverse">
							<tr>
								<th>Ref Reclamation </th>
								<th>Incident </th>
								<th>Objet</th>
								<th>Statut</th>
								<th>Details </th>
								<th>Cancel </th>		
							</tr>
							<?php while ($data_rec = $rs_rec -> fetch()) { ?>
							<tr <?php if($data_rec['statut']== 0) { ?>
									class="alert alert-secondary"
								<?php } elseif ($data_rec['statut'] == 1) { ?>
									class="alert alert-info"
								<?php } elseif ($data_rec['statut'] == 2) { ?>
									class="alert alert-success"
								<?php } else{ // -2 ?>
									class="alert alert-danger"
								<?php } ?>
							>
								<td><?php echo $data_rec['num_recla'] ?></td> 
								<td><?php echo $data_rec['type_incedent'] ?></td> 
								<td><?php echo $data_rec['objet'] ?></td> 
								<?php if($data_rec['statut']== 0) { ?>
									<td> Affected </td> 
								<?php } elseif ($data_rec['statut'] == 1) { ?>
									<td> En Cour </td>
								<?php } elseif ($data_rec['statut'] == -1) { ?>
									<td> Failed </td>
								<?php } elseif ($data_rec['statut'] == 2) { ?>
									<td> Success </td>
								<?php } else /* -2 */{ ?>
									<td> Not Affected Yet </td>
								<?php } ?>
								<td><a class="btn btn-info" href="infoRec.php?cin=<?php echo $data_rec['cin'] ?>&rec=<?php echo $data_rec['num_recla'] ?>">More Infos</a></td>
								<td>
								<?php if($data_rec['statut'] == -2 && $data_rec['email'] == $email){ ?>
									<a class="btn btn-danger" href="AnnulerRec.php?rec=<?php echo $data_rec['num_recla'] ?>">Annuler</a>
								<?php } ?>
							</td>
							</tr> 
							<?php } ?>
						</table>
					<?php } else { ?>
					    <?php echo '<div class="alert alert-success" style="font-size:18px; text-align:center"> There is No Reclamations </div>' ?>
					<?php } ?>
					</div>
				</div>
			</form> 
		</div>
	</body>
</html>












