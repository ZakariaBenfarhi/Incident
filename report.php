<?php
require_once 'redirectionIndex.php';
require_once 'Menu.php';
require_once 'out.php';

$email = $_SESSION['profil'];
$con = new PDO('mysql:host=localhost; dbname=app_projet', 'root', '');

$que_ts = "select cin from personne where email = '" . $email . "' and role = 'technicien'";
$rs_ts = $con -> prepare($que_ts);
$rs_ts -> execute();
$data_ts = $rs_ts -> fetch();

$ts = $data_ts['cin'];

$que_rec = "select num_recla from affecter where id_ts = '" . $ts . "' and statut_aff = -1 limit 1";
$rs_rec = $con -> prepare($que_rec);
$rs_rec -> execute();
$data_rec = $rs_rec -> fetch();
$rec = $data_rec['num_recla'];

if(isset($_POST['send'])){
    
    try {
        
        $obj = $_POST['obj'];
        $msg = $_POST['message'];
        
        //echo "<br><br><br><br>". $ts . "   \n" . $obj . "    \n" . $msg . "    \n" . $rec;
        
        $que_rep = "insert into report (id_ts, num_recla, objet, message) values ('$ts', $rec, '$obj', '$msg')";
        $rs_rep = $con -> prepare($que_rep);
        $rs_rep -> execute();
        
        echo '<div class="alert alert-success" style="margin-top:8%; text-align:center; font-size:18px;"> Your Message Has Been Send Successfully </div>';
    } catch (Exception $e) {
        echo '<div class=" alert alert-danger" style="margin-top:8%; text-align:center; font-size:18px;"> Your Message Has Not Send :( You May have to try again later </div>';
    }
    
}

?>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css">
	<body>
		<div class="col-md-8 col-md-offset-2" style="margin-top: 8%">
			<div class="panel panel-info">
				<form method="get" action="">
					<div class="panel-heading">Report : </div>
					<div class="panel-body">
						<div class="group-form">
							<input type="text" class="form-control" name="obj" placeholder="l'Objet Generale .." /><br><br>
							<textarea name="message" rows="5" class="form-control" placeholder="Votre Message, les Arguments à propos cette Reclamation ..."></textarea><br>
						</div><br>
						<div class="group-form">
							<input type="submit" value="Send" name="send" class="form-control btn btn-primary" />
						</div>
					</div>
				</form>
			</div>
		</div>
	</body>
</html>