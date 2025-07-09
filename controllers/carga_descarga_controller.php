<?php
//////////////////////////////////////////////////////////////////
session_start();

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");
require_once("../functions/carga_descarga_functions.php");

//comprobamos que el usuario esta logeado
check_logged_user();

/////////////////////////////////////////////////////////////////////////////////////

//cargamos la vista
//require_once('../views/carga_descarga_modal_view.php');
//cargamos la vista
require_once('../views/plan_semanal_view.php');