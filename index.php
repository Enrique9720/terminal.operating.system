<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// CONTROL DE SEGURIDAD DE ACCESO AL DIRECTORIO ////////////////////////////////////
	//iniciamos la sesion
	session_start();
		
	//comprobamos que el usuario esta logeado, si no lo mandamos al login
	if(isset($_SESSION['email']) && $_SESSION['email'] != ''){
		header ("Location: ./controllers/login_controller.php");
	} else {
		header ("Location: ./controllers/login_controller.php");
	}
	
?>


