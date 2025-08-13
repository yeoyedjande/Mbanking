@extends('layouts.app')



@section('title', $title)



@section('css')

<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="/assets/vendors/select2/select2.min.css">
<link rel="stylesheet" href="/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">

@endsection



@section('content')

	<div class="page-header">

    <h3 class="page-title">{{ $title }}</h3>

    <nav aria-label="breadcrumb">

      <ol class="breadcrumb">

        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>

        <li class="breadcrumb-item active" aria-current="page"> {{ $title }} </li>

      </ol>

    </nav>

  </div>



<div class="row">

    <div class="col-12">

      <div class="card">

        <div class="card-body">

          <div class="container pt-5">

            

            <div class="row pricing-table">

              

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

    

              <div class="col-md-12 grid-margin stretch-card pricing-card">



                <div class="card border-primary border pricing-card-body">

                  <div class="pricing-card-head">

                    

                    <form class="forms-sample" action="{{ route('caisse-rechargement-valid') }}" method="POST">



                        {{ @csrf_field() }}

                        <div class="row">

                            

                            <div class="col-md-6">

                              <div class="form-group">

                                  <label>Caisse *</label> <br>

                                  <select class="form-control form-control-lg" id="" name="caisse" required>

                                    <option value="">Selectionner</option>

                                    @foreach($caisses as $a)

                                    <option value="{{ $a->id }}">{{ $a->name }}</option>

                                    @endforeach

                                  </select>

                              </div>

                            </div>



                            <div class="col-md-6">

                              <div class="form-group">

                                  <label>Guichetier *</label> <br>

                                  <select class="form-control form-control-lg" id="" name="guichetier" required>

                                    <option value="">Selectionner</option>

                                    @foreach($guichetiers as $a)

                                    <option value="{{ $a->id }}">{{ $a->nom }} {{ $a->prenom }}</option>

                                    @endforeach

                                  </select>

                              </div>

                            </div>



                            <div class="col-md-12">

                              <div class="form-group">

                                  <label>Montant Initial *</label> <br>

                                  <input type="number" class="form-control form-control-lg" name="montant" value="0" min="0" required>

                              </div>

                            </div>



                            <div class="col-md-12">

                              <div class="form-group">

                                  <button type="submit" class="btn btn-success btn-block btn-lg">Recharger</button>

                              </div>

                            </div>



                        </div>

                    </form>



                  </div>

                  

                </div>

              </div>

              

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

@endsection



@section('js')

<script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>

<script src="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>

<script src="/assets/js/data-table.js"></script>

<script src="/assets/vendors/select2/select2.min.js"></script>

<script src="/assets/js/select2.js"></script>



<script type="text/javascript">



		$(document).ready(function() {

				

			$("#num_account").change(function () {

                 

                 

         	//console.log(" Numero Compte ");



            $("#num_account option:selected").each(function () {



                var num_account = $("#num_account").val();



               if (num_account) {

                    

                    console.log('Tu as trouver')



                    $.post("",{num_account:num_account},function(data){



                	 	$("#res_cent").html(data);

                   

                	});



                }else{

                  console.log("Veuillez saisir un num_account. ");

                }



            });



        })

      

        .trigger('change');



		});



</script>

@endsection