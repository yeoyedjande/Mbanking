@extends('layouts.app_client')

@section('title', 'Relevé de Compte')

@section('content')
    <div class="container">
        <h1>Relevé de Compte</h1>
        
        <!-- Ajoutez ici le contenu de votre page -->
        <p>Consultez ci-dessous votre relevé de compte pour les transactions récentes.</p>

        	<div class="card col-12">
        	
	        <!-- Exemple de tableau de relevé de compte -->
	        <table class="table table-bordered mb-0">
	            <thead>
	                <tr>
	                    <th>Date</th>
	                    <th>Description</th>
	                    <th>Montant</th>
	                    <!-- Ajoutez d'autres colonnes selon vos besoins -->
	                </tr>
	            </thead>
	            <tbody>
	                <!-- Ajoutez ici les lignes de relevé de compte dynamiquement -->
	                <tr>
	                    <td>2023-01-01</td>
	                    <td>Achat en ligne</td>
	                    <td>- $50.00</td>
	                </tr>
	                <tr>
	                    <td>2023-01-05</td>
	                    <td>Dépôt en espèces</td>
	                    <td>+ $100.00</td>
	                </tr>
	                <!-- Ajoutez d'autres lignes selon vos transactions -->
	            </tbody>
	        </table>
    	</div>
    </div>

@endsection
