@extends('layouts.template')



@section('title', 'Liste des taux')

@section('css')

  <link rel="stylesheet" href="/assets/css/pages/fontawesome.html" />
  <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css"/>
  <link rel="stylesheet" href="/assets/css/pages/simple-datatables.css" />

  <style>

    .badge-custom {
    display: inline-block;
    padding: 0.25em 0.5em;
    font-size: 75%;
    font-weight: bold;
    line-height: 1;
    color: #fff;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
    background-color: #28a745; /* Couleur verte */
}
  </style>

@endsection



@section('content')

<div class="page-heading">

    <div class="page-title">

      <div class="row">

        <div class="col-12 col-md-6 order-md-1 order-last">

          <h3 style="text-transform: uppercase;">Liste des taux</h3>

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

              <h3 class="card-title">Liste des taux</h3>

              <a href="{{ route('taux-create') }}" class="btn btn-primary">

                  <i class="bi bi-plus"></i> Créer un nouveau

              </a>

          </div>

      </div>

        <div class="card-body">

          <div class="row overflow-auto">

            <div class="col-12">

              @if( $taux->isNotEmpty() )

              <table id="order-listing" class="table" cellspacing="0" width="100%">

                <thead>

                  <tr class="bg-primary text-white">

                    <th>N°</th>

                    <th>Taux de commission</th>

                    <th>Montant du frais de dossier</th>

                    <th>Taux d'intérê</th>

                    <th>Taux d'assurance</th>

                    <th>Statut</th>

                    <th>Actions</th>

                  </tr>

                </thead>

                <tbody>

                  @php

                  $i = 1;

                  @endphp

                  @foreach( $taux as $t )

                  

                  <tr>

                    <td class="text-center">{{ $i++ }}</td>

                    <td class="text-center"><b>{{ $t->taux_commission }}</b></td>

                    <td class="text-center"><b>{{ $t->frais_de_dossier }}</b></td>

                    <td class="text-center"><b>{{ $t->taux_interet }}</b></td>

                    <td class="text-center"><b>{{ $t->taux_assurance }}</b></td>

                    <td class="text-center"><b>
                      @if($t->is_active =='yes' )
                      <span class="badge-custom">Actif</span>
                      @endif</b>
                    </td>

                    <td class="text-center">

                      <a href="{{ route('taux-edit', $t->id) }}" class="btn btn-info">

                        <i class="mdi mdi-pencil"></i> Modifier </a>

                        <button class="btn btn-danger" data-bs-toggle="modal" data-id="{{ $t->id }}" data-bs-target="#delete" title="Supprimer">
                        <i class="mdi mdi-delete"></i> Supprimer </button>

                    </td>

                  </tr>


                  @endforeach

                </tbody>

              </table>

              @else

                  <div class="card card-inverse-danger mb-5">

                    <div class="card-body">

                      <p class="alert alert-info mb-4"> Vous n'avez pas encore ajouté de taux !</p>

                    </div>

                  </div>

              @endif

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>


  <!--DELETE-->
<div class="modal fade text-left" id="delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger white">
          <sapn class="modal-title" id="myModalLabel150">
            Supprimer Le Taux 
          </sapn>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">
            
            <form class="" method="POST" action="{{ route('taux-delete') }}">
                {{ csrf_field() }}

                <input type="hidden" class="" name="id" id="id">
                <p>Voulez-vous supprimer cet taux ?</p>

                <div class="form-group mt-4">
                  <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Non</span>
                  </button>
                  <button type="submit" class="btn btn-danger">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Oui</span>
                  </button>
                </div>

            </form>

        </div>
      </div>
    </div>
</div>
<!--/END DELETE-->


@endsection



@section('js')
<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}" id="parsley"></script>
<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/assets/js/pages/simple-datatables.js"></script>

<script>

  $(document).ready(function() {

    $("#delete").on('show.bs.modal', function(e){
        var button = $(e.relatedTarget);
        var id = button.data('id');
        
        var modal = $(this);

        modal.find('#id').val(id);
        
       
    });

  });
</script>
@endsection
