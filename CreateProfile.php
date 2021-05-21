<?php
require_once 'redirectionIndex.php';
require_once 'Menu.php';
require_once 'out.php';

$con = mysqli_connect('localhost', 'root', '', 'app_projet');


$que_sp = "select * from specialite s, departement d where s.id_dept = d.id_dept order by d.dept, s.id_dept";
$rs_que_spe = mysqli_query($con, $que_sp); 


?> 

<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css">
		<meta charset="utf-8">
	</head>
	<body>
		<div class="container col-md-6 col-md-offset-3" style="margin-top: 8%;">
			<form method="post" action="saveProfile.php" enctype="multipart/form-data">
				<div class="panel panel-info">
					<div class="panel-heading">Create New Profile :</div>
					<div class="panel-body">
						<div class="group-form"><br>
							<label class="label-form">CIN * </label>
							<input type="text" class="form-control" name="cin" placeholder="CIN..." required="required"/>
						</div><br><br>
						<div class="group-form">
							<label class="label-form">Nom * </label>
							<input type="text" class="form-control col-md-4" name="nom" placeholder="Nom..." required="required"/>
						</div><br><br><br>
						<div class="group-form">	
							<label class="label-form">Prenom * </label>
							<input type="text" class="form-control col-md-4" name="prenom" placeholder="Prenom..." required="required"/>
						</div><br><br><br>
						<div class="group-form">	
							<label class="label-form">Sexe * </label>
							<select class="form-control" name="sexe">
								<option value="Male">Male</option> 
								<option value="Female">Female</option>
							</select>
						</div><br><br>
						<div class="group-form">
							<label class="label-form">Telephone * </label>
							<input type="tel" class="form-control" name="phone" placeholder="Telephone..." required="required"/>
						</div><br>
						<div class="group-form">
							<label class="label-form">E-mail * </label>
							<input type="email" class="form-control" name="email" placeholder="E-mail..." required="required"/>
						</div><br>
						<div class="group-form">
							<label class="label-form">Ville d'Agence * </label>
							<input type="text" class="form-control" name="ville" placeholder="Ville..." required="required"/>
						</div><br>
						<div class="group-form">
							<label class="label-form">Adresse d'Agence * </label>
							<input type="text" class="form-control" name="adr" placeholder="l'adresse d'Agence..." required="required"/>
						</div><br>
						<div class="group-form">
							<label class="label-form">Specialite * </label>
							<select name="spe" class="form-control">
								<?php while ($fetch_spe = mysqli_fetch_array($rs_que_spe)) { ?>
								     <option value= " <?php echo $fetch_spe["id_spec"] ?>"> <?php echo $fetch_spe['dept'] . " - " . $fetch_spe["descrip"]?> </option>
								<?php } ?>
							</select>
						</div><br><br>
						<div class="group-form">
							<label class="label-form">Role du Profil * </label>
							<select name="role" class="form-control">
								<option value="Admin">Admin</option>
								<option value="Employe">Employe</option> 
								<option value="Technicien">Technicien</option> 
							</select>							
						</div><br>
						<div class="group-form">
							<label class="label-form">Photo </label>
							<input type="file" name="photo" class="form-control" />
						</div><br><br> 
						<div class="group-form">
							<input type="submit" value="Enregistrer" class="form-control btn btn-primary" />
						</div><br>
					</div><br>
				</div><br><br>
			</form>
		</div>
	</body>
</html>