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

                Type de crédit

              </li>

            </ol>

          </nav>

        </div>

      </div>

  </div>
</div>


  <div class="row">



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

    <div class="col-md-12">

      	<div class="card">

	        <div class="card-header">

	            <div class="d-flex justify-content-between align-items-center">

	                <h3 class="card-title">Créer un type de crédit</h3>

	                <a href="{{ route('types_credits.index') }}" class="btn btn-primary">

	                    <i class="bi bi-list"></i> Liste des types de crédit

	                </a>

	            </div>

	        </div>

        	<div class="card-body">

          		<form class="forms-sample" action="{{ route('TypesCreditsCreateValid') }}" method="POST">


		            {{ csrf_field() }}
		            <div class="row">

			            <div class="col-md-6">
				            <div class="form-group">
							    <label for="name">Nom du type de crédit <span class="text-danger"> *</span></label>
							    <input type="text" class="form-control form-control-xl" value="{{ old('name') }}" id="name" name="name" require autocomplete="0" />
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
							    <label for="taux">Taux d'intérêt<span class="text-danger"> *</span></label>
							    <input type="text" class="form-control form-control-xl" value="{{ old('taux') }}" id="taux" name="taux" />
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
							    <label for="montant_min">Montant minimum<span class="text-danger"> *</span></label>
							    <input type="number" class="form-control form-control-xl" value="{{ old('montant_min') }}" id="montant_min" name="montant_min" />
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
							    <label for="montant_max">Montant maximum<span class="text-danger"> *</span></label>
							    <input type="number" class="form-control form-control-xl" value="{{ old('montant_max') }}" id="montant_max" name="montant_max" />
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
							    <label for="duree_mois_min">Durée en mois minimum<span class="text-danger"> *</span></label>
							    <input type="number" class="form-control form-control-xl" value="{{ old('duree_mois_min') }}" id="duree_mois_min" name="duree_mois_min" />
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
							    <label for="duree_mois_max">Durée en mois maximum<span class="text-danger"> *</span></label>
							    <input type="number" class="form-control form-control-xl" value="{{ old('duree_mois_max') }}" id="duree_mois_max" name="duree_mois_max" />
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
							    <label for="periodicite">Périodicité<span class="text-danger"> *</span></label>
							    <input type="number" class="form-control form-control-xl" value="{{ old('periodicite') }}" id="periodicite" name="periodicite" />
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
							    <label for="montant_frais">Montant des frais<span class="text-danger"> *</span></label>
							    <input type="number" class="form-control form-control-xl" value="{{ old('montant_frais') }}" id="montant_frais" name="montant_frais" />
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
							    <label for="montant_commission">Montant de la commission<span class="text-danger"> *</span></label>
							    <input type="number" class="form-control form-control-xl" value="{{ old('montant_commission') }}" id="montant_commission" name="montant_commission" />
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
							    <label for="montant_assurance">Montant de l'assurance<span class="text-danger"> *</span></label>
							    <input type="number" class="form-control form-control-xl" value="{{ old('montant_assurance') }}" id="montant_assurance" name="montant_assurance" />
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
							    <label for="pourcentage_commission">Pourcentage de commission (%)<span class="text-danger"> *</span></label>
							    <input type="text" class="form-control form-control-xl" value="{{ old('pourcentage_commission') }}" id="pourcentage_commission" name="pourcentage_commission" />
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
							    <label for="pourcentage_assurance">Pourcentage de l'assurance (%)<span class="text-danger"> *</span></label>
							    <input type="text" class="form-control form-control-xl" value="{{ old('pourcentage_assurance') }}" id="pourcentage_assurance" name="pourcentage_assurance" />
							</div>
						</div>	

						<div class="col-md-6">
							<div class="form-group">
							    <label for="delai_grace_jour">Délai de grâce (en jours)<span class="text-danger"> *</span></label>
							    <input type="number" class="form-control form-control-xl" value="{{ old('delai_grace_jour') }}" id="delai_grace_jour" name="delai_grace_jour" />
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
							    <label for="differe_jour_max">Différé maximum (en jours)<span class="text-danger"> *</span></label>
							    <input type="number" class="form-control form-control-xl" value="{{ old('differe_jour_max') }}" id="differe_jour_max" name="differe_jour_max" />
							</div>
						</div>

					</div>


		            <button type="submit" class="btn btn-primary me-2"> Créer </button>

		            <button class="btn btn-danger" type="reset">Cancel</button>

          		</form>

        	</div>

      	</div>

    </div>


  </div>



@endsection



@section('js')
<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}" id="parsley"></script>
<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/assets/js/pages/simple-datatables.js"></script>

@endsection
