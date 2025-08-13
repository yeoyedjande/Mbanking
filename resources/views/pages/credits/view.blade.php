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
              Les demandes disponible
            </li>
          </ol>
        </nav>
      </div>
    </div>
</div>

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


    <section class="section">
      
          <div class="card">
            
            <div class="card-body">
              @if( $demandes->isNotEmpty() )
              <table class="table table-striped" id="table1">
                <thead>
                  <tr style="text-transform: uppercase;">
                    <th class="text-center">N°</th>
                    <th class="text-center">Dossier</th>
                    <th class="text-center">Type de credit</th>
                    <th class="text-center">Client</th>
                    <th class="text-center">Montant</th>
                    <th class="text-center">Date de la demande</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $i = 1;
                    @endphp
                    
                    @foreach( $demandes as $d )

                    <?php 
                      $assign = DB::table('analyste_demandes')
                      ->Where('demande', $d->num_dossier)
                      ->first();
                    ?>
                    <tr>
                        <td class="text-center">{{ $i++ }}</td>
                        <td class="text-center">{{$d->num_dossier}}</td>
                        <td class="text-center">{{$d->name}}</td>

                        <td class="text-center">

                            {{ $d->nom }} @if($d->prenom != 'NULL') {{ $d->prenom }} @endif
                            
                        </td>


                        <td class="text-center">{{ number_format($d->montant_demande, 0, 2, ' ') }} BIF</td>
                        <td class="text-center"><b>
                          {{ $d->date_demande }}
                        </b></td>

                        
                        <td class="text-center">
                            <a href="{{ route('detail-demandes', $d->num_dossier) }}" class="btn btn-info btn-sm">Détail de la demande </a>

                            <?php if ($assign): ?>
                                <a href="#" class="btn btn-danger btn-sm">Déjà attribuee </a>
                              <?php else: ?>
                                <a href="{{ route('send-demande-envoyer', $d->num_dossier) }}"  class="btn btn-success btn-sm">Envoyer à un analyste </a>
                            <?php endif ?>
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
              @else
                  <div class="alert alert-info">
                    <h4 class="alert-heading">Info</h4>
                    <p>Il n'y a pas de demandes disponible en ce moment !</p>
                  </div>
              @endif
            </div>
          </div>
          
      </section>


  <div class="modal fade" id="validation" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">Validation de transaction <span id="montant"></span></h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="forms-sample" action="{{ route('transaction-attente-valid') }}" method="POST">
          <div class="modal-body">
            <p>Vous etes sur le point de valider cette transaction ?</p>
            
            {{ csrf_field() }}
            <input type="hidden" id="id" name="operation_id">
            <input type="hidden" id="name" name="name">
            <input type="hidden" id="amount" name="amount">
            <input type="hidden" id="num_account" name="num_account">
            <input type="hidden" id="num_account_dest" name="num_account_dest">
            <input type="hidden" id="user" name="user_id">
            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Oui</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Non</button>
          </div>
        </form>
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
        var user = button.data('user');
        var num_account_dest = button.data('numberaccountdest');
        var num_account = button.data('numberaccount');
        var modal = $(this);

        modal.find('#id').val(id);
        modal.find('#name').val(name);
        modal.find('#amount').val(amount);
        modal.find('#user').val(user);
        modal.find('#num_account_dest').val(num_account_dest);
        modal.find('#num_account').val(num_account);
        modal.find('#montant').text(montant+' BIF');
    });

  });
</script>

@endsection