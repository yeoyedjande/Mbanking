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

		          			<input type="hidden" value="{{ $data->number_account }}" name="num_account">

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

		        			<div class="col-md-6" style="text-align: right;">
								<a target="_blank" href="{{ route('releve-prints', [$account_num, $date_debut, $date_fin]) }}" class="btn btn-primary btn-lg"><i class="bi bi-printer"></i> Imprimer le relevé</a>
		        			</div>

		        		</div>
		        		

		        </div>

		        <div class="card-body">
		        	@if( $operations->isNotEmpty() )
		          	<table id="table1" class="table table-striped">
		          			<thead>
		          				<th>N°</th>
		          				<th>Date Operation</th>
		          				<th>Montant</th>
		          				<th>Type Operation</th>
		          			</thead>

		          			<tbody>

		          					@php $i = 1; @endphp

		          					@foreach( $operations as $op )
		          					<tr>
		          							<td>{{ $i++ }}</td>
		          							<td>{{ $op->date_op }}</td>
		          							<td><b>{{ number_format($op->montant + $op->frais, 0, 2, ' ') }} BIF</b></td>
		          							<td>{{ $op->name }}</td>
		          					</tr>
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

@endsection



@section('js')
<script src="/assets/extensions/jquery/jquery.min.js"></script>
@endsection