@extends('layouts.template')



@section('title', 'Liste des banques externes')

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

          <h3 style="text-transform: uppercase;">Liste des banques externes</h3>

        </div>

        <div class="col-12 col-md-6 order-md-2 order-first">

          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">

            <ol class="breadcrumb">

              <li class="breadcrumb-item">

                <a href="{{ route('dashboard') }}">Tableau de bord</a>

              </li>

              <li class="breadcrumb-item active" aria-current="page">

                Banques externes

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

                <h3 class="card-title">Liste des banques externes</h3>

                <a href="{{ route('BanquexternesCreate') }}" class="btn btn-primary">

                    <i class="bi bi-plus"></i> Créer un nouveau

                </a>

            </div>

          </div>

        <div class="card-body">

          <div class="row overflow-auto">

            <div class="col-12">

              @if( $banquexternes->isNotEmpty() )

              <table id="order-listing" class="table" cellspacing="0" width="100%">

                <thead>

                  <tr class="bg-primary text-white">

                    <th>N°</th>

                    <th>Nom de la banque</th>

                    <th>Adresse</th>

                    <th>Pays</th>

                    <th>Montant</th>

                    <th>Actions</th>

                  </tr>

                </thead>

                <tbody>

                  @php

                  $i = 1;

                  @endphp

                  @foreach( $banquexternes as $b )

                  

                  <tr>

                    <td class="text-center">{{ $i++ }}</td>

                    <td class="text-center"><b>{{ $b->name }}</b></td>

                    <td class="text-center"><b>{{ $b->adresse }}</b></td>

                    <td class="text-center"><b>{{ $b->pays }}</b></td>

                    <td class="text-center"><b>{{ number_format($b->montant, 0, ',', ' ') }}</b></td>

                    <td class="text-center">

                      <a href="{{ route('BanquexternesEdit', $b->id) }}" class="btn btn-info">

                        <i class="mdi mdi-pencil"></i> Modifier </a>

                        <button class="btn btn-danger" data-bs-toggle="modal" data-id="{{ $b->id }}" data-bs-target="#delete" title="Supprimer">
                        <i class="mdi mdi-delete"></i> Supprimer </button>

                    </td>

                  </tr>


                  @endforeach

                </tbody>

              </table>

              @else

                  <div class="card card-inverse-danger mb-5">

                    <div class="card-body">

                      <p class="alert alert-info mb-4"> Vous n'avez pas encore ajouté de banque externe !</p>

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
            Supprimer Une Banque Externe 
          </sapn>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">
            
            <form class="" method="POST" action="{{ route('BanquexternesDel') }}">
                {{ csrf_field() }}

                <input type="hidden" class="" name="id" id="id">
                <p>Voulez-vous supprimer cette banque externe ?</p>

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
