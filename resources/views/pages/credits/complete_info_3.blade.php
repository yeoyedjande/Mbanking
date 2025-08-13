<div class="form-section">

<div class="row">



<h4 class="card-title"> 2. HISTORIQUE DE L’EMPRUNTEUR <br>2.1. ACTIVITES  <br> <br></h4> 





  <div class="col-12">

    <div class="input-group">

      <div class="input-group-prepend">

        <span class="input-group-text">Activités principales ( à énumérer) :</span>

      </div>

        <input type="text" name="activite1" aria-label="First name" class="form-control" required  placeholder="1)" required data-parsley-group="block2"/>

        <input type="text" name="activite2" aria-label="Last name" class="form-control"  placeholder="2)"  data-parsley-group="block2"/>

        <input type="text"  name="activite3" aria-label="Last name" class="form-control" placeholder="3) Autres..." data-parsley-group="block2"/>

    </div>

    <br><br>  

  </div>  

  <section class="section">

      <div class="row">

          <div class="col">

              <div class="card">

                <label ><br>Faiblesses/Contraintes de l’emprunteur (Marché d’approvisionnement/écoulement,  concurrence,) :  </label>



                   <div class="form-floating">

                       <textarea
                         class="form-control"
                         placeholder="Faiblesses et contraintes de l'emprunteur"
                         id="floatingTextarea"
                         name="faiblesses_contraintes_emprunteur_marche_approvisionnement"
                          data-parsley-group="block2"></textarea>

                   </div>

              </div>

          </div>

      </div>

  </section>



  <section class="section">

      <div class="row">

          <div class="col">

              <div class="card">

                <label ><br>Forces/Stratégies envisagées par l’emprunteur : </label>



                   <div class="form-floating">

                       <textarea

                         class="form-control"

                         placeholder="Leave a comment here"

                         id="floatingTextarea"

                         name="forces_Strategies_envisagees_par_emprunteur"

                          data-parsley-group="block2"></textarea>

                   </div>

              </div>

          </div>

      </div>

  </section>



 	<h4 class="card-title"> 2.2. ESTIMATION DES RECETTES ET DEPENSES DE L'EMPRUNTEUR (Période mensuelle, trimestrielle………): <br></h4> 





	<section class="section">

    <div class="row" id="table-bordered">

      <div class="col-12">

        <div class="card">

          <div class="card-content">

          

            <!-- table bordered -->

            <div class="table-responsive">

              <table class="table table-bordered mb-0">



                <thead>

                  <tr>

                   <th>Sources de Revenus (activités, salaires, autres)</th>

                   <th>Montant</th>

                   <th>Objet des dépenses (dépenses liées à l’activité et celles liées au ménage)</th>

                   <th>Montant</th>

                  </tr>

                </thead>



                <tbody>



                  <tr>

                    <td class="text-bold-500"><input type="text"  name="source_revenus1" data-parsley-group="block2" class="form-control"></td>

                    <td><input type="text" class="form-control" name="montant_source_revenus1" data-parsley-group="block2"></td>

                    <td class="text-bold-500"><input type="text" name="objet_depense1" data-parsley-group="block2" class="form-control"></td>

                    <td><input type="text" class="form-control" name="montant_objet_depense1" data-parsley-group="block2"></td>

                  </tr>



                  <tr>

                    <td class="text-bold-500"><input type="text"  name="source_revenus2"  data-parsley-group="block2"class="form-control"></td>

                    <td><input type="text" class="form-control" name="montant_source_revenus2" data-parsley-group="block2"></td>

                    <td class="text-bold-500"><input type="text" name="objet_depense2" data-parsley-group="block2" class="form-control"></td>

                    <td><input type="text" class="form-control" name="montant_objet_depense2" data-parsley-group="block2"></td>

                  </tr>



                  <tr>

                    <td class="text-bold-500"><input type="text"  name="source_revenus3"   data-parsley-group="block2"class="form-control" placeholder="TOTAL (A)"></td>

                    <td><input type="text" class="form-control" name="montant_source_revenus3" data-parsley-group="block2"></td>

                    <td class="text-bold-500"><input type="text" name="objet_depense3" placeholder="TOTAL (B)" class="form-control" data-parsley-group="block2"></td>

                    <td><input type="text" class="form-control" name="montant_objet_depense3" data-parsley-group="block2"></td>

                  </tr>



                  <tr>

                    <td class="text-bold-500"><input type="text"  name="source_revenus4" placeholder="REVENU NET ESTIME(C) = (A)-(B)" class="form-control" data-parsley-group="block2"></td>

                    <td><input type="text" class="form-control" name="montant_source_revenus4" data-parsley-group="block2"></td>

                    <td class="text-bold-500"><input type="text" name="objet_depense4"  data-parsley-group="block2"class="form-control"></td>

                    <td><input type="text" class="form-control" name="montant_objet_depense4" data-parsley-group="block2"></td>

                  </tr>



                </tbody>

              </table>

            </div>

          </div>

        </div>

      </div>

    </div>

  </section>

 

 	<h4 class="card-title"> 2.3. HABITUDES EN ÉPARGNE ET CRÉDIT <br>

  </h4> <h5> 2.3.1. HABITUDES EN ÉPARGNE</h5>  <br> <br>

 

  Séquence en épargne: 

  <ul>  

      <li class="d-inline-block me-2 mb-1">

          <div class="form-check">

           <label for="checkbox2"> Journalier</label>

            <input

            type="radio"

            class="form-check-input"

            id="checkbox2"

            name="flexRadio1"

            />

         </div>

      </li>

      <li class="d-inline-block me-2 mb-1">

          <div class="form-check">

            <div class="checkbox">

            <input

            type="radio"

            class="form-check-input"

            id="checkbox3"

            name="flexRadio1"



            />

           <label for="checkbox3">Mensuel</label>

           </label>

         </div>

       </div>

      </li>

      <li class="d-inline-block me-2 mb-1">

          <div class="form-check">

            <div class="checkbox">

            <input

            type="radio"

            class="form-check-input"

            id="checkbox4"

            name="flexRadio1"

            required data-parsley-group="block2"



            />

           <label for="checkbox4">Trimestriel</label>

           </label>

         </div>

       </div>

      </li>



      <li class="d-inline-block me-2 mb-1">

          <div class="form-check">

            <div class="checkbox">

            <input

            type="radio"

            class="form-check-input"

            id="checkbox5"

            name="flexRadio1"



            />

           <label for="checkbox5">Semestriel</label>

           </label>

         </div>

       </div>

      </li>

      <li class="d-inline-block me-2 mb-1">

          <div class="form-check">

            <div class="checkbox">

            <input

            type="radio"

            class="form-check-input"

            name="flexRadio1"

            id="checkbox6"

            />

           <label for="checkbox6">Aléatoire</label>

           </label>

         </div>

       </div>

      </li>



      <li class="d-inline-block me-2 mb-1">

           <div class="form-check">

             <div class="checkbox">

       <label for="checkbox7">Néant</label>

                   <input

              type="radio"

            class="form-check-input"

            name="flexRadio1"

            id="checkbox7"

            />

         </div>

       </div>

      </li>

  </ul> 

  <br><br> 

            

            

	Volume moyen épargne a vue (Versements) durant les 6 derniers mois : <br>



 

	<div class="row"> 



	  <div class="col-md-6 col-12">

	    <div class="form-group">

	      <label for="versement_jour" class="form-label">Journalière  :</label>

	        <input type="text" id="versement_jour" class="form-control" name="versement_jour"  data-parsley-group="block2">

	      </div>

	  </div>



	  <div class="col-md-6 col-12">

	    <div class="form-group">

	      <label for="versement_hebdo" class="form-label"> Hebdomadaire :</label>

	        <input type="text" id="versement_hebdo" class="form-control" name="versement_hebdo" data-parsley-group="block2">

	      </div>

	  </div>



	  <div class="col-md-6 col-12">

	    <div class="form-group">

	      <label for="versement_mois" class="form-label"> Mensuel :</label>

	        <input type="text" id="versement_mois" class="form-control"  data-parsley-group="block2"name="versement_mois">

	    </div>

	  </div>



	  <div class="col-md-6 col-12">

	    <div class="form-group">

	      <label for="versement_trimestre" class="form-label">Trimestriel:</label>

	        <input type="text" id="versement_trimestre" class="form-control" name="versement_trimestre"  data-parsley-group="block2">

	    </div>

	  </div>

	  

	  <div class="col-md-6 col-12">

	    <div class="form-group">

	      <label for="versement_semestre" class="form-label">Semestriel :</label>

	        <input type="text" id="versement_semestre" class="form-control" name="versement_semestre" data-parsley-group="block2">

	    </div>

	  </div>

	</div>

  



  <div>



    <div class="col-12">

      <div class="input-group">

        <div class="input-group-prepend">

          <span class="input-group-text">Nombre et volume des dépôts à Terme depuis l’adhésion :</span>

        </div>

        <input type="number" aria-label="First name" class="form-control" name="nombre_adhesion" placeholder="Nombre" data-parsley-group="block2"/>

        <input type="text" name="volume_adhesion" aria-label="Last name" class="form-control" placeholder="Volume" data-parsley-group="block2"/>

      </div>

    </div>



  </div>



