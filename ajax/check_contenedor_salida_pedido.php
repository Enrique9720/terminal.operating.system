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

    $id_cita_carga = $_POST['id_cita_carga'];
    //echo $id_cita_carga;
    $num_contenedor = $_POST['num_contenedor'];
    //echo $num_contenedor;

    $railsider_model = new railsider_model();

    $contenedor_stock_check = $railsider_model->contenedor_en_stock($num_contenedor);
    if(count($contenedor_stock_check) > 0){//Contenedor en stock
      $stock_check = 1;
    }else{//Contenedor no en stock
      $stock_check = 0;
    }

    $linea_carga_list = $railsider_model->get_contenedor_salida_tren_pedido($id_cita_carga, $num_contenedor);
    if(count($linea_carga_list) > 0){//El contenedor esta en la cita de carga
      $linea_carga_check = 1;
    }else{//El contenedor no esta en la cita de carga
      $linea_carga_check = 0;
    }

    $data = null;

    $data = array(
      'num_contenedor' => $num_contenedor,
      'linea_carga_check' => $linea_carga_check,
      'stock_check' => $stock_check
    );

    echo json_encode($data);

?>
