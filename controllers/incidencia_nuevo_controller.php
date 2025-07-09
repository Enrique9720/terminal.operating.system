<?php
//////////////////////////////////////////////////////////////////
session_start();

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");

//comprobamos que el usuario esta logeado
check_logged_user();

/////////////////////// CARGA DE MODELOS ////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////

$railsider_model = new railsider_model();

//obtener tipos de trabajos desde BBDD
$tipo_incidencia_list = $railsider_model->get_tipo_incidencia();
//echo "<pre>Tipo Incidencia: $tipo_incidencia_list</pre>";

//cargamos la vista
require_once('../views/incidencia_nuevo_view.php');