<br><br>



<h4> 2.3.2. HABITUDES EN CREDIT</h4><br>

    Avez-vous déjà bénéficié d’un crédit ?

<li class="d-inline-block me-2 mb-1">

  <div class="form-check">

    <div class="checkbox">

      <label for="credit-oui">Oui</label>

        <input type="radio" class="form-check-input" name="credit" id="credit-oui"/>

    </div>

  </div>

</li> 



<li class="d-inline-block me-2 mb-1">

  <div class="form-check">

    <div class="checkbox">

        <label for="credit-non">Non</label>

          <input type="radio" class="form-check-input" name="credit" id="credit-non"/>

      </div>

    </div>

    <div class="col-md-6 col-12">

      <div class="form-group">

        <label for="non" class="form-label">Si non, pourquoi ?</label>

          <input type="text" id="non" class="form-control" name="pourquoi_credit">

      </div>

    </div>

</li>



<div class="col-md-6 col-12">

  <div class="form-group">

    <label for="nombre_credit" class="form-label">Si oui : Nombre</label>

      <input type="number" id="nombre_credit" class="form-control" name="nombre_credit">

  </div>

</div>



<div class="col-md-6 col-12">

  <div class="form-group">

    <label for="date_dernier_credit" class="form-label"> Date/Année dernier crédit :</label>

      <input type="date" id="date_dernier_credit" class="form-control" name="date_dernier_credit" >

  </div>

