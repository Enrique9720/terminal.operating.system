<?php

    //////////////////////////////////////////////////////////////////
    session_start();

    /////////////////////// CARGA DE MODELOS ////////////////////////////////////////////
    require_once("../models/railsider_model.php");
    /////////////////////////////////////////////////////////////////////////////////////

    if(isset($_POST['fecha_min']) && isset($_POST['fecha_max'])){
        
        $fecha_min = $_POST['fecha_min'];
        $fecha_max = $_POST['fecha_max'];
        
        $railsider_model = new railsider_model();
        
        $result = $railsider_model->get_citas_descarga($fecha_min, $fecha_max);

        $response_array['status'] = 'success';  
        $response_array['value'] = $result;
        
    }
    else {
        $response_array['status'] = 'error';  
        $response_array['message'] = "Faltan campos"; 
    }
    
    echo json_encode($response_array);
?>