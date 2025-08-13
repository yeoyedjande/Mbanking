<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Fiche de simulation</title>
</head>
<body>

	<table width="500">
		<tr>
			<td>
				<img width="150" src="data:image/png;base64,{{ base64_encode(file_get_contents( 'https://banking.hopefundburundi.com/assets/images/logo/hopeFund.png' )) }}">
			</td>
			<td align="right">
				<h3><u>Hope Fund Burundi s.a</u></h3>
			</td>
		</tr>
	</table> 
	<br>
	<table align="center" bgcolor="#cccccc" width="500" border="1" cellspacing="0" cellpadding="0">
		<tr>
			
			<td align="center" width="">
				<h4>SIMULATION DOSSIER:  {{ $v->dossier }}</h4>
			</td>
		</tr>
	</table>

	<table align="center" width="500" border="0">
		<tr>
			<td width="30%" align="center">
				<h4>Date: {{ $v->created_at->format('d/m/Y') }}</h4>
			</td>
			<td width="35%" align="center">
				<h4>Heure:  {{ $v->created_at->format('H:i') }}</h4>
			</td>
			<td width="35%" align="center">
				<h4>Agence:  {{ $v->nom_agence }}</h4>
			</td>
		</tr>
		<tr>
			<td width="30%" colspan="3">
				<h4>Agent: {{ $v->matricule }}</h4>
			</td>
			
		</tr>
	</table>

	<ul>

		<span>- Dossier: {{ $v->dossier }} </span> <br>
		<span>- Nom du Client: {{ $v->nom }} @if($v->prenom != 'NULL') {{ $v->prenom }} @endif</span> <br>

		<span>- Montant: {{ number_format($v->amount, 0, 2, ' ') }} BIF</span> <br>

		<span>- Durée du crédit: {{ $v->duree }}</span><br>

		<span>- Date de déboursement: {{ $v->date_demande }}</span><br>

		<span>- Produit de crédit:  {{ $v->name }} </span><br>


		<span>- Montant de la commission: {{ number_format($v->amount_commission, 0, 2, ' ') }} BIF</span><br>

		<span>- Montant des assurances: {{ number_format($v->amount_assurances, 0, 2, ' ') }} BIF</span><br>

		<span>- Montant de la garantie numéraire: 0 BIF</span><br>

		<span>- Montant de la garantie matérielle: 0 BIF</span><br>

		<span>- Différé: Aucun</span><br>

		<span>- Taux d'intérêt: {{ $v->taux_interet }}%</span><br>

		<span>- Périodicité de remboursement: Mensuelle</span><br>

		<span>- Mode de calcul des intérêts: Constant</span><br>

		<span>- Délais de grâce: 0 jours</span><br>

		<span>- Nombre de jours pour bloquer le crédit avant échéance: 0 jours</span><br>

</ul>
	<hr>
	<table align="center" width="520" border="1" cellspacing="0" cellpadding="0">
		
		<tr>

			<td colspan="2"></td>

			<td colspan="4" style="font-weight: bold; text-align: center;">Echéance (BIF)</td>

			<td colspan="4" style="font-weight: bold; text-align: center;">Solde (BIF)</td>

		</tr>

		<tr style="">

			<td align="center">N°</td>

			<td align="center">Date</td>

			<td align="center">Capital</td>

			<td align="center">Intérêts</td>

			<td align="center">Garantie</td>

			<td align="center">Total</td>



			<td align="center">Capital</td>

			<td align="center">Intérêts</td>

			<td align="center">Garantie</td>

			<td align="center">Total</td>

		</tr>


		<?php 

			$total_cap_att = 0;
			$total_int_att = 0;
			$total_gar_att = 0;
			$total_cap_sold = 0;
			$total_int_sold = 0;
			$total_gar_sold = 0;
			$grd_total_att = 0;
			$grd_total_sold = 0;

			$echeances = DB::table('dossier_simulations')->where('simulation_id', $v->id)->get();
			foreach ($echeances as $key => $value) {

				$total_cap_att = $total_cap_att + $value->cap_att;
				$total_int_att = $total_int_att + $value->int_att;
				$total_gar_att = $total_gar_att + $value->gar_att;
				$total_cap_sold = $total_cap_sold + $value->cap_sold;
				$total_int_sold = $total_int_sold + $value->int_sold;
				$total_gar_sold = $total_gar_sold + $value->gar_sold;
				$grd_total_att = $grd_total_att + $value->total_att;
				$grd_total_sold = $grd_total_sold + $value->total_sold;
		?>

			<tr>
				<td align="center">{{ $value->numero }}</td>
				<td align="center">{{ $value->date }}</td>
				<td align="center">{{ number_format($value->cap_att, 0, 2, ' ') }}</td>
				<td align="center">{{ number_format($value->int_att, 0, 2, ' ') }}</td>
				<td align="center">{{ number_format($value->gar_att, 0, 2, ' ') }}</td>
				<td align="center">{{ number_format($value->total_att, 0, 2, ' ') }}</td>
				<td align="center">{{ number_format($value->cap_sold, 0, 2, ' ') }}</td>
				<td align="center">{{ number_format($value->int_sold, 0, 2, ' ') }}</td>
				<td align="center">{{ number_format($value->gar_sold, 0, 2, ' ') }}</td>
				<td align="center">{{ number_format($value->total_sold, 0, 2, ' ') }}</td>
			</tr>

		<?php } ?>

		<tr>
			<td align="center" colspan="2">Totaux (BIF)</td>
			<td align="center"><b>{{ number_format($total_cap_att, 0, 2, ' ') }}</b></td>
			<td align="center"><b>{{ number_format($total_int_att, 0, 2, ' ') }}</b></td>
			<td align="center"><b>{{ number_format($total_gar_att, 0, 2, ' ') }}</b></td>
			<td align="center"><b>{{ number_format($grd_total_att, 0, 2, ' ') }}</b></td>
			<td align="center"><b>{{ number_format($total_cap_sold, 0, 2, ' ') }}</b></td>
			<td align="center"><b>{{ number_format($total_int_sold, 0, 2, ' ') }}</b></td>
			<td align="center"><b>{{ number_format($total_gar_sold, 0, 2, ' ') }}</b></td>
			<td align="center"><b>{{ number_format($grd_total_sold, 0, 2, ' ') }}</b></td>
		</tr>
	</table>

	

</body>
</html>