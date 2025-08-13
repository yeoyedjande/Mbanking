@extends('layouts.template')

@section('title', 'Commencer le virement')

@section('content')

	<div class="page-heading">

	  <div class="row">

	      <div class="col-md-6">

	        <h3>Commencer le virement</h3>

	      </div>

	  </div>

	</div>


  <section class="row">

      <div class="card">

          <div class="card-body text-center">

              <h1 style="font-size: 50px;"><i class="bi bi-arrow-left-right"></i></h1>

              <h2 class="mb-4" style="color: blue;">

                Vous êtes sur le point de commencer un virement, <br>êtes-vous prêt pour commencer ?

              </h2>   



              <a href="javascript(0);" data-bs-toggle="modal" data-bs-target="#numberAccount" class="btn btn-success btn-lg">Commencer maintenant <i class="bi bi-arrow-right"></i></a>

          </div>



      </div>

 </section>

<!--BEGIN VERSEMENT-->

<div class="modal fade text-left" id="numberAccount" tabindex="-1" role="dialog" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">

      <div class="modal-content">

        <div class="modal-header bg-primary white">

          <sapn class="modal-title" id="myModalLabel150">

            Virement

          </sapn>

          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">

            <i data-feather="x"></i>

          </button>

        </div>

        <div class="modal-body">

            

            <h2 class="mb-4">Commencer le virement</h2>

            <form class="" method="GET" action="{{ route('virement-new-2') }}">



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
