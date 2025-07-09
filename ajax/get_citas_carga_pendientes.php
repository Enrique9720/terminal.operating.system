<?php

    session_start();

    //cargamos el modelo con la clase que interactua con la tabla
    require_once("../models/railsider_model.php");
    //cargamos las funciones PHP comunes para todas las apps
    require_once("../functions/functions.php");
    //comprobamos que el usuario esta logeado
    check_logged_user();

    $railsider_model = new railsider_model();
    $result = $railsider_model->get_citas_carga_pendientes();

    $response_array['status'] = 'success';
    $response_array['value'] = $result;

    echo json_encode($response_array);
?>
