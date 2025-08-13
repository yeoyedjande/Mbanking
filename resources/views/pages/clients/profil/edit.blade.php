    @extends('layouts.template')

    @section('title', 'Create-Clients')

    @section('content')

    <!-- inclure la librairie jQuery -->
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}" id="parsley"></script>

<script>
      $(document).ready(function() {
     
      $('#form-pars').parsley({
        errorClass: 'is-invalid text-danger',
        successClass: 'is-valid',
        errorsWrapper: '<span class="invalid-feedback"></span>',
        errorTemplate: '<span></span>'
      });

      var current_fs, next_fs, previous_fs; // fieldsets
      var opacity;
      var step = 1;

      $('#form-pars fieldset:not(:first-child)').hide();

      //  bouton Suivant
      $('.next').click(function() {
      var form = $('#form-pars');
      var current_fs = $(this).parent();
      var next_fs = $(this).parent().next();
      
      if (form.parsley().validate({group: 'block' + step}) && step < 2) {
        current_fs.hide();
        next_fs.show();
        step++;
      }
    });

    // Bouton précédent
    $('.previous').click(function() {
      var current_fs = $(this).parent();
      var previous_fs = $(this).parent().prev();
      
      current_fs.hide();
      previous_fs.show();
      step--;
    });

      // Empêcher la soumission du formulaire
      if (form.parsley().validate({group: 'block' + step}) && step == 2) {
      return true;
    }


    });

</script>


    <style>
        .form-section {
            display: none;
        }

        .form-section.current {
            display: block;
        }
    </style>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Formulaire de création de compte client</h4>
                    </div>
                    <div class="row">
                    @if( session()->has('msg') )
                    <div class="col-md-12">
                      <div class="alert alert-success">{{ session()->get('msg') }}</div>
                    </div>
                    @endif 
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" id="form-pars" method="POST" action="{{ route('profil.edit.valide') }}">
                                {{ csrf_field() }}

                                <!-- Page 1 -->
                                <div class="form-section current">
                                    <div class="row">

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="nom" class="form-label">Nom</label>
                                                <input type="text" id="nom" class="form-control" placeholder="Nom" name="nom" required data-parsley-group="block1">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="prenom" class="form-label">Prénom(s)</label>
                                                <input type="text" id="prenom" class="form-control" placeholder="Prénom(s)" name="prenom" required data-parsley-group="block1">
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="raison_social" class="form-label">Raison sociale</label>
                                                <input type="text" id="raison_social" class="form-control" name="raison_social" required data-parsley-group="block1">
                                            </div>
                                        </div>

                                                <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="association" class="form-label">Nom de l'Association</label>
                                                            <input type="text" id="association" class="form-control" name="nom_association" required data-parsley-group="block1">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="membres" class="form-label">Nombre de membres de l'Association</label>
                                                            <input type="number" id="membres" class="form-control" name="nombre_membres" required data-parsley-group="block1">
                                                      </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="nationalite" class="form-label">Nationalité</label>
                                                            <input type="text" id="nationalite" class="form-control" name="nationalite" required data-parsley-group="block1">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                          <label for="cni_client" class="form-label">CNI</label>
                                                            <input type="text" id="cni_client" class="form-control" name="cni_client" required data-parsley-group="block1">
                                                      </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                          <label for="residence" class="form-label">Résidence</label>
                                                            <input type="text" id="residence" class="form-control" name="residence" required data-parsley-group="block1">
                                                      </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                          <label for="ville" class="form-label">Ville</label>
                                                            <input type="text" id="ville" class="form-control" name="ville" required data-parsley-group="block1">
                                                      </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                          <label for="date_naissance" class="form-label">Date de naissance</label>
                                                            <input type="date" id="date_naissance" class="form-control" name="date_naissance" required data-parsley-group="block2">
                                                      </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="lieu_naissance" class="form-label">Lieu de naissance</label>
                                                            <input type="text" id="lieu_naissance" class="form-control" name="lieu_naissance" required data-parsley-group="block2">
                                                        </div>
                                                    </div>

                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="etat_civil" class="form-label">Etat- Civil</label>
                                                        <select class="form-select" id="etat_civil" name="etat_civil">
                                                            <option value="Célibataire">Célibataire</option>
                                                            <option value="Marié">Marié(e)</option>
                                                            <option value="Divorcé">Divorcé(e)</option>
                                                            <option value="Veuf">Veuf(Veuve)</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                    
                                  </div>
                                    <button type="button" id="first-step" class="next btn btn-primary float-right">Suivant ></button>
                                </div>

                                  <!-- Page 2 -->
                                  <div class="form-section">
                                        <div class="row">

                                                <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="profession" class="form-label">Profession</label>
                                                            <input type="text" id="profession" class="form-control" name="profession" required data-parsley-group="block2">
                                                      </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                          <label for="employeur" class="form-label">Employeur</label>
                                                            <input type="text" id="employeur" class="form-control" name="employeur" required data-parsley-group="block2">
                                                      </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                          <label for="lieu_activite" class="form-label">Lieu d'activité</label>
                                                            <input type="text" id="lieu_activite" class="form-control" name="lieu_activite" required data-parsley-group="block2">
                                                      </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="adresse" class="form-label">Adresse</label>
                                                            <input type="text" id="adresse" class="form-control" name="adresse" required data-parsley-group="block2">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="commune" class="form-label">Commune</label>
                                                            <input type="text" id="commune" class="form-control" name="commune" required data-parsley-group="block2">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="telephone" class="form-label">Telephone</label>
                                                            <input type="number" id="telephone" class="form-control" name="telephone" required data-parsley-group="block2">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="quartier" class="form-label">Quartier</label>
                                                            <input type="text" id="quartier" class="form-control" name="quartier" required data-parsley-group="block2">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 col-12">
                                                          <div class="form-group">
                                                              <label for="nom_conjoint" class="form-label">Nom du Conjoint</label>
                                                              <input type="text" id="nom_conjoint" class="form-control" name="nom_conjoint" required data-parsley-group="block3">
                                                          </div>
                                                      </div>    

                                                      <div class="col-md-6 col-12">
                                                          <div class="form-group">
                                                            <label for="nom_heritier1" class="form-label">Nom de l'héritier 1 </label>
                                                              <input type="text" id="nom_heritier1" class="form-control" name="nom_heritier1" required data-parsley-group="block3">
                                                        </div>
                                                      </div>

                                                      <div class="col-md-6 col-12">
                                                          <div class="form-group">
                                                            <label for="nom_heritier2" class="form-label">Nom de l'héritier 2 </label>
                                                              <input type="text" id="nom_heritier2" class="form-control" name="nom_heritier2" required data-parsley-group="block3">
                                                        </div>
                                                      </div>

                                                      <div class="col-md-6 col-12">
                                                          <div class="form-group">
                                                            <label for="nom_heritier3" class="form-label">Nom de l'héritier 3 </label>
                                                              <input type="text" id="nom_heritier3" class="form-control" name="nom_heritier3" required data-parsley-group="block3">
                                                        </div>
                                                      </div>

                                                       
                                                </div>

                                            <button type="button" class="previous btn btn-primary float-left">< Précédent</button>
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Editer</button>                                         
                                  </div>
                            </form>
                        </div>

                    </div>
                </div>
             </div>
        </div>
    </section>
    @endsection

    
