<?php
    //iniciamos sesion
	session_start();
	
	//borramos todas las variables de sesion
	session_destroy();
	header ("Location: ../controllers/login_controller.php");
?>