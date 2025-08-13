@extends('layouts.app')

@section('title', $title)

@section('css')
<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
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

    <form class="forms-sample" action="#" method="POST">
    	<div class="row">

	     	{{ csrf_field() }}
	     	
		    <div class="col-md-7 grid-margin stretch-card">
		      
		      <div class="card">
		        <div class="card-body">
		          <h4 class="card-title mb-4">Defini le Montant initial</h4>

		          
		            <div class="row">

		            	<div class="col-md-6">
										<div class="form-group">
				              <label for="name">Montant * </label>
				              <input type="text" class="form-control" id="nom" name="nom" required placeholder="Nom" autocomplete="0" />
				            </div>
		            	</div>

		            	<div class="col-md-6">
										<div class="form-group">
				              <label for="prenom">Prénoms * </label>
				              <input type="text" class="form-control" id="prenom" name="prenom" required placeholder="Prénoms" autocomplete="0" />
				            </div>
		            	</div>

		            	<div class="col-md-6">
										<div class="form-group">
				              <label for="email">Email * </label>
				              <input type="text" class="form-control" id="email" name="email" required placeholder="Email" autocomplete="0" />
				            </div>
		            	</div>

		            	<div class="col-md-6">
										<div class="form-group">
				              <label for="telephone">Téléphone * </label>
				              <input type="text" class="form-control" id="telephone" name="telephone" required placeholder="Téléphone" autocomplete="0" />
				            </div>
		            	</div>
			            
			            
			            
								</div>

		          

		        </div>
		      </div>
		    </div>



		    <div class="col-md-12 text-center">
				<button type="submit" class="btn btn-primary btn-lg me-2"> Modifier </button>
            </div>
		</div>
    </form>
  </div>
@endsection

@section('js')
<script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="/assets/js/data-table.js"></script>

@endsection