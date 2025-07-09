<?php
    //////////////////////////////////////////////////////////////////
	session_start();

	//cargamos el codigo PHP que realiza la conexion a la BD
	require_once("../models/conexion_db.php");

    //cargamos las funciones PHP comunes para todas las apps
    require_once("../functions/functions.php");

    //cargamos el modelo
    require_once("../models/railsider_model.php");
    
	//comprobamos que el usuario esta logeado
    check_logged_user();

    /////////////////////////////////////////////////////////////////////////////////////

    //cargamos la vista
	require_once('../views/salida_tren_view.php');

?>
