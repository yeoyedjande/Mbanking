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
              {{ $title }}
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


    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-header" style="text-align: right;">
          <a href="{{ route('liste-demandes') }}" class="btn btn-primary">< Retour</a>
        </div>
        <div class="card-body">
          <div class="row overflow-auto">
            <div class="col-12 mb-4">
              
                  <h4>Client: {{ $demande->nom }} @if($demande->prenom != 'NULL') {{ $demande->prenom }} @endif</h4>
                  <span>
                      Dossier: <b>{{$demande->num_dossier}}</b>
                  </span><br>
                  <span>
                      Type de credit: <b>{{$demande->name}}</b>
                  </span>
                  <br>
                  <span>
                      Montant demandé: <b>{{ number_format($demande->montant_demande, 0, 2, ' ') }} BIF</b>
                  </span>
            </div>

            <h4>Documents fournis</h4>
            <?php 
              $variable = DB::table('doc_credits')->Where('code', $demande->code_doc)->get(); 
              foreach ($variable as $key => $value) {              
            ?>
              <div class="col-md-3">
                  <iframe height="250" src="/assets/docs/credits/{{ $value->file }}"></iframe>
              </div>
              
            <?php } ?>
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