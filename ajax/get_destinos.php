<?php

    //////////////////////////////////////////////////////////////////
    session_start();

    /////////////////////// CARGA DE MODELOS ////////////////////////////////////////////
    require_once("../models/railsider_model.php");
    /////////////////////////////////////////////////////////////////////////////////////

    $velilla_model = new railsider_model();

    $result = $velilla_model->get_destinos();

    $response_array['status'] = 'success';
    $response_array['value'] = $result;

    echo json_encode($response_array);
?>
