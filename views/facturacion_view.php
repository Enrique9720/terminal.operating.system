<!DOCTYPE html>
<html lang="es" xml:lang="es" xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Facturaci&oacute;n</title>
	<?php
	//Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
	require_once('../tpl/header_includes.php');
	?>
	<script>
		var datatable;
		$(document).ready(function() {
			datatable = $('#table_facturacion').DataTable({
				ordering: false,
				autoWidth: false,
				iDisplayLength: 0,
				//scrollY: '55vh',
				bPaginate: false,
				bFilter: false,
				bInfo: false,
				bScrollCollapse: false
			});


			//Seleccion de filas
			$('#table_facturacion tbody').on('click', 'tr', function() {
				if ($(this).hasClass('active')) {
					$(this).removeClass('active');
				} else {
					datatable.$('tr.active').removeClass('active');
					$(this).addClass('active');
				}
			});

			//al pasar el cursor por una fila de la tabla hacemos el hover tambien sobre la fila de la fixed column
			$("#table_facturacion").on("mouseenter", "tbody tr", function() {
				//stuff to do on mouse enter
				//cogemos el indice de la fila en la tabla
				trIndex = $(this).index();
				//añadimos la clase hover a la fila correspondiente de la fixed column
				$('#table_facturacion tbody').find("tr:eq(" + trIndex + ")").addClass('hover');
			});

			//al salir el cursor de una fila de la tabla quitamos el hover tambien sobre la fila de la fixed column
			$("#table_facturacion").on("mouseleave", "tbody tr", function() {
				//stuff to do on mouse leave
				//cogemos el indice de la fila en la tabla
				trIndex = $(this).index();
				//quitamos la clase hover a la fila correspondiente de la fixed column
				$('#table_facturacion tbody').find("tr:eq(" + trIndex + ")").removeClass('hover');
			});
		});
	</script>


	<style>
		table {
			font-size: 11px;
		}

		.table>thead>tr>th {
        text-align: center; /* Centra el texto en los encabezados */
        vertical-align: middle; /* Alinea verticalmente el texto en el centro */
    }

		.table>tbody>tr.periodo_no_facturable>td {
			background-color: #eee;
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

		.text-right-bold {
			text-align: right;
			font-weight: bold;
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
		<br>

		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">

					<table id="table_facturacion" class="table table-bordered">
						<thead>
							<tr>
								<th scope="col" class="success">A&Ntilde;O</th>
								<th scope="col" class="success">MES</th>
								<th scope="col" class="success">IMPORTE MAN. UTIs</th>
								<th scope="col" class="success">IMPORTE ALMACENAJE</th>
								<th scope="col" class="success">IMPORTE CONEXIONADO ELECTRICO</th>
								<th scope="col" class="success">IMPORTE CONTROL TEMPERATURA</th>
								<th scope="col" class="success">IMPORTE LIMPIEZA</th>
								<th scope="col" class="success">IMPORTE HORAS EXTRAS</th>
								<th scope="col" class="success">IMPORTE MANIOBRA TERMINAL</th>
								<th scope="col" class="success">IMPORTE MANIOBRA GENERADORES</th>
								<th scope="col" class="success">IMPORTE SERVICIOS ESPECIALES (VIAS GENERADORES)</th>
								<th scope="col" class="success">IMPORTE TOTAL</th>
								<th scope="col" class="success"></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($facturacion_anual as $facturacion_line) { ?>
								<tr>
									<td><?php echo $facturacion_line['year']; ?></td>
									<td><?php echo $facturacion_line['month_name']; ?></td>
									<td style="text-align:right;"><?php echo $facturacion_line['importe_manipulacion_utis']; ?></td>
									<td style="text-align:right;"><?php echo $facturacion_line['importe_almacenaje']; ?></td>
									<td style="text-align:right;"><?php echo $facturacion_line['importe_conexionado_electrico']; ?></td>
									<td style="text-align:right;"><?php echo $facturacion_line['importe_control_temperatura']; ?></td>
									<td style="text-align:right;"><?php echo $facturacion_line['importe_limpieza']; ?></td>
									<td style="text-align:right;"><?php echo $facturacion_line['importe_horas_extras']; ?></td>
									<td style="text-align:right;"><?php echo $facturacion_line['importe_maniobra_terminal']; ?></td>
									<td style="text-align:right;"><?php echo $facturacion_line['importe_maniobra_generadores']; ?></td>
									<td style="text-align:right;"><?php echo $facturacion_line['importe_servicios_especiales']; ?></td>
									<td style="text-align:right;"><?php echo $facturacion_line['importe_total']; ?></td>
									<td><?php echo $facturacion_line['botones']; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>

				</div>
				<!-- /.col-lg-12 -->
			</div>

		</div>
		<!-- /#page-wrapper -->

	</div>
	<!-- /#wrapper -->

</body>