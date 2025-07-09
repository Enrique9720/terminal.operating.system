<!DOCTYPE html>

<html lang="es">

<head>
    <title>Stock Contenedores</title>

    <?php
    //Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
    require_once('../tpl/header_includes.php');
    ?>

    <script>
        //Inicializacion DATATABLES
        //Imagen para PDF Datatables
        var logo_grupo = "<?php echo $dataUri = img2base64("../images/logogms2.png");?>";

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
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:120px;"/>');//Nº Contenedor
                        break;
                    case 1: //columna 1:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:95px;"/>');//Operaciones
                        break;
                    case 2: //columna 2:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:50px;"/>');//Tipo
                        break;
                    case 3: //columna 3:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:75px;"/>');//Longitud
                        break;
                    case 4: //columna 4:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:125px;"/>');//Descripción
                        break;
                    case 5: //columna 5:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:50px;"/>');//Tara
                        break;
                    case 6: //columna 6:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:100px;"/>');//Propietario
                        break;
                    case 7: //columna 7:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:65px;"/>');//Estado
                        break;
                    case 8: //columna 8:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:150px;"/>');//Mercancia
                        break;
                    case 9: //columna 9:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:115px;"/>');//Peso Mercancia
                        break;
                    case 10: //columna 10:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:90px;"/>');//Peso Bruto
                        break;
                    case 11: //columna 11:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:95px;"/>');//Temperatura
                        break;
                    case 12: //columna 12:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:190px;"/>');//Destinatario
                        break;
                    case 13: //columna 13:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:90px;"/>');//Nº Booking
                        break;
                    case 14: //columna 14:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:90px;"/>');//Nº Precinto
                        break;
                    case 15: //columna 15:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:110px;"/>');//Tipo Entrada
                        break;
                    case 16: //columna 16:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:105px;"/>');//Nº Expedición
                        break;
                    case 17: //columna 17:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:115px;"/>');//Fecha Entrada
                        break;
                    case 18: //columna 18:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:85px;"/>');//Fecha Entrada
                        break;
                    case 19: //columna 19:
                        $(this).html('<input type="text" class="form-control input-sm" placeholder="' + title + '" data-index="' + i + '" style="color:red; width:85px;"/>');//Incidencia
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
                fixedColumns: true,
                //ordenamos por fecha_creacion (columna nº0)
                order: [
                    [0, "asc"]
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
            $('#tabla tbody').on('click', 'tr', function() {
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                } else {
                    table.$('tr.active').removeClass('active');
                    $(this).addClass('active');
                }
            });


            //al pasar el cursor por una fila de la tabla hacemos el hover tambien sobre la fila de la fixed column
            $("#tabla").on("mouseenter", "tbody tr", function() {
                //stuff to do on mouse enter
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //añadimos la clase hover a la fila correspondiente de la fixed column
                $('#tabla tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").addClass('hover');

            });

            //al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
            $("#tabla").on("mouseleave", "tbody tr", function() {
                //stuff to do on mouse leave
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //quitamos la clase hover a la fila correspondiente de la fixed column
                $('#tabla tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
            });


            //al pasar el cursor por una fila de la fixed columns hacemos el hover tambien sobre la fila de la tabla
            $(".DTFC_Cloned").on("mouseenter", "tbody tr", function() {
                //stuff to do on mouse enter
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //añadimos la clase hover a la fila correspondiente de la fixed column
                $('#tabla tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
            });

            //al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
            $(".DTFC_Cloned").on("mouseleave", "tbody tr", function() {
                //stuff to do on mouse leave
                //cogemos el indice de la fila en la tabla
                trIndex = $(this).index();
                //quitamos la clase hover a la fila correspondiente de la fixed column
                $('#tabla tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
                $('.DTFC_Cloned tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
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
            <div class="row h-100" style="margin:0">

                <h3>Stock Contenedores</h3>
                <div class="well well-sm">
                    <a class="btn btn-default" onclick="window.location.reload()"><i class="glyphicon glyphicon-refresh"></i> Recargar</a>
                </div>

                <form class="form-inline" action="../controllers/stock_contenedores_controller.php" method="POST">
                  <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label><center>Fecha Stock:</center></label>
                        <input type="date" class="form-control" id="fecha_stock" name="fecha_stock" value="<?php echo $fecha_stock;?>" required>
                      </div>
                      <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" name="submit" class="btn btn-primary">Filtrar</button>
                      </div>
                    </div>
                    <div class="col-sm-4"></div>
                  </div>
                </form>

                <br/>

                <table id="tabla" class="table table-bordered dataTable table-hover">

                    <thead>
                        <tr>
                            <th class="warning">Nº Contenedor</th> <!-- ID entrada -->
                            <th class="noVis not-export-col warning">Operaciones</th>
                            <th class="warning">Tipo</th>
                            <th class="warning">Longitud</th>
                            <th class="warning">Descripción</th>
                            <th class="warning">Tara</th>
                            <th class="warning">Propietario</th>
                            <th class="success">Estado</th>
                            <th class="success">Mercancía</th>
                            <th class="success">Peso Mercancía</th>
                            <th class="success">Peso Bruto</th>
                            <th class="success">Temperatura</th>
                            <th class="success">Origen / Destino</th>
                            <th class="success">Nº Booking</th>
                            <th class="success">Nº Precinto</th>
                            <th class="success">Tipo Entrada</th>
                            <th class="success">Nº Expedición</th>
                            <th class="success">Fecha Entrada</th>
                            <th class="success">Ubicación</th>
                            <th class="warning">Incidencia</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                          <th class="warning">Nº Contenedor</th> <!-- ID entrada -->
                          <th class="noVis not-export-col warning">Operaciones</th>
                          <th class="warning">Tipo</th>
                          <th class="warning">Longitud</th>
                          <th class="warning">Descripción</th>
                          <th class="warning">Tara</th>
                          <th class="warning">Propietario</th>
                          <th class="success">Estado</th>
                          <th class="success">Mercancía</th>
                          <th class="success">Peso Mercancía</th>
                          <th class="success">Peso Bruto</th>
                          <th class="success">Temperatura</th>
                          <th class="success">Origen / Destino</th>
                          <th class="success">Nº Booking</th>
                          <th class="success">Nº Precinto</th>
                          <th class="success">Tipo Entrada</th>
                          <th class="success">Nº Expedición</th>
                          <th class="success">Fecha Entrada</th>
                          <th class="success">Ubicación</th>
                          <th class="warning">Incidencia</th>
                        </tr>
                    </tfoot>

                    <tbody>

                        <?php foreach ($contenedores_stock_list as $contenedores_stock_line) {
                                if($contenedores_stock_line['incidencia'] != null){
                                  $clase_incidencia = 'danger';
                                }else {
                                  $clase_incidencia = '';
                                }
                          ?>

                            <tr class="<?php echo $clase_incidencia; ?>" id="<?php echo $contenedores_stock_line['num_contenedor']; ?>">

                                <td><?php echo $contenedores_stock_line['num_contenedor']; ?></td>
                                <td>
                                    <center>
                                        <div class="btn-group">
                                            <a target="_blank" href="../controllers/historico_contenedor_controller.php?num_contenedor=<?php echo $contenedores_stock_line['num_contenedor']; ?>" type="button" id="<?php echo $contenedores_stock_line['num_contenedor']; ?>" class="btn btn-sm btn-default view_record" title="Ver"><span class="glyphicon glyphicon-eye-open"></span></a>
                                        </div>
                                    </center>
                                </td>
                                <td><?php echo $contenedores_stock_line['id_tipo_contenedor_iso']; ?></td>
                                <td><?php echo $contenedores_stock_line['longitud_tipo_contenedor']; ?></td>
                                <td><?php echo $contenedores_stock_line['descripcion_tipo_contenedor']; ?></td>
                                <td><?php echo $contenedores_stock_line['tara_contenedor']; ?></td>
                                <td><?php echo $contenedores_stock_line['nombre_comercial_propietario']; ?></td>
                                <td><?php echo $contenedores_stock_line['estado_carga_contenedor']; ?></td>
                                <td><?php echo $contenedores_stock_line['descripcion_mercancia']; ?></td>
                                <td><?php echo $contenedores_stock_line['peso_mercancia_contenedor']; ?></td>
                                <td><?php echo $contenedores_stock_line['peso_bruto_contenedor']; ?></td>
                                <td><?php echo $contenedores_stock_line['temperatura_contenedor']; ?></td>
                                <td><?php echo $contenedores_stock_line['nombre_destinatario']; ?></td>
                                <td><?php echo $contenedores_stock_line['num_booking_contenedor']; ?></td>
                                <td><?php echo $contenedores_stock_line['num_precinto_contenedor']; ?></td>
                                <td><?php echo $contenedores_stock_line['tipo_entrada']; ?></td>
                                <td><center>
                                <?php if($contenedores_stock_line['tipo_entrada'] == 'TRASPASO'){ ?>
                                  <a target="_blank" href="../controllers/entrada_resumen_controller.php?id_entrada=<?php echo $contenedores_stock_line['id_entrada'];?>" type="button" id="<?php echo $contenedores_stock_line['id_entrada'];?>" class="btn btn-sm btn-default view_record" title="Ver"><span class="glyphicon glyphicon-eye-open"></span></a>
                                <?php }else{?>
                                  <a target="_blank" href="../controllers/entrada_resumen_controller.php?id_entrada=<?php echo $contenedores_stock_line['id_entrada'];?>" type="button" id="<?php echo $contenedores_stock_line['id_entrada'];?>" class="btn btn-sm btn-default view_record" title="Ver"><?php echo $contenedores_stock_line['num_expedicion_entrada'];?></a>
                                <?php }?>
                                </td></center>
                                <td><?php echo $contenedores_stock_line['fecha_entrada']; ?></td>
                                <td><?php echo $contenedores_stock_line['id_ubicacion']; ?></td>

                                <td>
                                  <?php
                                    if(isset($contenedores_stock_line['incidencia'])){
                                      echo "<center>";
                                      echo "SI&nbsp;&nbsp;&nbsp;";
                                      echo '<a target="_blank" href="../controllers/parte_trabajo_controller.php?id_parte='.$contenedores_stock_line['incidencia'].'" type="button" class="btn btn-sm btn-default" title="Ver"><i class="fas fa-wrench"></i></a>';
                                      echo "</center>";
                                    }
                                  ?>
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
