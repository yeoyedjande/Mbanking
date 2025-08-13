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
        <h3 style="text-transform: uppercase;">caisses du <?= date('d/m/Y'); ?></h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Caisses
            </li>
          </ol>
        </nav>
      </div>
    </div>
</div>

<div class="row">


<!--
	<div class="col-md-6 grid-margin stretch-card">

	  

	  <div class="card">

	    <div class="card-body">

	      <h4 class="card-title mb-4">Selection par période</h4>



	      <form class="forms-sample" action="{{ route('caisse-rapport-result') }}" method="POST">

	      	{{ csrf_field() }}

	        <div class="row">



	        	<div class="col-md-12">

					<div class="form-group">

		              <label for="num_account">Selectionner * </label>

		              <select style="padding-top: 20px;" class="form-control form-control-xl" id="periode" name="periode" required>

		              	<option value="day">Aujourd'hui</option>

		              	<option value="week">Semaine</option>

		              	<option value="month">Mois</option>

		              	<option value="year">Année</option>

		              </select>

		            </div>

	        	</div>



	        	<div class="col-md-12">

					<div class="form-group">

		              <button type="submit" class="btn btn-primary btn-lg">Rechercher</button>

		            </div>

	        	</div>

			</div>

		  </form>



	    </div>

	  </div>

	</div>  



	<div class="col-md-6 grid-margin stretch-card">

	  

	  <div class="card">

	    <div class="card-body">

	      <h4 class="card-title mb-4">Selection par intervalle de date</h4>



	      	<form class="forms-sample" action="{{ route('caisse-rapport-result') }}" method="POST">

		        {{ csrf_field() }}

		        <div class="row">



		        	<div class="col-md-6">

						<div class="form-group">

			              <label for="date_start">Date de début * </label>

			              <input type="date" required id="date_start" name="date_start" class="form-control form-control-xl">

			            </div>

		        	</div>



		        	<div class="col-md-6">

						<div class="form-group">

			              <label for="date_end">Date de fin* </label>

			              <input type="date" required id="date_end" name="date_end" class="form-control form-control-xl">

			            </div>

		        	</div>



		        	<div class="col-md-12">

						<div class="form-group">

			              <button type="submit" class="btn btn-primary btn-lg">Rechercher</button>

			            </div>

		        	</div>

		        	

				</div>

			</form>

	    </div>

	  </div>

	</div> 

-->

	<div class="col-md-12 grid-margin stretch-card">

	  

	  <div class="card">

	    <div class="card-body">

	      <!--<h4 class="card-title mb-4">Faire un retrait</h4>-->



	        <div class="row">



	        	<div class="col-12">

              
	        		@if($historys->isNotEmpty())
	              <table id="table1" class="table" cellspacing="0" width="100%">

	                <thead>

	                  <tr class="">

	                    <th class="text-center">N°</th>
	                    <th class="text-center">Date</th>
	                    <th class="text-center">Caisse</th>
	                    <th class="text-center">Montant à l'ouverture</th>
	                    <th class="text-center">Total retrait</th>
	                    <th class="text-center">Total versement</th>
	                    <th class="text-center">Solde à la clôture</th>
	                    <th class="text-center">Etat de la caisse</th>
	                    <th class="text-center">Ajustement</th>

	                    <th class="text-center">Actions</th>

	                  </tr>

	                </thead>

	                <tbody>

	                  @php

	                  $i = 1;

	                  @endphp

	                  

	                  @foreach( $historys as $m )

	                  <?php 

	                  	$versements = DB::table('operation_mouvements')->join('operations', 'operations.id', '=', 'operation_mouvements.operation_id')
								        ->join('users', 'users.id', '=', 'operations.user_id')
								        ->Where('users.agence_id', Auth::user()->agence_id)
								        ->Where('operation_mouvements.mouvement_id', $m->id)
								        ->Where('operations.type_operation_id', 3)
								        ->get();

								        $total_versement = 0;

								        foreach ($versements as $v) {
								        	$total_versement = $total_versement + $v->montant;
								        }

								        $retraits = DB::table('operation_mouvements')->join('operations', 'operations.id', '=', 'operation_mouvements.operation_id')
								        ->join('users', 'users.id', '=', 'operations.user_id')
								        ->Where('users.agence_id', Auth::user()->agence_id)
								        ->Where('operation_mouvements.mouvement_id', $m->id)
								        ->Where('operations.type_operation_id', 2)
								        ->get();

								        $total_retrait = 0;

								        foreach ($retraits as $r) {
								        	$total_retrait = $total_retrait + $r->montant;
								        }

	                   ?>
	                  <tr>

	                      <td class="text-center">{{ $i++ }}</td>

	                      <td>{{ $m->date_mvmt }}</td>

	                      <td>{{ $m->name }}</td>

	                      <td class="text-center">{{ number_format($m->solde_initial, 0, 2, ' ') }} BIF</td>
	                      <td class="text-center">{{ number_format($total_retrait, 0, 2, ' ') }} BIF</td>
	                      <td class="text-center">{{ number_format($total_versement, 0, 2, ' ') }} BIF</td>

	                      <td class="text-center"><b>{{ number_format($m->solde_final, 0, 2, ' ') }} BIF</b></td>

	                      <td class="text-center">
	                      		@if( $m->verify == 'yes' )
	                      			<span class="badge bg-success">Ouvert</span>
	                      		@endif

	                      		@if( $m->verify == 'ferme' )
	                      			<span class="badge bg-danger">Fermé</span>
	                      		@endif

	                      		@if( $m->verify == 'cancel' )
	                      			<span class="badge bg-danger">Annulé</span>
	                      		@endif
	                      </td>

	                      <td class="text-center"><b> 0 BIF</b></td>

	                      <td>

	                        <a href="#" class="btn btn-primary">

	                        <i class="bi bi-eye"></i> Voir les transactions </a>

	                      </td>

	                  </tr>

	                  @endforeach

	                </tbody>
	              </table>
	            @else
	            	<div class="alert alert-info">
                  <h4 class="alert-heading">Info</h4>
                  <p>Il n'y a pas encore d'operations disponible !</p>
                </div>
	            @endif
	              

	            </div>

	        	

			</div>



	    </div>

	  </div>

	</div>  
</div>



@endsection



@section('js')

<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/assets/js/pages/simple-datatables.js"></script>

@endsection