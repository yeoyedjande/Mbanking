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
                    
                    <form class="forms-sample" action="{{ route('virement-new-confirm-valid') }}" method="POST">

                        {{ @csrf_field() }}
                        <div class="row">
                            
                            <input type="hidden" value="{{ $info_exp->number_account }}" name="num_account_exp">

                            <input type="hidden" value="{{ $info_dest->number_account }}" name="num_account_dest">

								        		<input type="hidden" value="{{ $amount }}" name="amount">


								        		<div id="dragula-right" class="py-2">
								        			<div class="rounded border mb-2">
						                      <div class="card-body p-3">
						                        <div class="media">
						                          <i class="mdi mdi-user icon-sm align-self-center me-3"></i>
						                          <div class="media-body">
						                            <h6 class="mb-1">Date du virement</h6>
						                            <p class="mb-0 text-muted"><?= date('d/m/Y'); ?></span></p>
						                          </div>
						                        </div>
						                      </div>
						                  </div>

						              		<div class="rounded border mb-2">
						                      <div class="card-body p-3">
						                        <div class="media">
						                          <i class="mdi mdi-user icon-sm align-self-center me-3"></i>
						                          <div class="media-body">
						                            <h6 class="mb-1">De:</h6>
						                            <p class="mb-0 text-muted">{{ $info_exp->number_account }} du client <b>{{ $info_exp->nom }} @if($info_exp->prenom != 'NULL') {{ $info_exp->prenom }} @endif</b></span></p>
						                          </div>
						                        </div>
						                      </div>
						                  </div>
						                  <div class="rounded border mb-2">
						                      <div class="card-body p-3">
						                        <div class="media">
						                          <i class="mdi mdi-money icon-sm align-self-center me-3"></i>
						                          <div class="media-body">
						                            <h6 class="mb-1">Vers:</h6>
						                            <p class="mb-0 text-muted">{{ $info_dest->number_account }} du client <b>{{ $info_dest->nom }} @if($info_dest->prenom != 'NULL') {{ $info_dest->prenom }} @endif</b></p>
						                          </div>
						                        </div>
						                      </div>
						                  </div>
						                  <div class="rounded border mb-2">
						                      <div class="card-body p-3">
						                        <div class="media">
						                          <i class="mdi mdi-money icon-sm align-self-center me-3"></i>
						                          <div class="media-body">
						                            <h6 class="mb-1">Montant du virement</h6>
						                            <p class="mb-0 text-muted">
						                            	<span id="" style="font-weight: bold; color: #FF0000;">{{ $amount }} BIF</span>
						                            </p>
						                          </div>
						                        </div>
						                      </div>
						                  </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                  <button type="submit" class="btn btn-success btn-block btn-lg">Confirmer le virement</button>

                                  <a href="{{ route('virement-new') }}"  class="btn btn-danger btn-block btn-lg">Annuler le virement</a>
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