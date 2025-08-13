

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
			
		var form = $('.form_virement');
		var submitBtn = form.find('#btn_virement');

		// Désactivation du bouton d'envoi
		submitBtn.prop('disabled', true);

		form.find('input').on('keyup blur', function() {
		  // Vérification si tous les champs sont remplis
		  var tousRemplis = true;
		  form.find('input').each(function() {
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

		$("#addVirement").on('show.bs.modal', function(){

					$('.alert').text('Bien vouloir vérifier le virement ci-après et cliquer sur le bouton de confirmation');

	        	var amount = $('#amount').val().replace(/\s/g, '');
	        	var num_account_dest = $('#num_account_dest').val();
	        	var motif_virement = $('#motif_virement').val();
	         	var frais = 1000;
	         	var type_carte = 'frais_virement';
	        	var modal = $(this);
	        
						modal.find('#result_amount').val(amount);
						modal.find('#result_type_carte').val(type_carte);
						modal.find('#result_frais').val(frais);

						modal.find('#result_motif_virement').val(motif_virement);
						modal.find('#result_num_account_dest').val(num_account_dest);
						modal.find('#affiche_num_compte_destinataire').html(num_account_dest);
						modal.find('#affiche_motif_virement').html(motif_virement);
						modal.find('#affiche_type_carte').html(type_carte);
						modal.find('#affiche_frais').html(frais+' BIF');


						var amountAffiche = $('#amount').val();
	        	modal.find('#affiche_amount').html(amountAffiche+' BIF');


	        	$('.modal-footer').html('<button type="button" class="btn btn-dark btn-lg" data-bs-dismiss="modal">Retour</button><button type="submit" class="btn btn-success btn-lg">Confirmer et imprimer le virement></button>');
	        

    	});

});