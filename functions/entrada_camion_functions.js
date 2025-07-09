/**
 * Valida la entrada de mercancía
 * @returns
 *//*
function validarEntrada(){
    console.log("validarEntrada()");

    $('#validarEntradaButton').prop('disabled', true);

    num_expedicion = $('#citas_descarga_pendientes_combo').find(":selected").text().split("(")[0].trim();
    console.log(num_expedicion);
    //fecha_expedicion = $('#citas_descarga_pendientes_combo').find(":selected").text().split("(")[1].replace(")", "").replace(" ", "");
    //console.log(fecha_expedicion);
    //nombre_comercial_propietario = $('#citas_descarga_pendientes_combo').find(":selected").text().split("(")[2].replace(")", "");
    //console.log(nombre_comercial_propietario_select);

    if ((num_expedicion === "Seleccione nº de expedición")){
        alert("Debe seleccionar un número de expedición");
        $('#validarEntradaButton').prop('disabled', false);
        return ;
    }


    var entrada_camion = [];
    //console.log(table_entrada_camion);

    //recorremos la tabla de entrada camion fila a fila
    for(var i=0;i<table_entrada_camion.rows().data().length;i++){

        var data = table_entrada_camion.rows().data()[i];
        //console.log(data);

        var linea_entrada_camion = {
           fecha_expedicion: data['fecha_expedicion'],
           num_expedicion: data['num_expedicion'],
           mat_contenedor: data['mat_contenedor'],
           num_contenedor: data['num_contenedor'],
           tipo_contenedor_iso: data['tipo_contenedor_iso'],
           vacio_cargado_contenedor: data['vacio_cargado_contenedor'],
           peso_bruto_contenedor: data['peso_bruto_contenedor'],
           temperatura_contenedor: data['temperatura_contenedor'],
           nombre_comercial_propietario: data['nombre_comercial_propietario'],
           mercancia_peligrosa: data['mercancia_peligrosa'],
           nombre_comercial_propietario: data['nombre_comercial_propietario'],
           destinatario: data['destinatario']
        }

       entrada_camion.push(linea_entrada_camion);
    }

    if (entrada_camion.length == 0){
        alert("Debe haber al menos un camión"); //??
        $('#validarEntradaButton').prop('disabled', false);
        return ;
    }

    console.log(entrada_camion);

    $.ajax({
        url: "../ajax/validar_entrada_camion.php",
        type: "POST",
        dataType: "json",
        data: {
            num_expedicion : num_expedicion,
            entrada_camion : entrada_camion
        },
        cache: false,
        success: function(result) {
            console.log("result validar_entrada_mercancia: "+JSON.stringify(result));
            alert("Mercancía dada de alta en el sistema correctamente");
        },
        error: function(result) {
           console.log("error validar_entrada_mercancia: "+JSON.stringify(result));
           alert("ERROR: hubo algún fallo al dar de entrada la mercancía");
        }
   });

}*/

/**
* Obtiene los albaranes de entrada abiertos
* @returns
*/
/*function getCitasDescargaPendientes(){

    $.ajax({
        url: "../ajax/get_citas_descarga_pendientes.php",
        type: "POST",
        dataType: "json",
        cache: false,
        success: function(result) {
           //console.log("result get_citas_descarga_pendientes: "+JSON.stringify(result));

           var citas_descarga_pendientes_combo = document.getElementById("citas_descarga_pendientes_combo");
           //console.log(result.value.length);
           for(var i=0;i<result.value.length;i++){
               var option = document.createElement("option");
               option.innerHTML = '' + result.value[i].num_expedicion + ' (' + result.value[i].fecha + ') (' + result.value[i].nombre_comercial_propietario + ')';
               option.value = result.value[i].id;
               citas_descarga_pendientes_combo.add(option);
           }

           citas_descarga_pendientes_combo.selectedIndex = "0";

        },
        error: function(result) {
           console.log("error get_citas_descarga_pendientes: "+JSON.stringify(result));
        }
   });
}*/
