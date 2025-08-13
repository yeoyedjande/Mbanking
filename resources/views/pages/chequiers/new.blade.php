@extends('layouts.template')

@section('title', 'Faire une commande de chequiers')





@section('content')

  <div class="page-heading">

	  <div class="page-title mb-5">

	    <div class="row">

	      <div class="col-12 col-md-6 order-md-1 order-last">

	        <h3 style="text-transform: uppercase;">{{ $title }}</h3>

	      </div>

	      <div class="col-12 col-md-6 order-md-2 order-first">

	        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">

	          <ol class="breadcrumb">

	            <li class="breadcrumb-item">

	              <a href="{{ route('dashboard') }}">Tableau de bord</a>

	            </li>

	            <li class="breadcrumb-item active" aria-current="page">

	              Faire une commande de chequiers

	            </li>

	          </ol>

	        </nav>

	      </div>

	    </div>

		</div>



    @if( session()->has('msg_success') )

    <div class="col-md-12">

        <div class="alert alert-success">{{ session()->get('msg_success') }}</div>

    </div>

    @endif



    @if( session()->has('msg_error') )

    <div class="col-md-12">

        <div class="alert alert-danger">{{ session()->get('msg_error') }}</div>

    </div>

    @endif



    @if( session()->has('msg_info') )

    <div class="col-md-12">

        <div class="alert alert-info">{{ session()->get('msg_info') }}</div>

    </div>

    @endif





    <section class="section">

      

      <div class="row">



      	<div class="col-md-6">

      		<div class="card">

		        <div class="card-header">

		        		<h2>Remplir les informations</h2>

		        </div>

		        <div class="card-body">

		          	<form class="form_versement" method="POST" action="#">

		          			{{ csrf_field() }}

		          			<input type="hidden" value="{{ $data->number_account }}" name="num_account">


		          			<div class="form-group">

				             	<label>Type de carnet de chèques *</label>
				             	<select class="form-control form-control-xl" name="type_carnet_cheque" id="type_carnet_cheque" required>
				             		<option value="standard">Standard</option>
				             		<option value="express">Express</option>
				             	</select>
				            </div>


		          			<div class="form-group">

				             	<label>Nombre de chequiers *</label>
				             	<input type="number" id="nb_chequiers" required class="form-control form-control-xl" name="nb_chequiers" autocomplete="0">
				            </div>

		          			<div class="form-group">

		          			  <label>Prix Unitaire *</label>
				              <input type="text" id="amount" min="1" class="form-control form-control-xl" name="amount" autocomplete="off" readonly required>

				            </div>

				            <div class="form-group">

				              <button type="button" id="btn_vers" data-bs-toggle="modal" data-bs-target="#addChequiers" class="btn btn-primary btn-lg">Valider</button>

				            </div>

		          	</form>

		        </div>

		      </div>

      	</div>

      	<div class="col-md-6">

			<div class="card">

		        <div class="card-header">

		        		<h2>Resumé du compte: {{ $data->number_account }}</h2>

		        </div>

		        <div class="card-body">

		          	<div class="list-group" style="">

		              <span class="list-group-item"><b>Solde:</b> {{ number_format($data->solde, 0, 2, ' ') }} BIF</span>

		              <span class="list-group-item"><b>Nom et Prenom(s) du client: </b>{{ $data->nom }} @if($data->prenom != 'NULL' ) {{ $data->prenom }} @endif</span>

		              @if($data->email != 'NULL' )

		              <span class="list-group-item"><b>Email: </b>{{ $data->email }}</span>

		              @endif

		              <span class="list-group-item"><b>Type de compte: </b>{{ $data->name }}</span>

		            </div>

		        </div>

		    </div>

      	</div>

	      

    	</div>

  	</section>


  	<!--CONFIRMATION-->

  	<div class="modal fade text-left" id="addChequiers" tabindex="-1" role="dialog" aria-hidden="true">

	    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">

	      <div class="modal-content">

	        <div class="modal-header bg-primary white">

	          <sapn class="modal-title" id="myModalLabel150">
	            Reviser la commande du chequiers
	          </sapn>

	          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
	            <i data-feather="x"></i>
	          </button>

	        </div>

	        <div class="modal-body">

	        	<form action="{{ route('chequiers-valide') }}" method="POST">
				      	<div class="modal-body">
			        		<div class="alert alert-warning">
			        		</div>

			        		{{ csrf_field() }}
			        		<input type="hidden" value="{{ $data->number_account }}" name="num_account">
			        		<input type="hidden" id="result_amount" name="amount">
			        		<input type="hidden" id="result_nb_chequiers" name="nb_chequiers">
			        		<input type="hidden" id="result_type_carnet_cheque" name="type_carnet_cheque">


			        		<div id="dragula-right" class="content">
				          		<div class="rounded border mb-2">
				                  <div class="card-body p-3">
				                    <div class="media">
				                      <i class="bi bi-user icon-sm align-self-center me-3"></i>
				                      <div class="media-body">
				                        <h4 class="mb-1">Numéro de compte</h4>
				                        <p class="mb-3 text-muted" style="font-size: 18px;">{{ $data->number_account }}
				                        </p>

			                        	<h4 class="mb-1">Prix Unitaire</h4>
				                        <p class="mb-3 text-muted" style="font-size: 18px;">
				                        	<span id="affiche_amount" style="font-weight: bold; color: #FF0000;"></span>
				                        </p>

				                        <h4 class="mb-1">Nombre de chequiers</h4>
				                        <p class="mb-3 text-muted" style="font-size: 18px;">
				                        	<span id="affiche_nb_chequiers" style="font-weight: bold; color: #FF0000;"></span>
				                        </p>

				                        <h4 class="mb-1">Prix Total à payer</h4>
				                        <p class="mb-3 text-muted" style="font-size: 18px;">
				                        	<span id="affiche_total" style="font-weight: bold; color: #FF0000;"></span>
				                        </p>

				                        <h4 class="mb-1">Date de paiement</h4>
				                        <p class="mb-4 text-muted" style="font-size: 18px;">
				                        	<?= date('d/m/Y'); ?>
				                        </p>

				                      </div>
				                    </div>
				                  </div>
				              	</div>
				            </div>

		            	</div>
				      <div class="modal-footer">
				      </div>
		    	</form>

	        </div>

	      </div>

	    </div>

	</div>
