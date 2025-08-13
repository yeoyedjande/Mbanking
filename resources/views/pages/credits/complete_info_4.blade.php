<div class="form-section">

          <div class="row">



            <div class="card-header">

                <h3 class="card-title"> B. ANALYSE DU CREDIT DEMANDE 

                  <br></h3> <h4> 1. DESCRIPTION DE LA DEMANDE</h4>

            </div>
                                             

                      <div class="col-md-6 col-12">

                          <div class="form-group">

                              <label for="nom_prenom_signataire1" class="form-label">Détail de l’objet(précision activité):</label>

                              <input type="text" id="nom_prenom_signataire1" class="form-control" name="detail_objet_precision_activite" required data-parsley-group="block3">

                          </div>

                      </div>



                      <div class="col-md-6 col-12">

                          <div class="form-group">

                              <label for="nom_prenom_signataire2" class="form-label">Conditions de la demande:</label>

                              <input type="text" id="nom_prenom_signataire2" class="form-control" name="condition_demande" required data-parsley-group="block3">

                          </div>

                      </div>



                      <div class="input-group">

                       <div class="input-group-prepend">

                         <span class="input-group-text">

                           

                         Garanties proposées : </span >

                        

                       </div>

                       <input

                         type="text"

                         aria-label="First name"

                         class="form-control"

                         placeholder="1°"

                         name="garantie_propose1"required data-parsley-group="block3"

                       />

                       <input

                         type="text"

                         aria-label="Last name"

                         class="form-control"

                         name="garantie_propose1"

                         placeholder="2°"

                       />

                       <input

                         type="text"

                         aria-label="Last name"

                         class="form-control"

                         name="garantie_propose1"

                         placeholder="3°"

                       />

                   </div>



                      <div class="col-md-6 col-12">

                          <div class="form-group">

                              <label for="nom_prenom_signataire3" class="form-label">Avaliseur ( Nom et Prénom):</label>

                              <input type="text" id="nom_prenom_aviliseur" class="form-control" name="nom_prenom_avaliseur" required data-parsley-group="block3">

                          </div>

                      </div>



                      <div class="col-md-6 col-12">

                          <div class="form-group">

                            <label for="cni_signataire3" class="form-label">Résidence: </label>

                              <input type="text" id="cni_signataire3" class="form-control" name="residence" required data-parsley-group="block3">

                        </div>

                      </div>



                      <div class="col-md-6 col-12">

                          <div class="form-group">

                              <label for="telephone" class="form-label">CNI :</label>

                              <input type="number" id="cni" class="form-control" name="cni" required data-parsley-group="block3">

                          </div>

                      </div>



                      <div class="col-md-6 col-12">

                          <div class="form-group">

                              <label for="telephone" class="form-label">Téléphone :</label>

                              <input type="number" id="telephone" class="form-control" name="telephone" required data-parsley-group="block3">

                          </div>

                      </div>


                      <div class="col-md-6 col-12">

                          <div class="form-group">

                              <label for="activite_principale" class="form-label">Activité principale :</label>

                              <input type="text" id="activite_principale" class="form-control" name="activite_principale" required data-parsley-group="block3">

                          </div>

                      </div>



                 <h4>  2. ANALYSE DE LA DEMANDE </h4>





                  <ul> <br>

                      <h4>  2.1. Eléments d’analyse:</h4><br><br>

                   <li class="d-inline-block me-2 mb-1">

                         <div class="form-check">

                           <div class="checkbox">

                          <label for="checkbox2">Eléments du Dossier

                          </label>

                           <input

                           type="radio"

                           class="form-check-input"

                           id="checkbox2"

                           name="element_dossier"required data-parsley-group="block3"

                           />

                        </div>

                      </div>

                     </li>

                     <li class="d-inline-block me-2 mb-1">

                         <div class="form-check">

                           <div class="checkbox">

                          <label for="checkbox2">Rapport de Visite de terrain  

                          </label>

                           <input

                           type="radio"

                           class="form-check-input"

                           id="checkbox2"

                           name="element_dossier"

                           />

                        </div>

                      </div>

                     </li>



                      <li class="d-inline-block me-2 mb-1">

                         <div class="form-check">

                           <div class="checkbox">

                          <label for="checkbox2">Rapport d’expertise de la garantie 

                          </label>

                           <input

                           type="radio"

                           class="form-check-input"

                           id="checkbox2"

                           name="element_dossier"

                           />

                        </div>

                      </div>

                     </li>

                   </ul>

                     <br><br>



                     <h4>2.2. Résultat de l’analyse de la demande (Cfr annexe 1)</h4>

                                Commentaire de l’agent:

                       <div class="form-floating">

                         <textarea

                           class="form-control"

                           id="floatingTextarea"

                           name="commentaire_agent_demande"required data-parsley-group="block3"

                         ></textarea>

                      </div>



                       <h4>2.3. Résultat de l’analyse de la rentabilité du Projet/activité (Cfr annexe 2)</h4>

                                Commentaire de l’agent:

                       <div class="form-floating">

                         <textarea

                           class="form-control"

                           id="floatingTextarea"

                           name="commentaire_agent_rentabilite"required data-parsley-group="block3"

                         ></textarea>

                      </div>



                      <br>

     <h4>2.4. EVALUATION DES GARANTIES  </h4>

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

                                 <th class="col-n">Nature/Type de garantie</th>

                                 <th>Description+ Mode  d’acquisition</th>

                                 <th>

                                   Valeur de Garantie 

                                  </th>

                                 <th>Combien de Km de l’agence</th>

                                 <th>Doc. matérialisant la garantie</th>

                                 <th>Valeur Retenue après visite</th>

                               </tr>

                             </thead>

                             <tbody> 

                               <tr>

                                 <td class="text-bold-500"> Épargne_nantie</td>

                                 <td><input type="text"name="mode_description1"class="form-control"required data-parsley-group="block3"></td>

                                 <td class="text-bold-500"><input type="text" name="valeur_garantie1"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="combien_km_agence1"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="doc_materiel_garantie1"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="valeur_retenu_visiste1"class="form-control"required data-parsley-group="block3"></td>

               



                               </tr>

                               <tr>

                                 <td class="text-bold-500">Garantie matérielle1</td>

                                 <td><input type="text" name="mode_description2"class="form-control"required data-parsley-group="block3"></td>

                                 <td class="text-bold-500"><input type="text" name="valeur_garantie2"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="combien_km_agence2"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="doc_materiel_garantie2"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="valeur_retenu_visiste2"class="form-control"required data-parsley-group="block3"></td>

                                 

                               </tr>

                               <tr>

                                 <td class="text-bold-500">Garantie matérielle 2

                             </td>

                                 <td><input type="text"

                                    name="mode_description3"class="form-control"required data-parsley-group="block3"></td>

                                 <td class="text-bold-500"><input type="text" 

                                  name="valeur_garantie3"required data-parsley-group="block3"class="form-control"></td>

                                 <td><input type="text" name="combien_km_agence3"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="doc_materiel_garantie3"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="valeur_retenu_visiste3"class="form-control"required data-parsley-group="block3"></td>



                               </tr>

                               <tr>

                                 <td class="text-bold-500">Caution, Aval (capacité de payer sur base de ses revenus</td>

                                 <td><input type="text"  name="mode_description4"required data-parsley-group="block3"class="form-control"></td>

                                 <td class="text-bold-500"><input type="text"

                                  name="valeur_garantie4"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="combien_km_agence4"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="doc_materiel_garantie4"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="valeur_retenu_visiste4"class="form-control"required data-parsley-group="block3"></td>

                                 

                             </tr>

                             <tr>

                                 <td class="text-bold-500">Dépôt salaire</td>

                                 <td><input type="text"  name="mode_description5"class="form-control"required data-parsley-group="block3"></td>

                                 <td class="text-bold-500"><input type="text"

                                  name="valeur_garantie5"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="combien_km_agence5"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="doc_materiel_garantie5"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="valeur_retenu_visiste5"class="form-control"required data-parsley-group="block3"></td>

                                 

                             </tr>

                             <tr>

                                 <td class="text-bold-500">Autres garanties</td>

                                 <td><input type="text"  name="mode_description6"class="form-control"required data-parsley-group="block3"></td>

                                 <td class="text-bold-500"><input type="text"

                                  name="valeur_garantie6"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="combien_km_agence6"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="doc_materiel_garantie6"class="form-control"required data-parsley-group="block3"></td>

                                 <td><input type="text" name="valeur_retenu_visiste6"class="form-control"required data-parsley-group="block3"></td>

                                 

                             </tr>

                             <tr>

                                 <td colspan="5" class="text-bold-500">Total   (doit être supérieurs au  crédit autorisé  = 150% du montant du crédit autorisé ) : </td>

                                 <td><input type="text" name="monant_credit_autorise"class="form-control"required data-parsley-group="block3"></td>

                                 

                             </tr>

                            <tr>

                             <td colspan="6">

                              Commentaires de l’agent sur la solidité  des garanties :

                               <textarea

                                class="form-control"

                                 id="exampleFormControlTextarea1"

                                 rows="3"

                                 name="commentaires"

                                 required data-parsley-group="block3"

                                >

                               </textarea>

                             </td>

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