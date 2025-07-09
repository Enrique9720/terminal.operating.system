<!DOCTYPE html>
<html lang="es">

<head>
  <title>Entrada de mercanc&iacute;a</title>
  <?php
  //Plantilla con los inludes de las librerias y CSS usados por todas las paginas de la APP
  require_once('../tpl/header_includes.php');
  ?>
  <style>
    table {
      font-size: 12px;
    }
  </style>
  <!-- Custom Functions JavaScript -->
  <script src="../functions/entrada_tren_functions.js"></script>
  <script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
  <script>
    var ExcelToJSON = function() {
      this.parseExcel = function(file) {
        var reader = new FileReader();
        reader.onload = function(e) {
          //cargamos contenido excel en binario
          var data = e.target.result;
          //console.log(data);
          //descodificamos el excel
          var workbook = XLSX.read(data, {
            type: 'binary',
            cellDates: true, //activamos las celdas de fechas en la importacion desde excel
            dateNF: 'yyyy-mm-dd' //importamos las fechas del excel en el formato para MySQL
          });
          //console.log(workbook);

          //leemos la primera hoja y pasamos datos a objeto
          var XL_row_object1 = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]], {
            header: 3, //activamos la opcion de leer los encabezados de la primera fila
            raw: false,
            blankrows: true, //activamos las casillas vacias o en blanco
            defval: '' //para las casillas vacias, el valor por defecto sera cadena vacia en vez de null
          });
          //console.log(XL_row_object1);

          //pasamos objeto a JSON, esta variable sera la que contiene los datos que importaremos a la BBDD
          var data_entrada_tren = JSON.parse(JSON.stringify(XL_row_object1));
          //console.log(data_entrada_tren);

          //var rows = $('#table_entrada_tren tbody');
          //console.log(rows);

          //vaciamos tabla por si hubiera datos anteriores
          table_entrada_tren0.clear().draw();
          table_entrada_tren.clear().draw();
          $('#validarEntradaButton').prop('disabled', true);
          //encabezados de fecha expedicion y numero expedicion
          encabezados1 = Object.values(data_entrada_tren[0]);
          //console.log(encabezados1);
          //encabezados del pie de tren
          encabezados = Object.values(data_entrada_tren[2]);
          //console.log(encabezados);

          num_expedicion_select = $('#citas_descarga_pendientes_combo').find(":selected").text().split("(")[0].trim();
          //console.log(num_expedicion_select);
          fecha_expedicion_select = $('#citas_descarga_pendientes_combo').find(":selected").text().split("(")[1].replace(")", "").replace(" ", "");
          //console.log(fecha_expedicion_select);
          nombre_comercial_propietario_select = $('#citas_descarga_pendientes_combo').find(":selected").text().split("(")[2].replace(")", "");
          //console.log(nombre_comercial_propietario_select);

          encabezados_ok = true; //inicializamos primer check
          num_expedicion_ok = true; //inicializamos segundo check
          fecha_expedicion_ok = true; //inicializamos tercer check
          num_contenedor_ok = true; //inicializamos cuarto check
          nombre_comercial_propietario_ok = true; //inicializamos quinto check
          vacio_cargado_ok = true; //inicializamos sexto check
          //mercancia_peligrosa_ok = true; //inicializamos septimo
          tipo_contenedor_iso_ok = true; //inicializamos octavo
          tara_contenedor_ok = true; //inicializamos octavo
          peso_bruto_contenedor_ok = true; //inicializamos noveno y ultimo check
          temperatura_contenedor_ok = true; //inicializamos decimo y ultimo check
          num_peligro_adr_ok = true; //inicializamos undecimo y ultimo check
          num_onu_adr_ok = true; //inicializamos duodecimo y ultimo check
          num_clase_adr_ok = true; //inicializamos treceavo y ultimo check
          cod_grupo_embalaje_adr_ok = true; //inicializamos catorceavo y ultimo check
          destinatario_ok = true; //inicializamos quinceavo y ultimo check

          //PRIMER CHECK DE IMPORTACION: comprobamos cabeceras
          if (
            encabezados1[0] == 'FECHA EXPEDICION' &&
            encabezados1[1] == 'Nº EXPEDICION' &&
            encabezados[0] == 'Nº DE VAGON' &&
            encabezados[1] == 'POS. VAGON' &&
            encabezados[2] == 'POS. CONTENEDOR' &&
            encabezados[3] == 'Nº CONTENEDOR' &&
            encabezados[4] == 'TIPO (ISO)' &&
            encabezados[5] == 'TARA (Kg)' &&
            encabezados[6] == 'V/C' &&
            encabezados[7] == 'PESO BRUTO (Kg)' &&
            encabezados[8] == 'TEMPERATURA (ºC)' &&
            encabezados[9] == 'PROPIETARIO' &&
            encabezados[10] == 'Nº PELIGRO' &&
            encabezados[11] == 'Nº ONU' &&
            encabezados[12] == 'CLASE' &&
            encabezados[13] == 'GRUPO EMBALAJE' &&
            encabezados[14] == 'DESTINATARIO'
          ) {
            //sacamos el valor de la fecha expedicion
            fecha_expedicion_fila = Object.values(data_entrada_tren[1])[0];
            //console.log(fecha_expedicion_fila);
            //sacamos el valor de numero expedicion
            num_expedicion_fila = Object.values(data_entrada_tren[1])[1];
            //console.log(num_expedicion_fila);

            clase_td_fecha_expedicion = 'success'; //se inicializan las clases de los td a succes hasta que haya un error o warning y se cambiara el valor a danger o warning
            clase_td_num_expedicion = 'success';
            clase_td_mensaje_error = 'success';
            mensaje_error_0 = '';

            //SEGUNDO CHECK DE IMPORTACION: comprobamos Nº expedicion
            if (num_expedicion_fila != num_expedicion_select) {
              clase_td_num_expedicion = "danger";
              clase_td_mensaje_error = 'danger';
              mensaje_error_0 = "Nº Expedicion no coincide con " + num_expedicion_select + ".<br/>";
              num_expedicion_ok = false;
            }

            //TERCER CHECK DE IMPORTACION: comprobamos fecha expedicion
            if (fecha_expedicion_fila != fecha_expedicion_select) {
              clase_td_fecha_expedicion = "danger";
              clase_td_mensaje_error = 'danger';
              mensaje_error_0 = mensaje_error_0 + "Fecha Expedición no coincide con " + fecha_expedicion_select + ".<br/>";
              fecha_expedicion_ok = false;
            }

            //Creamos array con los datos para la tabla
            var item0 = {
              fecha_expedicion: fecha_expedicion_fila,
              num_expedicion: num_expedicion_fila,
              mensaje_error: mensaje_error_0,
              clase_td_fecha_expedicion: clase_td_fecha_expedicion,
              clase_td_num_expedicion: clase_td_num_expedicion,
              clase_td_mensaje_error: clase_td_mensaje_error,
            };

            //Añadimos la fila con los datos en la tabla
            table_entrada_tren0.row.add(item0);
            table_entrada_tren0.rows().invalidate().draw(false);

            //Recorremos el objeto con los datos del excel para la tabla principal
            for (i = 3; i < data_entrada_tren.length; i++) {

              var columns = Object.values(data_entrada_tren[i]);

              if (
                (columns[0].trim() != '') && //Nº VAGON
                (columns[1].trim() != '') && //POS VAGON
                (columns[9].trim() != '') //PROPIETARIO
              ) { //INICIO IF fila vacia

                //sacamos datos del excel fila a fila, columna a columna
                num_vagon_fila = columns[0];
                pos_vagon_fila = columns[1];
                pos_contenedor_fila = columns[2];
                num_contenedor_fila = columns[3].toUpperCase(); //convertimos Nº de contenedor a mayusculas
                columns[3] = num_contenedor_fila; //guardamos Nº contenedor en mayusculas en el array de datos
                tipo_contenedor_iso_fila = columns[4].toUpperCase(); //convertimos tipo contenedor iso a mayusculas
                columns[4] = tipo_contenedor_iso_fila; //guardamos tipo contenedor iso en mayusculas en el array de datos
                tara_contenedor_fila = columns[5];
                tara_contenedor_fila = tara_contenedor_fila.split(".").join("");
                tara_contenedor_fila = tara_contenedor_fila.split(",").join("");
                columns[5] = tara_contenedor_fila;
                vacio_cargado_contenedor_fila = columns[6].toUpperCase(); //convertimos Nº de contenedor a mayusculas
                columns[6] = vacio_cargado_contenedor_fila; //guardamos V/C en mayusculas en el array de datos

                peso_bruto_contenedor_fila = columns[7];
                peso_bruto_contenedor_fila = peso_bruto_contenedor_fila.split(".").join("");
                peso_bruto_contenedor_fila = peso_bruto_contenedor_fila.split(",").join("");
                columns[7] = peso_bruto_contenedor_fila;

                temperatura_contenedor_fila = columns[8];
                nombre_comercial_propietario_fila = columns[9].toUpperCase();
                columns[9] = nombre_comercial_propietario_fila;

                num_peligro_adr_fila = columns[10];
                num_onu_adr_fila = columns[11];
                num_clase_adr_fila = columns[12];
                cod_grupo_embalaje_adr_fila = columns[13];

                destinatario_fila = columns[14].toUpperCase();
                columns[14] = destinatario_fila;

                mensaje_error = ''; //inicializamos el mensaje de error

                clase_td_num_vagon = 'success'; //se inicializan las clases de los td a succes hasta que haya un error o warning y se cambiara el valor a danger o warning
                clase_td_pos_vagon = 'success';
                clase_td_pos_contenedor = 'success';
                clase_td_num_contenedor = 'success';
                clase_td_tipo_contenedor_iso = 'success';
                clase_td_tara_contenedor = 'success';
                clase_td_vacio_cargado = 'success';
                clase_td_peso_bruto_contenedor = 'success';
                clase_td_temperatura_contenedor = 'success';
                clase_td_nombre_comercial_propietario = 'success';
                clase_td_num_peligro_adr = 'success';
                clase_td_num_onu_adr = 'success';
                clase_td_num_clase_adr = 'success';
                clase_td_cod_grupo_embalaje_adr = 'success';
                clase_td_destinatario = 'success';
                clase_td_mensaje_error = 'success';

                //CUARTO CHECK DE IMPORTACION: comprobamos Nº Contenedor
                //Limpiamos el numero de contenedor de caracteres "-" y "."
                if ((num_contenedor_fila.includes("-") == true) || (num_contenedor_fila.includes(".") == true)) {
                  mensaje_error = mensaje_error + "Nº Contenedor " + num_contenedor_fila + " corregido.<br/>";
                  num_contenedor_fila = num_contenedor_fila.split("-").join("");
                  num_contenedor_fila = num_contenedor_fila.split(".").join("");
                  clase_td_mensaje_error = "warning";
                  columns[5] = num_contenedor_fila;
                }

                if (num_contenedor_fila.length == 11 && num_contenedor_fila.match(/^[a-zA-Z]{3}U\d{7}$/)) {

                  $.ajax({
                    url: "../ajax/contenedor_en_stock.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                      num_contenedor: num_contenedor_fila
                    },
                    cache: false,
                    success: function(result) {
                      text = result.text;
                      if (text != 'no existe') { //si el contenedor esta en stock
                        clase_td_num_contenedor = "danger";
                        clase_td_mensaje_error = "danger";
                        mensaje_error = mensaje_error + "Contenedor " + num_contenedor_fila + " en stock.<br/>";
                        num_contenedor_ok = false;
                      }
                    },
                    async: false,
                    error: function(result) {
                      console.log("error: " + JSON.stringify(result));
                      alert("ERROR: hubo algún fallo");
                    }
                  });

                } else if (num_contenedor_fila.length == 0) {
                  clase_td_num_contenedor = "success";
                } else {
                  clase_td_num_contenedor = "danger";
                  clase_td_mensaje_error = "danger";
                  mensaje_error = mensaje_error + "Nº Contenedor incorrecto.<br/>";
                  num_contenedor_ok = false;
                }

                //QUINTO CHECK DE IMPORTACION: comprobamos Propietario

                if ((nombre_comercial_propietario_fila != nombre_comercial_propietario_select) || nombre_comercial_propietario_fila == '') {
                  clase_td_nombre_comercial_propietario = "danger";
                  clase_td_mensaje_error = 'danger';
                  mensaje_error = mensaje_error + "Propietario no coincide con " + nombre_comercial_propietario_select + ".<br/>";
                  nombre_comercial_propietario_ok = false;
                }

                //SEXTO CHECK DE IMPORTACION: comprobamos V/C
                if (
                  (num_contenedor_fila.length != 0) &&
                  (
                    (vacio_cargado_contenedor_fila != 'V') &&
                    (vacio_cargado_contenedor_fila != 'C')
                  )
                ) {
                  clase_td_vacio_cargado = "danger";
                  clase_td_mensaje_error = 'danger';
                  mensaje_error = mensaje_error + "Error campo V/C.<br/>";
                  vacio_cargado_ok = false;
                }


                //SEPTIMO CHECK DE IMPORTACION: comprobamos tipo Contenedor ISO
                //Limpiamos el tipo de contenedor del caracter comilla simple
                if ((tipo_contenedor_iso_fila.includes("'") == true)) {
                  tipo_contenedor_iso_fila = tipo_contenedor_iso_fila.split("'").join("");
                  columns[6] = tipo_contenedor_iso_fila;
                }
                //comprobamos que el tipo_contenedor_iso exista en BBDD
                $.ajax({
                  url: "../ajax/check_tipo_contenedor_iso.php",
                  type: "POST",
                  dataType: "json",
                  data: {
                    id_tipo_contenedor_iso: tipo_contenedor_iso_fila
                  },
                  cache: false,
                  success: function(result) {
                    text = result.text;
                    if (text == 'no existe' && (num_contenedor_fila.length != 0)) { //si el tipo contenedor no existe, danger
                      clase_td_tipo_contenedor_iso = "danger";
                      clase_td_mensaje_error = "danger";
                      mensaje_error = mensaje_error + "Tipo Contenedor No existe.<br/>";
                      tipo_contenedor_iso_ok = false;
                    }
                  },
                  async: false,
                  error: function(result) {
                    console.log("error: " + JSON.stringify(result));
                    alert("ERROR: hubo algún fallo");
                  }
                });

                //SEPTIMO B CHECK DE IMPORTACION: comprobamos tara contenedor
                if (tara_contenedor_fila != '') {
                  if ((tara_contenedor_fila < 1400) || (tara_contenedor_fila > 10000)) {
                    clase_td_tara_contenedor = "danger";
                    clase_td_mensaje_error = "danger";
                    mensaje_error = mensaje_error + "Tara erronea.<br/>";
                    tara_contenedor_ok = false;
                  }
                }

                //NOVENO CHECK DE IMPORTACION: comprobamos peso bruto contenedor
                if (vacio_cargado_contenedor_fila == 'C') { //si esta cargado
                  if ((peso_bruto_contenedor_fila < 1500)) {
                    clase_td_peso_bruto_contenedor = "danger";
                    clase_td_mensaje_error = "danger";
                    mensaje_error = mensaje_error + "Peso Bruto bajo para cargado.<br/>";
                    peso_bruto_contenedor_ok = false;
                  } else if ((peso_bruto_contenedor_fila > 35000)) {
                    clase_td_peso_bruto_contenedor = "danger";
                    clase_td_mensaje_error = "danger";
                    mensaje_error = mensaje_error + "Peso Bruto excesivo para cargado.<br/>";
                    peso_bruto_contenedor_ok = false;
                  }
                } else if (vacio_cargado_contenedor_fila == 'V') { //si esta vacio
                  if ((peso_bruto_contenedor_fila > 6500)) {
                    clase_td_peso_bruto_contenedor = "danger";
                    clase_td_mensaje_error = "danger";
                    mensaje_error = mensaje_error + "Peso Bruto excesivo para vacío.<br/>";
                    peso_bruto_contenedor_ok = false;
                  } else if (peso_bruto_contenedor_fila < 1500) {
                    clase_td_peso_bruto_contenedor = "danger";
                    clase_td_mensaje_error = "danger";
                    mensaje_error = mensaje_error + "Peso Bruto bajo para vacío.<br/>";
                    peso_bruto_contenedor_ok = false;
                  }
                }

                //DECIMO CHECK DE IMPORTACION: comprobamos temperatura
                if (temperatura_contenedor_fila != '') {
                  if ((temperatura_contenedor_fila < -60) || (temperatura_contenedor_fila > 30)) {
                    clase_td_temperatura_contenedor = "danger";
                    clase_td_mensaje_error = "danger";
                    mensaje_error = mensaje_error + "Temperatura Contenedor erronea.<br/>";
                    temperatura_contenedor_ok = false;
                  }
                }
                //UNDECIMO CHECK DE IMPORTACION: comprobamos Nº Peligro
                //comprobamos que el num_peligro_adr exista en BBDD
                if (num_peligro_adr_fila != '') {
                  $.ajax({
                    type: "POST",
                    url: "../ajax/get_adr_num_peligro.php",
                    //dataType: "json",
                    cache: false,
                    data: {
                      num_peligro_adr: num_peligro_adr_fila
                    },
                    success: function(returned) {
                      var obj = $.parseJSON(returned);
                      jQuery(obj).each(function(i, item) {
                        text = item.text;
                        if (text == 'No hay resultados') { //si el tipo contenedor no existe, danger
                          clase_td_num_peligro_adr = "danger";
                          clase_td_mensaje_error = "danger";
                          mensaje_error = mensaje_error + "Nº Peligro ADR No existe.<br/>";
                          num_peligro_adr_ok = false;
                        }
                      })
                    },
                    async: false,
                    error: function() {
                      alert("failure");
                    }
                  });
                }

                //DUODECIMO CHECK DE IMPORTACION: comprobamos Nº ONU
                //comprobamos que el num_onu_adr exista en BBDD
                if (num_onu_adr_fila != '') {
                  $.ajax({
                    type: "POST",
                    url: "../ajax/get_adr_onu.php",
                    //dataType: "json",
                    cache: false,
                    data: {
                      num_onu_adr: num_onu_adr_fila
                    },
                    success: function(returned) {
                      var obj = $.parseJSON(returned);
                      jQuery(obj).each(function(i, item) {
                        text = item.text;
                        if (text == 'No hay resultados') { //si el tipo contenedor no existe, danger
                          clase_td_num_onu_adr = "danger";
                          clase_td_mensaje_error = "danger";
                          mensaje_error = mensaje_error + "Nº ONU ADR No existe.<br/>";
                          num_onu_adr_ok = false;
                        }
                      })
                    },
                    async: false,
                    error: function() {
                      alert("failure");
                    }
                  });
                }

                //TRECEAVO CHECK DE IMPORTACION: comprobamos Clase ADR
                //comprobamos que el num_onu_adr exista en BBDD
                if (num_clase_adr_fila != '') {
                  $.ajax({
                    type: "POST",
                    url: "../ajax/get_adr_clase.php",
                    //dataType: "json",
                    cache: false,
                    data: {
                      num_clase_adr: num_clase_adr_fila
                    },
                    success: function(returned) {
                      var obj = $.parseJSON(returned);
                      jQuery(obj).each(function(i, item) {
                        text = item.text;
                        if (text == 'No hay resultados') { //si el tipo contenedor no existe, danger
                          clase_td_num_clase_adr = "danger";
                          clase_td_mensaje_error = "danger";
                          mensaje_error = mensaje_error + "Nº Clase ADR No existe.<br/>";
                          num_clase_adr_ok = false;
                        }
                      })
                    },
                    async: false,
                    error: function() {
                      alert("failure");
                    }
                  });
                }

                //CATORCEAVO CHECK DE IMPORTACION: comprobamos Clase ADR
                //comprobamos que el num_onu_adr exista en BBDD
                if (cod_grupo_embalaje_adr_fila != '') {
                  $.ajax({
                    type: "POST",
                    url: "../ajax/get_adr_grupo_embalaje.php",
                    //dataType: "json",
                    cache: false,
                    data: {
                      cod_grupo_embalaje_adr: cod_grupo_embalaje_adr_fila
                    },
                    success: function(returned) {
                      var obj = $.parseJSON(returned);
                      jQuery(obj).each(function(i, item) {
                        text = item.text;
                        if (text == 'No hay resultados') { //si el tipo contenedor no existe, danger
                          clase_td_cod_grupo_embalaje_adr = "danger";
                          clase_td_mensaje_error = "danger";
                          mensaje_error = mensaje_error + "Nº Grupo Embalaje ADR No existe.<br/>";
                          cod_grupo_embalaje_adr_ok = false;
                        }
                      })
                    },
                    async: false,
                    error: function() {
                      alert("failure");
                    }
                  });
                }

                //QUINCEAVO CHECK DE IMPORTACION: comprobamos destinatario no sean numeros
                //comprobamos que el num_onu_adr exista en BBDD
                if (destinatario_fila != '') {
                  if (destinatario_fila.match(/^[0-9]+$/)) {
                    clase_td_destinatario = "danger";
                    clase_td_mensaje_error = "danger";
                    mensaje_error = mensaje_error + "Destintario no es un nombre.<br/>";
                    destinatario_ok = false;
                  }
                }

                var item = {
                  num_vagon: num_vagon_fila,
                  pos_vagon: pos_vagon_fila,
                  pos_contenedor: pos_contenedor_fila,
                  num_contenedor: num_contenedor_fila,
                  tipo_contenedor_iso: tipo_contenedor_iso_fila,
                  tara_contenedor: tara_contenedor_fila,
                  vacio_cargado_contenedor: vacio_cargado_contenedor_fila,
                  peso_bruto_contenedor: peso_bruto_contenedor_fila,
                  temperatura_contenedor: temperatura_contenedor_fila,
                  nombre_comercial_propietario: nombre_comercial_propietario_fila,
                  num_peligro_adr: num_peligro_adr_fila,
                  num_onu_adr: num_onu_adr_fila,
                  num_clase_adr: num_clase_adr_fila,
                  cod_grupo_embalaje_adr: cod_grupo_embalaje_adr_fila,
                  destinatario: destinatario_fila,
                  mensaje_error: mensaje_error,
                  clase_td_num_vagon: clase_td_num_vagon,
                  clase_td_pos_vagon: clase_td_pos_vagon,
                  clase_td_pos_contenedor: clase_td_pos_contenedor,
                  clase_td_num_contenedor: clase_td_num_contenedor,
                  clase_td_tipo_contenedor_iso: clase_td_tipo_contenedor_iso,
                  clase_td_tara_contenedor: clase_td_tara_contenedor,
                  clase_td_vacio_cargado: clase_td_vacio_cargado,
                  clase_td_peso_bruto_contenedor: clase_td_peso_bruto_contenedor,
                  clase_td_temperatura_contenedor: clase_td_temperatura_contenedor,
                  clase_td_nombre_comercial_propietario: clase_td_nombre_comercial_propietario,
                  clase_td_num_peligro_adr: clase_td_num_peligro_adr,
                  clase_td_num_onu_adr: clase_td_num_onu_adr,
                  clase_td_num_clase_adr: clase_td_num_clase_adr,
                  clase_td_cod_grupo_embalaje_adr: clase_td_cod_grupo_embalaje_adr,
                  clase_td_destinatario: clase_td_destinatario,
                  clase_td_mensaje_error: clase_td_mensaje_error,
                };
                //console.log("item");
                //console.log(item);
                table_entrada_tren.row.add(item);
                table_entrada_tren.rows().invalidate().draw(false);


              } //FIN IF fila vacia

            } //FIN FOREACH


          } else {
            alert("Fichero excel Importación NO VÁLIDO. Revise columnas y su orden");
            encabezados_ok = false;
          }

          //console.log("encabezados_ok: "+encabezados_ok);
          //console.log("num_expedicion_ok: "+num_expedicion_ok);
          //console.log("fecha_expedicion_ok: "+fecha_expedicion_ok);
          //console.log("num_contenedor_ok: "+num_contenedor_ok);
          //console.log("nombre_comercial_propietario_ok: "+nombre_comercial_propietario_ok);
          //console.log("vacio_cargado_ok: "+vacio_cargado_ok);
          //console.log("mercancia_peligrosa_ok: "+mercancia_peligrosa_ok);

          if (
            encabezados_ok &&
            num_expedicion_ok &&
            fecha_expedicion_ok &&
            num_contenedor_ok &&
            nombre_comercial_propietario_ok &&
            vacio_cargado_ok &&
            tipo_contenedor_iso_ok &&
            tara_contenedor_ok &&
            peso_bruto_contenedor_ok &&
            temperatura_contenedor_ok &&
            num_peligro_adr_ok &&
            num_onu_adr_ok &&
            num_clase_adr_ok &&
            cod_grupo_embalaje_adr_ok &&
            destinatario_ok
          ) {
            $("#validarEntradaButton").prop("disabled", false);
          }

        };
        reader.onerror = function(ex) {
          console.log(ex);
        };
        reader.readAsBinaryString(file);
      };
    };

    function handleFileSelect(evt) {
      var files = evt.target.files; // FileList object
      var xl2json = new ExcelToJSON();
      xl2json.parseExcel(files[0]);
      $("#file").val(null);
    }
    $(document).ready(function() {
      $('#citas_descarga_pendientes_combo').change(function() {
        $("#file").prop("disabled", false);
        document.getElementById('file').addEventListener('change', handleFileSelect, false);
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      getCitasDescargaPendientes();

      table_entrada_tren0 = $('#table_entrada_tren0').DataTable({
        columns: [{
            data: 'fecha_expedicion'
          },
          {
            data: 'num_expedicion'
          },
          {
            data: 'mensaje_error'
          },
          {
            data: 'clase_td_fecha_expedicion',
            'visible': false
          },
          {
            data: 'clase_td_num_expedicion',
            'visible': false
          },
          {
            data: 'clase_td_mensaje_error',
            'visible': false
          },
        ],
        createdRow: function(row, data, index) {
          //console.log(data);
          $('td', row).eq(0).addClass(data['clase_td_fecha_expedicion']);
          $('td', row).eq(1).addClass(data['clase_td_num_expedicion']);
          $('td', row).eq(2).addClass(data['clase_td_mensaje_error']);
        },
        columnDefs: [{
          "targets": 2,
          "className": "text-center",
          "width": "55%"
        }],
        scrollX: false,
        ordering: false,
        autoWidth: false,
        iDisplayLength: -1,
        //scrollY: '10vh',
        bPaginate: false,
        bFilter: false,
        bInfo: false,
        bScrollCollapse: true
      });


      table_entrada_tren = $('#table_entrada_tren').DataTable({
        columns: [{
            data: 'num_vagon'
          },
          {
            data: 'pos_vagon'
          },
          {
            data: 'pos_contenedor'
          },
          {
            data: 'num_contenedor'
          },
          {
            data: 'tipo_contenedor_iso'
          },
          {
            data: 'tara_contenedor'
          },
          {
            data: 'vacio_cargado_contenedor'
          },
          {
            data: 'peso_bruto_contenedor'
          },
          {
            data: 'temperatura_contenedor'
          },
          {
            data: 'nombre_comercial_propietario'
          },
          {
            data: 'num_peligro_adr'
          },
          {
            data: 'num_onu_adr'
          },
          {
            data: 'num_clase_adr'
          },
          {
            data: 'cod_grupo_embalaje_adr'
          },
          {
            data: 'destinatario'
          },
          {
            data: 'mensaje_error'
          },
          {
            data: 'clase_td_num_vagon',
            'visible': false
          },
          {
            data: 'clase_td_pos_vagon',
            'visible': false
          },
          {
            data: 'clase_td_pos_contenedor',
            'visible': false
          },
          {
            data: 'clase_td_num_contenedor',
            'visible': false
          },
          {
            data: 'clase_td_tipo_contenedor_iso',
            'visible': false
          },
          {
            data: 'clase_td_tara_contenedor',
            'visible': false
          },
          {
            data: 'clase_td_vacio_cargado',
            'visible': false
          },
          {
            data: 'clase_td_peso_bruto_contenedor',
            'visible': false
          },
          {
            data: 'clase_td_temperatura_contenedor',
            'visible': false
          },
          {
            data: 'clase_td_nombre_comercial_propietario',
            'visible': false
          },
          {
            data: 'clase_td_num_peligro_adr',
            'visible': false
          },
          {
            data: 'clase_td_num_onu_adr',
            'visible': false
          },
          {
            data: 'clase_td_num_clase_adr',
            'visible': false
          },
          {
            data: 'clase_td_cod_grupo_embalaje_adr',
            'visible': false
          },
          {
            data: 'clase_td_destinatario',
            'visible': false
          },
          {
            data: 'clase_td_mensaje_error',
            'visible': false
          },
        ],
        createdRow: function(row, data, index) {
          //console.log(data);
          $('td', row).eq(0).addClass(data['clase_td_num_vagon']);
          $('td', row).eq(1).addClass(data['clase_td_pos_vagon']);
          $('td', row).eq(2).addClass(data['clase_td_pos_contenedor']);
          $('td', row).eq(3).addClass(data['clase_td_num_contenedor']);
          $('td', row).eq(4).addClass(data['clase_td_tipo_contenedor_iso']);
          $('td', row).eq(5).addClass(data['clase_td_tara_contenedor']);
          $('td', row).eq(6).addClass(data['clase_td_vacio_cargado']);
          $('td', row).eq(7).addClass(data['clase_td_peso_bruto_contenedor']);
          $('td', row).eq(8).addClass(data['clase_td_temperatura_contenedor']);
          $('td', row).eq(9).addClass(data['clase_td_nombre_comercial_propietario']);
          $('td', row).eq(10).addClass(data['clase_td_num_peligro_adr']);
          $('td', row).eq(11).addClass(data['clase_td_num_onu_adr']);
          $('td', row).eq(12).addClass(data['clase_td_num_clase_adr']);
          $('td', row).eq(13).addClass(data['clase_td_cod_grupo_embalaje_adr']);
          $('td', row).eq(14).addClass(data['clase_td_destinatario']);
          $('td', row).eq(15).addClass(data['clase_td_mensaje_error']);
        },
        scrollX: false,
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
  <style>

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
      ?> </nav>
    <div class="container-fluid" id="page-wrapper">

      <div class="row">
        <div class="col-lg-12" style="margin-top:20px;padding-left:0;">
          <div class="control-group">
            <div class="form-group floating-label-form-group controls mb-0 pb-2">
              <select class="form-control" id="citas_descarga_pendientes_combo">
                <option value="-1" disabled selected>Seleccione n&ordm; de expedici&oacute;n</option>
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12" style="padding:0px;">
          <div class="well well-sm" style="text-align:left;margin-bottom:20px;background:#eee;border:1px solid #ddd;padding:10px;">
            <div class="form-group">
              <input type="file" class="form-control-file" name="files[]" id="file" accept=".xls, .xlsx, .csv" required disabled>
            </div>

            <div class="form-group">
              <a href="../excel/IMPORTACION_ENTRADA_TRENES.xlsx">Descargar plantilla importación entrada trenes para rellenar</a>
            </div>

          </div>
        </div>
      </div>

      <center>
        <label>
          <input type="checkbox" id="retraso_tren_checkbox" name="retraso_tren_checkbox" value="true" />
          ESTE TREN VIENE CON RETRASO
        </label>
      </center>


      <div class="row">
        <div class="col-lg-4"></div>

        <div class="col-lg-4" style="padding:0px;">
          <table id="table_entrada_tren0" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Fecha Expedición</th>
                <th>Nº Expedición</th>
                <th>Errores</th>
                <th>clase_td_fecha_expedicion</th>
                <th>clase_td_num_expedicion</th>
                <th>clase_td_mensaje_error</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>

        <div class="col-lg-4"></div>
      </div>



      <div class="row">
        <div class="col-lg-12" style="padding-top:25px;padding-left:0;">

          <table id="table_entrada_tren" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Nº de Vagón</th>
                <th>Pos. Vagón</th>
                <th>Pos. Contenedor</th>
                <th>Nº Contenedor</th>
                <th>Tipo (ISO)</th>
                <th>Tara (Kg)</th>
                <th>V/C</th>
                <th>Peso Bruto (Kg)</th>
                <th>Temperatura (ºC)</th>
                <th>Propietario</th>
                <th>Nº Peligro</th>
                <th>Nº ONU</th>
                <th>Clase</th>
                <th>Grupo Embalaje</th>
                <th>Origen / Destino</th>
                <th>Errores</th>
                <th>clase_td_num_vagon</th>
                <th>clase_td_pos_vagon</th>
                <th>clase_td_pos_contenedor</th>
                <th>clase_td_num_contenedor</th>
                <th>clase_td_tipo_contenedor_iso</th>
                <th>clase_td_vacio_cargado</th>
                <th>clase_td_peso_bruto_contenedor</th>
                <th>clase_td_temperatura_contenedor</th>
                <th>clase_td_nombre_comercial_propietario</th>
                <th>clase_td_num_peligro_adr</th>
                <th>clase_td_num_onu_adr</th>
                <th>clase_td_num_clase_adr</th>
                <th>clase_td_cod_grupo_embalaje_adr</th>
                <th>clase_td_destinatario</th>
                <th>clase_td_mensaje_error</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>

          <button id="validarEntradaButton" class="btn btn-primary" onclick="validarEntrada()" style="margin-left:15px;" disabled>Validar Entrada</button>

        </div>
        <!-- /.col-lg-12 -->
      </div>
    </div>
    <!-- /#wrapper -->
  </div>
</body>

</html>