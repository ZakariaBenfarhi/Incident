<?php
//require_once 'Menu.php';


?>

<html>
	<head>
		<link type="text/css" rel="stylesheet" href="bootstrap.min.css">
	</head>
	<body>
		<div class="container col-md-4 col-md-offset-4" style="margin-top: 15%;">
			<div class="card">
				<div class="card-body">
					<form method="post" action="verif.php">
						<div class="group-form">
							<input type="text" class="form-control" name="email" placeholder="User Name or E-mail" required="required"/><br>
							<input type="password" class="form-control" name="pwd" placeholder="Password" required="required"/><br> 
							<input type="submit" class="form-control btn btn-primary" name="btn_log" value="Sign-in" /><br>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>









