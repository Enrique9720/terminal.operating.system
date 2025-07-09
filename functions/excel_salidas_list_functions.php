<?php
function excel_listado_salidas($salidas_list)
{
    //FORMATO CCIS-BILBAO SICSA-VALENCIA
    //generamos excel

    /*$fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
  $fecha_fin = date('Y-m-d', strtotime($fecha_fin));

  $nombre_comercial_propietario = 'CCIS-BILBAO_SICSA-VALENCIA';*/
    $filename = "../excel/listados/salidas/LISTADO SALIDAS.xlsx";
    $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
    $activeWorksheet = $spreadsheet->getActiveSheet();

    //Nombre de la hoja activa
    $activeWorksheet->setTitle("Salidas");

    //Texto para titulo A1
    $activeWorksheet->setCellValue('A1', 'LISTADO SALIDAS');
    //Alineación horizontal para la celda A1
    $activeWorksheet->getStyle('A1')->getAlignment()->setHorizontal('center');
    //Texto en negrita para la celda A1
    $activeWorksheet->getStyle('A1')->getFont()->setBold(true);
    //Combinamos celdas para titulo de la hoja
    $activeWorksheet->mergeCells('A1:G1');

    $activeWorksheet->mergeCells('F2:G2');

    $activeWorksheet->mergeCells('A2:A3');
    $activeWorksheet->mergeCells('B2:B3');
    $activeWorksheet->mergeCells('C2:C3');
    $activeWorksheet->mergeCells('D2:D3');
    $activeWorksheet->mergeCells('E2:E3');

    //Alineación horizontal para las celdas de cabecera
    $activeWorksheet->getStyle('A2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('B2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('C2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('D2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('E2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('F2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('G2')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('F3')->getAlignment()->setHorizontal('center');
    $activeWorksheet->getStyle('G3')->getAlignment()->setHorizontal('center');

    //Alineación vertical para las celdas de cabecera
    $activeWorksheet->getStyle('A2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('B2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('C2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('D2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('E2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('F2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('G2')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('F3')->getAlignment()->setVertical('center');
    $activeWorksheet->getStyle('G3')->getAlignment()->setVertical('center');

    //Texto en negrita para las celdas de cabecera
    $activeWorksheet->getStyle('A2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('B2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('C2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('D2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('E2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('F2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('G2')->getFont()->setBold(true);
    $activeWorksheet->getStyle('F3')->getFont()->setBold(true);
    $activeWorksheet->getStyle('G3')->getFont()->setBold(true);

    //Altura de las celdas de cabecera
    $activeWorksheet->getRowDimension('2')->setRowHeight(30);

    //Anchura para la columna A
    $activeWorksheet->getColumnDimension('A')->setWidth(18);
    //Anchura para la columna B
    $activeWorksheet->getColumnDimension('B')->setWidth(20);
    //Anchura para la columna C
    $activeWorksheet->getColumnDimension('C')->setWidth(18);
    //Anchura para la columna C
    $activeWorksheet->getColumnDimension('D')->setWidth(30);
    //Anchura para la columna D
    $activeWorksheet->getColumnDimension('E')->setWidth(22);
    //Anchura para la columna E
    $activeWorksheet->getColumnDimension('F')->setWidth(26);

    //Todos los bordes para la celda cabecera A2
    $activeWorksheet->getStyle('A2:A3')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A2:A3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A2:A3')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('A2:A3')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera B2
    $activeWorksheet->getStyle('B2:B3')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('B2:B3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('B2:B3')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('B2:B3')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera C2
    $activeWorksheet->getStyle('C2:C3')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('C2:C3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('C2:C3')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('C2:C3')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera D2
    $activeWorksheet->getStyle('D2:D3')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('D2:D3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('D2:D3')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('D2:D3')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera E2
    $activeWorksheet->getStyle('E2:E3')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E2:E3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E2:E3')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('E2:E3')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera E2
    $activeWorksheet->getStyle('F2:G2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F2:G2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F2:G2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F2:G2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera E2
    $activeWorksheet->getStyle('F3')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F3')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('F3')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    //Todos los bordes para la celda cabecera E2
    $activeWorksheet->getStyle('G3')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G3')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G3')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
    $activeWorksheet->getStyle('G3')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

    //Color de fondo para encabezado
    $activeWorksheet->getStyle('A2:F2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000');
    $activeWorksheet->getStyle('F3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000');
    $activeWorksheet->getStyle('G3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF0000');

    //Texto para encabezado A2
    $activeWorksheet->setCellValue('A2', 'Nº EXPEDICION');
    //Texto para encabezado B2
    $activeWorksheet->setCellValue('B2', 'FECHA SALIDA');
    //Texto para encabezado C2
    $activeWorksheet->setCellValue('C2', 'TIPO');
    //Texto para encabezado D2
    $activeWorksheet->setCellValue('D2', 'PROPIETARIO');
    //Texto para encabezado C2
    $activeWorksheet->setCellValue('E2', 'Nº CONTENEDORES');
    //Texto para encabezado E2
    $activeWorksheet->setCellValue('F2', 'CONTENEDORES');
    //Texto para encabezado E2
    $activeWorksheet->setCellValue('F3', 'Nº CONTENEDOR');
    //Texto para encabezado E2
    $activeWorksheet->setCellValue('G3', 'TIPO');

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
    $activeWorksheet->getStyle('F3')->getAlignment()->setWrapText(true);
    $activeWorksheet->getStyle('G3')->getAlignment()->setWrapText(true);

    /*//Columna C en formato fecha
  $activeWorksheet->getStyle('G')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
  //Columna D en formato numero
  $activeWorksheet->getStyle('H')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
  //Columna C en formato fecha
  $activeWorksheet->getStyle('F')->getNumberFormat()->setFormatCode(PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);*/

    //Desfase para fila de cabeceras
    $indice = 4;
    foreach ($salidas_list as $key => $salidas_line) {
        $indice_inicial = $indice;
        //Valor para celda A.$indice
        $activeWorksheet->setCellValue('A' . $indice, $salidas_line['num_expedicion']);
        //Valor para celda B.$indice
        $activeWorksheet->setCellValue('B' . $indice, $salidas_line['fecha_salida']);
        //Valor para celda C.$indice
        $activeWorksheet->setCellValue('C' . $indice, $salidas_line['tipo_salida']);
        //Valor para celda D.$indice
        $activeWorksheet->setCellValue('D' . $indice, $salidas_line['nombre_comercial_propietario']);
        //Valor para celda D.$indice
        $activeWorksheet->setCellValue('E' . $indice, $salidas_line['contenedores'][0]['total_contenedores']);

        foreach ($salidas_line['contenedores'] as $key => $contenedor) {

            $activeWorksheet->setCellValue('F' . $indice, $contenedor['num_contenedor']);
            $activeWorksheet->setCellValue('G' . $indice, $contenedor['id_tipo_contenedor_iso']);

            //Todos los bordes para la celda cabecera E2
            $activeWorksheet->getStyle('F' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $activeWorksheet->getStyle('F' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $activeWorksheet->getStyle('F' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $activeWorksheet->getStyle('F' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            //Todos los bordes para la celda cabecera E2
            $activeWorksheet->getStyle('G' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $activeWorksheet->getStyle('G' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $activeWorksheet->getStyle('G' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $activeWorksheet->getStyle('G' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

            $activeWorksheet->getStyle('F' . $indice)->getAlignment()->setHorizontal('center');
            $activeWorksheet->getStyle('F' . $indice)->getAlignment()->setVertical('center');

            $activeWorksheet->getStyle('G' . $indice)->getAlignment()->setHorizontal('center');
            $activeWorksheet->getStyle('G' . $indice)->getAlignment()->setVertical('center');

            $indice++;
        }

        $indice--;

        $activeWorksheet->mergeCells('A' . $indice_inicial . ':A' . $indice);
        $activeWorksheet->mergeCells('B' . $indice_inicial . ':B' . $indice);
        $activeWorksheet->mergeCells('C' . $indice_inicial . ':C' . $indice);
        $activeWorksheet->mergeCells('D' . $indice_inicial . ':D' . $indice);
        $activeWorksheet->mergeCells('E' . $indice_inicial . ':E' . $indice);


        $activeWorksheet->getStyle('A' . $indice_inicial . ':A' . $indice)->getAlignment()->setHorizontal('left');
        $activeWorksheet->getStyle('A' . $indice_inicial . ':A' . $indice)->getAlignment()->setVertical('center');

        $activeWorksheet->getStyle('B' . $indice_inicial . ':B' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('B' . $indice_inicial . ':B' . $indice)->getAlignment()->setVertical('center');

        $activeWorksheet->getStyle('C' . $indice_inicial . ':C' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('C' . $indice_inicial . ':C' . $indice)->getAlignment()->setVertical('center');

        $activeWorksheet->getStyle('D' . $indice_inicial . ':D' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('D' . $indice_inicial . ':D' . $indice)->getAlignment()->setVertical('center');

        $activeWorksheet->getStyle('E' . $indice_inicial . ':E' . $indice)->getAlignment()->setHorizontal('center');
        $activeWorksheet->getStyle('E' . $indice_inicial . ':E' . $indice)->getAlignment()->setVertical('center');

        //Todos los bordes para la celda A.$indice
        $activeWorksheet->getStyle('A' . $indice_inicial . ':A' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice_inicial . ':A' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice_inicial . ':A' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('A' . $indice_inicial . ':A' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda B.$indice
        $activeWorksheet->getStyle('B' . $indice_inicial . ':B' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice_inicial . ':B' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice_inicial . ':B' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('B' . $indice_inicial . ':B' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda C.$indice
        $activeWorksheet->getStyle('C' . $indice_inicial . ':C' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice_inicial . ':C' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice_inicial . ':C' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('C' . $indice_inicial . ':C' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda D.$indice
        $activeWorksheet->getStyle('D' . $indice_inicial . ':D' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice_inicial . ':D' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice_inicial . ':D' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('D' . $indice_inicial . ':D' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        //Todos los bordes para la celda E.$indice
        $activeWorksheet->getStyle('E' . $indice_inicial . ':E' . $indice)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice_inicial . ':E' . $indice)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice_inicial . ':E' . $indice)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $activeWorksheet->getStyle('E' . $indice_inicial . ':E' . $indice)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $indice = $indice + 1;
        //$indice_inicial = $indice_inicial+1;
    }

    $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($filename);
    header('Location: ' . $filename);
    //unlink('hello world.xlsx');
}
