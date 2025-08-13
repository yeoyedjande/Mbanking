
  	<div class="row">
     	
	    <div class="col-md-12 grid-margin stretch-card">
	      
	      <div class="card">
	      	
	        <div class="card-body">
	          <h4 class="card-title mb-4">
	          	Informations Personnelles <br>

	          	Client: {{ $demande->nom }} @if($demande->prenom != 'NULL') {{ $demande->prenom }} @endif</h4>
               

            	<form class="forms-sample" action="#" method="POST">

            		{{ csrf_field() }}
              		<div class="row">

		            	<div class="col-md-12">
							
							<table class="table table-bordered" style="bottom: 15px;">
								<thead>
									<th>Sources de Revenus (activités, salaires, autres)</th>
									<th>Montant</th>
									<th>Objet des dépenses (dépenses liées à l’activité et celles liées au ménage)</th>
									<th>Montant</th>
								</thead>

								<tbody>
									<tr>
										<td><input type="text" class="form-control" name="name_source1"></td>
										<td><input type="text" class="form-control" name="montant_source1"></td>
										<td><input type="text" class="form-control" name="objet_name1"></td>
										<td><input type="text" class="form-control" name="montant_objet1"></td>
									</tr>
									<tr>
										<td><input type="text" class="form-control" name="name_source2"></td>
										<td><input type="text" class="form-control" name="montant_source2"></td>
										<td><input type="text" class="form-control" name="objet_name2"></td>
										<td><input type="text" class="form-control" name="montant_objet2"></td>
									</tr>
									<tr class="new_row"></tr>
									<tr>
										<td>TOTAL (A)</td>
										<td><input type="text" class="form-control" name="montant_source3"></td>
										<td>TOTAL (B)</td>
										<td><input type="text" class="form-control" name="montant_objet3"></td>
									</tr>
									<tr>
										<td>REVENU NET ESTIME (C) = (A)-(B)</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
								</tbody>
							</table>

		            	</div>

		            	

		            	<br><br>

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
