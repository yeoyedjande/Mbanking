@extends('layouts.template')

@section('title', 'Faire un retrait')

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

	              Faire un retrait

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



      	<div class="col-md-7">


      		<div class="card">

		        <div class="card-header">
	        		<h2>Entrer le montant du retrait</h2>
		        </div>

		        <div class="card-body">

		          	<form class="form_retrait" method="POST" enctype='multipart/form-data' action="#">

		          			{{ csrf_field() }}

		          			
		          			<input type="hidden" id="nom_complet" value="{{ $client->nom }} {{ $client->prenom }}" name="nom_complet">

		          			<input type="hidden" id="cumulday" value="{{ $cumulRetraitJour }}" name="cumulday">
		          			<input type="hidden" id="cumulmonth" value="{{ $cumulRetraitMonth }}" name="cumulmonth">

		          			<input type="hidden" name="frais" id="frais">
		          			<input type="hidden" name="num_generer" id="num_generer">

		          			<div class="row">
		          				<div class="form-group col-md-12">
					             	<label>Selectionner le type de compte *</label>
					             	<select class="form-control form-control-xl" name="num_account" id="compte" required>
					             		@foreach( $comptes as $c )
					             		<option value="{{ $c->number_account }}">{{ $c->name }}</option>
					             		@endforeach
					             	</select>
					            </div>

		          				<div class="form-group col-md-6">

			          			  <label style="font-size: 20px;">Selectionner le mode de retrait *</label>
					              <select class="form-control form-control-xl remplir" required name="type_carte" id="type_carte">
					              	<option value="bancaire">Carte Bancaire</option>
					              	<option value="carnet">Chèque</option>
					              	<option value="recu">Reçu</option>
					              </select>

					            </div>

			          			<div class="form-group col-md-6">
			          				<label style="font-size: 20px;">Selectionner le type de personne *</label>
			          				<select class="form-control champs2 form-control-xl remplir" required name="type_personne" id="type_personne">
			          					<option value="titulaire">Titulaire</option>
			          					<option value="mandataire">Mandataire</option>
			          					<option value="porteur">Porteur de chèque</option>
			          				</select>
					            </div>
							</div>
							<div class="row">
								<div class="form-group col-md-6" id="affiche_chp_serie_cheque"></div>
					            <div class="form-group col-md-6" id="affiche_nom_porteur">
					            </div>
							</div>

				            <div class="row">
					            <div class="form-group col-md-6">
			          			  <label style="font-size: 20px;">Type de pièce *</label>
					              <select class="form-control form-control-xl remplir" required name="type_piece" id="type_piece">
					              	<option value="cni">CNI</option>
					              	<option value="autre">Autre</option>
					              </select>
					            </div>

					            <div class="form-group col-md-6">
			          			  <label style="font-size: 20px;">Numéro de la pièce *</label>
					              <input type="text" id="num_piece" class="form-control form-control-xl remplir" name="num_piece" autocomplete="off" required>
					            </div>
				        	</div>



		          			<div class="form-group">
		          			  <label style="font-size: 20px;">Montant du retrait *</label>
				              <input type="text" id="amount" min="1" class="form-control form-control-xl remplir" name="amount" autocomplete="off" required>

				            </div>


				            <div class="form-group">

				              <button type="button" id="btn_ret" data-bs-toggle="modal" data-bs-target="#addRetrait" class="btn btn-primary btn-lg">Valider</button>

				            </div>
		          	</form>

		        </div>

	      	</div>

      	</div>

      	<div class="col-md-5">

			<div class="card">

		        <div class="card-header">

		        		<h2>Resumé du compte: {{ $client->nom }} {{ $client->prenom }}</h2>

		        </div>

		        <div class="card-body">

		          	<div class="list-group" style="">

		              @foreach( $comptes as $c )
		              	<span class="list-group-item" style="font-size: 20px;"><b>Solde {{ $c->name }}:</b> {{ number_format($c->solde, 0, 2, ' ') }} BIF</span>
		              @endforeach

		              <span class="list-group-item"><b>Nom et Prenom(s) du client: </b>{{ $client->nom }} {{ $client->prenom }}</span>

		              @if($client->email != null )

		              <span class="list-group-item"><b>Email: </b>{{ $client->email }}</span>

		              @endif

		              @foreach( $mandataires as $c )
		              <span class="list-group-item"><b>Nom et Prénom(s) du madataire: </b>{{ $c->nom_mandataire }}</span>
		              <span class="list-group-item"><b>CNI du madataire: </b>{{ $c->cni_mandataire }}</span>
		              @endforeach

		            </div>

		        </div>

		      </div>
      	</div>

	      

    	</div>

  	</section>


  	<!--CONFIRMATION-->

  	<div class="modal fade text-left w-100" id="addRetrait" tabindex="-1" role="dialog" aria-hidden="true">

	    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">

	      <div class="modal-content">

	        <div class="modal-header bg-primary white">

	          <sapn class="modal-title" id="myModalLabel16">
	            Reviser le retrait
	          </sapn>

	          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
	            <i data-feather="x"></i>
	          </button>

	        </div>

	        <div class="modal-body">

	        	<form action="{{ route('retrait-new-valid') }}" enctype='multipart/form-data' method="POST">
				      	<div class="modal-body">
			        		<div class="alert alert-warning">
			        		</div>

			        		{{ csrf_field() }}

			        		<input type="hidden" id="num_account_select" name="num_account">
			        		<input type="hidden" id="result_amount" name="amount">
			        		<input type="hidden" id="result_type_personne" name="type_personne">
			        		<input type="hidden" id="result_type_piece" name="type_piece">
			        		<input type="hidden" id="result_num_piece" name="num_piece">
			        		<input type="hidden" id="result_file_piece" name="file_piece">
			        		<input type="hidden" id="result_nom_porteur" name="nom_porteur">
			        		<input type="hidden" id="result_serie_cheque" name="serie_cheque">
			        		<input type="hidden" id="result_type_carte" name="type_carte">


			        		<input type="hidden" id="result_frais" name="frais">

			        		<div class="row">
			        			<div class="col-md-5">
					        		<div id="dragula-right" class="content">
						          		<div class="rounded border mb-2">
						                  <div class="card-body p-3">
						                    <div class="media">
						                      <i class="bi bi-users icon-sm align-self-center me-3"></i>
						                      <div class="media-body">
						                        <h4 class="mb-1">Numéro de compte</h4>
						                        <p class="mb-3 text-muted" style="font-size: 18px;"><span id="affiche_num_account"></span>
						                        </p>

						                        <h4 class="mb-1">Type de la personne</h4>
						                        <p class="mb-3 text-muted" style="font-size: 18px;">
						                        	<span id="affiche_type_personne" style="font-weight: bold; color: #FF0000;"></span>
						                        </p>

						                        <h4 class="mb-1">Type de la pièce</h4>
						                        <p class="mb-3 text-muted" style="font-size: 18px;">
						                        	<span id="affiche_type_piece" style="font-weight: bold; color: #FF0000;"></span>
						                        </p>

						                        <h4 class="mb-1">Numéro de la pièce</h4>
						                        <p class="mb-3 text-muted" style="font-size: 18px;">
						                        	<span id="affiche_num_piece" style="font-weight: bold; color: #FF0000;"></span>
						                        </p>

						                     

						                        <span id="affiche_name_type_personne">
						                    	</span>
						                    	<span id="affiche_serie_cheque">
						                    	</span>
					                        	

					                        	

					                        	<h4 class="mb-1">Montant à retirer</h4>
						                        <p class="mb-3 text-muted" style="font-size: 18px;">
						                        	<span id="affiche_amount" style="font-weight: bold; color: #FF0000;"></span>
						                        </p>

						                        <h4 class="mb-1">Frais</h4>
						                        <p class="mb-3 text-muted" style="font-size: 18px;">
						                        	<span id="affiche_frais" style="font-weight: bold; color: #FF0000;"></span>
						                        </p>

						                        <h4 class="mb-1">Total à prelever</h4>
						                        <p class="mb-3 text-muted" style="font-size: 18px;">
						                        	<span id="affiche_total_prelever" style="font-weight: bold; color: #FF0000;"></span>
						                        </p>

						                        <h4 class="mb-1">Date du retrait</h4>
						                        <p class="mb-4 text-muted" style="font-size: 18px;">
						                        	<?= date('d/m/Y'); ?>
						                        </p>

						                      </div>
						                    </div>
						                  </div>
						              	</div>
						            </div>
								</div>

								<div class="col-md-7" id="dragula-right" class="content">
									<div class="rounded border mb-2">
					                  	<div class="card-body p-3">
					                  		<div class="media">
						                  		<div class="media-body">
						                  			<input type="hidden" id="result_final" name="result_verif">

													<table class="table">

							                          <thead>

							                            <th>Billet</th>

							                            <th>Nombre de billet</th>

							                            <th>Total</th>

							                          </thead>

							                          <tbody>

							                            @foreach( $billets as $b )

							                            <tr>

							                              <td><h4>{{ $b->montant }}</h4></td>

							                              <td>

							                                <input type="number" style="font-size: 18px;" min="0" class="form-control form-control-xl" id="nb_{{ $b->montant }}" name="nb_{{ $b->montant }}">



							                                <input type="hidden" value="{{ $b->id }}" name="billet_id_{{ $b->montant }}">

							                              </td>

							                              <td>

							                                <h4 id="result_{{ $b->montant }}"></h4>

							                              </td>

							                            </tr>

							                            @endforeach

							                          </tbody>
							                        </table>
							                        <div class="col-md-12 mt-5" style="text-align: center; color: red;">
								                        <h4 id="result"></h4>
							                      	</div>
												</div>
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
<script src="/assets/js/_bil.js"></script>
<script src="/assets/js/_ret.js"></script>

@endsection