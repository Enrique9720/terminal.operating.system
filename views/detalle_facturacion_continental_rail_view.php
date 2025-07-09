<!DOCTYPE html>

<html lang="es">

<head>
    <title>Detalle Facturación <?php echo $nombre_comercial_cliente; ?></title>

    <?php
    //Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
    require_once('../tpl/header_includes.php');
    ?>

    <style>
        /*css para select2 y adaptarlos al footer de la tabla*/
        .select2-container--bootstrap .select2-selection {
            font-size: 12px;
        }

        .select2-container--bootstrap .select2-selection--single {
            height: 30px;
        }

        table {
            font-size: 11px;
        }
    </style>

    <!-- SCRIPT TABLA MANIOBRAS -->
    <script>
        //Inicializacion DATATABLES
        //Imagen para PDF Datatables
        var logo_grupo = "<?php //echo $dataUri = img2base64("../images/logo_ms_terminal.png.png"); 
                            ?>";

        //Fecha actual para mostrar en el pie del PDF
        var now = new Date();
        var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear();

        $(document).ready(function() {

            /////////////// FILTRADO DE REGISTROS DE TABLA POR TEXTO EN CADA COLUMNA
            // Setup - add a text input to each footer cell
            $('#tabla-maniobras-continental tfoot th').each(function(i) {
                var title = $('#tabla-maniobras-continental thead th').eq($(this).index()).text();

                switch (i) {
                    case 0: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:125px;"/>'); //nº contenedor
                        break;
                    case 1: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:150px;"/>'); //tamaño
                        break;
                    case 2: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:180px;"/>'); //fecha entrada
                        break;
                    case 3: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:325px;"/>'); //tipo entrada
                        break;
                    case 4: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:400px;"/>'); //fecha salida
                        break;
                    default:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:auto;"/>');
                }

            });
            /////////////// FILTRADO DE REGISTROS DE TABLA POR TEXTO EN CADA COLUMNA

            // INICIALIZACION DATATABLE
            table = $('#tabla-maniobras-continental').DataTable({
                //texto para traducir datatables a español
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Ver _MENU_ filas",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                //Habilitamos el scroll horizontal al haber muchas columnas
                scrollX: true,
                //Habilitamos el plugin para seleccion de filas
                select: true,
                //Definimos el numero de registros a mostrar por pagina y el desplegable
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "Todas"]
                ],
                "iDisplayLength": 10,
                //Mantenemos fija la primera columna que contiene la clave primaria de cada fila
                fixedColumns: true,
                //ordenamos por fecha_creacion (columna nº0)
                order: [
                    //[0, "desc"]
                ],
                //Establecemos como queremos que sea el DOM de los elementos que rodean a la tabla
                "dom": "<'row'<'col-sm-2'l><'col-sm-5 text-center'B><'col-sm-5'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                //Definimos que botones van a estar presentes
                buttons: [{ //COLVIS, filtrado de columnas
                        extend: 'colvis',
                        text: '<i class="fa fa-filter"></i> Filtrar',
                        className: 'btn btn-default',
                        //ocultamos las columnas con th de la clase novs (fecha crecion en este ejemplo)
                        columns: ':not(.noVis)'
                    },
                    { //EXPORTACION a EXCEL
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-file-excel-o"></i> a Excel',
                        className: 'btn btn-default',
                        exportOptions: {
                            modifier: {
                                page: 'all'
                            },
                            columns: ':visible:not(.not-export-col)'
                        },
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row c', sheet).attr('s', '25');
                        }
                    },

                    { //EXPORTACION a PDF
                        extend: 'pdfHtml5',
                        text: '<i class="fa fa-file-pdf-o"></i> a PDF',
                        className: 'btn btn-default',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        filename: 'listado_' + jsDate.toString(),
                        download: 'download',

                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        },

                        customize: function(doc) {
                            //titulo para el pdf
                            var titulo_pdf = doc.content[0].text;
                            //remove title of page
                            doc.content.splice(0, 1);
                            doc.pageMargins = [25, 45, 25, 20]; //margin-left, margin-top, margin-right, margin-bottom
                            //doc.pageMargins = [20,60,20,30];
                            doc.defaultStyle.fontSize = 7;
                            doc.styles.tableHeader.fontSize = 7;
                            doc.styles.title.fontSize = 11;

                            //create header
                            doc['header'] = (function() {
                                return {
                                    columns: [{
                                            image: logo_grupo,
                                            margin: [0, 0, 0, 0],
                                            height: 28,
                                            width: 70
                                        },
                                        {
                                            alignment: 'center',
                                            margin: [-20, 5, 0, 0],
                                            fontSize: 13,
                                            //text: 'Custom PDF export with dataTables'
                                            text: titulo_pdf
                                        }
                                    ],
                                    margin: [25, 10]
                                }
                            });

                            // Create a footer
                            doc['footer'] = (function(page, pages) {
                                return {
                                    columns: [{
                                            alignment: 'left',
                                            text: ['Informe generado el ', {
                                                text: jsDate.toString()
                                            }]
                                        },
                                        {
                                            // This is the right column
                                            alignment: 'right',
                                            text: ['Página ', {
                                                text: page.toString()
                                            }, ' de ', {
                                                text: pages.toString()
                                            }]
                                        }
                                    ],
                                    margin: [25, 0]
                                }
                            });

                            // Styling the table: create style object
                            var objLayout = {};
                            // Horizontal line thickness
                            objLayout['hLineWidth'] = function(i) {
                                return .5;
                            };
                            // Vertikal line thickness
                            objLayout['vLineWidth'] = function(i) {
                                return .5;
                            };
                            // Horizontal line color
                            objLayout['hLineColor'] = function(i) {
                                return '#aaa';
                            };
                            // Vertical line color
                            objLayout['vLineColor'] = function(i) {
                                return '#aaa';
                            };
                            // Left padding of the cell
                            objLayout['paddingLeft'] = function(i) {
                                return 4;
                            };
                            // Right padding of the cell
                            objLayout['paddingRight'] = function(i) {
                                return 4;
                            };
                            // Inject the object in the document
                            doc.content[0].layout = objLayout;

                        }

                    }

                ]

            });

            // APLICAMOS EL FILTRADO DE COLUMNAS EN CADA INPUT
            table.columns().every(function() {
                var that = this;

                $('input', this.footer()).on('keyup change', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });


            //Seleccion de filas
            $('tabla-maniobras-continental tbody').on('click', 'tr', function() {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    table.$('tr.active').removeClass('active');
                    $(this).addClass('active');
                }
            });


            //al pasar el cursor por una fila de la tabla hacemos el hover tambien sobre la fila de la fixed column
            $("#tabla-maniobras-continental").on("mouseenter", "tbody tr", function() {
                //stuff to do on mouse enter
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //añadimos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-maniobras-continental tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").addClass('hover');

            });

            //al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
            $("#tabla-maniobras-continental").on("mouseleave", "tbody tr", function() {
                //stuff to do on mouse leave
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //quitamos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-maniobras-continental tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
            });


            //al pasar el cursor por una fila de la fixed columns hacemos el hover tambien sobre la fila de la tabla
            $(".DTFC_Cloned").on("mouseenter", "tbody tr", function() {
                //stuff to do on mouse enter
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //añadimos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-maniobras-continental tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
            });

            //al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
            $(".DTFC_Cloned").on("mouseleave", "tbody tr", function() {
                //stuff to do on mouse leave
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //quitamos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-maniobras-continental tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
            });

        });
    </script>
    <!-- FIN SCRIPT TABLA MANIOBRAS -->

    <style>
        .select2-container {
            width: 100% !important;
        }

        table {
            font-size: 12px;
        }

        .table>tbody>tr.active>td {
            background-color: #337ab7;
            color: #eeeeee !important;

        }

        .table-hover>tbody>tr:hover>td,
        .table-hover>tbody>tr:hover>th {
            background-color: #C4D6E4;
            color: black;
        }

        .table-hover>tbody>tr.active:hover>td {
            background-color: #337ab7;
            color: #eeeeee !important;
        }

        /*Cambiamos el color de fondo de la fila fija para las filas impares*/
        .DTFC_Cloned>tbody>tr:nth-of-type(odd) {
            background-color: #eeeeee;
        }

        /*Cambiamos el color de fondo de la fila fija para las filas impares*/
        .DTFC_Cloned>tbody>tr:nth-of-type(even) {
            background-color: #FFFFFF;
        }

        /*Ocultamos el input de filtrado de la fixed column de datatables*/
        .DTFC_LeftFootWrapper {
            display: none;
        }

        /*Ocultamos la info de "fila seleccionada" del plugin selectrow de datatables*/
        .select-info {
            display: none;
        }

        /*al seleccionar fila con plugin select, cambiomos el color de los iconos*/
        table.dataTable tbody tr.selected a,
        table.dataTable tbody th.selected a,
        table.dataTable tbody td.selected a {
            color: #fff;
        }

        table.dataTable tbody tr.selected a.btn-default,
        table.dataTable tbody th.selected a.btn-default,
        table.dataTable tbody td.selected a.btn-default {
            color: #333;
        }

        /*Clase para cuando hacemos hover sobre filas de la tabla*/
        .hover {
            background-color: #C4D6E4 !important;
            color: black !important;
        }
    </style>

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        function guardartotales() {

            jQuery.ajax({
                method: 'POST',
                url: '../ajax/guardar_en_bbdd.php',
                data: {
                    year: <?php echo isset($year) ? $year : 0; ?>,
                    month: <?php echo isset($month) ? $month : 0; ?>,
                    importe_manipulacion_utis: <?php echo isset($total_importe_manipulacion_utis) ? $total_importe_manipulacion_utis : 0; ?>,
                    importe_almacenaje: <?php echo isset($total_importe_almacenaje) ? $total_importe_almacenaje : 0; ?>,
                    importe_conexionado_electrico: <?php echo isset($total_importe_conexion) ? $total_importe_conexion : 0; ?>,
                    importe_control_temperatura: <?php echo isset($total_importe_control_temperatura) ? $total_importe_control_temperatura : 0; ?>,
                    importe_limpieza: <?php echo isset($total_importe_limpieza) ? $total_importe_limpieza : 0; ?>,
                    importe_horas_extras: <?php echo isset($total_importe_horas_extras) ? $total_importe_horas_extras : 0; ?>,
                    importe_maniobra_terminal: <?php echo isset($total_importe_maniobra_terminal) ? $total_importe_maniobra_terminal : 0; ?>,
                    importe_maniobra_generadores: <?php echo isset($total_importe_maniobra_generadores) ? $total_importe_maniobra_generadores : 0; ?>,
                    importe_servicios_especiales: <?php echo isset($total_importe_servicios_especiales) ? $total_importe_servicios_especiales : 0; ?>,
                    id_cliente: <?php echo isset($id_cliente) ? $id_cliente : 0; ?>
                }
            }).done(function(response) { // after the request has been loaded...
                console.log(response);
                var jsonResponse = JSON.parse(response);
                if (jsonResponse.success) {
                    toastr.success(jsonResponse.message);
                } else {
                    toastr.error(jsonResponse.message);
                }
            }).fail(function() {
                toastr.error('Error. Datos NO insertados en BBDD.');
            });
        }

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-bottom-left",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    </script>

    <style>
        .btn-shadow {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Sombra elegante */
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            /* Animación para una transición suave */
            border-radius: 5px;
            /* Bordes redondeados */
        }

        .btn-shadow:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            /* Aumenta la sombra al pasar el ratón */
            transform: translateY(-2px);
            /* Levanta el botón visualmente */
            /*background-color: #0056b3;*/
            /* Cambia el color de fondo al pasar el ratón */
        }

        .btn-shadow:active {
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
            /* Disminuye la sombra al presionar */
            transform: translateY(1px);
            /* Simula un efecto de "click" */
        }

        .well-sm {
            background-color: #f7f7f7;
            /* Color de fondo del contenedor */
            border: 1px solid #ddd;
            /* Borde alrededor del contenedor */
            padding: 15px;
            /* Espaciado interior del contenedor */
        }
    </style>

