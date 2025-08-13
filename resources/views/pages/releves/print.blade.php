<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Relevé de compte</title>
</head>
<body>

	<table align="center" bgcolor="#cccccc" width="750" border="1" cellspacing="0" cellpadding="0">
		<tr>
			
			<td align="center" width="">
				<h4>RELEVE DE COMPTE DE #{{ $number_account }} </h4>
			</td>
		</tr>
	</table>

	<table align="center" width="750" border="0">
		<tr>
			<td width="250" align="">
				<h4>Période: <?= date('d/m/Y'); ?></h4>
			</td>
			<td width="200" align="center">
				<h4>Solde du compte: <span style="color: green;">{{ number_format($client->solde, 0, 2, ' ') }} BIF</span> </h4>
			</td>
			<td width="300" align="center">
				<h4>Client:  {{ $client->nom }} @if ($client->prenom != 'NULL')

                  {{ $client->prenom }}

                @endif</h4>
			</td>
		</tr>
		
	</table>

	<table align="center" width="750" border="1" cellspacing="0" cellpadding="0">
		

		<tr bgcolor="#cccccc;">
			
			<td width="" align="center">
				DATE DE VALEUR
			</td>
			<td width="" align="center">
				REFERENCE
			</td>
			<td width="" align="center">
				TYPE OPERATION
			</td>
			<td width="" align="center">
				DONNEUR ORDRE
			</td>
			<td width="" align="center">
				TIREUR
			</td>
			<td width="" align="center">
				COMMUNICATION
			</td>
			<td width="" align="center">
				DEPOTS
			</td>
			<td width="" align="center">
				RETRAITS
			</td>
			<td width="" align="center">
				SOLDE
			</td>

		</tr>
		@php $i = 1; @endphp

		@foreach( $operations as $op )
		<tr>
			
			<td width="" align="center">
				{{ $op->date_op }}
			</td>
			
			<td width="" align="center">
				{{ $op->ref }}
			</td>
			<td width="" align="center">
				{{ $op->name }}
			</td>
			<td width="" align="center">
				&nbsp;
			</td>
			<td width="" align="center">
				&nbsp;
			</td>
			<td width="" align="center">
				{{ $op->motif_versement }}
			</td>

			<td width="" align="center">

				@if( $op->type_operation_id == 3)
				{{ number_format($op->montant + $op->frais, 0, 2, ' ') }} BIF
				@endif


			</td>
			<td width="" align="center">
				@if( $op->type_operation_id == 2)
				{{ number_format($op->montant + $op->frais, 0, 2, ' ') }} BIF
				@endif
			</td>

			<td width="" align="center">

				@if( $op->type_operation_id == 2 )
					<b>{{ number_format($op->montant + $op->frais, 0, 2, ' ') }} BIF</b>
				@endif

			</td>

		</tr>
		@endforeach
		
		<tr height="100">
			<td colspan="8" align="center"><b>MONTANT TOTAL OPERATION</b></td>
			<td align="center"><b>1 00 000 BIF</b></td>
		</tr>
	</table>

	<br><br><br>
	<table align="center" width="750" border="0">
		<tr>
			<td width="300" align="">
				<h4>Signature Caissier</h4>
			</td>
			<td width="150" align="">
				&nbsp;
			</td>
			<td width="300" align="right">
				<h4>Signature du client</h4>
			</td>
		</tr>
	</table>

</body>
</html>