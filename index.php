<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////// CONTROL DE SEGURIDAD DE ACCESO AL DIRECTORIO ////////////////////////////////////
	//iniciamos la sesion
	session_start();
		
	//establecemos las variables de sesion para la ruta 
	if(!isset($_SESSION['ruta']) && !isset($_SESSION['ruta_php'])){
		$_SESSION['ruta'] = '/intranet/';
		$_SESSION['ruta_php'] = $_SERVER['DOCUMENT_ROOT'].$_SESSION['ruta'];
	}
	
	//comprobamos que el usuario esta logeado, si no lo mandamos al login
	if(isset($_SESSION['email']) && $_SESSION['email'] != ''){
		header ("Location: ".$_SESSION['ruta']."controllers/index_controller.php");
	} else {
		header ("Location: ".$_SESSION['ruta']."./modules/login/controllers/login_controller.php");
	}
	
?>


