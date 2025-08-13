@extends('layouts.template')

@section('title', 'Enregistrement avec succes')

@section('content')

	<div class="page-heading">

	  <div class="row">

	      <div class="col-md-6">

	        <h3>Enregistrement avec succes</h3>

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



  <section class="row">

      <div class="card">



          <div class="card-body text-center">

              <h1 style="font-size: 50px;"><i class="bi bi-bank"></i></h1>

              <h2 class="mb-4" style="color: green;">

                La simulation a été effectuée avec succès.

              </h2>   

              <a href="{{ route('liste-demandes-assign') }}" class="btn btn-dark btn-lg"><i class="bi bi-arrow-clockwise"></i> Faire une autre simulation</a>
              <a href="{{ route('simulation-print', $dossier) }}" class="btn btn-success btn-lg"><i class="bi bi-printer"></i> Imprimer la simulation</a>

          </div>



      </div>

 </section>



@endsection
