<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Recu chequiers</title>
</head>
<body>

	<img src="https://hopefundburundi.com/img/logo/logo_new.png">
	<table align="center" bgcolor="#cccccc" width="300" border="1" cellspacing="0" cellpadding="0">
		<tr>
			
			<td align="center" width="">
				<h4>COMMANDE DE CHEQUIERS <br>#{{ $v->reference }} </h4>
			</td>
		</tr>
	</table>

	<table align="center" width="300" border="0">
		<tr>
			<td width="30%" align="center">
				<h4>Date: {{ $v->date_order }}</h4>
			</td>
			<td width="35%" align="center">
				<h4>Heure:  {{ $v->heure_order }}</h4>
			</td>
			<td width="35%" align="center">
				<h4>Agence:  {{ $v->nom_agence }}</h4>
			</td>
		</tr>
		<tr>
			<td width="30%" colspan="3">
				<h4>Guichetier: {{ $v->matricule }}</h4>
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
				TITULAIRE:
			</td>
			<td width="" align="">
				{{ $v->nom }} @if ($v->prenom != 'NULL')

                  {{ $v->prenom }}

                @endif
			</td>
		</tr>
		<tr>
			<td width="" align="">
				QUANTITE DE CHEQUIERS:
			</td>
			<td width="" align="">
				{{ $v->qte }}
			</td>
		</tr>
		
		<tr>
			<td width="" align="">
				MONTANT UNITAIRE:
			</td>
			<td width="" align="">
				<b>{{ number_format($v->montant, 0, 2, ' ') }} BIF</b>
			</td>
		</tr>
		<tr>
			<td width="" align="">
				MONTANT TOTAL:
			</td>
			<td width="" align="">
				<b>{{ number_format($v->montant_total, 0, 2, ' ') }} BIF</b>
			</td>
		</tr>
		
		<tr>
			<td width="" align="">
				TYPE CARNET CHEQUE:
			</td>
			<td width="" align="" style="text-transform: uppercase;">
				<b>{{ $v->type }}</b>
			</td>
		</tr>

	</table>

	<br><br><br>
	<table align="center" width="300" border="0">
		<tr>
			<td width="35%" align="center">
				<h4>Signature Caissier</h4>
			</td>
			<td width="30%" align="center">
				&nbsp;
			</td>
			<td width="35%" align="center">
				<h4>Signature du demandeur</h4>
			</td>
		</tr>
	</table>

</body>
</html>