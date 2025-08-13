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
        <h3 style="text-transform: uppercase;">Historique de retraits</h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Historique de retraits
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

          <h4 class="card-title mb-4">Historiques des Retraits</h4>

          <div class="row overflow-auto">

            <div class="col-12">

              

              <table id="table1" class="table" cellspacing="0" width="100%">

                <thead>

                  <tr class="bg-primary text-white">

                    <th class="text-center">N°</th>

                    <th class="text-center">Reference</th>

                    <th class="text-center">Numero de compte</th>

                    <th class="text-center">Montant</th>

                    <th class="text-center">Nom client</th>

                    <th class="text-center">Date de retrait</th>

                    <th class="text-center">Actions</th>

                  </tr>

                </thead>

                <tbody>

                  @php

                  $i = 1;

                  @endphp

                  

                  @foreach( $retraits as $v )

                  <tr>

                    <td class="text-center">{{ $i++ }}</td>

                    <td class="text-center">{{ $v->ref }}</td>

                    <td class="text-center">{{ $v->account_id }}</td>

                    <td class="text-center"><b>{{ number_format($v->montant + $v->frais, 0, 2, ' ') }} BIF</b></td>

                    <td class="text-center"><b>{{ $v->nom }} <?php if ($v->prenom != 'NULL'): ?>

                      {{ $v->prenom }}

                    <?php endif ?></b></td>

                    <td class="text-center">{{ $v->date_op }}</td>

                    

                    <td class="text-center">

                      <a target="_blank" href="{{ route('retrait-print', strtolower($v->ref)) }}" class="btn btn-primary btn-xs">

                        <i class="bi bi-printer"></i> &nbsp; Imprimer le reçu</a>

                      <!--<a href="#" class="btn btn-danger">

                        <i class="mdi mdi-delete"></i>Supprimer </a>-->

                    </td>

                  </tr>

                  @endforeach

                </tbody>

              </table>

              

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>





@endsection
@section('js')

<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/assets/js/pages/simple-datatables.js"></script>

@endsection