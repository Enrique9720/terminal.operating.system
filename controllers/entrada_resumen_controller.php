<?php
    //////////////////////////////////////////////////////////////////
	session_start();

	//cargamos el codigo PHP que realiza la conexion a la BD de Wordpress
    require_once("../models/conexion_db.php");

    //cargamos las funciones PHP comunes para todas las apps
    require_once("../functions/functions.php");

		//cargamos el modelo con la clase que interactua con la tabla clientes
		require_once("../models/railsider_model.php");

	//comprobamos que el usuario esta logeado
    check_logged_user();

    /////////////////////////////////////////////////////////////////////////////////////

	if(isset($_GET['id_entrada'])){

		$id_entrada = $_GET['id_entrada'];
		//echo $id_entrada."<br>";
		$id_entrada_upload = $id_entrada;

	  $railsider_model = new railsider_model();

		$tipos_ficheros_list = $railsider_model-> get_tipos_ficheros();
		//echo "<pre>";
		//print_r($tipos_ficheros_list);
		//echo "</pre>";
		$ficheros_list = $railsider_model -> get_ficheros_por_id_entrada($id_entrada);
		//echo "<pre>";
		//print_r($ficheros_list);
		//echo "</pre>";

		$entrada_list = $railsider_model-> get_entrada_por_id($id_entrada);
		//echo "<pre>";
		//print_r($entrada_list);
		//echo "</pre>";

		foreach ($entrada_list as $entrada_line) {
			$fecha_entrada = $entrada_line['fecha_entrada'];
			$tipo_entrada = $entrada_line['tipo_entrada'];
		}

		if($tipo_entrada == 'TREN'){

			$num_expedicion_list = $railsider_model-> get_num_expedicion_entrada_tipo_tren($id_entrada);
			$num_expedicion = $num_expedicion_list[0]['num_expedicion'];

			$cita_descarga_list = $railsider_model-> get_cita_descarga($num_expedicion);
			$ruta_tren = $cita_descarga_list[0]['nombre_origen']." - ".$cita_descarga_list[0]['nombre_destino'];

			//obtener propietario entrada
			$propietarios_list = $railsider_model-> get_propietarios_entrada_tren($id_entrada);
			//$id_entrada = $entrada_list[0]['id'];
			//echo "<pre>";
			//print_r($propietarios_list);
			//echo "</pre>";
			$propietarios = '';
			foreach ($propietarios_list as $propietarios_line) {
				$propietarios = $propietarios." ".$propietarios_line['propietario'];
			}
			//echo "propietarios:".$propietarios;

			//obtener cantidad vagones
			$vagones_list = $railsider_model-> get_cantidad_vagones_entrada_tren($id_entrada);
			$cantidad_vagones = $vagones_list[0]['cantidad_vagones'];
			//echo "<pre>";
			//print_r($vagones_list);
			//echo "</pre>";

			//obtener cantidad Contenedores
			$contenedores_list = $railsider_model-> get_cantidad_contenedores_entrada_tren($id_entrada);
			$cantidad_contenedores = $contenedores_list[0]['cantidad_contenedores'];
			//echo "<pre>";
			//print_r($contenedores_list);
			//echo "</pre>";

			//listado entrada
			$entrada_tren_list = $railsider_model-> get_entrada_tren_por_id_entrada($id_entrada);
			//echo "<pre>";
			//print_r($entrada_tren_list);
			//echo "</pre>";

			// Cargamos información del envío de CODECO para la entrada y en contenedor
			$codeco_info_list = array();
			foreach ($entrada_tren_list as $entrada_tren_line) {
				// Obtenemos los CODECOs para la entrada y el número de contenedor
				$codeco_info_list_ = $railsider_model->get_codeco_entrada_por_id_entrada_por_num_contenedor($id_entrada, $entrada_tren_line['num_contenedor']);
				foreach ($codeco_info_list_ as $codeco_info_line_) {
					$codeco_info_list[] = $codeco_info_line_;
				}
			}
			//echo "<pre>";
			//print_r($codeco_info_list);
			//echo "</pre>";

			//$re_send_train_codeco_email = codeco_envio_ccis_sicsa($contenedores_codeco_email, $fecha_movimiento);

			$entrada_tren_incidencia_list = $railsider_model ->get_incidencias_id_entrada($id_entrada);

			//cargamos la vista
			require_once('../views/entrada_resumen_tren_view.php');
			//require_once('../views/entrada_resumen_tren_modal_view.php');

		}else if($tipo_entrada == 'CAMIÓN'){

			//listado entrada
			$entrada_camion_list = $railsider_model-> get_entrada_camion_por_id_entrada($id_entrada);
			//echo "<pre>";
			//print_r($entrada_camion_list);
			//echo "</pre>";

			$num_expedicion = $entrada_camion_list[0]['num_expedicion'];
			$flag_mercancia_peligrosa = false;
			if(
				$entrada_camion_list[0]['num_onu_adr'] != ''
				&& (
						$entrada_camion_list[0]['descripcion_mercancia'] == 'MERCANCÍA PELIGROSA' ||
						$entrada_camion_list[0]['descripcion_mercancia'] == 'VACÍO-SUCIO'
					)
			){
					$flag_mercancia_peligrosa = true;
			}

			//cargamos informacion del envio de CODECO para la entrada y en contenedor
			$num_contenedor = $entrada_camion_list[0]['num_contenedor'];

			$codeco_info_list = $railsider_model-> get_codeco_entrada_por_id_entrada_por_num_contenedor($id_entrada, $num_contenedor);
			//echo "<pre>";
			//print_r($codeco_info_list);
			//echo "</pre>";

			$entrada_camion_incidencia_list = $railsider_model ->get_incidencias_id_entrada($id_entrada);

			//cargamos la vista
			require_once('../views/entrada_resumen_camion_view.php');

		}else if($tipo_entrada == 'TRASPASO'){

			//listado entrada
			$entrada_traspaso_list = $railsider_model-> get_entrada_traspaso_por_id_entrada($id_entrada);
			//echo "<pre>";
			//print_r($entrada_camion_list);
			//echo "</pre>";

			$num_traspaso = $entrada_traspaso_list[0]['id_traspaso'];

			//cargamos la vista
			require_once('../views/entrada_resumen_traspaso_view.php');

		}/*else if ($tipo_entrada == 'TRANSBORDO'){
			$entrada_transbordo_list = $railsider_model-> get_entrada_transbordo_por_id_entrada($id_entrada);
			$num_transbordo = $entrada_transbordo_list[0]['id_transbordo'];

			//cargamos la vista
			require_once('../views/entrada_resumen_transbordo_view.php');
		}*/


		require_once('../views/fichero_subida_modal_view.php');



	}else{
			echo "Error. No hay id_entrada";
	}

?>
