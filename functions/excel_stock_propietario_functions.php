<?php
/////////////////////////////////RENFE//////////////////////////////////////////
function excel_stock_renfe($contendores_stock_list, $fecha_stock)
{
  //FORMATO RENFE
  //generamos excel
  if($fecha_stock == date('Y-m-d')){
    $date = date('Y-m-d');
    $date_excel = date('Y-m-d H:i');
    $date_excel = date('Y-m-d H:i',strtotime('+1 hour',strtotime($date_excel)));
  }else{
    $date = date('Y-m-d', strtotime($fecha_stock));
    $date_excel = $date;
  }

  $nombre_comercial_propietario = 'RENFE';
  $filename = "../excel/stocks/".$nombre_comercial_propietario."/Stock_Contenedores_".$nombre_comercial_propietario."_".$date.".xlsx";
  $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
  $activeWorksheet = $spreadsheet->getActiveSheet();

  //Nombre de la hoja activa
  $activeWorksheet->setTitle("Hoja1");

  //Texto para titulo A1
  $activeWorksheet->setCellValue('A1', 'Stock Contenedores '.$nombre_comercial_propietario.' '.$date_excel);
  //Alineación horizontal para la celda A1
  $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal('center');
  //Texto en negrita para la celda A1
  $activeWorksheet->getStyle('A1')->getFont()->setBold(true);
  //Combinamos celdas para titulo de la hoja
  $activeWorksheet->mergeCells('A1:H1');

  //Alineación horizontal para las celdas de cabecera
  $activeWorksheet->getStyle('A2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('B2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('C2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('D2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('E2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('F2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('G2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('H2')->getAlignment()->setHorizontal('center');

  //Alineación vertical para las celdas de cabecera
  $activeWorksheet->getStyle('A2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('B2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('C2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('D2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('E2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('F2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('G2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('H2')->getAlignment()->setVertical('center');

  //Texto en negrita para las celdas de cabecera
  $activeWorksheet->getStyle('A2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('B2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('C2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('D2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('E2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('F2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('G2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('H2')->getFont()->setBold(true);

  //Altura de las celdas de cabecera
  $activeWorksheet->getRowDimension('2')->setRowHeight(34);

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
  //Todos los bordes para la celda cabecera F2
  $activeWorksheet->getStyle('F2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera G2
  $activeWorksheet->getStyle('G2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera H2
  $activeWorksheet->getStyle('H2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

  //Anchura para la columna A
  $activeWorksheet->getColumnDimension('A')->setWidth(18.3); //Nº CONTENEDOR
  //Anchura para la columna B
  $activeWorksheet->getColumnDimension('B')->setWidth(10); //TAMAÑO
  //Anchura para la columna C
  $activeWorksheet->getColumnDimension('C')->setWidth(16.4); // FECHA ENTRADA
  //Anchura para la columna D
  $activeWorksheet->getColumnDimension('D')->setWidth(17.8); //PESO CONTENEDOR
  //Anchura para la columna E
  $activeWorksheet->getColumnDimension('E')->setWidth(8.7); // C/V
  //Anchura para la columna F
  $activeWorksheet->getColumnDimension('F')->setWidth(12.9); // MERCANCIA PELIGROSA
  //Anchura para la columna G
  $activeWorksheet->getColumnDimension('G')->setWidth(34); // CLIENTE RENFE
  //Anchura para la columna H
  $activeWorksheet->getColumnDimension('H')->setWidth(13); // PROPIETARIO

  //Texto para encabezado A2
  $activeWorksheet->setCellValue('A2', 'Nº CONTENEDOR');
  //Texto para encabezado B2
  $activeWorksheet->setCellValue('B2', 'TAMAÑO');
  //Texto para encabezado C2
  $activeWorksheet->setCellValue('C2', 'FECHA ENTRADA');
  //Texto para encabezado D2
  $activeWorksheet->setCellValue('D2', 'PESO CONTENEDOR');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('E2', 'C/V');
  //Texto para encabezado F2
  $activeWorksheet->setCellValue('F2', 'MERCANCIA PELIGROSA');
  //Texto para encabezado G2
  $activeWorksheet->setCellValue('G2', 'CLIENTE RENFE');
  //Texto para encabezado G2
  $activeWorksheet->setCellValue('H2', 'PROPIETARIO');

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
  //Ajustar texto para encabezado F2
  $activeWorksheet->getStyle('F2')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado G2
  $activeWorksheet->getStyle('G2')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado G2
  $activeWorksheet->getStyle('H2')->getAlignment()->setWrapText(true);

  //Columna C en formato fecha
  $activeWorksheet->getStyle('C')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
  //Columna D en formato numero
  $activeWorksheet->getStyle('D')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

  //Por cada linea de contenedores en stock
  foreach ($contendores_stock_list as $key => $contendores_stock_line) {
    //Desfase para fila de cabeceras
    $indice = $key+3;
    //Valor para celda A.$indice
    $activeWorksheet->setCellValue('A'.$indice, $contendores_stock_line['num_contenedor']);
    //Valor para celda B.$indice
    $activeWorksheet->setCellValue('B'.$indice, $contendores_stock_line['longitud_tipo_contenedor']);
    //Valor para celda C.$indice
    $date = date_create($contendores_stock_line['fecha_entrada']);
    $fecha = date_format($date,"d/m/Y");
    $activeWorksheet->setCellValue('C'.$indice, $fecha);
    //Valor para celda D.$indice
    $activeWorksheet->setCellValue('D'.$indice, $contendores_stock_line['peso_mercancia_contenedor']);
    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('E'.$indice, $contendores_stock_line['estado_carga_contenedor']);
    //Valor para celda F.$indice
    if(
      $contendores_stock_line['descripcion_mercancia'] == 'MERCANCÍA PELIGROSA' ||
      $contendores_stock_line['descripcion_mercancia'] == 'VACÍO-SUCIO'
    ){
      $activeWorksheet->setCellValue('F'.$indice, 'SI');
    }else{
      $activeWorksheet->setCellValue('F'.$indice, 'NO');
    }
    //Valor para celda G.$indice
    $activeWorksheet->setCellValue('G'.$indice, $contendores_stock_line['nombre_destinatario']);
    //Valor para celda H.$indice
    $activeWorksheet->setCellValue('H'.$indice, $contendores_stock_line['nombre_comercial_propietario']);

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
    //Todos los bordes para la celda F.$indice
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda G.$indice
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda H.$indice
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  }

  $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
  $writer->save($filename);
  header('Location: '.$filename);
  //unlink('hello world.xlsx');
}
///////////////////////////////// FIN RENFE //////////////////////////////////////////


////////////////////////////SICSA-VALENCIA//////////////////////////////////////
function excel_stock_sicsa($contendores_stock_list, $fecha_stock)
{
  //FORMATO SICSA-VALENCIA
  //generamos excel
  if($fecha_stock == date('Y-m-d')){
    $date = date('Y-m-d');
    $date_excel = date('Y-m-d H:i');
    $date_excel = date('Y-m-d H:i',strtotime('+1 hour',strtotime($date_excel)));
  }else{
    $date = date('Y-m-d', strtotime($fecha_stock));
    $date_excel = $date;
  }

  $nombre_comercial_propietario = 'SICSA-VALENCIA';
  $filename = "../excel/stocks/".$nombre_comercial_propietario."/Stock_Contenedores_".$nombre_comercial_propietario."_".$date.".xlsx";
  $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
  $activeWorksheet = $spreadsheet->getActiveSheet();

  //Nombre de la hoja activa
  $activeWorksheet->setTitle("Hoja1");

  //Texto para titulo A1
  $activeWorksheet->setCellValue('A1', 'Stock Contenedores '.$nombre_comercial_propietario.' '.$date_excel);
  //Alineación horizontal para la celda A1
  $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal('center');
  //Texto en negrita para la celda A1
  $activeWorksheet->getStyle('A1')->getFont()->setBold(true);
  //Combinamos celdas para titulo de la hoja
  $activeWorksheet->mergeCells('A1:F1');

  //Alineación horizontal para las celdas de cabecera
  $activeWorksheet->getStyle('A2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('B2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('C2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('D2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('E2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('F2')->getAlignment()->setHorizontal('center');

  //Alineación vertical para las celdas de cabecera
  $activeWorksheet->getStyle('A2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('B2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('C2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('D2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('E2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('F2')->getAlignment()->setVertical('center');

  //Texto en negrita para las celdas de cabecera
  $activeWorksheet->getStyle('A2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('B2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('C2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('D2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('E2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('F2')->getFont()->setBold(true);

  //Altura de las celdas de cabecera
  $activeWorksheet->getRowDimension('2')->setRowHeight(34);

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
  //Todos los bordes para la celda cabecera F2
  $activeWorksheet->getStyle('F2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

  //Anchura para la columna A
  $activeWorksheet->getColumnDimension('A')->setWidth(18.3); //NUM CONTENEDOR
  //Anchura para la columna B
  $activeWorksheet->getColumnDimension('B')->setWidth(10); // TAMAÑO
  //Anchura para la columna C
  $activeWorksheet->getColumnDimension('C')->setWidth(16.4); // FECHA ENTRADA
  //Anchura para la columna D
  $activeWorksheet->getColumnDimension('D')->setWidth(17.8); // PESO CONTENEDOR
  //Anchura para la columna E
  $activeWorksheet->getColumnDimension('E')->setWidth(8.7); // C/V
  //Anchura para la columna F
  $activeWorksheet->getColumnDimension('F')->setWidth(15.5); // PROPIETARIO

  //Texto para encabezado A2
  $activeWorksheet->setCellValue('A2', 'Nº CONTENEDOR');
  //Texto para encabezado B2
  $activeWorksheet->setCellValue('B2', 'TAMAÑO');
  //Texto para encabezado C2
  $activeWorksheet->setCellValue('C2', 'FECHA ENTRADA');
  //Texto para encabezado D2
  $activeWorksheet->setCellValue('D2', 'PESO CONTENEDOR');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('E2', 'C/V');
  //Texto para encabezado F2
  $activeWorksheet->setCellValue('F2', 'PROPIETARIO');

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
  //Ajustar texto para encabezado F2
  $activeWorksheet->getStyle('F2')->getAlignment()->setWrapText(true);

  //Columna C en formato fecha
  $activeWorksheet->getStyle('C')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
  //Columna D en formato numero
  $activeWorksheet->getStyle('D')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

  //Por cada linea de contenedores en stock
  foreach ($contendores_stock_list as $key => $contendores_stock_line) {
    //Desfase para fila de cabeceras
    $indice = $key+3;
    //Valor para celda A.$indice
    $activeWorksheet->setCellValue('A'.$indice, $contendores_stock_line['num_contenedor']);
    //Valor para celda B.$indice
    $activeWorksheet->setCellValue('B'.$indice, $contendores_stock_line['longitud_tipo_contenedor']);
    //Valor para celda C.$indice
    $date = date_create($contendores_stock_line['fecha_entrada']);
    $fecha = date_format($date,"d/m/Y");
    $activeWorksheet->setCellValue('C'.$indice, $fecha);
    //Valor para celda D.$indice
    $activeWorksheet->setCellValue('D'.$indice, $contendores_stock_line['peso_bruto_contenedor']);
    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('E'.$indice, $contendores_stock_line['estado_carga_contenedor']);
    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('F'.$indice, $contendores_stock_line['nombre_comercial_propietario']);

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
    //Todos los bordes para la celda F.$indice
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  }

  $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
  $writer->save($filename);
  header('Location: '.$filename);
  //unlink('hello world.xlsx');
}
//////////////////////////// FIN SICSA-VALENCIA //////////////////////////////////////

//////////////////////////////CCIS-BILBAO///////////////////////////////////////
function excel_stock_ccis($contendores_stock_list, $fecha_stock)
{
  //FORMATO CCIS-BILBAO
  //generamos excel
  if($fecha_stock == date('Y-m-d')){
    $date = date('Y-m-d');
    $date_excel = date('Y-m-d H:i');
    $date_excel = date('Y-m-d H:i',strtotime('+1 hour',strtotime($date_excel)));
  }else{
    $date = date('Y-m-d', strtotime($fecha_stock));
    $date_excel = $date;
  }

  $nombre_comercial_propietario = 'CCIS-BILBAO';
  $filename = "../excel/stocks/".$nombre_comercial_propietario."/Stock_Contenedores_".$nombre_comercial_propietario."_".$date.".xlsx";
  $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
  $activeWorksheet = $spreadsheet->getActiveSheet();

  //Nombre de la hoja activa
  $activeWorksheet->setTitle("Hoja1");

  //Texto para titulo A1
  $activeWorksheet->setCellValue('A1', 'Stock Contenedores '.$nombre_comercial_propietario.' '.$date_excel);
  //Alineación horizontal para la celda A1
  $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal('center');
  //Texto en negrita para la celda A1
  $activeWorksheet->getStyle('A1')->getFont()->setBold(true);
  //Combinamos celdas para titulo de la hoja
  $activeWorksheet->mergeCells('A1:F1');

  //Alineación horizontal para las celdas de cabecera
  $activeWorksheet->getStyle('A2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('B2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('C2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('D2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('E2')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('F2')->getAlignment()->setHorizontal('center');

  //Alineación vertical para las celdas de cabecera
  $activeWorksheet->getStyle('A2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('B2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('C2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('D2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('E2')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('F2')->getAlignment()->setVertical('center');

  //Texto en negrita para las celdas de cabecera
  $activeWorksheet->getStyle('A2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('B2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('C2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('D2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('E2')->getFont()->setBold(true);
  $activeWorksheet->getStyle('F2')->getFont()->setBold(true);

  //Altura de las celdas de cabecera
  $activeWorksheet->getRowDimension('2')->setRowHeight(34);

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
  //Todos los bordes para la celda cabecera F2
  $activeWorksheet->getStyle('F2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

  //Anchura para la columna A
  $activeWorksheet->getColumnDimension('A')->setWidth(18.3); //Nº CONTENEDOR
  //Anchura para la columna B
  $activeWorksheet->getColumnDimension('B')->setWidth(10); // TAMAÑAO
  //Anchura para la columna C
  $activeWorksheet->getColumnDimension('C')->setWidth(13); //TIPO
  //Anchura para la columna D
  $activeWorksheet->getColumnDimension('D')->setWidth(17.8); //PESO CONTENEDOR
  //Anchura para la columna E
  $activeWorksheet->getColumnDimension('E')->setWidth(8.7); // C/V
  //Anchura para la columna F
  $activeWorksheet->getColumnDimension('F')->setWidth(13); // PROPIETARIO CCIS-BILBAO

  //Texto para encabezado A2
  $activeWorksheet->setCellValue('A2', 'Nº CONTENEDOR');
  //Texto para encabezado B2
  $activeWorksheet->setCellValue('B2', 'TAMAÑO');
  //Texto para encabezado C2
  $activeWorksheet->setCellValue('C2', 'TIPO');
  //Texto para encabezado D2
  $activeWorksheet->setCellValue('D2', 'PESO CONTENEDOR');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('E2', 'C/V');
  //Texto para encabezado F2
  $activeWorksheet->setCellValue('F2', 'PROPIETARIO');

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
  //Ajustar texto para encabezado F2
  $activeWorksheet->getStyle('F2')->getAlignment()->setWrapText(true);

  //Columna D en formato numero
  $activeWorksheet->getStyle('D')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

  //Por cada linea de contenedores en stock
  foreach ($contendores_stock_list as $key => $contendores_stock_line) {
    //Desfase para fila de cabeceras
    $indice = $key+3;
    //Valor para celda A.$indice
    $activeWorksheet->setCellValue('A'.$indice, $contendores_stock_line['num_contenedor']);
    //Valor para celda B.$indice
    $activeWorksheet->setCellValue('B'.$indice, $contendores_stock_line['longitud_tipo_contenedor']);
    //Valor para celda C.$indice
    $activeWorksheet->setCellValue('C'.$indice, $contendores_stock_line['id_tipo_contenedor_iso']);
    //Valor para celda D.$indice
    $activeWorksheet->setCellValue('D'.$indice, $contendores_stock_line['peso_mercancia_contenedor']);
    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('E'.$indice, $contendores_stock_line['estado_carga_contenedor']);
    //Valor para celda F.$indice
    $activeWorksheet->setCellValue('F'.$indice, $contendores_stock_line['nombre_comercial_propietario']);

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
    //Todos los bordes para la celda F.$indice
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  }

  $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
  $writer->save($filename);
  header('Location: '.$filename);
  //unlink('hello world.xlsx');
}
////////////////////////////// FIN CCIS-BILBAO ///////////////////////////////////////

//////////////////////////////CCIS-BILBAO_SICSA-VALENCIA///////////////////////////////////////
function excel_stock_ccis_sicsa($contendores_stock_list, $fecha_stock)
{
  //FORMATO CCIS-BILBAO
  //generamos excel
  if($fecha_stock == date('Y-m-d')){
    $date = date('Y-m-d');
    $date_excel = date('Y-m-d H:i');
    $date_excel = date('Y-m-d H:i',strtotime('+1 hour',strtotime($date_excel)));
  }else{
    $date = date('Y-m-d', strtotime($fecha_stock));
    $date_excel = $date;
  }

  $nombre_comercial_propietario = 'CCIS-BILBAO_SICSA-VALENCIA';
  $filename = "../excel/stocks/".$nombre_comercial_propietario."/Stock_Contenedores_".$nombre_comercial_propietario."_".$date.".xlsx";
  $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
  $activeWorksheet = $spreadsheet->getActiveSheet();

  //Nombre de la hoja activa
  $activeWorksheet->setTitle("Hoja1");

  //Texto para titulo A1
  $activeWorksheet->setCellValue('A1', 'Stock Contenedores '.$nombre_comercial_propietario.' '.$date_excel);
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
  $activeWorksheet->getRowDimension('2')->setRowHeight(34);

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
  //Todos los bordes para la celda cabecera F2
  $activeWorksheet->getStyle('F2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera F2
  $activeWorksheet->getStyle('G2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera F2
  $activeWorksheet->getStyle('H2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera F2
  $activeWorksheet->getStyle('I2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('I2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('I2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('I2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

  //Anchura para la columna A
  $activeWorksheet->getColumnDimension('A')->setWidth(18.3); //Nº CONTENEDOR
  //Anchura para la columna B
  $activeWorksheet->getColumnDimension('B')->setWidth(10); // TAMAÑAO
  //Anchura para la columna C
  $activeWorksheet->getColumnDimension('C')->setWidth(13); //TIPO
  //Anchura para la columna D
  $activeWorksheet->getColumnDimension('D')->setWidth(19); //PESO CONTENEDOR
  //Anchura para la columna D
  $activeWorksheet->getColumnDimension('E')->setWidth(17.8); //PESO CONTENEDOR
  //Anchura para la columna E
  $activeWorksheet->getColumnDimension('F')->setWidth(8.7); // C/V
  //Anchura para la columna C
  $activeWorksheet->getColumnDimension('G')->setWidth(11); //TIPO
  //Anchura para la columna C
  $activeWorksheet->getColumnDimension('H')->setWidth(13); //TIPO
  //Anchura para la columna F
  $activeWorksheet->getColumnDimension('I')->setWidth(15.5); // PROPIETARIO CCIS-BILBAO

  //Texto para encabezado A2
  $activeWorksheet->setCellValue('A2', 'Nº CONTENEDOR');
  //Texto para encabezado B2
  $activeWorksheet->setCellValue('B2', 'TAMAÑO');
  //Texto para encabezado C2
  $activeWorksheet->setCellValue('C2', 'TIPO');
  //Texto para encabezado D2
  $activeWorksheet->setCellValue('D2', 'DESCRIPCIÓN');
  //Texto para encabezado D2
  $activeWorksheet->setCellValue('E2', 'PESO CONTENEDOR');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('F2', 'C/V');
  //Texto para encabezado F2
  $activeWorksheet->setCellValue('G2', 'FECHA ENTRADA');
  //Texto para encabezado F2
  $activeWorksheet->setCellValue('H2', 'INCIDENCIA');
  //Texto para encabezado F2
  $activeWorksheet->setCellValue('I2', 'PROPIETARIO');

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
  //Ajustar texto para encabezado F2
  $activeWorksheet->getStyle('F2')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado F2
  $activeWorksheet->getStyle('G2')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado F2
  $activeWorksheet->getStyle('H2')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado F2
  $activeWorksheet->getStyle('I2')->getAlignment()->setWrapText(true);

  //Columna en formato numero
  $activeWorksheet->getStyle('E')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
  //Columna en formato fecha
  $activeWorksheet->getStyle('G')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);

  //Por cada linea de contenedores en stock
  foreach ($contendores_stock_list as $key => $contendores_stock_line) {
    //Desfase para fila de cabeceras
    $indice = $key+3;
    //Valor para celda A.$indice
    $activeWorksheet->setCellValue('A'.$indice, $contendores_stock_line['num_contenedor']);
    //Valor para celda B.$indice
    $activeWorksheet->setCellValue('B'.$indice, $contendores_stock_line['longitud_tipo_contenedor']);
    //Valor para celda C.$indice
    $activeWorksheet->setCellValue('C'.$indice, $contendores_stock_line['id_tipo_contenedor_iso']);
    //Valor para celda D.$indice
    $activeWorksheet->setCellValue('D'.$indice, $contendores_stock_line['descripcion_tipo_contenedor']);
    //Valor para celda D.$indice
    $activeWorksheet->setCellValue('E'.$indice, $contendores_stock_line['peso_mercancia_contenedor']);
    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('F'.$indice, $contendores_stock_line['estado_carga_contenedor']);
    //Valor para celda E.$indice
    //Valor para celda E.$indice
    $date = date_create($contendores_stock_line['fecha_entrada']);
    $fecha = date_format($date,"d/m/Y");
    $activeWorksheet->setCellValue('G'.$indice, $fecha);
    //Valor para celda E.$indice
    if($contendores_stock_line['incidencia'] != ''){
      $activeWorksheet->setCellValue('H'.$indice, 'SI');
    }
    //Valor para celda F.$indice
    $activeWorksheet->setCellValue('I'.$indice, $contendores_stock_line['nombre_comercial_propietario']);
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('C'.$indice)->getAlignment()->setHorizontal('right');

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
    //Todos los bordes para la celda F.$indice
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda F.$indice
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda F.$indice
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda F.$indice
    $activeWorksheet->getStyle('I'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

  }

  $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
  $writer->save($filename);
  header('Location: '.$filename);
  //unlink('hello world.xlsx');
}
////////////////////////////// FIN CCIS-BILBAO_SICSA-VALENCIA ///////////////////////////////////////
?>
