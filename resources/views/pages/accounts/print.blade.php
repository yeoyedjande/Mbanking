<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Fiche de l'ouverture du compte</title>
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
	</table> <br>
	
	<table align="center" bgcolor="#cccccc" width="500" border="1" cellspacing="0" cellpadding="0">
		<tr>
			
			<td align="center" width="">
				<h4>OUVERTURE DE COMPTE : {{ strtoupper($i->name) }} </h4>
			</td>
		</tr>
	</table>

	<table align="center" width="500" border="0">
		<tr>
			<td width="30%" align="left">
				<h4>Date: {{$i->date_ouverture_compte}}</h4>
			</td>
			<td width="35%" align="center">
				<h4>Heure: {{ $i->created_at->format('H:i:s') }}</h4>
			</td>
			<td width="35%" align="right">
				<h4>Agence: {{$i->nom_agence}}</h4>
			</td>
		</tr>

		<tr>
			<td width="30%" colspan="3" class="mb-0">
				<h4>Agent: {{$i->matricule}}</h4>
			</td>
			
		</tr>

	</table>

	<table align="center" width="500" border="0">
		<tr>
			
		<tr>
			<td width="" align="">
				<small style="font-size: 10px;">N° COMPTE:</small>
			</td>
			<td width="" align="">
				<small style="font-size: 10px;">{{$i->number_account}}</small>
			</td>
		</tr>

		<tr>
		    <td width="" align="">
		        <small style="font-size: 10px;">N° CLIENT:</small>
		    </td>
		    <td width="" align="">
		        <small style="font-size: 10px;">{{ $i->code_client }}</small>
		    </td>
		</tr>

		<tr>
		    <td width="" align="">
		        <small style="font-size: 10px;">TYPE DE COMPTE:</small>
		    </td>
		    <td width="" align="">
		        <small style="font-size: 10px;">{{ $i->type_compte }}</small>
		    </td>
		</tr>

		<tr>
		    <td width="" align="">
		        <small style="font-size: 10px;">ANCIEN N° CLIENT:</small>
		    </td>
		    <td width="" align="">
		        <small style="font-size: 10px;">{{ $i->ancien_code_client }}</small>
		    </td>
		</tr>

		<tr>
		    <td width="" align="">
		        <small style="font-size: 10px;">DATE D'OUVERTURE DE COMPTE:</small>
		    </td>
		    <td width="" align="">
		        <small style="font-size: 10px;">{{ $i->date_ouverture_compte }}</small>
		    </td>
		</tr>

		<tr>
		    <td width="" align="">
		        <small style="font-size: 10px;">LANGUE DE CORRESPONDANCE:</small>
		    </td>
		    <td width="" align="">
		        <small style="font-size: 10px;">{{ $i->lang }}</small>
		    </td>
		</tr>


		@if($i->id_juridique == 1)

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">MATRICULE:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->matricule }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		           <small style="font-size: 10px;">NOM ET PRÉNOM(S):</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->nom }}</small> <small style="font-size: 10px;">{{ $i->prenom }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">DATE DE NAISSANCE:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->date_naissance }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">LIEU DE NAISSANCE:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->lieu_naissance }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">PAYS DE NATIONALITÉ:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->pays_nationalite }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">PAYS DE NAISSANCE:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->pays_naissance }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">SEXE:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->sexe == 1 ? 'MASCULIN' : 'FÉMININ' }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">TYPE DE PIÈCE D'IDENTITÉ:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->type_piece }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">NUMÉRO DE PIÈCE D'IDENTITÉ:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->numero_cni }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">ÉTAT CIVIL:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->etat_civil }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">NOMBRE D'ENFANT:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->nmbre_enfant }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">EMPLOYEUR:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->employeur == 'non' ? 'NON' : 'OUI' }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">FONCTION DE L'EMPLOYEUR:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->fonction_employeur }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">NOM ET PRÉNOMS DU SIGNATAIRE 1:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->nom_prenom_signataire1 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">CNI SIGNATAIRE 1:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->cni_signataire1 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">TÉLÉPHONE SIGNATAIRE 1:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->telephone_signataire1 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">NOM ET PRÉNOMS DU SIGNATAIRE 2:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->nom_prenom_signataire2 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">CNI SIGNATAIRE 2:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->cni_signataire2 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">TÉLÉPHONE SIGNATAIRE 2:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->telephone_signataire2 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">NOM ET PRÉNOMS DU SIGNATAIRE 3:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->nom_prenom_signataire3 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">CNI SIGNATAIRE 3:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->cni_signataire3 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">TÉLÉPHONE SIGNATAIRE 3:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->telephone_signataire3 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">POUVOIR DES SIGNATAIRES:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->pouvoir_signataires }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">NOM DE L'HÉRITIER 1:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->nom_heritier1 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">NOM DE L'HÉRITIER 2:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->nom_heritier2 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">NOM DE L'HÉRITIER3:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->nom_heritier3 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">NOM DU MANDATAIRE:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->nom_mandataire }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">CNI DU MANDATAIRE:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->cni_mandataire }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">TÉLÉPHONE DU MANDATAIRE:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->telephone_mandataire }}</small>
		        </td>
		    </tr>

		@endif


		<tr>
		    <td width="" align="">
		        <small style="font-size: 10px;">ADRESSE:</small>
		    </td>
		    <td width="" align="">
		        <small style="font-size: 10px;">{{ $i->adresse }}</small>
		    </td>
		</tr>

		<tr>
		    <td width="" align="">
		        <small style="font-size: 10px;">CODE POSTAL:</small>
		    </td>
		    <td width="" align="">
		        <small style="font-size: 10px;">{{ $i->code_postal }}</small>
		    </td>
		</tr>

		<tr>
		    <td width="" align="">
		        <small style="font-size: 10px;">VILLE:</small>
		    </td>
		    <td width="" align="">
		        <small style="font-size: 10px;">{{ $i->ville }}</small>
		    </td>
		</tr>

		<tr>
		    <td width="" align="">
		        <small style="font-size: 10px;">PAYS:</small>
		    </td>
		    <td width="" align="">
		        <small style="font-size: 10px;">{{ $i->pays }}</small>
		    </td>
		</tr>

		<tr>
		    <td width="" align="">
		        <small style="font-size: 10px;">N° DE TÉLÉPHONE:</small>
		    </td>
		    <td width="" align="">
		        <small style="font-size: 10px;">{{ $i->telephone }}</small>
		    </td>
		</tr>

		<tr>
		    <td width="" align="">
		        <small style="font-size: 10px;">E-MAIL:</small>
		    </td>
		    <td width="" align="">
		        <small style="font-size: 10px;">{{ $i->email }}</small>
		    </td>
		</tr>

		@if($i->id_juridique == 2)
		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">NOM DE L'ENTREPRISE:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ strtoupper($i->nom_entreprise) }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">RAISON SOCIALE:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->raison_social }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">ABRÉVIATIONS:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->abreviation }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">LOCALISATION 1:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->localisation_1 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">LOCALISATION 2:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->localisation_2 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">ZONE:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->zone }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">COMMENTAIRE SUR LE CLIENT:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->commentaire_client }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">CATÉGORIE DE PM:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->categorie_pm }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">NUMÉRO CARTE BANCAIRE:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->numero_carte_bancaire }}</small>
		        </td>
		    </tr>

		@endif

		@if($i->id_juridique == 3)

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">NOM DU GROUPE:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->nom_groupe }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">RESPONSABLE DU GROUPE:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->responsable_groupe }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		           <small style="font-size: 10px;">NOMBRE D'IMF:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->nombre_imf }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		          <small style="font-size: 10px;">SECTEUR D'ACTIVITÉ:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->secteur_activite }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		           <small style="font-size: 10px;">NOMBRE DE BANQUES:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->nombre_banques }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		          <small style="font-size: 10px;">PARTENAIRES:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->partenaires }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		          <small style="font-size: 10px;">GESTIONNAIRE:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->gestionnaire }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		          <small style="font-size: 10px;">MEMBRE 1:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->membre1 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		          <small style="font-size: 10px;">MEMBRE 2:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->membre2 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		          <small style="font-size: 10px;">MEMBRE 3:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->membre3 }}</small>
		        </td>
		    </tr>

		    <tr>
		        <td width="" align="">
		            <small style="font-size: 10px;">NUMÉRO CARTE BANCAIRE:</small>
		        </td>
		        <td width="" align="">
		            <small style="font-size: 10px;">{{ $i->numero_carte_bancaire }}</small>
		        </td>
		    </tr>

		@endif


		@if($i->id_juridique == 4)

	    <tr>
	        <td width="" align="">
	           <small style="font-size: 10px;">NOM DU GROUPE:</small>
	        </td>
	        <td width="" align="">
	            <small style="font-size: 10px;">{{ $i->nom_groupe }}</small>
	        </td>
	    </tr>

	    <tr>
	        <td width="" align="">
	            <small style="font-size: 10px;">NOMBRE DE MEMBRES DU GROUPE:</small>
	        </td>
	        <td width="" align="">
	            <small style="font-size: 10px;">{{ $i->nombre_membres }}</small>
	        </td>
	    </tr>

	    <tr>
	        <td width="" align="">
	            <small style="font-size: 10px;">NOMBRE D'HOMMES DU GROUPE:</small>
	        </td>
	        <td width="" align="">
	            <small style="font-size: 10px;">{{ $i->nombre_homme_group }}</small>
	        </td>
	    </tr>

	    <tr>
	        <td width="" align="">
	            <small style="font-size: 10px;">NOMBRE DE FEMMES DU GROUPE:</small>
	        </td>
	        <td width="" align="">
	            <small style="font-size: 10px;">{{ $i->nombre_femme_group }}</small>
	        </td>
	    </tr>

	    <tr>
	        <td width="" align="">
	            <small style="font-size: 10px;">SECTEUR D'ACTIVITÉ:</small>
	        </td>
	        <td width="" align="">
	            <small style="font-size: 10px;">{{ $i->secteur_activite }}</small>
	        </td>
	    </tr>

	    <tr>
	        <td width="" align="">
	            <small style="font-size: 10px;">NOMBRE DE BANQUES:</small>
	        </td>
	        <td width="" align="">
	            <small style="font-size: 10px;">{{ $i->nombre_banques }}</small>
	        </td>
	    </tr>

	    <tr>
	        <td width="" align="">
	            <small style="font-size: 10px;">DATE D'AGRÉMENT DU GROUPE INFORMEL:</small>
	        </td>
	        <td width="" align="">
	            <small style="font-size: 10px;">{{ $i->date_agrement }}</small>
	        </td>
	    </tr>

	    <tr>
	        <td width="" align="">
	            <small style="font-size: 10px;">NUMÉRO CARTE BANCAIRE:</small>
	        </td>
	        <td width="" align="">
	            <small style="font-size: 10px;">{{ $i->numero_carte_bancaire }}</small>
	        </td>
	    </tr>

	@endif

	<tr>
	    <td width="" align="">
	        <small style="font-size: 10px;">QUALITÉ:</small>
	    </td>
	    <td width="" align="">
	        <small style="font-size: 10px;">{{ $i->qualite }}</small>
	    </td>
	</tr>

	<tr>
	    <td width="" align="">
	        <small style="font-size: 10px;">NIVEAU AGENCE:</small>
	    </td>
	    <td width="" align="">
	        <small style="font-size: 10px;">{{ $i->niveau_agence }}</small>
	    </td>
	</tr>

	<tr>
	    <td width="" align="">
	        <small style="font-size: 10px;">NIVEAU GUICHET:</small>
	    </td>
	    <td width="" align="">
	        <small style="font-size: 10px;">{{ $i->niveau_guichet }}</small>
	    </td>
	</tr>

	<tr>
	    <td width="" align="">
	        <small style="font-size: 10px;">VERSEMENT INITIAL:</small>
	    </td>
	    <td width="" align="">
	        <small style="font-size: 10px;">{{ $i->versement_initial }}</small>
	    </td>
	</tr>

	<tr>
	    <td width="" align="">
	       <small style="font-size: 10px;"> MONTANT ÉPARGNE:</small>
	    </td>
	    <td width="" align="">
	        <small style="font-size: 10px;">{{ $i->montant_epargne }}</small>
	    </td>
	</tr>

	<tr>
	    <td width="" align="">
	        <small style="font-size: 10px;">TOTAL VERSÉ:</small>
	    </td>
	    <td width="" align="">
	        <small style="font-size: 10px;">{{ $i->total_verse }}</small>
	    </td>
	</tr>

	<tr>
	    <td width="" align="">
	        <small style="font-size: 10px;">DATE DE CLÔTURE DE COMPTE:</small>
	    </td>
	    <td width="" align="">
	        <small style="font-size: 10px;">{{ $i->date_cloture_compte }}</small>
	    </td>
	</tr>

	<tr>
	    <td width="" align="">
	       <small style="font-size: 10px;"> VERSEMENT FINAL:</small>
	    </td>
	    <td width="" align="">
	        <small style="font-size: 10px;">{{ $i->versement_final }}</small>
	    </td>
	</tr>



	</table>

	<!-- <table align="center" width="500" height="10" border="0">
		<tr>
			<td width="35%" align="center">
				<h4>Signature Agent</h4>
			</td>
			<td width="30%" align="center">
				&nbsp;
			</td>
			<td width="35%" align="center">
				<h4>Signature Client</h4><br>
					
			</td>
		</tr>
	</table> -->

</body>
</html>