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
    $railsider_model = new railsider_model();
    $lineas_carga = $railsider_model->get_contenedores_salida_tren_pedidos($id_cita_carga);

    $data = null;
    foreach ($lineas_carga as $key => $linea_carga) {

      $num_contenedor = $linea_carga['num_contenedor'];

      $contenedor_salida_list = $railsider_model->contenedor_en_stock($num_contenedor);

      if(count($contenedor_salida_list) > 0){//si esta en stock
        foreach ($contenedor_salida_list as $key => $contenedor_salida_line) {
          $data[] = array(
            'num_contenedor' => $contenedor_salida_line['num_contenedor'],
            'id_tipo_contenedor_iso' => $contenedor_salida_line['id_tipo_contenedor_iso'],
            'longitud_tipo_contenedor' => $contenedor_salida_line['longitud_tipo_contenedor'],
            'descripcion_tipo_contenedor' => $contenedor_salida_line['descripcion_tipo_contenedor'],
            'nombre_comercial_propietario' => $contenedor_salida_line['nombre_comercial_propietario'],
            'peso_bruto_actual_contenedor' => $contenedor_salida_line['peso_bruto_actual_contenedor'],
            'descripcion_mercancia' => $contenedor_salida_line['descripcion_mercancia'],
            'picking_check' => $contenedor_salida_line['id_cita_carga_temp'],
            'stock_check' => "1"
        	);
        }
      }else{//si no esta en stock
        $contenedor_salida_sin_stock_list = $railsider_model->get_contenedor($num_contenedor);
        foreach ($contenedor_salida_sin_stock_list as $key => $contenedor_salida_sin_stock_line) {
          $data[] = array(
            'num_contenedor' => $contenedor_salida_sin_stock_line['num_contenedor'],
            'id_tipo_contenedor_iso' => $contenedor_salida_sin_stock_line['id_tipo_contenedor_iso'],
            'longitud_tipo_contenedor' => $contenedor_salida_sin_stock_line['longitud_tipo_contenedor'],
            'descripcion_tipo_contenedor' => $contenedor_salida_sin_stock_line['descripcion_tipo_contenedor'],
            'nombre_comercial_propietario' => $contenedor_salida_sin_stock_line['nombre_comercial_propietario'],
            'peso_bruto_actual_contenedor' => $contenedor_salida_sin_stock_line['peso_bruto_actual_contenedor'],
            'descripcion_mercancia' => $contenedor_salida_sin_stock_line['descripcion_mercancia'],
            'picking_check' => "0",
            'stock_check' => "0"
        	);
        }
      }

    }

    echo json_encode($data);

?>
