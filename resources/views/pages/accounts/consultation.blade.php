@extends('layouts.template')

@section('title', $title)

@section('css')
  <link rel="stylesheet" href="/assets/css/pages/fontawesome.html" />
  <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css"/>
  <link rel="stylesheet" href="/assets/css/pages/simple-datatables.css" />
@endsection


@section('content')
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>Consultation de compte</h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Consultation de compte
            </li>
          </ol>
        </nav>
      </div>
    </div>
</div>

<section class="section">
  <div class="row">
    
      @if( session()->has('msg_success') )
      
          <div class="alert alert-success">{{ session()->get('msg_success') }}</div>
      
      @endif

      @if( session()->has('msg_error') )
      
          <div class="alert alert-danger">{{ session()->get('msg_error') }}</div>
      
      @endif
      <div class="card">
        <div class="card-body">
          
            <form action="{{ route('accounts-consultation-verif') }}" method="POST">
              {{ @csrf_field() }}

              <div class="row">
                  
                  <div class="col-md-4">
                      <div class="form-group">
                          <label class="mb-2 mt-3" style="font-size: 16px;">Consulter par numéro de compte</label> <br>
                          <input type="text" class="form-control form-control-xl" name="num_account" placeholder="Numéro de compte">
                      </div>
                  </div>

                  <div class="col-md-4">                 
                    <div class="form-group">
                        <label class="mb-2 mt-3" style="font-size: 16px;">Consulter par Email</label>
                        <input type="text" class="form-control form-control-xl" name="email" placeholder="Email">
                    </div>
                  </div> 

                  <div class="col-md-4">
                    <div class="form-group">
                        <label class="mb-2 mt-3" style="font-size: 18px;">Consulter par Téléphone</label>
                        <input type="text" class="form-control form-control-xl" name="phone" placeholder="Téléphone">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-dark btn-lg">Consulter</button>
                    </div>
                  </div>
              </div>
          </form>

        </div>
      </div>

  </div>  
</section>

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