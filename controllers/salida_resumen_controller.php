<?php
//////////////////////////////////////////////////////////////////
session_start();

//cargamos el codigo PHP que realiza la conexion a la BD de Wordpress
require_once("../models/conexion_db.php");

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/functions.php");

//cargamos las funciones PHP comunes para todas las apps
require_once("../functions/codeco_functions.php");

//cargamos el modelo con la clase que interactua con la tabla clientes
require_once("../models/railsider_model.php");

//comprobamos que el usuario esta logeado
check_logged_user();

/////////////////////////////////////////////////////////////////////////////////////

if (isset($_GET['id_salida'])) {

	$id_salida = $_GET['id_salida'];

	$id_salida_upload = $id_salida;

	$railsider_model = new railsider_model();

	$tipos_ficheros_list = $railsider_model->get_tipos_ficheros();
	//echo "<pre>";
	//print_r($tipos_ficheros_list);
	//echo "</pre>";
	$ficheros_list = $railsider_model->get_ficheros_por_id_salida($id_salida);
	//echo "<pre>";
	//print_r($ficheros_list);
	//echo "</pre>";

	$salida_list = $railsider_model->get_salida_por_id($id_salida);
	//echo "<pre>";
	//print_r($salida_list);
	//echo "</pre>";

	foreach ($salida_list as $salida_line) {
		$fecha_salida = $salida_line['fecha_salida'];
		$tipo_salida = $salida_line['tipo_salida'];
	}

	if ($tipo_salida == 'TREN') {

		$num_expedicion_list = $railsider_model->get_num_expedicion_salida_tren($id_salida);
		$propietarios = '';
		foreach ($num_expedicion_list as $indice => $num_expedicion_line) {
			//obtener num_expedicion_salida
			$num_expedicion_salida = $num_expedicion_line['num_expedicion'];
			//obtener propietario entrada
			if ($indice == 0) {
				$propietarios = $num_expedicion_line['nombre_comercial_propietario'];
			} else {
				$propietarios = $propietarios . "<br>" . $num_expedicion_line['nombre_comercial_propietario'];
			}
		}

		//obtener origen y destino
		$cita_carga_list = $railsider_model->get_cita_carga($num_expedicion_salida);
		$ruta_tren = $cita_carga_list[0]['nombre_origen'] . " - " . $cita_carga_list[0]['nombre_destino'];

		//obtener cantidad vagones
		$vagones_list = $railsider_model->get_cantidad_vagones_salida_tren($id_salida);
		$cantidad_vagones = $vagones_list[0]['cantidad_vagones'];
		//echo "<pre>";
		//print_r($vagones_list);
		//echo "</pre>";

		//obtener cantidad Contenedores
		$contenedores_list = $railsider_model->get_cantidad_contenedores_salida_tren($id_salida);
		$cantidad_contenedores = $contenedores_list[0]['cantidad_contenedores'];
		//echo "<pre>";
		//print_r($contenedores_list);
		//echo "</pre>";

		//listado entrada
		$salida_tren_list = $railsider_model->get_salida_tren_por_id_salida($id_salida);
		//echo "<pre>";
		//print_r($salida_tren_list);
		//echo "</pre>";

		foreach ($salida_tren_list as $key => $value) {
			$id_entrada = $value['id_entrada'];
			$tipo_entrada = $value['tipo_entrada'];
			$num_contenedor = $value['num_contenedor'];

			if ($tipo_entrada == 'TREN') {

				//listado entrada
				$entrada_tren_list = $railsider_model->get_entrada_tipo_tren_por_id_entrada_por_num_contenedor(
					$id_entrada,
					$num_contenedor
				);
				//echo "<pre>";
				//print_r($entrada_tren_list);
				//echo "</pre>";
				//sacamos datos de entrada y guardamos en array
				foreach ($entrada_tren_list as $entrada_tren_line) {
					$salida_tren_list[$key]['num_expedicion_entrada'] = $entrada_tren_line['num_expedicion'];
					$salida_tren_list[$key]['estado_carga_contenedor'] = $entrada_tren_line['estado_carga_contenedor'];
					$salida_tren_list[$key]['peso_bruto_contenedor'] = $entrada_tren_line['peso_bruto_contenedor'];
					$salida_tren_list[$key]['peso_mercancia_contenedor'] = $entrada_tren_line['peso_mercancia_contenedor'];
					$salida_tren_list[$key]['temperatura_contenedor'] = $entrada_tren_line['temperatura_contenedor'];
					$salida_tren_list[$key]['nombre_comercial_propietario'] = $entrada_tren_line['nombre_comercial_propietario'];
					$salida_tren_list[$key]['descripcion_mercancia'] = $entrada_tren_line['descripcion_mercancia'];
					$salida_tren_list[$key]['num_peligro_adr'] = $entrada_tren_line['num_peligro_adr'];
					$salida_tren_list[$key]['num_onu_adr'] = $entrada_tren_line['num_onu_adr'];
					$salida_tren_list[$key]['nombre_destinatario'] = $entrada_tren_line['nombre_empresa_destino_origen'];
				}
			} else if ($tipo_entrada == 'CAMIÓN') {
				//listado entrada
				$entrada_camion_list = $railsider_model->get_entrada_tipo_camion_por_id_entrada_por_num_contenedor(
					$id_entrada,
					$num_contenedor
				);
				//echo "<pre>";
				//print_r($entrada_camion_list);
				//echo "</pre>";
				//sacamos datos de entrada y guardamos en array

				foreach ($entrada_camion_list as $entrada_camion_line) {
					$salida_tren_list[$key]['num_expedicion_entrada'] = $entrada_camion_line['num_expedicion'];
					$salida_tren_list[$key]['estado_carga_contenedor'] = $entrada_camion_line['estado_carga_contenedor'];
					$salida_tren_list[$key]['peso_bruto_contenedor'] = $entrada_camion_line['peso_bruto_contenedor'];
					$salida_tren_list[$key]['peso_mercancia_contenedor'] = $entrada_camion_line['peso_mercancia_contenedor'];
					$salida_tren_list[$key]['temperatura_contenedor'] = $entrada_camion_line['temperatura_contenedor'];
					$salida_tren_list[$key]['nombre_comercial_propietario'] = $entrada_camion_line['nombre_comercial_propietario'];
					$salida_tren_list[$key]['descripcion_mercancia'] = $entrada_camion_line['descripcion_mercancia'];
					$salida_tren_list[$key]['num_peligro_adr'] = $entrada_camion_line['num_peligro_adr'];
					$salida_tren_list[$key]['num_onu_adr'] = $entrada_camion_line['num_onu_adr'];
					$salida_tren_list[$key]['nombre_destinatario'] = $entrada_camion_line['nombre_empresa_destino_origen'];
					$salida_tren_list[$key]['num_tarjeta_teco'] = $entrada_camion_line['num_tarjeta_teco'];
					$salida_tren_list[$key]['codigo_estacion_ferrocarril'] = $entrada_camion_line['codigo_estacion_ferrocarril'];
					$salida_tren_list[$key]['nombre_estacion_ferrocarril'] = $entrada_camion_line['nombre_estacion_ferrocarril'];
				}
			} else if ($tipo_entrada == 'TRASPASO') {

				//listado entrada
				$entrada_traspaso_list = $railsider_model->get_entrada_tipo_traspaso_por_id_entrada_por_num_contenedor(
					$id_entrada,
					$num_contenedor
				);
				//echo "<pre>";
				//print_r($entrada_traspaso_list);
				//echo "</pre>";
				//sacamos datos de entrada y guardamos en array

				foreach ($entrada_traspaso_list as $entrada_traspaso_line) {
					$salida_tren_list[$key]['num_expedicion_entrada'] = $entrada_traspaso_line['num_expedicion'];
					$salida_tren_list[$key]['estado_carga_contenedor'] = $entrada_traspaso_line['estado_carga_contenedor'];
					$salida_tren_list[$key]['peso_bruto_contenedor'] = $entrada_traspaso_line['peso_bruto_contenedor'];
					$salida_tren_list[$key]['peso_mercancia_contenedor'] = $entrada_traspaso_line['peso_mercancia_contenedor'];
					$salida_tren_list[$key]['temperatura_contenedor'] = $entrada_traspaso_line['temperatura_contenedor'];
					$salida_tren_list[$key]['nombre_comercial_propietario'] = $entrada_traspaso_line['nombre_comercial_propietario'];
					$salida_tren_list[$key]['descripcion_mercancia'] = $entrada_traspaso_line['descripcion_mercancia'];
					$salida_tren_list[$key]['num_tarjeta_teco'] = $entrada_traspaso_line['num_tarjeta_teco'];
					$salida_tren_list[$key]['codigo_estacion_ferrocarril'] = $entrada_traspaso_line['codigo_estacion_ferrocarril'];
					$salida_tren_list[$key]['nombre_estacion_ferrocarril'] = $entrada_traspaso_line['nombre_estacion_ferrocarril'];
					$salida_tren_list[$key]['num_booking_contenedor'] = $entrada_traspaso_line['num_booking_contenedor'];
					$salida_tren_list[$key]['num_precinto_contenedor'] = $entrada_traspaso_line['num_precinto_contenedor'];

					$salida_tren_list[$key]['nombre_destinatario'] = $entrada_traspaso_line['nombre_empresa_destino_origen'];

					//Mercancia Peligrosa en entrada
					$salida_tren_list[$key]['num_peligro_adr'] = $entrada_traspaso_line['num_peligro_adr'];
					$salida_tren_list[$key]['descripcion_peligro_adr'] = $entrada_traspaso_line['descripcion_peligro_adr'];
					$salida_tren_list[$key]['num_onu_adr'] = $entrada_traspaso_line['num_onu_adr'];
					$salida_tren_list[$key]['descripcion_onu_adr'] = $entrada_traspaso_line['descripcion_onu_adr'];
					$salida_tren_list[$key]['num_clase_adr'] = $entrada_traspaso_line['num_clase_adr'];
					$salida_tren_list[$key]['cod_grupo_embalaje_adr'] = $entrada_traspaso_line['cod_grupo_embalaje_adr'];
				}
			}
		}

		//echo "<pre>";
		//print_r($salida_tren_list);
		//echo "</pre>";

		$nombre_comercial_propietario = $salida_tren_list[0]['nombre_comercial_propietario'];

		// Cargamos información del envío de CODECO para la entrada y en contenedor
		$codeco_info_list = array();
		foreach ($salida_tren_list as $salida_tren_line) {
			// Obtenemos los CODECOs para la entrada y el número de contenedor
			$codeco_info_list_ = $railsider_model->get_codeco_salida_por_id_salida_por_num_contenedor($id_salida, $salida_tren_line['num_contenedor']);
			foreach ($codeco_info_list_ as $codeco_info_line_) {
				$codeco_info_list[] = $codeco_info_line_;
			}
		}
		//echo "<pre>";
		//print_r($codeco_info_list);
		//echo "</pre>";

		$re_send_train_codeco_email = codeco_envio_ccis_sicsa($contenedores_codeco_email, $fecha_movimiento);

		$incidencia_list = array();
		foreach ($salida_tren_list as $salida_tren_line) {
			$salida_tren_incidencia_list = $railsider_model->get_incidencias_num_contenedor_id_salida($id_salida, $salida_tren_line['num_contenedor']);
			foreach ($salida_tren_incidencia_list as $salida_tren_incidencia_line){
				$incidencia_list[]= $salida_tren_incidencia_line;
			}
		}
		//echo "<pre>"; print_r($incidencia_list); echo "</pre>";

		$list = $railsider_model->get_incidencias_id_salida($id_salida);
		//echo "<pre>"; print_r($list); echo "</pre>";
		foreach ($list as $line) {
				$incidencia_list[]= $line;
		}
		//echo "<pre>"; print_r($incidencia_list); echo "</pre>";

		 //esto lo tenía antes de hacer el backup
		//$salida_tren_incidencia_list_2 = $railsider_model->get_incidencias_num_contenedor($num_contenedor);


		//cargamos la vista
		require_once('../views/salida_resumen_tren_view.php');
	} else if ($tipo_salida == 'CAMIÓN') {

		//listado entrada
		$salida_camion_list = $railsider_model->get_salida_camion_por_id_salida($id_salida);
		//echo "<pre>";
		//print_r($salida_camion_list);
		//echo "</pre>";

		$num_expedicion_salida = $salida_camion_list[0]['num_expedicion_salida'];

		foreach ($salida_camion_list as $key => $value) {
			$id_entrada = $value['id_entrada'];
			$tipo_entrada = $value['tipo_entrada'];
			$num_contenedor = $value['num_contenedor'];

			//cargamos informacion del envio de CODECO para la salida y en contenedor
			$codeco_info_list = $railsider_model->get_codeco_salida_por_id_salida_por_num_contenedor($id_salida, $num_contenedor);
			//echo "<pre>";
			//print_r($codeco_info_list);
			//echo "</pre>";

			if ($tipo_entrada == 'TREN') {

				//listado entrada
				$entrada_tren_list = $railsider_model->get_entrada_tipo_tren_por_id_entrada_por_num_contenedor(
					$id_entrada,
					$num_contenedor
				);
				//echo "<pre>";
				//print_r($entrada_tren_list);
				//echo "</pre>";
				//sacamos datos de entrada y guardamos en array
				foreach ($entrada_tren_list as $entrada_tren_line) {
					$salida_camion_list[$key]['num_expedicion_entrada'] = $entrada_tren_line['num_expedicion'];
					$salida_camion_list[$key]['estado_carga_contenedor'] = $entrada_tren_line['estado_carga_contenedor'];
					$salida_camion_list[$key]['peso_bruto_contenedor'] = $entrada_tren_line['peso_bruto_contenedor'];
					$salida_camion_list[$key]['peso_mercancia_contenedor'] = $entrada_tren_line['peso_mercancia_contenedor'];
					$salida_camion_list[$key]['temperatura_contenedor'] = $entrada_tren_line['temperatura_contenedor'];
					$salida_camion_list[$key]['nombre_comercial_propietario'] = $entrada_tren_line['nombre_comercial_propietario'];
					$salida_camion_list[$key]['descripcion_mercancia'] = $entrada_tren_line['descripcion_mercancia'];
					//$salida_camion_list[$key]['nombre_destinatario'] = $entrada_tren_line['nombre_empresa_destino_origen'];

					//Mercancia Peligrosa en entrada
					$salida_camion_list[$key]['num_peligro_adr'] = $entrada_tren_line['num_peligro_adr'];
					$salida_camion_list[$key]['descripcion_peligro_adr'] = $entrada_tren_line['descripcion_peligro_adr'];
					$salida_camion_list[$key]['num_onu_adr'] = $entrada_tren_line['num_onu_adr'];
					$salida_camion_list[$key]['descripcion_onu_adr'] = $entrada_tren_line['descripcion_onu_adr'];
					$salida_camion_list[$key]['num_clase_adr'] = $entrada_tren_line['num_clase_adr'];
					$salida_camion_list[$key]['cod_grupo_embalaje_adr'] = $entrada_tren_line['cod_grupo_embalaje_adr'];
				}
			} else if ($tipo_entrada == 'CAMIÓN') {
				//listado entrada
				$entrada_camion_list = $railsider_model->get_entrada_tipo_camion_por_id_entrada_por_num_contenedor(
					$id_entrada,
					$num_contenedor
				);
				//echo "<pre>";
				//print_r($entrada_camion_list);
				//echo "</pre>";
				//sacamos datos de entrada y guardamos en array

				foreach ($entrada_camion_list as $entrada_camion_line) {
					$salida_camion_list[$key]['num_expedicion_entrada'] = $entrada_camion_line['num_expedicion'];
					$salida_camion_list[$key]['estado_carga_contenedor'] = $entrada_camion_line['estado_carga_contenedor'];
					$salida_camion_list[$key]['peso_bruto_contenedor'] = $entrada_camion_line['peso_bruto_contenedor'];
					$salida_camion_list[$key]['peso_mercancia_contenedor'] = $entrada_camion_line['peso_mercancia_contenedor'];
					$salida_camion_list[$key]['temperatura_contenedor'] = $entrada_camion_line['temperatura_contenedor'];
					$salida_camion_list[$key]['nombre_comercial_propietario'] = $entrada_camion_line['nombre_comercial_propietario'];
					$salida_camion_list[$key]['descripcion_mercancia'] = $entrada_camion_line['descripcion_mercancia'];


					//$salida_camion_list[$key]['nombre_destinatario'] = $entrada_camion_line['nombre_empresa_destino_origen'];


					$salida_camion_list[$key]['num_tarjeta_teco'] = $entrada_camion_line['num_tarjeta_teco'];
					$salida_camion_list[$key]['codigo_estacion_ferrocarril'] = $entrada_camion_line['codigo_estacion_ferrocarril'];
					$salida_camion_list[$key]['nombre_estacion_ferrocarril'] = $entrada_camion_line['nombre_estacion_ferrocarril'];
					$salida_camion_list[$key]['num_booking_contenedor'] = $entrada_camion_line['num_booking_contenedor'];
					$salida_camion_list[$key]['num_precinto_contenedor'] = $entrada_camion_line['num_precinto_contenedor'];

					//Mercancia Peligrosa en entrada
					$salida_camion_list[$key]['num_peligro_adr'] = $entrada_camion_line['num_peligro_adr'];
					$salida_camion_list[$key]['descripcion_peligro_adr'] = $entrada_camion_line['descripcion_peligro_adr'];
					$salida_camion_list[$key]['num_onu_adr'] = $entrada_camion_line['num_onu_adr'];
					$salida_camion_list[$key]['descripcion_onu_adr'] = $entrada_camion_line['descripcion_onu_adr'];
					$salida_camion_list[$key]['num_clase_adr'] = $entrada_camion_line['num_clase_adr'];
					$salida_camion_list[$key]['cod_grupo_embalaje_adr'] = $entrada_camion_line['cod_grupo_embalaje_adr'];
				}
			} else if ($tipo_entrada == 'TRASPASO') {
				//listado entrada
				$entrada_traspaso_list = $railsider_model->get_entrada_tipo_traspaso_por_id_entrada_por_num_contenedor(
					$id_entrada,
					$num_contenedor
				);
				//echo "<pre>";
				//print_r($entrada_camion_list);
				//echo "</pre>";
				//sacamos datos de entrada y guardamos en array

				foreach ($entrada_traspaso_list as $entrada_traspaso_line) {
					$salida_camion_list[$key]['num_expedicion_entrada'] = $entrada_traspaso_line['num_expedicion'];
					$salida_camion_list[$key]['estado_carga_contenedor'] = $entrada_traspaso_line['estado_carga_contenedor'];
					$salida_camion_list[$key]['peso_bruto_contenedor'] = $entrada_traspaso_line['peso_bruto_contenedor'];
					$salida_camion_list[$key]['peso_mercancia_contenedor'] = $entrada_traspaso_line['peso_mercancia_contenedor'];
					$salida_camion_list[$key]['temperatura_contenedor'] = $entrada_traspaso_line['temperatura_contenedor'];
					$salida_camion_list[$key]['nombre_comercial_propietario'] = $entrada_traspaso_line['nombre_comercial_propietario'];
					$salida_camion_list[$key]['descripcion_mercancia'] = $entrada_traspaso_line['descripcion_mercancia'];
					$salida_camion_list[$key]['num_tarjeta_teco'] = $entrada_traspaso_line['num_tarjeta_teco'];
					$salida_camion_list[$key]['codigo_estacion_ferrocarril'] = $entrada_traspaso_line['codigo_estacion_ferrocarril'];
					$salida_camion_list[$key]['nombre_estacion_ferrocarril'] = $entrada_traspaso_line['nombre_estacion_ferrocarril'];
					$salida_camion_list[$key]['num_booking_contenedor'] = $entrada_traspaso_line['num_booking_contenedor'];
					$salida_camion_list[$key]['num_precinto_contenedor'] = $entrada_traspaso_line['num_precinto_contenedor'];
					$salida_camion_list[$key]['nombre_destinatario'] = $entrada_traspaso_line['nombre_empresa_destino_origen'];
					//Mercancia Peligrosa en entrada
					$salida_camion_list[$key]['num_peligro_adr'] = $entrada_traspaso_line['num_peligro_adr'];
					$salida_camion_list[$key]['descripcion_peligro_adr'] = $entrada_traspaso_line['descripcion_peligro_adr'];
					$salida_camion_list[$key]['num_onu_adr'] = $entrada_traspaso_line['num_onu_adr'];
					$salida_camion_list[$key]['descripcion_onu_adr'] = $entrada_traspaso_line['descripcion_onu_adr'];
					$salida_camion_list[$key]['num_clase_adr'] = $entrada_traspaso_line['num_clase_adr'];
					$salida_camion_list[$key]['cod_grupo_embalaje_adr'] = $entrada_traspaso_line['cod_grupo_embalaje_adr'];
				}
			}
		}

		//echo "<pre>";
		//print_r($salida_camion_list);
		//echo "</pre>";

		//flag mercancia peligrosa
		$flag_mercancia_peligrosa = false;
		if (
			$salida_camion_list[0]['num_onu_adr'] != ''
			&& $salida_camion_list[0]['descripcion_mercancia'] == 'MERCANCÍA PELIGROSA'
		) {
			$flag_mercancia_peligrosa = true;
		}

		//$re_send_truck_codeco_email = codeco_envio_ccis_sicsa($contenedores_codeco_email, $fecha_movimiento);

		$salida_camion_incidencia_list = $railsider_model->get_incidencias_num_contenedor($num_contenedor);

		//cargamos la vista
		require_once('../views/salida_resumen_camion_view.php');
	} else if ($tipo_salida == 'TRASPASO') { //INICIO TRASPASO

		$traspaso_list = $railsider_model->get_traspaso_por_id_salida($id_salida);
		//echo "<pre>";
		//print_r($traspaso_list);
		//echo "</pre>";

		$salida_traspaso_list = $railsider_model->get_salida_traspaso_por_id_salida($id_salida);
		//echo "<pre>";
		//print_r($salida_traspaso_list);
		//echo "</pre>";
		foreach ($salida_traspaso_list as $key => $value) {
			$id_entrada = $value['id_entrada'];
			$tipo_entrada = $value['tipo_entrada'];
			$num_contenedor = $value['num_contenedor'];

			if ($tipo_entrada == 'TREN') {
				//listado entrada
				$entrada_tren_list = $railsider_model->get_entrada_tipo_tren_por_id_entrada_por_num_contenedor(
					$id_entrada,
					$num_contenedor
				);

				foreach ($entrada_tren_list as $entrada_tren_line) {
					$salida_traspaso_list[$key]['num_expedicion_entrada'] = $entrada_tren_line['num_expedicion'];
					$salida_traspaso_list[$key]['estado_carga_contenedor'] = $entrada_tren_line['estado_carga_contenedor'];
					$salida_traspaso_list[$key]['peso_bruto_contenedor'] = $entrada_tren_line['peso_bruto_contenedor'];
					$salida_traspaso_list[$key]['peso_mercancia_contenedor'] = $entrada_tren_line['peso_mercancia_contenedor'];
					$salida_traspaso_list[$key]['temperatura_contenedor'] = $entrada_tren_line['temperatura_contenedor'];
					$salida_traspaso_list[$key]['nombre_comercial_propietario'] = $entrada_tren_line['nombre_comercial_propietario'];
					$salida_traspaso_list[$key]['descripcion_mercancia'] = $entrada_tren_line['descripcion_mercancia'];
					//Mercancia Peligrosa en entrada
					$salida_traspaso_list[$key]['num_peligro_adr'] = $entrada_tren_line['num_peligro_adr'];
					$salida_traspaso_list[$key]['descripcion_peligro_adr'] = $entrada_tren_line['descripcion_peligro_adr'];
					$salida_traspaso_list[$key]['num_onu_adr'] = $entrada_tren_line['num_onu_adr'];
					$salida_traspaso_list[$key]['descripcion_onu_adr'] = $entrada_tren_line['descripcion_onu_adr'];
					$salida_traspaso_list[$key]['num_clase_adr'] = $entrada_tren_line['num_clase_adr'];
					$salida_traspaso_list[$key]['cod_grupo_embalaje_adr'] = $entrada_tren_line['cod_grupo_embalaje_adr'];
				}

				//echo "<pre>";
				//print_r($entrada_tren_list);
				//echo "</pre>";


			} else if ($tipo_entrada == 'CAMIÓN') {
				//listado entrada
				$entrada_camion_list = $railsider_model->get_entrada_tipo_camion_por_id_entrada_por_num_contenedor(
					$id_entrada,
					$num_contenedor
				);
				//echo "<pre>";
				//print_r($entrada_camion_list);
				//echo "</pre>";
				//sacamos datos de entrada y guardamos en array

				foreach ($entrada_camion_list as $entrada_camion_line) {
					$salida_traspaso_list[$key]['num_expedicion_entrada'] = $entrada_camion_line['num_expedicion'];
					$salida_traspaso_list[$key]['estado_carga_contenedor'] = $entrada_camion_line['estado_carga_contenedor'];
					$salida_traspaso_list[$key]['peso_bruto_contenedor'] = $entrada_camion_line['peso_bruto_contenedor'];
					$salida_traspaso_list[$key]['peso_mercancia_contenedor'] = $entrada_camion_line['peso_mercancia_contenedor'];
					$salida_traspaso_list[$key]['temperatura_contenedor'] = $entrada_camion_line['temperatura_contenedor'];
					$salida_traspaso_list[$key]['nombre_comercial_propietario'] = $entrada_camion_line['nombre_comercial_propietario'];
					$salida_traspaso_list[$key]['descripcion_mercancia'] = $entrada_camion_line['descripcion_mercancia'];
					$salida_traspaso_list[$key]['num_tarjeta_teco'] = $entrada_camion_line['num_tarjeta_teco'];
					$salida_traspaso_list[$key]['codigo_estacion_ferrocarril'] = $entrada_camion_line['codigo_estacion_ferrocarril'];
					$salida_traspaso_list[$key]['nombre_estacion_ferrocarril'] = $entrada_camion_line['nombre_estacion_ferrocarril'];
					$salida_traspaso_list[$key]['num_booking_contenedor'] = $entrada_camion_line['num_booking_contenedor'];
					$salida_traspaso_list[$key]['num_precinto_contenedor'] = $entrada_camion_line['num_precinto_contenedor'];

					//Mercancia Peligrosa en entrada
					$salida_traspaso_list[$key]['num_peligro_adr'] = $entrada_camion_line['num_peligro_adr'];
					$salida_traspaso_list[$key]['descripcion_peligro_adr'] = $entrada_camion_line['descripcion_peligro_adr'];
					$salida_traspaso_list[$key]['num_onu_adr'] = $entrada_camion_line['num_onu_adr'];
					$salida_traspaso_list[$key]['descripcion_onu_adr'] = $entrada_camion_line['descripcion_onu_adr'];
					$salida_traspaso_list[$key]['num_clase_adr'] = $entrada_camion_line['num_clase_adr'];
					$salida_traspaso_list[$key]['cod_grupo_embalaje_adr'] = $entrada_camion_line['cod_grupo_embalaje_adr'];
				}
			}
		}

		//cargamos la vista
		require_once('../views/salida_resumen_traspaso_view.php');
		//FIN TRASPASO
	} /*else if ($tipo_salida == 'TRANSBORDO') {
		$salida_transbordo_list = $railsider_model->get_salida_transbordo_por_id_salida($id_salida);
		//echo "<pre>"; print_r($salida_transbordo_list); echo "</pre>";
		$num_transbordo = $salida_transbordo_list[0]['id_transbordo'];

		//cargamos la vista
		require_once('../views/salida_resumen_transbordo_view.php');
	}*/

	require_once('../views/fichero_subida_modal_view.php');
} else {
	echo "Error. No hay id_salida";
}
