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

			              <input type="date" value="<?php if(!empty($_POST['date_start'])){ echo $_POST['date_start']; } ?>" required id="date_start" name="date_start" class="form-control form-control-xl">

			            </div>

		        	</div>



		        	<div class="col-md-6">

						<div class="form-group">

			              <label for="date_end">Date de fin* </label>

			              <input type="date" value="<?php if(!empty($_POST['date_end'])) echo $_POST['date_end']; ?>" required id="date_end" name="date_end" class="form-control form-control-xl">

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



	<div class="col-md-12 grid-margin stretch-card">

	  

	  <div class="card">

	    <div class="card-body">

	      <!--<h4 class="card-title mb-4">Faire un retrait</h4>-->



	        <div class="row">



	        	<div class="col-12">

              	  @if( $rapports->isNotEmpty() )

	              <table id="order-listing" class="table" cellspacing="0" width="100%">

	                <thead>

	                  <tr class="bg-primary text-white">

	                    <th>N°</th>

	                    <th>Numéro de compte</th>

	                    <th>Nom et Prénom(s)</th>

	                    <th>Opération</th>

	                    <th>Montant</th>

	                    <th>Date Opération</th>

	                    <th>Actions</th>

	                  </tr>

	                </thead>

	                <tbody>

	                  @php

	                  $i = 1;

	                  @endphp

	                  

	                  @foreach( $rapports as $m )

	                  <tr>

	                      <td>{{ $i++ }}</td>

	                      <td>{{ $m->number_account }}</td>

	                      <td>{{ $m->nom }} @if($m->prenom != 'NULL') {{ $m->prenom }} @endif</td>

	                      <td>{{ $m->name }}</td>

	                      <td><b>{{ number_format($m->montant, 0, 2, ' ') }} BIF</b></td>

	                      <td>{{ $m->date_op }}</td>



	                      <td>

	                        <a href="#" class="btn btn-success">

	                        <i class="mdi mdi-eyes"></i>Details </a>

	                      </td>

	                  </tr>

	                  @endforeach

	                </tbody>

	              </table>

	              @else

	              <div class="alert alert-danger"> La recherche demandée n'a abouti à aucun résultat. </div>

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