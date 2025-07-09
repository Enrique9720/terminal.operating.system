<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

	<title>Estadisticas Generales <?php echo $_SESSION['year']; ?></title>
</head>

<body>
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<?php //Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
			require_once('../tpl/aside.php');
			require_once('../tpl/header_includes.php');
			require_once('../tpl/header_menu.php');
			?>
		</nav>

		<div id="page-wrapper">
			<div class="row">
				<br>
				
				<!--<div class="col-sm-6 text-center">
					<label class="label label-default">Obtenemos el número de contenedores total por entradas y por fechas</label>
					<div id="area-chart-entrada"></div>
				</div>
				<div class="col-sm-6 text-center">
					<label class="label label-default">Obtenemos el número de contenedores total por salidas y por fechas</label>
					<div id="area-chart-salida"></div>
				</div>
				<div class="col-sm-6 text-center">
					<label class="label label-success">Line Chart Entrada</label>
					<div id="line-chart-entrada"></div>
				</div>
				<div class="col-sm-6 text-center">
					<label class="label label-success">Line Chart Salida</label>
					<div id="line-chart-salida"></div>
				</div>-->
				<div class="col-sm-6 text-center">
					<h4><b>ENTRADA DE CONTENEDORES POR FECHA</b></h4>
					<div id="bar-chart-entrada"></div>
				</div>
				<div class="col-sm-6 text-center">
					<h4><b>SALIDA DE CONTENEDORES POR FECHA</b></h4>
					<div id="bar-chart-salida"></div>
				</div>
				<!-- <div class="col-sm-6 text-center">
					<label class="label label-success">Bar stacked Entrada</label>
					<div id="stacked-entrada"></div>
				</div>
				<div class="col-sm-6 text-center">
					<label class="label label-success">Bar stacked Salida</label>
					<div id="stacked-salida"></div>
				</div> -->
				<br>
				<!--<div class="col-sm-6 text-center">
					<h4><b>ENTRADA CONTENEDORES CCIS-BILBAO</b></h4>
					<div id="pie-chart-entrada-ccis-bilbao"></div>
				</div>
				<div class="col-sm-6 text-center">
					<h4><b>SALIDA CONTENEDORES CCIS-BILBAO</b></h4>
					<div id="pie-chart-salida-ccis-bilbao"></div>
				</div>
				<br>
				<div class="col-sm-6 text-center">
					<h4><b>ENTRADA CONTENEDORES SICSA-VALENCIA</b></h4>
					<div id="pie-chart-entrada-sicsa-valencia"></div>
				</div>
				<div class="col-sm-6 text-center">
					<h4><b>SALIDA CONTENEDORES SICSA-VALENCIA</b></h4>
					<div id="pie-chart-salida-sicsa-valencia"></div>
				</div>
				<br>
				<div class="col-sm-6 text-center">
					<h4><b>ENTRADA CONTENEDORES RENFE</b></h4>
					<div id="pie-chart-entrada-renfe"></div>
				</div>
				<div class="col-sm-6 text-center">
					<h4><b>SALIDA CONTENEDORES RENFE</b></h4>
					<div id="pie-chart-salida-renfe"></div>
				</div> -->
				<br>
				<div class="col-sm-6 text-center">
					<h4><b>ENTRADA CONTENEDORES TOTAL</b></h4>
					<div id="pie-chart-entrada"></div>
				</div>
				<div class="col-sm-6 text-center">
					<h4><b>SALIDA CONTENEDORES TOTAL</b></h4>
					<div id="pie-chart-salida"></div>
				</div>
			</div>
			<style></style>
		</div> <!-- page_wrapper -->
	</div> <!-- wrapper -->
</body>

</html>

