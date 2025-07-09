<?php
    //////////////////////////////////////////////////////////////////
    session_start();

    //cargamos las funciones PHP comunes para todas las apps
    require_once("../functions/functions.php");

    //comprobamos que el usuario esta logeado
    check_logged_user();

    /////////////////////////////////////////////////////////////////////////////////////


    ///////////////////////*CARGA DE MODELOS*////////////////////////////////////////////
    require_once("../models/railsider_model.php");
    /////////////////////////////////////////////////////////////////////////////////////

    $railsider_model = new railsider_model();

    ////////////////////////////////////////////////////////////////

    //cargamos la vista
    require_once('../views/plan_semanal_view.php');
    //cargamos la vista modal
    require_once('../views/lineas_carga_contenedores_modal_view.php');
    //cargamos la vista modal del plan semanal
    require_once('../views/plan_semanal_modal_view.php');



?>
