<!DOCTYPE html>
<html lang="en">

<head>

	<title>Login Usuario</title>
	<?php
	//Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
	require_once('../tpl/header_includes.php');
	require_once('../functions/functions.php');
	?>

	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="../css/login.css" type="text/css" />

</head>

<body>

	<div class="container">
		<div class="d-flex justify-content-center h-100">
			<div class="card">
				<div class="card-header" style="text-align: center;padding-top:20px;">
					<!--<h1 style="font-size: 5em; color: white; text-align: center; text-shadow: 2px 2px 4px #000000; font-family: 'Harabara';">MSTerminal</h1>-->

					<table style="width:100%">
						<tr>
							<td>
								<img src="../images/logogms_2.png" style="height:100px;image-rendering: crisp-edges;" />
							</td>
						</tr>
					</table>

				</div>

				<div class="card-body">

					<form action="../controllers/login_controller.php" method="post">

						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fas fa-user"></i></span>
							</div>
							<input type="text" id="email" class="form-control" name="email" placeholder="Correo electr&oacute;nico">

						</div>

						<div class="input-group form-group">
							<div class="input-group-prepend">
								<span class="input-group-text"><i class="fas fa-key"></i></span>
							</div>
							<input type="password" id="password" name="password" class="form-control" placeholder="Contrase&ntilde;a">

						</div>

						<div class="form-group">
							<input type="submit" value="Login" class="btn float-right login_btn">
						</div>

					</form>

					<?php

					//mensaje de error si login fallido
					if (isset($_SESSION['error_login'])) {
						if ($_SESSION['error_login'] != '') {
							echo "<span style='color:white'><b>" . $_SESSION['error_login'] . "</b></span>";
							//php_alert_message('danger', $_SESSION['error_login']);
						} else {
							echo "<span>XXX</span>";
						}
					}

					?>

				</div>

			</div>
		</div>
	</div> <!-- #container -->
</body>

</html>
