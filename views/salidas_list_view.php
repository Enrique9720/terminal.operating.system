<!DOCTYPE html>

<html lang="es">

<head>
    <title>Listado Salidas</title>

    <?php
    //Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
    require_once('../tpl/header_includes.php');
    ?>

    <script>
        //Inicializacion DATATABLES
        //Imagen para PDF Datatables
        var logo_grupo = "<?php //echo $dataUri = img2base64("../images/logogms2.png");
                            ?>";

        //Fecha actual para mostrar en el pie del PDF
        var now = new Date();
        var jsDate = now.getDate() + '-' + (now.getMonth() + 1) + '-' + now.getFullYear();

        $(document).ready(function() {

            /////////////// FILTRADO DE REGISTROS DE TABLA POR TEXTO EN CADA COLUMNA
            // Setup - add a text input to each footer cell
            $('#tabla tfoot th').each(function(i) {
                var title = $('#tabla thead th').eq($(this).index()).text();

                switch (i) {
                    case 0: //columna 0:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:110px;"/>');
                        break;
                    case 1: //columna 1:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:100px;"/>');
                        break;
                    case 2: //columna 2:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:120px;"/>');
                        break;
                    case 3: //columna 3:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:70px;"/>');
                        break;
                    case 4: //columna 4:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:200px;"/>');
                        break;
                    case 5: //columna 5:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:120px;"/>');
                        break;
                    case 6: //columna 5:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:120px;"/>');
                        break;
                    default:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:auto;"/>');;
                }

            });
            /////////////// FILTRADO DE REGISTROS DE TABLA POR TEXTO EN CADA COLUMNA

            // INICIALIZACION DATATABLE
            table = $('#tabla').DataTable({
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
                //fixedColumns: true,
                //ordenamos por fecha_creacion (columna nº0)
                order: [
                    [2, "desc"],
                    [0, "desc"]
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
                    /*{ //EXPORTACION a EXCEL
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
                    }*/
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

        });
    </script>

    <style>
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

        /* Cambiamos el color de fondo de la fila fija para las filas impares */
        .DTFC_Cloned>tbody>tr:nth-of-type(odd) {
            background-color: #eeeeee;
        }

        /* Cambiamos el color de fondo de la fila fija para las filas pares */
        .DTFC_Cloned>tbody>tr:nth-of-type(even) {
            background-color: #FFFFFF;
        }

        /* Ocultamos el input de filtrado de la fixed column de datatables */
        .DTFC_LeftFootWrapper {
            display: none;
        }

        /* Ocultamos la info de "fila seleccionada" del plugin selectrow de datatables */
        .select-info {
            display: none;
        }

        /* Cambiamos el color de los iconos al seleccionar fila con plugin select */
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

        /* Clase para hover sobre filas de la tabla */
        .hover {
            background-color: #C4D6E4 !important;
            color: black !important;
        }

        /* Eliminamos cualquier estilo que afecte a toda la tabla cuando se selecciona una fila */
        table.dataTable tbody tr.selected {
            background-color: #337ab7 !important;
            color: rgb(0, 0, 0) !important;
        }

        /* Garantizamos que el resto de la tabla no cambie de color */
        table.dataTable {
            background-color: inherit !important;
        }
    </style>



</head>

<body>

    <div id="wrapper">
        <!-- Top Menu and Sidebar -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <?php
            // Plantilla con el menu del header
            require_once("../tpl/header_menu.php");

            // Plantilla con el aside usado SOLO POR ESTA APP
            require_once("../tpl/aside.php");
            ?>
        </nav>

        <div class="container-fluid" id="page-wrapper">
            <div class="row h-100" style="margin:0">

                <h3>Listado Salidas Contenedores</h3>
                <div class="well well-sm">
                    <button class="btn btn-default" onclick="window.location.reload()">
                        <i class="glyphicon glyphicon-refresh"></i> Recargar
                    </button>
                    <a href="../controllers/excel_salidas_list_controller.php?year=<?php echo $year;?>" type="button" id="listado_salidas" class="btn btn-danger" title="excel"><i class="far fa-file-excel" aria-hidden="true"></i> EXCEL LISTADO SALIDAS</a>
                </div>

                <table id="tabla" class="table table-bordered dataTable table-hover">
                    <thead>
                        <tr>
                            <th class="danger">Nº Expedición</th>
                            <th class="noVis not-export-col danger">Operaciones</th>
                            <th class="danger">Fecha Salida</th>
                            <th class="danger">Tipo</th>
                            <th class="danger">Propietario</th>
                            <th class="danger">Nº Contenedores</th>
                            <th class="danger">Contenedores</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th class="danger">Nº Expedición</th>
                            <th class="noVis not-export-col danger">Operaciones</th>
                            <th class="danger">Fecha Salida</th>
                            <th class="danger">Tipo</th>
                            <th class="danger">Propietario</th>
                            <th class="danger">Nº Contenedores</th>
                            <th class="danger">Contenedores</th>
                        </tr>
                    </tfoot>

                    <tbody>
                        <?php foreach ($salidas_list as $salidas_line) { ?>
                            <tr id="<?php echo htmlspecialchars($salidas_line['id_salida'], ENT_QUOTES, 'UTF-8'); ?>">
                                <td><?php echo htmlspecialchars($salidas_line['num_expedicion'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <center>
                                        <div class="btn-group">
                                            <a target="_blank"
                                                href="../controllers/salida_resumen_controller.php?id_salida=<?php echo htmlspecialchars($salidas_line['id_salida'], ENT_QUOTES, 'UTF-8'); ?>"
                                                class="btn btn-sm btn-default"
                                                title="Ver">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                            </a>
                                        </div>
                                    </center>
                                </td>
                                <td><?php echo htmlspecialchars($salidas_line['fecha_salida'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($salidas_line['tipo_salida'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($salidas_line['nombre_comercial_propietario'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($salidas_line['contenedores'][0]['total_contenedores'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <table class="table table-bordered">
                                        <?php if (in_array($salidas_line['tipo_salida'], ['TREN', 'CAMIÓN', 'TRASPASO'])) { ?>
                                            <thead>
                                                <tr>
                                                    <th>Nº Contenedor</th>
                                                    <th>Tipo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($salidas_line['contenedores'] as $contenedor) { ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($contenedor['num_contenedor'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                        <td><?php echo htmlspecialchars($contenedor['id_tipo_contenedor_iso'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        <?php } ?>
                                    </table>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>


</html>