</head>

<body>

    <div id="wrapper">
        <!-- Top Menu and Sidebar -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <?php
            //Plantilla con el menu del header
            require_once("../tpl/header_menu.php");

            //Plantilla con el aside usado SOLO POR ESTA APP
            require_once("../tpl/aside.php");
            ?>
        </nav>

        <div class="container-fluid" id="page-wrapper">
            <h3>Facturación <?php echo $nombre_comercial_cliente;
                            echo ' ';
                            echo $year;
                            echo '-';
                            echo $month; ?></h3>
            <?php
            foreach ($tarifas as $tarifa) {
                // Accedemos a cada atributo por su clave
                $id_tarifa = $tarifa['id_tarifa'];
                $year = $tarifa['year'];
                $cif_cliente = $tarifa['cif_cliente'];
                $tarifa_manipulacion_uti = $tarifa['tarifa_manipulacion_uti'];
                $tarifa_manipulacion_uti_traspaso = $tarifa['tarifa_manipulacion_uti_traspaso'];
                $tarifa_almacenaje_20 = $tarifa['tarifa_almacenaje_20'];
                $unidades_libres_20 = $tarifa['unidades_libres_20'];
                $tarifa_almacenaje_40 = $tarifa['tarifa_almacenaje_40'];
                $unidades_libres_40 = $tarifa['unidades_libres_40'];
                $tarifa_almacenaje_45 = $tarifa['tarifa_almacenaje_45'];
                $unidades_libres_45 = $tarifa['unidades_libres_45'];
                $tarifa_temperatura = $tarifa['tarifa_temperatura'];
                $tarifa_conexion = $tarifa['tarifa_conexion'];
                $tarifa_limpieza = $tarifa['tarifa_limpieza'];
                $tarifa_hora_extraordinaria = $tarifa['tarifa_hora_extraordinaria'];
                $tarifa_reducida = $tarifa['tarifa_reducida'];
                $tarifa_maxima = $tarifa['tarifa_maxima'];
                $tarifa_adicional = $tarifa['tarifa_adicional'];
                $tarifa_exceso_7_dias = $tarifa['tarifa_exceso_7_dias'];
                $tarifa_maniobra_terminal = $tarifa['tarifa_maniobra_terminal'];
                $tarifa_maniobra_cambio_generadores = $tarifa['tarifa_maniobra_cambio_generadores'];
                $id_cliente = $tarifa['id_cliente'];
                $nombre_cliente = $tarifa['nombre_cliente'];
                $nombre_comercial_cliente = $tarifa['nombre_comercial_cliente'];
                $direccion_cliente = $tarifa['direccion_cliente'];
                $persona_contacto = $tarifa['persona_contacto'];
                $email_contacto = $tarifa['email_contacto'];
            }
            ?>
            <div class="row" style="margin:0">
                <h3>MANIOBRAS TERMINAL</h3>
                <div class="well well-sm">
                    <!-- href="../controllers/excel_detalle_facturacion_cliente_controller.php?cliente=CONTINENTAL-RAIL&fecha_inicio=<?php echo $fecha_inicio; ?>&fecha_fin=<?php echo $fecha_fin; ?>&tipo_facturacion=maniobra_terminal" -->
                    <a type="button" id="" class="btn btn-success" title="excel" disabled><i class="far fa-file-excel" aria-hidden="true"></i> MANIOBRAS TERMINAL CONTINENTAL-RAIL </a>
                    <a class="btn btn-default" onclick=""><i class="glyphicon glyphicon-euro"></i> <strong>Importe Maniobra Terminal: <i><?php echo $total_importe_maniobra_terminal . ' €'; ?></strong></i></a>
                    <a class="btn btn-default" onclick=""><i class="glyphicon glyphicon-euro"></i> <strong>Importe Maniobra Cambio Generadores: <i><?php echo $total_importe_maniobra_generadores . ' €'; ?></strong></i></a>
                </div>
                <table id="tabla-maniobras-continental" class="table table-bordered table-striped dataTable table-hover">
                    <thead>
                        <tr>
                            <th>FECHA TREN</th>
                            <th>TIPO MOVIMIENTO</th>
                            <th>ORIGEN / DESTINO</th>
                            <th>IMPORTE MANIOBRA TERMINAL (<?= $tarifa_maniobra_terminal ?> €/MANIOBRA)</th>
                            <th>IMPORTE MANIOBRA CAMBIO VIA GENEREADORES (<?= $tarifa_maniobra_cambio_generadores ?> €/TREN)</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>FECHA TREN</th>
                            <th>TIPO MOVIMIENTO</th>
                            <th>ORIGEN / DESTINO</th>
                            <th>IMPORTE MANIOBRA TERMINAL (<?= $tarifa_maniobra_terminal ?> €/MANIOBRA)</th>
                            <th>IMPORTE MANIOBRA CAMBIO VIA GENEREADORES (<?= $tarifa_maniobra_cambio_generadores ?> €/TREN)</th>
                        </tr>
                    </tfoot>

                    <tbody>
                        <?php foreach ($maniobra_continental_list as $maniobra_continental_line) { ?>
                            <tr>
                                <td><?php echo $maniobra_continental_line['fecha_tren']; ?></td>
                                <td><?php echo $maniobra_continental_line['tipo_movimiento']; ?></td>
                                <td><?php echo $maniobra_continental_line['nombre_origen'] . " / " . $maniobra_continental_line['nombre_destino']; ?></td>
                                <td><?php echo $maniobra_continental_line['importe_maniobra_terminal']; ?></td>
                                <td><?php echo $maniobra_continental_line['importe_maniobra_cambio_generadores']; ?></td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="well well-sm">
                <center>
                    <button type="button" class="btn btn-warning btn-sm btn-shadow" onclick="guardartotales()" title="Guardar en BBDD" disabled>
                        <i class="fa fa-database"></i> Guardar en BBDD
                    </button>
                </center>
            </div>

        </div>
    </div>
</body>

</html>