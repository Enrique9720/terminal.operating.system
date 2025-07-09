<?php
//////////////////////////////////////////////////////////////////
session_start();

//cargamos el codigo PHP que realiza la conexion a la BD
require_once("../models/conexion_db.php");

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");

//comprobamos que el usuario esta logeado
check_logged_user();
/////////////////////////////////////////////////////////////////////////////////////

///////////////////////*CARGA DE MODELOS*////////////////////////////////////////////
require_once("../models/railsider_model.php");
/////////////////////////////////////////////////////////////////////////////////////

	if(isset($_GET['num_contenedor'])){

		$num_contenedor = $_GET['num_contenedor'];

		$railsider_model = new railsider_model();
		//$historico_contenedor_list = $railsider_model->get_contenedor_historico($num_contenedor); //HISTORICO CONTENEDOR
		$historico_contenedor_list = $railsider_model->get_contenedor_historico_transbordo($num_contenedor); //HISTORICO TRANSBORDO

		//echo "<pre>";
		//print_r($historico_contenedor_list);
		//echo "</pre>";

		if (count($historico_contenedor_list) > 0) {

			foreach ($historico_contenedor_list as $key => $value) {
				//inicializamos variables
				//contenedor
				$id_control_stock = "";
				$num_contenedor = "";
				$id_tipo_contenedor_iso = "";
				$longitud_tipo_contenedor = "";
				$descripcion_tipo_contenedor = "";
				$tara_contenedor = "";
				$cif_propietario = "";
				$nombre_comercial_propietario = "";
				$id_ubicacion = "";
				//entrada
				$id_entrada = "";
				$num_expedicion_entrada = "";
				$id_tipo_entrada = "";
				$tipo_entrada = "";
				$nombre_comercial_propietario_entrada = "";
				$fecha_entrada = "";
				$id_destinatario_entrada = "";
				$nombre_destinatario_entrada = "";
				$num_vagon = "";
				$pos_vagon = "";
				$pos_contenedor = "";
				$num_booking_contenedor = "";
				$num_precinto_contenedor = "";
				$estado_carga_contenedor = "";
				$id_tipo_mercancia = "";
				$nombre_comercial_propietario_salida = "";
				$descripcion_mercancia_entrada = "";
				$peso_mercancia_contenedor = "";
				$peso_bruto_contenedor = "";
				$temperatura_contenedor_entrada = "";
				//transbordo
				$id_transbordo = "";
				//salida
				$id_salida = "";
				$num_expedicion_salida = "";
				$id_tipo_salida = "";
				$tipo_salida = "";
				$fecha_salida = "";
				$temperatura_contenedor_salida = "";
				$id_destinatario_salida = "";
				$nombre_destinatario_salida = "";


				$num_contenedor = $value['num_contenedor'];
				$id_tipo_contenedor_iso = $value['id_tipo_contenedor_iso'];
				$longitud_tipo_contenedor = $value['longitud_tipo_contenedor'];
				$descripcion_tipo_contenedor = $value['descripcion_tipo_contenedor'];
				$tara_contenedor = $value['tara_contenedor'];
				$id_control_stock = $value['id_control_stock'];
				$id_ubicacion = $value['id_ubicacion'];
				$id_entrada = $value['id_entrada'];
				$tipo_entrada = $value['tipo_entrada'];
				$fecha_entrada = $value['fecha_entrada'];
				$id_salida = $value['id_salida'];
				$tipo_salida = $value['tipo_salida'];
				$fecha_salida = $value['fecha_salida'];

				$cif_propietario = $value['cif_propietario'];
				$nombre_comercial_propietario = $value['nombre_comercial_propietario'];
				$id_transbordo = $value['id_transbordo'];


				if ($tipo_entrada == 'TREN') { //ENTRADA
					$entrada_tren_list = $railsider_model->get_entrada_tipo_tren_por_id_entrada_por_num_contenedor($id_entrada, $num_contenedor);
					//$cif_propietario = $entrada_tren_list[0]['cif_propietario'];
					//$nombre_comercial_propietario = $entrada_tren_list[0]['nombre_comercial_propietario'];
					$num_expedicion_entrada = $entrada_tren_list[0]['num_expedicion'];
					$descripcion_mercancia_entrada = $entrada_tren_list[0]['descripcion_mercancia'];
					$id_destinatario_entrada = $entrada_tren_list[0]['id_destinatario'];
					$nombre_destinatario_entrada = $entrada_tren_list[0]['nombre_empresa_destino_origen'];
					$num_vagon = $entrada_tren_list[0]['num_vagon'];
					$pos_vagon = $entrada_tren_list[0]['pos_vagon'];
					$pos_contenedor = $entrada_tren_list[0]['pos_contenedor'];
					$estado_carga_contenedor = $entrada_tren_list[0]['estado_carga_contenedor'];
					$id_tipo_mercancia = $entrada_tren_list[0]['id_tipo_mercancia'];
					$peso_bruto_contenedor = $entrada_tren_list[0]['peso_bruto_contenedor'];
					$peso_mercancia_contenedor = $peso_bruto_contenedor - $tara_contenedor;
					$temperatura_contenedor_entrada = $entrada_tren_list[0]['temperatura_contenedor'];
					$nombre_comercial_propietario_entrada = $entrada_tren_list[0]['nombre_comercial_propietario'];

				} else if ($tipo_entrada == 'CAMIÓN') {
					$entrada_camion_list = $railsider_model->get_entrada_tipo_camion_por_id_entrada_por_num_contenedor($id_entrada, $num_contenedor);
					//$cif_propietario = $entrada_camion_list[0]['cif_propietario'];
					//$nombre_comercial_propietario = $entrada_camion_list[0]['nombre_comercial_propietario'];
					$num_expedicion_entrada = $entrada_camion_list[0]['num_expedicion'];
					$descripcion_mercancia_entrada = $entrada_camion_list[0]['descripcion_mercancia'];
					$id_destinatario_entrada = $entrada_camion_list[0]['id_destinatario'];
					$nombre_destinatario_entrada = $entrada_camion_list[0]['nombre_empresa_destino_origen'];
					$num_booking_contenedor = $entrada_camion_list[0]['num_booking_contenedor'];
					$num_precinto_contenedor = $entrada_camion_list[0]['num_precinto_contenedor'];
					$estado_carga_contenedor = $entrada_camion_list[0]['estado_carga_contenedor'];
					$id_tipo_mercancia = $entrada_camion_list[0]['id_tipo_mercancia'];
					$peso_mercancia_contenedor = $entrada_camion_list[0]['peso_mercancia_contenedor'];
					$peso_bruto_contenedor = $peso_mercancia_contenedor + $tara_contenedor;
					$temperatura_contenedor_entrada = $entrada_camion_list[0]['temperatura_contenedor'];
					$nombre_comercial_propietario_entrada = $entrada_camion_list[0]['nombre_comercial_propietario'];
				} else if ($tipo_entrada == 'TRASPASO') {
					$entrada_traspaso_list = $railsider_model->get_entrada_tipo_traspaso_por_id_entrada_por_num_contenedor($id_entrada, $num_contenedor);
					//$num_expedicion_entrada = $entrada_traspaso_list[0]['num_expedicion'];
					$descripcion_mercancia_entrada = $entrada_traspaso_list[0]['descripcion_mercancia'];
					$id_destinatario_entrada = $entrada_traspaso_list[0]['id_destinatario'];
					$nombre_destinatario_entrada = $entrada_traspaso_list[0]['nombre_empresa_destino_origen'];
					$num_booking_contenedor = $entrada_traspaso_list[0]['num_booking_contenedor'];
					$num_precinto_contenedor = $entrada_traspaso_list[0]['num_precinto_contenedor'];
					$estado_carga_contenedor = $entrada_traspaso_list[0]['estado_carga_contenedor'];
					$id_tipo_mercancia = $entrada_traspaso_list[0]['id_tipo_mercancia'];
					$peso_mercancia_contenedor = $entrada_traspaso_list[0]['peso_mercancia_contenedor'];
					$peso_bruto_contenedor = $peso_mercancia_contenedor + $tara_contenedor;
					$temperatura_contenedor_entrada = $entrada_traspaso_list[0]['temperatura_contenedor'];
					$nombre_comercial_propietario_entrada = $entrada_traspaso_list[0]['nombre_comercial_propietario'];
				}

				if ($tipo_salida == 'TREN') { //SALIDA
					$salida_tren_list = $railsider_model->get_salida_tipo_tren_por_id_salida_por_num_contenedor($id_salida, $num_contenedor);
					$num_expedicion_salida = $salida_tren_list[0]['num_expedicion'];
					$temperatura_contenedor_salida = $salida_tren_list[0]['temperatura_contenedor'];
					$id_destinatario_salida = $salida_tren_list[0]['id_destinatario'];
					$nombre_destinatario_salida = $nombre_destinatario_entrada;
					$nombre_comercial_propietario_salida = $nombre_comercial_propietario_entrada;
				} else if ($tipo_salida == 'CAMIÓN') {
					$salida_camion_list = $railsider_model->get_salida_tipo_camion_por_id_salida_por_num_contenedor($id_salida, $num_contenedor);
					$num_expedicion_salida = $salida_camion_list[0]['num_expedicion'];
					$temperatura_contenedor_salida = $salida_camion_list[0]['temperatura_contenedor'];
					$id_destinatario_salida = $salida_camion_list[0]['id_destinatario'];
					$nombre_destinatario_salida = $salida_camion_list[0]['nombre_destinatario'];
					$nombre_comercial_propietario_salida = $nombre_comercial_propietario_entrada;
				} else if ($tipo_salida == 'TRASPASO') {
					/*
					$salida_camion_list = $railsider_model->get_salida_tipo_camion_por_id_salida_por_num_contenedor($id_salida, $num_contenedor);
					$num_expedicion_salida = $salida_camion_list[0]['num_expedicion'];
					$temperatura_contenedor_salida = $salida_camion_list[0]['temperatura_contenedor'];
					$id_destinatario_salida = $salida_camion_list[0]['id_destinatario'];
					$nombre_destinatario_salida = $salida_camion_list[0]['nombre_destinatario'];
					*/
					$nombre_comercial_propietario_salida = $nombre_comercial_propietario_entrada;

				}

				$historico_list[] = array(
					//contenedor
					'id_control_stock' => $id_control_stock,
					'num_contenedor' => $num_contenedor,
					'id_tipo_contenedor_iso' => $id_tipo_contenedor_iso,
					'longitud_tipo_contenedor' => $longitud_tipo_contenedor,
					'descripcion_tipo_contenedor' => $descripcion_tipo_contenedor,
					'tara_contenedor' => $tara_contenedor,
					'cif_propietario' => $cif_propietario,
					'nombre_comercial_propietario' => $nombre_comercial_propietario,//propietario actual
					'id_ubicacion' => $id_ubicacion,
					//entrada
					'id_entrada' => $id_entrada,
					'num_expedicion_entrada' => $num_expedicion_entrada,
					'id_tipo_entrada' => $id_tipo_entrada,
					'tipo_entrada' => $tipo_entrada,
					'nombre_comercial_propietario_entrada' => $nombre_comercial_propietario_entrada,//propietario actual
					'fecha_entrada' => $fecha_entrada,
					'id_destinatario_entrada' => $id_destinatario_entrada,
					'nombre_destinatario_entrada' => $nombre_destinatario_entrada,
					'num_vagon' => $num_vagon,
					'pos_vagon' => $pos_vagon,
					'pos_contenedor' => $pos_contenedor,
					'num_booking_contenedor' => $num_booking_contenedor,
					'num_precinto_contenedor' => $num_precinto_contenedor,
					'estado_carga_contenedor' => $estado_carga_contenedor,
					'id_tipo_mercancia' => $id_tipo_mercancia,
					'descripcion_mercancia_entrada' => $descripcion_mercancia_entrada,
					'peso_mercancia_contenedor' => $peso_mercancia_contenedor,
					'peso_bruto_contenedor' => $peso_bruto_contenedor,
					'temperatura_contenedor_entrada' => $temperatura_contenedor_entrada,
					//transbordo
					'id_transbordo' => $id_transbordo,
					//salida
					'id_salida' => $id_salida,
					'num_expedicion_salida' => $num_expedicion_salida,
					'id_tipo_salida' => $id_tipo_salida,
					'tipo_salida' => $tipo_salida,
					'nombre_comercial_propietario_salida' => $nombre_comercial_propietario_salida,//propietario actual
					'fecha_salida' => $fecha_salida,
					'temperatura_contenedor_salida' => $temperatura_contenedor_salida,
					'id_destinatario_salida' => $id_destinatario_salida,
					'nombre_destinatario_salida' => $nombre_destinatario_salida,

				);
			}
		}

		//echo "<pre>";
		//print_r($historico_list);
		//echo "</pre>";

		/////////////////////////////////////////////////////////
		//cargamos la vista
		require_once('../views/historico_contenedor_view.php');


	}else{
			echo "Error. No hay num_contenedor";
	}
