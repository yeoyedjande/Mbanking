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

              Versements

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

        <div class="card-header">

            <span class="d-flex justify-content-end">

              <a href="{{ route('versement-start') }}" class="btn btn-primary btn-lg">

                   Faire un versement

              </a>

            </span>

        </div>

        <div class="card-body">

          @if( $versements->isNotEmpty() )

          <table class="table table-striped" id="table1">

            <thead>

              <tr style="text-transform: uppercase;">

                <th class="text-center">N°</th>

                <th class="text-center">Reference</th>

                <th class="text-center">Numero de compte</th>

                <th class="text-center">Montant</th>

                <th class="text-center">Nom client</th>

                <th class="text-center">Date de versement</th>

                <th class="text-center">Actions</th>

              </tr>

            </thead>

            <tbody>

              @php

              $i = 1;

              @endphp

              

              @foreach( $versements as $v )

              <tr>

                <td class="text-center">{{ $i++ }}</td>

                <td class="text-center">{{ $v->ref }}</td>

                <td class="text-center">{{ $v->account_id }}</td>

                <td class="text-center"><b>{{ number_format($v->montant, 0, 2, ' ') }} BIF</b></td>

                <td class="text-center"><b>{{ $v->nom }} <?php if ($v->prenom != 'NULL'): ?>

                  {{ $v->prenom }}

                <?php endif ?></b></td>

                <td class="text-center">{{ $v->date_op }}</td>

                

                <td class="text-center">

                  <a target="_blank" href="{{ route('versement-print', strtolower($v->ref)) }}" class="btn btn-primary btn-xs">

                    <i class="bi bi-printer"></i> &nbsp; Imprimer le reçu</a>

                </td>

              </tr>

              @endforeach

            </tbody>

          </table>

          @else

              <div class="alert alert-info">

                <h4 class="alert-heading">Info</h4>

                <p>Il n'y a pas de versement disponible en ce moment !</p>

              </div>

          @endif

        </div>

      </div>

      

  </section>



<!--BEGIN VERSEMENT-->

<div class="modal fade text-left" id="numberAccount" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">

      <div class="modal-content">

        <div class="modal-header bg-primary white">

          <sapn class="modal-title" id="myModalLabel150">

            Versement

          </sapn>

          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">

            <i data-feather="x"></i>

          </button>

        </div>

        <div class="modal-body">

            

            <h2 class="mb-4">Commencer le versement</h2>

            <form class="" method="GET" action="{{ route('versement-new-search-account') }}">



                {{ csrf_field() }}



                <div class="form-group">

                  <label class="mb-4" style="font-size: 18px;" for="num_account">Entrer le numéro de compte du client * </label>

                  <input type="text" required data-parsley-group="block1" class="form-control form-control-xl" value="" id="num_account" name="flash" autocomplete="off" autofocus>

                </div>



                <div class="form-group mt-4">

                  <button type="button" class="btn btn-dark btn-lg" data-bs-dismiss="modal">

                    <i class="bx bx-x d-block d-sm-none"></i>

                    <span class="d-none d-sm-block">Fermer</span>

                  </button>

                  <button type="submit" class="btn btn-primary btn-lg">

                    <i class="bx bx-check d-block d-sm-none"></i>

                    <span class="d-none d-sm-block">Commencer ></span>

                  </button>

                </div>

            </form>



        </div>

      </div>

    </div>

</div>

<!--/END BEGIN VERSEMENT-->



@endsection



@section('js')



<script src="/assets/extensions/jquery/jquery.min.js"></script>



<script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}" id="parsley"></script>



<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>

<script src="/assets/js/pages/simple-datatables.js"></script>







@endsection