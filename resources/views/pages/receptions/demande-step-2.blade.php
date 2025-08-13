@extends('layouts.template')

@section('title', $title)

@section('css')
  <link rel="stylesheet" href="/assets/css/pages/fontawesome.html" />
  <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css"/>
  <link rel="stylesheet" href="/assets/css/pages/simple-datatables.css" />
@endsection

@section('content')

<div class="page-heading">
  <div class="page-title">
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
              {{ $title }}
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

    <section class="section">
      <div class="row">
      	<div class="col-md-6">
	        <div class="card">
	          <div class="card-header">
	              
	          </div>
	          <div class="card-body">
	            	<form class="forms-sample" action="{{ route('demande-credit-2') }}" method="GET">
			          	{{ csrf_field() }}

			          	<input type="hidden" name="flash" value="{{ $flash }}">
			          	<input type="hidden" name="rand" value="{{ $rand }}">

									<div class="row">
					          	<div class="col-md-12">
												<div class="form-group">
						              <label for="type" class="mb-2">Type de la demande * </label>
						              <select class="form-control form-control-xl" id="type" name="type" required>
						              	<option>Selectionner</option>
						              	@foreach( $type_credits as $t )
						              	<option value="{{ $t->id }}">{{ $t->name }}</option>
						              	@endforeach
						              </select>
						            </div>
						            <div class="form-group">
						              <label for="type" class="mb-2">Montant de la demande * </label>
						              <input type="text" id="amount" required name="amount" class="form-control form-control-xl">
						            </div>

						            <div class="form-group sendBtn mt-3">
						              <a href="{{ route('demande-credit') }}" class="btn btn-danger btn-lg">< Retour</a>
						              <button type="submit" class="btn btn-primary btn-lg">Suivant ></button>
						            </div>
					          	</div>
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
			          	<div class="list-group" style="font-size: 25px;">
			              <span class="list-group-item"><b>Solde:</b> <span style="color: green;">{{ number_format($data->solde, 0, 2, ' ') }} BIF</span></span>
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

@endsection

@section('js')


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

		$(document).ready(function() {
				
				var amount = $('#amount').val();
				
				$("#type").change(function () {
                 
		            $("#type option:selected").each(function () {

		            	var type = $('#type').val();
		            	$('#result_type').val(type);

			        });

		        });


				$("#sendDemande").on('show.bs.modal', function(){
		        //var button = $(e.relatedTarget);
		        //var id = button.data('id');

				var amount = $('#amount').val();
				
		        var modal = $(this);

	        	$('#dragula-right').show();
				modal.find('#result_amount').val(amount);
				//modal.find('#result_type').val(type);
	        	modal.find('#affiche_amount').html(amount+' BIF');
		
		    });
      
		});

</script>
@endsection