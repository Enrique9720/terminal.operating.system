<!DOCTYPE html>

<html lang="es">

<head>
	<title>Salida de Tren</title>
	<?php
		//Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
		require_once('../tpl/header_includes.php');
	?>
	<style>
    .select2 {
      width:100%!important;
    }
  </style>

	<!-- Custom Functions JavaScript -->
	<script src="../functions/salida_tren_functions.js"></script>

  <script>

		var num_contenedores = 0;

		$(document).ready(function() {
			//Cargamos citas de carga pendientes en el desplegable
			getCitascargaPendientes();

			$('#citas_carga_pendientes_combo').change(function() {

					//Cogemos id_cita_carga elegida en el desplegable
					var id_cita_carga = document.getElementById("citas_carga_pendientes_combo").value;
					//console.log(id_cita_descarga);

					//Cargamos contenedores pedidos en tabla inferior
					getcontenedorespedidos();

					//Calculamos el numero de contenedores que se ha hecho picking en tabla superior
					num_contenedores = 0;
					$("#num_contenedores").text(num_contenedores);

					//cargamos select2 de contenedores pedidos en la cita de carga
					load_ajax_select2("#num_contenedor", "Seleccione Contenedor", "../ajax/get_contenedores_salida_pedidos_list.php?id_cita_carga="+id_cita_carga);

					//cargamos select2 de nº de vagon usados en la entradas tren
      		load_select2_customtags("#num_vagon", "Escriba Vagón", "../ajax/get_vagones_list.php");

					//Habilitamos el boton de añadir linea
					$("#add_linea").prop("disabled",false);

					//resetar inputs al cambiar cita
					$('#pos_vagon').val('');
					$("#num_vagon").val('').trigger('change');
					$('#pos_contenedor').val('');
					$("#num_contenedor").val('').trigger('change');
					$('#id_tipo_contenedor_iso').val('');
					//$('#nombre_comercial_propietario').val('');
					$('#descripcion_mercancia').val('');

  				/////////////////////////////reloadLineasSalida/////////////////////////////
					//reiniciamos la tabla
					$('#table_contenedores_salida').dataTable().fnClearTable();
					//cargamos datos via ajax
					$.ajax({
  					type: "POST",
  					url: "../ajax/get_contenedores_cita_carga_temp.php",
						data: {'id_cita_carga': id_cita_carga,},
  					success: function(response){
							var obj = $.parseJSON(response);
							if(obj.length > 0){
								jQuery(obj).each(function(i, resp) {

									if(resp.num_contenedor == null){
										resp.num_contenedor = 'NO-CON';
										operacion = "<button id='"+resp.id_linea_carga+"' class='remove btn-danger no-con'><span class='glyphicon glyphicon-trash'></span></button>"
									}else{
										operacion = "<button id='"+resp.id_linea_carga+"' class='remove btn-danger'><span class='glyphicon glyphicon-trash'></span></button>"
										//calculamos el numero de contenedores que se ha hecho picking en tabla superior

										num_contenedores = num_contenedores+1;
										//console.log(num_contenedores);
										$("#num_contenedores").text(num_contenedores);
									}

									var item = {
										pos_vagon : resp.pos_vagon_temp,
										num_vagon : resp.num_vagon_temp,
										pos_contenedor : resp.pos_contenedor_temp,
										num_contenedor: resp.num_contenedor,
										id_tipo_contenedor_iso: resp.id_tipo_contenedor_iso,
										descripcion_mercancia: resp.descripcion_mercancia,
										operacion: operacion
									};
									table_contenedores_salida.row.add( item );
									table_contenedores_salida.draw(false);
  						})

						}

  					},
  					error: function(){
  						alert("failure");
  					}
  				});
					///////////////////////////////////////////////////////////////////////////

			});

		});
