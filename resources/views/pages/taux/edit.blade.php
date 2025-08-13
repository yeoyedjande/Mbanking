@extends('layouts.template')
@section('title', 'Edit-Taux')



@section('css')
<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
@endsection



@section('content')

<div class="page-heading">

    <div class="page-title">

      <div class="row">

        <div class="col-12 col-md-6 order-md-1 order-last">

          <h3 style="text-transform: uppercase;">Modication des taux</h3>

        </div>

        <div class="col-12 col-md-6 order-md-2 order-first">

          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">

            <ol class="breadcrumb">

              <li class="breadcrumb-item">

                <a href="{{ route('dashboard') }}">Tableau de bord</a>

              </li>

              <li class="breadcrumb-item active" aria-current="page">

                Taux

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

    <div class="col-md-12 grid-margin stretch-card">

      <div class="card">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center">

                <h3 class="card-title">Modifier le taux</h3>

                <a href="{{ route('taux.index') }}" class="btn btn-primary">

                    <i class="bi bi-list"></i> Liste des taux 

                </a>

            </div>

        </div>

        <div class="card-body">

          <form class="forms-sample" action="{{ route('taux-edit-valid') }}" method="POST">


            {{ csrf_field() }}

            <div class="row">

                <input type="hidden" value="{{ $taux->id }}" name="taux_id">

              <div class="col-md-6">

                <div class="form-group">

                  <label for="taux_commission">Taux de commission</label>

                  <input type="number" class="form-control form-control-xl" value="{{ $taux->taux_commission }}" id="taux_commission" name="taux_commission"  autocomplete="0" />

                </div>

              </div>

              <div class="col-md-6">

                <div class="form-group">

                  <label for="taux_interet">Taux d'intérêt </label>

                  <input type="number" class="form-control form-control-xl" value="{{ $taux->taux_interet }}" id="taux_interet" name="taux_interet"  autocomplete="0" />

                </div>

              </div>

              <div class="col-md-6">

                <div class="form-group">

                  <label for="taux_assurance">Taux d'assurance </label>

                  <input type="number" class="form-control form-control-xl" value="{{ $taux->taux_assurance }}" id="taux_assurance" name="taux_assurance"  autocomplete="0" />

                </div>

              </div>


              <div class="col-md-6">

                <div class="form-group">

                  <label for="frais_de_dossier">Montant du frais de dossier </label>

                  <input type="number" class="form-control form-control-xl" value="{{ $taux->frais_de_dossier }}" id="frais_de_dossier" name="frais_de_dossier"  autocomplete="0" />

                </div>

              </div>

            </div>

            

            <button type="submit" class="btn btn-primary me-2"> Modifier </button>

            <button class="btn btn-danger" type="reset">Annuler</button>

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