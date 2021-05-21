<?php
// detail reclamation d'un technicien
// detail reclamation d'un employe
require_once 'redirectionIndex.php';
require_once 'Menu.php';
require_once 'out.php';

$con = new PDO('mysql:host=localhost;dbname=app_projet', 'root', '');

// Recuperer Le Num du Reclamation
$rec = $_GET['rec'];

$query_rec = "select * from reclamation where num_recla = " . $rec;
$rs_rec = $con -> prepare($query_rec);
$rs_rec -> execute();
//$cou_rec = $rs_rec -> rowCount();
$data_rec = $rs_rec -> fetch();
$cin = $data_rec['id_emp'];

$query_aff = "select * from reclamation r, affecter a where a.num_recla = r.num_recla and r.num_recla = " . $rec;
$rs_aff = $con -> prepare($query_aff);
$rs_aff -> execute();
$cou_aff = $rs_aff -> rowCount();


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
				<?php if($cou_aff != 0){ ?>
				<div class="panel panel-info">
					<div class="panel-heading">Detail Du Reclamation : </div>
					<div class="panel-body">
						<div class="group-form">
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
										<span><?php echo '<div style="text-align:center; font-size:18px;" class="alert alert-light"> Affected </div>' ?></span> 
									<?php } elseif ($data['statut'] == 1) { ?>
										<span><?php echo '<div style="text-align:center; font-size:18px;" class="alert alert-info"> En Cour </div>' ?></span>
									<?php } elseif ($data['statut'] == -1) { ?>
										<span><?php echo '<div style="text-align:center; font-size:18px;" class="alert alert-danger"> Failed </div>' ?></span>  
									<?php } elseif ($data['statut'] == 2) { ?>
										<span><?php echo '<div style="text-align:center; font-size:18px;" class="alert alert-success"> Success </div>' ?></span>  
									<?php } else /* -2 */ { ?>
										<span><?php echo '<div style="text-align:center; font-size:18px;" class="alert alert-warning"> Not Affected Yet </div>' ?> </span>
									<?php } ?><br>
						    	<label class="label-form">Date Reclamation : <span style="color: blue"><?php echo $data['date_recl'] ?></span></label>
						    </div>
							<?php } ?>
						</div>
					</div>
				</div>
					<!--  -->
				<div class="panel panel-info">
				<?php $que_dsi = "select * from personne p, affecter a where a.id_dsi = p.cin and a.num_recla = " . $rec; ?>
				<?php $rs_dsi = $con -> prepare($que_dsi); ?>
				<?php $rs_dsi -> execute(); ?>
				<?php $que_ts = "select * from personne p, affecter a where a.id_ts = p.cin and a.num_recla = " . $rec; ?>
				<?php $rs_ts = $con -> prepare($que_ts); ?>
				<?php $rs_ts -> execute(); ?>
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
				<?php } else { ?>
				<div class="panel panel-info">
					<div class="panel-heading">Detail Du Reclamation : </div>
					<div class="panel-body">
						<div class="group-form">
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
										<span><?php echo '<div style="text-align:center; font-size:18px;" class="alert alert-light"> Affected </div>' ?></span> 
									<?php } elseif ($data['statut'] == 1) { ?>
										<span><?php echo '<div style="text-align:center; font-size:18px;" class="alert alert-info"> En Cour </div>' ?></span>
									<?php } elseif ($data['statut'] == -1) { ?>
										<span><?php echo '<div style="text-align:center; font-size:18px;" class="alert alert-danger"> Failed </div>' ?></span>  
									<?php } elseif ($data['statut'] == 2) { ?>
										<span><?php echo '<div style="text-align:center; font-size:18px;" class="alert alert-success"> Success </div>' ?></span>  
									<?php } else /* -2 */ { ?>
										<span><?php echo '<div style="text-align:center; font-size:18px;" class="alert alert-warning"> Not Affected Yet </div>' ?></span>
									<?php } ?><br>
						    	<label class="label-form">Date Reclamation : <span style="color: blue"><?php echo $data['date_recl'] ?></span></label>
						    </div>
							<?php } ?>
						</div>
					</div>
				</div>
				<?php } ?>
			</form>
		</div>
	</body>
</html>