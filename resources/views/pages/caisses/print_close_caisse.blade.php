<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Recu caisse</title>
</head>
<body>

	<table align="center" width="700" border="1" cellspacing="0" cellpadding="0">
		<tr>
			<td align="center">
				<h2>RECAPITULATIF CAISSE #{{ $mvt->name }} </h2>
			</td>
		</tr>
	</table>

	<table align="center" width="700" border="0">
		<tr>
			<td width="30%" align="center">
				<h4>Date: {{ $mvt->date_mvmt }}</h4>
			</td>
			<td width="35%" align="center">
				<h4>Heure d'ouverture:  {{ $mvt->heure_mvmt }}</h4>
			</td>
			<td width="35%" align="center">
				<h4>Heure de fermeture:  {{ $mvt->heure_mvmt_fermeture }}</h4>
			</td>
		</tr>
	</table>

	<br>
	<table align="center" width="700" border="0">
		<tr>
			<td width="30%" align="center">
				<h4>Caissier: #{{ $mvt->matricule }}</h4>
			</td>
			<td width="35%" align="center">
				&nbsp;
			</td>
			<td width="35%" align="center">
				<h4>Agence: {{ $mvt->nom_agence }}</h4>
			</td>
		</tr>
	</table>

	<br><br>
	<table align="center" width="700" border="1" cellspacing="0" cellpadding="0">
		<tr>
		  <td align="center"><b>Montant à l'ouverture</b></td>
  		<td align="center"><b>Total retrait</b></td>
      <td align="center"><b>Total versement</b></td>
      <td align="center"><b>Total virement</b></td>
      <td align="center"><b>Montant en cash à la fermeture</b></td>
      <td align="center"><b>Solde système</b></td>
      <td align="center"><b>Ajustement</b></td>
          
		</tr>

		<?php 
          $versements = DB::table('operation_mouvements')->join('operations', 'operations.id', '=', 'operation_mouvements.operation_id')
            ->join('users', 'users.id', '=', 'operations.user_id')
            ->Where('operation_mouvements.mouvement_id', $mvt->id)
            ->Where('operations.type_operation_id', 3)
            ->get();

            $total_versement = 0;

            foreach ($versements as $v) {
              $total_versement = $total_versement + $v->montant;
            }

            $retraits = DB::table('operation_mouvements')->join('operations', 'operations.id', '=', 'operation_mouvements.operation_id')
            ->join('users', 'users.id', '=', 'operations.user_id')
            ->Where('operation_mouvements.mouvement_id', $mvt->id)
            ->Where('operations.type_operation_id', 2)
            ->get();

            $total_retrait = 0;

            foreach ($retraits as $r) {
              $total_retrait = $total_retrait + $r->montant;
            }

         ?>

		<tr>
			<td align="center" bgcolor="#cccccc">{{ number_format($mvt->solde_initial, 0, 2, ' ') }} BIF</td>
			<td align="center" bgcolor="#cccccc">{{ number_format($total_retrait, 0, 2, ' ') }} BIF</td>
			<td align="center" bgcolor="#cccccc">{{ number_format($total_versement, 0, 2, ' ') }} BIF</td>
			<td align="center" bgcolor="#cccccc">0 BIF</td>
			<td align="center" bgcolor="#cccccc">{{ number_format($mvt->solde_fermeture, 0, 2, ' ') }} BIF</td>
			<td align="center" bgcolor="#cccccc">{{ number_format($mvt->solde_final, 0, 2, ' ') }} BIF</td>
			<td align="center" bgcolor="#cccccc">{{ number_format($mvt->montant_reajustement, 0, 2, ' ') }} BIF</td>
		</tr>
			
			
	</table>

	

	<table style="margin-top: 50px;" align="center" width="700" border="0">
		<tr>
			<td width="35%" align="center">
				<h4>Signature Caissier</h4>
			</td>
			<td width="30%" align="center">
				&nbsp;
			</td>
			<td width="35%" align="center">
				<h4>Signature Caissier Principal</h4>
			</td>
		</tr>
	</table>


</body>
</html>