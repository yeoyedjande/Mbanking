@extends('layouts.template')

@section('title', 'Dépenses et Revenus')

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

	              Dépenses et Revenus


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
	        		<h2>Dépenses et Revenus</h2>
               <span class="d-flex justify-content-end">

                <a href="{{ route('add-depenses-revenu') }}" class="btn btn-primary btn-lg">

                     Ajouter

                </a>

              </span> 
		        </div>

		        <div class="card-body">

		        	<div class="col-12">

              @if($depensesRevenus->isNotEmpty())

              <table id="table1" class="table" cellspacing="0" width="100%">

                <thead>

                  <tr class="bg-primary text-white">

                    <th class="text-center">N°</th>
                    <th class="text-center">Libéllé</th>
                    <th class="text-center">Sens</th>
                    <th class="text-center">Action</th>

                  </tr>

                </thead>

                <tbody>

                  @php

                    $i = 1;

                    @endphp

                    

                    @foreach( $depensesRevenus as $m )

                    <tr>

                        <td class="text-center">{{ $m->numero }}</td>
                        <td class="text-center">{{$m->libelle}}</td>
                       
                        <td class="text-center">
                            {{$m->sens}}
                        </td>
                        <td class="text-center">
                          <a href="#" class="btn btn-primary">Editer</a>
                        </td>

                    </tr>

                    @endforeach

                </tbody>
              </table>
              
              @else
              <div class="alert alert-warning">
                <h4 class="alert-heading">Info</h4>
                <p>Vous n'avez pas de libellé en ce moment !</p>
              </div>
              @endif
              
            </div>

		          	
		        </div>

	      	</div>
      	</div>
    	</div>
  	</section>
@endsection