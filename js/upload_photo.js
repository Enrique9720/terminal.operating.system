function ImgUpload() {

  var imgWrap = "";
  const dt = new DataTransfer(); // Permet de manipuler les fichiers de l'input file

  $("#files").on('change', function(e){
    imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
  	for(let i = 0; i < this.files.length; i++){
      var file = this.files.item(i);
      let name_file = file.name;

      let reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = function() {
        var html = "<div class='upload__img-box'><div style='background-image: url(" + reader.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + name_file + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
        imgWrap.append(html);
      };
  	};
  	// Ajout des fichiers dans l'objet DataTransfer
  	for (let file of this.files) {
  		dt.items.add(file);
  	}
  	// Mise à jour des fichiers de l'input file après ajout
  	this.files = dt.files;
  });

	// EventListener pour le bouton de suppression créé
  $('body').on('click', ".upload__img-close", function (e) {
		//let name = $(this).next('.img-bg').attr('data-file');
    let name = $(this).parent('.img-bg').attr('data-file');
		// Supprimer l'affichage du nom de fichier
		$(this).parent().parent().remove();
		for(let i = 0; i < dt.items.length; i++){
			// Correspondance du fichier et du nom
			if(name === dt.items[i].getAsFile().name){
				// Suppression du fichier dans l'objet DataTransfer
				dt.items.remove(i);
				continue;
			}
		}
		// Mise à jour des fichiers de l'input file après suppression
		document.getElementById('files').files = dt.files;
	});

}
