<!DOCTYPE html>

<html lang="es">

<head>
	<title>Resumen Entrada Traspaso <?php echo $num_traspaso ?></title>

	<?php
		//Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
		require_once('../tpl/header_includes.php');
	?>

	<!-- Custom Functions JavaScript -->
	<script src="../functions/documentacion_functions.js"></script>

  <script>
		$(document).ready(function() {

			var num_expedicion_salida = '<?php echo $num_traspaso ?>';

			table_traspaso_resumen = $('#table_traspaso_resumen').DataTable({
				columns: [
					{ data: 'id_traspaso' },
					{ data: 'fecha_traspaso' },
					{ data: 'num_contenedor' },
					{ data: 'nombre_comercial_propietario_anterior' },
					{ data: 'nombre_comercial_propietario_actual' },
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

			table_lineas_entrada = $('#table_lineas_entrada').DataTable({
				columns: [
					{ data: 'num_contenedor' },
					{ data: 'id_tipo_contenedor_iso' },
					{ data: 'longitud_tipo_contenedor' },
					{ data: 'descripcion_tipo_contenedor' },
					{ data: 'estado_carga_contenedor' },
					{ data: 'peso_mercancia_contenedor' },
					{ data: 'temperatura_contenedor' },
					{ data: 'descripcion_mercancia' },
					{ data: 'num_booking_contenedor' },
					{ data: 'num_precinto_contenedor' },
				],

				columnDefs: [
					{//num_contenedor
					"targets": 0,
					"className": "text-left",
					"width": "10%"
				},
				{//num_contenedor
					"targets": 1,
					"className": "text-left",
					"width": "5%"
				},

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
					<a class="btn btn-default" onclick="window.location.reload()"><i class="glyphicon glyphicon-refresh"></i> Recargar</a>
				</div>
			</div>

			<center><h3>Entrada Traspaso</h3></center>
			<center><h4>Nº Traspaso: <?php echo $num_traspaso ?></h4></center>

				<div class="col-md-12" style="padding-top:10px;">
					<div class="col-sm-3"></div>
					<div class="col-sm-6">
						<table id="table_traspaso_resumen" class="table table-striped table-bordered" style="font-size: 12px;">
							<thead>
								<tr>
									<th>Nº Traspaso</th>
									<th>Fecha</th>
									<th>Nº Contenedor</th>
									<th>Propietario anterior</th>
									<th>Propietario actual</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($entrada_traspaso_list as $entrada_traspaso_line) {?>
								<tr>
									<td><?php echo $entrada_traspaso_line['id_traspaso'];?></td>
									<td><?php echo $entrada_traspaso_line['fecha_traspaso'];?></td>
									<td><?php echo $entrada_traspaso_line['num_contenedor'];?></td>
									<td><?php echo $entrada_traspaso_line['nombre_comercial_propietario_anterior'];?></td>
									<td><?php echo $entrada_traspaso_line['nombre_comercial_propietario_actual'];?></td>
								</tr>
								<?php }?>
							</tbody>
						</table>
					</div>
					<div class="col-sm-3"></div>
			</div>



		<div class="col-md-12" style="padding-top:10px;">
				<center><h4>Datos Contenedor</h4></center>
				<table id="table_lineas_entrada" class="table table-striped table-bordered" style="font-size: 12px;">
					<thead>
						<tr>
							<th>Nº contenedor</th>
							<th>Tipo</th>
							<th>Longitud</th>
							<th>Descripción</th>
							<th>Tara</th>
							<th>Estado carga</th>
							<th>Peso Mercancía</th>
							<th>Temperatura</th>
							<th>Mercancía</th>
							<th>Nº Booking</th>
							<th>Nº Precinto</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($entrada_traspaso_list as $entrada_traspaso_line) {?>
						<tr>
							<td><?php echo $entrada_traspaso_line['num_contenedor'];?></td>
							<td><?php echo $entrada_traspaso_line['id_tipo_contenedor_iso'];?></td>
							<td><?php echo $entrada_traspaso_line['longitud_tipo_contenedor'];?></td>
							<td><?php echo $entrada_traspaso_line['descripcion_tipo_contenedor'];?></td>
							<td><?php echo $entrada_traspaso_line['tara_contenedor'];?></td>
							<td><?php echo $entrada_traspaso_line['estado_carga_contenedor'];?></td>
							<td><?php echo $entrada_traspaso_line['peso_mercancia_contenedor'];?></td>
							<td><?php echo $entrada_traspaso_line['temperatura_contenedor'];?></td>
							<td><?php echo $entrada_traspaso_line['descripcion_mercancia'];?></td>
							<td><?php echo $entrada_traspaso_line['num_booking_contenedor'];?></td>
							<td><?php echo $entrada_traspaso_line['num_precinto_contenedor'];?></td>
						</tr>
						<?php }?>
					</tbody>
				</table>
			</div>



		</div>


	<!-- /#wrapper -->
	</div>


</body>
</html>
