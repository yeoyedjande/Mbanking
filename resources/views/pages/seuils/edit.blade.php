@extends('layouts.template')

@section('title', 'Définition des seuils')

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

	              Editer une définition des seuils

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
	        		<h2>Versement</h2>
		        </div>

		        <div class="card-body">

		          	<form class="" method="POST" enctype='multipart/form-data' action="{{ route('seuil-valid-versement') }}">

		          			{{ csrf_field() }}

	          				<div class="form-group">
				             	<label>Période *</label>
				             	<select class="form-control form-control-xl" name="periode" id="periode" required>

				             		<option value="">Selectionner</option>
				             		<option value="day">Journée</option>
				             		<option value="week">Semaine</option>
				             		<option value="month">Mois</option>
				             		<option value="year">Année</option>

				             	</select>
				            </div>



		          			<div class="form-group">
		          			  <label style="">Montant limite *</label>
				              <input type="text" value="" id="amount" min="1" class="form-control form-control-xl remplir" name="amount" autocomplete="off" required>
				            </div>


				            <div class="form-group">

				              <button type="submit" id="btn_ret" class="btn btn-primary btn-lg">Valider</button>

				            </div>
		          	</form>

		          	<hr>

		          	<div class="table-responsive">
		          		<table class="table table-bordered">
		          			<thead>
		          				<th>N°</th>
		          				<th>Période</th>
		          				<th>Montant</th>
		          				<th>Action</th>
		          			</thead>
		          			<tbody>
		          				@php $i = 0; @endphp

		          				@foreach( $seuil_vers as $s )
		          					<tr>
		          					<td>{{ $i++ }}</td>
		          					<td>{{ $s->periode }}</td>
		          					<td>{{ $s->montant_limite }}</td>
		          					<td>
		          						<a href="{{ route('seuil-edit-versement', $s->id) }}" class="btn btn-primary">Editer</a>
		          					</td>
		          					</tr>
		          				@endforeach
		          			</tbody>
		          		</table>
		          	</div>
		        </div>

	      	</div>

      	</div>

      	<div class="col-md-6">

			<div class="card">

		        <div class="card-header">
		        	<h2>Retrait</h2>
		        	<a href="#" class="btn btn-primary btn-xs">Ajouter un seuil</a>
		        </div>

		        <div class="card-body">

		        	<form class="" method="POST" enctype='multipart/form-data' action="{{ route('seuil-edit-retrait-valid') }}">

		          			{{ csrf_field() }}
		          			<input type="hidden" name="id" value="{{ $seuil->id }}">

	          				<div class="form-group">
				             	<label>Période *</label>
				             	<select class="form-control form-control-xl" name="periode" id="periode" required>

				             		<option value="">Selectionner</option>
				             		<option value="day" <?php if ($seuil->periode == 'day') {
				             			echo "selected";
				             		} ?>>Journée</option>
				             		<option value="week" <?php if ($seuil->periode == 'week') {
				             			echo "selected";
				             		} ?>>Semaine</option>
				             		<option value="month" <?php if ($seuil->periode == 'month') {
				             			echo "selected";
				             		} ?>>Mois</option>
				             		<option value="year" <?php if ($seuil->periode == 'year') {
				             			echo "selected";
				             		} ?>>Année</option>

				             	</select>
				            </div>



		          			<div class="form-group">
		          			  <label style="">Montant limite *</label>
				              <input type="text" id="amount" value="{{ $seuil->montant_limite }}" min="1" class="form-control form-control-xl remplir" name="amount" autocomplete="off" required>
				            </div>


				            <div class="form-group">

				              <button type="submit" id="btn_ret" class="btn btn-primary btn-lg">Valider</button>

				            </div>
		          	</form>

		          	<hr style="margin-top: 15px;">
		          	<div class="table-responsive">
		          		<table class="table table-bordered">
		          			<thead>
		          				<th class="text-center">N°</th>
		          				<th class="text-center">Période</th>
		          				<th class="text-center">Montant</th>
		          				<th class="text-center">Action</th>
		          			</thead>
		          			<tbody>
		          				@php $i = 1; @endphp
		          				
		          				@foreach( $seuils as $s )
		          					<tr>
		          					<td class="text-center">{{ $i++ }}</td>

		          					<td class="text-center">
		          						@if($s->periode == 'day')
		          						Journée
		          						@elseif( $s->periode == 'week' )
		          						Semaine
		          						@elseif( $s->periode == 'month' )
		          						Mois
		          						@else
		          						Année
		          						@endif
		          					</td>

		          					<td class="text-center"><b>{{ number_format($s->montant_limite, 0, 2, ' ') }}</b></td>
		          					<td class="text-center">
		          						<a href="{{ route('seuil-edit-retrait', $s->id) }}" class="btn btn-primary">Editer</a>
		          					</td>
		          					</tr>
		          				@endforeach
		          			</tbody>
		          		</table>
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

</script>

@endsection