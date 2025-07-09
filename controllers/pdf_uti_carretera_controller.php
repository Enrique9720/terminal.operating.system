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

/////////////////////////////////////////////////////////////////////////////////
require_once '../vendor/setasign/fpdf/fpdf.php';
require_once '../vendor/setasign/fpdi/src/autoload.php';

use setasign\Fpdi\Fpdi;
/////////////////////////////////////////////////////////////////////////////////

if (isset($_GET["id"]) && isset($_GET["tipo"])) {

  //recogemos desde el metodo GET
  $id = $_GET["id"];

  //instanciamos el modelo de la BBDD
  $railsider_model = new railsider_model();

  $tipo_movimiento = $_GET["tipo"];
  $centro_logistico = "T.T.M.M.";

  if ($tipo_movimiento == 'entrada') {

    $id_entrada = $id;

    $entrada_camion_list = $railsider_model->get_entrada_camion_por_id_entrada($id_entrada);
    //echo "<pre>";
    //print_r($entrada_camion_list);
    //echo "</pre>";

    foreach ($entrada_camion_list as $entrada_camion_line) {
      //Sacamos fecha
      $date = date_create($entrada_camion_line['fecha_entrada']);
      $fecha = date_format($date, "d        m        Y");
      $hora_entrada = date_format($date, "H:i");
      $hora_salida = date('H:i', strtotime('+' . rand(10, 15) . ' minute', strtotime($hora_entrada)));
      $num_expedicion = $entrada_camion_line['num_expedicion'];
      $nombre_empresa_transportista = $entrada_camion_line['nombre_empresa_transportista'];
      $matricula_camion = $entrada_camion_line['matricula_tractora'] . " / " . $entrada_camion_line['matricula_remolque'];
      $conductor_nombre_apellidos = $entrada_camion_line['nombre_conductor'] . " " . $entrada_camion_line['apellidos_conductor'];
      $dni_conductor = $entrada_camion_line['dni_conductor'];
      $id_tipo_contenedor_iso = $entrada_camion_line['id_tipo_contenedor_iso'];
      $estado_carga_contenedor = $entrada_camion_line['estado_carga_contenedor'];
      $longitud_tipo_contenedor = $entrada_camion_line['longitud_tipo_contenedor'];
      $num_contenedor = $entrada_camion_line['num_contenedor'];
      $num_peligro_adr = $entrada_camion_line['num_peligro_adr'];
      $num_onu_adr = $entrada_camion_line['num_onu_adr'];
      $tara_contenedor = $entrada_camion_line['tara_contenedor'] / 1000;
      $peso_mercancia_contenedor = $entrada_camion_line['peso_mercancia_contenedor'] / 1000;
      $nombre_destinatario = $entrada_camion_line['nombre_destinatario']; //substr("abcdef", 0, -1); //devuelve "abcde" //utf8_decode
      $nombre_comercial_propietario = $entrada_camion_line['nombre_comercial_propietario'];
      if ($nombre_comercial_propietario == 'RENFE') {
        $nombre_comercial_propietario = 'RENFE';
        $empresa_ferroviaria = 'RENFE';
        $nombre_destinatario = ''; //si es RENFE no mostramos destinatario
      } else if ($nombre_comercial_propietario == 'SICSA-VALENCIA') {
        $nombre_comercial_propietario = 'SICSA';
        $empresa_ferroviaria = 'CONTINENTAL';
      } else if ($nombre_comercial_propietario == 'CCIS-BILBAO') {
        $nombre_comercial_propietario = 'CCIS';
        $empresa_ferroviaria = 'CONTINENTAL';
      }

      $origen_destino = $entrada_camion_line['nombre_origen'] . "-" . $entrada_camion_line['nombre_destino'];

      $num_booking_contenedor = $entrada_camion_line['num_booking_contenedor'];
      $num_precinto_contenedor = $entrada_camion_line['num_precinto_contenedor'];
      $espacio = "";
      $zona = "";
      $num_contenedor_cesion = "";
      $empresa_cede = "";
      $observacion_doc_cesion = "";
      $num_pi = "";
    }
  } else if ($tipo_movimiento == 'salida') {
    $id_salida = $id;
    $salida_camion_list = $railsider_model->get_salida_camion_por_id_salida($id_salida);

    foreach ($salida_camion_list as $key => $value) {
      $id_entrada = $value['id_entrada'];
      $tipo_entrada = $value['tipo_entrada'];
      $num_contenedor = $value['num_contenedor'];

      if ($tipo_entrada == 'TREN') {
        //listado entrada
        $entrada_tren_list = $railsider_model->get_entrada_tipo_tren_por_id_entrada_por_num_contenedor(
          $id_entrada,
          $num_contenedor
        );
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
        //sacamos datos de entrada y guardamos en array
        foreach ($entrada_camion_list as $entrada_camion_line) {
          $salida_camion_list[$key]['num_expedicion_entrada'] = $entrada_camion_line['num_expedicion'];
          $salida_camion_list[$key]['estado_carga_contenedor'] = $entrada_camion_line['estado_carga_contenedor'];
          $salida_camion_list[$key]['peso_bruto_contenedor'] = $entrada_camion_line['peso_bruto_contenedor'];
          $salida_camion_list[$key]['peso_mercancia_contenedor'] = $entrada_camion_line['peso_mercancia_contenedor'];
          $salida_camion_list[$key]['temperatura_contenedor'] = $entrada_camion_line['temperatura_contenedor'];
          $salida_camion_list[$key]['nombre_comercial_propietario'] = $entrada_camion_line['nombre_comercial_propietario'];
          $salida_camion_list[$key]['descripcion_mercancia'] = $entrada_camion_line['descripcion_mercancia'];
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


    foreach ($salida_camion_list as $salida_camion_line) {
      //Sacamos fecha
      $date = date_create($salida_camion_line['fecha_salida']);
      $fecha = date_format($date, "d        m        Y");
      $hora_salida = date_format($date, "H:i");
      $hora_entrada = date('H:i', strtotime('-' . rand(10, 15) . ' minute', strtotime($hora_salida)));
      $num_expedicion = $salida_camion_line['num_expedicion_salida'];
      $nombre_empresa_transportista = $salida_camion_line['nombre_empresa_transportista'];
      $matricula_camion = $salida_camion_line['matricula_tractora'] . " / " . $salida_camion_line['matricula_remolque'];
      $conductor_nombre_apellidos = $salida_camion_line['nombre_conductor'] . " " . $salida_camion_line['apellidos_conductor'];
      $dni_conductor = $salida_camion_line['dni_conductor'];
      $id_tipo_contenedor_iso = $salida_camion_line['id_tipo_contenedor_iso'];
      $estado_carga_contenedor = $salida_camion_line['estado_carga_contenedor'];
      $longitud_tipo_contenedor = $salida_camion_line['longitud_tipo_contenedor'];
      $num_contenedor = $salida_camion_line['num_contenedor'];
      $num_peligro_adr = $salida_camion_line['num_peligro_adr'];
      $num_onu_adr = $salida_camion_line['num_onu_adr'];
      $tara_contenedor = $salida_camion_line['tara_contenedor'] / 1000;
      $peso_mercancia_contenedor = $salida_camion_line['peso_mercancia_contenedor'] / 1000;
      $nombre_destinatario = $salida_camion_line['nombre_destinatario'];
      $nombre_comercial_propietario = $salida_camion_line['nombre_comercial_propietario'];
      if ($nombre_comercial_propietario == 'RENFE') {
        $nombre_comercial_propietario = 'RENFE';
        $empresa_ferroviaria = 'RENFE';
        $nombre_destinatario = ''; //si es RENFE no mostramos destinatario
      } else if ($nombre_comercial_propietario == 'SICSA-VALENCIA') {
        $nombre_comercial_propietario = 'SICSA';
        $empresa_ferroviaria = 'CONTINENTAL';
      } else if ($nombre_comercial_propietario == 'CCIS-BILBAO') {
        $nombre_comercial_propietario = 'CCIS';
        $empresa_ferroviaria = 'CONTINENTAL';
      }
      $origen_destino = $salida_camion_line['nombre_origen'] . "-" . $salida_camion_line['nombre_destino']; //ORIGEN-DESTINO SALIDA
      $num_booking_contenedor = $salida_camion_line['num_booking_contenedor'];
      $num_precinto_contenedor = $salida_camion_line['num_precinto_contenedor'];
      $espacio = "";
      $zona = "";
      $num_contenedor_cesion = "";
      $empresa_cede = "";
      $observacion_doc_cesion = "";
      $num_pi = "";
    }
  }


  // Iniciar FPDI
  $pdf = new Fpdi();
  // Agregar pagina en horizontal (paisaje)
  $pdf->AddPage('L');
  //Cargamos fichero pdf de plantilla
  $pdf->setSourceFile("../tpl/Acceso de UTI por carretera GMS.pdf");
  // Importamos pagina 1
  $tplId = $pdf->importPage(1);
  // Usa la página importada y colóquela en el punto 5,5 con su ancho preferido en mm
  $pdf->useTemplate($tplId, 0, 0, 298);

  //INICIO DATOS

  //ADD TIPO MOVIMIENTO
  // Nombre de fuente, estilo de fuente (p. ej., 'B' para negrita), tamaño de fuente
  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(170, 12); // Inicio X, inicio Y (en mm)
  $pdf->Write(0, $tipo_movimiento . " " . $num_expedicion);

  //ADD CENTRO LOGISTICO
  // Nombre de fuente, estilo de fuente (p. ej., 'B' para negrita), tamaño de fuente
  $pdf->SetFont('Arial', '', 12);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(252, 10.9); // Inicio X, inicio Y (en mm)
  $pdf->Write(0, $centro_logistico);

  // Agrega la fecha actual
  $pdf->SetFont('Arial', '', 12);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(245, 20.5);
  $pdf->Write(0, $fecha);

  // Agrega la hora actual
  $pdf->SetFont('Arial', '', 12);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(274.2, 28.4);
  $pdf->Write(0, $hora_entrada);

  // Agrega la hora actual
  $pdf->SetFont('Arial', '', 12);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(274.2, 37.7);
  $pdf->Write(0, $hora_salida);

  // ADD EMPRESA TRANSPORTISTA
  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(34.5, 28.5);
  $pdf->Write(0, substr($nombre_empresa_transportista, 0, 40));

  // ADD MATRICULA DEL CAMION
  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(152, 28.5);
  $pdf->Write(0, $matricula_camion);

  // ADD CONDUCTOR (NOMBRE Y APELLIDOS)
  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(34.5, 36.5);
  $pdf->Write(0, $conductor_nombre_apellidos);

  // ADD DNI
  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(151, 36.5);
  $pdf->Write(0, $dni_conductor);

  // ADD TIPO 1
  $pdf->SetFont('Arial', '', 6);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(14.5, 60.75);
  $pdf->Write(0, $id_tipo_contenedor_iso);

  // ADD C/V 1
  $pdf->SetFont('Arial', '', 6);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(25, 60.75);
  $pdf->Write(0, $estado_carga_contenedor);

  // ADD PIES 1
  $pdf->SetFont('Arial', '', 6);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(32, 60.75);
  $pdf->Write(0, $longitud_tipo_contenedor);

  // ADD Nº CONTENEDOR 1
  $pdf->SetFont('Arial', '', 6);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(47, 60.75);
  $pdf->Write(0, $num_contenedor);

  // ADD PELIGRO 1
  $pdf->SetFont('Arial', '', 6);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(82, 60.75);
  $pdf->Write(0, $num_peligro_adr);

  // ADD ONU 1
  $pdf->SetFont('Arial', '', 6);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(93, 60.75);
  $pdf->Write(0, $num_onu_adr);

  // ADD TARA 1
  $pdf->SetFont('Arial', '', 6);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(107, 60.75);
  $pdf->Write(0, $tara_contenedor);

  // ADD CARGA NETA 1
  $pdf->SetFont('Arial', '', 6);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(117, 60.75);
  $pdf->Write(0, $peso_mercancia_contenedor);

  // ADD EMPRESA CARGADOR 1
  $pdf->SetFont('Arial', '', 6);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(125, 60.75);
  $pdf->Write(0, substr(utf8_decode($nombre_destinatario), 0, 15));

  // ADD CLIENTE DE M. S. SHIPPING 1
  $pdf->SetFont('Arial', '', 6);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(151, 60.75);
  $pdf->Write(0, $nombre_comercial_propietario);

  // ADD EMPRESA FERROVIARIA QUE TRANSPORTA 1
  $pdf->SetFont('Arial', '', 6);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(175, 60.75);
  $pdf->Write(0, $empresa_ferroviaria);

  // ADD ORIGEN / DESTINO (FERROVIARIO) 1
  $pdf->SetFont('Arial', '', 6);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(196, 60.75);
  $pdf->Write(0, $origen_destino);

  // ADD BOOKING REFERENCE 1
  $pdf->SetFont('Arial', '', 6);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(230, 60.75);
  $pdf->Write(0, $num_booking_contenedor);

  // ADD PRECINTO 1
  $pdf->SetFont('Arial', '', 6);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(253.5, 60.75);
  $pdf->Write(0, $num_precinto_contenedor);

  // ADD ESPACIO 1
  $pdf->SetFont('Arial', '', 5.5);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(268.5, 60.75);
  $pdf->Write(0, $espacio);

  // ADD ZONA 1
  $pdf->SetFont('Arial', '', 3.5);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(280, 60.75); //+1 EN EJE X, SALTO DE LINEA
  $pdf->Write(0, $zona);

  // ADD Nº CONTENEDOR CESION
  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(56.5, 83.25);
  $pdf->Write(0, $num_contenedor_cesion);

  // ADD EMPRESA A LA QUE CEDE
  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(115, 83.25);
  $pdf->Write(0, $empresa_cede);

  // ADD DOCUMENTO DE CESION - OBSERVACIONES
  $pdf->SetFont('Arial', '', 7);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(173.5, 83.25);
  $pdf->Write(0, $observacion_doc_cesion);

  // ADD NºPI
  $pdf->SetFont('Arial', '', 7);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetXY(230, 96.5);
  $pdf->Write(0, $num_pi);

  //FIN DATOS
  //////////////////////////////////////////////////////////

  $fecha_entrada_salida = date_format($date, "d-m-Y");
  $nombre_archivo_salida = "Acceso_UTI_por_carretera_" . $tipo_movimiento . "_" . $num_expedicion . "_" . $num_contenedor . "_" . $fecha_entrada_salida . ".pdf";
  $pdf->Output('I', $nombre_archivo_salida);
} else {
  echo "Error. Faltan parametros";
}
