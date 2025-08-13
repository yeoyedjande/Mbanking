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







              Correspondances







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





    <div class="col-md-12 grid-margin stretch-card">







      <div class="card">



        <div class="card-header">

            <span class="d-flex justify-content-end">

              <a href="{{ route('correspondance-new') }}" class="btn btn-primary btn-lg">

                <i class="bi bi-plus"></i> Ajouter une correspondance

              </a>

            </span>

        </div>



        <div class="card-body">







          <h4 class="card-title mb-4">Correspondances</h4>







          <div class="row overflow-auto">

            <div class="col-12">

              @if( $correspondances->isNotEmpty() )

              <table id="table1" class="table table-bordered table-striped">

                <thead>


                  <tr class="" style="text-transform: uppercase;">
                    <th class="text-center">N°</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Heure</th>
                    <th class="text-center">Nature de la correspondance</th>
                    <th class="text-center">Quantité</th>
                    <th class="text-center">Livraison effectuée par</th>
                    <th class="text-center">Expediteur</th>
                    <th class="text-center">Destinataire</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Actions</th>
                  </tr>

                </thead>

                <tbody>
                  @php
                  $i = 1;

                  @endphp

                  @foreach( $correspondances as $r )

                  <tr>

                    <td class="text-center">{{ $i++ }}</td>

                    <td class="text-center"><b>{{ $r->date }}</b></td>

                    <td class="text-center"><b>{{ $r->heure }}</b></td>

                    <td class="text-center"><b>{{ $r->nature }}</b></td>
                    <td class="text-center"><b>{{ $r->quantite }}</b></td>
                    <td class="text-center"><b>{{ $r->auteur_livraison }}</b></td>
                    <td class="text-center"><b>{{ $r->expediteur }}</b></td>
                    <td class="text-center"><b>{{ $r->destinataire }}</b></td>
                    <td class="text-center"><b>{{ $r->description }}</b></td>

                    <td class="text-center">



                      <a href="#" class="btn btn-success">

                        <i class="bi bi-pencil"></i> Modifier </a>

                        <a href="#" class="btn btn-danger">

                        <i class="bi bi-trash"></i> Supprimer </a>

                    </td>

                  </tr>

                  
                  @endforeach
                </tbody>

              </table>







              @else







                  <div class="card">







                    <div class="card-body">







                      <p class="mb-4"> Vous n'avez pas encore correspondance !</p>







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



<script>







  $(document).ready(function() {



      $("#create").on('show.bs.modal', function(e){



          var button = $(e.relatedTarget);

          var id = button.data('id');

          var name = button.data('name');

          var modal = $(this);

          modal.find('#id').val(id);

          modal.find('#name').val(name);

          modal.find('.nom_agence').text(name);



      });



  });



</script>





@endsection