</div>



<section class="section">

  <div class="row" id="table-bordered">

    <div class="col-12">

      <div class="card">

        <div class="card-content">

          Montant des Crédits déjà obtenus:

          <!-- table bordered -->

          <div class="table-responsive">

            <table class="table table-bordered mb-0">



              <thead>

                <tr>

                  <th class="col-n">N°</th>

                  <th>Montant</th>

                  <th>Date/Mois/Année</th>

                  <th>Institution</th>

                  <th>Pénalités payées</th>

                </tr>

              </thead>



              <tbody>



                <tr>

                  <td class="text-bold-500">1</td>

                  <td><input type="number"name="montant_credit1" class="form-control" data-parsley-group="block2"></td>

                  <td class="text-bold-500"><input type="date" name="date_credit1" class="form-control" data-parsley-group="block2"></td>

                  <td><input type="text" name="institution1" class="form-control" data-parsley-group="block2"></td>

                  <td><input type="text" name="penalites_payees1" class="form-control" data-parsley-group="block2"></td>

                </tr>



                 <tr>

                  <td class="text-bold-500">2</td>

                  <td><input type="number"name="montant_credit2" class="form-control" data-parsley-group="block2"></td>

                  <td class="text-bold-500"><input type="date" name="date_credit2" class="form-control" data-parsley-group="block2"></td>

                  <td><input type="text" name="institution2" class="form-control" data-parsley-group="block2"></td>

                  <td><input type="text" name="penalites_payees2" class="form-control" data-parsley-group="block2"></td>

                </tr>



                 <tr>

                  <td class="text-bold-500">3</td>

                  <td><input type="number"name="montant_credit3" class="form-control" data-parsley-group="block2"></td>

                  <td class="text-bold-500"><input type="date" name="date_credit3" class="form-control" data-parsley-group="block2"></td>

                  <td><input type="text" name="institution3" class="form-control" data-parsley-group="block2"></td>

                  <td><input type="text" name="penalites_payees3" class="form-control" data-parsley-group="block2"></td>

                </tr>



                <tr>

                  <td class="text-bold-500">4</td>

                  <td><input type="number"name="montant_credit4" class="form-control" data-parsley-group="block2"></td>

                  <td class="text-bold-500"><input type="date" name="date_credit4" class="form-control" data-parsley-group="block2"></td>

                  <td><input type="text" name="institution4" class="form-control"  data-parsley-group="block2"></td>

                  <td><input type="text" name="penalites_payees4"  class="form-control" data-parsley-group="block2"></td>

                </tr>



              </tbody>

            </table>

          </div>

        </div>

      </div>

    </div>

  </div>

</section>



</div> 



  <button type="button" class="previous btn btn-primary float-left">< Précédent</button>

  <button type="button" id="first-step" class="next btn btn-primary float-right">Suivant ></button>                                         

</div>