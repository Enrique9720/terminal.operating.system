<?php
/////////////////////////////////RENFE//////////////////////////////////////////
function excel_pie_tren_salida_renfe($salida_tren_list)
{
  //FORMATO RENFE
  //generamos excel
  $num_expedicion_salida = explode("-", $salida_tren_list[0]['num_expedicion'])[0];
  $fecha_salida = date_create($salida_tren_list[0]['fecha_salida']);
  $date = date_format($fecha_salida, 'Y-m-d');
  $date_excel = date_format($fecha_salida, 'd/m/Y');
  $nombre_comercial_propietario = 'RENFE';
  $filename = "../excel/salidas_tren/".$nombre_comercial_propietario."/Pie_Tren_Salida_".$nombre_comercial_propietario."_".$date.".xlsx";
  $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();

  // Set default font type to 'Arial'
  $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
  // Set default font size to '12'
  $spreadsheet->getDefaultStyle()->getFont()->setSize(12);

  $activeWorksheet = $spreadsheet->getActiveSheet();

  //Nombre de la hoja activa
  $activeWorksheet->setTitle("Hoja1");

  // Prepare the drawing object
  $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
  // Set the picture name
  $drawing->setName('logo_renfe');
  // Set the picture path
  $drawing->setPath('../images/logo_renfe.jpg');
  $drawing->setHeight(59.7);
  $drawing->setOffsetX(59.5);
  $drawing->setOffsetY(1);
  // Set the cell address where the picture will be inserted
  $drawing->setCoordinates('J1');
  // Add the drawing to the worksheet
  $drawing->setWorksheet($spreadsheet->getActiveSheet());

  //Combinamos celdas para titulo de la hoja
  $activeWorksheet->mergeCells('D1:I1');
  $activeWorksheet->mergeCells('C3:J3');
  $activeWorksheet->mergeCells('C5:J5');
  $activeWorksheet->mergeCells('H7:K8');
  $activeWorksheet->mergeCells('A10:A11');
  $activeWorksheet->mergeCells('B10:C10');
  $activeWorksheet->mergeCells('D10:G10');
  $activeWorksheet->mergeCells('H10:I10');
  $activeWorksheet->mergeCells('J10:K10');

  //Alineación horizontal para las celdas de cabecera
  $activeWorksheet->getStyle('D1')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('C3')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('C5')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('B7')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('D7')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('H7')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('B8')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('D8')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('A10')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('B10')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('D10')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('H10')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('J10')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('B11')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('C11')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('D11')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('E11')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('F11')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('G11')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('H11')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('I11')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('J11')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('K11')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('M11')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('N11')->getAlignment()->setHorizontal('center');

  //Alineación vertical para las celdas de cabecera
  $activeWorksheet->getStyle('D1')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('C3')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('B7')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('D7')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('H7')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('B8')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('D8')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('B10')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('D10')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('H10')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('J10')->getAlignment()->setVertical('center');
  //Alineación vertical para las celdas de cabecera
  $activeWorksheet->getStyle('B11')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('C11')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('D11')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('E11')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('F11')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('G11')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('H11')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('I11')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('J11')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('K11')->getAlignment()->setVertical('center');

  //Tamaño de fuente
  $activeWorksheet->getStyle("D1")->getFont()->setSize(14);
  $activeWorksheet->getStyle("B7")->getFont()->setSize(10);
  $activeWorksheet->getStyle("D7")->getFont()->setSize(10);
  $activeWorksheet->getStyle("B8")->getFont()->setSize(14);
  $activeWorksheet->getStyle("D8")->getFont()->setSize(14);
  $activeWorksheet->getStyle("A10")->getFont()->setSize(8);
  $activeWorksheet->getStyle("B10")->getFont()->setSize(10);
  $activeWorksheet->getStyle("D10")->getFont()->setSize(10);
  $activeWorksheet->getStyle("H10")->getFont()->setSize(10);
  $activeWorksheet->getStyle("J10")->getFont()->setSize(10);
  $activeWorksheet->getStyle("B11")->getFont()->setSize(10);
  $activeWorksheet->getStyle("C11")->getFont()->setSize(10);
  $activeWorksheet->getStyle("D11")->getFont()->setSize(10);
  $activeWorksheet->getStyle("E11")->getFont()->setSize(10);
  $activeWorksheet->getStyle("F11")->getFont()->setSize(10);
  $activeWorksheet->getStyle("G11")->getFont()->setSize(10);
  $activeWorksheet->getStyle("H11")->getFont()->setSize(10);
  $activeWorksheet->getStyle("I11")->getFont()->setSize(10);
  $activeWorksheet->getStyle("J11")->getFont()->setSize(10);
  $activeWorksheet->getStyle("K11")->getFont()->setSize(10);
  $activeWorksheet->getStyle("M11")->getFont()->setSize(10);
  $activeWorksheet->getStyle("N11")->getFont()->setSize(10);

  //Texto en negrita para las celdas de cabecera
  $activeWorksheet->getStyle('D1')->getFont()->setBold(true);
  //Texto en negrita para las celdas de cabecera
  $activeWorksheet->getStyle('C3')->getFont()->setBold(true);
  //Texto en negrita para las celdas de cabecera
  $activeWorksheet->getStyle('C5')->getFont()->setBold(true);
  //Texto en negrita para las celdas de cabecera
  $activeWorksheet->getStyle('B7')->getFont()->setBold(true);
  $activeWorksheet->getStyle('D7')->getFont()->setBold(true);
  $activeWorksheet->getStyle('H7')->getFont()->setBold(true);
  //Texto en negrita para las celdas de cabecera
  $activeWorksheet->getStyle('B8')->getFont()->setBold(true);
  $activeWorksheet->getStyle('D8')->getFont()->setBold(true);
  //Texto en negrita para las celdas de cabecera
  $activeWorksheet->getStyle('B10')->getFont()->setBold(true);
  $activeWorksheet->getStyle('D10')->getFont()->setBold(true);
  $activeWorksheet->getStyle('H10')->getFont()->setBold(true);
  $activeWorksheet->getStyle('J10')->getFont()->setBold(true);
  //Texto en negrita para las celdas de cabecera
  $activeWorksheet->getStyle('B11')->getFont()->setBold(true);
  $activeWorksheet->getStyle('C11')->getFont()->setBold(true);
  $activeWorksheet->getStyle('D11')->getFont()->setBold(true);
  $activeWorksheet->getStyle('E11')->getFont()->setBold(true);
  $activeWorksheet->getStyle('F11')->getFont()->setBold(true);
  $activeWorksheet->getStyle('G11')->getFont()->setBold(true);
  $activeWorksheet->getStyle('H11')->getFont()->setBold(true);
  $activeWorksheet->getStyle('I11')->getFont()->setBold(true);
  $activeWorksheet->getStyle('J11')->getFont()->setBold(true);
  $activeWorksheet->getStyle('K11')->getFont()->setBold(true);

  //Todos los bordes para la celda cabecera A2
  $activeWorksheet->getStyle('A10:A11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('A10:A11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('A10:A11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('A10:A11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera A2
  $activeWorksheet->getStyle('B8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera A2
  $activeWorksheet->getStyle('D8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera A2
  $activeWorksheet->getStyle('B10:C10')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B10:C10')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B10:C10')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B10:C10')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera B2
  $activeWorksheet->getStyle('D10:G10')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D10:G10')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D10:G10')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D10:G10')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera B2
  $activeWorksheet->getStyle('H10:I10')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('H10:I10')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('H10:I10')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('H10:I10')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera B2
  $activeWorksheet->getStyle('J10:K10')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('J10:K10')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('J10:K10')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('J10:K10')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera A2
  $activeWorksheet->getStyle('B11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('B11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('B11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('B11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera B2
  $activeWorksheet->getStyle('C11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('C11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('C11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('C11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera C2
  $activeWorksheet->getStyle('D11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('D11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('D11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('D11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera D2
  $activeWorksheet->getStyle('E11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('E11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('E11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('E11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('F11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('F11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera F2
  $activeWorksheet->getStyle('G11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('G11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera G2
  $activeWorksheet->getStyle('H11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('H11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera G2
  $activeWorksheet->getStyle('I11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('I11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('I11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('I11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera G2
  $activeWorksheet->getStyle('J11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('J11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('J11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('J11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera G2
  $activeWorksheet->getStyle('K11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('K11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('K11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  $activeWorksheet->getStyle('K11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
  //Todos los bordes para la celda cabecera A2
  $activeWorksheet->getStyle('B11:C11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B11:C11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B11:C11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B11:C11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera B2
  $activeWorksheet->getStyle('D11:G11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D11:G11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D11:G11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D11:G11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera B2
  $activeWorksheet->getStyle('H11:I11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('H11:I11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('H11:I11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('H11:I11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera B2
  $activeWorksheet->getStyle('J11:K11')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('J11:K11')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('J11:K11')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('J11:K11')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

  //Altura de las celdas de cabecera
  $activeWorksheet->getRowDimension('1')->setRowHeight(30);
  $activeWorksheet->getRowDimension('2')->setRowHeight(12.75);
  $activeWorksheet->getRowDimension('3')->setRowHeight(15.75);
  $activeWorksheet->getRowDimension('4')->setRowHeight(7.5);
  $activeWorksheet->getRowDimension('5')->setRowHeight(15.75);
  $activeWorksheet->getRowDimension('6')->setRowHeight(5.25);
  $activeWorksheet->getRowDimension('7')->setRowHeight(13.5);
  $activeWorksheet->getRowDimension('8')->setRowHeight(18.75);
  $activeWorksheet->getRowDimension('9')->setRowHeight(6);
  $activeWorksheet->getRowDimension('10')->setRowHeight(18);
  $activeWorksheet->getRowDimension('11')->setRowHeight(36);

  //Anchura para la columna A
  $activeWorksheet->getColumnDimension('A')->setWidth(3.2);
  $activeWorksheet->getColumnDimension('B')->setWidth(17.2);
  $activeWorksheet->getColumnDimension('C')->setWidth(8.5);
  $activeWorksheet->getColumnDimension('D')->setWidth(16.1);
  $activeWorksheet->getColumnDimension('E')->setWidth(7.6);
  $activeWorksheet->getColumnDimension('F')->setWidth(9.1);
  $activeWorksheet->getColumnDimension('G')->setWidth(9);
  $activeWorksheet->getColumnDimension('H')->setWidth(8.8);
  $activeWorksheet->getColumnDimension('I')->setWidth(15.8);
  $activeWorksheet->getColumnDimension('J')->setWidth(12.5);
  $activeWorksheet->getColumnDimension('K')->setWidth(12.5);
  $activeWorksheet->getColumnDimension('L')->setWidth(0.94);
  $activeWorksheet->getColumnDimension('M')->setWidth(2.93);
  $activeWorksheet->getColumnDimension('N')->setWidth(2.93);

  //Texto para encabezado A2
  $activeWorksheet->setCellValue('D1', 'PIE DE TREN');

  //Texto para encabezado A2
  $activeWorksheet->setCellValue('C3', 'PROCEDIMIENTO REVISIÓN CONDICIONES DE CIRCULACIÓN UTI´s');

  //Texto para encabezado A2
  $activeWorksheet->setCellValue('C5', 'CONSIGNA TE01/16 ATE 61-2/17 y MM.PP. (inc. LQ)');

  //Texto para encabezado A2
  $activeWorksheet->setCellValue('B7', 'Nº TREN DE SALIDA');
  //Texto para encabezado A2
  $activeWorksheet->setCellValue('D7', 'FECHA SALIDA');
  //Texto para encabezado A2
  $activeWorksheet->setCellValue('H7', 'COMPOSICION ORIGEN MURCIA MERCANCIAS');

  //Texto para encabezado A2
  $activeWorksheet->setCellValue('B8', $num_expedicion_salida);
  //Texto para encabezado A2
  $activeWorksheet->setCellValue('D8', $date_excel);

  //Texto para encabezado A2
  $activeWorksheet->setCellValue('A10', 'Orden');
  //Rotar texto
  $activeWorksheet->getStyle('A10')->getAlignment()->setTextRotation(90);
  //Texto para encabezado A2
  $activeWorksheet->setCellValue('B10', 'VAGON ');
  //Texto para encabezado A2
  $activeWorksheet->setCellValue('D10', 'UTI');
  //Texto para encabezado A2
  $activeWorksheet->setCellValue('H10', 'ESTACIÓN DE DESTINO');
  //Texto para encabezado A2
  $activeWorksheet->setCellValue('J10', 'PRESCRIPCION');

  //Texto para encabezado A2
  $activeWorksheet->setCellValue('B11', 'NUMERO ');
  //Texto para encabezado B2
  $activeWorksheet->setCellValue('C11', 'T. CLIENTE');
  //Texto para encabezado C2
  $activeWorksheet->setCellValue('D11', 'NUMERO');
  //Texto para encabezado D2
  $activeWorksheet->setCellValue('E11', 'TIPO ');
  //Texto para encabezado E2
  $activeWorksheet->setCellValue('F11', 'PESO BRUTO');
  //Texto para encabezado F2
  $activeWorksheet->setCellValue('G11', 'MM.PP.');
  //Texto para encabezado G2
  $activeWorksheet->setCellValue('H11', 'NUMERO');
  //Texto para encabezado G2
  $activeWorksheet->setCellValue('I11', 'LITERAL');
  //Texto para encabezado G2
  $activeWorksheet->setCellValue('J11', 'TE 00001-16');
  //Texto para encabezado G2
  $activeWorksheet->setCellValue('K11', 'ATE 61-2/17');
  //Texto para encabezado G2
  $activeWorksheet->setCellValue('M11', 'A');
  //Texto para encabezado G2
  $activeWorksheet->setCellValue('N11', 'B');

  //Ajustar texto para encabezado A2
  $activeWorksheet->getStyle('B11')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado B2
  $activeWorksheet->getStyle('C11')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado C2
  $activeWorksheet->getStyle('D11')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado D2
  $activeWorksheet->getStyle('E11')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('F11')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado F2
  $activeWorksheet->getStyle('G11')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado G2
  $activeWorksheet->getStyle('H11')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado G2
  $activeWorksheet->getStyle('I11')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado G2
  $activeWorksheet->getStyle('J11')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado G2
  $activeWorksheet->getStyle('K11')->getAlignment()->setWrapText(true);

  //Columna C en formato fecha
  $activeWorksheet->getStyle('D8')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
  //Columna B en formato numero
  $activeWorksheet->getStyle('B')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

  $num_vagon_anterior = '';
  //Por cada linea de contenedores en stock
  foreach ($salida_tren_list as $key => $salida_tren_line) {
    //Desfase para fila de cabeceras
    $indice = $key+12;

    //Valor para celda A.$indice
    $activeWorksheet->setCellValue('A'.$indice, $salida_tren_line['pos_vagon']);
    //Valor para celda A.$indice
    if($salida_tren_line['num_vagon'] != $num_vagon_anterior){
      //Valor para celda A.$indice
      $activeWorksheet->setCellValue('B'.$indice, $salida_tren_line['num_vagon']);
    }
    $num_vagon_anterior = $salida_tren_line['num_vagon'];
    //Valor para celda B.$indice
    $activeWorksheet->setCellValue('C'.$indice, $salida_tren_line['num_tarjeta_teco']);
    //Valor para celda C.$indice
      if($salida_tren_line['num_contenedor'] == null){
        $salida_tren_line['num_contenedor'] = 'NO-CON';
      }
      $activeWorksheet->setCellValue('D'.$indice, $salida_tren_line['num_contenedor']);
    //Valor para celda D.$indice
    $activeWorksheet->setCellValue('E'.$indice, $salida_tren_line['longitud_tipo_contenedor']);
    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('F'.$indice, $salida_tren_line['peso_bruto_contenedor']);
    //Valor para celda F.$indice
    if(
      $salida_tren_line['descripcion_mercancia'] == 'MERCANCÍA PELIGROSA' ||
      $salida_tren_line['descripcion_mercancia'] == 'VACÍO-SUCIO'
    ){
      $activeWorksheet->setCellValue('G'.$indice, $salida_tren_line['num_peligro_adr'].'/'.$salida_tren_line['num_onu_adr']);
    }else{
      if($salida_tren_line['num_contenedor'] != 'NO-CON'){
        $activeWorksheet->setCellValue('G'.$indice, 'NO');
      }
    }
    //Valor para celda G.$indice
    $activeWorksheet->setCellValue('H'.$indice, $salida_tren_line['codigo_estacion_ferrocarril']);
    //Valor para celda G.$indice
    $activeWorksheet->setCellValue('I'.$indice, $salida_tren_line['nombre_estacion_ferrocarril']);
    //Valor para celda G.$indice
    $activeWorksheet->setCellValue('J'.$indice, $salida_tren_line['te']);
    //Valor para celda G.$indice
    $activeWorksheet->setCellValue('K'.$indice, $salida_tren_line['ate']);

    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('B'.$indice)->getFont()->setBold(true);
    $activeWorksheet->getStyle('B'.$indice)->getFont()->getColor()->setRGB('FF0000');
    //Todos los bordes para la celda A.$indice
    $activeWorksheet->getStyle('A'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda A.$indice
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda B.$indice
    $activeWorksheet->getStyle('C'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('C'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('C'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('C'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
    //Todos los bordes para la celda C.$indice
    $activeWorksheet->getStyle('D'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('D'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('D'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('D'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda D.$indice
    $activeWorksheet->getStyle('E'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda E.$indice
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda F.$indice
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
    //Todos los bordes para la celda G.$indice
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda G.$indice
    $activeWorksheet->getStyle('I'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
    //Todos los bordes para la celda G.$indice
    $activeWorksheet->getStyle('J'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('J'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('J'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('J'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda G.$indice
    $activeWorksheet->getStyle('K'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('K'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('K'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('K'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('A'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('B'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('C'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('D'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('E'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('F'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('G'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('H'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('I'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('J'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('K'.$indice)->getAlignment()->setHorizontal('center');

    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('A'.$indice)->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('B'.$indice)->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('C'.$indice)->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('D'.$indice)->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('E'.$indice)->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('F'.$indice)->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('G'.$indice)->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('H'.$indice)->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('I'.$indice)->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('J'.$indice)->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('K'.$indice)->getAlignment()->setVertical('center');

  }

  $indice = $indice+1;
  //Todos los bordes para la celda G.$indice
  $activeWorksheet->getStyle('A'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda G.$indice
  $activeWorksheet->getStyle('B'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda G.$indice
  $activeWorksheet->getStyle('C'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Combinar celdas pie de pagina
  $activeWorksheet->mergeCells('D'.$indice.':E'.$indice);
  //Todos los bordes para la celda G.$indice
  $activeWorksheet->getStyle('D'.$indice.':E'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D'.$indice.':E'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D'.$indice.':E'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D'.$indice.':E'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda G.$indice
  $activeWorksheet->getStyle('F'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda G.$indice
  $activeWorksheet->getStyle('G'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda G.$indice
  $activeWorksheet->getStyle('H'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda G.$indice
  $activeWorksheet->getStyle('I'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda G.$indice
  $activeWorksheet->getStyle('J'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda G.$indice
  $activeWorksheet->getStyle('K'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

  $indice = $indice+5;
  $activeWorksheet->getRowDimension($indice)->setRowHeight(14.25);
  $activeWorksheet->getRowDimension(($indice+1))->setRowHeight(14.25);
  $activeWorksheet->getRowDimension(($indice+2))->setRowHeight(14.25);
  $activeWorksheet->getRowDimension(($indice+3))->setRowHeight(14.5);
  $activeWorksheet->getRowDimension(($indice+4))->setRowHeight(12.75);
  $activeWorksheet->getRowDimension(($indice+5))->setRowHeight(12.75);
  $activeWorksheet->getRowDimension(($indice+6))->setRowHeight(12.75);
  $activeWorksheet->getRowDimension(($indice+7))->setRowHeight(13.5);

  //Combinar celdas pie de pagina
  $activeWorksheet->mergeCells('B'.$indice.':H'.$indice);
  //Todos los bordes para la celda G.$indice
  $activeWorksheet->getStyle('B'.$indice.':H'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B'.$indice.':H'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B'.$indice.':H'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Valor para celda G.$indice
  $activeWorksheet->setCellValue('B'.$indice, 'NOMBRE DEL CARGADOR HABILITADO');
  //Todos los bordes para la celda G.$indice
  $activeWorksheet->getStyle('B'.$indice.':H'.($indice+7))->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B'.$indice.':H'.($indice+7))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B'.$indice.':H'.($indice+7))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B'.$indice.':H'.($indice+7))->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Valor para celda G.$indice
  $activeWorksheet->setCellValue('I'.$indice, 'SELLADO: MARITIMA SURESTE SHIPPING, S.L.U.');
  //Combinar celdas pie de pagina
  $activeWorksheet->mergeCells('I'.$indice.':K'.($indice+7));
  //Alineación horizontal para las celdas de cabecera
  $activeWorksheet->getStyle('I'.$indice.':K'.($indice+7))->getAlignment()->setHorizontal('center');
  //Alineación vertical para las celdas de cabecera
  $activeWorksheet->getStyle('I'.$indice.':K'.($indice+7))->getAlignment()->setVertical('top');
  //Todos los bordes para la celda G.$indice
  $activeWorksheet->getStyle('I'.$indice.':K'.($indice+7))->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('I'.$indice.':K'.($indice+7))->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('I'.$indice.':K'.($indice+7))->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('I'.$indice.':K'.($indice+7))->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B'.$indice.':K'.($indice+7))->getFont()->setSize(11);

  // Prepare the drawing object
  $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
  // Set the picture name
  $drawing->setName('sello_shipping');
  // Set the picture path
  $drawing->setPath('../images/sello_shipping.jpg');
  $drawing->setHeight(105.07);
  $drawing->setOffsetX(-10);
  $drawing->setOffsetY(10);
  // Set the cell address where the picture will be inserted
  $drawing->setCoordinates('J'.($indice+1));
  // Add the drawing to the worksheet
  $drawing->setWorksheet($spreadsheet->getActiveSheet());

  $indice = $indice+1;
  //Combinar celdas pie de pagina
  $activeWorksheet->mergeCells('B'.$indice.':H'.$indice);

  $indice = $indice+1;
  //Valor para celda G.$indice
  $activeWorksheet->setCellValue('B'.$indice, '');
  //Combinar celdas pie de pagina
  $activeWorksheet->mergeCells('B'.$indice.':H'.$indice);

  $indice = $indice+1;
  //Combinar celdas pie de pagina
  $activeWorksheet->mergeCells('B'.$indice.':H'.($indice+4));

  $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
  $writer->save($filename);
  header('Location: '.$filename);
  //unlink('hello world.xlsx');
}
/////////////////////////////////RENFE//////////////////////////////////////////

////////////////////////////SICSA-VALENCIA//////////////////////////////////////
function excel_pie_tren_salida_sicsa($salida_tren_list)
{
  //FORMATO SICSA-VALENCIA
  //generamos excel
  $num_expedicion_salida = $salida_tren_list[0]['num_expedicion'];
  $fecha_salida = date_create($salida_tren_list[0]['fecha_salida']);
  //cargamos el modelo con la clase que interactua con la tabla clientes
  require_once("../models/railsider_model.php");
  //instanciamos el modelo de la BBDD
  $railsider_model = new railsider_model();
  $cita_carga_list = $railsider_model-> get_cita_carga($num_expedicion_salida);
  $ruta_tren = "MURCIA - ".$cita_carga_list[0]['nombre_destino'];
  $date = date_format($fecha_salida, 'Y-m-d');
  $date_excel = date_format($fecha_salida, 'd/m/Y');
  $nombre_comercial_propietario = 'SICSA-VALENCIA';
  $filename = "../excel/salidas_tren/".$nombre_comercial_propietario."/Pie_Tren_Salida_".$nombre_comercial_propietario."_".$date.".xlsx";
  $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
  $activeWorksheet = $spreadsheet->getActiveSheet();

  //Nombre de la hoja activa
  $activeWorksheet->setTitle("Hoja1");

  //Combinamos celdas para titulo de la hoja
  $activeWorksheet->mergeCells('B3:K3');
  $activeWorksheet->mergeCells('B4:D4');
  $activeWorksheet->mergeCells('G4:K4');
  $activeWorksheet->mergeCells('B5:E5');
  $activeWorksheet->mergeCells('F5:K5');
  $activeWorksheet->mergeCells('B6:D6');
  $activeWorksheet->mergeCells('G6:K6');
  $activeWorksheet->mergeCells('B7:E7');
  $activeWorksheet->mergeCells('F7:K7');

  //Alineación horizontal para las celdas de cabecera
  $activeWorksheet->getStyle('B3:K7')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('C8')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('D8')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('E8')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('F8')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('G8')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('H8')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('I8')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('J8')->getAlignment()->setHorizontal('center');

  //Alineación vertical para las celdas de cabecera
  $activeWorksheet->getStyle('B3:K7')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('C8')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('D8')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('E8')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('F8')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('G8')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('H8')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('I8')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('J8')->getAlignment()->setVertical('center');

  //Tamaño de fuente
  $activeWorksheet->getStyle("B3")->getFont()->setSize(14);

  //Texto en negrita para las celdas de cabecera
  $activeWorksheet->getStyle('B3')->getFont()->setBold(true);
  $activeWorksheet->getStyle('B4')->getFont()->setBold(true);
  $activeWorksheet->getStyle('F4')->getFont()->setBold(true);
  $activeWorksheet->getStyle('B5')->getFont()->setBold(true);
  $activeWorksheet->getStyle('B6')->getFont()->setBold(true);
  $activeWorksheet->getStyle('B7')->getFont()->setBold(true);
  $activeWorksheet->getStyle('F6')->getFont()->setBold(true);
  $activeWorksheet->getStyle('C8')->getFont()->setBold(true);
  $activeWorksheet->getStyle('D8')->getFont()->setBold(true);
  $activeWorksheet->getStyle('E8')->getFont()->setBold(true);
  $activeWorksheet->getStyle('F8')->getFont()->setBold(true);
  $activeWorksheet->getStyle('G8')->getFont()->setBold(true);
  $activeWorksheet->getStyle('H8')->getFont()->setBold(true);
  $activeWorksheet->getStyle('I8')->getFont()->setBold(true);
  $activeWorksheet->getStyle('J8')->getFont()->setBold(true);

  //Todos los bordes para la celda cabecera A2
  $activeWorksheet->getStyle('B8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera B2
  $activeWorksheet->getStyle('C8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('C8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('C8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('C8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera C2
  $activeWorksheet->getStyle('D8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera D2
  $activeWorksheet->getStyle('E8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('F8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('G8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('H8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('H8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('H8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('H8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('I8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('I8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('I8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('I8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('J8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('J8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('J8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('J8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('K8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('K8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('K8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('K8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('B3:K3')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B3:K3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B3:K3')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B3:K3')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('B4:D4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B4:D4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B4:D4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B4:D4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('E4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('F4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('G4:K4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G4:K4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G4:K4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G4:K4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('B5:E5')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B5:E5')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B5:E5')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B5:E5')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('F5:K5')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F5:K5')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F5:K5')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F5:K5')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('B6:D6')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B6:D6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B6:D6')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B6:D6')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('E6')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E6')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E6')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('F6')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F6')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F6')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('G6:K6')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G6:K6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G6:K6')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G6:K6')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('B7:E7')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B7:E7')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B7:E7')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B7:E7')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('F7:K7')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F7:K7')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F7:K7')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F7:K7')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

  //Altura de las celdas de cabecera
  $activeWorksheet->getRowDimension('1')->setRowHeight(8.25);
  $activeWorksheet->getRowDimension('2')->setRowHeight(34.5);
  $activeWorksheet->getRowDimension('3')->setRowHeight(21.75);
  $activeWorksheet->getRowDimension('4')->setRowHeight(21.75);
  $activeWorksheet->getRowDimension('5')->setRowHeight(21.75);
  $activeWorksheet->getRowDimension('6')->setRowHeight(21.75);
  $activeWorksheet->getRowDimension('7')->setRowHeight(15.75);
  $activeWorksheet->getRowDimension('8')->setRowHeight(16.5);

  //Anchura de las celdas de cabecera
  $activeWorksheet->getColumnDimension('A')->setWidth(1.2);
  $activeWorksheet->getColumnDimension('B')->setWidth(3.2);
  $activeWorksheet->getColumnDimension('C')->setWidth(13);
  $activeWorksheet->getColumnDimension('D')->setWidth(10.90);
  $activeWorksheet->getColumnDimension('E')->setWidth(15);
  $activeWorksheet->getColumnDimension('F')->setWidth(22.3);
  $activeWorksheet->getColumnDimension('G')->setWidth(4.3);
  $activeWorksheet->getColumnDimension('H')->setWidth(8.2);
  $activeWorksheet->getColumnDimension('I')->setWidth(10.8);
  $activeWorksheet->getColumnDimension('J')->setWidth(12.2);
  $activeWorksheet->getColumnDimension('K')->setWidth(3.2);

  //Texto para encabezado A2
  $activeWorksheet->setCellValue('E4', $num_expedicion_salida);
  $activeWorksheet->setCellValue('E6', 'CONTENEDORES');
  $activeWorksheet->setCellValue('F5', $ruta_tren);
  $activeWorksheet->setCellValue('G6', $date_excel);
  $activeWorksheet->setCellValue('B3', 'CONTINENTAL-RAIL');
  $activeWorksheet->setCellValue('B4', 'Nº de Expedición / Tren:');
  $activeWorksheet->setCellValue('F4', 'MAQUINISTA:');
  $activeWorksheet->setCellValue('B5', 'ORIGEN-DESTINO:');
  $activeWorksheet->setCellValue('B6', 'MERCANCIAS:');
  $activeWorksheet->setCellValue('F6', 'FECHA:');

  $activeWorksheet->setCellValue('C8', 'N0.Vagon');
  $activeWorksheet->setCellValue('D8', 'Pos Vagon');
  $activeWorksheet->setCellValue('E8', 'Pos.Contenedor');
  $activeWorksheet->setCellValue('F8', 'Contenedor');
  $activeWorksheet->setCellValue('G8', 'V/C');
  $activeWorksheet->setCellValue('H8', 'Tipo');
  $activeWorksheet->setCellValue('I8', 'PESO NETO');
  $activeWorksheet->setCellValue('J8', 'PESO BRUTO');

  //Color fondo para celdas
  $activeWorksheet->getStyle('B8:K8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('BFBFBF');

  //Ajustar texto para encabezado A2
  $activeWorksheet->getStyle('B3:K7')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado A2
  $activeWorksheet->getStyle('C8')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado B2
  $activeWorksheet->getStyle('D8')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado C2
  $activeWorksheet->getStyle('E8')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado D2
  $activeWorksheet->getStyle('F8')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('G8')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('H8')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('I8')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('J8')->getAlignment()->setWrapText(true);

  //Columna C en formato numero
  $activeWorksheet->getStyle('C')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
  $activeWorksheet->getStyle('I')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
  $activeWorksheet->getStyle('J')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

  //Columna D en formato numero
  $activeWorksheet->getStyle('G6')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);

  $num_vagon_anterior = '';
  $pos_vagon_anterior = '';
  //Por cada linea de contenedores en stock
  foreach ($salida_tren_list as $key => $salida_tren_line) {
    //Desfase para fila de cabeceras
    $indice = $key+9;
    //Valor para celda A.$indice
    if($salida_tren_line['num_vagon'] != $num_vagon_anterior){
      //Valor para celda A.$indice
      $activeWorksheet->setCellValue('C'.$indice, $salida_tren_line['num_vagon']);
    }
    $num_vagon_anterior = $salida_tren_line['num_vagon'];
    //Valor para celda B.$indice
    if($salida_tren_line['pos_vagon'] != $pos_vagon_anterior){
      //Valor para celda A.$indice
      $activeWorksheet->setCellValue('D'.$indice, $salida_tren_line['pos_vagon']);
    }
    $pos_vagon_anterior = $salida_tren_line['pos_vagon'];

    //Valor para celda C.$indice
    $activeWorksheet->setCellValue('E'.$indice, $salida_tren_line['pos_contenedor']);
    //Valor para celda D.$indice
    if($salida_tren_line['num_contenedor'] == null){
      $salida_tren_line['num_contenedor'] = 'NO-CON';
    }
    $activeWorksheet->setCellValue('F'.$indice, $salida_tren_line['num_contenedor']);
    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('G'.$indice, $salida_tren_line['estado_carga_contenedor']);
    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('H'.$indice, $salida_tren_line['longitud_tipo_contenedor']);
    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('I'.$indice, $salida_tren_line['peso_mercancia_contenedor']);
    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('J'.$indice, $salida_tren_line['peso_bruto_contenedor']);

    //Anchura de la fila
    $activeWorksheet->getRowDimension($indice)->setRowHeight(16.5);

    //Todos los bordes para la celda B.$indice
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
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
    $activeWorksheet->getStyle('K'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('C'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('D'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('E'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('F'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('G'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('H'.$indice)->getAlignment()->setHorizontal('center');

  }

  $indice = $indice+1;
  $activeWorksheet->getStyle('B'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('C'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('H'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('I'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('J'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('K'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

  $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
  $writer->save($filename);
  header('Location: '.$filename);
  //unlink('hello world.xlsx');
}
////////////////////////////SICSA-VALENCIA//////////////////////////////////////

//////////////////////////////CCIS-BILBAO///////////////////////////////////////
function excel_pie_tren_salida_ccis($salida_tren_list)
{
  //FORMATO SICSA-VALENCIA
  //generamos excel
  $num_expedicion_salida = $salida_tren_list[0]['num_expedicion'];
  $fecha_salida = date_create($salida_tren_list[0]['fecha_salida']);
  //cargamos el modelo con la clase que interactua con la tabla clientes
  require_once("../models/railsider_model.php");
  //instanciamos el modelo de la BBDD
  $railsider_model = new railsider_model();
  $cita_carga_list = $railsider_model-> get_cita_carga($num_expedicion_salida);
  $ruta_tren = "MURCIA - ".$cita_carga_list[0]['nombre_destino'];
  $date = date_format($fecha_salida, 'Y-m-d');
  $date_excel = date_format($fecha_salida, 'd/m/Y');
  $nombre_comercial_propietario = 'CCIS-BILBAO';
  $filename = "../excel/salidas_tren/".$nombre_comercial_propietario."/Pie_Tren_Salida_".$nombre_comercial_propietario."_".$date.".xlsx";
  $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
  $activeWorksheet = $spreadsheet->getActiveSheet();

  //Nombre de la hoja activa
  $activeWorksheet->setTitle("Hoja1");

  //Combinamos celdas para titulo de la hoja
  $activeWorksheet->mergeCells('B3:K3');
  $activeWorksheet->mergeCells('B4:D4');
  $activeWorksheet->mergeCells('G4:K4');
  $activeWorksheet->mergeCells('B5:E5');
  $activeWorksheet->mergeCells('F5:K5');
  $activeWorksheet->mergeCells('B6:D6');
  $activeWorksheet->mergeCells('G6:K6');
  $activeWorksheet->mergeCells('B7:E7');
  $activeWorksheet->mergeCells('F7:K7');

  //Alineación horizontal para las celdas de cabecera
  $activeWorksheet->getStyle('B3:K7')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('C8')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('D8')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('E8')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('F8')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('G8')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('H8')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('I8')->getAlignment()->setHorizontal('center');
  $activeWorksheet->getStyle('J8')->getAlignment()->setHorizontal('center');

  //Alineación vertical para las celdas de cabecera
  $activeWorksheet->getStyle('B3:K7')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('C8')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('D8')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('E8')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('F8')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('G8')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('H8')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('I8')->getAlignment()->setVertical('center');
  $activeWorksheet->getStyle('J8')->getAlignment()->setVertical('center');

  //Tamaño de fuente
  $activeWorksheet->getStyle("B3")->getFont()->setSize(14);

  //Texto en negrita para las celdas de cabecera
  $activeWorksheet->getStyle('B3')->getFont()->setBold(true);
  $activeWorksheet->getStyle('B4')->getFont()->setBold(true);
  $activeWorksheet->getStyle('F4')->getFont()->setBold(true);
  $activeWorksheet->getStyle('B5')->getFont()->setBold(true);
  $activeWorksheet->getStyle('B6')->getFont()->setBold(true);
  $activeWorksheet->getStyle('B7')->getFont()->setBold(true);
  $activeWorksheet->getStyle('F6')->getFont()->setBold(true);
  $activeWorksheet->getStyle('C8')->getFont()->setBold(true);
  $activeWorksheet->getStyle('D8')->getFont()->setBold(true);
  $activeWorksheet->getStyle('E8')->getFont()->setBold(true);
  $activeWorksheet->getStyle('F8')->getFont()->setBold(true);
  $activeWorksheet->getStyle('G8')->getFont()->setBold(true);
  $activeWorksheet->getStyle('H8')->getFont()->setBold(true);
  $activeWorksheet->getStyle('I8')->getFont()->setBold(true);
  $activeWorksheet->getStyle('J8')->getFont()->setBold(true);

  //Todos los bordes para la celda cabecera A2
  $activeWorksheet->getStyle('B8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera B2
  $activeWorksheet->getStyle('C8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('C8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('C8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('C8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera C2
  $activeWorksheet->getStyle('D8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera D2
  $activeWorksheet->getStyle('E8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('F8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('G8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('H8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('H8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('H8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('H8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('I8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('I8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('I8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('I8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('J8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('J8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('J8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('J8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('K8')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('K8')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('K8')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('K8')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('B3:K3')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B3:K3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B3:K3')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B3:K3')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('B4:D4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B4:D4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B4:D4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B4:D4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('E4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('F4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('G4:K4')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G4:K4')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G4:K4')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G4:K4')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('B5:E5')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B5:E5')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B5:E5')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B5:E5')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('F5:K5')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F5:K5')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F5:K5')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F5:K5')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('B6:D6')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B6:D6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B6:D6')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B6:D6')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('E6')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E6')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E6')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('F6')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F6')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F6')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('G6:K6')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G6:K6')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G6:K6')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G6:K6')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('B7:E7')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B7:E7')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B7:E7')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('B7:E7')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  //Todos los bordes para la celda cabecera E2
  $activeWorksheet->getStyle('F7:K7')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F7:K7')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F7:K7')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F7:K7')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

  //Altura de las celdas de cabecera
  $activeWorksheet->getRowDimension('1')->setRowHeight(8.25);
  $activeWorksheet->getRowDimension('2')->setRowHeight(34.5);
  $activeWorksheet->getRowDimension('3')->setRowHeight(21.75);
  $activeWorksheet->getRowDimension('4')->setRowHeight(21.75);
  $activeWorksheet->getRowDimension('5')->setRowHeight(21.75);
  $activeWorksheet->getRowDimension('6')->setRowHeight(21.75);
  $activeWorksheet->getRowDimension('7')->setRowHeight(15.75);
  $activeWorksheet->getRowDimension('8')->setRowHeight(16.5);

  //Anchura de las celdas de cabecera
  $activeWorksheet->getColumnDimension('A')->setWidth(1.2);
  $activeWorksheet->getColumnDimension('B')->setWidth(3.2);
  $activeWorksheet->getColumnDimension('C')->setWidth(13);
  $activeWorksheet->getColumnDimension('D')->setWidth(10.90);
  $activeWorksheet->getColumnDimension('E')->setWidth(15);
  $activeWorksheet->getColumnDimension('F')->setWidth(22.3);
  $activeWorksheet->getColumnDimension('G')->setWidth(4.3);
  $activeWorksheet->getColumnDimension('H')->setWidth(8.2);
  $activeWorksheet->getColumnDimension('I')->setWidth(10.8);
  $activeWorksheet->getColumnDimension('J')->setWidth(12.2);
  $activeWorksheet->getColumnDimension('K')->setWidth(3.2);

  //Texto para encabezado A2
  $activeWorksheet->setCellValue('E4', $num_expedicion_salida);
  $activeWorksheet->setCellValue('E6', 'CONTENEDORES');
  $activeWorksheet->setCellValue('F5', $ruta_tren);
  $activeWorksheet->setCellValue('G6', $date_excel);
  $activeWorksheet->setCellValue('B3', 'CONTINENTAL-RAIL');
  $activeWorksheet->setCellValue('B4', 'Nº de Expedición / Tren:');
  $activeWorksheet->setCellValue('F4', 'MAQUINISTA:');
  $activeWorksheet->setCellValue('B5', 'ORIGEN-DESTINO:');
  $activeWorksheet->setCellValue('B6', 'MERCANCIAS:');
  $activeWorksheet->setCellValue('F6', 'FECHA:');

  $activeWorksheet->setCellValue('C8', 'N0.Vagon');
  $activeWorksheet->setCellValue('D8', 'Pos Vagon');
  $activeWorksheet->setCellValue('E8', 'Pos.Contenedor');
  $activeWorksheet->setCellValue('F8', 'Contenedor');
  $activeWorksheet->setCellValue('G8', 'V/C');
  $activeWorksheet->setCellValue('H8', 'Tipo');
  $activeWorksheet->setCellValue('I8', 'PESO NETO');
  $activeWorksheet->setCellValue('J8', 'PESO BRUTO');

  //Color fondo para celdas
  $activeWorksheet->getStyle('B8:K8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('BFBFBF');

  //Ajustar texto para encabezado A2
  $activeWorksheet->getStyle('B3:K7')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado A2
  $activeWorksheet->getStyle('C8')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado B2
  $activeWorksheet->getStyle('D8')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado C2
  $activeWorksheet->getStyle('E8')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado D2
  $activeWorksheet->getStyle('F8')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('G8')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('H8')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('I8')->getAlignment()->setWrapText(true);
  //Ajustar texto para encabezado E2
  $activeWorksheet->getStyle('J8')->getAlignment()->setWrapText(true);

  //Columna C en formato numero
  $activeWorksheet->getStyle('C')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
  $activeWorksheet->getStyle('I')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
  $activeWorksheet->getStyle('J')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

  //Columna D en formato numero
  $activeWorksheet->getStyle('G6')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);

  $num_vagon_anterior = '';
  $pos_vagon_anterior = '';
  //Por cada linea de contenedores en stock
  foreach ($salida_tren_list as $key => $salida_tren_line) {
    //Desfase para fila de cabeceras
    $indice = $key+9;
    //Valor para celda A.$indice
    if($salida_tren_line['num_vagon'] != $num_vagon_anterior){
      //Valor para celda A.$indice
      $activeWorksheet->setCellValue('C'.$indice, $salida_tren_line['num_vagon']);
    }
    $num_vagon_anterior = $salida_tren_line['num_vagon'];
    //Valor para celda B.$indice
    if($salida_tren_line['pos_vagon'] != $pos_vagon_anterior){
      //Valor para celda A.$indice
      $activeWorksheet->setCellValue('D'.$indice, $salida_tren_line['pos_vagon']);
    }
    $pos_vagon_anterior = $salida_tren_line['pos_vagon'];

    //Valor para celda C.$indice
    $activeWorksheet->setCellValue('E'.$indice, $salida_tren_line['pos_contenedor']);
    //Valor para celda D.$indice
    if($salida_tren_line['num_contenedor'] == null){
      $salida_tren_line['num_contenedor'] = 'NO-CON';
    }
    $activeWorksheet->setCellValue('F'.$indice, $salida_tren_line['num_contenedor']);
    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('G'.$indice, $salida_tren_line['estado_carga_contenedor']);
    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('H'.$indice, $salida_tren_line['longitud_tipo_contenedor']);
    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('I'.$indice, $salida_tren_line['peso_mercancia_contenedor']);
    //Valor para celda E.$indice
    $activeWorksheet->setCellValue('J'.$indice, $salida_tren_line['peso_bruto_contenedor']);

    //Anchura de la fila
    $activeWorksheet->getRowDimension($indice)->setRowHeight(16.5);

    //Todos los bordes para la celda B.$indice
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('B'.$indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
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
    $activeWorksheet->getStyle('K'.$indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('C'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('D'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('E'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('F'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('G'.$indice)->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('H'.$indice)->getAlignment()->setHorizontal('center');

  }

  $indice = $indice+1;
  $activeWorksheet->getStyle('B'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('C'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('D'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('E'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('F'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('G'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('H'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('I'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('J'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
  $activeWorksheet->getStyle('K'.$indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);

  $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
  $writer->save($filename);
  header('Location: '.$filename);
  //unlink('hello world.xlsx');
}
//////////////////////////////CCIS-BILBAO///////////////////////////////////////

?>
