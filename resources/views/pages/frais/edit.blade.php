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

              Frais

            </li>

          </ol>

        </nav>

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

    <div class="col-md-4 grid-margin stretch-card">

      <div class="card">

        <div class="card-body">

          <h4 class="card-title mb-4">Editer un frais</h4>
          <form class="forms-sample" action="{{ route('frais-edit-valid') }}" method="POST">


            {{ csrf_field() }}

            <input type="hidden" name="frais_id" value="{{ $edit_f->id }}">

            <div class="form-group">
              <label for="type_frais">Type de frais * </label>
              <input type="text" class="form-control form-control-xl" value="{{ $edit_f->name }}" id="type_frais" name="type_frais" required placeholder="Type frais *" autocomplete="0" />
            </div>

            <div class="form-group">
              <label for="type_frais">Compte Epargne</label>
              <select class="form-control form-control-xl" name="compte">
                <option value="">Selectionner</option>
                @foreach( $comptes as $c )
                <option value="{{ $c->id }}" <?php if ( $edit_f->type_compte_id == $c->id ) {
                  echo "selected";
                } ?>>{{ $c->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="frequence">Fréquence</label>
              <select class="form-control-xl form-control" name="frequence">
                <option value="">Selectionner</option>
                <option value="week" <?php if ( $edit_f->frequence == "week" ) {
                  echo "selected";
                } ?>>Semaine</option>
                <option value="month" <?php if ( $edit_f->frequence == "month" ) {
                  echo "selected";
                } ?>>Mois</option>
                <option value="year" <?php if ( $edit_f->frequence == "year" ) {
                  echo "selected";
                } ?>>Année</option>
              </select>
            </div>

            <div class="form-group">
              <label for="amount">Montant *</label>
              <input type="text" value="{{ $edit_f->montant }}" class="form-control form-control-xl" id="amount" name="amount" required autocomplete="0" />
            </div>

            <div class="form-group">

              <label for="description">Description</label>

              <textarea class="form-control form-control-xl" id="description" rows="5" placeholder="Frais de compte" name="description">{{ $edit_f->description }}</textarea>

            </div>

            <button type="submit" class="btn btn-primary me-2"> Editer </button>
            <button class="btn btn-light" type="reset">Cancel</button>

          </form>

        </div>

      </div>

    </div>

    <div class="col-md-8 grid-margin stretch-card">

      <div class="card">

        <div class="card-body">

          <h4 class="card-title mb-4">Liste des frais</h4>

          <div class="row overflow-auto">

            <div class="col-12">

              @if( $frais->isNotEmpty() )

              <table id="order-listing" class="table" cellspacing="0" width="100%">

                <thead>

                  <tr class="bg-primary text-white">

                    <th>N°</th>

                    <th>Type de frais</th>

                    <th>Montant</th>

                    <th>Description</th>

                    <th>Actions</th>

                  </tr>

                </thead>

                <tbody>

                  @php

                  $i = 1;

                  @endphp

                  @foreach( $frais as $r )

                  

                  <tr>

                    <td class="text-center">{{ $i++ }}</td>

                    <td class="text-center"><b>{{ $r->name }}</b></td>

                    <td class="text-center"><b>{{ number_format($r->montant, 0, 2, ' ') }} BIF</b></td>

                    <td class="text-center"><b>{{ $r->description }}</b></td>

                    <td class="text-center">

                      <a href="{{ route('frais-edit', $r->id) }}" class="btn btn-info">

                        <i class="bi bi-pencil"></i> Modifier </a>

                      <button class="btn btn-danger">

                        <i class="bi bi-delete"></i> Supprimer </button>

                    </td>

                  </tr>

                  @endforeach
                </tbody>

              </table>

              @else

                  <div class="card card-inverse-danger mb-5">

                    <div class="card-body">

                      <p class="mb-4"> Vous n'avez pas encore ajouté de frais !</p>

                    </div>

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
<script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}" id="parsley"></script>
<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/assets/js/pages/simple-datatables.js"></script>
@endsection