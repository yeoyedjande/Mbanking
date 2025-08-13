<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Recu retrait caisse</title>
</head>
<body>

	<table align="center" bgcolor="#cccccc" width="300" border="1" cellspacing="0" cellpadding="0">
		<tr>
			
			<td align="center" width="">
				<h4>RETRAIT <br>#{{ $v->ref }} </h4>
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
				MONTANT RETIRÉ:
			</td>
			<td width="" align="">
				<b>{{ number_format($v->montant, 0, 2, ' ') }} BIF</b>
			</td>
		</tr>
		
		<tr>
			<td width="" align="">
				FRAIS:
			</td>
			<td width="" align="">
				{{ $v->frais }} BIF
			</td>
		</tr>

		<tr>
			<td width="" align="">
				MONTANT TOTAL DEBITÉ:
			</td>
			<td width="" align="">
				<b>{{ number_format($v->montant + $v->frais, 0, 2, ' ') }} BIF</b>
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
				<h4>Signature Client</h4>
			</td>
		</tr>
	</table>

</body>
</html>