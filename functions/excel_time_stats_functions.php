<?php

///////////////////////////////// ISO 9001 //////////////////////////////////////////
function excel_iso_9001_marcadores_tiempo($time_stats_list)
{
    //FORMATO ISO 9001 MARCADORES DE TIEMPO

    //Generamos excel
    $filename = "../excel/9001_marcadores_tiempo/Marcadores_Tiempo_ISO_9001.xlsx";
    $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
    $activeWorksheet = $spreadsheet->getActiveSheet();

    //Nombre de la hoja activa
    $activeWorksheet->setTitle("Hoja1");

    //Texto para titulo A1
    $activeWorksheet->setCellValue('A1', 'ISO 9001 -> Marcadores de Tiempo');
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
    $activeWorksheet->getRowDimension('2')->setRowHeight(30);

    //Anchura para la columna A
    $activeWorksheet->getColumnDimension('A')->setWidth(9);
    //Anchura para la columna B
    $activeWorksheet->getColumnDimension('B')->setWidth(39);
    //Anchura para la columna C
    $activeWorksheet->getColumnDimension('C')->setWidth(24);
    //Anchura para la columna C
    $activeWorksheet->getColumnDimension('D')->setWidth(45);
    //Anchura para la columna D
    $activeWorksheet->getColumnDimension('E')->setWidth(32);
    //Anchura para la columna F
    $activeWorksheet->getColumnDimension('F')->setWidth(54);

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
    $activeWorksheet->getStyle('A2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFC000');
    $activeWorksheet->getStyle('B2:D2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('92D050');
    $activeWorksheet->getStyle('E2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('00B0F0');
    $activeWorksheet->getStyle('F2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF00');
    //Color de la fuente para encabezado
    $activeWorksheet->getStyle('A2:F2')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

    //Texto para encabezado A2
    $activeWorksheet->setCellValue('A2', 'PERIODO');
    //Texto para encabezado B2
    $activeWorksheet->setCellValue('B2', 'TIEMPO DE ESPERA EN COLA DE CAMIONES DESDE TTM HASTA TCI (MINUTOS)');
    //Texto para encabezado C2
    $activeWorksheet->setCellValue('C2', 'TIEMPO EN ACCESO DE LA TTM EN LA TCI (MINUTOS)');
    //Texto para encabezado D2
    $activeWorksheet->setCellValue('D2', 'TIEMPO MÁXIMO DE ESPERA DE CAMIÓN EN CONTROL DE ACCESO A LA TERMINAL (MINUTOS)');
    //Texto para encabezado C2
    $activeWorksheet->setCellValue('E2', 'TIEMPO MEDIO DE LA ESTANCIA DE UN CAMIÓN EN LA TCI (MINUTOS)');
    //Texto para encabezado F2
    $activeWorksheet->setCellValue('F2', 'TIEMPO MAXIMO DE TRATAMIENTO DE UN TREN DURANTE LA CARGA O DESCARGA DE CONTENEDORES (MINUTOS)');

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

    //Desfase para fila de cabeceras
    $indice = 3;
    foreach ($time_stats_list as $key => $time_stats_line) {
        //Valor para celda A.$indice
        $activeWorksheet->setCellValue('A' . $indice, $time_stats_line['year'] . ' - ' . $time_stats_line['month']);
        //Valor para celda B.$indice
        $activeWorksheet->setCellValue('B' . $indice, $time_stats_line['t_max_espera_camion_en_cola']);
        //Valor para celda C.$indice
        $activeWorksheet->setCellValue('C' . $indice, $time_stats_line['t_max_acceso_camion_ttm']);
        //Valor para celda D.$indice
        $activeWorksheet->setCellValue('D' . $indice, $time_stats_line['suma']);
        //Valor para celda D.$indice
        $activeWorksheet->setCellValue('E' . $indice, $time_stats_line['t_medio_camion_tci']);
        //Valor para celda D.$indice
        $activeWorksheet->setCellValue('F' . $indice, $time_stats_line['t_max_carga_descarga_tren']);

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

        $indice = $indice + 1;
    }

    $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($filename);
    header('Location: ' . $filename);
}
?>
