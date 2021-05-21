<?php 
require_once 'redirectionIndex.php';
require_once 'Menu.php';
require_once 'out.php';
$email = $_SESSION['profil'];

$con = new PDO('mysql:host=localhost; dbname=app_projet', 'root', '') or (die(mysqli_error()));

// Checking Profiles Role 
$query = "select role from personne where email = '" . $email . "' and activate = 1";
$rs_query = $con -> prepare($query);
$rs_query -> execute();
$data = $rs_query -> fetch();
//


$spe = "select * from specialite";
$stat_spe = $con -> prepare($spe);
$stat_spe -> execute();

//Pagination ...
$size = 10;
if(isset($_GET['page'])){
    $page = $_GET['page'];
}
else {
    $page = 0;
}
$offset = $size * $page;

// Mot Clé Pour Le Filtrage
$search = "";

if(isset($_GET['search'])){
    $search = $_GET['search'];
    $query_search = "select p.* from personne p, specialite s , departement d where s.id_spec = p.id_spec and s.id_dept = d.id_dept and (p.email like '%$search%' or s.descrip like '%$search%' or d.dept like '%$search%' or p.cin = '$search' or p.nom like '%$search%' or p.prenom like '%$search%' or p.ville_trav like '%$search%' or p.role like '%$search%') order by p.date_embauche desc limit $size offset $offset";
}
else {
    $query_search = "select distinct * from personne order by date_embauche desc limit $size offset $offset";
}
$stat_search = $con -> prepare($query_search);
$stat_search -> execute();

// Récuperer le count d'enregistrements ..
$nb_pers = $stat_search -> rowCount();

