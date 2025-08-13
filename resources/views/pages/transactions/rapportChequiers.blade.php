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

    

  <section class="section">

      

      <div class="card">

        <div class="card-body">

          @if( $chequiers->isNotEmpty() )

          <table class="table table-striped" id="table1">

            <thead>

              <tr style="text-transform: uppercase;">

                <th class="text-center">N°</th>

                <th class="text-center">Référence</th>

                <th class="text-center">Numero de compte</th>

                <th class="text-center">Quantité</th>
                <th class="text-center">Prix Unitaire</th>
                <th class="text-center">Montant Total</th>

                <th class="text-center">Nom client</th>

                <th class="text-center">Date de demande</th>

                <th class="text-center">Actions</th>

              </tr>

            </thead>

            <tbody>

              @php

              $i = 1;

              @endphp

              

              @foreach( $chequiers as $v )

              <tr>

                <td class="text-center">{{ $i++ }}</td>

                <td class="text-center">{{ $v->reference }}</td>

                <td class="text-center">{{ $v->account_id }}</td>
                <td class="text-center">{{ $v->qte }}</td>

                <td class="text-center"><b>{{ number_format($v->montant, 0, 2, ' ') }} BIF</b></td>
                <td class="text-center"><b>{{ number_format($v->montant_total, 0, 2, ' ') }} BIF</b></td>

                <td class="text-center"><b>{{ $v->nom }} <?php if ($v->prenom != 'NULL'): ?>

                  {{ $v->prenom }}

                <?php endif ?></b></td>

                <td class="text-center">{{ $v->date_order }}</td>

                

                <td class="text-center">

                  <a target="_blank" href="{{ route('chequiers-print', strtolower($v->reference)) }}" class="btn btn-primary btn-xs">

                    <i class="bi bi-printer"></i> &nbsp; Imprimer le reçu</a>

                </td>

              </tr>

              @endforeach

            </tbody>

          </table>

          @else

              <div class="alert alert-info">

                <h4 class="alert-heading">Info</h4>

                <p>Il n'y a pas de commande de chequiers disponible en ce moment !</p>

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