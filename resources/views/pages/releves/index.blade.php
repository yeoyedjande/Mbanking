@extends('layouts.template')

@section('title', 'Releves de compte')





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



    @if( session()->has('msg_info') )

    <div class="col-md-12">

        <div class="alert alert-info">{{ session()->get('msg_info') }}</div>

    </div>

    @endif





    <section class="section">

      

      <div class="row">

      	<div class="col-md-6">
      		<h4>Solde: <span style="color: green;">{{ number_format($data->solde, 0, 2, ' ') }} BIF</span></h4>
      	</div>
      	<div class="col-md-6" style="text-align: right;">
      		<h4>Client: {{ $data->nom }} @if($data->prenom != 'NULL' ) {{ $data->prenom }} @endif</h4>
      	</div>

      	<div class="col-md-12 mt-5">

      		<div class="card">

		        <div class="card-header">

		        		<h3>Faire une recherche par intervalle de date</h3>

		        </div>

		        <div class="card-body">

		          	<form class="form_versement" method="GET" action="{{ route('releve-search-2') }}">

		          			{{ csrf_field() }}

		          			<input type="hidden" value="{{ $data->number_account }}" name="flash">

		          			<div class="row">
			          			<div class="form-group col-md-6">

					             	<label>Date de Début *</label>
					             	<input type="date" id="date_debut" required class="form-control form-control-xl" required name="date_debut" autocomplete="0">
					            </div>

			          			<div class="form-group col-md-6">

			          			  <label>Date de Fin *</label>
					              <input type="date" id="date_fin" min="1" class="form-control form-control-xl" required name="date_fin" autocomplete="off" required>

					            </div>
										</div>
				            <div class="form-group">

				              <button type="submit" class="btn btn-primary btn-lg">Rechercher</button>

				            </div>

		          	</form>

		        </div>

		      </div>

      	</div>

      	<div class="col-md-12 mt-5">

      		<div class="card">

		        <div class="card-header">

		        		<div class="row">
		        			<div class="col-md-6">
								<h3>Liste des operations</h3>
		        			</div>
		        			@if( $operations->isNotEmpty() )
		        			<div class="col-md-6" style="text-align: right;">
								<a data-bs-toggle="modal" data-bs-target="#ValidPrint" href="javascript(0);" class="btn btn-primary btn-lg"><i class="bi bi-printer"></i> Imprimer le relevé</a>
								<!--<a target="_blank" href="{{ route('releve-print', [$account_num]) }}" class="btn btn-primary btn-lg"><i class="bi bi-printer"></i> Imprimer le relevé</a>-->
		        			</div>
		        			@endif
		        		</div>
		        		

		        </div>

		        <div class="card-body">
		        	@if( $operations->isNotEmpty() )
		          	<table id="table1" class="table table-striped">
		          			<thead>
		          				<th>Date Operation</th>
		          				<th>Reference</th>
		          				<th>Type operation</th>
		          				<th>Versements</th>
		          				<th>Retraits</th>
		          				<th>Virements</th>
		          				<th>Solde</th>
		          			</thead>

		          			<tbody>

		          					@php $i = 1; @endphp

		          					@foreach( $operations as $op )
		          					<tr>
		          							<td>{{ $op->date_op }}</td>
		          							<td>{{ $op->ref }}</td>

		          							<td>
		          								@if( $op->type_operation_id == 2 )
		          								Retrait
		          								@elseif($op->type_operation_id == 3)
		          								Versement
		          								@else
		          								Virement
		          								@endif
		          							</td>

		          							<td>
		          								@if( $op->type_operation_id == 3)
												{{ number_format($op->montant, 0, 2, ' ') }} BIF

												<?php $solde = $op->solde + $op->montant; ?>
												@endif
		          							</td>
		          							<td>
		          								@if( $op->type_operation_id == 2)
												{{ number_format($op->montant, 0, 2, ' ') }} BIF

												<?php $solde = $op->solde - $op->montant; ?>
												@endif
											</td>

											<td>
		          								@if( $op->type_operation_id == 1)
												{{ number_format($op->montant, 0, 2, ' ') }} BIF
												<?php $solde = $op->solde - $op->montant; ?>
												@endif
											</td>

		          							<td>
		          								{{ number_format($solde, 0, 2, ' ') }} BIF
		          							</td>
		          					</tr>

		          					<?php 

		                                  $f = DB::table('operations')->join('type_frais', 'type_frais.id', '=', 'operations.frais')->Select('type_frais.*')->Where('operations.id', $op->id)->first();

		                                  if ( $f ) {
		                                  
		                              ?>

		          					<tr>
		          							<td>{{ $op->date_op }}</td>
		          							<td>{{ $op->ref }}</td>

		          							<td>
		          								{{ $f->name }}
		          							</td>

		          							<td>
		          								
		          							</td>
		          							<td>
		          								
												{{ number_format($f->montant, 0, 2, ' ') }} BIF
												
											</td>

											<td>
		          								
											</td>

		          							<td>
		          								{{ number_format($solde, 0, 2, ' ') }} BIF
		          							</td>
		          					</tr>

		          					<?php } ?>
		          					@endforeach
		          			</tbody>
		          	</table>
		          	@else

		          	<div class="alert alert-info">

	                <h4 class="alert-heading">Info</h4>

	                <p>Il n'y a pas d'operations disponible en ce moment pour ce client !</p>

	              </div>
		          @endif

		        </div>

		      </div>

      	</div>


    	</div>

  	</section>

  	<div class="modal fade text-left" id="ValidPrint" tabindex="-1" role="dialog" aria-hidden="true">

	    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">

	      <div class="modal-content">

	        <div class="modal-header bg-dark white">

	          <sapn class="modal-title" id="myModalLabel150">
	            Resumé d'impression du relevé
	          </sapn>

	          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">

	            <i data-feather="x"></i>

	          </button>

	        </div>

	        <div class="modal-body">

	        	<form class="" method="POST" action="{{ route('releve-print') }}">

	        		{{ csrf_field() }}

	        		<input type="hidden" name="number_of_pages" value="{{ $number_of_pages }}">
	        		<input type="hidden" name="price_per_page" value="{{ $price_per_page }}">
	        		<input type="hidden" name="num_account" value="{{ $account_num }}">

	        		<div id="dragula-right" class="content">
		          		<div class="rounded border mb-2">
		                  <div class="card-body p-3">
		                    <div class="media">
		                      <i class="bi bi-user icon-sm align-self-center me-3"></i>
		                      <div class="media-body">
		                        <h4 class="mb-1">Nombre de pages: </h4>
		                        <p class="mb-3 text-muted" style="font-size: 18px; color: #000000;">{{ number_format($number_of_pages, 0, 2, ' ') }}
		                        </p>

	                        	<h4 class="mb-1">Prix par page</h4>
		                        <p class="mb-3 text-muted" style="font-size: 18px;">
		                        	<span id="affiche_amount" style="font-weight: bold; color: #FF0000;">{{ number_format($price_per_page, 0, 2, ' ') }} BIF</span>
		                        </p>

		                        <h4 class="mb-1">Prix total à payer</h4>
		                        <p class="mb-3 text-muted" style="font-size: 18px;">
		                        	<span id="affiche_amount" style="font-weight: bold; color: #FF0000;">{{ number_format($price_per_page * $number_of_pages, 0, 2, ' ') }} BIF</span>
		                        </p>
		                      </div>
		                    </div>
		                  </div>
		              	</div>
		            </div>

		            <div class="form-group mt-4">

		                  <button type="button" class="btn btn-dark btn-lg" data-bs-dismiss="modal">

		                    <i class="bx bx-x d-block d-sm-none"></i>

		                    <span class="d-none d-sm-block">Fermer</span>

		                  </button>

		                  <button type="submit" class="btn btn-primary btn-lg">

		                    <i class="bx bx-check d-block d-sm-none"></i>

		                    <span class="d-none d-sm-block">Payer et Imprimer ></span>

		                  </button>

		                </div>
	            	</div>
				</form>
	        </div>

	      </div>

	    </div>

	</div>
@endsection



@section('js')
<script src="/assets/extensions/jquery/jquery.min.js"></script>

@endsection