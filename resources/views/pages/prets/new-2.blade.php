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



    

    	

  	<div class="row">

     	

     	

	    <div class="col-md-7 grid-margin stretch-card">

	      

	      <div class="card">

	        <div class="card-body">

	          <!--<h4 class="card-title mb-4">Faire un retrait</h4>-->



	          	<ul class="nav nav-pills nav-pills-success" id="pills-tab" role="tablist">

                <li class="nav-item">

                  <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">SIMULATION</a>

                </li>

                <li class="nav-item">

                  <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">DOSSIERS</a>

                </li>

               

              </ul>

              <div class="tab-content" id="pills-tabContent">

                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                  	

                  	<form class="forms-sample" action="{{ route('pret-simulation') }}" method="POST">



                  		{{ csrf_field() }}

	                  	<div class="row">



					            	<div class="col-md-6">

													<div class="form-group">

							              <label for="num_account">Numéro de compte * </label>

							              <input type="text" value="{{ $data->number_account }}" class="form-control form-control-lg" id="num_account" name="num_account" readonly required>

							            </div>

					            	</div>



					            	<div class="col-md-6">

													<div class="form-group">

							              <label for="duree_credit">Durée du crédit * </label>

							              <select id="duree_credit" class="form-control form-control-lg" name="duree_credit" style="padding-top: 10px;" required>

							              		<option value="">Selectionner</option>

							              		<option data-taux = "0.0045" value="3">3 mois</option>

							              		<option data-taux = "0.0045" value="6">6 mois</option>

							              		@foreach( $type_credits as $t )

							              		<option data-taux = "{{ $t->taux }}" value="{{ $t->echeance }}">{{ $t->echeance }} mois</option>

							              		@endforeach

							              </select>

							            </div>

					            	</div>



					            	<div class="col-md-6">

													<div class="form-group">

							              <label for="date_deboursement">Date de déboursement * </label>

							              <input type="date"  class="form-control form-control-lg" id="date_deboursement" name="date_deboursement" required>

							            </div>

					            	</div>



					            	<div class="col-md-6">

													<div class="form-group">

							              <label for="amount_frais">Montant des frais de dossier * </label>

							              <input type="amount_frais" min="1000" style="color: red; font-weight: bold;" class="form-control form-control-lg" id="amount_frais" name="amount_frais" required>

							            </div>

					            	</div>

					            	<div class="col-md-6">

													<div class="form-group">

							              <label for="periode">Période de remboursement * </label>

							              <select class="form-control form-control-lg" name="periode" style="padding-top: 10px;" required>

							              		<option value="">Selectionner</option>

							              		<option value="jour">Par Jour</option>

							              		<option value="semaine">Par Semaine</option>

							              		<option value="mois">Par Mois</option>

							              </select>

							            </div>

					            	</div>

					            	<div class="col-md-6">

													<div class="form-group">

							              <label for="amount">Montant du prêt * </label>

							              <input type="number" id="amount" min="0" style="color: green; font-weight: bold;" class="form-control form-control-lg" name="amount" required>

							            </div>

					            	</div>



					            	<div class="col-md-6">

													<div class="form-group">

							              <label for="amount_commission">Montant de la commission * </label>

							              <input type="number" id="amount_commission" min="0" class="form-control form-control-lg" name="amount_commission" required>

							            </div>

					            	</div>



					            	<div class="col-md-6">

													<div class="form-group">

							              <label for="amount_assurances">Montant des assurances * </label>

							              <input type="number" id="amount_assurances" min="0" class="form-control form-control-lg" name="amount_assurances" required>

							            </div>

					            	</div>



					            	<div class="col-md-6">

													<div class="form-group">

							              <label for="taux_interet">Taux d'intérêt * </label>

							              <input type="number" id="taux_interet" min="0" class="form-control form-control-lg" name="taux_interet" required>

							            </div>

					            	</div>



					            	<div class="col-md-12">

													<div class="form-group">

							              <label for="description">Description du prêt * </label>

							              <textarea class="form-control" name="description" rows="10" placeholder="Ecrire une description du prêt" required></textarea>

							            </div>

					            	</div>

					            	

												<div class="col-md-12">

													<div class="form-group">

							              <button type="submit" class="btn btn-primary btn-lg me-2"> <i class="mdi mdi-arrow-down"></i> &nbsp;&nbsp; Voir le resultat</button>

							            </div>

					            	</div>

											</div>



										</form>

                </div>

                      

	            

								<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

	                <div class="row">

	                		

	                		<div class="col-md-12">

												<div class="form-group">

						              <label for="libelle">Libellé * </label>

						              <input type="text" class="form-control form-control-lg" id="libelle" name="libelle" required>

						            </div>



				            	</div>



				            	<div class="col-md-12">

												

						            <div class="form-group">

						              <label for="fichier">Fichier (.pdf, .jpg, .docx) * </label>

						              <input type="file" class="form-control form-control-lg" id="fichier" name="fichier" required>

						            </div>



				            	</div>



				            	<div class="col-md-12">

												

						            <div class="form-group">

						              <button type="submit" class="btn btn-primary">Ajouter</button>

						            </div>



				            	</div>





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

	            	<div class="card mb-5">

	                    <div class="card-body">

	                      <div id="dragula-right" class="py-2">

	                      		<div class="card rounded border mb-2">

		                            <div class="card-body p-3">

		                              <div class="media">

		                                <i class="mdi mdi-money icon-sm align-self-center me-3"></i>

		                                <div class="media-body">

		                                  <h6 class="mb-1">Solde</h6>

		                                  <p class="mb-0 text-muted"> <span style="color: green; font-weight: bold;" >{{ number_format($data->solde, 0, 2, ' ') }} BIF</span></p>

		                                </div>

		                              </div>

		                            </div>

		                        </div>



	                      		<div class="card rounded border mb-2">

		                            <div class="card-body p-3">

		                              <div class="media">

		                                <i class="mdi mdi-account icon-sm align-self-center me-3"></i>

		                                <div class="media-body">

		                                  <h6 class="mb-1">Nom et Prenom(s) client</h6>

		                                  <p class="mb-0 text-muted"> {{ $data->nom }} @if($data->prenom != 'NULL' ) {{ $data->prenom }} @endif</p>

		                                </div>

		                              </div>

		                            </div>

		                        </div>

		                        @if($data->email != 'NULL' )

		                        <div class="card rounded border mb-2">

		                            <div class="card-body p-3">

		                              <div class="media">

		                                <i class="mdi mdi-email icon-sm align-self-center me-3"></i>

		                                <div class="media-body">

		                                  <h6 class="mb-1">Email client</h6>

		                                  <p class="mb-0 text-muted"> {{ $data->email }}</p>

		                                </div>

		                              </div>

		                            </div>

		                        </div>

													@endif

		                        <div class="card rounded border mb-2">

		                            <div class="card-body p-3">

		                              <div class="media">

		                                <i class="mdi mdi-email icon-sm align-self-center me-3"></i>

		                                <div class="media-body">

		                                  <h6 class="mb-1">Type de compte</h6>

		                                  <p class="mb-0 text-muted"> {{ $data->name }}</p>

		                                </div>

		                              </div>

		                            </div>

		                        </div>



		                        <div class="card rounded border mb-2">

		                            <div class="card-body p-3">

		                              <div class="media">

		                                <i class="mdi mdi-email icon-sm align-self-center me-3"></i>

		                                <div class="media-body">

		                                  <h6 class="mb-1">Numero de compte</h6>

		                                  <p class="mb-0 text-muted"> {{ $data->number_account }}</p>

		                                </div>

		                              </div>

		                            </div>

		                        </div>



	                      </div>

	                    </div>

                    </div>

				</div>

	        </div>

	      </div>

	    </div>           

		</div>



		<div class="modal fade" id="addVersement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

		  <div class="modal-dialog modal-md" role="document">

		    <div class="modal-content">

		      <div class="modal-header">

		        <h5 class="modal-title" id="exampleModalLabel">Réviser le retrait</h5>

		        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">

		          <span aria-hidden="true">&times;</span>

		        </button>

		      </div>



		      <form class="forms-sample" action="{{ route('retrait-new-valid') }}" method="POST">

		      <div class="modal-body">

		        		<div class="alert alert-warning">Bien vouloir vérifier le retrait ci-après et cliquer sur le bouton de confirmation</div>



		        		{{ csrf_field() }}

		        		<input type="hidden" value="{{ $data->number_account }}" name="num_account">

		        		<input type="hidden" id="result_amount" name="amount">





		        		<div id="dragula-right" class="py-2">

              		<div class="rounded border mb-2">

                      <div class="card-body p-3">

                        <div class="media">

                          <i class="mdi mdi-user icon-sm align-self-center me-3"></i>

                          <div class="media-body">

                            <h6 class="mb-1">Numéro de compte</h6>

                            <p class="mb-0 text-muted">{{ $data->number_account }}</span></p>

                          </div>

                        </div>

                      </div>

                  </div>

                  <div class="rounded border mb-2">

                      <div class="card-body p-3">

                        <div class="media">

                          <i class="mdi mdi-money icon-sm align-self-center me-3"></i>

                          <div class="media-body">

                            <h6 class="mb-1">Nom du client</h6>

                            <p class="mb-0 text-muted">{{ $data->nom }} @if($data->prenom != 'NULL' ) {{ $data->prenom }} @endif</p>

                          </div>

                        </div>

                      </div>

                  </div>

                  <div class="rounded border mb-2">

                      <div class="card-body p-3">

                        <div class="media">

                          <i class="mdi mdi-money icon-sm align-self-center me-3"></i>

                          <div class="media-body">

                            <h6 class="mb-1">Montant du retrait</h6>

                            <p class="mb-0 text-muted">

                            	<span id="affiche_amount" style="font-weight: bold; color: #FF0000;"></span>

                            </p>

                          </div>

                        </div>

                      </div>

                  </div>



                  <div class="rounded border mb-2">

                      <div class="card-body p-3">

                        <div class="media">

                          <i class="mdi mdi-calendar icon-sm align-self-center me-3"></i>

                          <div class="media-body">

                            <h6 class="mb-1">Date du retrait</h6>

                            <p class="mb-0 text-muted">

                            	<?= date('d/m/Y'); ?>

                            </p>

                          </div>

                        </div>

                      </div>

                  </div>



                </div>

		      </div>

		      <div class="modal-footer">

		        <button type="submit" class="btn btn-success">Confirmer le retrait</button>

		        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Retour</button>

		      </div>

		    </form>

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

				

				$("#addVersement").on('show.bs.modal', function(){

		        //var button = $(e.relatedTarget);

		        //var id = button.data('id');



		        var amount = $('#amount').val();

		        var modal = $(this);



		        modal.find('#result_amount').val(amount);

		        modal.find('#affiche_amount').html(amount+' BIF');

		    });



				$("#duree_credit").change(function () {



					$("#duree_credit option:selected").each(function () {

							var duree = $("#duree_credit").val();

							var taux = $(this).data('taux');



							console.log(taux)



							$("#amount").keyup(function(){

									var amount = $("#amount").val();



									if ( amount ) {

										$('#amount_commission').val(Math.ceil(amount * 0.06));

										$('#amount_assurances').val(Math.ceil(amount * taux));

									}



							});



					});



				});



      

		});



</script>

@endsection