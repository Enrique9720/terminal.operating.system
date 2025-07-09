
/**
 *
 * @param month_num
 * @returns
 */
function get_month_name(month_num) {
	switch (month_num) {
		case 1: return "ENERO";
		case 2: return "FEBRERO";
		case 3: return "MARZO";
		case 4: return "ABRIL";
		case 5: return "MAYO";
		case 6: return "JUNIO";
		case 7: return "JULIO";
		case 8: return "AGOSTO";
		case 9: return "SEPTIEMBRE";
		case 10: return "OCTUBRE";
		case 11: return "NOVIEMBRE";
		case 12: return "DICIEMBRE";
		default: return "";
	}
}

/////////////////////////////////////SELECT 2 ////////////////////////////
function load_select2(select_clase, placeholder) {
	$(select_clase).select2({
		theme: "bootstrap",
		placeholder: placeholder,
		allowClear: true
	});
}

function load_ajax_select2(select_clase, placeholder, script_sql) {
	$(select_clase).select2({
		theme: "bootstrap",
		placeholder: placeholder,
		allowClear: true,
		ajax: {
			url: script_sql,//script consulta BD
			dataType: 'json',
			delay: 0,
			data: function (params) {
				return {
					q: params.term // search term
				};
			},
			processResults: function (data) {
				// parse the results into the format expected by Select2.
				// since we are using custom formatting functions we do not need to
				// alter the remote JSON data
				return {
					results: data
				};
			},
			cache: true
		},
		minimumInputLength: 2
	});
}

//funcion para inicializar select2 con custom tags
function load_select2_customtags(select_clase, placeholder, script_sql) {
	$(select_clase).select2({
		theme: "bootstrap",
		placeholder: placeholder,
		allowClear: true,
		ajax: {
			url: script_sql,//script consulta BD
			dataType: 'json',
			delay: 100,
			data: function (params) {
				return {
					q: params.term // search term
				};
			},
			processResults: function (data) {
				// parse the results into the format expected by Select2.
				// since we are using custom formatting functions we do not need to
				// alter the remote JSON data
				return {
					results: data
				};
			},
			cache: true
		},
		tags: true,
		minimumInputLength: 2
	});
}

function load_all_select2() {
	load_select2(".select_2", "");
}
//////////////////////////////////////////////////////////////////////////////////////////
