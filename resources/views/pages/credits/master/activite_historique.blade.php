
  	<div class="row">
     	
	    <div class="col-md-12 grid-margin stretch-card">
	      
	      <div class="card">
	      	
	        <div class="card-body">
	          <h4 class="card-title mb-4">
	          	Informations Personnelles <br>

	          	Client: {{ $demande->nom }} @if($demande->prenom != 'NULL') {{ $demande->prenom }} @endif</h4>
               

            	<form class="forms-sample" action="{{ route('complete-demandes-step-3', $demande->id) }}" method="POST">

            		{{ csrf_field() }}
              		<div class="row">

		            	<div class="col-md-6">
							<div class="form-group">
				              <label for="num_account">Activités principales ( à énumérer) * </label>
				              <textarea rows="5" required class="form-control" name="activite_principale"></textarea>
				            </div>
		            	</div>

		            	<div class="col-md-6">
							<div class="form-group">
				              <label for="nom">Forces/Stratégies envisagées par l’emprunteur * </label>
				              <textarea rows="5" class="form-control" name="force_strategie" required></textarea>
				            </div>
		            	</div>

		            	

						<div class="col-md-12">
							<div class="form-group">
				              <a href="{{ route('complete-demandes', $demande->id) }}" class="btn btn-primary btn-lg me-2">   <i class="mdi mdi-arrow-left"></i>Retour &nbsp;&nbsp;</a>

				              <button type="submit" class="btn btn-primary btn-lg me-2">   Suivant&nbsp;&nbsp;<i class="mdi mdi-arrow-right"></i></button>
				            </div>
		            	</div>
					</div>

				</form>
               
	        </div>
	      </div>
	    </div>
          
		</div>
