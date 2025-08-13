@extends('layouts.template')

@section('title', 'Validation de la création du compte')

@section('content')

	<div class="page-heading">

	  <div class="row">

	      <div class="col-md-6">

	        <h3>Validation de la création du compte</h3>

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

              <h1 style="font-size: 50px;"><i class="bi bi-users"></i></h1>

              <h2 class="mb-4" style="color: green;">

                L'ouverture du compte à été effectué avec succès <br>
                Le numéro du compte du client est: {{$code}}

              </h2>   



              <a href="{{ route('account-index') }}" class="btn btn-dark btn-lg"><i class="bi bi-arrow-clockwise"></i> Faire une autre inscription</a>
              <a target="_blank" href="{{ route('account-print', $code) }}" class="btn btn-success btn-lg"><i class="bi bi-printer"></i> Imprimer la fiche d'inscription</a>

          </div>



      </div>

 </section>



@endsection
