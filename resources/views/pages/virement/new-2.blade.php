@extends('layouts.template')

@section('title', 'Virements')


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
                <a href="{{ route('dashboard') }}">Tableau de bord</a>
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


  	<div class="row">

	    <div class="col-md-7">

	      <div class="card">

	        <div class="card-body">


	          <form class="form_virement" action="#" method="POST">

	            {{ csrf_field() }}


	            <input type="hidden" value="{{ $data->number_account }}" name="num_account_exp">

	            <div class="row">



	            	<div class="col-md-12">

									<div class="form-group">

			              <label for="num_account">Numéro de compte du destinataire * </label>

			              <input type="text"  class="form-control form-control-xl" id="num_account_dest" name="num_account_dest" autocomplete="0" required>

			            </div>

	            	</div>



	            	<div class="col-md-12">

									<div class="form-group">

			              <label for="amount">Montant à envoyer * </label>

			              <input type="text" id="amount" min="1" class="form-control form-control-xl" name="amount" autocomplete="0" required>

			            </div>

	            	</div>

	            	<div class="col-md-12">

									<div class="form-group">

			              <label for="amount">Motif du virement * </label>

			              <textarea rows="5" id="motif_virement" name="motif_virement" class="form-control form-control-xl" required></textarea>

			            </div>

	            	</div>

	            	

								<div class="col-md-12">

									<div class="form-group">

			              <button type="button" id="btn_virement" data-bs-toggle="modal" data-bs-target="#addVirement" class="btn btn-primary btn-lg"> <i class="bi bi-arrow-down"></i> &nbsp;&nbsp; Valider</button>

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
	      		<h4>Resumé de compte: {{ $data->number_account }}</h4>
	      	</div>

	        <div class="card-body">

	            <div class="row">

                	<div class="list-group" style="">

			              <span class="list-group-item"><b>Solde:</b> {{ number_format($data->solde, 0, 2, ' ') }} BIF</span>

			              <span class="list-group-item"><b>Nom et Prénom(s) du client: </b>{{ $data->nom }} @if($data->prenom != 'NULL' ) {{ $data->prenom }} @endif</span>

			              @if($data->email != 'NULL' )

			              <span class="list-group-item"><b>Email: </b>{{ $data->email }}</span>

			              @endif

			              <span class="list-group-item"><b>Type de compte: </b>{{ $data->name }}</span>

			            </div>

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

	        	<form action="{{ route('virement-new-confirm-valid') }}" method="POST">
				      	<div class="modal-body">
			        		<div class="alert alert-warning">
			        		</div>

			        		{{ csrf_field() }}
			        		<input type="hidden" value="{{ $data->number_account }}" name="num_account">

			        		<input type="hidden" id="result_amount" name="amount">
			        		<input type="hidden" id="result_num_account_dest" name="num_account_dest">
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
				                        <p class="mb-3 text-muted" style="font-size: 18px;">{{ $data->number_account }} ({{ $data->nom }} {{ $data->prenom }})
				                        </p>

				                        <h4 class="mb-1">Numéro de compte destinataire</h4>
			                        	<p class="mb-3 text-muted" style="font-size: 18px;"><span id="affiche_num_compte_destinataire"></span>
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
<script src="/assets/js/_vir.js"></script>



@endsection