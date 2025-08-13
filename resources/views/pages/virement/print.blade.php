<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Recu virement caisse</title>
</head>
<body>

	<table width="300">
		<tr>
			<td>
				<img width="150" src="data:image/png;base64,{{ base64_encode(file_get_contents( 'https://banking.hopefundburundi.com/assets/images/logo/hopeFund.png' )) }}">
			</td>
			<td align="center">
				<h3><u>Hope Fund Burundi s.a</u></h3>
			</td>
		</tr>
	</table> <br>
	
	<table align="center" bgcolor="#cccccc" width="300" border="1" cellspacing="0" cellpadding="0">
		<tr>
			
			<td align="center" width="">
				<h4>VIREMENT ESPECES <br>#{{ $v->ref }} </h4>
			</td>
		</tr>
	</table>

	<table align="center" width="300" border="0">
		<tr>
			<td width="30%" align="center">
				<h4>Date: {{ $v->date_op }}</h4>
			</td>
			<td width="35%" align="center">
				<h4>Heure:  {{ $v->heure_op }}</h4>
			</td>
			<td width="35%" align="center">
				<h4>Agence:  {{ $v->nom_agence }}</h4>
			</td>
		</tr>

		<tr>
			<td width="30%" colspan="3">
				<h4>Comptable: {{ $v->matricule }}</h4>
			</td>
			
		</tr>

	</table>

	<table align="center" width="" border="0">
		<tr>
			<td width="" align="">
				RÉFÉRENCE:
			</td>
			<td width="" align="">
				{{ $v->ref }}
			</td>
		</tr>

		<tr>
			<td width="" align="">
				N° COMPTE DEBITÉ:
			</td>
			<td width="" align="">
				{{ $v->account_id }}
			</td>
		</tr>
		<tr>
			<td width="" align="">
				NOM DU DEBITEUR:
			</td>
			<td width="" align="">
				{{ $v->nom }} {{ $v->prenom }}
			</td>
		</tr>
		
		<tr>
			<td width="" align="">
				N° COMPTE CREDITÉ:
			</td>
			<td width="" align="">
				{{ $v->account_dest }}
			</td>
		</tr>
		<tr>
			<td width="" align="">
				NOM DU CREDITEUR:
			</td>
			<td width="" align="">
				<?php 
					$nom_crediteur = DB::table('operations')->join('accounts', 'accounts.number_account', '=', 'operations.account_dest')
					->join('clients', 'clients.id', '=', 'accounts.client_id')
					->Where('accounts.number_account', $v->account_dest)
					->first();
				?>
				{{ $nom_crediteur->nom }} {{ $nom_crediteur->prenom }}

			</td>
		</tr>
		<tr>
			<td width="" align="">
				MONTANT VIRÉ:
			</td>
			<td width="" align="">
				<b>{{ number_format($v->montant, 0, 2, ' ') }} BIF</b>
			</td>
		</tr>

		<tr>
			<td width="" align="">
				{{ $v->nom_frais }}
			</td>
			<td width="" align="">
				<b>{{ number_format($v->frais_montant, 0, 2, ' ') }} BIF</b>
			</td>
		</tr>
		
		<tr>
			<td width="" align="">
				MONTANT TOTAL DEBITE:
			</td>
			<td width="" align="">
				<b>{{ number_format($v->montant+$v->frais_montant, 0, 2, ' ') }} BIF</b>
			</td>
		</tr>

		<tr>
			<td width="" align="">
				MOTIF DU VIREMENT:
			</td>
			<td width="" align="">
				<b>{{ $v->motif_virement }} </b>
			</td>
		</tr>

	</table>

	<br><br><br>
	<table align="center" width="300" border="0">
		<tr>
			<td width="35%" align="center">
				<h4>Signature Comptable</h4>
			</td>
			<td width="30%" align="center">
				&nbsp;
			</td>
			<td width="35%" align="center">
				<h4>Signature Client</h4>
			</td>
		</tr>
	</table>

</body>
</html>