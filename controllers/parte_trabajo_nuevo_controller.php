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
$tipos_trabajos_list = $railsider_model->get_tipos_trabajos();
//echo "<pre>";
//print_r($tipos_trabajos_list);
//echo "</pre>";

//obtener tipos de trabajos desde BBDD
$tipos_incidencias_list = $railsider_model->get_tipos_incidencias();
//echo "<pre>";
//print_r($tipos_incidencias_list);
//echo "</pre>";


require_once('../views/parte_trabajo_nuevo_view.php');
