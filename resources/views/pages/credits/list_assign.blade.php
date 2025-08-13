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

          <div class="card-header">

              Les demandes disponible

          </div>

          <div class="card-body">

            @if( $demandes->isNotEmpty() )

            <table id="order-listing" class="table table-bordered" id="table1">

                <thead>

                  <tr class="" style="text-transform: uppercase;">

                    <th class="text-center">N°</th>

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
                     
                      $demande_approuve = DB::table('credits')->join('analyses', 'analyses.demande_credit_id', '=', 'credits.num_dossier')
                      ->join('avis', 'avis.analyse_id', '=', 'analyses.id')
                      ->join('users', 'users.id', '=', 'avis.user_id')
                      ->join('roles', 'roles.id', '=', 'users.role_id')
                      ->Where('roles.id', 6)
                      ->Where('credits.id', $d->id)
                      ->first();

                      //var_dump($demande_approuve);

                    ?>
                    <tr>

                        <td class="text-center">{{ $i++ }}</td>

                        <td class="text-center">{{$d->name}}</td>



                        <td class="text-center">



                            {{ $d->nom }} @if($d->prenom != 'NULL') {{ $d->prenom }} @endif

                            

                        </td>





                        <td class="text-center">

                          <b>{{ number_format($d->montant_demande, 0, 2, ' ') }} BIF</b>

                        </td>

                        <td class="text-center"><b>

                          {{ $d->date_demande }}

                        </b></td>

                        <td class="text-center">
                        
                            <a href="{{ route('simulation-new', $d->num_dossier) }}" class="btn btn-dark btn-sm">Faire une simulation</a>

                            <a href="{{ route('complete-demandes', $d->num_dossier) }}" class="btn btn-primary btn-sm">Completez la demande</a>
                          
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            @else

                <div class="alert alert-info">

                  <h4 class="alert-heading">Info</h4>

                  <p>Il n'y a pas de demandes de credits disponible en ce moment !</p>

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