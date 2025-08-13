@extends('layouts.template')

@section('title', 'Gestion du plan comptable')

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

	              <a href="{{ route('dashboard') }}">Tableau de bord</a>

	            </li>

	            <li class="breadcrumb-item active" aria-current="page">

	              Gestion du plan comptable


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
      <div class="row">
      	<div class="col-md-12">


      		<div class="card">

		        <div class="card-header">
	        		<h2>Gestion du plan comptable</h2>
		        </div>

		        <div class="card-body">

              @if($gestion_comptables->isNotEmpty())

              <table id="table1" class="table">

                <thead>

                  <tr class="bg-primary text-white">

                    <th class="text-center">N°</th>

                    <th class="text-center">Libéllé</th>

                    <th class="text-center">Compartiment</th>
                    <th class="text-center">Sens</th>

                    <th class="text-center">Débiteur</th>

                    <th class="text-center">Créditeur</th>

                    <th class="text-center">Action</th>

                  </tr>

                </thead>

                <tbody>

                  @php

                    $i = 1;

                    @endphp

                    

                    @foreach( $gestion_comptables as $m )

                    <tr>

                        <td class="text-center">{{ $m->numero }}</td>
                        <td class="text-center">{{$m->libelle}}</td>
                        <td class="text-center">
                            {{$m->compartiment}}
                        </td>
                        <td class="text-center">
                            {{$m->sens}}
                        </td>



                        <td class="text-center">{{ $m->debiteur }}</td>
                        <td class="text-center">{{ $m->crediteur }}</td>

                        <td class="text-center">
                          <a href="{{ route('gestion-comptable-edit', $m->numero) }}" class="btn btn-primary">Editer</a>
                        </td>

                    </tr>

                    @endforeach

                </tbody>
              </table>
              
              @else
              <div class="alert alert-warning">
                <h4 class="alert-heading">Info</h4>
                <p>Vous n'avez pas d'opérations en ce moment !</p>
              </div>
              @endif
              
		        </div>

	      	</div>
      	</div>
    	</div>
  	</section>
@endsection
@section('js')
<script src="/assets/extensions/jquery/jquery.min.js"></script>

<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/assets/js/pages/simple-datatables.js"></script>
@endsection