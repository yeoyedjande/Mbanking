@extends('layouts.template')



@section('title', 'Create-Etat-crédit')

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

          <h3 style="text-transform: uppercase;">Creation d'un état de crédit</h3>

        </div>

        <div class="col-12 col-md-6 order-md-2 order-first">

          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">

            <ol class="breadcrumb">

              <li class="breadcrumb-item">

                <a href="{{ route('dashboard') }}">Tableau de bord</a>

              </li>

              <li class="breadcrumb-item active" aria-current="page">

                Etat crédit

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

                <h3 class="card-title">Créer un état de crédit</h3>

                <a href="{{ route('etat-credit-index') }}" class="btn btn-primary">

                    <i class="bi bi-list"></i> Liste des états de crédit 

                </a>

            </div>

        </div>

        <div class="card-body">

          <form class="forms-sample" action="{{ route('etat-credit-create-valid') }}" method="POST">


            {{ csrf_field() }}

                <div class="row">

                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="libelle">Libellé Etat crédit<span class="text-danger"> *</span></label>
                          <input type="text" class="form-control form-control-xl" value="{{ old('libelle') }}" id="libelle" name="libelle" required autocomplete="0" />
                      </div>
                  </div>

                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="nbre_jours">Nombre de jours(-1 si dernier état, -2 si état radier) <span class="text-danger"> *</span></label>
                          <input type="text" class="form-control form-control-xl" value="{{ old('nbre_jours') }}" id="nbre_jours" name="nbre_jours" required autocomplete="0" />
                      </div>
                  </div>

                  
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="taux">Taux (%)</label>
                          <input type="text" class="form-control form-control-xl" value="{{ old('taux') }}" id="taux" name="taux" autocomplete="0" />
                      </div>
                  </div>


                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="taux_prov_decouvert">Taux Prov Découvert (%)</label>
                          <input type="text" class="form-control form-control-xl" value="{{ old('taux_prov_decouvert') }}" id="taux_prov_decouvert" name="taux_prov_decouvert" autocomplete="0" />
                      </div>
                  </div>

                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="taux_prov_reechelonne">Taux Prov Reechelonne(%)</label>
                          <input type="text" class="form-control form-control-xl" value="{{ old('taux_prov_reechelonne') }}" id="taux_prov_reechelonne" name="taux_prov_reechelonne" autocomplete="0" />
                      </div>
                  </div>

                  <div class="col-md-12">
                      <div class="form-group">
                          <label for="provisionne">Provisionne </label>
                          <input type="checkbox" value="t" id="provisionne" name="provisionne" autocomplete="0" />
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
