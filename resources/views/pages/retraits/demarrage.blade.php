@extends('layouts.template')

@section('title', 'Commencer le retrait')

@section('css')
  <style type="text/css">
    .pin-input{
        font-size: 20px;
        font-family: "Segoe UI Symbol", sans-serif;
        -webkit-text-security: disc;
        -moz-text-security: disc;
        text-security: disc;

        font-display: block;
    }
  </style>
@endsection
@section('content')
  
	<div class="page-heading">

	  <div class="row">

	      <div class="col-md-6">

	        <h3>Commencer le retrait</h3>

	      </div>

	  </div>

	</div>


  <section class="row">
      @if( session()->has('msg_error') )

      <div class="col-md-12">

          <div class="alert alert-danger">{{ session()->get('msg_error') }}</div>

      </div>

      @endif

      <div class="card">

          <div class="card-body text-center">

              <h1 style="font-size: 50px;"><i class="bi bi-bag-fill"></i></h1>

              <h2 class="mb-4" style="color: green;">

                Vous êtes sur le point de commencer un retrait, <br>êtes-vous prêt pour commencer ?

              </h2>   



              <a href="javascript(0);" data-bs-toggle="modal" data-bs-target="#numberAccount" class="btn btn-warning btn-lg">Commencer maintenant <i class="bi bi-arrow-right"></i></a>

          </div>



      </div>

      

 </section>

  <!--BEGIN RETRAIT-->

<div class="modal fade text-left" id="numberAccount" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">

      <div class="modal-content">

        <div class="modal-header bg-primary white">

          <sapn class="modal-title" id="myModalLabel150">

            Retrait

          </sapn>

          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">

            <i data-feather="x"></i>

          </button>

        </div>

        <div class="modal-body">

            

            <h2 class="mb-4">Commencer le retrait</h2>

            <form class="" method="GET" action="{{ route('retrait-new-search-account') }}">



                {{ csrf_field() }}



                <div class="form-group">

                  <label class="mb-2" style="font-size: 18px;" for="num_account">Entrer le numéro de compte du client * </label>
                  <input type="text" required data-parsley-group="block1" class="form-control form-control-xl" id="num_account" name="flash">

                </div>

                <div class="form-group mt-4">

                  <label class="mb-2" style="font-size: 18px;" for="pin_code">Code pin * </label>
                  <input type="text"  required data-parsley-group="block1" class="form-control form-control-xl pin-input" id="pin_code" name="pin_code" maxlength="4" autocomplete="off">

 
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

<!--/END BEGIN RETRAIT-->

@endsection

@section('js')
<script src="/assets/extensions/jquery/jquery.min.js"></script>
@endsection
