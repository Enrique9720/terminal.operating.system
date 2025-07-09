<?php
//////////////////////////////////////////////////////////////////
session_start();

//cargamos el codigo PHP que realiza la conexion a la BD
require_once("../models/conexion_db.php");

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");

//comprobamos que el usuario esta logeado
check_logged_user();
/////////////////////////////////////////////////////////////////////////////////////

///////////////////////*CARGA DE MODELOS*////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////

$railsider_model = new railsider_model();

$contenedores_list = $railsider_model->get_contenedores(); //TODOS LOS CONTENEDORES

//echo "<pre>";
//print_r($contenedores_list);
//echo "</pre>";

/////////////////////////////////////////////////////////
//cargamos la vista
require_once('../views/historico_contenedores_view.php');