@endsection



@section('js')

<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script type="text/javascript">
  $(window).on('load', function() {
    $('#waitVersement').modal('show');
  });
</script>

<script type="text/javascript">

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

</script>

<script type="text/javascript">

	$(document).ready(function() {
			
		var form = $('.form_versement');
		var submitBtn = form.find('#btn_vers');

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

		$('#amount').val(0);

		$('#type_carnet_cheque').change(function() {

			 $("#type_carnet_cheque option:selected").each(function () {

			    // Récupère la valeur sélectionnée
			    var valeurSelected = $(this).val();
			    var standard = 4000;
			    var express = 6000;

			    if (valeurSelected == 'standard') {

			    	//Le montant devient  4000 BIF
			    	$('#amount').val(standard);
			    	
			    }else{

			    	//Le montant devient  6000 BIF
			    	$('#amount').val(express);
			    	
			    }

		 	});
		 })
		.trigger('change');

		$("#addChequiers").on('show.bs.modal', function(){

	        var amount = $('#amount').val().replace(/\s/g, '');
	        var nb_chequiers = $('#nb_chequiers').val();
	        var type_carnet_cheque = $('#type_carnet_cheque').val();
	        
	        var total = amount * nb_chequiers;

	        var modal = $(this);


        	$('.alert').text('Bien vouloir vérifier le paiement ci-après et cliquer sur le bouton de confirmation');

					modal.find('#result_amount').val(amount);
					modal.find('#affiche_nb_chequiers').html(nb_chequiers);
					var amountAffiche = $('#amount').val();

		    	modal.find('#affiche_amount').html(amountAffiche+' BIF');
		    	modal.find('#result_nb_chequiers').val(nb_chequiers);
		    	modal.find('#result_type_carnet_cheque').val(type_carnet_cheque);

		    	modal.find('#affiche_total').html(total.toLocaleString('fr-FR')+' BIF');

		    	$('.modal-footer').html('<button type="button" class="btn btn-dark btn-lg" data-bs-dismiss="modal">Retour</button><button type="submit" class="btn btn-success btn-lg">Confirmer et imprimer la commande></button>');

    	});

});
</script>

@endsection