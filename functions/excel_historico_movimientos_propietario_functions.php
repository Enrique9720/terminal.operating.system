<?php
/////////////////////////////////RENFE ENTRADA CAMION//////////////////////////////////////////
function excel_historico_movimientos_renfe_entrada_camion($movimientos_entrada_list, $fecha_inicio, $fecha_fin)
{
  //FORMATO RENFE
  //generamos excel

  $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
  $fecha_fin = date('Y-m-d', strtotime($fecha_fin));

  $nombre_comercial_propietario = 'RENFE';
  $filename = "../excel/historico_movimientos/".$nombre_comercial_propietario."/Historico_movimientos_entrada_camion_".$nombre_comercial_propietario."_DEL_".$fecha_inicio."_AL_".$fecha_fin.".xlsx";
  $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();

  // Set default font type to 'Arial'
  $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
  // Set default font size to '12'
  $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

  $activeWorksheet = $spreadsheet->getActiveSheet();

  //Nombre de la hoja activa
  $activeWorksheet->setTitle("ENTRADAS CAMION");

  //Alineación horizontal para las celdas de cabecera
  $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('B1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('C1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('D1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('E1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('F1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('G1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('H1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('I1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('J1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('K1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('L1')->getAlignment()->setHorizontal('center');

  //Alineación vertical para las celdas de cabecera
  $activeWorksheet->getStyle('A1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('B1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('C1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('D1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('E1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('F1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('G1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('H1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('I1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('J1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('K1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('L1')->getAlignment()->setVertical('center');

  //Texto en negrita para las celdas de cabecera
  $activeWorksheet->getStyle('A1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('B1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('C1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('D1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('E1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('F1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('G1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('H1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('I1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('J1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('K1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('L1')->getFont()->setBold(true);

  //Altura de las celdas de cabecera
  $activeWorksheet->getRowDimension('1')->setRowHeight(12.75);

  //Anchura para la columna A
  $activeWorksheet->getColumnDimension('A')->setWidth(21);
  //Anchura para la columna B
  $activeWorksheet->getColumnDimension('B')->setWidth(18);
  //Anchura para la columna C
  $activeWorksheet->getColumnDimension('C')->setWidth(11.7);
  //Anchura para la columna C
  $activeWorksheet->getColumnDimension('D')->setWidth(10.5);
  //Anchura para la columna D
  $activeWorksheet->getColumnDimension('E')->setWidth(10.6);
  //Anchura para la columna E
  $activeWorksheet->getColumnDimension('F')->setWidth(14.3);
  //Anchura para la columna E
  $activeWorksheet->getColumnDimension('G')->setWidth(8.6);
  //Anchura para la columna E
  $activeWorksheet->getColumnDimension('H')->setWidth(11.7);
  //Anchura para la columna Es
  $activeWorksheet->getColumnDimension('I')->setWidth(10.6);
  //Anchura para la columna Es
  $activeWorksheet->getColumnDimension('J')->setWidth(17.7);
  //Anchura para la columna Es
  $activeWorksheet->getColumnDimension('K')->setWidth(14.5);
  //Anchura para la columna Es
  $activeWorksheet->getColumnDimension('L')->setWidth(50);

  //Todos los bordes para la celda cabecera A2
  $activeWorksheet->getStyle('A1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('A1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('A1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('A1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera B2
  $activeWorksheet->getStyle('B1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('B1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('B1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('B1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera C2
  $activeWorksheet->getStyle('C1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('C1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('C1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('C1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera D2
  $activeWorksheet->getStyle('D1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('D1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('D1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('D1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('E1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('E1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('E1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('E1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('F1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('G1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('H1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('I1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('I1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('I1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('I1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('J1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('J1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('J1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('J1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('K1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('K1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('K1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('K1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('L1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('L1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('L1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('L1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Color de fondo para encabezado
  $activeWorksheet->getStyle('A1:L1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('002E65');
  //Color de la fuente para encabezado
  $activeWorksheet->getStyle('A1:L1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

  //Texto para encabezado A2
  $activeWorksheet->setCellValue('A1', 'Destino');
  //Texto para encabezado B2
  $activeWorksheet->setCellValue('B1', 'Contenedor');
  //Texto para encabezado C2
  $activeWorksheet->setCellValue('C1', 'Modelo');
  //Texto para encabezado D2
  $activeWorksheet->setCellValue('D1', 'C/V');
  //Texto para encabezado C2
  $activeWorksheet->setCellValue('E1', 'ONU');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('F1', 'Fecha Ent');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('G1', ' Hora');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('H1', 'Peso Neto');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('I1', 'Tara');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('J1', 'Tarjeta Cliente');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('K1', 'Camión');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('L1', 'Mercancía Peligrosa Para El Medio Ambiente');

  //Ajustar texto para encabezado A2
  $activeWorksheet->getStyle('A1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado B2
  $activeWorksheet->getStyle('B1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado C2
  $activeWorksheet->getStyle('C1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado D2
  $activeWorksheet->getStyle('D1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('E1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('F1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('G1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('H1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('I1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('J1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('K1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('L1')->getAlignment()->setWrapText(true);

  //Columna D en formato numero
  $activeWorksheet->getStyle('H')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
  //Columna D en formato numero
  $activeWorksheet->getStyle('I')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
  //Columna C en formato fecha
  $activeWorksheet->getStyle('F')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);

  //Desfase para fila de cabeceras
  $indice = 2;
  foreach ($movimientos_entrada_list as $key => $movimientos_entrada_line) {
    if($movimientos_entrada_line['tipo_movimiento'] == 'ENTRADA CAMIÓN'){
      //Valor para celda A.$indice
      $activeWorksheet->setCellValue('A'.$indice, $movimientos_entrada_line['nombre_estacion_ferrocarril']);
      //Valor para celda B.$indice
      $activeWorksheet->setCellValue('B'.$indice, $movimientos_entrada_line['num_contenedor']);
      //Valor para celda C.$indice
      $activeWorksheet->setCellValue('C'.$indice, $movimientos_entrada_line['longitud_tipo_contenedor']);
      //Valor para celda D.$indice
      $activeWorksheet->setCellValue('D'.$indice, $movimientos_entrada_line['estado_carga_contenedor']);
      //Valor para celda D.$indice
      if($movimientos_entrada_line['num_peligro_adr'] != '' && $movimientos_entrada_line['num_onu_adr'] != ''){
        $adr = $movimientos_entrada_line['num_peligro_adr'].'/'.$movimientos_entrada_line['num_onu_adr'];
      }else{
        $adr = 'NO';
      }
      $activeWorksheet->setCellValue('E'.$indice, $adr);

      //Valor para celda E.$indice
      $date = date_create($movimientos_entrada_line['fecha']);
      $fecha = date_format($date,"d/m/Y");
      $activeWorksheet->setCellValue('F'.$indice, $fecha);

      //Valor para celda F.$indice
      $hora = date_format($date,"H:i");
      $activeWorksheet->setCellValue('G'.$indice, $hora);

      //Valor para celda E.$indice
      $activeWorksheet->setCellValue('H'.$indice, $movimientos_entrada_line['peso_mercancia']);
      //Valor para celda E.$indice
      $activeWorksheet->setCellValue('I'.$indice, $movimientos_entrada_line['tara_contenedor']);
      //Valor para celda E.$indice
      $activeWorksheet->setCellValue('J'.$indice, $movimientos_entrada_line['num_tarjeta_teco']);
      //Valor para celda E.$indice
      $activeWorksheet->setCellValue('K'.$indice, $movimientos_entrada_line['matricula_tractora']);
      //Valor para celda E.$indice
      $activeWorksheet->setCellValue('L'.$indice, $movimientos_entrada_line['materia_peligrosa']);

      //Todos los bordes para la celda A.$indice
      $activeWorksheet->getStyle('A'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('A'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('A'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('A'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda B.$indice
      $activeWorksheet->getStyle('B'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('B'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('B'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('B'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda C.$indice
      $activeWorksheet->getStyle('C'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('C'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('C'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('C'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda D.$indice
      $activeWorksheet->getStyle('D'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('D'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('D'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('D'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda E.$indice
      $activeWorksheet->getStyle('E'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('E'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('E'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('E'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda E.$indice
      $activeWorksheet->getStyle('F'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('F'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('F'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('F'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda E.$indice
      $activeWorksheet->getStyle('G'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('G'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('G'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('G'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda E.$indice
      $activeWorksheet->getStyle('H'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('H'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('H'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('H'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda E.$indice
      $activeWorksheet->getStyle('I'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('I'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('I'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('I'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda E.$indice
      $activeWorksheet->getStyle('J'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('J'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('J'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('J'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda E.$indice
      $activeWorksheet->getStyle('K'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('K'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('K'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('K'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda E.$indice
      $activeWorksheet->getStyle('L'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('L'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('L'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('L'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

      //Alineación horizontal para las celdas de cabecera
      $activeWorksheet->getStyle('A'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('B'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('C'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('D'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('E'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('F'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('G'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('H'.$indice)->getAlignment()->setHorizontal('right');
      $activeWorksheet->getStyle('I'.$indice)->getAlignment()->setHorizontal('right');
      $activeWorksheet->getStyle('J'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('K'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('L'.$indice)->getAlignment()->setHorizontal('center');

      $indice = $indice+1;
    }
  }

  $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
  $writer->save($filename);
  header('Location: '.$filename);
}
/////////////////////////////////RENFE ENTRADA CAMION//////////////////////////////////////////


/////////////////////////////////RENFE SALIDA CAMION//////////////////////////////////////////
function excel_historico_movimientos_renfe_salida_camion($movimientos_salida_list, $fecha_inicio, $fecha_fin)
{
  //FORMATO RENFE
  //generamos excel

  $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
  $fecha_fin = date('Y-m-d', strtotime($fecha_fin));

  $nombre_comercial_propietario = 'RENFE';
  $filename = "../excel/historico_movimientos/".$nombre_comercial_propietario."/Historico_movimientos_salida_camion_".$nombre_comercial_propietario."_DEL_".$fecha_inicio."_AL_".$fecha_fin.".xlsx";
  $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();

  // Set default font type to 'Arial'
  $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
  // Set default font size to '12'
  $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

  $activeWorksheet = $spreadsheet->getActiveSheet();

  //Nombre de la hoja activa
  $activeWorksheet->setTitle("SALIDAS CAMION");

  //Alineación horizontal para las celdas de cabecera
  $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('B1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('C1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('D1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('E1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('F1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('G1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('H1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('I1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('J1')->getAlignment()->setHorizontal('center');

  //Alineación vertical para las celdas de cabecera
  $activeWorksheet->getStyle('A1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('B1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('C1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('D1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('E1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('F1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('G1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('H1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('I1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('J1')->getAlignment()->setVertical('center');

  //Texto en negrita para las celdas de cabecera
  $activeWorksheet->getStyle('A1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('B1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('C1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('D1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('E1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('F1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('G1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('H1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('I1')->getFont()->setBold(true);
  $activeWorksheet->getStyle('J1')->getFont()->setBold(true);

  //Altura de las celdas de cabecera
  $activeWorksheet->getRowDimension('1')->setRowHeight(12.75);

  //Anchura para la columna A
  $activeWorksheet->getColumnDimension('A')->setWidth(21); //CONTENEDOR
  //Anchura para la columna B
  $activeWorksheet->getColumnDimension('B')->setWidth(11.6); //MODELO
  //Anchura para la columna C
  $activeWorksheet->getColumnDimension('C')->setWidth(17.5); //FECHA SALIDA
  //Anchura para la columna C
  $activeWorksheet->getColumnDimension('D')->setWidth(15); //HORA SALIDA
  //Anchura para la columna D
  $activeWorksheet->getColumnDimension('E')->setWidth(8); // C/V
  //Anchura para la columna E
  $activeWorksheet->getColumnDimension('F')->setWidth(11.3); // PESO
  //Anchura para la columna E
  $activeWorksheet->getColumnDimension('G')->setWidth(22.2); //TARJETA CLIENTE
  //Anchura para la columna E
  $activeWorksheet->getColumnDimension('H')->setWidth(15.3); //CAMION
  //Anchura para la columna E
  $activeWorksheet->getColumnDimension('I')->setWidth(24.2); //MODO ENT
  //Anchura para la columna E
  $activeWorksheet->getColumnDimension('J')->setWidth(50); //PEGATINA

  //Todos los bordes para la celda cabecera A2
  $activeWorksheet->getStyle('A1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('A1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('A1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('A1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera B2
  $activeWorksheet->getStyle('B1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('B1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('B1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('B1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera C2
  $activeWorksheet->getStyle('C1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('C1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('C1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('C1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera D2
  $activeWorksheet->getStyle('D1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('D1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('D1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('D1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('E1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('E1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('E1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('E1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('F1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('G1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('H1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('I1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('I1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('I1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('I1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('J1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('J1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('J1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('J1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

  //Color de fondo para encabezado
  $activeWorksheet->getStyle('A1:J1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('002E65');
  //Color de la fuente para encabezado
  $activeWorksheet->getStyle('A1:J1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);

  //Texto para encabezado A2
  $activeWorksheet->setCellValue('A1', 'Contenedor');
  //Texto para encabezado B2
  $activeWorksheet->setCellValue('B1', 'Modelo');
  //Texto para encabezado C2
  $activeWorksheet->setCellValue('C1', 'FechaSal');
  //Texto para encabezado D2
  $activeWorksheet->setCellValue('D1', 'HoraSal');
  //Texto para encabezado C2
  $activeWorksheet->setCellValue('E1', 'CV');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('F1', 'Peso Bruto');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('G1', 'Tarjeta Cliente');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('H1', 'Camion');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('I1', 'ModoEnt');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('J1', 'Mercancía Peligrosa Para El Medio Ambiente');

  //Ajustar texto para encabezado A2
  $activeWorksheet->getStyle('A1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado B2
  $activeWorksheet->getStyle('B1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado C2
  $activeWorksheet->getStyle('C1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado D2
  $activeWorksheet->getStyle('D1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('E1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('F1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('G1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('H1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('I1')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('J1')->getAlignment()->setWrapText(true);

  //Columna D en formato numero
  $activeWorksheet->getStyle('F')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
  //Columna C en formato fecha
  $activeWorksheet->getStyle('C')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);

  //Desfase para fila de cabeceras
  $indice = 2;

  foreach ($movimientos_salida_list as $key => $movimientos_salida_line) {
    if($movimientos_salida_line['tipo_movimiento'] == 'SALIDA CAMIÓN'){
      //Valor para celda A.$indice
      $activeWorksheet->setCellValue('A'.$indice, $movimientos_salida_line['num_contenedor']);
      //Valor para celda B.$indice
      $activeWorksheet->setCellValue('B'.$indice, $movimientos_salida_line['longitud_tipo_contenedor']);

      //Valor para celda E.$indice
      $date = date_create($movimientos_salida_line['fecha']);
      $fecha = date_format($date,"d/m/Y");
      $activeWorksheet->setCellValue('C'.$indice, $fecha);

      //Valor para celda F.$indice
      $hora = date_format($date,"H:i");
      $activeWorksheet->setCellValue('D'.$indice, $hora);

      //Valor para celda D.$indice
      $activeWorksheet->setCellValue('E'.$indice, $movimientos_salida_line['estado_carga_contenedor']);

      //Valor para celda F.$indice
      $activeWorksheet->setCellValue('F'.$indice, $movimientos_salida_line['peso_bruto']);

      //Valor para celda F.$indice
      $activeWorksheet->setCellValue('G'.$indice, $movimientos_salida_line['num_tarjeta_teco']);

      //Valor para celda E.$indice
      $activeWorksheet->setCellValue('H'.$indice, $movimientos_salida_line['matricula_tractora']);
      //Valor para celda E.$indice
      //$activeWorksheet->setCellValue('I'.$indice, $movimientos_salida_line['matricula_tractora']);
      //Valor para celda E.$indice
      $activeWorksheet->setCellValue('J'.$indice, $movimientos_salida_line['materia_peligrosa']);

      //Todos los bordes para la celda A.$indice
      $activeWorksheet->getStyle('A'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('A'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('A'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('A'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda B.$indice
      $activeWorksheet->getStyle('B'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('B'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('B'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('B'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda C.$indice
      $activeWorksheet->getStyle('C'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('C'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('C'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('C'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda D.$indice
      $activeWorksheet->getStyle('D'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('D'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('D'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('D'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda E.$indice
      $activeWorksheet->getStyle('E'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('E'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('E'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('E'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda E.$indice
      $activeWorksheet->getStyle('F'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('F'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('F'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('F'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda E.$indice
      $activeWorksheet->getStyle('G'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('G'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('G'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('G'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda E.$indice
      $activeWorksheet->getStyle('H'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('H'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('H'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('H'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda E.$indice
      $activeWorksheet->getStyle('H'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('H'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('H'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('H'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda E.$indice
      $activeWorksheet->getStyle('I'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('I'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('I'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('I'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      //Todos los bordes para la celda E.$indice
      $activeWorksheet->getStyle('J'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('J'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('J'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
      $activeWorksheet->getStyle('J'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

      //Alineación horizontal para las celdas de cabecera
      $activeWorksheet->getStyle('A'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('B'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('C'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('D'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('E'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('F'.$indice)->getAlignment()->setHorizontal('right');
      $activeWorksheet->getStyle('G'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('H'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('I'.$indice)->getAlignment()->setHorizontal('center');
      $activeWorksheet->getStyle('J'.$indice)->getAlignment()->setHorizontal('center');

      $indice = $indice+1;
    }
  }

  $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
  $writer->save($filename);
  header('Location: '.$filename);

}
/////////////////////////////////RENFE SALIDA CAMION//////////////////////////////////////////




//////////////////////////////CCIS-BILBAO SICSA-VALENCIA///////////////////////////////////////
function excel_historico_movimientos_ccis_sicsa($movimientos_entrada_list, $movimientos_salida_list, $fecha_inicio, $fecha_fin)
{
  //FORMATO CCIS-BILBAO SICSA-VALENCIA
  //generamos excel

  $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
  $fecha_fin = date('Y-m-d', strtotime($fecha_fin));

  $nombre_comercial_propietario = 'CCIS-BILBAO_SICSA-VALENCIA';
  $filename = "../excel/historico_movimientos/".$nombre_comercial_propietario."/Historico_movimientos_".$nombre_comercial_propietario."_DEL_".$fecha_inicio."_AL_".$fecha_fin.".xlsx";
  $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
  $activeWorksheet = $spreadsheet->getActiveSheet();

  //Nombre de la hoja activa
  $activeWorksheet->setTitle("Hoja1");

  //Texto para titulo A1
  $activeWorksheet->setCellValue('A1', 'Histórico Movimientos '.$nombre_comercial_propietario." del ".$fecha_inicio." al ".$fecha_fin);
  //Alineación horizontal para la celda A1
  $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal('center');
  //Texto en negrita para la celda A1
  $activeWorksheet->getStyle('A1')->getFont()->setBold(true);
  //Combinamos celdas para titulo de la hoja
  $activeWorksheet->mergeCells('A1:I1');


  //Alineación horizontal para las celdas de cabecera
  $activeWorksheet->getStyle('A2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('B2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('C2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('D2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('E2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('F2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('G2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('H2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('I2')->getAlignment()->setHorizontal('center');

  //Alineación vertical para las celdas de cabecera
  $activeWorksheet->getStyle('A2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('B2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('C2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('D2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('E2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('F2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('G2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('H2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('I2')->getAlignment()->setVertical('center');

  //Texto en negrita para las celdas de cabecera
  $activeWorksheet->getStyle('A2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('B2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('C2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('D2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('E2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('F2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('G2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('H2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('I2')->getFont()->setBold(true);

  //Altura de las celdas de cabecera
  $activeWorksheet->getRowDimension('2')->setRowHeight(30);

  //Anchura para la columna A
  $activeWorksheet->getColumnDimension('A')->setWidth(16);
  //Anchura para la columna B
  $activeWorksheet->getColumnDimension('B')->setWidth(19);
  //Anchura para la columna C
  $activeWorksheet->getColumnDimension('C')->setWidth(17);
  //Anchura para la columna C
  $activeWorksheet->getColumnDimension('D')->setWidth(10);
  //Anchura para la columna D
  $activeWorksheet->getColumnDimension('E')->setWidth(19);
  //Anchura para la columna E
  $activeWorksheet->getColumnDimension('F')->setWidth(11);
  //Anchura para la columna E
  $activeWorksheet->getColumnDimension('G')->setWidth(22);
  //Anchura para la columna E
  $activeWorksheet->getColumnDimension('H')->setWidth(13);
  //Anchura para la columna Es
  $activeWorksheet->getColumnDimension('I')->setWidth(5);

  //Todos los bordes para la celda cabecera A2
  $activeWorksheet->getStyle('A2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('A2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('A2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('A2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera B2
  $activeWorksheet->getStyle('B2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('B2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('B2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('B2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera C2
  $activeWorksheet->getStyle('C2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('C2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('C2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('C2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera D2
  $activeWorksheet->getStyle('D2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('D2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('D2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('D2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('E2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('E2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('E2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('E2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('F2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('G2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('H2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('I2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('I2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('I2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('I2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

  //Texto para encabezado A2
  $activeWorksheet->setCellValue('A2', 'PROPIETARIO');
  //Texto para encabezado B2
  $activeWorksheet->setCellValue('B2', 'TIPO MOVIMIENTO');
  //Texto para encabezado C2
  $activeWorksheet->setCellValue('C2', 'Nº CONTENEDOR');
  //Texto para encabezado D2
  $activeWorksheet->setCellValue('D2', 'TAMAÑO');
  //Texto para encabezado C2
  $activeWorksheet->setCellValue('E2', 'DESCRIPCIÓN');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('F2', 'FECHA');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('G2', ' CAMION / TREN');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('H2', 'PESO CONTENEDOR');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('I2', 'C/V');

  //Ajustar texto para encabezado A2
  $activeWorksheet->getStyle('A2')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado B2
  $activeWorksheet->getStyle('B2')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado C2
  $activeWorksheet->getStyle('C2')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado D2
  $activeWorksheet->getStyle('D2')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('E2')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('F2')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('G2')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('H2')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('I2')->getAlignment()->setWrapText(true);


  //Columna C en formato fecha
  $activeWorksheet->getStyle('G')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
  //Columna D en formato numero
  $activeWorksheet->getStyle('H')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
  //Columna C en formato fecha
  $activeWorksheet->getStyle('F')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);


  //Desfase para fila de cabeceras
  $indice = 3;
  foreach ($movimientos_entrada_list as $key => $movimientos_entrada_line) {
    //Valor para celda A.$indice
    $activeWorksheet->setCellValue('A'.$indice, $movimientos_entrada_line['nombre_comercial_propietario']);
    //Valor para celda B.$indice
    $activeWorksheet->setCellValue('B'.$indice, $movimientos_entrada_line['tipo_movimiento']);
    //Valor para celda C.$indice
    $activeWorksheet->setCellValue('C'.$indice, $movimientos_entrada_line['num_contenedor']);
    //Valor para celda D.$indice
    $activeWorksheet->setCellValue('D'.$indice, $movimientos_entrada_line['longitud_tipo_contenedor']);
    //Valor para celda D.$indice
    $activeWorksheet->setCellValue('E'.$indice, $movimientos_entrada_line['descripcion_tipo_contenedor']);

    //Valor para celda E.$indice
    $date = date_create($movimientos_entrada_line['fecha']);
    $fecha = date_format($date,"d/m/Y");
    $activeWorksheet->setCellValue('F'.$indice, $fecha);

    //Valor para celda F.$indice
    if($historico_movimiento_line['tipo_movimiento'] == 'ENTRADA TREN' || $movimientos_entrada_line['tipo_movimiento'] == 'SALIDA TREN'){
      $historico_movimiento_line['num_expedicion2'] = explode("-", $movimientos_entrada_line['num_expedicion2'])[0];
    }
    $activeWorksheet->setCellValue('G'.$indice, $movimientos_entrada_line['num_expedicion2']);

    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('H'.$indice, $movimientos_entrada_line['peso_bruto']);
    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('I'.$indice, $movimientos_entrada_line['estado_carga_contenedor']);

    //Todos los bordes para la celda A.$indice
    $activeWorksheet->getStyle('A'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda B.$indice
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda C.$indice
    $activeWorksheet->getStyle('C'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('C'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('C'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('C'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda D.$indice
    $activeWorksheet->getStyle('D'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('D'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('D'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('D'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda E.$indice
    $activeWorksheet->getStyle('E'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda E.$indice
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda E.$indice
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda E.$indice
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda E.$indice
    $activeWorksheet->getStyle('I'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


    $indice = $indice+1;
  }

  foreach ($movimientos_salida_list as $key => $movimientos_salida_line) {
    //Valor para celda A.$indice
    $activeWorksheet->setCellValue('A'.$indice, $movimientos_salida_line['nombre_comercial_propietario']);
    //Valor para celda B.$indice
    $activeWorksheet->setCellValue('B'.$indice, $movimientos_salida_line['tipo_movimiento']);
    //Valor para celda C.$indice
    $activeWorksheet->setCellValue('C'.$indice, $movimientos_salida_line['num_contenedor']);
    //Valor para celda D.$indice
    $activeWorksheet->setCellValue('D'.$indice, $movimientos_salida_line['longitud_tipo_contenedor']);
    //Valor para celda D.$indice
    $activeWorksheet->setCellValue('E'.$indice, $movimientos_salida_line['descripcion_tipo_contenedor']);

    //Valor para celda E.$indice
    $date = date_create($movimientos_salida_line['fecha']);
    $fecha = date_format($date,"d/m/Y");
    $activeWorksheet->setCellValue('F'.$indice, $fecha);

    //Valor para celda F.$indice
    if($historico_movimiento_line['tipo_movimiento'] == 'ENTRADA TREN' || $movimientos_salida_line['tipo_movimiento'] == 'SALIDA TREN'){
      $historico_movimiento_line['num_expedicion2'] = explode("-", $movimientos_salida_line['num_expedicion2'])[0];
    }
    $activeWorksheet->setCellValue('G'.$indice, $movimientos_salida_line['num_expedicion2']);

    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('H'.$indice, $movimientos_salida_line['peso_bruto']);
    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('I'.$indice, $movimientos_salida_line['estado_carga_contenedor']);

    //Todos los bordes para la celda A.$indice
    $activeWorksheet->getStyle('A'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda B.$indice
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda C.$indice
    $activeWorksheet->getStyle('C'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('C'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('C'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('C'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda D.$indice
    $activeWorksheet->getStyle('D'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('D'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('D'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('D'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda E.$indice
    $activeWorksheet->getStyle('E'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda E.$indice
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda E.$indice
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda E.$indice
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda E.$indice
    $activeWorksheet->getStyle('I'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    $indice = $indice+1;
  }

  $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
  $writer->save($filename);
  header('Location: '.$filename);
  //unlink('hello world.xlsx');
}
//////////////////////////////CCIS-BILBAO SICSA-VALENCIA///////////////////////////////////////

?>
