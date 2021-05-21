<?php
require_once 'redirectionIndex.php';
require_once 'Menu.php';
require_once 'out.php';

$con = new PDO('mysql:host=localhost;dbname=app_projet', 'root', '');

//Pagination ...
$size = 12;
if(isset($_GET['page'])){
    $page = $_GET['page'];
}
else {
    $page = 0;
}
$offset = $size * $page;

$search = "";

if(isset($_GET['search'])){
    $que = "select * from reclamation c, type_incident t where c.code_incedent = t.code_incedent and ( c.num_recla = $search or c.objet like '%". $search . "%' or c.description like '%" . $search . "%' or c.id_emp like '%" . $search ."%' or t.type_incedent like '%" . $search. "%') order by date_recl desc limit $size offset $offset ";     
}
else {
    $que = "select distinct * from reclamation c, type_incident t where c.code_incedent = t.code_incedent order by date_recl desc limit $size offset $offset ";  
}

$rs_que = $con -> prepare($que);
$rs_que -> execute();
$nb_pers = $rs_que -> rowCount();

// calculer Nombre de page à consommer ..
if($nb_pers % $size == 0){
    $nb_page = floor($nb_pers / $size);
}
else {
    $nb_page = floor(($nb_pers / $size ) + 1);
}
?>


<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css">
	</head>
	<body>
		<form method="get" action="liste.php">
		<div class="col-md-10 col-md-offset-1" style="margin-top: 9%">
			<div class="panel panel-info">
				<div class="panel-heading">Filtering : </div>
				<div class="panel-body">
					<div class="group-form">
						<input type="text" name="search" value="<?php echo $search ?>" class="form-control" placeholder="Ville, statut .." /><br>
						<input type="submit" value="Search" class="form-control btn btn-primary" />
					</div>
				</div>
			</div>
			<div class="panel panel-info">
				<div class="panel-heading">Reclamation : (<?php echo $nb_pers ?> Reclamations ) </div>
				<div class="panel-body">
					<?php while ($data = $rs_que -> fetch()){ ?>
					<div class="col-md-3">
						<div class="card card-info">
							<div class="card-header"><h3 style="color: blue">Ref Reclamation : <?php echo $data['num_recla'] ?></h3></div>
							<div class="card-body">
								<p>Objet : <?php echo $data['objet'] ?></p>
								<p>Incident : <?php echo $data['type_incedent'] ?></p>
									Statut :  
									<?php if($data['statut']== 0) { ?>
										<p class="btn btn-light">   Affected</p><br><br>
									<?php } elseif ($data['statut'] == 1) { ?>
										<p class="btn btn-info">   En Cour</p><br><br> 
									<?php } elseif ($data['statut'] == -1) { ?>
										<p class="btn btn-danger">   Failed</p><br><br>
									<?php } elseif ($data['statut'] == 2) { ?>
										<p class="btn btn-success">   Success</p><br><br>
									<?php } else /* -2 */{ ?>
										<p class="btn btn-danger">   Not Affected Yet</p><br><br>
									<?php } ?> 
								<p><a href="infoRec.php?cin=<?php echo $data['id_emp'] ?>&rec=<?php echo $data['num_recla'] ?>" class="form-control btn btn-info">More Infos</a></p>
							</div>
						</div>
					</div>
					<?php } ?>
					
				</div>
			</div>
			<div class="group-form">
				<ul class="nav nav-pills">
					<?php for($i=0; $i < $nb_page; $i++) { ?>
						<li class="<?php echo (($i==$page)?'active':'') ?>">
							<a href="liste.php?page=<?php echo ($i) ?>&search=<?php echo ($search) ?>">Page <?php echo ($i+1) ?></a>
						</li>
					<?php } ?>
				</ul>
			</div><br><br>
		</div>
		</form>
	</body>
</html>














