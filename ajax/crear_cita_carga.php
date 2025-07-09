<?php

    //////////////////////////////////////////////////////////////////
    session_start();

    /////////////////////// CARGA DE MODELOS ////////////////////////////////////////////
    require_once("../models/railsider_model.php");
    /////////////////////////////////////////////////////////////////////////////////////

    //echo "<pre>";
    //print_r($_POST);
    //echo "</pre>";

    if(
      isset($_POST['fecha']) &&
      isset($_POST['hora']) &&
      isset($_POST['cif_propietario']) &&
      isset($_POST['num_expedicion']) &&
      isset($_POST['observaciones']) &&
      isset($_POST['num_contenedores'])
    ){

        $fecha = $_POST['fecha'];
        $hora = $_POST['hora'];
        $cif_propietario = $_POST['cif_propietario'];
        $num_expedicion = $_POST['num_expedicion'];
        $id_origen = $_POST['id_origen'];
        $id_destino = $_POST['id_destino'];
        $observaciones = $_POST['observaciones'];
        $num_contenedores = $_POST['num_contenedores'];

        $railsider_model = new railsider_model();

        if($cif_propietario == 'A60389624'){//Para CCIS-BILBAO, añadimos automaticamente generadores para REEFERS
            $generadores_list = $railsider_model->get_generadores_por_propietario($cif_propietario);
            foreach ($generadores_list as $generadores_line) {
              $num_contenedores[] = array(
            		'num_contenedor' => $generadores_line['num_contenedor']
            	);
            }
        }

        $id_cita_carga = $railsider_model->crear_cita_carga(
          $fecha,
          $hora,
          $cif_propietario,
          $num_expedicion,
          $id_origen,
          $id_destino,
          $observaciones
        );

        foreach ($num_contenedores as $key => $value) {
					$num_contenedor = $value['num_contenedor'];
          $railsider_model->insert_linea_carga($id_cita_carga, $num_contenedor);
          //establecer a NULL id_cita_carga_temp de la tabla contenedor
          $railsider_model->update_contenedor_id_cita_carga_temp($num_contenedor, NULL);
				}

        $response_array['status'] = 'success';
        $response_array['value'] = $id_cita_carga;

    }
    else {
        $response_array['status'] = 'error';
        $response_array['message'] = "Faltan campos";
    }

    echo json_encode($response_array);
?>
