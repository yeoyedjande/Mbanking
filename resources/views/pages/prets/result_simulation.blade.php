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
     	
	    <div class="col-md-12 grid-margin stretch-card">
	      
	      	<div class="card">
	        		<div class="card-body">

	        			<form class="forms-sample" action="{{ route('pret-simulation-validate') }}" method="POST">

	        				{{ csrf_field() }}

	        				<input type="hidden" name="client_account" value="{{ $accountClient->number_account }}">
	        				<input type="hidden" name="duree" value="{{ $accountClient->number_account }}">
	        				<input type="hidden" name="client_account" value="{{ $accountClient->number_account }}">
	        				<input type="hidden" name="client_account" value="{{ $accountClient->number_account }}">
	        				<input type="hidden" name="client_account" value="{{ $accountClient->number_account }}">
	        				<input type="hidden" name="client_account" value="{{ $accountClient->number_account }}">
	        				<input type="hidden" name="client_account" value="{{ $accountClient->number_account }}">
	        				<input type="hidden" name="client_account" value="{{ $accountClient->number_account }}">
	        				<input type="hidden" name="client_account" value="{{ $accountClient->number_account }}">


	              	<div class="row">
	              		<h4>Critères de recherches</h4>
	              		<ul>
	              				<span>➥ Nom du Client: {{ $accountClient->nom }} @if($accountClient->prenom != 'NULL') {{ $accountClient->nom }} @endif</span> <br>
	              				<span>➥ Montant: {{ number_format($amount, 0, 2, ' ') }} BIF</span> <br>
	              				<span>➥ Durée du crédit: {{ $duree }}</span><br>
	              				<span>➥ Date de déboursement: {{ $date }}</span><br>
	              				<span>➥ Produit de crédit: Découvert sur {{ $duree }} mois</span><br>
	              				<span>➥ Montant des frais de dossier: {{ number_format($amount_frais, 0, 2, ' ') }} BIF </span><br>
	              				<span>➥ Montant de la commission: 0 BIF</span><br>
	              				<span>➥ Montant des assurances: 0 BIF</span><br>
	              				<span>➥ Montant de la garantie numéraire: 0 BIF</span><br>
	              				<span>➥ Montant de la garantie matérielle: 0 BIF</span><br>
	              				<span>➥ Différé: Aucun</span><br>
	              				<span>➥ Taux d'intérêt: {{ $taux_interet }}%</span><br>
	              				<span>➥ Périodicité de remboursement: Mensuelle</span><br>
	              				<span>➥ Mode de calcul des intérêts: Constant</span><br>
	              				<span>➥ Délais de grâce: 0 jours</span><br>
	              				<span>➥ Nombre de jours pour bloquer le crédit avant échéance: 0 jours</span><br>
	              		</ul>
	              		<hr>

			            	<table class="table">

			            			<tr>
			            				<td colspan="2"></td>
			            				<td colspan="4" style="font-weight: bold; text-align: center;">Echéance</td>
			            				<td colspan="4" style="font-weight: bold; text-align: center;">Solde</td>
			            			</tr>
			            			<tr style="">
			            				<td>N°</td>
			            				<td style="border-right: 1px solid;">Date</td>

			            				<td>Capital</td>
			            				<td>Intérêts</td>
			            				<td>Garantie</td>
			            				<td style="border-right: 1px solid;">Total</td>

			            				<td>Capital</td>
			            				<td>Intérêts</td>
			            				<td>Garantie</td>
			            				<td>Total</td>
			            			</tr>

			            			<?php 
		            						$total_dernier_2 = 0; 
		            						$capital_solde = 0;
		            						$pgcd = $amount;
		            						$interet_total = 0;
			            			?>
			            			<?php for ($i=1; $i <= $duree; $i++) { 

			            					$interet_total = $interet_mensuel + $interet_total;

			            					if ( $pgcd > $capital ) {
								                $pgcd = $pgcd - $capital;
								            }else{
								                $capital = $capital - $pgcd;
								            }

								            if ( $interet_solde_total > $interet_mensuel ) {
								                $interet_solde_total = $interet_solde_total - $interet_mensuel;
								            }else{
								                $interet_mensuel = $interet_mensuel - $interet_solde_total;
								            }

			            				?>


			            			<tr>
			            				<td>{{ $i }}</td>
			            				<td style="border-right: 1px solid;">
			            				<?php
                              $dateObj = DateTime::createFromFormat('d/m/Y', $date);
                              $dateObj->modify('+1 month');
                              $date = $dateObj->format('d/m/Y');
                              echo $date;
                           ?>
			            				</td>

			            				<td>
			            						<?php if ($i == $duree): ?>
			            							<?= number_format($montant_dernier, 0, 2, ' '); ?>
			            						<?php else: ?>
			            							<?= number_format(intval(round($capital)), 0, 2, ' '); ?>
			            						<?php endif ?>
			            				</td>
			            				<td>{{ number_format($interet_mensuel, 0, 2, ' ') }} BIF</td>
			            				<td>0</td>
			            				<td style="border-right: 1px solid; font-weight: bold;">
			            					<?php if ($i == $duree): ?>
		            							{{ number_format($montant_dernier+$interet_mensuel, 0, 2, ' ') }} BIF
		            							<?php $total_dernier = $montant_dernier+$interet_mensuel; ?>
		            						<?php else: ?>
		            							{{ number_format($capital+$interet_mensuel, 0, 2, ' ') }} BIF

		            							<?php $total_dernier_2 = $capital+$interet_mensuel + $total_dernier_2; ?>
		            						<?php endif ?>


			            				</td>

			            				<td><?= number_format(intval($pgcd), 0, 2, ' '); ?> BIF</td>
			            				<td><?= number_format(intval($interet_solde_total), 0, 2, ' '); ?> BIF</td>
			            				<td>12</td>
			            				<td>1 500 000 BIF</td>
			            			</tr>
			            			<?php } ?>

			            			<tbody>
			            					<th colspan="2" style="border-right: 1px solid;">Total</th>
			            					<th>{{ number_format($amount, 0, 2, ' ') }} BIF</th>
			            					<th>{{ number_format($interet_total, 0, 2, ' ') }} BIF</th>
			            					<th>0</th>
			            					<th style="border-right: 1px solid;">{{ number_format($amount + $interet_total, 0, 2, ' ') }} BIF</th>
			            			</tbody>
			            	</table>
									</div>
	               <div class="row mt-5">
										<div class="col-md-12">
			            			<button type="button" class="btn btn-primary btn-lg"> Enregistrer </button>
			            			<button type="submit" class="btn btn-success btn-lg"> Valider et Ajouter au dossier de prêt </button>
			            	</div>
	               </div>
               </form>

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
				
				$("#addVersement").on('show.bs.modal', function(){
		        //var button = $(e.relatedTarget);
		        //var id = button.data('id');

		        var amount = $('#amount').val();
		        var modal = $(this);

		        modal.find('#result_amount').val(amount);
		        modal.find('#affiche_amount').html(amount+' BIF');
		    });
      
		});

</script>
@endsection