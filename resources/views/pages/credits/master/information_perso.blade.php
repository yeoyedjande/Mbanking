
  	<div class="row">
     	
	    <div class="col-md-12 grid-margin stretch-card">
	      
	      <div class="card">
	      	
	        <div class="card-body">
	          <h4 class="card-title mb-4">
	          	Informations Personnelles <br>

	          	Client: {{ $demande->nom }} @if($demande->prenom != 'NULL') {{ $demande->prenom }} @endif</h4>
               

            	<form class="forms-sample" action="{{ route('complete-demandes-step-2', $demande->id) }}" method="POST">

            		{{ csrf_field() }}
              	<div class="row">

		            	<div class="col-md-4">
							<div class="form-group">
				              <label for="num_account">Numéro de compte * </label>
				              <input type="text" value="{{ $demande->client_id }}" class="form-control form-control-lg" id="num_account" name="num_account" readonly required>
				            </div>
		            	</div>

		            	<div class="col-md-4">
							<div class="form-group">
				              <label for="nom">Nom du client * </label>
				              <input type="text" value="{{ $demande->nom }}"  class="form-control form-control-lg" id="nom" name="nom" required>
				            </div>
		            	</div>

		            	<div class="col-md-4">
							<div class="form-group">
				              <label for="nom">Prenom du client * </label>
				              <input type="text" value="{{ $demande->prenom }}"  class="form-control form-control-lg" id="prenom" name="prenom" required>
				            </div>
		            	</div>

		            	<div class="col-md-4">
							<div class="form-group">
				              <label for="date_nais">Date de naissance * </label>
				              <input type="date" id="date_nais" min="0" class="form-control form-control-lg" name="date_nais" required>
				            </div>
		            	</div> 

		            	<div class="col-md-4">
										<div class="form-group">
				              <label for="lieu_nais">Lieu de naissance * </label>
				              <input type="text" id="lieu_nais" min="0" class="form-control form-control-lg" name="lieu_nais" required>
				            </div>
		            	</div>

		            	<div class="col-md-4">
							<div class="form-group">
				              <label for="sexe">Sexe </label>
				              <select class="form-control  form-control-lg" id="sexe" name="sexe" required>
				              	<option>Selectionner</option>
				              	<option value="M">Masculin</option>
				              	<option value="F">Feminin</option>
				              </select>
				            </div>
		            	</div>
		            	
		            	<div class="col-md-6">
							<div class="form-group">
				              <label for="nom_pere">Nom et Prenom du pere * </label>
				              <input type="text" id="nom_pere" class="form-control form-control-lg" name="nom_pere" required>
				            </div>
		            	</div>

		            	<div class="col-md-6">
							<div class="form-group">
				              <label for="nom_mere">Nom et Prenom de la mere * </label>
				              <input type="text" id="nom_mere" class="form-control form-control-lg" name="nom_mere" required>
				            </div>
		            	</div>

		            	<div class="col-md-3">
							<div class="form-group">
				              <label for="nature">Nature * </label>
				              <select class="form-control form-control-lg" name="nature" required>
				              	<option>Selectionner</option>
				              	<option value="cni">CNI</option>
				              	<option value="attestation">Attestation d'identité</option>
				              	<option value="passport">Passport</option>
				              </select>
				            </div>
		            	</div>

		            	<div class="col-md-3">
							<div class="form-group">
				              <label for="num_piece">Numéro de la pièce * </label>
				              <input type="text" id="num_piece" class="form-control form-control-lg" name="num_piece" required>
				            </div>
		            	</div>

		            	<div class="col-md-3">
							<div class="form-group">
				              <label for="residence">Résidence * </label>
				              <input type="text" id="residence" class="form-control form-control-lg" name="residence" required>
				            </div> 
		            	</div>

		            	<div class="col-md-3">
							<div class="form-group">
				              <label for="adresse">Depuis combien de temps êtes-vous à cette adresse ? </label>
				              <input type="text" id="adresse" class="form-control form-control-lg" name="adresse" required>
				            </div>
		            	</div>

						<div class="col-md-12">
							<div class="form-group">
				              <button type="submit" class="btn btn-primary btn-lg me-2">   Suivant&nbsp;&nbsp;<i class="mdi mdi-arrow-right"></i></button>
				            </div>
		            	</div>
					</div>

				</form>
               
	        </div>
	      </div>
	    </div>
          
		</div>
