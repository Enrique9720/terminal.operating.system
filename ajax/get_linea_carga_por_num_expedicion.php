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

    $num_expedicion = $_POST['num_expedicion'];

    $railsider_model = new railsider_model();
    $contenedores_list = $railsider_model->get_linea_carga_por_num_expedicion($num_expedicion);
    //echo "<pre>";
    //print_r($contenedores_list);
    //echo "</pre>";

    //si hay datos
  	if(count($contenedores_list) > 0){
  		foreach ($contenedores_list as $key => $value) {

        $data[] = array(
                'num_expedicion' => $num_expedicion,
              	'id_linea_carga' => $value['id_linea_carga'],
                'id_cita_carga' => $value['id_cita_carga'],
    						'num_contenedor' => $value['num_contenedor'],
    						'id_tipo_contenedor_iso' => $value['id_tipo_contenedor_iso'],
    						'longitud_tipo_contenedor' => $value['longitud_tipo_contenedor'],
    						'descripcion_tipo_contenedor' => $value['descripcion_tipo_contenedor'],
                'cif_propietario_actual' => $value['cif_propietario_actual'],
                'nombre_comercial_propietario_actual' => $value['nombre_comercial_propietario_actual'],
    						'pos_contenedor_temp' => $value['pos_contenedor_temp'],
    						'num_vagon_temp' => $value['num_vagon_temp'],
    						'pos_vagon_temp' => $value['pos_vagon_temp'],
                'text' => 'Hay resultados'
            );
  		}

    } else {
  		$data[] = array('num_expedicion' => $num_expedicion, 'text' => 'No hay resultados');
  	}

    echo json_encode($data);
?>
