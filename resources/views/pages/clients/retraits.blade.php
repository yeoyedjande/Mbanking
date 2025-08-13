@extends('layouts.app_client')



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

              <a href="{{ route('home') }}">Tableau de bord</a>

            </li>

            <li class="breadcrumb-item active" aria-current="page">

              {{ $title }}

            </li>

          </ol>

        </nav>

      </div>

    </div>

</div>




      <section class="section">

      

          <div class="card">

            <div class="card-body">

              @if( $retraits->isNotEmpty() )

              <table class="table table-striped" id="table1">

                <thead>

                  <tr style="text-transform: uppercase;">

                    <th class="text-center">N°</th>

                    <th class="text-center">Reference</th>

                    <th class="text-center">Montant</th>

                    <th class="text-center">Date de retrait</th>
                    <th class="text-center">Heure de retrait</th>

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

                        <td class="text-center"><b>{{ number_format($v->montant + $v->frais, 0, 2, ' ') }} BIF</b></td>

                        <td class="text-center">{{ $v->date_op }}</td>
                        <td class="text-center">{{ $v->heure_op }}</td>

                        

                        <td class="text-center">

                          <a target="_blank" href="{{ route('client-retrait-print', strtolower($v->ref)) }}" class="btn btn-primary">

                            <i class="bi bi-printer"></i> &nbsp; Imprimer le reçu</a>

                          <!--<a href="#" class="btn btn-danger">

                            <i class="mdi mdi-delete"></i>Supprimer </a>-->

                        </td>

                      </tr>

                  @endforeach

                </tbody>

              </table>

              @else

                  <div class="alert alert-info">

                    <h4 class="alert-heading">Info</h4>

                    <p>Il n'y a pas de retraits disponible en ce moment !</p>

                  </div>

              @endif

            </div>

          </div>

          

      </section>

@endsection



@section('js')



<script src="/assets/extensions/jquery/jquery.min.js"></script>

<script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}" id="parsley"></script>

<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>

<script src="/assets/js/pages/simple-datatables.js"></script>







@endsection