@extends('layouts.template')
@section('title', $title)



@section('css')
<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
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

                Nos objets de demandes

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

  <div class="col-md-4 grid-margin stretch-card">

    <div class="card">

      <div class="card-body">

        <h4 class="card-title mb-4">Modifier cet objet de demande</h4>

        <form class="forms-sample" action="{{ route('objet_demande-edit-valid') }}" method="POST">


          {{ csrf_field() }}

          <input type="hidden" value="{{ $objet_demande->id }}" name="objet_demande_id">

          <div class="form-group">

            <label for="libelle">Libelle <span class="text-danger"> *</span> </label>

            <input type="text" class="form-control form-control-xl" value="{{ $objet_demande->libelle }}" id="libelle" name="libelle" required  autocomplete="0" />

          </div>

          <div class="form-group">

            <label for="description">Description <span class="text-danger"> *</span> </label>

            <textarea class="form-control form-control-xl" id="description" name="description" required  autocomplete="0" /> {{ $objet_demande->description }} </textarea>

          </div>

          

          <button type="submit" class="btn btn-primary me-2"> Modifier </button>

          <button class="btn btn-light" type="reset">Annuler</button>

        </form>

      </div>

    </div>

  </div>

  <div class="col-md-8 grid-margin stretch-card">

    <div class="card">

      <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
              <h3 class="card-title">Liste des objets de demandes</h3>
              <a href="{{ route('type_biens.demande.index') }}" class="btn btn-primary">
                  <i class="bi bi-plus"></i> Créer un nouveau
              </a>
          </div>
      </div>
      <div class="card-body">

        <div class="row overflow-auto">

          <div class="col-12">

            @if( $objet_demandes->isNotEmpty() )

            <table id="order-listing" class="table" cellspacing="0" width="100%">

              <thead>

                <tr class="bg-primary text-white">

                  <th>N°</th>

                  <th>Libelle</th>

                  <th>Description</th>

                  <th>Actions</th>

                </tr>

              </thead>

              <tbody>

                @php

                $i = 1;

                @endphp

                @foreach( $objet_demandes as $o )

                

                <tr>

                  <td class="text-center">{{ $i++ }}</td>

                  <td class="text-center"><b>{{ $o->libelle }}</b></td>

                  <td class="text-center"><b>{{ $o->description }}</b></td>

                  <td class="text-center">

                    

                    <a href="{{ route('objet_demande-edit', $o->id) }}" class="btn btn-info">

                      <i class="mdi mdi-pencil"></i>Modifier </a>


                  </td>

                </tr>

                

                @endforeach

              </tbody>

            </table>

            @else

                <div class="card card-inverse-danger mb-5">

                  <div class="card-body">

                    <p class="mb-4"> Vous n'avez pas encore ajouté un objet de demande !</p>

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
