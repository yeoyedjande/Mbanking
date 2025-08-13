@extends('layouts.template')
@section('title', 'Edit-Banque-Externe')



@section('css')
<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
@endsection



@section('content')

<div class="page-heading">

    <div class="page-title">

      <div class="row">

        <div class="col-12 col-md-6 order-md-1 order-last">

          <h3 style="text-transform: uppercase;">Modication des banques externes</h3>

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

                <h3 class="card-title">Modifier la banque externe</h3>

                <a href="{{ route('banquexternes') }}" class="btn btn-primary">

                    <i class="bi bi-list"></i> Liste des banques externes 

                </a>

            </div>

        </div>

        <div class="card-body">

          <form class="forms-sample" action="{{ route('BanquexternesEditValid') }}" method="POST">


            {{ csrf_field() }}

            <div class="row">

                <input type="hidden" value="{{ $banquexternes->id }}" name="banquexternes_id">

                <div class="col-md-6">

                  <div class="form-group">

                    <label for="name">Nom de la banque</label>

                    <input type="text" class="form-control form-control-xl" value="{{ $banquexternes->name }}" id="name" name="name" required autocomplete="0" />

                  </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="adresse">Adresse</label>
                        <input type="text" class="form-control form-control-xl" value="{{ $banquexternes->adresse }}" id="adresse" required name="adresse" autocomplete="0" />
                    </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                      <label for="pays">Pays </label>
                      <select style="height: 50px;" class="form-control form-control-xl" value="{{ old('pays') }}" id="pays" name="pays" required>
                          <option value="">Selectionner</option>
                          <option value="{{ $banquexternes->pays }}" <?php if( $banquexternes->pays == $banquexternes->pays){ echo "selected"; } ?> >{{ $banquexternes->pays }}</option>
                          <option value="burundi">Burundi</option>
                          <option value="france">France</option>
                          <option value="canada">Canada</option>
                          <option value="burkina-faso">Burkina Faso</option>
                      </select>
                  </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="montant">Montant</label>
                        <input type="number" class="form-control form-control-xl" value="{{ $banquexternes->montant }}" id="montant" required name="montant" autocomplete="0" />
                    </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                      <label for="compte_comptable_id">Compte comptable </label>
                      <select style="height: 50px;" class="form-control form-control-xl" value="{{ old('compte_comptable_id') }}" id="compte_comptable_id" name="compte_comptable_id" required>
                          <option value="">Selectionner</option>
                          @foreach( $compte_comptable as $c )
                          <option value="{{ $c->id }}" <?php if( $banquexternes->compte_comptable_id == $c->id){ echo "selected"; } ?> >{{ $c->libelle }}</option>
                          @endforeach
                      </select>
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