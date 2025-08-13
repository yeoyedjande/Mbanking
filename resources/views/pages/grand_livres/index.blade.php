@extends('layouts.template')

@section('title', 'Personnalisation du Grand Livre')

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

	              Personnalisation du Grand Livre

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
        <!--Recherche par compte-->
      	<div class="col-md-4">


      		<div class="card">

		        <div class="card-header">
	        		<h2>Génerer par intervalle de compte</h2>
		        </div>

		        <div class="card-body">

              <form method="POST" action="{{ route('grand-livre-search-compte-intervalle') }}">

                  {{ csrf_field() }}
		        	    <div class="row">

                    <div class="col-12">
                      <div class="form-group">
                        <label>Du compte *</label>
                        <select class="form-control form-control-xl" required name="du_compte">
                          <option value="">Selectionner</option>
                          @foreach($compteComptables as $c)
                          <option value="{{ $c->numero }}">{{ $c->numero }} {{ $c->libelle }}</option>
                          @endforeach
                        </select>                      
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                        <label>Au compte *</label>
                        <select class="form-control form-control-xl" required name="au_compte">
                          <option value="">Selectionner</option>
                          @foreach($compteComptables as $c)
                          <option value="{{ $c->numero }}">{{ $c->numero }} {{ $c->libelle }}</option>
                          @endforeach
                        </select>                      
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                        <label>Affichage *</label>
                        <select class="form-control form-control-xl" required name="affichage">
                          <option value="condense">Condensé</option>
                          <option value="detail">Détaillé</option>
                        </select>                      
                      </div>
                    </div>


                    <div class="col-12">
                      <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-lg">Lancer -></button>
                      </div>
                    </div>
                  </div>

              </form>
		          	
		        </div>

	      	</div>
      	</div>
        <!--Fin Recherche par compte-->


        <!--Recherche par intervalle-->
        <div class="col-md-4">


          <div class="card">

            <div class="card-header">
              <h2>Génerer par intervalle de date</h2>
            </div>

            <div class="card-body">

              <form method="POST" action="{{ route('grand-livre-search-date-intervalle') }}">

                  {{ csrf_field() }}
                  <div class="row">

                    <div class="col-12">
                      <div class="form-group">
                        <label>Date Début</label>
                        <input type="date" value="<?= date('d/m/Y'); ?>" class="form-control form-control-xl" name="date_debut">                      
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                        <label>Date Fin</label>
                        <input type="date" value="<?= date('d/m/Y'); ?>" class="form-control form-control-xl" name="date_fin">                      
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                        <label>Affichage *</label>
                        <select class="form-control form-control-xl" required name="affichage">
                          <option value="condense">Condensé</option>
                          <option value="detail">Détaillé</option>
                        </select>                      
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-lg">Lancer -></button>
                      </div>
                    </div>
                  </div>
              </form>
                
            </div>

          </div>
        </div>
        <!--Fin Recherche par Intervalle-->


        <!--Recherche par période-->
        <div class="col-md-4">


          <div class="card">

            <div class="card-header">
              <h2>Génerer par période</h2>
            </div>

            <div class="card-body">

              <form method="POST" action="{{ route('grand-livre-search-periode') }}">

                  {{ csrf_field() }}
                  <div class="row">

                    
                    <div class="col-12">
                      <div class="form-group">
                        <label>Période *</label>
                        <select class="form-control form-control-xl" name="periode" required>
                          <option value="">Selectionner</option>
                          <option value="day">Aujourd'hui</option>
                          <option value="week">Semaine</option>
                          <option value="month">Mois</option>
                        </select>                      
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                        <label>Affichage *</label>
                        <select class="form-control form-control-xl" required name="affichage">
                          <option value="condense">Condensé</option>
                          <option value="detail">Détaillé</option>
                        </select>                      
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-lg">Lancer -></button>
                      </div>
                    </div>
                  </div>

              </form>
                
            </div>

          </div>
        </div>
        <!--Fin Recherche par période-->
    	</div>
  	</section>
@endsection