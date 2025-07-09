<?php
//////////////////////////////////////////////////////////////////
session_start();

//cargamos el codigo PHP que realiza la conexion a la BD de Wordpress
require_once "../models/conexion_db.php";

//cargamos las funciones PHP comunes para todas las apps
require_once "../functions/functions.php";

//cargamos el modelo con la clase que interactua con la tabla clientes
require_once("../models/railsider_model.php");

//comprobamos que el usuario esta logeado
check_logged_user();

/////////////////////////////////////////////////////////////////////////////////////

require '../vendor/autoload.php';

//cargamos las funciones que generan los excel por propietario
require_once "../functions/excel_salida_resumen_tren_functions.php";

if (isset($_GET["id_salida"])){

  //instanciamos el modelo de la BBDD
  $railsider_model = new railsider_model();
  //recogemos desde metodo GET
  $id_salida = $_GET["id_salida"];

  //datos desde BBDD
  $salida_list = $railsider_model-> get_salida_por_id($id_salida);
  foreach ($salida_list as $salida_line) {
    $fecha_salida = $salida_line['fecha_salida'];
    $tipo_salida = $salida_line['tipo_salida'];
  }

  if($tipo_salida == 'TREN'){

    $num_expedicion_list = $railsider_model-> get_num_expedicion_salida_tren($id_salida);
    //obtener num_expedicion_salida
    $num_expedicion_salida = $num_expedicion_list[0]['num_expedicion'];
    //obtener propietario entrada
    $nombre_comercial_propietario = $num_expedicion_list[0]['nombre_comercial_propietario'];
    //obtener origen y destino
    $cita_carga_list = $railsider_model-> get_cita_carga($num_expedicion_salida);
    $ruta_tren = $cita_carga_list[0]['nombre_origen']." - ".$cita_carga_list[0]['nombre_destino'];

    $salida_tren_list = $railsider_model-> get_salida_tren_por_id_salida($id_salida);

    foreach ($salida_tren_list as $key => $value) {
      $id_entrada = $value['id_entrada'];
      $tipo_entrada = $value['tipo_entrada'];
      $num_contenedor = $value['num_contenedor'];

      if($tipo_entrada == 'TREN'){

        //listado entrada
        $entrada_tren_list = $railsider_model-> get_entrada_tipo_tren_por_id_entrada_por_num_contenedor(
          $id_entrada,
          $num_contenedor
        );

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
          $salida_tren_list[$key]['descripcion_mercancia'] = $entrada_tren_line['descripcion_mercancia'];
          $salida_tren_list[$key]['num_peligro_adr'] = $entrada_tren_line['num_peligro_adr'];
          $salida_tren_list[$key]['nombre_destinatario'] = $entrada_tren_line['nombre_empresa_destino_origen'];
        }

      }else if($tipo_entrada == 'CAMIÓN'){
        //listado entrada
        $entrada_camion_list = $railsider_model-> get_entrada_tipo_camion_por_id_entrada_por_num_contenedor(
          $id_entrada,
          $num_contenedor
        );

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

      }else if($tipo_entrada == 'TRASPASO'){

        //listado entrada
        $entrada_traspaso_list = $railsider_model-> get_entrada_tipo_traspaso_por_id_entrada_por_num_contenedor(
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

    if($nombre_comercial_propietario == 'RENFE'){
      excel_pie_tren_salida_renfe($salida_tren_list);
    }else if($nombre_comercial_propietario == 'SICSA-VALENCIA'){
      excel_pie_tren_salida_sicsa($salida_tren_list);
    }else if($nombre_comercial_propietario == 'CCIS-BILBAO'){
      excel_pie_tren_salida_ccis($salida_tren_list);
    }

  }else{
    echo "Error. La salida no es de tren";
  }

}else{
    echo "Error. No hay propietario";
}
