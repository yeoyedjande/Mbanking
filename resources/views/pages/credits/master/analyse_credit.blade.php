<div class="row">
     	
	    <div class="col-md-12 grid-margin stretch-card">
	      
	      <div class="card">
	      	<div class="card-header">
	      		<a href="#" class="btn btn-primary btn-lg pull-right"><i class="mdi mdi-users"></i> Modifier informations personnelles client</a>
	      	</div>
	        <div class="card-body">
	          <h4 class="card-title mb-4">Client: {{ $demande->nom }} @if($demande->prenom != 'NULL' ) {{ $demande->prenom }} @endif</h4>
               

            	<form class="forms-sample" action="{{ route('pret-simulation') }}" method="POST">

            		{{ csrf_field() }}
              	<div class="row">

		            	<div class="col-md-6">
										<div class="form-group">
				              <label for="num_account">Numéro de compte * </label>
				              <input type="text" value="{{ $demande->client_id }}" class="form-control form-control-lg" id="num_account" name="num_account" readonly required>
				            </div>
		            	</div>

		            	<div class="col-md-6">
										<div class="form-group">
				              <label for="duree_credit">Durée du crédit * </label>
				              <select id="duree_credit" class="form-control form-control-lg" name="duree_credit" style="padding-top: 10px;" required>
				              		<option value="">Selectionner</option>
				              		<option data-taux = "0.0045" value="3">3 mois</option>
				              		<option data-taux = "0.0045" value="6">6 mois</option>
				              		@foreach( $type_credits as $t )
				              		<option data-taux = "{{ $t->taux }}" value="{{ $t->echeance }}">{{ $t->echeance }} mois</option>
				              		@endforeach
				              </select>
				            </div>
		            	</div>

		            	<div class="col-md-6">
										<div class="form-group">
				              <label for="date_deboursement">Date de déboursement * </label>
				              <input type="date"  class="form-control form-control-lg" id="date_deboursement" name="date_deboursement" required>
				            </div>
		            	</div>

		            	<div class="col-md-6">
										<div class="form-group">
				              <label for="amount_frais">Montant des frais de dossier * </label>
				              <input type="amount_frais" min="1000" style="color: red; font-weight: bold;" class="form-control form-control-lg" id="amount_frais" name="amount_frais" required>
				            </div>
		            	</div>
		            	<div class="col-md-6">
										<div class="form-group">
				              <label for="periode">Période de remboursement * </label>
				              <select class="form-control form-control-lg" name="periode" style="padding-top: 10px;" required>
				              		<option value="">Selectionner</option>
				              		<option value="jour">Par Jour</option>
				              		<option value="semaine">Par Semaine</option>
				              		<option value="mois">Par Mois</option>
				              </select>
				            </div>
		            	</div>
		            	<div class="col-md-6">
										<div class="form-group">
				              <label for="amount">Montant du prêt * </label>
				              <input type="number" id="amount" min="0" style="color: green; font-weight: bold;" value="{{ $demande->montant_demande }}" class="form-control form-control-lg" name="amount" required>
				            </div>
		            	</div>

		            	<div class="col-md-4">
										<div class="form-group">
				              <label for="amount_commission">Montant de la commission * </label>
				              <input type="number" id="amount_commission" min="0" class="form-control form-control-lg" name="amount_commission" required>
				            </div>
		            	</div>

		            	<div class="col-md-4">
										<div class="form-group">
				              <label for="amount_assurances">Montant des assurances * </label>
				              <input type="number" id="amount_assurances" min="0" class="form-control form-control-lg" name="amount_assurances" required>
				            </div>
		            	</div>

		            	<div class="col-md-4">
										<div class="form-group">
				              <label for="taux_interet">Taux d'intérêt * </label>
				              <select class="form-control form-control-lg" name="taux_interet" style="" required>
				              	<option>Selectionner</option>
				              	@foreach( $taux as $t )
				              	<option value="{{ $t->taux }}">{{ $t->taux * 100 }}%</option>
				              	@endforeach
				              </select>
				            </div>
		            	</div>

		            	<div class="col-md-6">
										<div class="form-group">
				              <label for="activite_principale">Activités principales ( à énumérer ) </label>
				              <textarea class="form-control" name="activite_principale" rows="10" placeholder="Activités principales ( à énumére )"></textarea>
				            </div>
		            	</div>
		            	<div class="col-md-6">
										<div class="form-group">
				              <label for="force_strategie">Forces/Stratégies envisagées par l’emprunteur </label>
				              <textarea class="form-control" name="force_strategie" rows="10" placeholder="Forces/Stratégies envisagées par l’emprunteur" required></textarea>
				            </div>
		            	</div>

		            	<div class="col-md-12">
										<div class="form-group">
				              <label for="description">Description du prêt * </label>
				              <textarea class="form-control" name="description" rows="10" placeholder="Ecrire une description du prêt" required></textarea>
				            </div>
		            	</div>
		            	
									<div class="col-md-12">
										<div class="form-group">
				              <button type="submit" class="btn btn-primary btn-lg me-2"> <i class="mdi mdi-arrow-down"></i> &nbsp;&nbsp; Suivant</button>
				            </div>
		            	</div>
								</div>

							</form>
               
	        </div>
	      </div>
	    </div>
          
		</div>