@extends('layouts.template')

@section('title', 'Validation du virement')

@section('content')

	<div class="page-heading">

	  <div class="row">

	      <div class="col-md-6">

	        <h3>Validation du virement</h3>

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

                Le virement a été effectué avec succès.

              </h2>   



              <a href="{{ route('virements') }}" class="btn btn-dark btn-lg"><i class="bi bi-arrow-clockwise"></i> Faire une autre opération</a>
              <a target="_blank" href="{{ route('virement-print', $ref) }}" class="btn btn-success btn-lg"><i class="bi bi-printer"></i> Imprimer le reçu</a>

          </div>



      </div>

 </section>



@endsection
