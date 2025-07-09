<!DOCTYPE html>
<html lang="es">

<head>
    <title>Incidencia</title>
    <?php
    //Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
    require_once('../tpl/header_includes.php');
    ?>
    <!--Subida de ficheros-->
    <link rel="stylesheet" href="../css/upload_photo.css">
    <script src="../js/upload_photo.js"></script>
    <script>
        jQuery(document).ready(function() {
            ImgUpload();
        });
    </script>


    <style>
        table {
            font-size: 12px;
        }

        .select2 {
            width: 100% !important;
        }
    </style>

    <script>
        $(document).ready(function() {
            load_select2("#id_tipo_incidencia", "");
        });


        $(document).ready(function() {

            //Establecemos inputs de fecha y hora de entrada
            var now = new Date();
            var now2 = new Date(now.getFullYear(), now.getMonth(), now.getDate(), now.getHours() + 1, now.getMinutes());
            $('#fecha_incidencia')[0].valueAsDate = now2;
            $('#hora_incidencia')[0].valueAsDate = now2;
        });


        $(document).ready(function() {

            $("form#form_incidencia").submit(function(event) {

                event.preventDefault(); //prevenir el envio del form via ajax, hasta que no esten todos los campos requeridos
                var form_incidencia = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: "../ajax/validar_incidencia.php",
                    contentType: false,
                    processData: false,
                    data: form_incidencia,
                    success: function(returned) {

                        var obj = $.parseJSON(returned);
                        jQuery(obj).each(function(i, item) {
                            id_incidencia = item.id_incidencia;
                            status = item.status;
                            text_fichero = item.text_fichero;
                            incidencia_entrada = item.incidencia_entrada;
                            incidencia_salida = item.incidencia_salida;
                            incidencia_contenedor = item.incidencia_contenedor;
                            num_contenedor = item.num_contenedor;

                            $(text_fichero).each(function(i, item) {
                                id_foto = item.id_foto;
                                file = item.file;
                                text = item.text;
                                ruta_foto = item.ruta_foto;
                                $("#resultado_upload").append(text);
                            });

                            if (status == 'success') {
                                alert("Incidencia dada de alta en el sistema correctamente");
                                document.location = '../controllers/incidencia_controller.php?id_incidencia=' + id_incidencia;
                            } else {
                                alert("ERROR: hubo algún fallo al crear la incidencia");
                            }

                        })

                    },
                    error: function(returned) {}
                });

            });


        });
    </script>

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

            <!--<form role="form" autocomplete="off" action="" method="post" id="form_incidencia">-->
            <form method="POST" id="form_incidencia" name="form_incidencia" enctype="multipart/form-data">

                <div class="row">
                    <div class="col-lg-12" style="margin-top:20px;padding-left:0;">
                        <div class="well well-sm">
                            <a class="btn btn-default" onclick="window.location.reload()"><i class="glyphicon glyphicon-refresh"></i> Recargar</a>
                        </div>
                    </div>
                </div>

                <center>
                    <h3><i class="fas fa-exclamation-triangle"></i> Nueva Incidencia</h3>
                </center>

                <div class="col-lg-12" style="margin-top:20px;padding-left:0;">

                    <div class="row">
                        <div class="col-sm-3 col-xs-0"></div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label>Fecha:</label>
                                <input type="date" class="form-control" id="fecha_incidencia" name="fecha_incidencia" required>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="form-group">
                                <label>Hora:</label>
                                <input type="time" class="form-control" id="hora_incidencia" name="hora_incidencia" step="60" required>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-0"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Tipo Incidencia:</label>
                                <select class="form-control select2" id="id_tipo_incidencia" name="id_tipo_incidencia">
                                    <option value=''></option>
                                    <?php foreach ($tipo_incidencia_list as $tipo_incidencia_line) { ?>
                                        <option value="<?php echo $tipo_incidencia_line['id_tipo_incidencia']; ?>">
                                            <?php echo $tipo_incidencia_line['tipo_incidencia']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>

                    <div class="row" id="additional-form-container" style="display:none;">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <div id="additional-form"></div>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>

                    <script>
                        $(document).ready(function() {
                            $('#id_tipo_incidencia').change(function() {
                                var id_tipo_incidencia = $(this).val();
                                if (id_tipo_incidencia) {
                                    $.ajax({
                                        url: '../ajax/get_tipos_incidencias.php',
                                        type: 'POST',
                                        data: {
                                            id_tipo_incidencia: id_tipo_incidencia
                                        },
                                        success: function(response) {
                                            $('#additional-form').html(response);
                                            $('#additional-form-container').show();

                                            // Inicia Select2
                                            $('.select2').select2();
                                        }
                                    });
                                } else {
                                    $('#additional-form-container').hide();
                                    $('#additional-form').html('');
                                }
                            });
                        });
                    </script>

                    <div class="row">
                        <div class="col-sm-3 col-xs-0"></div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label>Observaciones:</label>
                                <textarea class="form-control" rows="3" id="observaciones" name="observaciones"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-0"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-xs-12" style="margin-top:20px;padding-left:0;">
                            <div class="control-group">
                                <center>
                                    <?php if ($_SESSION['roles_array'][0]['nombre_rol'] == "admin") : ?><button type="submit" class="btn btn-primary btn_guardar" id="submit" name="submit"><i class="fa fa-lg fa-save"></i> Guardar</button><?php endif; ?>
                            </div>
                            </center>
                        </div>
                    </div>
                </div>
        </div> <!--Fin div col-lg-12-->
        </form>

    </div>
    </div>
    <!-- /#wrapper -->
    </div>
</body>

</html>
