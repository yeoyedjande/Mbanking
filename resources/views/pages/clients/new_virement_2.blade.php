@extends('layouts.app_client')

@section('title', 'Faire un virement')


@section('css')
  <link rel="stylesheet" href="/assets/css/pages/fontawesome.html" />
  <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css"/>
  <link rel="stylesheet" href="/assets/css/pages/simple-datatables.css" />
@endsection

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
                <a href="{{ route('home') }}">Tableau de bord</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                Faire un virement
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

    <div class="alert alert-secondary">

      <h4 class="alert-heading">Info</h4>

      <p style="font-size: 20px;">Vous êtes sur le point d'envoyer de l'argent au destinataire <b>{{ $data->nom }} @if($data->prenom != 'NULL' ) {{ $data->prenom }} @endif</b>, si oui remplissez le formulaire ci-dessous, sinon <a style="color: red;" href="{{ route('client-virements-new') }}">cliquez ici</a> pour recommencer !</p>

    </div>


  	<div class="row">

	    <div class="col-md-7">

	      <div class="card">

	        <div class="card-body">

	          <form class="form_virement" action="#" method="POST">

	            {{ csrf_field() }}


	            <div class="row">

	            	<div class="col-md-12">

									<div class="form-group">

			              <label for="amount" class="mb-3" style="font-size: 20px;">Entrer le montant à envoyer * </label>

			              <input type="text"  class="form-control form-control-xl" id="amount" name="amount" autocomplete="0" required>

			            </div>

	            	</div>

	            	
	            	<div class="col-md-12">

									<div class="form-group">

			              <label for="motif_virement" class="mb-3" style="font-size: 20px;">Motif du virement * </label>

			              <textarea rows="5" id="motif_virement" name="motif_virement" class="form-control form-control-xl" required></textarea>

			            </div>

	            	</div>

								<div class="col-md-12">

									<div class="form-group">

			              <button type="button" id="btn_virement" data-bs-toggle="modal" data-bs-target="#addVirement" class="btn btn-primary btn-lg">  Valider</button>

			            </div>

	            	</div>

							</div>

						</form>

	        </div>

	      </div>

	    </div>



	    <div class="col-md-5">


	      <div class="card">

	      	<div class="card-header">
	      		<h2>Mon compte</h2>
	      	</div>

	        <div class="card-body">

	            <div class="row">
	            		<p>
	            			<span style="font-size: 23px;">Mon solde: </span><br>
	            			<h4>{{ number_format($soldeClient->solde, 0, 2, ' ') }} BIF</h4>
	            		</p>
							</div>

	        </div>

	      </div>

	    </div>           

		</div>
    

  </div>

  <!--CONFIRMATION-->

  	<div class="modal fade text-left" id="addVirement" tabindex="-1" role="dialog" aria-hidden="true">

	    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">

	      <div class="modal-content">

	        <div class="modal-header bg-primary white">

	          <sapn class="modal-title" id="myModalLabel150">
	            Reviser le virement
	          </sapn>

	          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
	            <i data-feather="x"></i>
	          </button>

	        </div>

	        <div class="modal-body">

	        	<form action="{{ route('client-virements-valid') }}" method="POST">
				      	<div class="modal-body">
			        		<div class="alert alert-warning message">
			        		</div>

			        		{{ csrf_field() }}
			        		<input type="hidden" value="{{ $soldeClient->number_account }}" name="num_account">

			        		<input type="hidden" id="result_amount" name="amount">
			        		<input type="hidden" value="{{ $data->number_account }}" name="num_account_dest">
			        		<input type="hidden" id="result_motif_virement" name="motif_virement">

			        		<input type="hidden" id="result_type_carte" name="type_carte">
			        		<input type="hidden" id="result_frais" name="frais">


			        		<div id="dragula-right" class="content">
				          		<div class="rounded border mb-2">
				                  <div class="card-body p-3">
				                    <div class="media">
				                      <i class="bi bi-users icon-sm align-self-center me-3"></i>
				                      <div class="media-body">
				                        <h4 class="mb-1">Numéro de compte Expéditeur</h4>
				                        <p class="mb-3 text-muted" style="font-size: 18px;">{{ $soldeClient->number_account }}
				                        </p>

				                        <h4 class="mb-1">Numéro de compte destinataire</h4>
			                        	<p class="mb-3 text-muted" style="font-size: 18px;"><span>{{ $data->number_account }}</span>
			                        	</p>

			                        	<h4 class="mb-1">Montant à virer</h4>
				                        <p class="mb-3 text-muted" style="font-size: 18px;">
				                        	<span id="affiche_amount" style="font-weight: bold; color: #FF0000;"></span>
				                        </p>

				                        <h4 class="mb-1">Frais</h4>
				                        <p class="mb-3 text-muted" style="font-size: 18px;">
				                        	<span id="affiche_frais" style="font-weight: bold; color: #FF0000;"></span>
				                        </p>

				                        <h4 class="mb-1">Motif du virement</h4>
				                        <p class="mb-3 text-muted" style="font-size: 18px;">
				                        	<span id="affiche_motif_virement" style=""></span>
				                        </p>

				                        <h4 class="mb-1">Date du virement</h4>
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
<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/assets/js/pages/simple-datatables.js"></script>

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

					$('.message').text('Bien vouloir vérifier le virement ci-après et cliquer sur le bouton de confirmation');

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
</script>

@endsection