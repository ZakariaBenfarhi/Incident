<?php
require_once 'redirectionIndex.php';
require_once 'Menu.php';
require_once 'out.php';

$con = new PDO('mysql:host=localhost; dbname=app_projet', 'root', '');
$que_inc = "select distinct * from type_incident";
$rs_inc = $con -> prepare($que_inc);
$rs_inc -> execute();


?>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css">
	</head>
	<body>
		<div class="col-md-10 col-md-offset-1" style="margin-top: 8%">
			<div class="panel panel-info">
				<div class="panel-heading">New Reclamation : </div>
				<div class="panel-body">
					<form method="post" action="NewReclamation.php">
						<div class="group-form">
							<label class="label-form">Incident * </label>
							<select class="form-control" name="inc">
								<?php while ($data_inc = $rs_inc -> fetch(pdo::FETCH_ASSOC)){ ?>
									<option value="<?php echo $data_inc['code_incedent'] ?>"><?php echo $data_inc['type_incedent'] ?></option>
								<?php } ?>
							</select><br>
						</div>
						<div class="group-form">
							<label class="label-form">Objet * </label>
							<input type="text" class="form-control" name="obj" required="required"/>
						</div><br>
						<div class="group-form">
							<label class="label-form">Message * </label>
							<textarea class="form-control" rows="6" cols="" name="mes" placeholder="Describ Your Situation .." required="required"></textarea>
						</div><br><br>
						<div class="group-form"> 
							<input type="submit" class="btn btn-primary form-control" value="Envoyer" />
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>