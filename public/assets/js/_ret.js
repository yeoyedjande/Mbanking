
		// Récupérer le champ de montant

		const montant = document.getElementById("amount");

		// Ajouter un écouteur d'événements pour l'événement input

		montant.addEventListener('input', function(e) {

		  // Récupérer la valeur saisie dans le champ de montant

		  let valeur = e.target.value;
		  // Enlever tous les espaces de la valeur saisie

		  valeur = valeur.replace(/\s+/g, '');



		  // Formater le nombre en ajoutant des espaces tous les 3 chiffres

		  valeur = valeur.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ');



		  // Mettre à jour la valeur affichée dans le champ de montant

		  e.target.value = valeur;

		});

	


	$(document).ready(function() {
			


		var form = $('.form_retrait');
		var submitBtn = form.find('#btn_ret');

		// Désactivation du bouton d'envoi
		submitBtn.prop('disabled', true);

		form.find('.remplir').on('keyup blur', function() {
		  // Vérification si tous les champs sont remplis
		  var tousRemplis = true;
		  form.find('.remplir').each(function() {
		    if ($(this).val() == '') {
		      tousRemplis = false;
		    }
		  });

		  // Activation ou désactivation du bouton d'envoi en fonction de la vérification
		  if (tousRemplis) {
		    submitBtn.prop('disabled', false);
		  } else {
		    submitBtn.prop('disabled', true);
		  }
		});

		$('#compte').change(function() {

			 $("#compte option:selected").each(function () {

			    // Récupère la valeur sélectionnée
			    var selectedValue = $(this).val();
			    
			    //console.log(selectedValue);
			   	$('#num_generer').val(selectedValue);

		 	});
		 })
		.trigger('change');


		$('#affiche_chp_serie_cheque').html('');

		//$('.type_personne_select').html('<label style="font-size: 20px;">Selectionner le type de personne *</label><select class="form-control form-control-xl remplir" required name="type_personne" id="type_personne"><option value="titulaire">Titulaire</option><option value="mandataire">Mandataire</option><option value="porteur">Porteur de chèque</option></select>');

		$('#type_carte').change(function() {


			 $("#type_carte option:selected").each(function () {

			    // Récupère la valeur sélectionnée
			    var valeurSelected = $(this).val();
			    var champ2 = $('.champs2');

			    champ2.html('');

			    if (valeurSelected == 'recu') {

			    	$('#frais').val('5');
			    	$('#affiche_chp_serie_cheque').html('');

			    	champ2.append('<option value="titulaire">Titulaire</option>');
			    	champ2.append('<option value="mandataire">Mandataire</option>');
			    	champ2.append('<option value="porteur">Porteur de chèque</option></select>');

			    }else if(valeurSelected == 'carnet'){

			    	$('#affiche_chp_serie_cheque').html('<label>Serie du cheque *</label><input type="text" class="form-control form-control-xl" name="serie_cheque" id="serie_cheque" required>');

			    	$('#frais').val('0');

			    	champ2.append('<option value="titulaire">Titulaire</option>');
			    	champ2.append('<option value="mandataire">Mandataire</option>');
			    	champ2.append('<option value="porteur">Porteur de chèque</option></select>');

			    }else{
			    	$('#frais').val('0');
			    	$('#affiche_chp_serie_cheque').html('');

			    	champ2.append('<option value="titulaire">Titulaire</option>');
			    }

		 	});
		 })
		.trigger('change');

		//$('#affiche_nom_porteur').hide();
		$('#affiche_nom_porteur').html('');

		$('#type_personne').change(function() {

			 $("#type_personne option:selected").each(function () {

			    // Récupère la valeur sélectionnée
			    var selectedValue = $(this).val();
			    
			    if (selectedValue == 'porteur') {
			    	$('#affiche_nom_porteur').html('<label>Nom du porteur *</label><input type="text" class="form-control form-control-xl" name="nom_porteur" id="nom_porteur" required>');
			    }else{
			    	$('#affiche_nom_porteur').html('');
			    }

		 	});
		 })
		.trigger('change');

		

		$("#addRetrait").on('show.bs.modal', function(){

	        var amount = $('#amount').val().replace(/\s/g, '');
	        var type_personne = $('#type_personne').val();
	        var type_piece = $('#type_piece').val();
	        var nom_porteur = $('#nom_porteur').val();
	        var serie_cheque = $('#serie_cheque').val();
	        var num_piece = $('#num_piece').val();
	        var cumulday = $('#cumulday').val();
	        var cumulmonth = $('#cumulmonth').val();
	        var nom_complet = $('#nom_complet').val();

	        var num_generer = $('#num_generer').val();


	        var frais = $('#frais').val();

	        var type_carte = $('#type_carte').val();
	        

	        var total_prelever = Number(amount);
	        
	        var cumuldayFinal = cumulday + amount;
	        var cumulmonthFinal = cumulmonth + amount;

	        var seuil_jour = 15000000;
	        var seuil_mois = 100000000;
	        var seuil_operation = 1000000;

	        var modal = $(this);

	        	
	        	modal.find('#affiche_num_account').html(num_generer);
	        	modal.find('#num_account_select').val(num_generer);

				modal.find('#result_amount').val(amount);
				modal.find('#result_type_personne').val(type_personne);
				modal.find('#result_type_piece').val(type_piece);
				modal.find('#result_type_carte').val(type_carte);

				modal.find('#result_frais').val(frais);

				modal.find('#result_num_piece').val(num_piece);
				modal.find('#result_nom_porteur').val(nom_porteur);
				modal.find('#result_serie_cheque').val(serie_cheque);

				var amountAffiche = $('#amount').val();

	        	modal.find('#affiche_amount').html(amountAffiche+' BIF');
				modal.find('#affiche_type_personne').html(type_personne);


				if (frais == 5 ) {
					modal.find('#affiche_total_prelever').html(Number(total_prelever+600).toLocaleString('fr-FR')+' BIF');
				}else{
					modal.find('#affiche_total_prelever').html(Number(total_prelever).toLocaleString('fr-FR')+' BIF');
				}
				if ( type_carte == 'carnet') {
					modal.find('#affiche_serie_cheque').html('<h4 class="mb-1">Serie du cheque</h4><p class="mb-3 text-muted" style="font-size: 18px;">'+ serie_cheque +'</p>');
				}

	        	if (type_personne == 'porteur') {
	        		modal.find('#affiche_name_type_personne').html('<h4 class="mb-1">Nom du porteur</h4><p class="mb-3 text-muted" style="font-size: 18px;">'+ nom_porteur +'</p>');
	        	}else if(type_personne == 'titulaire'){
					modal.find('#affiche_name_type_personne').html('<h4 class="mb-1">Nom du client</h4><p class="mb-3 text-muted" style="font-size: 18px;">'+ nom_complet +'</p>');
	        	}else{
					//modal.find('#affiche_name_type_personne').html('<h4 class="mb-1">Nom du mandataire</h4><p class="mb-3 text-muted" style="font-size: 18px;">{{ $client->nom_mandataire }}</p>');
	        	}
	        	

	        	if ( Number(amount) >= 500000 ) {

					$('.alert').text('Seuil du porteur doit pas dépasser 500 000 BIF, donc cette opération nécessite une autorisation avant d\'être effectuée');

			        	modal.find('#affiche_type_piece').html(type_piece);

			        	if (frais == 5 ) {//ici que tout se passe
							modal.find('#affiche_frais').html('600 BIF');
			        	}else{
							modal.find('#affiche_frais').html('0 BIF');
			        	}
			        	

			        	modal.find('#affiche_num_piece').html(num_piece);
			        	
			        	$('.modal-footer').html('<button type="button" class="btn btn-dark btn-lg" data-bs-dismiss="modal">Retour</button><button type="submit" class="btn btn-danger btn-lg">Demander une autorisation</button>');
        		}else{
	        		
		        	if ( (Number(cumuldayFinal) > seuil_jour) && (Number(cumuldayFinal) < seuil_mois)) {

		        		$('.alert').text('Seuil du jour atteint: Cette opération nécessite une autorisation avant d\'être effectuée');

			        	modal.find('#affiche_type_piece').html(type_piece);
			        	modal.find('#affiche_num_piece').html(num_piece);

			        	if (frais == 5 ) {
							modal.find('#affiche_frais').html('600 BIF');
			        	}else{
							modal.find('#affiche_frais').html('0 BIF');
			        	}
			        	
			        	$('.modal-footer').html('<button type="button" class="btn btn-dark btn-lg" data-bs-dismiss="modal">Retour</button><button type="submit" class="btn btn-danger btn-lg">Demander une autorisation</button>');

			        }else if( Number(cumulmonthFinal) > seuil_mois ){
			        	
			        	$('.alert').text('Seuil du mois atteint: Cette opération nécessite une autorisation avant d\'être effectuée');

			        	modal.find('#affiche_type_piece').html(type_piece);
			        	modal.find('#affiche_num_piece').html(num_piece);
			        	if (frais == 5 ) {
							modal.find('#affiche_frais').html('600 BIF');
			        	}else{
							modal.find('#affiche_frais').html('0 BIF');
			        	}
			        	
			        	$('.modal-footer').html('<button type="button" class="btn btn-dark btn-lg" data-bs-dismiss="modal">Retour</button><button type="submit" class="btn btn-danger btn-lg">Demander une autorisation</button>');

			        }else if( (Number(amount) > seuil_operation) && (Number(amount) < seuil_jour) ){
			        	
			        	$('.alert').text('Le Seuil par operation doit pas dépasser 1 000 000 BIF, donc cette opération nécessite une autorisation avant d\'être effectuée');

			        	modal.find('#affiche_type_piece').html(type_piece);
			        	modal.find('#affiche_num_piece').html(num_piece);
			        	if (frais == 5 ) {
							modal.find('#affiche_frais').html('600 BIF');
			        	}else{
							modal.find('#affiche_frais').html('0 BIF');
			        	}
			        	
			        	$('.modal-footer').html('<button type="button" class="btn btn-dark btn-lg" data-bs-dismiss="modal">Retour</button><button type="submit" class="btn btn-danger btn-lg">Demander une autorisation</button>');

			        }else{

			        	$('.alert').text('Bien vouloir vérifier le retrait ci-après et cliquer sur le bouton de confirmation');

			        	modal.find('#affiche_type_piece').html(type_piece);
			        	modal.find('#affiche_num_piece').html(num_piece);
			        	
			        	if (frais == 5 ) {
							modal.find('#affiche_frais').html('600 BIF');
			        	}else{
							modal.find('#affiche_frais').html('0 BIF');
			        	}
			        	
			        	$('.modal-footer').html('<button type="button" class="btn btn-dark btn-lg" data-bs-dismiss="modal">Retour</button><button type="submit" class="btn btn-success btn-lg">Confirmer et imprimer le retrait></button>');

			        }

		    	}

    	});
	});
