<?php

    //////////////////////////////////////////////////////////////////
    session_start();

    /////////////////////// CARGA DE MODELOS ////////////////////////////////////////////
    require_once("../models/railsider_model.php");
    /////////////////////////////////////////////////////////////////////////////////////

    if(isset($_POST['fecha']) && isset($_POST['hora']) && isset($_POST['cif_propietario']) && isset($_POST['num_expedicion'])
        && isset($_POST['observaciones'])){

        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $cif_propietario = $_POST['cif_propietario'];
        $num_expedicion = $_POST['num_expedicion'];
        $id_origen = $_POST['id_origen'];
        $id_destino = $_POST['id_destino'];
        $observaciones = $_POST['observaciones'];


        $railsider_model = new railsider_model();

        $result = $railsider_model->crear_cita_descarga($fecha, $hora, $cif_propietario, $num_expedicion, $id_origen, $id_destino, $observaciones);

        $response_array['status'] = 'success';
        $response_array['value'] = $result;

    }
    else {
        $response_array['status'] = 'error';
        $response_array['message'] = "Faltan campos";
    }

    echo json_encode($response_array);
?>