// calculer Nombre de page à consommer ..
if($nb_pers % $size == 0){
    $nb_page = floor($nb_pers / $size); 
}
else {
    $nb_page = floor(($nb_pers / $size ) + 1);
}
?>
<?php if($data['role'] == 'Admin'){ ?>

<!-- ADMINISTRATION -->
<!-- ADMINISTRATION -->
<!-- ADMINISTRATION -->

<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		
	</head>
	<body>
		<div class=" col-md-10 col-md-offset-1" style="margin-top: 8%;">
			<form method="get" action="home.php">
				<div class="panel panel-info">
					<div class="panel-heading"> Filtring Profiles :</div>
					<div class="panel-body">
						<div class="group-form">
							<input type="text" class="form-control" name="search" placeholder="Search by Nom, Prenom, CIN, E-mail, Ville, Role, Description, Departement ...." value="<?php echo $search ?>" /><br><br>
							<input type="submit" class="form-control btn btn-primary" value="Search" />
						</div>
					</div> 
				</div>
				<div class="panel panel-info">
					<div class="panel-heading"> Profile : ( <?php echo $nb_pers ?> Resultats )</div>
					<div class="panel-body">
						<table class="container table table-responsive">
							<tr>
								<th>CIN</th> 
								<th>Nom</th> 
								<th>Prenom</th> 
								<th>Sexe</th> 
								<th>E-mail</th>
								<th>Ville</th> 
								<th>Photo</th>
								<th>Role</th> 
								<th>Statut</th> 
								<th></th> 
							</tr> 
							<?php while ($et = $stat_search -> fetch()) { ?>
							    <tr>
							    	<td><?php echo $et['cin'] ?></td> 
							    	<td><?php echo $et['nom'] ?></td> 
							    	<td><?php echo $et['prenom'] ?></td> 
							    	<td><?php echo ( ($et['sex']== 'Male')?'M':'F') ?></td>
							    	<td><?php echo $et['email'] ?></td>
							    	<td><?php echo $et['ville_trav'] ?></td>
							    	<td><img src="<?php echo 'img/' . $et['photo'] ?>" width="75" height="75"/></td>
							    	<td><?php echo $et['role'] ?></td> 
							    	<td>
							    		<?php if($et['activate'] == 1){ ?>
							    		 	<button class='btn btn-success'  value="<?php echo $et['cin'] ?>" disabled="disabled" >Activated</button>
							    		<?php } else { ?>
							    			<button class='btn btn-danger' value="<?php echo $et['cin'] ?>" disabled="disabled" >Not Activated</button>
							    		<?php } ?>
							    	</td> 
							    	<td>
							    		<a  class="btn btn-warning" href=<?php echo(($email != $et['email'])?('acti.php?cin='. $et["cin"]):('home.php'))?> >Enable / Disable</a>
							    	</td> 
							    	<td><a class="btn btn-info" href="Details.php?cin=<?php echo $et['cin'] ?>" >Details</a></td>
							    </tr>
							<?php } ?>
						</table>
					</div> 
				</div> 
				<div class="group-form">
					<ul class="nav nav-pills">
						<?php for($i=0; $i < $nb_page; $i++) { ?>
							<li class="<?php echo (($i==$page)?'active':'') ?>">
								<a href="home.php?page=<?php echo ($i) ?>&search=<?php echo ($search) ?>">Page <?php echo ($i+1) ?></a>
							</li>
						<?php } ?>
					</ul>
				</div><br><br>
			</form> 
		</div> 
	</body>
</html>
<?php } elseif ($data['role']== 'Employe'){ ?>

<!-- EMPLOYEES -->
<!-- EMPLOYEES -->
<!-- EMPLOYEES -->

<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css">
		<?php $que_emp_rec = "select * from personne p, reclamation c, type_incident t where p.cin = c.id_emp and c.code_incedent = t.code_incedent and p.email = '" . $email . "'"; ?>
		<?php $rs_emp_rec = $con -> prepare($que_emp_rec); ?>
		<?php $rs_emp_rec -> execute(); ?>
		<?php $count_emp_rec = $rs_emp_rec -> rowCount(); ?>
	</head>
	<body>
		<div class="col-md-10 col-md-offset-1" style="margin-top: 8%">
			<div class="panel panel-info">
				<div class="panel-heading">Reclamations ( <?php echo $count_emp_rec ?> Reclamations ) </div>
				<div class="panel-body">
					<!-- Testing Count du Reclamation -->
					<?php if($count_emp_rec != 0){ ?>
					<table class="table table-inverse">
						<tr> 
							<th>Ref Reclamation</th> 
							<th>Incident</th> 
							<th>Objet</th> 
							<th>Statut</th>
							<th>Dure (Jours)</th> 
							<th>Details</th> 
							<th>Cancel</th>
						</tr>
						<?php while ($data_emp_rec = $rs_emp_rec -> fetch()){ ?>
						<tr <?php if($data_emp_rec['statut']== 0) { ?>
									class="alert alert-light"
								<?php } elseif ($data_emp_rec['statut'] == 1) { ?>
									class="alert alert-info"
								<?php } elseif ($data_emp_rec['statut'] == 2) { ?>
									class="alert alert-success"
								<?php } else{ // -2 ?>
									class="alert alert-danger"
								<?php } ?>
						> 
							<td><?php echo $data_emp_rec['num_recla'] ?></td> 
							<td><?php echo $data_emp_rec['type_incedent'] ?></td> 
							<td><?php echo $data_emp_rec['objet'] ?></td>
								<?php if($data_emp_rec['statut']== 0) { ?>
									<td> Affected </td> 
								<?php } elseif ($data_emp_rec['statut'] == 1) { ?>
									<td> En Cour </td>
								<?php } elseif ($data_emp_rec['statut'] == -1) { ?>
									<td> Failed </td>
								<?php } elseif ($data_emp_rec['statut'] == 2) { ?>
									<td> Success </td>
								<?php } else /* -2 */{ ?>
									<td> Not Affected Yet </td>
								<?php } ?>
							
								<?php if($data_emp_rec['statut'] == 2 || $data_emp_rec['statut'] == -1 ){ ?>
										<?php $diff_rec_aff = "select datediff(a.date_aff, c.date_recl) as dure from reclamation c, affecter a where c.num_recla = a.num_recla and c.num_recla = " . $data_emp_rec['num_recla'];  ?>
										<?php $rs_diff_rec_aff = $con -> prepare($diff_rec_aff); ?>
										<?php $rs_diff_rec_aff -> execute(); ?>
										<?php $data_diff_rec_aff = $rs_diff_rec_aff -> fetch(); ?>
										<td>
											<?php echo $data_diff_rec_aff['dure'] ?>
										</td> 
								<?php } else { ?>
									<td></td> 
								<?php } ?>
							<td><a class="btn btn-primary" href="detail.php?rec=<?php echo $data_emp_rec['num_recla'] ?>">More Infos</a></td> 
							<td>
								<?php if($data_emp_rec['statut'] == -2){ ?>
									<a class="btn btn-danger" href="AnnulerRec.php?rec=<?php echo $data_emp_rec['num_recla'] ?>">Annuler</a>
								<?php } ?>
							</td>
						</tr>
						<?php } ?>
					</table>
					<?php } else { ?>
						<?php echo '<div class="alert alert-success"> No Reclamations Yet </div>' ?>
					<?php } ?>
				</div> 
			</div> 
		</div> 
	</body>
</html>
<?php } else { ?>

<!-- TECHNICIEN -->
<!-- TECHNICIEN -->
<!-- TECHNICIEN -->

<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css">
		<?php $que_tech_rec = "select * from personne p, reclamation c, type_incident t where p.cin = c.id_emp and c.code_incedent = t.code_incedent and p.email = '" . $email . "'"; ?>
		<?php $rs_tech_rec = $con -> prepare($que_tech_rec); ?>
		<?php $rs_tech_rec -> execute(); ?>
		<?php $count_tech_rec = $rs_tech_rec -> rowCount(); ?>
	</head>
	<body>
	<!-- Les Réclamations A Traiter -->
		<div class="col-md-10 col-md-offset-1" style="margin-top: 8%">
			<div class="panel panel-info">
			<?php $que_tech_aff = "select * from affecter a, personne p, reclamation c where p.cin = a.id_ts and a.num_recla = c.num_recla and ( a.statut_aff = 1 or a.statut_aff = 2 or a.statut_aff = -1) and p.email = '" . $email . "' order by a.date_aff desc"; ?>
			<?php $rs_aff = $con -> prepare($que_tech_aff); ?>
			<?php $rs_aff -> execute(); ?>
			<?php $cou_tech_aff = $rs_aff -> rowCount(); ?>
				<div class="panel-heading">A Traiter ( <?php echo $cou_tech_aff ?> Reclamations )</div>
				<div class="panel-body">
					<?php if($cou_tech_aff != 0){ ?>
					<div class="group-form">
						<table class="table table-inverse">
							<tr> 
								<th>Ref Reclamation</th> 
								<th>Ville</th> 
								<th>Objet</th>
								<th>Dure (Jours)</th>
								<th>Details</th>
							</tr>
							<?php while ($data_tech_aff = $rs_aff -> fetch()){ ?>
							<tr> 
								<td><?php echo $data_tech_aff['num_recla'] ?></td> 
								<td><?php echo $data_tech_aff['ville_trav'] ?></td> 
								<td><?php echo $data_tech_aff['objet'] ?></td> 
									<?php if($data_tech_aff['statut'] == 2 || $data_tech_aff['statut'] == -1 ){ ?>
										<?php $diff_rec_aff = "select datediff(a.date_aff, c.date_recl) as dure from reclamation c, affecter a where c.num_recla = a.num_recla and c.num_recla = " . $data_tech_aff['num_recla'];  ?>
										<?php $rs_diff_rec_aff = $con -> prepare($diff_rec_aff); ?>
										<?php $rs_diff_rec_aff -> execute(); ?>
										<?php $data_diff_rec_aff = $rs_diff_rec_aff -> fetch(); ?>
										<td>
											<?php echo $data_diff_rec_aff['dure'] ?>
										</td> 
									<?php } else { ?>
										<td></td> 
									<?php } ?>
								
								<td>
								<?php if($data_tech_aff['statut_aff']== 1 ){ ?>
									<a class="btn btn-info" href="resoRec.php?rec=<?php echo $data_tech_aff['num_recla'] ?>">En Cours</a>
								<?php } elseif ($data_tech_aff['statut_aff'] == 2) { ?>
									<a class="btn btn-success" href="resoRec.php?rec=<?php echo $data_tech_aff['num_recla'] ?>">Success</a>
								<?php } elseif ($data_tech_aff['statut_aff'] == -1){ ?>
									<a class="btn btn-danger" href="resoRec.php?rec=<?php echo $data_tech_aff['num_recla'] ?>">Not Solved</a>
								<?php } ?>
								</td> 
							</tr>
							<?php } ?>
						</table>
					</div>
					<?php } else { ?>
						<?php echo '<div class="alert alert-success>No Reclamations Yet</div>"' ?>
					<?php } ?>
				</div>
			</div>
			
		
			<div class="panel panel-info">
				<div class="panel-heading">Reclamations ( <?php echo $count_tech_rec ?> Reclamations ) </div>
				<div class="panel-body">
					<!-- Testing Count du Reclamation -->
					<?php if($count_tech_rec != 0){ ?>
					<table class="table table-inverse">
						<tr> 
							<th>Ref Reclamation</th> 
							<th>Incident</th> 
							<th>Objet</th> 
							<th>Statut</th> 
							<th>Details</th>
							<th>Cancel</th> 
						</tr>
						<?php while ($data_tech_rec = $rs_tech_rec -> fetch()){ ?>
						<tr <?php if($data_tech_rec['statut']== 0) { ?>
									class="alert alert-light"
								<?php } elseif ($data_tech_rec['statut'] == 1) { ?>
									class="alert alert-info"
								<?php } elseif ($data_tech_rec['statut'] == 2) { ?>
									class="alert alert-success"
								<?php } else{ // -2 ?>
									class="alert alert-danger"
								<?php } ?>
						> 
							<td><?php echo $data_tech_rec['num_recla'] ?></td> 
							<td><?php echo $data_tech_rec['type_incedent'] ?></td> 
							<td><?php echo $data_tech_rec['objet'] ?></td>
								<?php if($data_tech_rec['statut']== 0) { ?>
									<td> Affected </td> 
								<?php } elseif ($data_tech_rec['statut'] == 1) { ?>
									<td> En Cour </td>
								<?php } elseif ($data_tech_rec['statut'] == -1) { ?>
									<td> Failed </td>
								<?php } elseif ($data_tech_rec['statut'] == 2) { ?>
									<td> Success </td>
								<?php } else /* -2 */{ ?>
									<td> Not Affected Yet </td>
								<?php } ?>
							<td><a class="btn btn-primary" href="detail.php?rec=<?php echo $data_tech_rec['num_recla'] ?>">More Infos</a></td> 
							<td>
								<?php if($data_tech_rec['statut'] == -2){ ?>
									<a class="btn btn-danger" href="AnnulerRec.php?rec=<?php echo $data_tech_rec['num_recla'] ?>">Annuler</a>
								<?php } ?>
							</td>
						</tr>
						<?php } ?>
					</table>
					<?php } else { ?>
						<?php echo '<div class="alert alert-success"> No Reclamations Yet </div>' ?>
					<?php } ?>
				</div>
			</div> 
		</div>
	</body>
</html>
<?php } ?>









