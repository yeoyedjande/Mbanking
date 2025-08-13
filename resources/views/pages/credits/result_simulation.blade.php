@extends('layouts.template')
@section('title', $title)




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


	        				<input type="hidden" name="client_account" value="{{ $number_account }}">
	        				<input type="hidden" name="duree" value="{{ $duree }}">
	        				<input type="hidden" name="amount" value="{{ $amount }}">


	        				<input type="hidden" name="date_deboursement" value="{{ $accountClient->number_account }}">

	        				<input type="hidden" name="type_prod" value="{{ $type_credit }}">
	        				<input type="hidden" name="amount_commission" value="{{ $amount_commission }}">
	        				<input type="hidden" name="amount_assurances" value="{{ $amount_assurances }}">
	        				<input type="hidden" name="amount_garantie_numeraire" value="0">
	        				<input type="hidden" name="amount_garantie_materiel" value="0">

	        				<input type="hidden" name="differe" value="Aucun">
	        				<input type="hidden" name="taux_interet" value="{{ $taux_interet }}">

	        				<input type="hidden" name="periodicite" value="{{ $periode }}">
	        				<input type="hidden" name="mode_calcul" value="Constant">

	        				<input type="hidden" name="delai" value="0">
	        				<input type="hidden" name="nbr_jr" value="0">

	        				<input type="hidden" value="{{ $dossier }}" name="dossier">



	              	<div class="row">

	              		<h4>Critères de recherches</h4>

	              		<ul>

	              				<span>➥ Dossier: {{ $dossier }} </span> <br>
	              				<span>➥ Nom du Client: {{ $accountClient->nom }} @if($accountClient->prenom != 'NULL') {{ $accountClient->prenom }} @endif</span> <br>

	              				<span>➥ Montant: {{ number_format($amount, 0, 2, ' ') }} BIF</span> <br>

	              				<span>➥ Durée du crédit: {{ $duree }}</span><br>

	              				<span>➥ Date de déboursement: {{ $date }}</span><br>

	              				<span>➥ Produit de crédit: Découvert sur {{ $duree }} mois</span><br>

	              				<span>➥ Montant des frais de dossier: {{ number_format($amount_frais, 0, 2, ' ') }} BIF </span><br>

	              				<span>➥ Montant de la commission: {{ number_format($amount_commission, 0, 2, ' ') }} BIF</span><br>

	              				<span>➥ Montant des assurances: {{ number_format($amount_assurances, 0, 2, ' ') }} BIF</span><br>

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
			            				<input type="hidden" name="numero[]" value="{{ $i }}">
			            				<td>{{ $i }}</td>

			            				<td style="border-right: 1px solid;">
			            				<?php
                              $dateObj = \DateTime::createFromFormat('d/m/Y', $date);
											        $dateObj->modify('+1 month');
											        $date = $dateObj->format('d/m/Y');
                              echo $date;
                           ?>

                           <input type="hidden" name="date[]" value="<?php echo $date; ?>">
			            				</td>



			            				<td>

			            						<?php if ($i == $duree): ?>

			            							<?= number_format($montant_dernier, 0, 2, ' '); ?>
			            							<input type="hidden" name="cap[]" value="<?php echo $montant_dernier; ?>">
			            						<?php else: ?>

			            							<?= number_format(intval(round($capital)), 0, 2, ' '); ?>
			            							<input type="hidden" name="cap[]" value="<?php echo $capital; ?>">
			            						<?php endif ?>

			            				</td>

			            				<td>{{ number_format($interet_mensuel, 0, 2, ' ') }} BIF</td>
			            				<input type="hidden" name="int_att[]" value="<?php echo $interet_mensuel; ?>">
			            				<td>0</td>
			            				<input type="hidden" name="gar_att[]" value="0">
			            				<td style="border-right: 1px solid; font-weight: bold;">

			            					<?php if ($i == $duree): ?>

		            							{{ number_format($montant_dernier+$interet_mensuel, 0, 2, ' ') }} BIF

		            							<?php $total_dernier = $montant_dernier+$interet_mensuel; ?>
		            							<input type="hidden" name="total_att[]" value="<?php echo $total_dernier; ?>">
		            						<?php else: ?>

		            							{{ number_format($capital+$interet_mensuel, 0, 2, ' ') }} BIF



		            							<?php $total_dernier_2 = $capital+$interet_mensuel + $total_dernier_2; ?>
		            							<input type="hidden" name="total_att[]" value="<?php echo $total_dernier_2; ?>">
		            						<?php endif ?>





			            				</td>



			            				<td><?= number_format(intval($pgcd), 0, 2, ' '); ?> BIF</td>
			            				<input type="hidden" name="cap_sold[]" value="<?php echo $pgcd; ?>">
			            				<td><?= number_format(intval($interet_solde_total), 0, 2, ' '); ?> BIF</td>
			            				<input type="hidden" name="int_sold[]" value="<?php echo $interet_solde_total; ?>">
			            				<td>0</td>
			            				<input type="hidden" name="gar_sold[]" value="0">
			            				<td><?= number_format(intval($pgcd + $interet_solde_total), 0, 2, ' '); ?> BIF</td>
			            				<input type="hidden" name="tot_sold[]" value="<?php echo $pgcd + $interet_solde_total; ?>">
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

			            			<a href="<?= $_SERVER['HTTP_REFERER']; ?>" class="btn btn-danger btn-lg"> < Retour</a>
			            			<button type="submit" class="btn btn-primary btn-lg"> Enregistrer cette simulation</button>

			            	</div>

	               </div>

               </form>



							</div>



	        </div>

	    </div>

		</div>







  </div>

@endsection