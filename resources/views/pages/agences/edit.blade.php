@extends('layouts.template')
@section('title', $title)



@section('css')
<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
@endsection



@section('content')

	<div class="page-header">

    <h3 class="page-title">Nos agences</h3>

    <nav aria-label="breadcrumb">

      <ol class="breadcrumb">

        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>

        <li class="breadcrumb-item active" aria-current="page"> Nos agences </li>

      </ol>

    </nav>

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

          <h4 class="card-title mb-4">Modifier cette agence</h4>

          <form class="forms-sample" action="{{ route('agence-edit-valid') }}" method="POST">



            {{ csrf_field() }}

            <input type="hidden" value="{{ $agence->id }}" name="agence_id">

            <div class="form-group">

              <label for="nom">Nom agence * </label>

              <input type="text" class="form-control form-control-xl" value="{{ $agence->name }}" id="nom" name="nom" required placeholder="Nom agence *" autocomplete="0" />

            </div>

            <div class="form-group">

              <label for="ville">Ville agence * </label>

              <input type="text" class="form-control form-control-xl" value="{{ $agence->ville }}" id="ville" name="ville" required placeholder="Ville agence *" autocomplete="0" />

            </div>

            <div class="form-group">

              <label for="quartier">Quartier agence * </label>

              <input type="text" class="form-control form-control-xl" value="{{ $agence->quartier }}" id="quartier" name="quartier" required placeholder="Quartier agence *" autocomplete="0" />

            </div>

            <div class="form-group">

              <label for="tel">Téléphone </label>

              <input type="text" class="form-control form-control-xl" value="{{ $agence->tel }}" id="tel" name="tel" required placeholder="Telephone agence *" autocomplete="0" />

            </div>

            <div class="form-group">

              <label for="adresse">Adresse</label>

              <textarea class="form-control form-control-xl" id="adresse" rows="5" placeholder="Adresse" name="adresse">{{ $agence->adresse }}</textarea>

            </div>

            

            <button type="submit" class="btn btn-primary me-2"> Modifier </button>

            <button class="btn btn-light" type="reset">Annuler</button>

          </form>

        </div>

      </div>

    </div>

    <div class="col-md-8 grid-margin stretch-card">

      <div class="card">

        <div class="card-body">

          <h4 class="card-title mb-4">Liste de nos agences</h4>

          <div class="row overflow-auto">

            <div class="col-12">

              @if( $agences->isNotEmpty() )

              <table id="order-listing" class="table" cellspacing="0" width="100%">

                <thead>

                  <tr class="bg-primary text-white">

                    <th>N°</th>

                    <th>Nom Agence</th>

                    <th>Ville Agence</th>

                    <th>Quartier Agence</th>

                    <th>Actions</th>

                  </tr>

                </thead>

                <tbody>

                  @php

                  $i = 1;

                  @endphp

                  @foreach( $agences as $r )

                  

                  <tr>

                    <td class="text-center">{{ $i++ }}</td>

                    <td class="text-center"><b>{{ $r->name }}</b></td>

                    <td class="text-center"><b>{{ $r->ville }}</b></td>

                    <td class="text-center"><b>{{ $r->quartier }}</b></td>

                    <td class="text-center">

                      

                      <a href="{{ route('agence-edit', $r->id) }}" class="btn btn-info">

                        <i class="mdi mdi-pencil"></i>Modifier </a>

                      <button class="btn btn-danger">

                        <i class="mdi mdi-delete"></i>Supprimer </button>

                      



                    </td>

                  </tr>

                  

                  @endforeach

                </tbody>

              </table>

              @else

                  <div class="card card-inverse-danger mb-5">

                    <div class="card-body">

                      <p class="mb-4"> Vous n'avez pas encore ajouté d'agence !</p>

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