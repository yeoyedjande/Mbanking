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
        <h3 style="text-transform: uppercase;">caisses du <?= date('d/m/Y'); ?></h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Transaction en attente de validation
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

        <div class="card-body">

          <h4 class="card-title mb-4">Transaction en attente de validation</h4>

          <div class="row overflow-auto">

            <div class="col-12">

              @if($transactionsAttente->isNotEmpty())

              <table id="table1" class="table" cellspacing="0" width="100%">

                <thead>

                  <tr class="bg-primary text-white">

                    <th class="text-center">N°</th>

                    <th class="text-center">Date Opération</th>

                    <th class="text-center">De</th>

                    <th class="text-center">Vers</th>

                    <th class="text-center">Type d'opération</th>

                    <th class="text-center">Montant</th>

                    <th class="text-center">Statut</th>

                    <th class="text-center">Actions</th>

                  </tr>

                </thead>

                <tbody>

                  @php

                    $i = 1;

                    @endphp

                    

                    @foreach( $transactionsAttente as $m )

                    <tr>

                        <td class="text-center">{{ $i++ }}</td>

                        <td class="text-center">{{$m->date_op}}</td>



                        <td class="text-center">



                            @if( $m->name == 'Versement' )

                            Compte principal

                            @elseif( $m->name == 'Retrait' )

                            {{ $m->nom }} @if($m->prenom != 'NULL') {{ $m->prenom }} @endif



                            @else



                            <?php 

                              $exp = DB::table('operations')

                              ->join('accounts', 'accounts.number_account', '=', 'operations.account_id')

                              ->join('clients', 'clients.id', '=', 'accounts.client_id')

                              ->Where('operations.account_id', $m->account_id)

                              ->first();



                              //var_dump($dest->nom);

                            ?>



                            {{ $exp->nom }} @if($exp->prenom != 'NULL') {{ $exp->prenom }} @endif



                            @endif

                          

                        </td>



                        <td class="text-center">



                          @if( $m->name == 'Versement' )

                            {{ $m->nom }} @if($m->prenom != 'NULL') {{ $m->prenom }} @endif

                            @elseif( $m->name == 'Retrait' )

                            

                            Compte principal

                            @else



                            <?php 

                              $dest = DB::table('operations')

                              ->join('accounts', 'accounts.number_account', '=', 'operations.account_dest')

                              ->join('clients', 'clients.id', '=', 'accounts.client_id')

                              ->Where('operations.account_dest', $m->account_dest)

                              ->first();



                              //var_dump($dest->nom);

                            ?>

                            {{ $dest->nom }} @if($dest->prenom != 'NULL') {{ $dest->prenom }} @endif

                            

                            @endif



                        </td>



                        <td class="text-center">{{ $m->name }}</td>

                        <td class="text-center"><b>{{ number_format($m->montant, 0, 2, ' ') }} BIF</b></td class="text-center">

                        <td class="text-center">
                          <button class="btn btn-danger btn-xs">En attente de validation</button>
                        </td>

                        <td class="text-center">

                          <a href="javascript(0);" data-montant="{{ number_format($m->montant, 0, 2, ' ') }}" data-id="{{ $m->id }}" data-amount="{{ $m->montant }}" data-nom_deposant="{{ $m->nom_deposant }}" data-tel_deposant="{{ $m->tel_deposant }}" data-motif_deposant="{{ $m->motif_depot }}" data-date_op="{{ $m->date_op }}" data-name="{{ $m->name }}" data-user="{{ $m->user_id }}" data-numberaccount="{{ $m->number_account }}" data-numberaccountdest="{{ $m->account_dest }}" data-bs-toggle="modal" data-bs-target="#validation" class="btn btn-primary btn-xs">

                          Proceder à la validation>  </a>

                        </td>

                    </tr>

                    @endforeach

                </tbody>
              </table>
              
              @else
              <div class="alert alert-warning">
                <h4 class="alert-heading">Info</h4>
                <p>Vous n'avez pas de transaction en attente !</p>
              </div>
              @endif
              
            </div>

          </div>

        </div>

      </div>

    </div>

  </div>


  <div class="modal fade text-left" id="validation" tabindex="-1" role="dialog" aria-hidden="true">

      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">

        <div class="modal-content">

          <div class="modal-header bg-primary white">

            <sapn class="modal-title" id="myModalLabel150">
              Validation de transaction
            </sapn>

            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <i data-feather="x"></i>
            </button>

          </div>

          <div class="modal-body">

            <form action="{{ route('transaction-attente-valid') }}" method="POST">
                <div class="modal-body">
                  <div class="alert alert-info text-center">
                    Vous etes sur le point de valider cette transaction ?
                  </div>

                  {{ csrf_field() }}
                  

                  <input type="hidden" id="id" name="operation_id">
                  <input type="hidden" id="name" name="name">
                  <input type="hidden" id="amount" name="amount">
                  <input type="hidden" id="num_account" name="num_account">
                  <input type="hidden" id="num_account_dest" name="num_account_dest">
                  <input type="hidden" id="user" name="user_id">

                  <div id="dragula-right" class="content">
                      <div class="rounded border mb-2">
                          <div class="card-body p-3">
                            <div class="media">
                              <i class="bi bi-users icon-sm align-self-center me-3"></i>
                              <div class="media-body">
                                <h4 class="mb-1">Numéro de compte</h4>
                                <p class="mb-3 text-muted" style="font-size: 18px;">
                                  <span id="numberAccount"></span>
                                </p>

                                <h4 class="mb-1">Nom du déposant</h4>
                                <p class="mb-3 text-muted" style="font-size: 18px;"><span id="affiche_nom_deposant"></span>
                                </p>

                                <h4 class="mb-1">Numéro de téléphone du déposant </h4>
                                <p class="mb-3 text-muted" style="font-size: 18px;">
                                  <span id="affiche_tel_deposant"></span>
                                </p>

                                <h4 class="mb-1">Montant à verser</h4>
                                <p class="mb-3 text-muted" style="font-size: 18px;">
                                  <span id="affiche_amount" style="font-weight: bold; color: #FF0000;"></span>
                                </p>

                                <h4 class="mb-1">Date Opérations</h4>
                                <p class="mb-4 text-muted" style="font-size: 18px;">
                                  <span id="affiche_date_op"></span>
                                </p>

                                <h4 class="mb-1">Motif</h4>
                                <p class="mb-3 text-muted" style="font-size: 18px;">
                                  <span id="affiche_motif"></span>
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>

                  </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-dark btn-lg" data-bs-dismiss="modal">Retour</button>
                <button type="submit" class="btn btn-success btn-lg">Confirmer la validation></button>
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



  $(function () {



    $("#validation").on('show.bs.modal', function(e){

        var button = $(e.relatedTarget);

        var id = button.data('id');

        var montant = button.data('montant');

        var name = button.data('name');

        var amount = button.data('amount');
        var nom_deposant = button.data('nom_deposant');
        var tel_deposant = button.data('tel_deposant');
        var motif_deposant = button.data('motif_deposant');
        var date_op = button.data('date_op');

        var user = button.data('user');

        var num_account_dest = button.data('numberaccountdest');

        var num_account = button.data('numberaccount');

        var modal = $(this);



        modal.find('#id').val(id);

        modal.find('#name').val(name);
        modal.find('#affiche_nom_deposant').html(nom_deposant);
        modal.find('#affiche_tel_deposant').html(tel_deposant);
        modal.find('#affiche_date_op').html(date_op);
        modal.find('#affiche_motif').html(motif_deposant);

        modal.find('#amount').val(amount);
        modal.find('#affiche_amount').html(montant+' BIF');

        modal.find('#user').val(user);

        modal.find('#num_account_dest').val(num_account_dest);

        modal.find('#num_account').val(num_account);
        modal.find('#numberAccount').html(num_account);

        modal.find('#montant').text(montant+' BIF');

    });



  });

</script>



@endsection