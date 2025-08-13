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
        <h3 style="text-transform: uppercase;">Coffre fort</h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Coffres forts
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

    <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center">
            <h2>Transfert Banque vers Coffre fort</h2>  <br>
            <a href="javascript(0);" data-bs-toggle="modal" data-bs-target="#banque_coffrefort" class="btn btn-primary btn-lg"> Commencer</a>
          </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center">
            <h2>Transfert Coffre fort vers Coffre fort</h2>
            <a href="javascript(0);" data-bs-toggle="modal" data-bs-target="#coffrefort_coffrefort" class="btn btn-primary btn-lg"> Commencer</a>
          </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center">
            <h2>Transfert Coffre fort vers Banque</h2> <br>
            <a href="javascript(0);" data-bs-toggle="modal" data-bs-target="#coffrefort_banque" class="btn btn-primary btn-lg"> Commencer</a>
          </div>
        </div>
    </div>
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4">Total montant coffres Forts: {{ number_format($total_coffrefort, 0, 2, ' ') }} BIF</h4>
          <div class="row overflow-auto">
            <div class="col-12">
              @if( $agences->isNotEmpty() )
              <table id="table1" class="table table-bordered table-striped">
                <thead>
                  <tr class="" style="text-transform: uppercase;">
                    <th class="text-center">N°</th>
                    <th class="text-center">Nom Agence</th>
                    <th class="text-center">Coffre fort</th>
                    <th class="text-center">Ville Agence</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>

                <tbody>
                  @php
                  $i = 1;
                  @endphp







                  @foreach( $coffreforts as $r )
                  <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td class="text-center"><b>{{ $r->agence }}</b></td>
                    <td class="text-center"><b>{{ number_format($r->montant, 0, 2, ' ') }} BIF</b></td>
                    <td class="text-center"><b>{{ $r->ville }}</b></td>
                    <td class="text-center">
                      <a href="javascript(0);" data-montant="{{ $r->montant }}" data-id="{{ $r->compte_comptable_id }}" data-bs-toggle="modal" data-bs-target="#create" class="btn btn-success">
                         Transfert <i class="bi bi-arrow-right"></i></a>
                      <a href="javascript(0);" data-name="{{ $r->name }}" data-solde_principal="{{ $r->solde_principal }}" data-id="{{ $r->id }}" data-vers_numero="{{ $r->vers_numero_compte }}" data-bs-toggle="modal" data-bs-target="#edit" class="btn btn-info">

                        <i class="bi bi-pencil"></i> Modifier </a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>







              @else







                  <div class="card card-inverse-danger mb-5">







                    <div class="card-body">







                      <p class="mb-4"> Vous n'avez pas encore fait de transfert !</p>







                    </div>







                  </div>







              @endif







            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



  @include('pages.agences.modal.add_amount')

  <div class="modal fade text-left" id="banque_coffrefort" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary white">
            <sapn class="modal-title" id="myModalLabel150">
              Transfert Banque vers Coffre fort
            </sapn>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <i data-feather="x"></i>
            </button>
          </div>
          <div class="modal-body">
            
              <form method="POST" action="{{ route('bank-to-coffre') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label>Banque *</label>
                          <select class="form-control form-control-xl" name="banque" id="banque" required>
                            <option value="">Selectionner</option>
                            @foreach( $banquexternes as $b )
                            <option data-amount="{{ $b->montant }}" value="{{ $b->compte_comptable_id }}">{{ $b->name }}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label>Coffre fort *</label>
                          <select class="form-control form-control-xl" name="coffre" required>
                            <option value="">Selectionner</option>
                            @foreach( $coffreforts as $c )
                            <option value="{{ $c->compte_comptable_id }}">{{ $c->name }}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>

                    <span id="solde"></span>

                    <div class="col-md-12">
                      <div class="form-group">
                          <label>Montant *</label>
                          <input type="number" name="amount" class="form-control form-control-xl" required>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-lg">Envoyer</button>
                      </div>
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div>
  </div>

  <div class="modal fade text-left" id="coffrefort_coffrefort" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary white">
            <sapn class="modal-title" id="myModalLabel150">
              Transfert Coffre fort vers Coffre fort
            </sapn>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <i data-feather="x"></i>
            </button>
          </div>
          <div class="modal-body">
            
              <form method="POST" action="{{ route('coffre-to-coffre') }}">
                          {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label>Coffre fort expéditeur *</label>
                          <select class="form-control form-control-xl" name="coffre_exp" required>
                            <option value="">Selectionner</option>
                            @foreach( $coffreforts as $c )
                            <option value="{{ $c->compte_comptable_id }}">{{ $c->name }}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                          <label>Coffre fort destinataire *</label>
                          <select class="form-control form-control-xl" name="coffre_dest" required>
                            <option value="">Selectionner</option>
                            @foreach( $coffreforts as $c )
                            <option value="{{ $c->compte_comptable_id }}">{{ $c->name }}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                          <label>Montant *</label>
                          <input type="number" name="amount" class="form-control form-control-xl" required>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-lg">Envoyer</button>
                      </div>
                    </div>
                </div>
            </form>
          </div>
        </div>
      </div>
  </div>

  <div class="modal fade text-left" id="coffrefort_banque" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary white">
            <sapn class="modal-title" id="myModalLabel150">
              Transfert Coffre fort vers Banque
            </sapn>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <i data-feather="x"></i>
            </button>
          </div>
          <div class="modal-body">
            
              <form method="POST" action="{{ route('coffre-to-banque') }}">
                          {{ csrf_field() }}

                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                          <label>Coffre fort *</label>
                          <select class="form-control form-control-xl" name="coffre_exp" required>
                            <option value="">Selectionner</option>
                            @foreach( $coffreforts as $c )
                            <option value="{{ $c->compte_comptable_id }}">{{ $c->name }}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                          <label>Banque *</label>
                          <select class="form-control form-control-xl" name="banque" id="banque" required>
                            <option value="">Selectionner</option>
                            @foreach( $banquexternes as $b )
                            <option data-amount="{{ $b->montant }}" value="{{ $b->compte_comptable_id }}">{{ $b->name }}</option>
                            @endforeach
                          </select>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                          <label>Montant *</label>
                          <input type="number" name="amount" class="form-control form-control-xl" required>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                          <button type="submit" class="btn btn-primary btn-lg">Envoyer</button>
                      </div>
                    </div>
                </div>
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



<script>







  $(document).ready(function() {



      $("#create").on('show.bs.modal', function(e){



          var button = $(e.relatedTarget);

          var id = button.data('id');

          var montant = button.data('montant');

          var modal = $(this);

          modal.find('#id').val(id);

          modal.find('#montant').val(montant);

          modal.find('.nom_agence').text(name);



      });

      $("#edit").on('show.bs.modal', function(e){
          var button = $(e.relatedTarget);
          var id = button.data('id');
          var montant = button.data('montant');
          var solde_principal = button.data('solde_principal');
          var vers_numero = button.data('vers_numero');
          var modal = $(this);
          modal.find('#id').val(id);
          modal.find('#montant').val(montant);
          modal.find('.nom_agence').text(name);
          modal.find('#solde_principal').val(solde_principal);
          modal.find('#vers_numero').val(vers_numero);
      });

      function formatWithSpaces(number) {
          return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
      }

      $('#banque').change(function(){

          var selectedOption = $("#banque option:selected");
          // Récupère la valeur sélectionnée
          var selectedValue = selectedOption.val();
          // Récupère le montant associé à l'option sélectionnée
          var selectedAmount = selectedOption.data('amount');

          if (selectedAmount > 0) {
            var formattedAmount = formatWithSpaces(selectedAmount);

            $('#solde').html('<div class="col-md-12"><div class="form-group"><label style="color: green; font-size: 18px;">Solde disponible: '+formattedAmount+'</label></div></div>');
          }else{
            var formattedAmount = formatWithSpaces(selectedAmount);

            $('#solde').html('<div class="col-md-12"><div class="form-group"><label style="color: #ff0000; font-size: 18px;">Solde disponible: '+formattedAmount+'</label></div></div>');
          }
          
         //console.log(selectedAmount)

      }).trigger('change');


  });



</script>





@endsection