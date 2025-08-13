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
        <h3 style="text-transform: uppercase;">Opérations</h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Toutes les transactions
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

          <h4 class="card-title mb-4">Toutes les Transactions</h4>

          <div class="row overflow-auto">

            <div class="col-12">

              @if($transactions->isNotEmpty())

              <table id="table1" class="table" cellspacing="0" width="100%">

                <thead>

                  <tr class="bg-primary text-white">

                    <th class="text-center">N°</th>

                    <th class="text-center">Date Opération</th>

                    <th class="text-center">De</th>

                    <th class="text-center">Vers</th>

                    <th class="text-center">Type d'opération</th>

                    <th class="text-center">Montant</th>
                    <th class="text-center">Action</th>

                  </tr>

                </thead>

                <tbody>

                  @php

                    $i = 1;

                    @endphp

                    

                    @foreach( $transactions as $m )

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

                              ->join('clients', 'clients.code_client', '=', 'accounts.client_id')

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

                              ->join('clients', 'clients.code_client', '=', 'accounts.client_id')

                              ->Where('operations.account_dest', $m->account_dest)

                              ->first();



                              //var_dump($dest->nom);

                            ?>

                            {{ $dest->nom }} @if($dest->prenom != 'NULL') {{ $dest->prenom }} @endif

                            

                            @endif



                        </td>



                        <td class="text-center">{{ $m->name }}</td>

                        <td class="text-center"><b>{{ number_format($m->montant, 0, 2, ' ') }} BIF</b></td class="text-center">

                        <td class="text-center"><a href="#" class="btn btn-success"> <i class="mdi mdi-eyes"></i> Détails</a> </td>
                    </tr>

                    @endforeach

                </tbody>
              </table>
              
              @else
              <div class="alert alert-warning">
                <h4 class="alert-heading">Info</h4>
                <p>Vous n'avez pas de transactions disponible en ce moment !</p>
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