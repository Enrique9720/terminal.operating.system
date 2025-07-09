EXCEL DETALLE FACTURACION CLIENTE FUNCTIONS

<?php
function excel_detalle_facturacion_manipulacion_uti_ccis_bilbao($manipulacion_uti_list, $fecha_inicio, $fecha_fin, $tarifas)
{
    $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
    $fecha_fin = date('Y-m-d', strtotime($fecha_fin));

    $nombre_comercial_cliente = 'CCIS-BILBAO';
    $filename = "../excel/facturas/" . $nombre_comercial_cliente . "/LISTADO FACTURACIÓN MANIPULACIÓN UTI " . $nombre_comercial_cliente . "_DEL_" . $fecha_inicio . "_AL_" . $fecha_fin . ".xlsx";
    $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();

    // Set default font type to 'Arial'
    $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
    // Set default font size to '10'
    $spreadsheet->getDefaultStyle()->getFont()->setSize(11);

    $activeWorksheet = $spreadsheet->getActiveSheet();

    //Nombre de la hoja activa
    $activeWorksheet->setTitle("MANIPULACION-UTI");

    //Texto para titulo A1
    $activeWorksheet->setCellValue('A1', 'MANIPULACION UTI - ' . $nombre_comercial_cliente . " del " . $fecha_inicio . " al " . $fecha_fin);
    //Alineación horizontal para la celda A1
    $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('A1')->getAlignment()->setVertical('center');
    //Texto en negrita para la celda A1
    $activeWorksheet->getStyle('A1')->getFont()->setBold(true);
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('A1:G1');

    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('B2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('C2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('D2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('E2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('F2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('G2')->getAlignment()->setHorizontal('center');

    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('A2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('B2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('C2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('D2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('E2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('F2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('G2')->getAlignment()->setVertical('center');

    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('A2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('B2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('C2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('D2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('E2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('F2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('G2')->getFont()->setBold(true);

    //Altura de las celdas de cabecera
    $activeWorksheet->getRowDimension('1')->setRowHeight(20);

    //Anchura para la columna A
    $activeWorksheet->getColumnDimension('A')->setWidth(15.29);
    //Anchura para la columna B
    $activeWorksheet->getColumnDimension('B')->setWidth(9.86);
    //Anchura para la columna C
    $activeWorksheet->getColumnDimension('C')->setWidth(13.43);
    //Anchura para la columna D
    $activeWorksheet->getColumnDimension('D')->setWidth(12.86);
    //Anchura para la columna E
    $activeWorksheet->getColumnDimension('E')->setWidth(12.29);
    //Anchura para la columna F
    $activeWorksheet->getColumnDimension('F')->setWidth(10.86);
    //Anchura para la columna G
    $activeWorksheet->getColumnDimension('G')->setWidth(17.14);

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

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('A1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('A1:G1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('A2:F2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
    $activeWorksheet->getStyle('G2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00B0F0');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('A2:G2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    foreach ($tarifas as $tarifa) {
        $tarifa_manipulacion_uti = $tarifa['tarifa_manipulacion_uti'];
    }

    //Texto para encabezado A1
    $activeWorksheet->setCellValue('A2', 'Nº CONTENEDOR');
    //Texto para encabezado B1
    $activeWorksheet->setCellValue('B2', 'TAMAÑO');
    //Texto para encabezado C1
    $activeWorksheet->setCellValue('C2', 'FECHA ENTRADA');
    //Texto para encabezado D1
    $activeWorksheet->setCellValue('D2', 'TIPO ENTRADA');
    //Texto para encabezado E1
    $activeWorksheet->setCellValue('E2', 'FECHA SALIDA');
    //Texto para encabezado F1
    $activeWorksheet->setCellValue('F2', 'TIPO SALIDA');
    //Texto para encabezado G1
    $activeWorksheet->setCellValue('G2', 'IMPORTE MANIPULACIÓN UTI ('.$tarifa_manipulacion_uti.' €/UTI)');

    //Ajustar texto para encabezado A1
    $activeWorksheet->getStyle('A2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado B1
    $activeWorksheet->getStyle('B2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado C1
    $activeWorksheet->getStyle('C2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado D1
    $activeWorksheet->getStyle('D2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado E1
    $activeWorksheet->getStyle('E2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado F1
    $activeWorksheet->getStyle('F2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado G1
    $activeWorksheet->getStyle('G2')->getAlignment()->setWrapText(true);

    //Columna B en formato numero
    $activeWorksheet->getStyle('B')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna C en formato numero
    $activeWorksheet->getStyle('C')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
    //Columna E en formato fecha
    $activeWorksheet->getStyle('D')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna E en formato numero
    $activeWorksheet->getStyle('E')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
    //Columna F en formato fecha
    $activeWorksheet->getStyle('F')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna G en formato fecha
    $activeWorksheet->getStyle('G')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
    //$activeWorksheet->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00 €');

    //Desfase para fila de cabeceras
    $indice = 3;
    foreach ($manipulacion_uti_list as $manipulacion_uti_line) {
        //Valor para celda A.$indice
        $activeWorksheet->setCellValue('A' . $indice, $manipulacion_uti_line['num_contenedor']);
        //Valor para celda B.$indice
        $activeWorksheet->setCellValue('B' . $indice, $manipulacion_uti_line['longitud_tipo_contenedor']);
        //Valor para celda C.$indice
        $activeWorksheet->setCellValue('C' . $indice, $manipulacion_uti_line['fecha_entrada']);
        //Valor para celda D.$indice
        $activeWorksheet->setCellValue('D' . $indice, $manipulacion_uti_line['tipo_entrada']);
        //Valor para celda E.$indice
        $activeWorksheet->setCellValue('E' . $indice, $manipulacion_uti_line['fecha_salida']);
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('F' . $indice, $manipulacion_uti_line['tipo_salida']);
        //Valor para celda G.$indice
        $activeWorksheet->setCellValue('G' . $indice, $manipulacion_uti_line['importe_manipulacion_utis']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda B.$indice
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda C.$indice
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda D.$indice
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('G' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('G' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('G' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('G' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('B' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('C' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('D' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('E' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('F' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('G' . $indice)->getAlignment()->setHorizontal('center');

        $indice = $indice + 1;
    }
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('A' . $indice . ':F' . $indice . '');
    //Texto para encabezado A.indice
    $activeWorksheet->setCellValue('A' . $indice, 'TOTAL ');
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setHorizontal('right');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getFont()->setBold(true);
    //Todos los bordes para la celda cabecera A a F
    $activeWorksheet->getStyle('A' . $indice . ':F' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':F' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':F' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':F' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera A a F
    $activeWorksheet->getStyle('F' . $indice . ':G' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F' . $indice . ':G' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F' . $indice . ':G' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F' . $indice . ':G' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('A' . $indice)->getFont()->setSize(10);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('G' . $indice)->getFont()->setSize(10);

    foreach ($manipulacion_uti_list as $manipulacion_uti_line) {
        //Valor para celda G.$indice
        $activeWorksheet->setCellValue('G' . $indice, $manipulacion_uti_line['total_importe_manipulacion_utis']);
    }
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('G' . $indice)->getAlignment()->setHorizontal('center');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('G' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('G' . $indice)->getFont()->setBold(true);

    //Columna F en formato numero
    $activeWorksheet->getStyle('F' . $indice)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

    $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($filename);
    header('Location: ' . $filename);
    echo "FACTURACION MANIPULACION-UTI CCIS-BILBAO";
}

function excel_detalle_facturacion_almacenaje_ccis_bilbao($almacenaje_list_20, $almacenaje_list_40, $almacenaje_list_45, $almacenaje_agrupado_list, $fecha_inicio, $fecha_fin, $tarifas)
{
    //ALMACENAJE DE 20'
    $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
    $fecha_fin = date('Y-m-d', strtotime($fecha_fin));

    $nombre_comercial_cliente = 'CCIS-BILBAO';
    $filename = "../excel/facturas/" . $nombre_comercial_cliente . "/LISTADO FACTURACIÓN ALMACENAJE " . $nombre_comercial_cliente . "_DEL_" . $fecha_inicio . "_AL_" . $fecha_fin . ".xlsx";
    $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();

    // Set default font type to 'Arial'
    $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
    // Set default font size to '12'
    $spreadsheet->getDefaultStyle()->getFont()->setSize(11);

    $activeWorksheet = $spreadsheet->getActiveSheet();

    //Nombre de la hoja activa
    $activeWorksheet->setTitle("ALMACENAJE");

    //Texto para titulo A1
    $activeWorksheet->setCellValue('A1', 'ALMACENAJE 20´ - ' . $nombre_comercial_cliente . " del " . $fecha_inicio . " - " . $fecha_fin);
    //Alineación horizontal para la celda A1
    $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('A1')->getAlignment()->setVertical('center');
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
    $activeWorksheet->getRowDimension('1')->setRowHeight(15);

    //Anchura para la columna A
    $activeWorksheet->getColumnDimension('A')->setWidth(10.71);
    //Anchura para la columna B
    $activeWorksheet->getColumnDimension('B')->setWidth(8.57);
    //Anchura para la columna C
    $activeWorksheet->getColumnDimension('C')->setWidth(8.57);
    //Anchura para la columna D
    $activeWorksheet->getColumnDimension('D')->setWidth(8.14);
    //Anchura para la columna E
    $activeWorksheet->getColumnDimension('E')->setWidth(16);
    //Anchura para la columna F
    $activeWorksheet->getColumnDimension('F')->setWidth(12.57);

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

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('A1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('A1:F1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('A2:F2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
    $activeWorksheet->getStyle('F2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00B0F0');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('A2:F2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    foreach ($tarifas as $tarifa) {
        $tarifa_almacenaje_20 = $tarifa['tarifa_almacenaje_20'];
        $unidades_libres_20 = $tarifa['unidades_libres_20'];
        $tarifa_almacenaje_40 = $tarifa['tarifa_almacenaje_40'];
        $unidades_libres_40 = $tarifa['unidades_libres_40'];
        $tarifa_almacenaje_45 = $tarifa['tarifa_almacenaje_45'];
        $unidades_libres_45 = $tarifa['unidades_libres_45'];
    }

    //Texto para encabezado A1
    $activeWorksheet->setCellValue('A2', 'FECHA');
    //Texto para encabezado B1
    $activeWorksheet->setCellValue('B2', 'ENTRADA 20´ ');
    //Texto para encabezado C1
    $activeWorksheet->setCellValue('C2', 'SALIDA 20´ ');
    //Texto para encabezado D1
    $activeWorksheet->setCellValue('D2', 'STOCK 20´');
    //Texto para encabezado E1
    $activeWorksheet->setCellValue('E2', 'ALMACENAJE 20´ ('.$unidades_libres_20.' UNIDADES LIBRES)');
    //Texto para encabezado F1
    $activeWorksheet->setCellValue('F2', 'IMPORTE ALMACENAJE ('.$tarifa_almacenaje_20.' €/UTI)');

    //Ajustar texto para encabezado A1
    $activeWorksheet->getStyle('A2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado B1
    $activeWorksheet->getStyle('B2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado C1
    $activeWorksheet->getStyle('C2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado D1
    $activeWorksheet->getStyle('D2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado E1
    $activeWorksheet->getStyle('E2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado F1
    $activeWorksheet->getStyle('F2')->getAlignment()->setWrapText(true);

    //Columna A en formato fecha
    $activeWorksheet->getStyle('A')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
    //Columna B en formato numero
    $activeWorksheet->getStyle('B')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna C en formato numero
    $activeWorksheet->getStyle('C')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna D en formato fecha
    $activeWorksheet->getStyle('D')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna E en formato numero
    $activeWorksheet->getStyle('E')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna F en formato fecha
    $activeWorksheet->getStyle('F')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

    //Desfase para fila de cabeceras
    $indice = 3;
    foreach ($almacenaje_list_20 as $almacenaje_line_20) {
        //Valor para celda A.$indice
        $activeWorksheet->setCellValue('A' . $indice, $almacenaje_line_20['fecha_dia']);
        //Valor para celda B.$indice
        $activeWorksheet->setCellValue('B' . $indice, $almacenaje_line_20['num_contenedores_entrada_20']);
        //Valor para celda C.$indice
        $activeWorksheet->setCellValue('C' . $indice, $almacenaje_line_20['num_contenedores_salida_20']);
        //Valor para celda D.$indice
        $activeWorksheet->setCellValue('D' . $indice, $almacenaje_line_20['num_contenedores_20_total']);
        //Valor para celda E.$indice
        $activeWorksheet->setCellValue('E' . $indice, $almacenaje_line_20['num_contenedores_20_cobrar']);
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('F' . $indice, $almacenaje_line_20['importe_almacenaje_20']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda B.$indice
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda C.$indice
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda D.$indice
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('B' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('C' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('D' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('E' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('F' . $indice)->getAlignment()->setHorizontal('center');

        $indice = $indice + 1;
    }
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('A' . $indice . ':E' . $indice . '');
    //Texto para encabezado A.indice
    $activeWorksheet->setCellValue('A' . $indice, 'TOTAL ');
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setHorizontal('right');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getFont()->setBold(true);
    //Todos los bordes para la celda cabecera A a E
    $activeWorksheet->getStyle('A' . $indice . ':E' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':E' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':E' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':E' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera E a F
    $activeWorksheet->getStyle('E' . $indice . ':F' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E' . $indice . ':F' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E' . $indice . ':F' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E' . $indice . ':F' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('A' . $indice)->getFont()->setSize(11);

    foreach ($almacenaje_agrupado_list as $almacenaje_agrupado_line) {
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('F' . $indice, $almacenaje_agrupado_line['total_importe_almacenaje_20']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('F' . $indice)->getAlignment()->setHorizontal('center');
    }
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('F' . $indice)->getAlignment()->setHorizontal('center');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('F' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('F' . $indice)->getFont()->setBold(true);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('F' . $indice)->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('F' . $indice)->getFont()->setSize(10);
    //Columna F en formato numero
    $activeWorksheet->getStyle('F' . $indice)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Texto para titulo I1
    $activeWorksheet->setCellValue('I1', 'ALMACENAJE 40´ - ' . $nombre_comercial_cliente . " del " . $fecha_inicio . " - " . $fecha_fin);
    //Alineación horizontal para la celda I1
    $activeWorksheet->getStyle('I1')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('I1')->getAlignment()->setVertical('center');
    //Texto en negrita para la celda A1
    $activeWorksheet->getStyle('I1')->getFont()->setBold(true);
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('I1:N1');

    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('I2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('J2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('K2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('L2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('M2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('N2')->getAlignment()->setHorizontal('center');

    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('I2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('J2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('K2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('L2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('M2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('N2')->getAlignment()->setVertical('center');

    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('I2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('J2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('K2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('L2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('M2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('N2')->getFont()->setBold(true);

    //Altura de las celdas de cabecera
    $activeWorksheet->getRowDimension('1')->setRowHeight(15);

    //Anchura para la columna I
    $activeWorksheet->getColumnDimension('I')->setWidth(10.71);
    //Anchura para la columna J
    $activeWorksheet->getColumnDimension('J')->setWidth(9.71);
    //Anchura para la columna K
    $activeWorksheet->getColumnDimension('K')->setWidth(9.14);
    //Anchura para la columna L
    $activeWorksheet->getColumnDimension('L')->setWidth(8);
    //Anchura para la columna M
    $activeWorksheet->getColumnDimension('M')->setWidth(17.14);
    //Anchura para la columna N
    $activeWorksheet->getColumnDimension('N')->setWidth(12);

    //Todos los bordes para la celda cabecera A2
    $activeWorksheet->getStyle('I2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera B2
    $activeWorksheet->getStyle('J2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('J2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('J2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('J2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera C2
    $activeWorksheet->getStyle('K2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('K2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('K2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('K2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera D2
    $activeWorksheet->getStyle('L2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('L2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('L2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('L2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera E2
    $activeWorksheet->getStyle('M2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('M2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('M2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('M2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera F2
    $activeWorksheet->getStyle('N2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('N2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('N2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('N2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('I1:N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('I1:N1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('I2:N2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
    $activeWorksheet->getStyle('N2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00B0F0');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('I2:N2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    //Texto para encabezado A1
    $activeWorksheet->setCellValue('I2', 'FECHA');
    //Texto para encabezado B1
    $activeWorksheet->setCellValue('J2', 'ENTRADA 40´ ');
    //Texto para encabezado C1
    $activeWorksheet->setCellValue('K2', 'SALIDA 40´ ');
    //Texto para encabezado D1
    $activeWorksheet->setCellValue('L2', 'STOCK 40´');
    //Texto para encabezado E1
    $activeWorksheet->setCellValue('M2', 'ALMACENAJE 40´ ('.$unidades_libres_40.' UNIDADES LIBRES)');
    //Texto para encabezado F1
    $activeWorksheet->setCellValue('N2', 'IMPORTE ALMACENAJE ('.$tarifa_almacenaje_40.'€/UTI)');

    //Ajustar texto para encabezado A1
    $activeWorksheet->getStyle('I2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado B1
    $activeWorksheet->getStyle('J2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado C1
    $activeWorksheet->getStyle('K2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado D1
    $activeWorksheet->getStyle('L2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado E1
    $activeWorksheet->getStyle('M2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado F1
    $activeWorksheet->getStyle('N2')->getAlignment()->setWrapText(true);

    //Columna A en formato fecha
    $activeWorksheet->getStyle('I')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
    //Columna B en formato numero
    $activeWorksheet->getStyle('J')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna C en formato numero
    $activeWorksheet->getStyle('K')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna D en formato fech
    $activeWorksheet->getStyle('L')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna E en formato numero
    $activeWorksheet->getStyle('M')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna F en formato fecha
    $activeWorksheet->getStyle('N')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

    //Desfase para fila de cabeceras
    $indice = 3;
    foreach ($almacenaje_list_40 as $almacenaje_line_40) {
        //Valor para celda A.$indice
        $activeWorksheet->setCellValue('I' . $indice, $almacenaje_line_40['fecha_dia']);
        //Valor para celda B.$indice
        $activeWorksheet->setCellValue('J' . $indice, $almacenaje_line_40['num_contenedores_entrada_40']);
        //Valor para celda C.$indice
        $activeWorksheet->setCellValue('K' . $indice, $almacenaje_line_40['num_contenedores_salida_40']);
        //Valor para celda D.$indice
        $activeWorksheet->setCellValue('L' . $indice, $almacenaje_line_40['num_contenedores_40_total']);
        //Valor para celda E.$indice
        $activeWorksheet->setCellValue('M' . $indice, $almacenaje_line_40['num_contenedores_40_cobrar']);
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('N' . $indice, $almacenaje_line_40['importe_almacenaje_40']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('I' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('I' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('I' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('I' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda B.$indice
        $activeWorksheet->getStyle('J' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('J' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('J' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('J' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda C.$indice
        $activeWorksheet->getStyle('K' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('K' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('K' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('K' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda D.$indice
        $activeWorksheet->getStyle('L' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('L' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('L' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('L' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('M' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('M' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('M' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('M' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('N' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('N' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('N' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('N' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('I' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('J' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('K' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('L' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('M' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('N' . $indice)->getAlignment()->setHorizontal('center');

        $indice = $indice + 1;
    }
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('I' . $indice . ':M' . $indice . '');
    //Texto para encabezado A.indice
    $activeWorksheet->setCellValue('I' . $indice, 'TOTAL ');
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('I' . $indice)->getAlignment()->setHorizontal('right');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('I' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('I' . $indice)->getFont()->setBold(true);
    //Todos los bordes para la celda cabecera A a E
    $activeWorksheet->getStyle('I' . $indice . ':M' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I' . $indice . ':M' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I' . $indice . ':M' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I' . $indice . ':M' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera E a F
    $activeWorksheet->getStyle('M' . $indice . ':N' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('M' . $indice . ':N' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('M' . $indice . ':N' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('M' . $indice . ':N' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('I' . $indice)->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('I' . $indice)->getFont()->setSize(11);

    foreach ($almacenaje_agrupado_list as $almacenaje_agrupado_line) {
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('N' . $indice, $almacenaje_agrupado_line['total_importe_almacenaje_40']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('N' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('N' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('N' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('N' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('N' . $indice)->getAlignment()->setHorizontal('center');
    }
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('N' . $indice)->getAlignment()->setHorizontal('center');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('N' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('N' . $indice)->getFont()->setBold(true);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('N' . $indice)->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('N' . $indice)->getFont()->setSize(10);
    //Columna F en formato numero
    $activeWorksheet->getStyle('N' . $indice)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Texto para titulo I1
    $activeWorksheet->setCellValue('Q1', 'ALMACENAJE 45´ - ' . $nombre_comercial_cliente . " del " . $fecha_inicio . " - " . $fecha_fin);
    //Alineación horizontal para la celda I1
    $activeWorksheet->getStyle('Q1')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('Q1')->getAlignment()->setVertical('center');
    //Texto en negrita para la celda A1
    $activeWorksheet->getStyle('Q1')->getFont()->setBold(true);
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('Q1:V1');

    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('Q2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('R2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('S2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('T2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('U2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('V2')->getAlignment()->setHorizontal('center');

    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('Q2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('R2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('S2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('T2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('U2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('V2')->getAlignment()->setVertical('center');

    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('Q2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('R2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('S2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('T2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('U2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('V2')->getFont()->setBold(true);

    //Altura de las celdas de cabecera
    $activeWorksheet->getRowDimension('1')->setRowHeight(15);

    //Anchura para la columna I
    $activeWorksheet->getColumnDimension('Q')->setWidth(10, 71);
    //Anchura para la columna J
    $activeWorksheet->getColumnDimension('R')->setWidth(9.57);
    //Anchura para la columna K
    $activeWorksheet->getColumnDimension('S')->setWidth(8.71);
    //Anchura para la columna L
    $activeWorksheet->getColumnDimension('T')->setWidth(8.14);
    //Anchura para la columna M
    $activeWorksheet->getColumnDimension('U')->setWidth(16.29);
    //Anchura para la columna N
    $activeWorksheet->getColumnDimension('V')->setWidth(12.43);

    //Todos los bordes para la celda cabecera A2
    $activeWorksheet->getStyle('Q2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('Q2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('Q2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('Q2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera B2
    $activeWorksheet->getStyle('R2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('R2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('R2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('R2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera C2
    $activeWorksheet->getStyle('S2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('S2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('S2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('S2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera D2
    $activeWorksheet->getStyle('T2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('T2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('T2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('T2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera E2
    $activeWorksheet->getStyle('U2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('U2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('U2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('U2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera F2
    $activeWorksheet->getStyle('V2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('V2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('V2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('V2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('Q1:V1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('Q1:V1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('Q2:V2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
    $activeWorksheet->getStyle('V2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00B0F0');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('Q2:V2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    //Texto para encabezado A1
    $activeWorksheet->setCellValue('Q2', 'FECHA');
    //Texto para encabezado B1
    $activeWorksheet->setCellValue('R2', 'ENTRADA 45´ ');
    //Texto para encabezado C1
    $activeWorksheet->setCellValue('S2', 'SALIDA 45´ ');
    //Texto para encabezado D1
    $activeWorksheet->setCellValue('T2', 'STOCK 45´');
    //Texto para encabezado E1
    $activeWorksheet->setCellValue('U2', 'ALMACENAJE 45´ ('.$unidades_libres_45.' UNIDADES LIBRES)');
    //Texto para encabezado F1
    $activeWorksheet->setCellValue('V2', 'IMPORTE ALMACENAJE ('.$tarifa_almacenaje_45.'€/UTI)');

    //Ajustar texto para encabezado A1
    $activeWorksheet->getStyle('Q2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado B1
    $activeWorksheet->getStyle('R2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado C1
    $activeWorksheet->getStyle('S2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado D1
    $activeWorksheet->getStyle('T2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado E1
    $activeWorksheet->getStyle('U2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado F1
    $activeWorksheet->getStyle('V2')->getAlignment()->setWrapText(true);

    //Columna A en formato fecha
    $activeWorksheet->getStyle('Q')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
    //Columna B en formato numero
    $activeWorksheet->getStyle('R')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna C en formato numero
    $activeWorksheet->getStyle('S')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna D en formato fech
    $activeWorksheet->getStyle('T')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna E en formato numero
    $activeWorksheet->getStyle('U')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna F en formato fecha
    $activeWorksheet->getStyle('V')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

    //Desfase para fila de cabeceras
    $indice = 3;
    foreach ($almacenaje_list_45 as $almacenaje_line_45) {
        //Valor para celda A.$indice
        $activeWorksheet->setCellValue('Q' . $indice, $almacenaje_line_45['fecha_dia']);
        //Valor para celda B.$indice
        $activeWorksheet->setCellValue('R' . $indice, $almacenaje_line_45['num_contenedores_entrada_45']);
        //Valor para celda C.$indice
        $activeWorksheet->setCellValue('S' . $indice, $almacenaje_line_45['num_contenedores_salida_45']);
        //Valor para celda D.$indice
        $activeWorksheet->setCellValue('T' . $indice, $almacenaje_line_45['num_contenedores_45_total']);
        //Valor para celda E.$indice
        $activeWorksheet->setCellValue('U' . $indice, $almacenaje_line_45['num_contenedores_45_cobrar']);
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('V' . $indice, $almacenaje_line_45['importe_almacenaje_45']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('Q' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('Q' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('Q' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('Q' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda B.$indice
        $activeWorksheet->getStyle('R' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('R' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('R' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('R' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda C.$indice
        $activeWorksheet->getStyle('S' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('S' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('S' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('S' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda D.$indice
        $activeWorksheet->getStyle('T' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('T' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('T' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('T' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('U' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('U' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('U' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('U' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('V' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('V' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('V' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('V' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('Q' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('R' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('S' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('T' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('U' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('V' . $indice)->getAlignment()->setHorizontal('center');

        $indice = $indice + 1;
    }
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('Q' . $indice . ':U' . $indice . '');
    //Texto para encabezado A.indice
    $activeWorksheet->setCellValue('Q' . $indice, 'TOTAL ');
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('Q' . $indice)->getAlignment()->setHorizontal('right');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('Q' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('Q' . $indice)->getFont()->setBold(true);
    //Todos los bordes para la celda cabecera A a E
    $activeWorksheet->getStyle('Q' . $indice . ':U' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('Q' . $indice . ':U' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('Q' . $indice . ':U' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('Q' . $indice . ':U' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera E a F
    $activeWorksheet->getStyle('U' . $indice . ':V' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('U' . $indice . ':V' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('U' . $indice . ':V' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('U' . $indice . ':V' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('Q' . $indice)->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('Q' . $indice)->getFont()->setSize(10);

    foreach ($almacenaje_agrupado_list as $almacenaje_agrupado_line) {
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('V' . $indice, $almacenaje_agrupado_line['total_importe_almacenaje_45']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('V' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('V' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('V' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('V' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('V' . $indice)->getAlignment()->setHorizontal('center');
    }
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('V' . $indice)->getAlignment()->setHorizontal('center');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('V' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('V' . $indice)->getFont()->setBold(true);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('V' . $indice)->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('V' . $indice)->getFont()->setSize(11);
    //Columna F en formato numero
    $activeWorksheet->getStyle('V' . $indice)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($filename);
    header('Location: ' . $filename);
    echo "FACTURACION ALMACENAJE CCIS-BILBAO";
}

function excel_detalle_facturacion_temperatura_conexionado_limpieza_ccis_bilbao($conexionado_control_temperatura_list, $fecha_inicio, $fecha_fin, $tarifas)
{
    $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
    $fecha_fin = date('Y-m-d', strtotime($fecha_fin));

    $nombre_comercial_cliente = 'CCIS-BILBAO';
    $filename = "../excel/facturas/" . $nombre_comercial_cliente . "/LISTADO FACTURACIÓN CONEXIONADO + CONTROL_TEMP + LIMPIEZA " . $nombre_comercial_cliente . "_DEL_" . $fecha_inicio . "_AL_" . $fecha_fin . ".xlsx";
    $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();

    // Set default font type to 'Arial'
    $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
    // Set default font size to '10'
    $spreadsheet->getDefaultStyle()->getFont()->setSize(10.25);

    $activeWorksheet = $spreadsheet->getActiveSheet();

    //Nombre de la hoja activa
    $activeWorksheet->setTitle("CONEXION+CONTROL TEMP+LIMPIEZA");

    //Texto para titulo A1
    $activeWorksheet->setCellValue('A1', 'CONEXION+CONTROL TEMP+LIMPIEZA - ' . $nombre_comercial_cliente . " del " . $fecha_inicio . " al " . $fecha_fin);
    //Alineación horizontal para la celda A1
    $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('A1')->getAlignment()->setVertical('center');
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
    $activeWorksheet->getRowDimension('1')->setRowHeight(20);

    //Anchura para la columna A
    $activeWorksheet->getColumnDimension('A')->setWidth(12.71);
    //Anchura para la columna B
    $activeWorksheet->getColumnDimension('B')->setWidth(8.29);
    //Anchura para la columna C
    $activeWorksheet->getColumnDimension('C')->setWidth(14.14);
    //Anchura para la columna D
    $activeWorksheet->getColumnDimension('D')->setWidth(10);
    //Anchura para la columna E
    $activeWorksheet->getColumnDimension('E')->setWidth(12.86);
    //Anchura para la columna F
    $activeWorksheet->getColumnDimension('F')->setWidth(5.86);
    //Anchura para la columna G
    $activeWorksheet->getColumnDimension('G')->setWidth(17.43);
    $activeWorksheet->getColumnDimension('H')->setWidth(9.86);
    $activeWorksheet->getColumnDimension('I')->setWidth(9);

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

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('A1:I1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('A2:F2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
    $activeWorksheet->getStyle('G2:I2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00B0F0');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('A2:I2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    foreach ($tarifas as $tarifa) {
        $tarifa_temperatura = $tarifa['tarifa_temperatura'];
        $tarifa_conexion = $tarifa['tarifa_conexion'];
        $tarifa_limpieza = $tarifa['tarifa_limpieza'];
    }

    //Texto para encabezado A1
    $activeWorksheet->setCellValue('A2', 'Nº CONTENEDOR');
    //Texto para encabezado B1
    $activeWorksheet->setCellValue('B2', 'TAMAÑO');
    //Texto para encabezado C1
    $activeWorksheet->setCellValue('C2', 'TIPO');
    //Texto para encabezado D1
    $activeWorksheet->setCellValue('D2', 'FECHA CONEXIÓN');
    //Texto para encabezado E1
    $activeWorksheet->setCellValue('E2', 'FECHA DESCONEXIÓN');
    //Texto para encabezado F1
    $activeWorksheet->setCellValue('F2', 'TOTAL DIAS');
    //Texto para encabezado G1
    $activeWorksheet->setCellValue('G2', 'IMPORTE CONTROL TEMPERATURA ('.$tarifa_temperatura.' €/UTI)');
    $activeWorksheet->setCellValue('H2', 'IMPORTE CONEXIÓN ('.$tarifa_conexion.' €/UTI)');
    $activeWorksheet->setCellValue('I2', 'IMPORTE LIMPIEZA ('.$tarifa_limpieza.' €/UTI)');

    //Ajustar texto para encabezado A1
    $activeWorksheet->getStyle('A2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado B1
    $activeWorksheet->getStyle('B2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado C1
    $activeWorksheet->getStyle('C2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado D1
    $activeWorksheet->getStyle('D2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado E1
    $activeWorksheet->getStyle('E2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado F1
    $activeWorksheet->getStyle('F2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado G1
    $activeWorksheet->getStyle('G2')->getAlignment()->setWrapText(true);
    $activeWorksheet->getStyle('H2')->getAlignment()->setWrapText(true);
    $activeWorksheet->getStyle('I2')->getAlignment()->setWrapText(true);

    //Columna B en formato numero
    $activeWorksheet->getStyle('B')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna C en formato numero
    $activeWorksheet->getStyle('C')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
    //Columna E en formato fecha
    $activeWorksheet->getStyle('D')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna E en formato numero
    $activeWorksheet->getStyle('E')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
    //Columna F en formato fecha
    $activeWorksheet->getStyle('F')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna G en formato fecha
    $activeWorksheet->getStyle('G')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
    $activeWorksheet->getStyle('H')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
    $activeWorksheet->getStyle('I')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
    //$activeWorksheet->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00 €');

    //Desfase para fila de cabeceras
    $indice = 3;
    foreach ($conexionado_control_temperatura_list as $conexionado_control_temperatura_line) {
        //Valor para celda A.$indice
        $activeWorksheet->setCellValue('A' . $indice, $conexionado_control_temperatura_line['num_contenedor']);
        //Valor para celda B.$indice
        $activeWorksheet->setCellValue('B' . $indice, $conexionado_control_temperatura_line['longitud_tipo_contenedor']);
        //Valor para celda C.$indice
        $activeWorksheet->setCellValue('C' . $indice, $conexionado_control_temperatura_line['descripcion_tipo_contenedor']);
        //Valor para celda D.$indice
        $activeWorksheet->setCellValue('D' . $indice, $conexionado_control_temperatura_line['fecha_conexion']);
        //Valor para celda E.$indice
        $activeWorksheet->setCellValue('E' . $indice, $conexionado_control_temperatura_line['fecha_desconexion']);
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('F' . $indice, $conexionado_control_temperatura_line['total_dias']);
        //Valor para celda G.$indice
        $activeWorksheet->setCellValue('G' . $indice, $conexionado_control_temperatura_line['importe_control_temperatura']);
        $activeWorksheet->setCellValue('H' . $indice, $conexionado_control_temperatura_line['importe_conexion']);
        $activeWorksheet->setCellValue('I' . $indice, $conexionado_control_temperatura_line['importe_limpieza']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda B.$indice
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda C.$indice
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda D.$indice
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('G' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('G' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('G' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('G' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('H' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('H' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('H' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('H' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('I' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('I' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('I' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('I' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('B' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('C' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('D' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('E' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('F' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('G' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('H' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('I' . $indice)->getAlignment()->setHorizontal('center');

        $indice = $indice + 1;
    }
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('A' . $indice . ':F' . $indice . '');
    //Texto para encabezado A.indice
    $activeWorksheet->setCellValue('A' . $indice, 'SUBTOTAL ');
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setHorizontal('right');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getFont()->setBold(true);
    //Todos los bordes para la celda cabecera A a F
    $activeWorksheet->getStyle('A' . $indice . ':F' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':F' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':F' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':F' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera A a F
    $activeWorksheet->getStyle('F' . $indice . ':G' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F' . $indice . ':G' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F' . $indice . ':G' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F' . $indice . ':G' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('A' . $indice)->getFont()->setSize(10);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('G' . $indice)->getFont()->setSize(10);

    foreach ($conexionado_control_temperatura_list as $conexionado_control_temperatura_line) {
        //Valor para celda G.$indice
        $activeWorksheet->setCellValue('G' . $indice, $conexionado_control_temperatura_line['total_importe_control_temperatura']);
        $activeWorksheet->setCellValue('H' . $indice, $conexionado_control_temperatura_line['total_importe_conexion']);
        $activeWorksheet->setCellValue('I' . $indice, $conexionado_control_temperatura_line['total_importe_limpieza']);
    }
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('G' . $indice . ':I' . $indice . '')->getAlignment()->setHorizontal('center');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('G' . $indice . ':I' . $indice . '')->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('G' . $indice . ':I' . $indice . '')->getFont()->setBold(true);

    //Todos los bordes para la celda E.$indice
    $activeWorksheet->getStyle('G' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda E.$indice
    $activeWorksheet->getStyle('H' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda E.$indice
    $activeWorksheet->getStyle('I' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    //Columna F en formato numero
    $activeWorksheet->getStyle('G' . $indice . ':I' . $indice . '')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

    $indice = $indice + 1;
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('A' . $indice . ':F' . $indice . '');
    //Texto para encabezado A.indice
    $activeWorksheet->setCellValue('A' . $indice, 'TOTAL ');
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setHorizontal('right');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getFont()->setBold(true);
    //Todos los bordes para la celda cabecera A a F
    $activeWorksheet->getStyle('A' . $indice . ':F' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':F' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':F' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':F' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('G' . $indice . ':I' . $indice . '');
    //Texto para encabezado A.indice
    $activeWorksheet->setCellValue('G' . $indice, $conexionado_control_temperatura_line['total']);
    //Todos los bordes para la celda cabecera A a F
    $activeWorksheet->getStyle('G' . $indice . ':I' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G' . $indice . ':I' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G' . $indice . ':I' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G' . $indice . ':I' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('A' . $indice . ':I' . $indice . '')->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('A' . $indice . ':I' . $indice . '')->getFont()->setSize(10);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('G' . $indice . ':I' . $indice . '')->getFont()->setSize(10);
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('G' . $indice . ':I' . $indice . '')->getAlignment()->setHorizontal('center');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('G' . $indice . ':I' . $indice . '')->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('G' . $indice . ':I' . $indice . '')->getFont()->setBold(true);
    //Columna F en formato numero
    $activeWorksheet->getStyle('G' . $indice . ':I' . $indice . '')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

    $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($filename);
    header('Location: ' . $filename);
    echo "FACTURACION TEMPERATURA, CONEXIONADO Y LIMPIEZA CCIS-BILBAO";
}

function excel_detalle_facturacion_horas_extras_ccis_bilbao($horas_extras, $fecha_inicio, $fecha_fin)
{
    echo "FACTURACION HORAS EXTRAS CCIS-BILBAO";
}

function excel_detalle_facturacion_manipulacion_uti_sicsa_valencia($manipulacion_uti_list, $fecha_inicio, $fecha_fin, $tarifas)
{
    $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
    $fecha_fin = date('Y-m-d', strtotime($fecha_fin));

    $nombre_comercial_cliente = 'SICSA-VALENCIA';
    $filename = "../excel/facturas/" . $nombre_comercial_cliente . "/LISTADO FACTURACIÓN MANIPULACIÓN UTI " . $nombre_comercial_cliente . "_DEL_" . $fecha_inicio . "_AL_" . $fecha_fin . ".xlsx";
    $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();

    // Set default font type to 'Arial'
    $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
    // Set default font size to '10'
    $spreadsheet->getDefaultStyle()->getFont()->setSize(11);

    $activeWorksheet = $spreadsheet->getActiveSheet();

    //Nombre de la hoja activa
    $activeWorksheet->setTitle("MANIPULACION-UTI");

    //Texto para titulo A1
    $activeWorksheet->setCellValue('A1', 'MANIPULACION UTI - ' . $nombre_comercial_cliente . " del " . $fecha_inicio . " al " . $fecha_fin);
    //Alineación horizontal para la celda A1
    $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('A1')->getAlignment()->setVertical('center');
    //Texto en negrita para la celda A1
    $activeWorksheet->getStyle('A1')->getFont()->setBold(true);
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('A1:G1');

    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('B2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('C2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('D2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('E2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('F2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('G2')->getAlignment()->setHorizontal('center');

    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('A2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('B2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('C2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('D2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('E2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('F2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('G2')->getAlignment()->setVertical('center');

    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('A2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('B2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('C2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('D2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('E2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('F2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('G2')->getFont()->setBold(true);

    //Altura de las celdas de cabecera
    $activeWorksheet->getRowDimension('1')->setRowHeight(20);

    //Anchura para la columna A
    $activeWorksheet->getColumnDimension('A')->setWidth(12.71);
    //Anchura para la columna B
    $activeWorksheet->getColumnDimension('B')->setWidth(9.57);
    //Anchura para la columna C
    $activeWorksheet->getColumnDimension('C')->setWidth(9.57);
    //Anchura para la columna D
    $activeWorksheet->getColumnDimension('D')->setWidth(12.86);
    //Anchura para la columna E
    $activeWorksheet->getColumnDimension('E')->setWidth(12.29);
    //Anchura para la columna F
    $activeWorksheet->getColumnDimension('F')->setWidth(10.86);
    //Anchura para la columna G
    $activeWorksheet->getColumnDimension('G')->setWidth(17);

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

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('A1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('A1:G1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('A2:F2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
    $activeWorksheet->getStyle('G2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00B0F0');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('A2:G2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    foreach ($tarifas as $tarifa) {
        $tarifa_manipulacion_uti = $tarifa['tarifa_manipulacion_uti'];
    }

    //Texto para encabezado A1
    $activeWorksheet->setCellValue('A2', 'Nº CONTENEDOR');
    //Texto para encabezado B1
    $activeWorksheet->setCellValue('B2', 'TAMAÑO');
    //Texto para encabezado C1
    $activeWorksheet->setCellValue('C2', 'FECHA ENTRADA');
    //Texto para encabezado D1
    $activeWorksheet->setCellValue('D2', 'TIPO ENTRADA');
    //Texto para encabezado E1
    $activeWorksheet->setCellValue('E2', 'FECHA SALIDA');
    //Texto para encabezado F1
    $activeWorksheet->setCellValue('F2', 'TIPO SALIDA');
    //Texto para encabezado G1
    $activeWorksheet->setCellValue('G2', 'IMPORTE MANIPULACIÓN UTI ('.$tarifa_manipulacion_uti.' €/UTI)');

    //Ajustar texto para encabezado A1
    $activeWorksheet->getStyle('A2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado B1
    $activeWorksheet->getStyle('B2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado C1
    $activeWorksheet->getStyle('C2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado D1
    $activeWorksheet->getStyle('D2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado E1
    $activeWorksheet->getStyle('E2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado F1
    $activeWorksheet->getStyle('F2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado G1
    $activeWorksheet->getStyle('G2')->getAlignment()->setWrapText(true);

    //Columna B en formato numero
    $activeWorksheet->getStyle('B')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna C en formato numero
    $activeWorksheet->getStyle('C')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
    //Columna E en formato fecha
    $activeWorksheet->getStyle('D')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna E en formato numero
    $activeWorksheet->getStyle('E')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
    //Columna F en formato fecha
    $activeWorksheet->getStyle('F')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna G en formato fecha
    $activeWorksheet->getStyle('G')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
    //$activeWorksheet->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00 €');

    //Desfase para fila de cabeceras
    $indice = 3;
    foreach ($manipulacion_uti_list as $manipulacion_uti_line) {
        //Valor para celda A.$indice
        $activeWorksheet->setCellValue('A' . $indice, $manipulacion_uti_line['num_contenedor']);
        //Valor para celda B.$indice
        $activeWorksheet->setCellValue('B' . $indice, $manipulacion_uti_line['longitud_tipo_contenedor']);
        //Valor para celda C.$indice
        $activeWorksheet->setCellValue('C' . $indice, $manipulacion_uti_line['fecha_entrada']);
        //Valor para celda D.$indice
        $activeWorksheet->setCellValue('D' . $indice, $manipulacion_uti_line['tipo_entrada']);
        //Valor para celda E.$indice
        $activeWorksheet->setCellValue('E' . $indice, $manipulacion_uti_line['fecha_salida']);
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('F' . $indice, $manipulacion_uti_line['tipo_salida']);
        //Valor para celda G.$indice
        $activeWorksheet->setCellValue('G' . $indice, $manipulacion_uti_line['importe_manipulacion_utis']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda B.$indice
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda C.$indice
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda D.$indice
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('G' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('G' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('G' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('G' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('B' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('C' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('D' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('E' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('F' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('G' . $indice)->getAlignment()->setHorizontal('center');

        $indice = $indice + 1;
    }
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('A' . $indice . ':F' . $indice . '');
    //Texto para encabezado A.indice
    $activeWorksheet->setCellValue('A' . $indice, 'TOTAL ');
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setHorizontal('right');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getFont()->setBold(true);
    //Todos los bordes para la celda cabecera A a F
    $activeWorksheet->getStyle('A' . $indice . ':F' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':F' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':F' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':F' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera A a F
    $activeWorksheet->getStyle('F' . $indice . ':G' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F' . $indice . ':G' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F' . $indice . ':G' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F' . $indice . ':G' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('A' . $indice)->getFont()->setSize(10);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('G' . $indice)->getFont()->setSize(10);

    foreach ($manipulacion_uti_list as $manipulacion_uti_line) {
        //Valor para celda G.$indice
        $activeWorksheet->setCellValue('G' . $indice, $manipulacion_uti_line['total_importe_manipulacion_utis']);
    }
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('G' . $indice)->getAlignment()->setHorizontal('center');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('G' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('G' . $indice)->getFont()->setBold(true);

    //Columna F en formato numero
    $activeWorksheet->getStyle('F' . $indice)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

    $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($filename);
    header('Location: ' . $filename);
    echo "FACTURACION MANIPULACION-UTI SICSA-VALENCIA";
}

function excel_detalle_facturacion_almacenaje_sicsa_valencia($almacenaje_list_20, $almacenaje_list_40, $almacenaje_list_45, $almacenaje_agrupado_list, $fecha_inicio, $fecha_fin, $tarifas)
{
    //ALMACENAJE DE 20'
    $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
    $fecha_fin = date('Y-m-d', strtotime($fecha_fin));

    $nombre_comercial_cliente = 'SICSA-VALENCIA';
    $filename = "../excel/facturas/" . $nombre_comercial_cliente . "/LISTADO FACTURACIÓN ALMACENAJE " . $nombre_comercial_cliente . "_DEL_" . $fecha_inicio . "_AL_" . $fecha_fin . ".xlsx";
    $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();

    // Set default font type to 'Arial'
    $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
    // Set default font size to '12'
    $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

    $activeWorksheet = $spreadsheet->getActiveSheet();

    //Nombre de la hoja activa
    $activeWorksheet->setTitle("ALMACENAJE");

    //Texto para titulo A1
    $activeWorksheet->setCellValue('A1', 'ALMACENAJE 20´ - ' . $nombre_comercial_cliente . " del " . $fecha_inicio . " - " . $fecha_fin);
    //Alineación horizontal para la celda A1
    $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('A1')->getAlignment()->setVertical('center');
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
    $activeWorksheet->getRowDimension('1')->setRowHeight(15);

    //Anchura para la columna A
    $activeWorksheet->getColumnDimension('A')->setWidth(10.71);
    //Anchura para la columna B
    $activeWorksheet->getColumnDimension('B')->setWidth(9);
    //Anchura para la columna C
    $activeWorksheet->getColumnDimension('C')->setWidth(8.71);
    //Anchura para la columna D
    $activeWorksheet->getColumnDimension('D')->setWidth(8);
    //Anchura para la columna E
    $activeWorksheet->getColumnDimension('E')->setWidth(15.57);
    //Anchura para la columna F
    $activeWorksheet->getColumnDimension('F')->setWidth(13.14);

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

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('A1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('A1:F1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('A2:F2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
    $activeWorksheet->getStyle('F2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00B0F0');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('A2:F2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    foreach ($tarifas as $tarifa) {
        $tarifa_almacenaje_20 = $tarifa['tarifa_almacenaje_20'];
        $unidades_libres_20 = $tarifa['unidades_libres_20'];
        $tarifa_almacenaje_40 = $tarifa['tarifa_almacenaje_40'];
        $unidades_libres_40 = $tarifa['unidades_libres_40'];
        $tarifa_almacenaje_45 = $tarifa['tarifa_almacenaje_45'];
        $unidades_libres_45 = $tarifa['unidades_libres_45'];
    }

    //Texto para encabezado A1
    $activeWorksheet->setCellValue('A2', 'FECHA');
    //Texto para encabezado B1
    $activeWorksheet->setCellValue('B2', 'ENTRADA 20´ ');
    //Texto para encabezado C1
    $activeWorksheet->setCellValue('C2', 'SALIDA 20´ ');
    //Texto para encabezado D1
    $activeWorksheet->setCellValue('D2', 'STOCK 20´');
    //Texto para encabezado E1
    $activeWorksheet->setCellValue('E2', 'ALMACENAJE 20´ ('.$unidades_libres_20.' UNIDADES LIBRES)');
    //Texto para encabezado F1
    $activeWorksheet->setCellValue('F2', 'IMPORTE ALMACENAJE ('.$tarifa_almacenaje_20.' €/UTI)');

    //Ajustar texto para encabezado A1
    $activeWorksheet->getStyle('A2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado B1
    $activeWorksheet->getStyle('B2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado C1
    $activeWorksheet->getStyle('C2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado D1
    $activeWorksheet->getStyle('D2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado E1
    $activeWorksheet->getStyle('E2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado F1
    $activeWorksheet->getStyle('F2')->getAlignment()->setWrapText(true);

    //Columna A en formato fecha
    $activeWorksheet->getStyle('A')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
    //Columna B en formato numero
    $activeWorksheet->getStyle('B')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna C en formato numero
    $activeWorksheet->getStyle('C')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna D en formato fecha
    $activeWorksheet->getStyle('D')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna E en formato numero
    $activeWorksheet->getStyle('E')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna F en formato fecha
    $activeWorksheet->getStyle('F')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

    //Desfase para fila de cabeceras
    $indice = 3;
    foreach ($almacenaje_list_20 as $almacenaje_line_20) {
        //Valor para celda A.$indice
        $activeWorksheet->setCellValue('A' . $indice, $almacenaje_line_20['fecha_dia']);
        //Valor para celda B.$indice
        $activeWorksheet->setCellValue('B' . $indice, $almacenaje_line_20['num_contenedores_entrada_20']);
        //Valor para celda C.$indice
        $activeWorksheet->setCellValue('C' . $indice, $almacenaje_line_20['num_contenedores_salida_20']);
        //Valor para celda D.$indice
        $activeWorksheet->setCellValue('D' . $indice, $almacenaje_line_20['num_contenedores_20_total']);
        //Valor para celda E.$indice
        $activeWorksheet->setCellValue('E' . $indice, $almacenaje_line_20['num_contenedores_20_cobrar']);
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('F' . $indice, $almacenaje_line_20['importe_almacenaje_20']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda B.$indice
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda C.$indice
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda D.$indice
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('B' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('C' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('D' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('E' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('F' . $indice)->getAlignment()->setHorizontal('center');

        $indice = $indice + 1;
    }
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('A' . $indice . ':E' . $indice . '');
    //Texto para encabezado A.indice
    $activeWorksheet->setCellValue('A' . $indice, 'SUBTOTAL ');
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setHorizontal('right');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getFont()->setBold(true);
    //Todos los bordes para la celda cabecera A a E
    $activeWorksheet->getStyle('A' . $indice . ':E' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':E' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':E' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':E' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera E a F
    $activeWorksheet->getStyle('E' . $indice . ':F' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E' . $indice . ':F' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E' . $indice . ':F' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E' . $indice . ':F' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('A' . $indice)->getFont()->setSize(10);

    foreach ($almacenaje_agrupado_list as $almacenaje_agrupado_line) {
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('F' . $indice, $almacenaje_agrupado_line['total_importe_almacenaje_20']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('F' . $indice)->getAlignment()->setHorizontal('center');
    }
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('F' . $indice)->getAlignment()->setHorizontal('center');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('F' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('F' . $indice)->getFont()->setBold(true);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('F' . $indice)->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('F' . $indice)->getFont()->setSize(10);
    //Columna F en formato numero
    $activeWorksheet->getStyle('F' . $indice)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Texto para titulo I1
    $activeWorksheet->setCellValue('I1', 'ALMACENAJE 40´ - ' . $nombre_comercial_cliente . " del " . $fecha_inicio . " - " . $fecha_fin);
    //Alineación horizontal para la celda I1
    $activeWorksheet->getStyle('I1')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('I1')->getAlignment()->setVertical('center');
    //Texto en negrita para la celda A1
    $activeWorksheet->getStyle('I1')->getFont()->setBold(true);
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('I1:N1');

    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('I2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('J2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('K2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('L2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('M2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('N2')->getAlignment()->setHorizontal('center');

    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('I2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('J2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('K2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('L2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('M2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('N2')->getAlignment()->setVertical('center');

    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('I2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('J2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('K2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('L2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('M2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('N2')->getFont()->setBold(true);

    //Altura de las celdas de cabecera
    $activeWorksheet->getRowDimension('1')->setRowHeight(15);

    //Anchura para la columna I
    $activeWorksheet->getColumnDimension('I')->setWidth(10.71);
    //Anchura para la columna J
    $activeWorksheet->getColumnDimension('J')->setWidth(9.43);
    //Anchura para la columna K
    $activeWorksheet->getColumnDimension('K')->setWidth(9);
    //Anchura para la columna L
    $activeWorksheet->getColumnDimension('L')->setWidth(8.29);
    //Anchura para la columna M
    $activeWorksheet->getColumnDimension('M')->setWidth(15.43);
    //Anchura para la columna N
    $activeWorksheet->getColumnDimension('N')->setWidth(13.29);

    //Todos los bordes para la celda cabecera A2
    $activeWorksheet->getStyle('I2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera B2
    $activeWorksheet->getStyle('J2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('J2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('J2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('J2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera C2
    $activeWorksheet->getStyle('K2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('K2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('K2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('K2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera D2
    $activeWorksheet->getStyle('L2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('L2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('L2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('L2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera E2
    $activeWorksheet->getStyle('M2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('M2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('M2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('M2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera F2
    $activeWorksheet->getStyle('N2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('N2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('N2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('N2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('I1:N1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('I1:N1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('I2:N2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
    $activeWorksheet->getStyle('N2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00B0F0');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('I2:N2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    //Texto para encabezado A1
    $activeWorksheet->setCellValue('I2', 'FECHA');
    //Texto para encabezado B1
    $activeWorksheet->setCellValue('J2', 'ENTRADA 40´ ');
    //Texto para encabezado C1
    $activeWorksheet->setCellValue('K2', 'SALIDA 40´ ');
    //Texto para encabezado D1
    $activeWorksheet->setCellValue('L2', 'STOCK 40´');
    //Texto para encabezado E1
    $activeWorksheet->setCellValue('M2', 'ALMACENAJE 40´ ('.$unidades_libres_40.' UNIDADES LIBRES)');
    //Texto para encabezado F1
    $activeWorksheet->setCellValue('N2', 'IMPORTE ALMACENAJE ('.$tarifa_almacenaje_40.' €/UTI)');

    //Ajustar texto para encabezado A1
    $activeWorksheet->getStyle('I2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado B1
    $activeWorksheet->getStyle('J2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado C1
    $activeWorksheet->getStyle('K2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado D1
    $activeWorksheet->getStyle('L2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado E1
    $activeWorksheet->getStyle('M2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado F1
    $activeWorksheet->getStyle('N2')->getAlignment()->setWrapText(true);

    //Columna A en formato fecha
    $activeWorksheet->getStyle('I')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
    //Columna B en formato numero
    $activeWorksheet->getStyle('J')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna C en formato numero
    $activeWorksheet->getStyle('K')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna D en formato fech
    $activeWorksheet->getStyle('L')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna E en formato numero
    $activeWorksheet->getStyle('M')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna F en formato fecha
    $activeWorksheet->getStyle('N')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

    //Desfase para fila de cabeceras
    $indice = 3;
    foreach ($almacenaje_list_40 as $almacenaje_line_40) {
        //Valor para celda A.$indice
        $activeWorksheet->setCellValue('I' . $indice, $almacenaje_line_40['fecha_dia']);
        //Valor para celda B.$indice
        $activeWorksheet->setCellValue('J' . $indice, $almacenaje_line_40['num_contenedores_entrada_40']);
        //Valor para celda C.$indice
        $activeWorksheet->setCellValue('K' . $indice, $almacenaje_line_40['num_contenedores_salida_40']);
        //Valor para celda D.$indice
        $activeWorksheet->setCellValue('L' . $indice, $almacenaje_line_40['num_contenedores_40_total']);
        //Valor para celda E.$indice
        $activeWorksheet->setCellValue('M' . $indice, $almacenaje_line_40['num_contenedores_40_cobrar']);
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('N' . $indice, $almacenaje_line_40['importe_almacenaje_40']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('I' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('I' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('I' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('I' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda B.$indice
        $activeWorksheet->getStyle('J' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('J' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('J' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('J' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda C.$indice
        $activeWorksheet->getStyle('K' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('K' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('K' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('K' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda D.$indice
        $activeWorksheet->getStyle('L' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('L' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('L' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('L' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('M' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('M' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('M' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('M' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('N' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('N' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('N' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('N' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('I' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('J' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('K' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('L' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('M' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('N' . $indice)->getAlignment()->setHorizontal('center');

        $indice = $indice + 1;
    }
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('I' . $indice . ':M' . $indice . '');
    //Texto para encabezado A.indice
    $activeWorksheet->setCellValue('I' . $indice, 'SUBTOTAL ');
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('I' . $indice)->getAlignment()->setHorizontal('right');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('I' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('I' . $indice)->getFont()->setBold(true);
    //Todos los bordes para la celda cabecera A a E
    $activeWorksheet->getStyle('I' . $indice . ':M' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I' . $indice . ':M' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I' . $indice . ':M' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I' . $indice . ':M' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera E a F
    $activeWorksheet->getStyle('M' . $indice . ':N' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('M' . $indice . ':N' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('M' . $indice . ':N' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('M' . $indice . ':N' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('I' . $indice)->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('I' . $indice)->getFont()->setSize(10);

    foreach ($almacenaje_agrupado_list as $almacenaje_agrupado_line) {
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('N' . $indice, $almacenaje_agrupado_line['total_importe_almacenaje_40']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('N' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('N' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('N' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('N' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('N' . $indice)->getAlignment()->setHorizontal('center');
    }
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('N' . $indice)->getAlignment()->setHorizontal('center');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('N' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('N' . $indice)->getFont()->setBold(true);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('N' . $indice)->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('N' . $indice)->getFont()->setSize(10);
    //Columna F en formato numero
    $activeWorksheet->getStyle('N' . $indice)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //Texto para titulo I1
    $activeWorksheet->setCellValue('Q1', 'ALMACENAJE 45´ - ' . $nombre_comercial_cliente . " del " . $fecha_inicio . " - " . $fecha_fin);
    //Alineación horizontal para la celda I1
    $activeWorksheet->getStyle('Q1')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('Q1')->getAlignment()->setVertical('center');
    //Texto en negrita para la celda A1
    $activeWorksheet->getStyle('Q1')->getFont()->setBold(true);
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('Q1:V1');

    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('Q2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('R2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('S2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('T2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('U2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('V2')->getAlignment()->setHorizontal('center');

    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('Q2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('R2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('S2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('T2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('U2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('V2')->getAlignment()->setVertical('center');

    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('Q2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('R2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('S2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('T2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('U2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('V2')->getFont()->setBold(true);

    //Altura de las celdas de cabecera
    $activeWorksheet->getRowDimension('1')->setRowHeight(15);

    //Anchura para la columna I
    $activeWorksheet->getColumnDimension('Q')->setWidth(10.71);
    //Anchura para la columna J
    $activeWorksheet->getColumnDimension('R')->setWidth(10.14);
    //Anchura para la columna K
    $activeWorksheet->getColumnDimension('S')->setWidth(8.14);
    //Anchura para la columna L
    $activeWorksheet->getColumnDimension('T')->setWidth(8);
    //Anchura para la columna M
    $activeWorksheet->getColumnDimension('U')->setWidth(15);
    //Anchura para la columna N
    $activeWorksheet->getColumnDimension('V')->setWidth(12.29);

    //Todos los bordes para la celda cabecera A2
    $activeWorksheet->getStyle('Q2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('Q2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('Q2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('Q2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera B2
    $activeWorksheet->getStyle('R2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('R2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('R2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('R2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera C2
    $activeWorksheet->getStyle('S2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('S2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('S2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('S2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera D2
    $activeWorksheet->getStyle('T2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('T2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('T2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('T2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera E2
    $activeWorksheet->getStyle('U2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('U2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('U2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('U2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera F2
    $activeWorksheet->getStyle('V2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('V2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('V2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('V2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('Q1:V1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('Q1:V1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('Q2:V2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
    $activeWorksheet->getStyle('V2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00B0F0');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('Q2:V2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    //Texto para encabezado A1
    $activeWorksheet->setCellValue('Q2', 'FECHA');
    //Texto para encabezado B1
    $activeWorksheet->setCellValue('R2', 'ENTRADA 45´ ');
    //Texto para encabezado C1
    $activeWorksheet->setCellValue('S2', 'SALIDA 45´ ');
    //Texto para encabezado D1
    $activeWorksheet->setCellValue('T2', 'STOCK 45´');
    //Texto para encabezado E1
    $activeWorksheet->setCellValue('U2', 'ALMACENAJE 45´ ('.$unidades_libres_45.' UNIDADES LIBRES)');
    //Texto para encabezado F1
    $activeWorksheet->setCellValue('V2', 'IMPORTE ALMACENAJE ('.$tarifa_almacenaje_45.' €/UTI)');

    //Ajustar texto para encabezado A1
    $activeWorksheet->getStyle('Q2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado B1
    $activeWorksheet->getStyle('R2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado C1
    $activeWorksheet->getStyle('S2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado D1
    $activeWorksheet->getStyle('T2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado E1
    $activeWorksheet->getStyle('U2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado F1
    $activeWorksheet->getStyle('V2')->getAlignment()->setWrapText(true);

    //Columna A en formato fecha
    $activeWorksheet->getStyle('Q')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
    //Columna B en formato numero
    $activeWorksheet->getStyle('R')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna C en formato numero
    $activeWorksheet->getStyle('S')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna D en formato fech
    $activeWorksheet->getStyle('T')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna E en formato numero
    $activeWorksheet->getStyle('U')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna F en formato fecha
    $activeWorksheet->getStyle('V')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

    //Desfase para fila de cabeceras
    $indice = 3;
    foreach ($almacenaje_list_45 as $almacenaje_line_45) {
        //Valor para celda A.$indice
        $activeWorksheet->setCellValue('Q' . $indice, $almacenaje_line_45['fecha_dia']);
        //Valor para celda B.$indice
        $activeWorksheet->setCellValue('R' . $indice, $almacenaje_line_45['num_contenedores_entrada_45']);
        //Valor para celda C.$indice
        $activeWorksheet->setCellValue('S' . $indice, $almacenaje_line_45['num_contenedores_salida_45']);
        //Valor para celda D.$indice
        $activeWorksheet->setCellValue('T' . $indice, $almacenaje_line_45['num_contenedores_45_total']);
        //Valor para celda E.$indice
        $activeWorksheet->setCellValue('U' . $indice, $almacenaje_line_45['num_contenedores_45_cobrar']);
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('V' . $indice, $almacenaje_line_45['importe_almacenaje_45']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('Q' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('Q' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('Q' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('Q' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda B.$indice
        $activeWorksheet->getStyle('R' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('R' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('R' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('R' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda C.$indice
        $activeWorksheet->getStyle('S' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('S' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('S' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('S' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda D.$indice
        $activeWorksheet->getStyle('T' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('T' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('T' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('T' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('U' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('U' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('U' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('U' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('V' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('V' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('V' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('V' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('Q' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('R' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('S' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('T' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('U' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('V' . $indice)->getAlignment()->setHorizontal('center');

        $indice = $indice + 1;
    }
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('Q' . $indice . ':U' . $indice . '');
    //Texto para encabezado A.indice
    $activeWorksheet->setCellValue('Q' . $indice, 'SUBTOTAL ');
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('Q' . $indice)->getAlignment()->setHorizontal('right');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('Q' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('Q' . $indice)->getFont()->setBold(true);
    //Todos los bordes para la celda cabecera A a E
    $activeWorksheet->getStyle('Q' . $indice . ':U' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('Q' . $indice . ':U' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('Q' . $indice . ':U' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('Q' . $indice . ':U' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera E a F
    $activeWorksheet->getStyle('U' . $indice . ':V' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('U' . $indice . ':V' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('U' . $indice . ':V' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('U' . $indice . ':V' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('Q' . $indice)->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('Q' . $indice)->getFont()->setSize(10);

    foreach ($almacenaje_agrupado_list as $almacenaje_agrupado_line) {
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('V' . $indice, $almacenaje_agrupado_line['total_importe_almacenaje_45']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('V' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('V' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('V' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('V' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('V' . $indice)->getAlignment()->setHorizontal('center');
    }
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('V' . $indice)->getAlignment()->setHorizontal('center');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('V' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('V' . $indice)->getFont()->setBold(true);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('V' . $indice)->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('V' . $indice)->getFont()->setSize(10);
    //Columna F en formato numero
    $activeWorksheet->getStyle('V' . $indice)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($filename);
    header('Location: ' . $filename);
    echo "FACTURACION ALMACENAJE SICSA-VALENCIA";
}

function excel_detalle_facturacion_horas_extras_sicsa_valencia($horas_extras, $fecha_inicio, $fecha_fin)
{
    echo "FACTURACION HORAS EXTRAS SICSA-VALENCIA";
}

function excel_detalle_facturacion_manipulacion_uti_renfe($manipulacion_uti_list, $fecha_inicio, $fecha_fin, $tarifas)
{
    $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
    $fecha_fin = date('Y-m-d', strtotime($fecha_fin));

    $nombre_comercial_cliente = 'RENFE';
    $filename = "../excel/facturas/" . $nombre_comercial_cliente . "/LISTADO FACTURACIÓN MANIPULACIÓN UTI " . $nombre_comercial_cliente . "_DEL_" . $fecha_inicio . "_AL_" . $fecha_fin . ".xlsx";
    $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();

    // Set default font type to 'Arial'
    $spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
    // Set default font size to '10'
    $spreadsheet->getDefaultStyle()->getFont()->setSize(10);

    $activeWorksheet = $spreadsheet->getActiveSheet();

    //Nombre de la hoja activa
    $activeWorksheet->setTitle("MANIPULACION-UTI");

    //Texto para titulo A1
    $activeWorksheet->setCellValue('A1', 'MANIPULACION UTI - ' . $nombre_comercial_cliente . " del " . $fecha_inicio . " al " . $fecha_fin);
    //Alineación horizontal para la celda A1
    $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('A1')->getAlignment()->setVertical('center');
    //Texto en negrita para la celda A1
    $activeWorksheet->getStyle('A1')->getFont()->setBold(true);
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('A1:M1');

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
    $activeWorksheet->getStyle('J2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('K2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('L2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('M2')->getAlignment()->setHorizontal('center');

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
    $activeWorksheet->getStyle('J2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('K2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('L2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('M2')->getAlignment()->setVertical('center');


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
    $activeWorksheet->getStyle('J2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('K2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('L2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('M2')->getFont()->setBold(true);


    //Altura de las celdas de cabecera
    $activeWorksheet->getRowDimension('1')->setRowHeight(20);

    //Anchura para la columna A
    $activeWorksheet->getColumnDimension('A')->setWidth(12.71);
    //Anchura para la columna B
    $activeWorksheet->getColumnDimension('B')->setWidth(8.57);
    //Anchura para la columna C
    $activeWorksheet->getColumnDimension('C')->setWidth(10.29);
    //Anchura para la columna D
    $activeWorksheet->getColumnDimension('D')->setWidth(11.29);
    //Anchura para la columna E
    $activeWorksheet->getColumnDimension('E')->setWidth(9.86);
    //Anchura para la columna F
    $activeWorksheet->getColumnDimension('F')->setWidth(9.86);
    //Anchura para la columna G
    $activeWorksheet->getColumnDimension('G')->setWidth(13.57);
    //Anchura para la columna A
    $activeWorksheet->getColumnDimension('H')->setWidth(14);
    //Anchura para la columna B
    $activeWorksheet->getColumnDimension('I')->setWidth(9.71);
    //Anchura para la columna C
    $activeWorksheet->getColumnDimension('J')->setWidth(16.29);
    //Anchura para la columna D
    $activeWorksheet->getColumnDimension('K')->setWidth(15.14);
    //Anchura para la columna E
    $activeWorksheet->getColumnDimension('L')->setWidth(18);
    //Anchura para la columna F
    $activeWorksheet->getColumnDimension('M')->setWidth(14.43);

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
    //Todos los bordes para la celda cabecera A2
    $activeWorksheet->getStyle('H2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('H2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera B2
    $activeWorksheet->getStyle('I2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera C2
    $activeWorksheet->getStyle('J2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('J2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('J2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('J2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera D2
    $activeWorksheet->getStyle('K2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('K2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('K2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('K2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera E2
    $activeWorksheet->getStyle('L2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('L2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('L2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('L2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera E2
    $activeWorksheet->getStyle('M2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('M2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('M2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('M2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('A1:M1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('A1:M1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('A2:I2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
    $activeWorksheet->getStyle('I2:M2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00B0F0');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('A2:M2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);
    
    foreach ($tarifas as $tarifa) {
        $tarifa_reducida = $tarifa['tarifa_reducida'];
        $tarifa_maxima = $tarifa['tarifa_maxima'];
        $tarifa_adicional = $tarifa['tarifa_adicional'];
        $tarifa_exceso_7_dias = $tarifa['tarifa_exceso_7_dias'];
    }

    //Texto para encabezado A1
    $activeWorksheet->setCellValue('A2', 'Nº CONTENEDOR');
    //Texto para encabezado B1
    $activeWorksheet->setCellValue('B2', 'TAMAÑO');
    //Texto para encabezado C1
    $activeWorksheet->setCellValue('C2', 'FECHA ENTRADA');
    //Texto para encabezado D1
    $activeWorksheet->setCellValue('D2', 'TIPO ENTRADA');
    //Texto para encabezado E1
    $activeWorksheet->setCellValue('E2', 'FECHA SALIDA');
    //Texto para encabezado F1
    $activeWorksheet->setCellValue('F2', 'TIPO SALIDA');
    //Texto para encabezado G1
    $activeWorksheet->setCellValue('G2', 'FECHA INICIO FACTURACION');
    //Texto para encabezado A1
    $activeWorksheet->setCellValue('H2', 'FECHA FIN FACTURACION');
    //Texto para encabezado F1
    $activeWorksheet->setCellValue('I2', 'DÍAS ESTANCIA');
    foreach ($tarifas as $tarifa) {
        //Texto para encabezado B1
        $activeWorksheet->setCellValue('J2', 'TARIFA REDUCIDA (0 - 2 DÍAS) ('.$tarifa_reducida.' €/UTI)');
        //Texto para encabezado C1
        $activeWorksheet->setCellValue('K2', 'TARIFA MÁXIMA (HASTA 7 DÍAS) ('.$tarifa_maxima.' €/UTI)');
        //Texto para encabezado D1
        $activeWorksheet->setCellValue('L2', 'MANIPULACIÓN ADICIONAL (MÁS DE 7 DÍAS) ('.$tarifa_adicional.' €/UTI)');
        //Texto para encabezado E1
        $activeWorksheet->setCellValue('M2', 'EXCESO 7 DIAS TRANSITO ('.$tarifa_exceso_7_dias.' €/UTI/DÍA)');
    }

    //Ajustar texto para encabezado A1
    $activeWorksheet->getStyle('A2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado B1
    $activeWorksheet->getStyle('B2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado C1
    $activeWorksheet->getStyle('C2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado D1
    $activeWorksheet->getStyle('D2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado E1
    $activeWorksheet->getStyle('E2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado F1
    $activeWorksheet->getStyle('F2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado G1
    $activeWorksheet->getStyle('G2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado A1
    $activeWorksheet->getStyle('H2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado B1
    $activeWorksheet->getStyle('I2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado C1
    $activeWorksheet->getStyle('J2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado D1
    $activeWorksheet->getStyle('K2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado E1
    $activeWorksheet->getStyle('L2')->getAlignment()->setWrapText(true);
    //Ajustar texto para encabezado F1
    $activeWorksheet->getStyle('M2')->getAlignment()->setWrapText(true);

    //Columna B en formato numero
    $activeWorksheet->getStyle('B')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna C en formato numero
    $activeWorksheet->getStyle('C')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
    //Columna E en formato fecha
    $activeWorksheet->getStyle('D')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna E en formato numero
    $activeWorksheet->getStyle('E')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
    //Columna F en formato fecha
    $activeWorksheet->getStyle('F')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    $activeWorksheet->getStyle('G')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
    $activeWorksheet->getStyle('H')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
    $activeWorksheet->getStyle('I')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
    //Columna G en formato fecha
    $activeWorksheet->getStyle('J')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
    $activeWorksheet->getStyle('K')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
    $activeWorksheet->getStyle('L')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
    $activeWorksheet->getStyle('M')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);
    //$activeWorksheet->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00 €');

    //Desfase para fila de cabeceras
    $indice = 3;
    foreach ($manipulacion_uti_list as $manipulacion_uti_line) {
        //Valor para celda A.$indice
        $activeWorksheet->setCellValue('A' . $indice, $manipulacion_uti_line['num_contenedor']);
        //Valor para celda B.$indice
        $activeWorksheet->setCellValue('B' . $indice, $manipulacion_uti_line['longitud_tipo_contenedor']);
        //Valor para celda C.$indice
        $activeWorksheet->setCellValue('C' . $indice, $manipulacion_uti_line['fecha_entrada']);
        //Valor para celda D.$indice
        $activeWorksheet->setCellValue('D' . $indice, $manipulacion_uti_line['tipo_entrada']);
        //Valor para celda E.$indice
        $activeWorksheet->setCellValue('E' . $indice, $manipulacion_uti_line['fecha_salida']);
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('F' . $indice, $manipulacion_uti_line['tipo_salida']);
        //Valor para celda G.$indice
        $activeWorksheet->setCellValue('G' . $indice, $manipulacion_uti_line['fecha_inicio_facturacion']);
        //Valor para celda A.$indice
        $activeWorksheet->setCellValue('H' . $indice, $manipulacion_uti_line['fecha_fin_facturacion']);
        //Valor para celda B.$indice
        $activeWorksheet->setCellValue('I' . $indice, $manipulacion_uti_line['total_dias']);
        //Valor para celda C.$indice
        $activeWorksheet->setCellValue('J' . $indice, $manipulacion_uti_line['importe_reducida']);
        //Valor para celda D.$indice
        $activeWorksheet->setCellValue('K' . $indice, $manipulacion_uti_line['importe_maxima']);
        //Valor para celda E.$indice
        $activeWorksheet->setCellValue('L' . $indice, $manipulacion_uti_line['importe_adicional']);
        //Valor para celda F.$indice
        $activeWorksheet->setCellValue('M' . $indice, $manipulacion_uti_line['importe_exceso_7_dias']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda B.$indice
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda C.$indice
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda D.$indice
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('F' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('G' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('G' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('G' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('G' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('H' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('H' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('H' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('H' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda B.$indice
        $activeWorksheet->getStyle('I' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('I' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('I' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('I' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda C.$indice
        $activeWorksheet->getStyle('J' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('J' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('J' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('J' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda D.$indice
        $activeWorksheet->getStyle('K' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('K' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('K' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('K' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('L' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('L' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('L' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('L' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('M' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('M' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('M' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('M' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('B' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('C' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('D' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('E' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('F' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('G' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('H' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('I' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('J' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('K' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('L' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('M' . $indice)->getAlignment()->setHorizontal('center');

        $indice = $indice + 1;
    }

    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('A' . $indice . ':I' . $indice . '');
    //Texto para encabezado A.indice
    $activeWorksheet->setCellValue('A' . $indice, 'SUBTOTAL ');
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setHorizontal('right');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getFont()->setBold(true);
    //Todos los bordes para la celda cabecera A a F
    $activeWorksheet->getStyle('A' . $indice . ':I' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':I' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':I' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':I' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera A a F
    $activeWorksheet->getStyle('I' . $indice . ':J' . $indice . ':K' . $indice . ':L' . $indice . ':M' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I' . $indice . ':J' . $indice . ':K' . $indice . ':L' . $indice . ':M' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I' . $indice . ':J' . $indice . ':K' . $indice . ':L' . $indice . ':M' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('I' . $indice . ':J' . $indice . ':K' . $indice . ':L' . $indice . ':M' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('A' . $indice)->getFont()->setSize(10);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('G' . $indice)->getFont()->setSize(10);

    foreach ($manipulacion_uti_list as $manipulacion_uti_line) {
        //Valor para celda G.$indice
        $activeWorksheet->setCellValue('J' . $indice, $manipulacion_uti_line['total_importe_reducida']);
        $activeWorksheet->setCellValue('K' . $indice, $manipulacion_uti_line['total_importe_maxima']);
        $activeWorksheet->setCellValue('L' . $indice, $manipulacion_uti_line['total_importe_adicional']);
        $activeWorksheet->setCellValue('M' . $indice, $manipulacion_uti_line['total_importe_exceso_7_dias']);

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('J' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('J' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('J' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('J' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('J' . $indice)->getAlignment()->setHorizontal('center');

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('K' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('K' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('K' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('K' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('K' . $indice)->getAlignment()->setHorizontal('center');

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('L' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('L' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('L' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('L' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('L' . $indice)->getAlignment()->setHorizontal('center');

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('M' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('M' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('M' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('M' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Alineación horizontal para las celdas de cabecera
        $activeWorksheet->getStyle('M' . $indice)->getAlignment()->setHorizontal('center');
    }
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('J' . $indice)->getAlignment()->setHorizontal('center');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('J' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('J' . $indice)->getFont()->setBold(true);
    //Columna F en formato numero
    $activeWorksheet->getStyle('J' . $indice)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('K' . $indice)->getAlignment()->setHorizontal('center');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('K' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('K' . $indice)->getFont()->setBold(true);
    //Columna F en formato numero
    $activeWorksheet->getStyle('K' . $indice)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('L' . $indice)->getAlignment()->setHorizontal('center');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('L' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('L' . $indice)->getFont()->setBold(true);
    //Columna F en formato numero
    $activeWorksheet->getStyle('L' . $indice)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('M' . $indice)->getAlignment()->setHorizontal('center');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('M' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('M' . $indice)->getFont()->setBold(true);
    //Columna F en formato numero
    $activeWorksheet->getStyle('M' . $indice)->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

    $indice = $indice + 1;
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('A' . $indice . ':I' . $indice . '');
    //Texto para encabezado A.indice
    $activeWorksheet->setCellValue('A' . $indice, 'TOTAL ');
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setHorizontal('right');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('A' . $indice)->getFont()->setBold(true);
    //Todos los bordes para la celda cabecera A a F
    $activeWorksheet->getStyle('A' . $indice . ':I' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':I' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':I' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A' . $indice . ':I' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('J' . $indice . ':M' . $indice . '');
    //Texto para encabezado A.indice
    $activeWorksheet->setCellValue('J' . $indice, $manipulacion_uti_line['total']);
    //Todos los bordes para la celda cabecera A a F
    $activeWorksheet->getStyle('J' . $indice . ':M' . $indice . '')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('J' . $indice . ':M' . $indice . '')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('J' . $indice . ':M' . $indice . '')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('J' . $indice . ':M' . $indice . '')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Ajustar texto para encabezado A
    $activeWorksheet->getStyle('A' . $indice . ':I' . $indice . '')->getAlignment()->setWrapText(true);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('A' . $indice . ':I' . $indice . '')->getFont()->setSize(10);
    // Set default font size to '1'
    $spreadsheet->getDefaultStyle('J' . $indice . ':M' . $indice . '')->getFont()->setSize(10);
    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('J' . $indice . ':M' . $indice . '')->getAlignment()->setHorizontal('center');
    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('J' . $indice . ':M' . $indice . '')->getAlignment()->setVertical('center');
    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('J' . $indice . ':M' . $indice . '')->getFont()->setBold(true);
    //Columna F en formato numero
    $activeWorksheet->getStyle('J' . $indice . ':M' . $indice . '')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

    $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($filename);
    header('Location: ' . $filename);
    echo "FACTURACION MANIPULACION UTI RENFE";
}

function excel_detalle_facturacion_maniobras_terminal_continental_rail($maniobra_continental_list, $fecha_inicio, $fecha_fin)
{
    echo "FACTURACION MANIOBRAS TERMINAL CONTINENTAL-RAIL";
}

function excel_detalle_facturacion_maniobras_generadores_gmf_railway($maniobra_gmf_railway_list, $fecha_inicio, $fecha_fin)
{
    echo "FACTURACION MANIOBRAS TERMINAL CONTINENTAL-RAIL";
}
