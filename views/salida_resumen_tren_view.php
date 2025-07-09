<!DOCTYPE html>

<html lang="es">

<head>
	<title>Resumen Salida Tren <?php echo $num_expedicion_salida ?></title>

	<?php
		//Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
		require_once('../tpl/header_includes.php');
	?>

  <script>
		$(document).ready(function() {

			//Reenvio de CODECO erroneo
			//al hacer click en el boton de reenvio codeco
      $(document).on('click', '.resend_codeco', function(event){
           $.ajax({
               type: "POST",
               url: "../ajax/resend_codeco.php",
               data: {'id_codeco': this.id,}, //recogemos el id del boton de view_record
               success: function(returned){
                   var obj = $.parseJSON(returned);
                   jQuery(obj).each(function(i, item){
                       text = item.text;
                       if(text == 'success'){
												 location.reload();
                       }else{
                           alert(text);
                       }
                   })
               },
               error: function(){
                   alert("failure");
               }
           });
       });

			var num_expedicion_salida = '<?php echo $num_expedicion_salida ?>';

			table_salida_tren_resumen = $('#table_salida_tren_resumen').DataTable({
				columns: [
					{ data: 'fecha' },
					{ data: 'propietarios' },
					{ data: 'cantidad_vagones' },
					{ data: 'cantidad_contenedores' },
				],
				ordering: false,
				autoWidth: false,
				iDisplayLength: -1,
				//scrollY: '10vh',
				bPaginate: false,
				bFilter: false,
				bInfo: false,
				bScrollCollapse: true
			});

			table_lineas_salida_tren = $('#table_lineas_salida_tren').DataTable({
				columns: [
					{ data: 'num_vagon' },
					{ data: 'pos_vagon' },
					{ data: 'pos_contenedor' },
					{ data: 'num_contenedor' },
					{ data: 'id_tipo_contenedor_iso' },
					{ data: 'longitud_tipo_contenedor' },
					{ data: 'descripcion_tipo_contenedor' },
					{ data: 'tara_contenedor' },
					{ data: 'tipo_entrada' },
					{ data: 'num_expedicion_entrada' },
					{ data: 'estado_carga_contenedor' },
					{ data: 'peso_mercancia_contenedor' },
					{ data: 'peso_bruto_contenedor' },
					{ data: 'temperatura_contenedor' },
					{ data: 'nombre_comercial_propietario' },
					{ data: 'descripcion_mercancia' },
					{ data: 'nombre_destinatario' },
					{ data: 'num_tarjeta_teco' },
					{ data: 'codigo_estacion_ferrocarril' },
					{ data: 'nombre_estacion_ferrocarril' },
				],
				ordering: true,
				order: [
					[1, 'asc'], [2, 'asc']
				],
				autoWidth: false,
				iDisplayLength: -1,
				scrollX: true,
				//scrollY: '10vh',
				bPaginate: false,
				bFilter: false,
				bInfo: false,
				bScrollCollapse: true
			});

			table_ficheros = $('#table_ficheros').DataTable({
				columns: [
					{ data: 'tipo_fichero' },
					{ data: 'extension' },
					{ data: 'operaciones' },
				],
				ordering: true,
				autoWidth: false,
				iDisplayLength: -1,
				//scrollY: '10vh',
				bPaginate: false,
				bFilter: false,
				bInfo: false,
				bScrollCollapse: true
			});

			table_entrada_camion_incidencia = $('#table_salida_tren_incidencia').DataTable({
				columns: [{
						data: 'num_incidencia'
					},
					{
						data: 'tipo_incidencia'
					},
					{
						data: 'estado_incidencia'
					}
				],
				ordering: true,
				autoWidth: false,
				iDisplayLength: -1,
				//scrollY: '10vh',
				bPaginate: false,
				bFilter: false,
				bInfo: false,
				bScrollCollapse: true
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

		<div class="row">
			<div class="col-md-12" style="padding-top:10px;">
			 <div class="well well-sm">
					<?php if($_SESSION['roles_array'][0]['nombre_rol'] == "admin") : ?><a href="#" type="button" id="<?php echo $num_expedicion_salida ?>" class="btn btn-success add_fichero" title="Subir Fichero"><span class="fa fa-arrow-up" aria-hidden="true"></span> Subir Fichero</a><?php endif;?>
					<a href="../controllers/excel_salida_resumen_tren_controller.php?id_salida=<?php echo $id_salida;?>" type="button" id="" class="btn btn-success" title="excel"><i class="far fa-file-excel"></i> Salida Tren <?php echo $nombre_comercial_propietario;?></a>
					<a class="btn btn-default" onclick="window.location.reload()"><i class="glyphicon glyphicon-refresh"></i> Recargar</a>
				</div>
			</div>

			<center><h3>Salida Tren</h3></center>
			<center><h4>Nº Expedición: <?php echo $num_expedicion_salida ?></h4></center>
			<center><h4><?php echo $ruta_tren ?></h4></center>

			<div class="col-md-12" style="padding-top:10px;">
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<table id="table_salida_tren_resumen" class="table table-striped table-bordered" style="font-size: 12px;">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Propietario</th>
								<th>Nº Vagones</th>
								<th>Nº Contenedores</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php echo $fecha_salida?></td>
								<td><?php echo $propietarios?></td>
								<td><?php echo $cantidad_vagones?></td>
								<td><?php echo $cantidad_contenedores?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="col-sm-3"></div>
		</div>

		<div class="col-sm-12"><center><h4>Datos Contenedores</h4></center></div>

		<div class="col-md-12" style="padding-top:10px;">
				<table id="table_lineas_salida_tren" class="table table-striped table-bordered" style="font-size: 12px;">
					<thead>
						<tr>
							<th>Vagón</th>
							<th>P. vagón</th>
							<th>P. contenedor</th>
							<th>Nº contenedor</th>
							<th>Tipo</th>
							<th>Longitud</th>
							<th>Descripción</th>
							<th>Tara</th>
							<th>Tipo Entrada</th>
							<th>Exp. Entrada</th>
							<th>Estado carga</th>
							<th>Peso Mercancía</th>
							<th>Peso bruto</th>
							<th>Temperatura</th>
							<th>Propietario</th>
							<th>Mercancía</th>
							<th>Origen / Destino</th>
							<th>T. Teco</th>
							<th>Cod. Estación</th>
							<th>Estación</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($salida_tren_list as $salida_tren_line) {?>
						<tr>
							<td><?php echo $salida_tren_line['num_vagon'];?></td>
							<td><?php echo $salida_tren_line['pos_vagon'];?></td>
							<td><?php echo $salida_tren_line['pos_contenedor'];?></td>
							<td><?php
										if($salida_tren_line['num_contenedor'] == null){
											echo 'NO-CON';
										}else{
											echo $salida_tren_line['num_contenedor'];
										}?>
							</td>
							<td><?php echo $salida_tren_line['id_tipo_contenedor_iso'];?></td>
							<td><?php echo $salida_tren_line['longitud_tipo_contenedor'];?></td>
							<td><?php echo $salida_tren_line['descripcion_tipo_contenedor'];?></td>
							<td><?php echo $salida_tren_line['tara_contenedor'];?></td>
							<td><?php echo $salida_tren_line['tipo_entrada'];?></td>
							<td>
									<center>
									<?php echo $salida_tren_line['num_expedicion_entrada'];?>
									<?php if($salida_tren_line['num_expedicion_entrada'] != null){ ?>
											<div class="btn-group">
													<a target="_blank" href="../controllers/entrada_resumen_controller.php?id_entrada=<?php echo $salida_tren_line['id_entrada']; ?>" type="button" id="<?php echo $salida_tren_line['id_entrada']; ?>" class="btn btn-sm btn-default view_record" title="Ver Entrada"><span class="glyphicon glyphicon-eye-open"></span></a>
											</div>
									<?php }?>
									</center>
							</td>
							<td><?php echo $salida_tren_line['estado_carga_contenedor'];?></td>
							<td><?php echo $salida_tren_line['peso_mercancia_contenedor'];?></td>
							<td><?php echo $salida_tren_line['peso_bruto_contenedor'];?></td>
							<td><?php echo $salida_tren_line['temperatura_contenedor'];?></td>
							<td><?php echo $salida_tren_line['nombre_comercial_propietario'];?></td>
							<td><?php echo $salida_tren_line['descripcion_mercancia'];?></td>
							<td><?php echo $salida_tren_line['nombre_destinatario'];?></td>
							<td><?php echo $salida_tren_line['num_tarjeta_teco'];?></td>
							<td><?php echo $salida_tren_line['codigo_estacion_ferrocarril'];?></td>
							<td><?php echo $salida_tren_line['nombre_estacion_ferrocarril'];?></td>
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>

		</div>



		<div class="row">
			<div class="col-sm-12"><center><h4>Ficheros</h4></center></div>

			<div class="col-sm-4"></div>
			<div class="col-sm-4">
				<table id="table_ficheros" class="table table-striped table-bordered" style="font-size: 12px;">
					<thead>
						<tr>
							<th>Documento</th>
							<th>Extensión</th>
							<th>Operaciones</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($ficheros_list as $ficheros_line) {?>
						<tr>
							<td><?php echo $ficheros_line['tipo_fichero'];?></td>
							<td><?php echo $ficheros_line['extension'];?></td>
							<td>
								<div class="btn-group">
									<a href="<?php echo $ficheros_line['ruta_fichero'];?>" target="_blank" type="button" class="btn btn-sm btn-default ver_fichero" title="Ver"><span class="fa fa-eye" aria-hidden="true"></span></a>
									<a href="<?php echo $ficheros_line['ruta_fichero'];?>" download type="button" class="btn btn-sm btn-primary descargar_fichero" title="Descargar"><span class="fa fa-arrow-down" aria-hidden="true"></span></a>
									<?php if($_SESSION['roles_array'][0]['nombre_rol'] == "admin") : ?><a href="#" type="button" id="<?php echo $ficheros_line['id_fichero'];?>" class="btn btn-sm btn-danger delete_record" title="Borrar"><span class="glyphicon glyphicon-trash"></span></a><?php endif;?>
								</div>
							</td>
						</tr>
					<?php }?>
					</tbody>
				</table>
			</div>
			<div class="col-sm-4"></div>
		</div>

		<div class="row">
				<div class="col-sm-12">
					<center>
						<h4>Incidencia</h4>
					</center>
				</div>
				<div class="col-sm-3"></div>
				<div class="col-sm-6">
					<table id="table_salida_tren_incidencia" class="table table-striped table-bordered" style="font-size: 12px;">
						<thead>
							<tr>
								<th>Num Incidencia</th>
								<th>Tipo Incidencia</th>
								<th>Estado Incidencia</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($incidencia_list as $incidencia_line) { ?>
								<tr>
									<td><center><a target="_blank" href="../controllers/incidencia_controller.php?id_incidencia=<?php echo $incidencia_line['id_incidencia']; ?>" type="button" id="<?php echo $incidencia_line['id_incidencia']; ?>" class="btn btn-sm btn-default view_record" title="Ver"><?php echo $incidencia_line['num_incidencia']; ?></a></center></td>
									<td><?php echo $incidencia_line['tipo_incidencia']; ?></td>
									<td><?php echo $incidencia_line['estado_incidencia']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="col-sm-3"></div>
			</div>

		<div class="row">
			<div class="col-sm-12"><center><h4>CODECO</h4></center></div>
			<div class="col-sm-3"></div>
			<div class="col-sm-6">

				<table id="table_envio_codeco" class="table table-striped table-bordered" style="font-size: 12px;">
					<thead>
						<tr>
							<th>ID Codeco</th>
							<th>Nº Contenedor</th>
							<th>Estado envío</th>
							<th>Error</th>
							<th>Correo</th>
						</tr>

						<?php foreach ($codeco_info_list as $codeco_info_line) {?>
						<tr>
							<td><?php echo $codeco_info_line['id_codeco']; ?></td>
							<td><?php echo $codeco_info_line['num_contenedor'];?></td>
							<td>
								<?php
									//echo $codeco_info_line['check_envio'];
									if($codeco_info_line['check_envio'] == 1){
										echo "<i class='fa fa-check-circle fa-lg text-success' aria-hidden='true'></i>";
									}else{
										echo "<i class='fa fa-times-circle fa-lg text-danger' aria-hidden='true'></i>";
									}
								?>
							</td>
							<td><?php echo $codeco_info_line['error_envio'];?></td>
							<td><!-- Correo -->
							<?php
								if($codeco_info_line['check_envio'] == 0){ ?>
								<a href="#" type="button" id="<?php echo $codeco_info_line['id_codeco'];?>" class="btn btn-warning resend_codeco" title="Reenviar Codeco">
								<span class="fa fa-send-o" aria-hidden="false"></span> Reenviar Correo </a>
							<?php } ?>
							</td>
						</tr>
					<?php }?>


					</thead>
					<tbody>
					</tbody>
				</table>


			</div>
			<div class="col-sm-3"></div>
		</div>


		<br/>

	<!-- /#wrapper -->
	</div>


</body>
</html>
