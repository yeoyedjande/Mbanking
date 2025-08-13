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

    <form class="forms-sample" action="{{ route('virement-new-2') }}" method="POST">
    	<div class="row">

	     	{{ csrf_field() }}
	     	
		    <div class="col-md-7 grid-margin stretch-card">
		      
		      <div class="card">
		        <div class="card-body">
		          <!--<h4 class="card-title mb-4">Faire un virement</h4>-->

		          
		            <div class="row">

		            	<div class="col-md-8">
							<div class="form-group">
				              <label for="num_account">Numéro de compte * </label>
				              <input type="text" class="form-control form-control-lg" name="num_account" autocomplete="0" required>
				            </div>
		            	</div>

		            	<div class="col-md-12">
							<div class="form-group">
							  <label>&nbsp;&nbsp;</label> <br>
				              <button type="submit" class="btn btn-primary btn-lg me-2"> <i class="mdi mdi-eye"></i> &nbsp;&nbsp; Verifier</button>
				            </div>
		            	</div>
 
					</div>

		        </div>
		      </div>
		    </div>

		    <div class="col-md-5 grid-margin stretch-card">
		      <div class="card">
		        <div class="card-body">
		          <h4 class="card-title mb-4">Resumés de compte</h4>
		            <div class="row">
		            	<div class="card card-inverse-danger mb-5">
		                    <div class="card-body">
		                      <p class="mb-4"> Vous devez saisir le numéro de compte pour voir le resumé du compte correspondant !</p>
		                    </div>
	                    </div>
					</div>
		        </div>
		      </div>
		    </div>

		</div>
    </form>
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