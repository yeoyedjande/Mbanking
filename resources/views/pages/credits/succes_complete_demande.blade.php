@extends('layouts.template')

@section('title', 'Validation du versement')

@section('content')

	<div class="page-heading">

	  <div class="row">

	      <div class="col-md-6">

	        <h3>Validation du versement</h3>

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

              <h1 style="font-size: 50px;"><i class="bi bi-reception-4"></i></h1>

              <h2 class="mb-4" style="color: green;">

                Vous avez completé le dossier N° {{$dossier}} du client {{$client->nom}} avec succès. <br>

                Sachez que votre avis est la première étape de déblocage du crédit. Merci de procéder dans les meilleurs délais.

              </h2>   

              <a href="{{ route('avis-consulting', $dossier) }}" class="btn btn-success btn-lg"> Passez à la prochaine étape: Donnez votre avis ></a>

          </div>



      </div>

 </section>



@endsection