<script>
	/*$(document).ready(function() {
		Morris.Area({
			element: 'area-chart-entrada',
			parseTime: false,
			data: <?php echo json_encode($num_contenedores_entrada); ?>,
			xkey: 'año_mes',
			ykeys: ['contenedor_tren', 'contenedor_camion'],
			labels: ['Nº Cont. Tren', 'Nº Cont. Camión'],
			behaveLikeLine: true,
			hideHover: 'auto',
			resize: true,
			redraw: true
		});
	});

	$(document).ready(function() {
		Morris.Area({
			element: 'area-chart-salida',
			parseTime: false,
			data: <?php echo json_encode($num_contenedores_salida); ?>,
			xkey: 'año_mes',
			ykeys: ['contenedor_tren', 'contenedor_camion'],
			labels: ['Nº Cont. Tren', 'Nº Cont. Camión'],
			behaveLikeLine: true,
			hideHover: 'auto',
			resize: true,
			redraw: true
		});
	});

	$(document).ready(function() {
		Morris.Line({
			element: 'line-chart-entrada',
			parseTime: false,
			data: <?php echo json_encode($num_contenedores_entrada); ?>,
			xkey: 'año_mes',
			ykeys: ['contenedor_tren', 'contenedor_camion'],
			labels: ['Nº Cont. Tren', 'Nº Cont. Camión'],
			hideHover: 'auto',
			resize: true,
			redraw: true
		});
	});

	$(document).ready(function() {
		Morris.Line({
			element: 'line-chart-salida',
			parseTime: false,
			data: <?php echo json_encode($num_contenedores_salida); ?>,
			xkey: 'año_mes',
			ykeys: ['contenedor_tren', 'contenedor_camion'],
			labels: ['Nº Cont. Tren', 'Nº Cont. Camión'],
			hideHover: 'auto',
			resize: true,
			redraw: true
		});
	});*/

	$(document).ready(function() {
		Morris.Bar({
			element: 'bar-chart-entrada',
			parseTime: false,
			data: <?php echo json_encode($num_contenedores_entrada); ?>,
			xkey: 'año_mes',
			ykeys: ['contenedor_tren', 'contenedor_camion', 'total_contenedores'],
			labels: ['Nº Cont. Tren', 'Nº Cont. Camión', 'Total Cont.'],
			barcolors: ['#003A5D', '#009FE3', '#8ABD24'],
			hideHover: 'auto',
			resize: true,
			redraw: true
		});
	});

	$(document).ready(function() {
		Morris.Bar({
			element: 'bar-chart-salida',
			parseTime: false,
			data: <?php echo json_encode($num_contenedores_salida); ?>,
			xkey: 'año_mes',
			ykeys: ['contenedor_tren', 'contenedor_camion', 'total_contenedores'],
			labels: ['Nº Cont. Camión', 'Nº Cont. Tren', 'Total Cont.'],
			barcolors: ['#003A5D', '#009FE3', '#E83F4B'],
			hideHover: 'auto',
			resize: true,
			redraw: true
		});
	});

	/*$(document).ready(function() {
		Morris.Bar({
			element: 'stacked-entrada',
			parseTime: false,
			data: <?php echo json_encode($num_contenedores_entrada); ?>,
			xkey: 'año_mes',
			ykeys: ['contenedor_tren', 'contenedor_camion', 'total_contenedores'],
			labels: ['Nº Cont. Camión', 'Nº Cont. Tren', 'Total Cont.'],
			stacked: true,
			hideHover: 'auto',
			resize: true,
			redraw: true
		});
	});

	$(document).ready(function() {
		Morris.Bar({
			element: 'stacked-salida',
			parseTime: false,
			data: <?php echo json_encode($num_contenedores_salida); ?>,
			xkey: 'año_mes',
			ykeys: ['contenedor_tren', 'contenedor_camion', 'total_contenedores'],
			labels: ['Nº Cont. Camión', 'Nº Cont. Tren', 'Total Cont.'],
			stacked: true,
			hideHover: 'auto',
			resize: true,
			redraw: true
		});
	});*/

	$(document).ready(function() {
		Morris.Donut({
			element: 'pie-chart-entrada',
			data: <?php echo json_encode($datos_donut_chart_entrada); ?>,
			labels: ['Nº Cont. Camión', 'Nº Cont. Tren'],
			colors:['#003A5D', '#009fe3'],
			hideHover: 'auto',
			resize: true,
			redraw: true
			
		});
	});

	$(document).ready(function() {
		Morris.Donut({
			element: 'pie-chart-salida',
			data: <?php echo json_encode($datos_donut_chart_salida); ?>,
			labels: ['Nº Cont. Camión', 'Nº Cont. Tren'],
			colors:['#003A5D', '#009fe3'],
			hideHover: 'auto',
			resize: true,
			redraw: true
			
		});
	});
</script>