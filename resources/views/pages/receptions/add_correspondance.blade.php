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







              Ajouter une correspondance







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

              <a href="{{ route('correspondances') }}" class="btn btn-primary btn-lg">

                <i class="bi bi-list"></i> Liste des correspondances

              </a>

            </span>

        </div>



        <div class="card-body">







          <h4 class="card-title mb-4">Ajouter</h4>







          <div class="row overflow-auto">

            <div class="col-12">

                <form class="forms-sample" action="{{ route('correspondance-new-valid') }}" method="POST">

                    {{ csrf_field() }}

                    <div class="row">

                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Date *</label>
                            <input type="date" name="date" required class="form-control form-control-xl">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Heure *</label>
                            <input type="time" name="hour" required class="form-control form-control-xl">
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                            <label>Nature *</label>
                            <input type="text" name="nature" required class="form-control form-control-xl">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label>Quantité *</label>
                            <input type="number" name="qte" required class="form-control form-control-xl">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                            <label>Auteur livraison *</label>
                            <input type="text" name="auteur" required class="form-control form-control-xl">
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Expediteur *</label>
                            <input type="text" name="expediteur" required class="form-control form-control-xl">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Destinataire *</label>
                            <input type="text" name="destinataire" required class="form-control form-control-xl">
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                            <label>Description </label>
                            <textarea rows="5" name="description" class="form-control form-control-xl"></textarea>
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-lg">Valider</button>
                        </div>
                      </div>

                    </div>
                </form>
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