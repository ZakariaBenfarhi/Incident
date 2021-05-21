<?php
require_once 'redirectionIndex.php';
require_once 'Menu.php';


$con = new PDO('mysql:host=localhost;dbname=app_projet', 'root', '');
$cin = $_GET['cin'];

$rec = $_GET['rec'];

$query = "select distinct * from personne p, reclamation c, type_incident t where p.cin = c.id_emp and c.code_incedent = t.code_incedent and p.cin = '" . $cin . "' and c.num_recla =" . $rec;
$rs = $con -> prepare($query);
$rs -> execute();

?>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css">
	</head>
	<body>
		<div class="col-md-10 col-md-offset-1" style="margin-top: 8%">
			<form action="">
				<div class="panel panel-info">
					<div class="panel-heading">Details Reclamation d'un Employe </div>
					<div class="panel-body">
						<?php while ($data = $rs -> fetch()) { ?>
						    <div class="form-group">
						    	<label class="label-form">Reference Du Reclamation : <span style="color: blue"><?php echo $data['num_recla'] ?></span></label><br> 
						    	<label class="label-form">Type Incident : <span style="color: blue"><?php echo $data['type_incedent'] ?></span></label><br> 
						    	<label class="label-form">Objet : </label><br> 
						    	<label class="label-form" style="color: blue"><?php echo $data['objet'] ?></label><br> 
						    	<label class="label-form">Description : </label><br> 
						    	<label class="label-form" style="color: blue"><?php echo $data['description'] ?></label><br> 
						    	<label class="label-form">Statut : </label><br>
						    		<?php if($data['statut']== 0) { ?>
										<span><?php echo '<div class="alert alert-light" style="font-size:18px;text-align:center" >Affected</div>' ?></span> 
									<?php } elseif ($data['statut'] == 1) { ?>
										<span><?php echo '<div class="alert alert-warning" style="font-size:18px;text-align:center">En Cours</div>' ?></span>
									<?php } elseif ($data['statut'] == -1) { ?>
										<span><?php echo '<div class="alert alert-danger" style="font-size:18px;text-align:center">Failed</div>' ?></span>  
									<?php } elseif ($data['statut'] == 2) { ?>
										<span><?php echo '<div class="alert alert-success" style="font-size:18px;text-align:center">Success</div>' ?></span>  
									<?php } else /* -2 */ { ?>
										<span><?php echo '<div class="alert alert-danger" style="font-size:18px;text-align:center">Not Affected Yet</div>' ?></span>
									<?php } ?><br>
						    	<label class="label-form">Date Reclamation :  <span style="color: blue"><?php echo $data['date_recl'] ?></span></label>
						    </div>
						<?php } ?>
					</div>
				</div>
				<?php $que_dsi = "select * from personne p, affecter a where a.id_dsi = p.cin and a.num_recla = " . $rec; ?>
				<?php $rs_dsi = $con -> prepare($que_dsi); ?>
				<?php $rs_dsi -> execute(); ?>
				<?php $cou_dsi = $rs_dsi -> rowCount(); ?>
				<?php $que_ts = "select * from personne p, affecter a where a.id_ts = p.cin and a.num_recla = " . $rec; ?>
				<?php $rs_ts = $con -> prepare($que_ts); ?>
				<?php $rs_ts -> execute(); ?>
				
				<?php if($cou_dsi != 0) { ?>
				<div class="panel panel-info">
					<div class="panel-heading">Reclamation Solved : </div>
					<div class="panel-body">
						<?php while ($data_dsi = $rs_dsi -> fetch()) { ?>
						<?php while ($data_ts = $rs_ts -> fetch()) { ?>
						    <div class="group-form">
						    	<label class="label-form">Nom et Prenom (DSI) : <span style="color: blue"><?php echo $data_dsi['nom'] . " " . $data_dsi['prenom'] ?></span></label><br>
						    	<label class="lebel-form">Nom et Prenom (TS) : <span style="color: blue"><?php echo $data_ts['nom'] . " " . $data_ts['prenom'] ?></span></label><br>
						    	<label class="label-form">Statut du Reclamation : </label><br>
						    		<?php if($data_dsi['statut_aff'] == 1){ ?>
						    			<span><?php echo '<div style="text-align:center; font-size:18px;" class="alert alert-warning"> En Cours </div>' ?></span>
						    		<?php } elseif ($data_dsi['statut_aff'] == -1){ ?>
						    			<span><?php echo '<div style="text-align:center; font-size:18px;" class="alert alert-danger"> Not Solved </div>' ?></span>
						    		<?php } else { // 2 ?>
						    			<span><?php echo '<div style="text-align:center; font-size:18px;" class="alert alert-success"> Solved </div>' ?></span>
						    		<?php } ?><br> 
						    	<label class="label-form">Last Update : <span style="color: blue"><?php echo $data_ts['date_aff'] ?></span></label>
						    </div>
						<?php } ?>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
			</form>
		</div>
	</body>
</html>