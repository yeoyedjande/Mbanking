@extends('layouts.template')

@section('title', 'Faire un versement')





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

	              Faire un versement

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

		          			<input type="hidden" value="{{ $cumulVersementJour }}" id="cumulday" name="cumulday">

		          			<input type="hidden" id="num_generer" name="num_generer">

		          			<div class="form-group">
				             	<label>Selectionner le type de compte *</label>
				             	<select class="form-control form-control-xl" name="num_account" id="compte" required>
				             		<option value="">Selectionner</option>
				             		@foreach( $comptes as $c )
				             		<option value="{{ $c->number_account }}">{{ $c->name }}</option>
				             		@endforeach
				             	</select>
				            </div>

		          			<div class="form-group">

				             	<label>Nom et Prénom(s) du déposant *</label>
				             	<input type="text" id="nom_deposant" required class="form-control form-control-xl" name="nom_deposant" autocomplete="0">
				            </div>

				            <div class="form-group">

				             	<label>Téléphone du déposant *</label>
				             	<input type="text" id="tel_deposant" required class="form-control form-control-xl" name="tel_deposant" autocomplete="0">
				            </div>

		          			<div class="form-group">

		          			  <label>Montant à verser *</label>
				              <input type="text" id="amount" min="1" class="form-control form-control-xl" pattern="[0-9]*" name="amount" autocomplete="off" required>

				            </div>

				            <div class="form-group">

		          			  <label>Motif du versement</label>
				              <textarea class="form-control form-control-xl" rows="" name="motif_versement" id="motif_versement"></textarea>

				            </div>


				            <div class="form-group">

				              <button type="button" id="btn_vers" data-bs-toggle="modal" data-bs-target="#addVersement" class="btn btn-primary btn-lg">Valider</button>

				            </div>

		          	</form>

		        </div>

		      </div>

      	</div>

      	<div class="col-md-6">

			<div class="card">

		        <div class="card-header">

		        		<h2>Resumé du compte: {{ $client->nom }} {{ $client->prenom }}</h2>

		        </div>

		        <div class="card-body">

		          	<div class="list-group" style="">

		          	  @foreach( $comptes as $c )
		              	<span class="list-group-item" style="font-size: 20px;"><b>Solde {{ $c->name }}:</b> {{ number_format($c->solde, 0, 2, ' ') }} BIF</span>
		              @endforeach
		              <span class="list-group-item"><b>Nom et Prenom(s) du client: </b>{{ $client->nom }}  {{ $client->prenom }}</span>

		              @if($client->email != null )
		              <span class="list-group-item"><b>Email: </b>{{ $client->email }}</span>
		              @endif

		            </div>

		        </div>

		    </div>

      	</div>

	      

    	</div>

  	</section>


  	<!--CONFIRMATION-->

  	<div class="modal fade text-left" id="addVersement" tabindex="-1" role="dialog" aria-hidden="true">

	    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">

	      <div class="modal-content">

	        <div class="modal-header bg-primary white">

	          <sapn class="modal-title" id="myModalLabel150">
	            Reviser le versement
	          </sapn>

	          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
	            <i data-feather="x"></i>
	          </button>

	        </div>

	        <div class="modal-body">

	        	<form action="{{ route('versement-new-valid') }}" method="POST">
				      	<div class="modal-body">
			        		<div class="alert alert-warning">
			        		</div>

			        		{{ csrf_field() }}

			        		<input type="hidden" id="num_account_select" name="num_account">

			        		<input type="hidden" id="result_amount" name="amount">
			        		<input type="hidden" id="result_nom_deposant" name="nom_deposant">
			        		<input type="hidden" id="result_tel_deposant" name="tel_deposant">
			        		<input type="hidden" id="result_motif_versement" name="motif_versement">

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

						                        <h4 class="mb-1">Nom du déposant</h4>
					                        	<p class="mb-3 text-muted" style="font-size: 18px;"><span id="affiche_nom_deposant"></span>
					                        	</p>

					                        	<h4 class="mb-1">Numéro de téléphone du déposant </h4>
					                        	<p class="mb-3 text-muted" style="font-size: 18px;">
					                        		<span id="affiche_tel_deposant"></span>
					                        	</p>

					                        	<h4 class="mb-1">Montant à verser</h4>
						                        <p class="mb-3 text-muted" style="font-size: 18px;">
						                        	<span id="affiche_amount" style="font-weight: bold; color: #FF0000;"></span>
						                        </p>

						                        <h4 class="mb-1">Date du versement</h4>
						                        <p class="mb-4 text-muted" style="font-size: 18px;">
						                        	<?= date('d/m/Y'); ?>
						                        </p>

						                        <h4 class="mb-1">Motif du versement</h4>
						                        <p class="mb-3 text-muted" style="font-size: 18px;">
						                        	<span id="affiche_motif"></span>
						                        </p>
						                      </div>
						                    </div>
						                  </div>
						              	</div>
						            </div>
					        	</div>
					        	<div class="col-md-7">
					        		<div id="dragula-right" class="content">
						          		<div class="rounded border mb-2">
						                  <div class="card-body p-3">
						                    <div class="media">
						                      <i class="bi bi-users icon-sm align-self-center me-3"></i>
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
<script src="/assets/js/_vers.js"></script>

@endsection