</script>

	<script>
			///////////////////Obtener datos contenedor en Inputs//////////////
			$(document).ready(function() {
				$('#num_contenedor').change(function(){
					num_contenedor = $('#num_contenedor').find(":selected").text();
					console.log(num_contenedor);
					$.ajax({
							 type: "POST",
							 url: "../ajax/get_contenedor.php",
							 data: {
								 num_cont_1 : num_contenedor
							 },
							 success: function(returned) {
									 var obj = $.parseJSON(returned);
									 jQuery(obj).each(function(i, item) {
										 text = item.text;
										 if (text != 'No hay resultados') {
											 id = item.id;
											 id_tipo_contenedor_iso = item.id_tipo_contenedor_iso;
											 nombre_comercial_propietario = item.nombre_comercial_propietario;
											 descripcion_mercancia = item.descripcion_mercancia;
											 $("#id_tipo_contenedor_iso").val(id_tipo_contenedor_iso);
											 //$("#nombre_comercial_propietario").val(nombre_comercial_propietario);
											 $("#descripcion_mercancia").val(descripcion_mercancia);
										 }else {
											 //alert(text);
											 $("#id_tipo_contenedor_iso").val('');
											 //$("#nombre_comercial_propietario").val('');
											 $("#descripcion_mercancia").val('');
										 }
									 })
							 },
							 error: function() {
								 alert("failure");
							 }
						 });
				});
			});
			//////////////////////////////////////////////////////////////////////////
	</script>

	<script>
			/////////////////////////////deleteLineaSalida////////////////////////////
			$(document).ready(function() {
					$('#table_contenedores_salida').on('click', '.remove', function () {

						var id_cita_carga = document.getElementById("citas_carga_pendientes_combo").value;
						table_contenedores_salida.row($(this).parents('tr')).remove().draw();

						//Eliminar palet de la tabla temporal via ajax
					 /**********************************************/
					 	has_class_no_cont = $(this).hasClass("no-con");
						$.ajax({
						 type: "POST",
						 url: "../ajax/contenedor_salida_temp_delete.php",
						 data: {
							 'id_linea_carga': this.id,
							 'id_cita_carga': id_cita_carga,
						 },
						 cache: false,
						 success: function(returned){
							 var obj = $.parseJSON(returned);
							 jQuery(obj).each(function(i, item){
								 //text = item.text;
								 id = item.num_contenedor;
								 //calculamos el numero de contenedores que se ha hecho picking en tabla superior
								if(has_class_no_cont == false){ // si no tiene la clase no-cont, entonces es un contenedor
									num_contenedores = num_contenedores-1;
									$("#num_contenedores").text(num_contenedores);
								}
							 })
							 //recargamos tabla con lista de picking
							 getcontenedorespedidos();
						 },
						 async: false,
						 error: function(){
							 alert("failure");
						 }
					 });
					});
			});
			///////////////////////////////////////////////////////////////////////////
	</script>

	<script>
			/////////////////////Inicialización Tablas Datatables//////////////////////
			$(document).ready(function() {
				table_contenedores_salida = $('#table_contenedores_salida').DataTable({
					columns: [
						{ data: 'pos_vagon' },
						{ data: 'num_vagon' },
						{ data: 'pos_contenedor' },
						{ data: 'num_contenedor' },
						{ data: 'operacion' },
					],
					ordering: true,
					order: [
						[0, 'asc'], [2, 'asc']
					],
					//scrollX: true,
					autoWidth: false,
					iDisplayLength: -1,
					//scrollY: '10vh',
					bPaginate: false,
					bFilter: false,
					bInfo: false,
					bScrollCollapse: true
				});

				table_contenedores_lineas_carga = $('#table_contenedores_lineas_carga').DataTable({
					columns: [
						{ data: 'num_contenedor' },
						{ data: 'id_tipo_contenedor_iso' },
						{ data: 'descripcion_mercancia' },
						{ data: 'nombre_comercial_propietario' },
						{ data: 'picking_check',
							'visible': false
						},
						{ data: 'stock_check',
							'visible': false
						},
					],
					createdRow: function ( row, data, index ) {
						//console.log(data);
						if ( data['stock_check'] == "0" ) {
							$(row).addClass('danger');
						}else if ( data['picking_check'] != null ) {
							$(row).addClass('successclass');
						}else if(data['picking_check'] == null){
							$(row).addClass('warningclass');
						}
					},
					ordering: true,
					order: [[0, 'asc']],
					autoWidth: false,
					iDisplayLength: -1,
					//scrollY: '10vh',
					bPaginate: false,
					bFilter: false,
					bInfo: false,
					bScrollCollapse: true
				});
			});
			///////////////////////////////////////////////////////////////////////////
	</script>


	<style>
			tr { /*height: 50px;*/ }

		   .configuracion-palets {
				display: table;
			}
			.configuracion-palets tr {
				display: table-cell;
			}
			.configuracion-palets tr td {
				display: block;
			}

			.close-modal{
		       visibility: hidden;
		   }
			.salida-item{
				padding-right: 5px;
				padding-left: 5px;
				padding-top: 5px;
				padding-bottom: 5px;
			}

		.successclass{
			background-color: #5cb85c78;
		}
		.warningclass{
			background-color: #f0ad4e73;
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

			<div class="row">
	      <div class="col-md-12" style="margin-top:20px;">
	        <div class="control-group">
	          <div class="form-group floating-label-form-group controls mb-0 pb-2">
	            <select class="form-control" id="citas_carga_pendientes_combo">
	              <option value="-1" disabled selected>Seleccione n&ordm; de expedición</option>
	            </select>
	          </div>
	        </div>
	      </div>
	    </div>

			<div class="row">
	      <div class="col-md-12" style="padding:5px;">
	          <table id="table_contenedores_salida" class="table table-striped table-bordered" style="font-size: 12px;">
	            <thead>
	              <tr>
									<th class="info">Pos. V</th>
									<th class="info">Vagón</th>
									<th class="warning">Pos. C</th>
									<th class="warning">Contenedor</th>
									<th class="warning"></th>
	              </tr>
	            </thead>
	          </table>
	      </div>
	      <!-- /.col-lg-12 -->
	      <center>
	        <h4><span class="label label-primary">Contenedores Salida: <span id="num_contenedores"></span>/<span id="num_contenedores_total"></span></span></h4>
					<p id="error" class="label label-danger"></p>
	      </center>
	    </div>

			<div class="row" style="background:#00FF00; padding-top:0px; padding-bottom:0px;">
				<div class="col-xs-3 col-md-3 salida-item">
					<label>Pos. V:</label>
					<input type="number" class="form-control" id="pos_vagon" min="1" style="width: 100%; height: 35px;" required>
				</div>

				<div class="col-xs-9 col-md-9 salida-item">
					<label>Nº Vagón:</label>
					<select class="form-control select_2" id="num_vagon" name="num_vagon" required></select>
				</div>
			</div>

			<div class="row" style="background:#00FF00; padding-top:0px; padding-bottom:0px;">
				<div class="col-xs-3 col-md-3 salida-item">
					<label>Pos. C:</label>
					<input type="number" class="form-control" id="pos_contenedor" min="1" style="width: 100%; height: 35px;" required>
				</div>

			  <div class="col-xs-9 col-md-9 salida-item">
					<label>Nº Contenedor:</label>
					<select class="form-control select_2" id="num_contenedor" name="num_contenedor" required></select>
				</div>
			</div>

			<div class="row" style="background:#00FF00; padding-top:0px; padding-bottom:0px;">
				<div class="col-xs-6 col-md-6 salida-item">
					<input type="text" class="form-control" id="id_tipo_contenedor_iso" placeholder="Tipo Contenedor" style="width: 100%; height: 35px;" readonly>
				</div>
				<div class="col-xs-6 col-md-6 salida-item">
					<input type="text" class="form-control" id="descripcion_mercancia" placeholder="Mercancía" style="width: 100%; height: 35px;" readonly>
				</div>
			</div>

			<div class="row" style="background:#00FF00; padding-top:0px; padding-bottom:10px;">
				<div class="col-xs-12 col-md-12">
					<div style="height:20px"></div>
					<button id="add_linea" class="btn btn-primary" onclick="addLineaSalida()" disabled>A&ntilde;adir Contenedor</button>
				</div>
			</div>

	    <div class="row">
				<div class="col-xs-12 col-md-12" style="background:#ddd;">
	        <div class="form-row" style="padding:12px;">
	          <center><button id="validarSalidaButton" class="btn btn-success" onclick="validarsalida()" disabled>Validar Salida</button></center>
	        </div>
	      </div>
	    </div>

			<div class="row">
	      <div class="col-md-12" style="padding:5px;">
	          <table id="table_contenedores_lineas_carga" class="table table-bordered" style="font-size: 11px;">
	            <thead>
	              <tr>
	                <th>Contenedor</th>
									<th>Tipo</th>
									<th>Mercancía</th>
									<th>Propietario</th>
									<th>picking_check</th>
									<th>stock_check</th>
	              </tr>
	            </thead>
	          </table>
	      </div>
	    </div>

	  </div>
	  <!-- /#wrapper -->


	</div>


</body>
</html>
