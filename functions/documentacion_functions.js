/**
 * Obtiene un array con todos los albaranes de entrada
 * @returns
 */
function getAllNumPacking(){
	
	 $.ajax({
		 url: "../functions/get_all_num_packing.php",
	     type: "POST",
	     dataType: "json",
	     cache: false,
	     success: function(result) {	
	    	//console.log("result get_all_num_packing: "+JSON.stringify(result));
	        var num_packing_array = result.value;
	        p = [];
	        num_packing_array.forEach(item => p.push(item.num_packing));
	        	
	        $("#num_packing_input").jqxInput({placeHolder: "Nº de packing", height: 35, width: '100%', minLength: 1,  source: p });
	        
	     },
	     error: function(result) {
	    	console.log("error get_all_num_packing: "+JSON.stringify(result));	
	     }
	});		
}

/**
 * Obtiene todos los documentos asociados con el albarán de entrada seleccionado
 * @returns
 */
function getDocumentacion(){
	
	var num_packing = document.getElementById("num_packing_input").value;
	
	var dropzoneDiv = document.getElementById('dropzoneDiv');
	dropzoneDiv.style.visibility = 'visible';
	 
	document.getElementById("num_packing").value = num_packing;
	document.getElementById("docList").innerHTML = "";
	
	$.ajax({
		 url: "../functions/get_listado_documentacion.php",
	     type: "POST",
	     dataType: "json",
	     cache: false,
	     async: false,
	     data: {
	    	 num_packing : num_packing,
	     },
	     success: function(result) {	
	    	console.log("result get_listado_documentacion: "+JSON.stringify(result));
	    	if (result.value != null){
	    		var fileList = Object.values(result.value);
	    		for (var i=0;i<fileList.length;i++){
	    			var li = document.createElement('li');
	    			var a = document.createElement('a');
	    			var linkText = document.createTextNode(fileList[i]);
	    			a.appendChild(linkText);
	    			a.title = fileList[i];
	    			a.href = "../uploads/"+num_packing+"/"+fileList[i];
	    			a.target="_blank";
	    			a.style.textDecoration = "none";
	    			li.appendChild(a);
	    			document.getElementById("docList").appendChild(li); // Append the text to <li>
	    		}
	    	}

	     },
	     error: function(result) {
	    	console.log("error get_listado_documentacion: "+JSON.stringify(result));	
	     }
	});		
}
	