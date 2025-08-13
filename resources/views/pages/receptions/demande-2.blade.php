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

        <h3 style="text-transform: uppercase;">{{ $title }}</h3>

      </div>

      <div class="col-12 col-md-6 order-md-2 order-first">

        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">

          <ol class="breadcrumb">

            <li class="breadcrumb-item">

              <a href="{{ route('dashboard') }}">Tableau de bord</a>

            </li>

            <li class="breadcrumb-item active" aria-current="page">

              {{ $title }}

            </li>

          </ol>

        </nav>

      </div>

    </div>

</div>



    @if( session()->has('msg_success') )

    <div class="col-md-12">

        <div class="alert alert-success">{{ session()->get('msg_success') }}</div>

    </div>

    @endif

    @if( session()->has('msg_info') )

    <div class="col-md-12">

        <div class="alert alert-info">{{ session()->get('msg_info') }}</div>

    </div>

    @endif


    @if( session()->has('msg_error') )

    <div class="col-md-12">

        <div class="alert alert-danger">{{ session()->get('msg_error') }}</div>

    </div>

    @endif



    

    	

    <section class="section">

      <div class="row">

      	<div class="col-md-6">

	        <div class="card">

	          <div class="card-header">

	              

	          </div>

	          <div class="card-body">

	            	<form class="forms-sample" action="{{ route('add-files-credit') }}" method="POST" enctype="multipart/form-data">



		          		{{ csrf_field() }}

		          		<input type="hidden" name="code" value="{{ $rand }}">

	        				<input type="hidden" value="{{ $data->number_account }}" name="num_account">

			            <div class="row">

			            	

			            	<div class="col-md-12">

											<div class="form-group">

					              <label for="libelle" class="mb-3">Libelle * </label>

					              <input type="text" class="form-control form-control-xl" id="libelle" name="libelle" required>

					            </div>

			            	</div>



			            	<div class="col-md-12">



											<div class="form-group">

					              <label for="file" class="mb-3">Fichier scanné * </label>

					              <input type="file" accept="application/pdf" class="form-control form-control-xl" id="file" name="file" required>

					            </div>

			            	</div>



			            	<div class="col-md-12">

											<div class="form-group">

					              <button type="submit" class="btn btn-primary btn-lg">Ajouter</button>

					            </div>

			            	</div>

									</div>

								</form>



								

	          </div>

	        </div>

      	</div>



      	<div class="col-md-6">

      			<div class="card">

			        <div class="card-header">

			        		<h2>Resumé du compte: {{ $data->number_account }}</h2>

			        </div>

			        <div class="card-body">

			          	<div class="list-group" style="font-size: 25px;">

			              <span class="list-group-item"><b>Solde:</b> <span style="color: green;">{{ number_format($data->solde, 0, 2, ' ') }} BIF</span></span>

			              <span class="list-group-item"><b>Nom et Prenom(s) du client: </b>{{ $data->nom }} @if($data->prenom != 'NULL' ) {{ $data->prenom }} @endif</span>

			              @if($data->email != 'NULL' )

			              <span class="list-group-item"><b>Email: </b>{{ $data->email }}</span>

			              @endif

			              <span class="list-group-item"><b>Type de compte: </b>{{ $data->name }}</span>

			            </div>

			        </div>

			      </div>

      	</div>



      	<div class="col-md-12">


								@if( $docs->isNotEmpty() )

									<div class="card">

										<div class="card-body">

											<div class="row">

												<table class="table table-bordered mb-4">

													<thead style="text-transform: uppercase;">

														<th class="text-center">Libellé</th>

														<th class="text-center">Document</th>

														<th class="text-center">Action</th>

													</thead>

													<tbody>

														@foreach( $docs as $d )

														<tr>

															<td class="text-center">{{ $d->libelle }}</td>

															<td class="text-center">

																<a href="/assets/docs/credits/{{ $d->file }}">Voir le document</a>

															</td>

															<td class="text-center">

																<button type="button" class="btn btn-danger"><i class="bi bi-trash"></i></button>

															</td>

														</tr>

														@endforeach

													</tbody>

												</table>



												<form class="forms-sample" action="{{ route('send-demande-credit') }}" method="POST">

													{{ csrf_field() }}

													<input type="hidden" name="type" value="{{ $type }}">
													<input type="hidden" name="codeClient" value="{{ $data->code_client }}">
							        		<input type="hidden" name="amount" value="{{ $amount }}">
							        		<input type="hidden" name="code" value="{{ $rand }}">
							        		<input type="hidden" value="{{ $data->number_account }}" name="num_account">



													<a href="<?= $_SERVER['HTTP_REFERER']; ?>" class="btn btn-danger btn-lg"> < Annuler</a>
													<button type="submit" class="btn btn-success btn-lg"> Envoyer la demande au chef de service de credit ></button>

												</form>

											</div>



											

										</div>

									</div>

								@endif



      			



      	</div>

      </div>

    </section>

@endsection



@section('js')





<script type="text/javascript">



		$(document).ready(function() {

				

				var amount = $('#amount').val();

				

				$("#type").change(function () {

                 

		            $("#type option:selected").each(function () {



		            	var type = $('#type').val();

		            	$('#result_type').val(type);



			        });



		        });





				$("#sendDemande").on('show.bs.modal', function(){

		        //var button = $(e.relatedTarget);

		        //var id = button.data('id');



				var amount = $('#amount').val();

				

		        var modal = $(this);



	        	$('#dragula-right').show();

				modal.find('#result_amount').val(amount);

				//modal.find('#result_type').val(type);

	        	modal.find('#affiche_amount').html(amount+' BIF');

		

		    });

      

		});



</script>

@endsection