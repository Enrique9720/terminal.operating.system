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

    <!-- SCRIPT TABLA MANIPULACION UTI -->
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
            $('#tabla-manipulacion-uti-bilbao tfoot th').each(function(i) {
                var title = $('#tabla-manipulacion-uti-bilbao thead th').eq($(this).index()).text();

                switch (i) {
                    case 0: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:125px;"/>'); //nº contenedor
                        break;
                    case 1: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:100px;"/>'); //tamaño
                        break;
                    case 2: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:125px;"/>'); //fecha entrada
                        break;
                    case 3: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:125px;"/>'); //tipo entrada
                        break;
                    case 4: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:125px;"/>'); //fecha salida
                        break;
                    case 5: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:100px;"/>'); //tipo salida
                        break;
                    case 6: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:255px;"/>'); //importe total
                        break;
                    default:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:auto;"/>');
                }

            });
            /////////////// FILTRADO DE REGISTROS DE TABLA POR TEXTO EN CADA COLUMNA

            // INICIALIZACION DATATABLE
            table = $('#tabla-manipulacion-uti-bilbao').DataTable({
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
            $('#tabla-manipulacion-uti-bilbao tbody').on('click', 'tr', function() {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    table.$('tr.active').removeClass('active');
                    $(this).addClass('active');
                }
            });


            //al pasar el cursor por una fila de la tabla hacemos el hover tambien sobre la fila de la fixed column
            $("#tabla-manipulacion-uti-bilbao").on("mouseenter", "tbody tr", function() {
                //stuff to do on mouse enter
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //añadimos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-manipulacion-uti tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").addClass('hover');

            });

            //al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
            $("#tabla-manipulacion-uti-bilbao").on("mouseleave", "tbody tr", function() {
                //stuff to do on mouse leave
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //quitamos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-manipulacion-uti-bilbao tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
            });


            //al pasar el cursor por una fila de la fixed columns hacemos el hover tambien sobre la fila de la tabla
            $(".DTFC_Cloned").on("mouseenter", "tbody tr", function() {
                //stuff to do on mouse enter
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //añadimos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-manipulacion-uti-bilbao tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
            });

            //al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
            $(".DTFC_Cloned").on("mouseleave", "tbody tr", function() {
                //stuff to do on mouse leave
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //quitamos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-manipulacion-uti-bilbao tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
            });

        });
    </script>
    <!-- FIN SCRIPT TABLA MANIPULACION UTI -->

    <!-- SCRIPT TABLA ALMACENAJE 20 -->
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
            $('#tabla-almacenaje-bilbao-20 tfoot th').each(function(i) {
                var title2 = $('#tabla-almacenaje-bilbao-20 thead th').eq($(this).index()).text();

                switch (i) {
                    case 0: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:150px;"/>');
                        break;
                    case 1: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:175px;"/>');
                        break;
                    case 2: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:175px;"/>');
                        break;
                    case 3: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:175px;"/>');
                        break;
                    case 4: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:400px;"/>');
                        break;
                    case 5: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:250px;"/>');
                        break;
                    case 6: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:200px;"/>');
                        break;
                    case 7: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:200px;"/>');
                        break;
                    case 8: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:200px;"/>');
                        break;
                    case 9: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:350px;"/>');
                        break;
                    case 10: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:250px;"/>');
                        break;
                    case 11: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:250px;"/>');
                        break;
                    case 12: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:200px;"/>');
                        break;
                    case 13: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:200px;"/>');
                        break;
                    case 14: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:400px;"/>');
                        break;
                    case 15: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:400px;"/>');
                        break;
                    default:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:auto;"/>');
                }

            });
            /////////////// FILTRADO DE REGISTROS DE TABLA POR TEXTO EN CADA COLUMNA

            // INICIALIZACION DATATABLE
            table = $('#tabla-almacenaje-bilbao-20').DataTable({
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
                            doc.styles.title2.fontSize = 11;

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
            $('#tabla-almacenaje-bilbao-20 tbody').on('click', 'tr', function() {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    table.$('tr.active').removeClass('active');
                    $(this).addClass('active');
                }
            });


            //al pasar el cursor por una fila de la tabla hacemos el hover tambien sobre la fila de la fixed column
            $("#tabla-almacenaje-bilbao-20").on("mouseenter", "tbody tr", function() {
                //stuff to do on mouse enter
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //añadimos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-almacenaje-bilbao-20 tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").addClass('hover');

            });

            //al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
            $("#tabla-almacenaje-bilbao-20").on("mouseleave", "tbody tr", function() {
                //stuff to do on mouse leave
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //quitamos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-almacenaje-bilbao-20 tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
            });


            //al pasar el cursor por una fila de la fixed columns hacemos el hover tambien sobre la fila de la tabla
            $(".DTFC_Cloned").on("mouseenter", "tbody tr", function() {
                //stuff to do on mouse enter
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //añadimos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-almacenaje-bilbao-20 tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
            });

            //al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
            $(".DTFC_Cloned").on("mouseleave", "tbody tr", function() {
                //stuff to do on mouse leave
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //quitamos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-almacenaje-bilbao-20 tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
            });

        });
    </script>
    <!-- FIN SCRIPT TABLA ALMACENAJE 20 -->

    <!-- SCRIPT TABLA ALMACENAJE 40 -->
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
            $('#tabla-almacenaje-bilbao-40 tfoot th').each(function(i) {
                var title2 = $('#tabla-almacenaje-bilbao-40 thead th').eq($(this).index()).text();

                switch (i) {
                    case 0: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:150px;"/>');
                        break;
                    case 1: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:175px;"/>');
                        break;
                    case 2: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:175px;"/>');
                        break;
                    case 3: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:175px;"/>');
                        break;
                    case 4: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:400px;"/>');
                        break;
                    case 5: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:250px;"/>');
                        break;
                    case 6: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:200px;"/>');
                        break;
                    case 7: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:200px;"/>');
                        break;
                    case 8: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:200px;"/>');
                        break;
                    case 9: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:350px;"/>');
                        break;
                    case 10: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:250px;"/>');
                        break;
                    case 11: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:250px;"/>');
                        break;
                    case 12: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:200px;"/>');
                        break;
                    case 13: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:200px;"/>');
                        break;
                    case 14: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:400px;"/>');
                        break;
                    case 15: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:400px;"/>');
                        break;
                    default:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:auto;"/>');
                }

            });
            /////////////// FILTRADO DE REGISTROS DE TABLA POR TEXTO EN CADA COLUMNA

            // INICIALIZACION DATATABLE
            table = $('#tabla-almacenaje-bilbao-40').DataTable({
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
                            doc.styles.title2.fontSize = 11;

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
            $('#tabla-almacenaje-bilbao-40 tbody').on('click', 'tr', function() {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    table.$('tr.active').removeClass('active');
                    $(this).addClass('active');
                }
            });


            //al pasar el cursor por una fila de la tabla hacemos el hover tambien sobre la fila de la fixed column
            $("#tabla-almacenaje-bilbao-40").on("mouseenter", "tbody tr", function() {
                //stuff to do on mouse enter
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //añadimos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-almacenaje-bilbao-40 tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").addClass('hover');

            });

            //al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
            $("#tabla-almacenaje-bilbao-40").on("mouseleave", "tbody tr", function() {
                //stuff to do on mouse leave
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //quitamos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-almacenaje-bilbao-40 tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
            });


            //al pasar el cursor por una fila de la fixed columns hacemos el hover tambien sobre la fila de la tabla
            $(".DTFC_Cloned").on("mouseenter", "tbody tr", function() {
                //stuff to do on mouse enter
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //añadimos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-almacenaje-bilbao-40 tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
            });

            //al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
            $(".DTFC_Cloned").on("mouseleave", "tbody tr", function() {
                //stuff to do on mouse leave
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //quitamos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-almacenaje-bilbao-40 tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
            });

        });
    </script>
    <!-- FIN SCRIPT TABLA ALMACENAJE 40 -->

    <!-- SCRIPT TABLA ALMACENAJE 45 -->
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
            $('#tabla-almacenaje-bilbao-45 tfoot th').each(function(i) {
                var title2 = $('#tabla-almacenaje-bilbao-45 thead th').eq($(this).index()).text();

                switch (i) {
                    case 0: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:150px;"/>');
                        break;
                    case 1: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:175px;"/>');
                        break;
                    case 2: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:175px;"/>');
                        break;
                    case 3: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:175px;"/>');
                        break;
                    case 4: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:400px;"/>');
                        break;
                    case 5: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:250px;"/>');
                        break;
                    case 6: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:200px;"/>');
                        break;
                    case 7: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:200px;"/>');
                        break;
                    case 8: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:200px;"/>');
                        break;
                    case 9: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:350px;"/>');
                        break;
                    case 10: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:250px;"/>');
                        break;
                    case 11: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:250px;"/>');
                        break;
                    case 12: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:200px;"/>');
                        break;
                    case 13: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:200px;"/>');
                        break;
                    case 14: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:400px;"/>');
                        break;
                    case 15: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:400px;"/>');
                        break;
                    default:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title2 + '" data-index="' + i + '" style="color:red; width:auto;"/>');
                }

            });
            /////////////// FILTRADO DE REGISTROS DE TABLA POR TEXTO EN CADA COLUMNA

            // INICIALIZACION DATATABLE
            table = $('#tabla-almacenaje-bilbao-45').DataTable({
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
                            doc.styles.title2.fontSize = 11;

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
            $('#tabla-almacenaje-bilbao-45 tbody').on('click', 'tr', function() {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    table.$('tr.active').removeClass('active');
                    $(this).addClass('active');
                }
            });


            //al pasar el cursor por una fila de la tabla hacemos el hover tambien sobre la fila de la fixed column
            $("#tabla-almacenaje-bilbao-45").on("mouseenter", "tbody tr", function() {
                //stuff to do on mouse enter
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //añadimos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-almacenaje-bilbao-45 tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").addClass('hover');

            });

            //al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
            $("#tabla-almacenaje-bilbao-45").on("mouseleave", "tbody tr", function() {
                //stuff to do on mouse leave
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //quitamos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-almacenaje-bilbao-45 tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
            });


            //al pasar el cursor por una fila de la fixed columns hacemos el hover tambien sobre la fila de la tabla
            $(".DTFC_Cloned").on("mouseenter", "tbody tr", function() {
                //stuff to do on mouse enter
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //añadimos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-almacenaje-bilbao-45 tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
            });

            //al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
            $(".DTFC_Cloned").on("mouseleave", "tbody tr", function() {
                //stuff to do on mouse leave
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //quitamos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-almacenaje-bilbao-45 tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
            });

        });
    </script>
    <!-- FIN SCRIPT TABLA ALMACENAJE 45 -->

    <!-- SCRIPT CONEXIONADO+CONTROL_TEMP+LIMPIEZA -->
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
            $('#tabla-conexioado_control_temp_limpieza-bilbao tfoot th').each(function(i) {
                var title = $('#tabla-conexioado_control_temp_limpieza-bilbao thead th').eq($(this).index()).text();

                switch (i) {
                    case 0: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:125px;"/>'); //nº contenedor
                        break;
                    case 1: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:100px;"/>'); //tamaño
                        break;
                    case 2: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:150px;"/>'); //tipo
                        break;
                    case 3: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:150px;"/>'); //fecha conexion
                        break;
                    case 4: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:250px;"/>'); //fecha desconexion
                        break;
                    case 5: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:100px;"/>'); //total dias
                        break;
                    case 6: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:350px;"/>'); //importe tempetaruta
                        break;
                    case 7: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:255px;"/>'); //importe conexion
                        break;
                    case 8: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:255px;"/>'); //importe limpieza
                        break;
                    default:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:auto;"/>');
                }

            });
            /////////////// FILTRADO DE REGISTROS DE TABLA POR TEXTO EN CADA COLUMNA

            // INICIALIZACION DATATABLE
            table = $('#tabla-conexioado_control_temp_limpieza-bilbao').DataTable({
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
            $('#tabla-conexioado_control_temp_limpieza-bilbao tbody').on('click', 'tr', function() {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    table.$('tr.active').removeClass('active');
                    $(this).addClass('active');
                }
            });


            //al pasar el cursor por una fila de la tabla hacemos el hover tambien sobre la fila de la fixed column
            $("#tabla-conexioado_control_temp_limpieza-bilbao").on("mouseenter", "tbody tr", function() {
                //stuff to do on mouse enter
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //añadimos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-conexioado_control_temp_limpieza-bilbao tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").addClass('hover');

            });

            //al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
            $("#tabla-conexioado_control_temp_limpieza-bilbao").on("mouseleave", "tbody tr", function() {
                //stuff to do on mouse leave
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //quitamos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-conexioado_control_temp_limpieza-bilbao tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
            });


            //al pasar el cursor por una fila de la fixed columns hacemos el hover tambien sobre la fila de la tabla
            $(".DTFC_Cloned").on("mouseenter", "tbody tr", function() {
                //stuff to do on mouse enter
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //añadimos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-conexioado_control_temp_limpieza-bilbao tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
            });

            //al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
            $(".DTFC_Cloned").on("mouseleave", "tbody tr", function() {
                //stuff to do on mouse leave
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //quitamos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-conexioado_control_temp_limpieza-bilbao tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
            });

        });
    </script>
    <!-- FIN SCRIPT CONEXIONADO+CONTROL_TEMP+LIMPIEZA -->

    <!-- SCRIPT HORAS EXTRAS -->
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
            $('#tabla-horas-extras-bilbao tfoot th').each(function(i) {
                var title3 = $('#tabla-horas-extras-bilbao thead th').eq($(this).index()).text();

                switch (i) {
                    case 0: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title3 + '" data-index="' + i + '" style="color:red; width:110px;"/>'); //nº contenedor
                        break;
                    case 1: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title3 + '" data-index="' + i + '" style="color:red; width:150px;"/>'); //tamaño
                        break;
                    case 2: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title3 + '" data-index="' + i + '" style="color:red; width:150px;"/>'); //tipo
                        break;
                    case 3: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title3 + '" data-index="' + i + '" style="color:red; width:120px;"/>'); //fecha conexion
                        break;
                    case 4: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title3 + '" data-index="' + i + '" style="color:red; width:200px;"/>'); //fecha desconexion
                        break;
                    case 5: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title3 + '" data-index="' + i + '" style="color:red; width:250px;"/>'); //total dias
                        break;
                    case 6: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title3 + '" data-index="' + i + '" style="color:red; width:200px;"/>'); //importe temperatura
                        break;
                    case 7: //columna
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title3 + '" data-index="' + i + '" style="color:red; width:400px;"/>'); //importe conexion
                        break;
                    default:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title3 + '" data-index="' + i + '" style="color:red; width:auto;"/>');
                }

            });
            /////////////// FILTRADO DE REGISTROS DE TABLA POR TEXTO EN CADA COLUMNA

            // INICIALIZACION DATATABLE
            table = $('#tabla-horas-extras-bilbao').DataTable({
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
                            doc.styles.title2.fontSize = 11;

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
            $('#tabla-horas-extras-bilbao tbody').on('click', 'tr', function() {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    table.$('tr.active').removeClass('active');
                    $(this).addClass('active');
                }
            });


            //al pasar el cursor por una fila de la tabla hacemos el hover tambien sobre la fila de la fixed column
            $("#tabla-horas-extras-bilbao").on("mouseenter", "tbody tr", function() {
                //stuff to do on mouse enter
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //añadimos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-horas-extras-bilbao tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").addClass('hover');

            });

            //al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
            $("#tabla-horas-extras-bilbao").on("mouseleave", "tbody tr", function() {
                //stuff to do on mouse leave
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //quitamos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-horas-extras-bilbao tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
            });


            //al pasar el cursor por una fila de la fixed columns hacemos el hover tambien sobre la fila de la tabla
            $(".DTFC_Cloned").on("mouseenter", "tbody tr", function() {
                //stuff to do on mouse enter
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //añadimos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-horas-extras-bilbao tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
            });

            //al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
            $(".DTFC_Cloned").on("mouseleave", "tbody tr", function() {
                //stuff to do on mouse leave
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //quitamos la clase hover a la fila correspondiente de la fixed column
                $('#tabla-horas-extras-bilbao tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
            });

        });
    </script>
    <!-- FIN SCRIPT HORAS EXTRAS -->


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
                            echo $month; ?>(CMA CGM INLAND SERVICES SAU)</h3>
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
                <h3>MANIPULACIÓN UTIS</h3>
                <div class="well well-sm">
                    <a href="../controllers/excel_detalle_facturacion_cliente_controller.php?cliente=CCIS-BILBAO&fecha_inicio=<?php echo $fecha_inicio; ?>&fecha_fin=<?php echo $fecha_fin; ?>&tipo_facturacion=manipulacion_uti" type="button" id="manipulacion_uti_ccis_bilbao" class="btn btn-success" title="excel"><i class="far fa-file-excel" aria-hidden="true"> </i> MANIPULACION UTI CCIS-BILBAO </a>
                    <a class="btn btn-default" onclick=""><i class="glyphicon glyphicon-euro"></i> <strong>Total Manipulación UTI: <i><?php echo $total_importe_manipulacion_utis . ' €'; ?></strong></i></a>
                </div>
                <table id="tabla-manipulacion-uti-bilbao" class="table table-bordered table-striped dataTable table-hover">
                    <thead>
                        <tr>
                            <th>Nº CONTENEDOR</th>
                            <th>TAMAÑO</th>
                            <th>FECHA ENTRADA</th>
                            <th>TIPO ENTRADA</th>
                            <th>FECHA SALIDA</th>
                            <th>TIPO SALIDA</th>
                            <th>IMPORTE MANIPULACION UTI (<?= $tarifa_manipulacion_uti ?> €/UTI)</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>Nº CONTENEDOR</th>
                            <th>TAMAÑO</th>
                            <th>FECHA ENTRADA</th>
                            <th>TIPO ENTRADA</th>
                            <th>FECHA SALIDA</th>
                            <th>TIPO SALIDA</th>
                            <th>IMPORTE MANIPULACION UTI (<?= $tarifa_manipulacion_uti ?> €/UTI)</th>
                        </tr>
                    </tfoot>

                    <tbody>
                        <?php foreach ($manipulacion_uti_list as $manipulacion_uti_line) { ?>
                            <tr>
                                <td><?php echo $manipulacion_uti_line['num_contenedor']; ?></td>
                                <td><?php echo $manipulacion_uti_line['longitud_tipo_contenedor']; ?></td>
                                <td><?php echo $manipulacion_uti_line['fecha_entrada']; ?></td>
                                <td><?php echo $manipulacion_uti_line['tipo_entrada']; ?></td>
                                <td><?php echo $manipulacion_uti_line['fecha_salida']; ?></td>
                                <td><?php echo $manipulacion_uti_line['tipo_salida']; ?></td>
                                <td><?php echo $manipulacion_uti_line['importe_manipulacion_utis'];
                                    echo ' €' ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!--</div>-->

            <!--<div class="container-fluid" id="page-wrapper">-->
            <div class="row" style="margin:0">
                <h3>ALMACENAJE</h3>
                <div class="well well-sm">
                    <a href="../controllers/excel_detalle_facturacion_cliente_controller.php?cliente=CCIS-BILBAO&fecha_inicio=<?php echo $fecha_inicio; ?>&fecha_fin=<?php echo $fecha_fin; ?>&tipo_facturacion=almacenaje" type="button" id="" class="btn btn-success" title="excel"><i class="far fa-file-excel" aria-hidden="true"></i> ALMACENAJE CCIS-BILBAO </a>
                    <a class="btn btn-default" onclick=""><i class="glyphicon glyphicon-euro"></i> <strong>Importe almacenaje 20': <i><?php echo $total_importe_almacenaje_20 . ' €'; ?></strong></i></a>
                    <a class="btn btn-default" onclick=""><i class="glyphicon glyphicon-euro"></i> <strong>Importe almacenaje 40': <i><?php echo $total_importe_almacenaje_40 . ' €'; ?></strong></i></a>
                    <a class="btn btn-default" onclick=""><i class="glyphicon glyphicon-euro"></i> <strong>Importe almacenaje 45': <i><?php echo $total_importe_almacenaje_45 . ' €'; ?></strong></i></a>
                    <a class="btn btn-default" onclick=""><i class="glyphicon glyphicon-euro"></i> <strong>Total Importe Almacenaje: <i><?php echo $total_importe_almacenaje . ' €'; ?></strong></i></a>
                </div>

                <h4>ALMACENAJE 20'</h4>
                <table id="tabla-almacenaje-bilbao-20" class="table table-bordered table-striped dataTable table-hover">
                    <thead>
                        <tr>
                            <th>FECHA STOCK</th>
                            <th>ENTRADA 20'</th>
                            <th>SALIDA 20'</th>
                            <th>STOCK 20' </th>
                            <th>ALMACENAJE 20' (<?= $unidades_libres_20 ?>  UNIDADES LIBRES)</th>
                            <th>IMPORTE ALMACENAJE (<?= $tarifa_almacenaje_20 ?> €/UTI)</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>FECHA STOCK</th>
                            <th>ENTRADA 20'</th>
                            <th>SALIDA 20'</th>
                            <th>STOCK 20' </th>
                            <th>ALMACENAJE 20' (<?= $unidades_libres_20 ?>  UNIDADES LIBRES)</th>
                            <th>IMPORTE ALMACENAJE (<?= $tarifa_almacenaje_20 ?> €/UTI)</th>
                        </tr>
                    </tfoot>

                    <tbody>

                        <?php foreach ($almacenaje_list_20 as $almacenaje_line_20) { ?>
                            <tr>
                                <td><?php echo $almacenaje_line_20['fecha_dia']; ?></td>
                                <td><?php echo $almacenaje_line_20['num_contenedores_entrada_20']; ?></td>
                                <td><?php echo $almacenaje_line_20['num_contenedores_salida_20']; ?></td>
                                <td><?php echo $almacenaje_line_20['num_contenedores_20_total']; ?></td>
                                <td><?php echo $almacenaje_line_20['num_contenedores_20_cobrar']; ?></td>
                                <td><?php echo $almacenaje_line_20['importe_almacenaje_20']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <h4>ALMACENAJE 40'</h4>
                <table id="tabla-almacenaje-bilbao-40" class="table table-bordered table-striped dataTable table-hover">
                    <thead>
                        <tr>
                            <th>FECHA STOCK</th>
                            <th>ENTRADA 40'</th>
                            <th>SALIDA 40'</th>
                            <th>STOCK 40' </th>
                            <th>ALMACENAJE 40' (<?= $unidades_libres_40 ?> UNIDADES LIBRES)</th>
                            <th>IMPORTE ALMACENAJE (<?= $tarifa_almacenaje_40 ?> €/UTI)</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>FECHA STOCK</th>
                            <th>ENTRADA 40'</th>
                            <th>SALIDA 40'</th>
                            <th>STOCK 40' </th>
                            <th>ALMACENAJE 40' (<?= $unidades_libres_40 ?> UNIDADES LIBRES)</th>
                            <th>IMPORTE ALMACENAJE (<?= $tarifa_almacenaje_40 ?> €/UTI)</th>
                        </tr>
                    </tfoot>

                    <tbody>

                        <?php foreach ($almacenaje_list_40 as $almacenaje_line_40) { ?>
                            <tr>
                                <td><?php echo $almacenaje_line_40['fecha_dia']; ?></td>
                                <td><?php echo $almacenaje_line_40['num_contenedores_entrada_40']; ?></td>
                                <td><?php echo $almacenaje_line_40['num_contenedores_salida_40']; ?></td>
                                <td><?php echo $almacenaje_line_40['num_contenedores_40_total']; ?></td>
                                <td><?php echo $almacenaje_line_40['num_contenedores_40_cobrar']; ?></td>
                                <td><?php echo $almacenaje_line_40['importe_almacenaje_40']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <h4>ALMACENAJE 45'</h4>
                <table id="tabla-almacenaje-bilbao-45" class="table table-bordered table-striped dataTable table-hover">
                    <thead>
                        <tr>
                            <th>FECHA STOCK</th>
                            <th>ENTRADA 45'</th>
                            <th>SALIDA 45'</th>
                            <th>STOCK 45' </th>
                            <th>ALMACENAJE 45' (<?= $unidades_libres_45 ?> UNIDADES LIBRES)</th>
                            <th>IMPORTE ALMACENAJE (<?= $tarifa_almacenaje_45 ?> €/UTI)</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>FECHA STOCK</th>
                            <th>ENTRADA 45'</th>
                            <th>SALIDA 45'</th>
                            <th>STOCK 45' </th>
                            <th>ALMACENAJE 45' (<?= $unidades_libres_45 ?> UNIDADES LIBRES)</th>
                            <th>IMPORTE ALMACENAJE (<?= $tarifa_almacenaje_45 ?> €/UTI)</th>
                        </tr>
                    </tfoot>

                    <tbody>

                        <?php foreach ($almacenaje_list_45 as $almacenaje_line_45) { ?>
                            <tr>
                                <td><?php echo $almacenaje_line_45['fecha_dia']; ?></td>
                                <td><?php echo $almacenaje_line_45['num_contenedores_entrada_45']; ?></td>
                                <td><?php echo $almacenaje_line_45['num_contenedores_salida_45']; ?></td>
                                <td><?php echo $almacenaje_line_45['num_contenedores_45_total']; ?></td>
                                <td><?php echo $almacenaje_line_45['num_contenedores_45_cobrar']; ?></td>
                                <td><?php echo $almacenaje_line_45['importe_almacenaje_45']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!--<div class="container-fluid" id="page-wrapper">-->
            <div class="row" style="margin:0">
                <h3>CONEXIONADO+CONTROL_TEMP+LIMPIEZA</h3>
                <div class="well well-sm">
                    <a href="../controllers/excel_detalle_facturacion_cliente_controller.php?cliente=CCIS-BILBAO&fecha_inicio=<?php echo $fecha_inicio; ?>&fecha_fin=<?php echo $fecha_fin; ?>&tipo_facturacion=conexionado_temperatura_limpieza" type="button" id="" class="btn btn-success" title="excel"><i class="far fa-file-excel" aria-hidden="true"></i> CONEXIONADO+CONTROL TEMP+LIMPIEZA CCIS-BILBAO </a>
                    <a class="btn btn-default" onclick=""><i class="glyphicon glyphicon-euro"></i> <strong>Imp. Temperatura: <i><?php echo $total_importe_control_temperatura . ' €'; ?></strong></i></a>
                    <a class="btn btn-default" onclick=""><i class="glyphicon glyphicon-euro"></i> <strong>Imp. Conexión: <i><?php echo $total_importe_conexion . ' €'; ?></strong></i></a>
                    <a class="btn btn-default" onclick=""><i class="glyphicon glyphicon-euro"></i> <strong>Imp. Limpieza: <i><?php echo $total_importe_limpieza . ' €'; ?></strong></i></a>
                    <a class="btn btn-default" onclick=""><i class="glyphicon glyphicon-euro"></i> <strong>Total Imp.: <i><?php echo $total_conexion_temperatura_limpieza . ' €'; ?></strong></i></a>
                </div>
                <table id="tabla-conexioado_control_temp_limpieza-bilbao" class="table table-bordered table-striped dataTable table-hover">
                    <thead>
                        <tr>
                            <th>Nº CONTENEDOR</th>
                            <th>TAMAÑO</th>
                            <th>TIPO</th>
                            <th>FECHA CONEXIÓN</th>
                            <th>FECHA DESCONEXIÓN</th>
                            <th>TOTAL DIAS</th>
                            <th>IMPORTE CONTROL TEMPERATURA (<?= $tarifa_temperatura ?> €/UTI)</th>
                            <th>IMPORTE CONEXIÓN (<?= $tarifa_conexion ?>  €/UTI)</th>
                            <th>IMPORTE LIMPIEZA (<?= $tarifa_limpieza ?>  €/UTI)</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>Nº CONTENEDOR</th>
                            <th>TAMAÑO</th>
                            <th>TIPO</th>
                            <th>FECHA CONEXIÓN</th>
                            <th>FECHA DESCONEXIÓN</th>
                            <th>TOTAL DIAS</th>
                            <th>IMPORTE CONTROL TEMPERATURA (<?= $tarifa_temperatura ?> €/UTI)</th>
                            <th>IMPORTE CONEXIÓN (<?= $tarifa_conexion ?>  €/UTI)</th>
                            <th>IMPORTE LIMPIEZA (<?= $tarifa_limpieza ?>  €/UTI)</th>
                        </tr>
                    </tfoot>

                    <tbody>

                        <?php foreach ($conexionado_control_temperatura_list as $conexionado_control_temperatura_line) { ?>
                            <tr>
                                <td><?php echo $conexionado_control_temperatura_line['num_contenedor']; ?></td>
                                <td><?php echo $conexionado_control_temperatura_line['longitud_tipo_contenedor']; ?></td>
                                <td><?php echo $conexionado_control_temperatura_line['descripcion_tipo_contenedor']; ?></td>
                                <td><?php echo $conexionado_control_temperatura_line['fecha_conexion']; ?></td>
                                <td><?php echo $conexionado_control_temperatura_line['fecha_desconexion']; ?></td>
                                <td><?php echo $conexionado_control_temperatura_line['total_dias']; ?></td>
                                <td><?php echo $conexionado_control_temperatura_line['importe_control_temperatura'];
                                    echo ' €' ?></td>
                                <td><?php echo $conexionado_control_temperatura_line['importe_conexion'];
                                    echo ' €' ?></td>
                                <td><?php echo $conexionado_control_temperatura_line['importe_limpieza'];
                                    echo ' €' ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!--</div>-->

            <!--<div class="container-fluid" id="page-wrapper">-->
            <div class="row" style="margin:0">
                <h3>HORAS EXTRAS</h3>
                <div class="well well-sm">
                    <?php $nombre_comercial_cliente == 'CCIS-BILBAO'; ?>
                    <!-- href="../controllers/excel_detalle_facturacion_cliente_controller.php?cliente=CCIS-BILBAO&fecha_inicio=<?php echo $fecha_inicio; ?>&fecha_fin=<?php echo $fecha_fin; ?>&tipo_facturacion=horas_extras" -->
                    <a type="button" id="" class="btn btn-success" title="excel" disabled><i class="far fa-file-excel" aria-hidden="true"></i> HORAS EXTRAS CCIS-BILBAO </a>
                    <a class="btn btn-default" onclick=""><i class="glyphicon glyphicon-euro"></i> <strong>Importe Horas Extras: <i><?php echo ' €'; ?></strong></i></a>
                    <a class="btn btn-default" onclick=""><i class="glyphicon glyphicon-euro"></i> <strong>Total Imp. Horas Extras: <i><?php echo ' €'; ?></strong></i></a>
                </div>
                <table id="tabla-horas-extras-bilbao" class="table table-bordered table-striped dataTable table-hover">
                    <thead>
                        <tr>
                            <th>FECHA</th>
                            <th>Nº EXPEDICIÓN TREN</th>
                            <th>ORIGEN / DESTINO</th>
                            <th>HORA ENTRADA</th>
                            <th>HORA SALIDA ORDINARIA</th>
                            <th>HORA SALIDA EXTRAORDINARIA</th>
                            <th>HORAS EXTRAS</th>
                            <th>IMPORTE HORAS EXTRAORDINARIAS (<?= $tarifa_hora_extraordinaria ?>  €/HORA EXTRA)</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>FECHA</th>
                            <th>Nº EXPEDICIÓN TREN</th>
                            <th>ORIGEN / DESTINO</th>
                            <th>HORA ENTRADA</th>
                            <th>HORA SALIDA ORDINARIA</th>
                            <th>HORA SALIDA EXTRAORDINARIA</th>
                            <th>HORAS EXTRAS</th>
                            <th>IMPORTE HORAS EXTRAORDINARIAS (<?= $tarifa_hora_extraordinaria ?>  €/HORA EXTRA)</th>
                        </tr>
                    </tfoot>

                    <tbody>
                        <?php foreach ($horas_extras_list as $horas_extras_line) { ?>
                            <tr>
                                <td><?php echo $horas_extras_line['fecha']; ?></td>
                                <td><?php echo $horas_extras_line['num_expedicion']; ?></td>
                                <td><?php echo $horas_extras_line['origen_destino']; ?></td>
                                <td><?php echo $horas_extras_line['hora_entrada']; ?></td>
                                <td><?php echo $horas_extras_line['hora_salida_ordinaria']; ?></td>
                                <td><?php echo $horas_extras_line['hora_salida_extra_ordinaria']; ?></td>
                                <td><?php echo $horas_extras_line['horas_extras']; ?></td>
                                <td><?php echo $horas_extras_line['importe_horas_extraordinarias'];
                                    echo ' €' ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="well well-sm">
                <center>
                    <button type="button" class="btn btn-warning btn-sm btn-shadow" onclick="guardartotales()" title="Guardar en BBDD">
                        <i class="fa fa-database"></i> Guardar en BBDD
                    </button>
                </center>
            </div>

        </div>
    </div>
</body>

</html>