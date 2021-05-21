<?php
$con = new PDO('mysql:host=localhost; dbname=app_projet', 'root', '');

require_once 'redirectionIndex.php';
require_once 'Menu.php';
require_once 'out.php';
$email = $_SESSION['profil'];




if(isset($_SESSION['profil'])){
     
    
    $query = "select * from personne where email = '" . $email . "'";
    $statement = $con -> prepare($query);
    $statement -> execute();
   
}

if(isset($_POST['save'])){
    $tel = $_POST['tele'];
    $log = $_POST['login'];
    $old = $_POST['old_pwd'];
    $new = $_POST['new_pwd'];
    $conf = $_POST['conf_pwd'];
    
    
    $que_verify = "select password from personne where email = '" . $email . "'";
    $rs_verify = $con -> prepare($que_verify);
    $rs_verify -> execute();
    $data_verify = $rs_verify -> fetch(pdo::FETCH_ASSOC);
    
    if($tel != "" && $log != "" && $old != "" && $new != "" && $conf != ""){
        if($new == $conf && $old == $data_verify['password']){
            $photo = $_FILES['photo']['name'];
            if($photo == ""){
                $que_update = "update personne set tele = '" . $tel . "', login = '" . $log . "', password = '" . $new . "' where email = '" . $email . "'";
                $rs_update = $con -> prepare($que_update);
                $rs_update -> execute();
                header("location:home.php");
            }
            else {
                $tmp_photo = $_FILES['photo']['tmp_name'];
                move_uploaded_file($tmp_photo, './img/'.$photo);
                $que_update = "update personne set tele = '" . $tel . "', login = '" . $log . "', password = '" . $new . "', photo = '". $photo ."' where email = '" . $email . "'";
                $rs_update = $con -> prepare($que_update);
                $rs_update -> execute();
                header("location:home.php");
            }
        }
        else {
            echo '<div style="text-align:center; font-size:18px; margin-top:6%" class="alert alert-danger"> Your Password is Wrong </div>';
        }
    }
    else {
        echo '<div style="text-align:center; font-size:18px; margin-top:6%" class="alert alert-danger"> All Fields are Required </div>';
    }
}

?>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css">
	</head>
	<body>
		<div class="col-md-10 col-md-offset-1" style="margin-top: 8%">
			<form method="post" action="compte.php" enctype="multipart/form-data">
			<?php while ($data = $statement -> fetch()) { ?>
				<div class="panel panel-info">
					<div class="panel-heading">Details : </div>
					<div class="panel-body">
						<div class="col-md-10 col-md-offset-1">
							<div class="group-form">
								<div class="col-md-4">
									<img src="./img/<?php echo $data['photo'] ?>" width="200" height="200">
								</div>
								<label class="">CIN : <span style="color: blue;"><?php echo $data['cin'] ?></span></label><br>
								<label class="">Nom & Prenom : <span style="color: blue;"><?php echo $data['nom'] . " - " . $data['prenom'] ?></span></label><br>
								<label class="">E-mail : <span style="color: blue;"><?php echo $data['email'] ?></span></label><br>
								<label class="">Ville & Adresse : <span style="color: blue;"><?php echo $data['ville_trav'] . " - " . $data['adresse_entreprise'] ?></span></label><br> 
								<label>Sexe : <span style="color: blue"><?php echo $data['sex'] ?></span></label>
							</div><br>
						</div> 
					</div> 
				</div>
				<div class="panel panel-info">
					<div class="panel-heading">Compte : </div>
					<div class="container panel-body">
					
						<div class="group-form">
							<label class="label-form">Telephone * </label>
							<input type="tel" class="form-control" name="tele" value="<?php echo $data['tele'] ?>" /><br>
						</div>
					
						<div class="group-form">
							<label class="label-form">Photo</label>
							<input type="file" name="photo" class="form-control"><br>
							<img src="img/<?php echo $data['photo'] ?>" width="100" height="100"><br><br>
						</div>
						<div class="group-form">
							<label class="label-form">Login</label>
							<input type="text" name="login" class="form-control" value="<?php echo $data['login'] ?>" /><br>
						</div>
						<div>
							<label class="label-form">Old Password </label>
							<input type="password" name="old_pwd" class="form-control" /><br>
						</div>
						<div>
							<label class="label-form">New Password </label>
							<input type="password" name="new_pwd" class="form-control" /><br>
						</div>
						<div>
							<label class="label-form">Confirm Password </label>
							<input type="password" name="conf_pwd" class="form-control" /><br>
						</div><br>
					
						<div class="group-control">
							<input type="submit" value="Save" name="save" class="form-control btn btn-primary"/>
						</div>
					</div><br>
				</div>
				<?php } ?>
			</form>
		</div>
	</body>
</html>








