@extends('layouts.template')

@section('title', 'Ouverture de dossier crédit')

@section('content')

	<div class="page-heading">

	  <div class="row">

	      <div class="col-md-6">

	        <h3>Dossier numéro {{ session()->get('dossier') }} ouvert</h3>

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

              <h1 style="font-size: 50px;"><i class="bi bi-handbag-fill"></i></h1>

              <h2 class="mb-4" style="color: green;">

                Vous avez ouvert un dossier de crédit dont le numéro est: {{ session()->get('dossier') }} <br>
                Le dossier suit son cours au niveau du chef de service crédit.

              </h2>   



              <a href="{{ route('demande-credit') }}" class="btn btn-dark btn-lg"><i class="bi bi-arrow-clockwise"></i> Faire une autre demande de crédit</a>

          </div>



      </div>

 </section>



@endsection
