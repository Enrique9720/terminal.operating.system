<!DOCTYPE html>

<html lang="es">

<head>
    <title>Tiempo ISO 9001</title>

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

                <h3>Marcadores de Tiempo</h3>
                <div class="well well-sm">
                    <a class="btn btn-default" onclick="window.location.reload()"><i class="glyphicon glyphicon-refresh"></i> Recargar</a>
                    <a href="../controllers/excel_time_stats_controller.php" type="button" id="time_stats" class="btn btn-success" title="excel"><i class="far fa-file-excel" aria-hidden="true"> </i> EXCEL </a>
                </div>
                <h4>ISO 9001</h4>

                <div class="row">
                    <center>
                        <h5>TIEMPO MÁXIMO DE ESPERA DE CAMIÓN EN CONTROL DE ACCESO A LA TERMINAL</h5>
                    </center>
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <table id="table" class="table table-bordered table-striped dataTable table-hover">
                            <thead>
                                <tr>
                                    <th class="">Periodo</th>
                                    <th class="">Tiempo de espera en cola de camiones desde TTM hasta TCI (Minutos)</th>
                                    <th class="">Tiempo en acceso de la TTM en la TCI (Minutos)</th>
                                    <th class="">Total del tiempo (Minutos)</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($time_stats_list as $time_stats_line) { ?>
                                    <tr>
                                        <td><?php echo $time_stats_line['year'] . ' - ' . $time_stats_line['month']; ?></td>
                                        <td><?php echo $time_stats_line['t_max_espera_camion_en_cola']; ?> </td>
                                        <td><?php echo $time_stats_line['t_max_acceso_camion_ttm']; ?> </td>
                                        <td><?php echo $time_stats_line['t_max_espera_camion_en_cola'] + $time_stats_line['t_max_acceso_camion_ttm']; ?> </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-3"></div>
                </div>

                <div class="row">
                    <center>
                        <h5>TIEMPO MEDIO DE LA ESTANCIA DE UN CAMIÓN EN LA TERMINAL DE CARGA INTERMODAL</h5>
                    </center>
                    <div class="col-md-5"></div>
                    <div class="col-md-2">
                        <table id="tabla2" class="table table-bordered table-striped dataTable table-hover">
                            <thead>
                                <tr>
                                    <th class="">Periodo</th>
                                    <th class="">Tiempo medio (Minutos)</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($time_stats_list as $time_stats_line) { ?>
                                    <tr>
                                        <td><?php echo $time_stats_line['year'] . ' - ' . $time_stats_line['month']; ?></td>
                                        <td><?php echo $time_stats_line['t_medio_camion_tci']; ?> </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5"></div>
                </div>

                <div class="row">
                    <center>
                        <h5>TIEMPO MAXIMO DE TRATAMIENTO DE UN TREN DURANTE LA CARGA O DESCARGA DE CONTENEDORES</h5>
                    </center>
                    <div class="col-md-5"></div>
                    <div class="col-md-2">
                        <table id="tabla3" class="table table-bordered table-striped dataTable table-hover">
                            <thead>
                                <tr>
                                    <th class="">Periodo</th>
                                    <th class="">Tiempo maximo (Minutos)</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($time_stats_list as $time_stats_line) { ?>
                                    <tr>
                                        <td><?php echo $time_stats_line['year'] . ' - ' . $time_stats_line['month']; ?></td>
                                        <td><?php echo $time_stats_line['t_max_carga_descarga_tren']; ?> </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-5"></div>
                </div>


            </div>
        </div>
    </div>
</body>

</html>