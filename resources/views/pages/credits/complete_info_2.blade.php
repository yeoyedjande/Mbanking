<div class="form-section current">

	<div class="row">

	 <h4 class="card-title">1. IDENTIFICATION DE L'EMPRUNTEUR<br>Statut : Personne physique <br><br></h4>



	       

	 	<div class="col-md-7">

		 	<div class="form-group">

		    <label class="mb-2" style="font-size: 20px;">Nom et prénom(s) de l'emprunteur : *</label>  

		    <input type="text" name="nom_emprunteur" value="{{ $demande->nom }}" class="form-control form-control-xl"  required data-parsley-group="block1" readonly />

			</div>

		</div>



		<div class="col-md-5 mb-3">

	      <div class="form-group">

	        <label for="qualite" class="mb-2" style="font-size: 20px;">Qualité de <strong> l'emprunteur *</strong> : </label>

	          <select class="form-control form-control-xl" id="qualite"

	          name="qualite_emprunteur" required data-parsley-group="block1">

	            <option value="Membre ordinaire">Membre ordinaire</option>

	            <option value="Membre des organes">Membre des organes</option>

	            <option value="Membre du Personnel">Membre du Personnel</option>

          	</select>

	      </div>

	  </div> 

	  

	  

   	<ul class="mt-3">

      <label class="mb-2" style="margin-right: 15px; font-size: 20px;">Sexe: *</label> 

    	<li class="d-inline-block me-4 mb-1">

        <div class="form-check">

           <div class="checkbox">

            <label for="checkbox-mal" style="font-size: 20px;">Masculin</label>

             <input type="radio" value="Masculin" class="form-check-input" name="sexe_emprunteur" checked id="checkbox-mal" />

           </div>

         </div>

      </li>



   		<li class="d-inline-block me-4 mb-1">

          <div class="form-check">

            <div class="checkbox">

            <label for="checkbox-fem" style="font-size: 20px;">Feminin  

            </label>

             <input type="radio" class="form-check-input"name="sexe_emprunteur"value="femme" id="checkbox-fem"  />

          </div>

        </div>

   		</li>

    </ul>



    <div class="col-md-6">

        <div class="form-group">

            <label for="prenom" class="mb-2" style="font-size: 20px;">Nom et prénom du père :</label>

            <input type="text" class="form-control form-control-xl"  name="nom_prenom_pere">

        </div>

    </div>





    <div class="col-md-6">

        <div class="form-group">

            <label for="prenom" class="mb-2" style="font-size: 20px;">Nom et prénom de la mère :</label>

            <input type="text" class="form-control form-control-xl"  name="nom_prenom_mere">

        </div>

    </div>



    <div class="col-md-6">

        <div class="form-group">

            <label for="numero" class="mb-2" style="font-size: 20px;">Numéro de la pièce d'identité : *</label>

            <input type="text"  class="form-control form-control-xl" name="nature_numero_piece_identite" required data-parsley-group="block1">

        </div>

    </div>



	       

    <div class="col-md-6">

        <div class="form-group">

            <label for="date" class="mb-2" style="font-size: 20px;">Lieu de naissance : * </label>

            <input type="text" value="{{ $demande->lieu_naissance }}" class="form-control form-control-xl" name="lieu_naissance_emprunteur" required data-parsley-group="block1">

        </div>

    </div>



   	<div class="col-md-6">

      <div class="form-group">

          <label for="date" class="mb-2" style="font-size: 20px;">Date de naissance : *</label>

          <input type="date" value="{{ $demande->date_naissance }}" class="form-control form-control-xl" name="date_naissance_emprunteur" required data-parsley-group="block1">

      </div>

  	</div>



    <div class="col-md-6">

        <div class="form-group">

            <label for="raison_social" class="mb-2" style="font-size: 20px;">Résidence actuelle : *</label>

            <input type="text"  class="form-control form-control-xl" name="residence_actuelle_emprunteur" required data-parsley-group="block1">

        </div>

    </div>



   	<div class="col-md-6 col-12">

      <div class="form-group">

          <label for="association" class="mb-2" style="font-size: 20px;">Nom de l'Association</label>

          <input type="text"  class="form-control form-control-xl" name="nom_association">

      </div>

    </div>



    <div class="col-md-6 col-12">

        <div class="form-group">

            <label for="association" class="mb-2" style="font-size: 20px;">Employeur :</label>

            <input type="text" class="form-control form-control-xl" name="employeur_emprunteur">

        </div>

    </div>



    <div class="col-md-6 col-12">

        <div class="form-group">

            <label for="association" class="mb-2" style="font-size: 20px;">Lieu de travail :</label>

            <input type="text"  class="form-control form-control-xl" name="lieu_travail_emprunteur">

        </div>

    </div>



    <div class="col-md-6 col-12">

        <div class="form-group">

	            <label for="membres" class="mb-2" style="font-size: 20px;">Téléphone * :</label>

	            <input type="text" value="{{ $demande->telephone }}" class="form-control form-control-xl" name="tel_emprunt" required data-parsley-group="block1">

	      </div>

    </div>



	                   

   	<div class="col-md-6 col-12">

       	<div class="form-group">

          <label for="etat_civil" class="mb-2" style="font-size: 20px;">Etat- Civil *</label>

         <select class="form-control form-control-xl" name="etat_civil_emprunteur" required data-parsley-group="block1">

             <option value="Célibataire">Célibataire</option>

             <option value="Marié">Marié(e)</option>

             <option value="Divorcé">Divorcé(e)</option>

              <option value="Veuf">Veuf(Veuve)</option>

         </select>

        </div>

   	</div>



    <div class="col-md-6 col-12">

        <div class="form-group">

          <label for="cni_client" class="mb-2" style="font-size: 20px;">Ancienneté :</label>

            <input type="text" id="cni_client" class="form-control form-control-xl" name="anciennete_emprunteur">

      	</div>

    </div>





    <div class="col-md-6 col-12">

        <div class="form-group">

          <label for="cni_client" class="mb-2" style="font-size: 20px;">Nom du conjoint :</label>

            <input type="text" id="cni_client" class="form-control form-control-xl" name="nom_conjoint_emprunteur">

      </div>

    </div>





    <div class="col-md-6 col-12">

        <div class="form-group">

          <label for="cni_client" class="mb-2" style="font-size: 20px;">Téléphone du conjoint :</label>

            <input type="text" id="cni_client" class="form-control form-control-xl" name="telephone_conjoint">

      </div>

    </div>





    <div class="col-md-6 col-12">

        <div class="form-group">

          <label for="cni_client" class="mb-2" style="font-size: 20px;">Lieu de travail du conjoint :</label>

            <input type="text" id="cni_client" class="form-control form-control-xl" name="lieu_travail_conjoint">

      </div>

    </div>



		<div class="col-md-6 col-12">

		  <div class="form-group">

		    <label  class="mb-2" style="font-size: 20px;">Employeur du conjoint :</label>

		      <input type="text"  class="form-control form-control-xl" name="employeur_conjoint">

			</div>

		</div>



    <div class="col-md-6 col-12">

        <div class="form-group">

          <label class="mb-2" style="font-size: 20px;">Ancienneté du conjoint :</label>

            <input type="text" id="cni_client" class="form-control form-control-xl" name="Anciennete_conjoint">

      </div>

    </div>





    <div class="col-md-6 col-12">

        <div class="form-group">

          <label class="mb-2" style="font-size: 20px;">Personnes de référence : *</label>

            <input type="text" id="cni_client" class="form-control form-control-xl" name="personne_reference" required data-parsley-group="block1">

      </div>

    </div>



    <div class="col-md-6">

     <div class="form-group">

         <label for="resi_lieu_perso_ref" class="mb-2" style="font-size: 20px;">Résidence/lieu de travail de la personnes de référence : *</label>

         <input type="text" id="resi_lieu_perso_ref" class="form-control form-control-xl" name="lieu_perso_ref"required data-parsley-group="block1">

      </div>

   </div>



     <div class="col-md-6 col-12">

        <div class="form-group">

          <label  class="mb-2" style="font-size: 20px;">Téléphone de la personnes de référence : *</label>

            <input type="text" id="cni_client" class="form-control form-control-xl" name="tel_perso_ref" required data-parsley-group="block1">

      </div>

    </div> 

	                        

	</div> 



	 

		<button type="button" id="first-step" class="next btn btn-primary float-right btn-lg">Suivant ></button>

</div>