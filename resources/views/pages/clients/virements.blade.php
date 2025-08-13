@extends('layouts.app_client')

@section('title', $title)


@section('css')
  <link rel="stylesheet" href="/assets/css/pages/fontawesome.html" />
  <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css"/>
  <link rel="stylesheet" href="/assets/css/pages/simple-datatables.css" />
@endsection

@section('content')

  <div class="page-heading">
    <div class="page-title mb-5">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3 style="text-transform: uppercase;">{{ $title }}</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Tableau de bord</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                {{$title}}
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



    @if( session()->has('msg_info') )

    <div class="col-md-12">

        <div class="alert alert-info">{{ session()->get('msg_info') }}</div>

    </div>

    @endif



     <section class="section">

      <div class="card">

        <div class="card-header">

            <span class="d-flex justify-content-end">

              <a href="{{ route('client-virements-new') }}" class="btn btn-primary btn-lg">

                   Faire un virement

              </a>

            </span>

        </div>

        <div class="card-body">

          @if( $virements->isNotEmpty() )

          <table class="table table-striped" id="table1">

            <thead>

              <tr style="text-transform: uppercase;">

                <th class="text-center">N°</th>
                <th class="text-center">Référence</th>
                <th class="text-center">Envoyer à</th>
                <th class="text-center">Montant</th>
                <th class="text-center">Date de virement</th>
                <th class="text-center">Heure de virement</th>
                <th class="text-center">Actions</th>

              </tr>

            </thead>

            <tbody>

              @php

              $i = 1;

              @endphp

              

              @foreach( $virements as $v )

              <?php 
                 $nom_crediteur = DB::table('operations')->join('accounts', 'accounts.number_account', '=', 'operations.account_dest')
                  ->join('clients', 'clients.id', '=', 'accounts.client_id')
                  ->Where('accounts.number_account', $v->account_dest)
                  ->first();
               ?>
              <tr>

                <td class="text-center">{{ $i++ }}</td>

                <td class="text-center">{{ $v->ref }}</td>

                <td class="text-center">{{ $nom_crediteur->nom }} @if ($nom_crediteur->prenom != 'NULL')

                  {{ $nom_crediteur->prenom }}

                @endif</td>

                <td class="text-center"><b>{{ number_format($v->montant, 0, 2, ' ') }} BIF</b></td>

                <td class="text-center">{{ $v->date_op }}</td>
                <td class="text-center">{{ $v->heure_op }}</td>

                

                <td class="text-center">

                  <a target="_blank" href="{{ route('client-virement-print', strtolower($v->ref)) }}" class="btn btn-primary btn-xs">

                    <i class="bi bi-printer"></i> &nbsp; Imprimer le reçu</a>

                </td>

              </tr>

              @endforeach

            </tbody>

          </table>

          @else

              <div class="alert alert-info">

                <h4 class="alert-heading">Info</h4>

                <p>Il n'y a pas de virements disponible en ce moment !</p>

              </div>

          @endif

        </div>

      </div>

      

  </section>
@endsection



@section('js')

<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/assets/js/pages/simple-datatables.js"></script>

@endsection