@extends('layouts.template')

@section('title', 'PERSONNE MORAL')

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

    var step = 1;

    $('#form-pars fieldset:not(:first-child)').hide();

    // Fonction pour mettre à jour les champs de la quatrième étape
    function updateRecapFields() {
    // Récupérez les valeurs des champs de chaque étape
    var numeroClient = $('#numero').val();
    var nomEntreprise = $('#nom_entreprise').val();
    var typeCompte = $('#compte').val();
    var ancienNumeroClient = $('input[name="ancien_numeroclient"]').val();
    var dateOuvertureCompte = $('#date_ouverture_compte').val();
    var langCorrespondance = $('#langue_correspondance').val();
    var raisonSocial = $('#raison_social').val();
    var abreviation = $('input[name="abreviation"]').val();
    var adresse = $('#adresse').val();
    var codePostal = $('#code_postal').val();
    var ville = $('#ville').val();
    var pays = $('#pays').val();
    var numeroTelephone = $('#numero_telephone').val();
    var email = $('#email').val();
    var localisation1 = $('#localisation_1').val();
    var localisation2 = $('#localisation_2').val();
    var localisation3 = $('#localisation_3').val();
    var zone = $('#zone').val();
    var commentaireClient = $('textarea[name="commetaire_client"]').val();
    var categoriePm = $('#categorie_pm').val();
    var qualite = $('#qualite').val();
    var niveauAgence = $('#niveau_agence').val();
    var niveauGuichet = $('#niveau_guichet').val();
    var numeroCarteBancaire = $('#numero_carte_bancaire').val();
    var versementInitial = $('#versement_initial').val();
    var montantEpargne = $('#montant_epargne').val();
    var totalVerse = $('#total_verse').val();
    var dateClotureCompte = $('#date_cloture_compte').val();
    var versementFinal = $('#versement_final').val();

    // Mettez à jour les champs de la quatrième étape avec les valeurs récupérées
    $('#recap_numero_client').text(numeroClient);
    $('#recap_nom_entreprise').text(nomEntreprise);
    $('#recap_type_compte').text(typeCompte);
    $('#recap_ancien_numero_client').text(ancienNumeroClient);
    $('#recap_date_ouverture_compte').text(dateOuvertureCompte);
    $('#recap_langue_correspondance').text(langCorrespondance);
    $('#recap_raison_sociale').text(raisonSocial);
    $('#recap_abreviation').text(abreviation);
    $('#recap_adresse').text(adresse);
    $('#recap_code_postal').text(codePostal);
    $('#recap_ville').text(ville);
    $('#recap_pays').text(pays);
    $('#recap_numero_telephone').text(numeroTelephone);
    $('#recap_email').text(email);
    $('#recap_localisation_1').text(localisation1);
    $('#recap_localisation_2').text(localisation2);
    $('#recap_localisation_3').text(localisation3);
    $('#recap_zone').text(zone);
    $('#recap_commentaire_client').text(commentaireClient);
    $('#recap_categorie_pm').text(categoriePm);
    $('#recap_qualite').text(qualite);
    $('#recap_niveau_agence').text(niveauAgence);
    $('#recap_niveau_guichet').text(niveauGuichet);
    $('#recap_numero_carte_bancaire').text(numeroCarteBancaire);
    $('#recap_versement_initial').text(versementInitial);
    $('#recap_montant_epargne').text(montantEpargne);
    $('#recap_total_verse').text(totalVerse);
    $('#recap_date_cloture_compte').text(dateClotureCompte);
    $('#recap_versement_final').text(versementFinal);
    // Ajoutez autant de champs que nécessaire

    // Mise à jour du logo dans le récapitulatif
    readAndPreviewLogo();

    // Mise à jour de la photo dans le récapitulatif
        // var capturedImageData = $('#captured_image_data').val();
        // $('#recap_captured_image').attr('src', capturedImageData);

        // Mise à jour de la signature dans le récapitulatif
        var capturedSignatureData = $('#captured_signature_data').val();
        $('#recap_captured_signature').attr('src', capturedSignatureData);

    }

    function readAndPreviewLogo() {
        var logoInput = $('#logo_input')[0]; // Assurez-vous d'ajuster l'ID selon votre formulaire

        if (logoInput.files && logoInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#recap_uploaded_logo').attr('src', e.target.result);
            };

            reader.readAsDataURL(logoInput.files[0]);
        }
    }


    // Fonction pour gérer le bouton Suivant
    function handleNext() {
      var form = $('#form-pars');
      var current_fs = $(this).parent();
      var next_fs = $(this).parent().next();

      if (form.parsley().validate({ group: 'block' + step }) && step < 4) {
        // Appeler la fonction pour mettre à jour les champs de la quatrième étape
        updateRecapFields();

        current_fs.hide();
        next_fs.show();
        step++;
      }
    }

    // Fonction pour gérer le bouton Précédent
    function handlePrevious() {
      var current_fs = $(this).parent();
      var previous_fs = $(this).parent().prev();

      current_fs.hide();
      previous_fs.show();
      step--;
    }

    // Événement associé au bouton Suivant
    $('.next').click(handleNext);

    // Événement associé au bouton Précédent
    $('.previous').click(handlePrevious);

    // Empêcher la soumission du formulaire
    $('#form-pars').submit(function(e) {
      var form = $('#form-pars');
      if (form.parsley().validate({ group: 'block' + step }) && step === 4) {
        // Appeler la fonction pour mettre à jour les champs de la quatrième étape avant la soumission
        updateRecapFields();
        return true;
      } else {
        e.preventDefault(); // Empêcher la soumission du formulaire si les validations ne sont pas réussies
      }
    });
  });
</script>



<style>
    .form-section {
        display: none;
    }

    .form-section.current {
        display: block;
    }


    .recap-title {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .recap-container {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .recap-column {
        width: 48%; /* Ajustez selon votre mise en page */
    }


</style>

      <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 style="text-transform: uppercase;">Ouverture Personne morale</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <a href="{{ route('account-index') }}" class="btn btn-primary float-right">  <i class="bi bi-arrow-left"></i> Retour</a>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="row">
                    @if( session()->has('msg') )
                    <div class="col-md-12">
                      <div class="alert alert-success">{{ session()->get('msg') }}</div>
                    </div>
                    @endif 
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" id="form-pars" method="POST" action="{{route('ComptePersonneMoralValid')}}" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <input type="hidden" value="{{ $etat_juridique->id }}" name="id_personne_moral">
                                <input type="hidden" value="{{ $number_account }}" name="number_account">


                                    <!-- Page 1 -->
                                    <div class="form-section current">
                                        <div class="row">

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="numero_client" class="form-label">N° client<span class="text-danger"> *</span></label>
                                                    <input type="text" readonly id="numero" class="form-control form-control-xl" value="{{ $rander }}" name="numero_client" required data-parsley-group="block1">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ancien_numeroclient" class="form-label">Ancien N° Client</label>
                                                    <input class="form-control form-control-xl" type="number" name="ancien_numeroclient">
                                                </div>
                                            </div> 

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="compte" class="form-label">Type de compte <span class="text-danger"> *</span></label>
                                                    <select class="form-select form-control form-control-xl form-control form-control-xl-xl" id="compte" name="type_compte" required data-parsley-group="block1">
                                                        <option value="">Selectionner</option>
                                                        @foreach($type_accounts as $tc)
                                                        <option value="{{$tc->id}}">{{$tc->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="nom_entreprise" class="form-label">Nom de l'entreprise <span class="text-danger"> *</span></label>
                                                    <input type="text" id="nom_entreprise" class="form-control form-control-xl" name="nom_entreprise" required data-parsley-group="block1">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="date_ouverture_compte" class="form-label">Date d'adhésion <span class="text-danger"> *</span> </label>
                                                    <input type="date" id="date" class="form-control form-control-xl" name="date_ouverture_compte" required data-parsley-group="block1">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="date_ouverture_compte" class="form-label">Date d'ouverture de compte <span class="text-danger"> *</span></label>
                                                    <input type="text" readonly value="<?= date('d/m/Y'); ?>" id="date_ouverture_compte" class="form-control form-control-xl" name="date_ouverture_compte" required data-parsley-group="block1">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="langue_correspondance" class="form-label">Langue de correspondance <span class="text-danger"> *</span></label>
                                                    <select class="form-select form-control form-control-xl form-control form-control-xl-xl" id="langue_correspondance" name="langue_correspondance" required data-parsley-group="block1">
                                                         <option value="">Selectionner</option>
                                                         <option value="français">Français</option>
                                                         <option value="anglais">Anglais</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="logo_input" class="form-label">Télécharger le Logo</label>
                                                    <input type="file" id="logo_input" class="form-control form-control-xl" name="logo">
                                                </div>
                                            </div>

                                            
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="raison_social" class="form-label">Raison sociale <span class="text-danger"> *</span></label>
                                                    <input type="text" id="raison_social" class="form-control form-control-xl" name="raison_social" required data-parsley-group="block1">
                                                </div>
                                            </div>

                                             <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="compte" class="form-label">Abréviations</label>
                                                    <input type="text" class="form-control form-control-xl" name="abreviation">
                                                </div>
                                            </div>   


                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="adresse" class="form-label">Adresse <span class="text-danger"> *</span></label>
                                                    <input type="text" id="adresse" class="form-control form-control-xl" name="adresse" required data-parsley-group="block1">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="code_postal" class="form-label">Code postal</label>
                                                    <input type="text" id="code_postal" class="form-control form-control-xl" name="code_postal">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="ville" class="form-label">Ville</label>
                                                    <input type="text" id="ville" class="form-control form-control-xl" name="ville">
                                                </div>
                                            </div>


                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="pays" class="form-label">Pays</label>
                                                    <select class="form-select form-control form-control-xl form-control form-control-xl-xl" id="pays" name="pays">
                                                        <option value="">Selectionner</option>
                                                        <option value="burundi">Burundi</option>
                                                        <option value="cote-d'ivoire">Côte d'Ivoie</option>
                                                        <option value="france">France</option>
                                                        <option value="mali">Mali</option>
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
                                                    <label for="numero_telephone" class="form-label">N° de téléphone</label>
                                                    <input type="number" id="numero_telephone" class="form-control form-control-xl" name="numero_telephone">
                                                </div>
                                            </div>


                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="email" class="form-label">E-mail</label>
                                                    <input type="email" id="email" class="form-control form-control-xl" name="email">
                                                </div>
                                            </div>

                                                    
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="localisation_1" class="form-label">Localisation 1</label>
                                                    <input type="text" id="localisation_1" class="form-control form-control-xl" name="localisation_1">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                  <label for="localisation_2" class="form-label">Localisation 2</label>
                                                    <input type="text" id="localisation_2" class="form-control form-control-xl" name="localisation_2" data-parsley-group="block2">
                                              </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="zone" class="form-label">Zone</label>
                                                     <input type="text" id="zone" class="form-control form-control-xl" name="zone" data-parsley-group="block2">
                                                </div>
                                            </div> 


                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="commetaire_client" class="form-label">Commemtaire sur le client</label>
                                                    <textarea row="12px" class="form-control form-control-xl" name="commetaire_client">
                                                        
                                                    </textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="categorie_pm" class="form-label">Catedorie de PM <span class="text-danger">*</span></label>
                                                    <select class="form-select form-control form-control-xl form-control form-control-xl-xl" id="categorie_pm" name="categorie_pm" required data-parsley-group="block2">
                                                        <option value="">Selectionner</option>
                                                        <option value="aucun">aucun</option>
                                                        <option value="aucun">Banque</option>
                                                        <option value="aucun">Institution financière</option>
                                                        <option value="aucun">Entreprise privée</option>
                                                        <option value="aucun">Entreprise public</option>
                                                        <option value="aucun">Association sans but lucratif</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="qualite" class="form-label">Qualité <span class="text-danger"> *</span></label>
                                                    <input type="text" id="qualite" class="form-control form-control-xl" name="qualite" readonly value="Auxilliaire" required data-parsley-group="block2">
                                                </div>
                                            </div>

                                                    
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="niveau_agence" class="form-label">Niveau agence <span class="text-danger"> *</span></label>
                                                    <select class="form-select form-control form-control-xl form-control form-control-xl-xl" id="niveau_agence" name="niveau_agence" required data-parsley-group="block2">
                                                        <option value="">Selectionner</option>
                                                        <option value="aucun">Aucun</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="niveau_guichet" class="form-label">Niveau guichet <span class="text-danger"> *</span></label>
                                                    <select class="form-select form-control form-control-xl form-control form-control-xl-xl" id="niveau_guichet" name="niveau_guichet" required data-parsley-group="block2">
                                                        <option value="">Selectionner</option>
                                                        <option value="aucun">Aucun</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="numero_carte_bancaire" class="form-label">Numéro carte bancaire</label>
                                                    <input type="number" id="numero_carte_bancaire" class="form-control form-control-xl" name="numero_carte_bancaire">
                                                </div>
                                            </div> 

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="versement_initial" class="form-label">Versement initial <span class="text-danger"> *</span></label>
                                                    <input type="number" id="versement_initial" class="form-control form-control-xl" name="versement_initial" required data-parsley-group="block2" oninput="calculateVersementFinal()">
                                                </div>
                                            </div> 

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="montant_epargne" class="form-label">Montant epargne <span class="text-danger"> *</span></label>
                                                    <input type="number" id="montant_epargne" class="form-control form-control-xl" name="montant_epargne" required data-parsley-group="block2">
                                                </div>
                                            </div> 

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="total_verse" class="form-label">Total versé <span class="text-danger"> *</span></label>
                                                    <input type="number" id="total_verse" class="form-control form-control-xl" name="total_verse" required data-parsley-group="block2" oninput="calculateVersementFinal()">
                                                </div>
                                            </div> 

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="date_cloture_compte" class="form-label">Date de clôture de compte <span class="text-danger"> *</span></label>
                                                    <input type="date" id="date_cloture_compte" class="form-control form-control-xl" name="date_cloture_compte"  required data-parsley-group="block2">
                                                </div>
                                            </div> 

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="versement_final" class="form-label">Versement final <span class="text-danger"> *</span></label>
                                                    <input type="number" id="versement_final" class="form-control form-control-xl" name="versement_final" required data-parsley-group="block2" readonly>
                                                </div>
                                            </div>

                                        </div>
                                         
                                       
                                        <button type="button" class="previous btn btn-primary float-left">< Précédent</button>
                                        <button type="button" id="second-step" class="next btn btn-primary float-right">Suivant ></button> 

                                    </div>

                                    <!-- Page 3 -->
                                    <div class="form-section">
                                        <div class="row">

                                            <!-- <div class="col-lg-6 mb-4" align="center">
                                                <div id="my_camera" class="pre_capture_frame"></div>
                                                <input type="hidden" name="captured_image_data" id="captured_image_data">
                                                <br>
                                                <input type="button" class="btn btn-info btn-round btn-file" value="Prendre une photo" onClick="take_snapshot()">   
                                            </div>

                                            <div class="col-lg-6 mb-4" align="center">
                                                <div id="results">
                                                    <img style="width: 350px;" class="after_capture_frame" src="image_placeholder.jpg" />
                                                </div>
                                                <br>
                                                <button type="button" class="btn btn-success" onclick="saveSnap()">Enregistrer</button>
                                            </div> -->

                                            <div class="col-md-12 mb-4">
                                                <input type="hidden" name="captured_signature_data" id="captured_signature_data">
                                                <canvas style="border: 1px solid #cccccc;" id="signature-pad" class="signature-pad" width="400" height="200"></canvas>
                                                <button class="btn btn-danger mt-2" id="clear-signature">Effacer</button>
                                                <button class="btn btn-success mt-2" onclick="saveSignature()" id="signature">Enregistrer</button>
                                            </div>

                                        </div>

                                       <button type="button" class="previous btn btn-primary float-left">< Précédent</button>
                                        <button type="button" id="thirst-step" class="next btn btn-primary float-right">Suivant ></button>
                                    </div>

                                    <!-- Page 4 -->
                                    <div class="form-section">
                                        <h2 class="recap-title">Récapitulatif des informations</h2>
                                        
                                        <div class="recap-container">
                                            <div class="recap-column">
                                                <p><strong>N° client:</strong> <span id="recap_numero_client"></span></p>
                                                <p><strong>Type de compte:</strong> <span id="recap_type_compte"></span></p>
                                                <p><strong>Ancien N° Client:</strong> <span id="recap_ancien_numero_client"></span></p>
                                                <p><strong>Nom de l'entreprise:</strong> <span id="recap_nom_entreprise"></span></p>
                                                <p><strong>Date d'ouverture de compte:</strong> <span id="recap_date_ouverture_compte"></span></p>
                                                <p><strong>Langue de correspondance:</strong> <span id="recap_langue_correspondance"></span></p>
                                                <p><strong>Raison sociale:</strong> <span id="recap_raison_sociale"></span></p>
                                                <p><strong>Abréviations:</strong> <span id="recap_abreviation"></span></p>
                                                <p><strong>Adresse:</strong> <span id="recap_adresse"></span></p>
                                                <p><strong>Code postal:</strong> <span id="recap_code_postal"></span></p>
                                                <p><strong>Ville:</strong> <span id="recap_ville"></span></p>
                                                <p><strong>Pays:</strong> <span id="recap_pays"></span></p>
                                                <p><strong>N° de téléphone:</strong> <span id="recap_numero_telephone"></span></p>
                                                <p><strong>E-mail:</strong> <span id="recap_email"></span></p>
                                                <p><strong>Localisation 1:</strong> <span id="recap_localisation_1"></span></p>
                                                <p><strong>Logo:</strong></p>
                                                    <img id="recap_uploaded_logo" style="width: 150px; height: 150px;" src="image_placeholder.jpg" alt="Logo du client">

                                            </div>
                                            <div class="recap-column">
                                                <p><strong>Localisation 2:</strong> <span id="recap_localisation_2"></span></p>
                                                <p><strong>Zone:</strong> <span id="recap_zone"></span></p>
                                                <p><strong>Commentaire sur le client:</strong> <span id="recap_commentaire_client"></span></p>
                                                <p><strong>Catégorie de PM:</strong> <span id="recap_categorie_pm"></span></p>
                                                <p><strong>Qualité:</strong> <span id="recap_qualite"></span></p>
                                                <p><strong>Niveau agence:</strong> <span id="recap_niveau_agence"></span></p>
                                                <p><strong>Niveau guichet:</strong> <span id="recap_niveau_guichet"></span></p>
                                                <p><strong>Numéro carte bancaire:</strong> <span id="recap_numero_carte_bancaire"></span></p>
                                                <p><strong>Versement initial:</strong> <span id="recap_versement_initial"></span></p>
                                                <p><strong>Montant épargne:</strong> <span id="recap_montant_epargne"></span></p>
                                                <p><strong>Total versé:</strong> <span id="recap_total_verse"></span></p>
                                                <p><strong>Date de clôture de compte:</strong> <span id="recap_date_cloture_compte"></span></p>
                                                <p><strong>Versement final:</strong> <span id="recap_versement_final"></span></p>
                                                <p><strong>Signature:</strong></p>
                                                    <img id="recap_captured_signature" style="width: 150px; height: 150px; border: 1px solid #cccccc;" src="image_placeholder.jpg" alt="Signature du client">

    
                                            </div>


                                        </div>

                                         <button type="button" class="previous btn btn-primary float-left mt-5">< Précédent</button>
                                        <button type="submit" class="btn btn-primary me-1 mb-1 mt-5">Valider</button>
                                    </div>
                                       
                            </form>
                        </div>

                    </div>
                </div>
             </div>
        </div>
    </section>
    @endsection

    @section('js')

    <!-- CALCUL TOTAL VERSE -->

    <script>
        function calculateVersementFinal() {

            var versementInitial = parseFloat(document.getElementById('versement_initial').value) || 0;
            var montantEpargne = parseFloat(document.getElementById('montant_epargne').value) || 0;
            var totalVerse = parseFloat(document.getElementById('total_verse').value) || 0;

            var versementFinal = versementInitial + totalVerse;

            document.getElementById('versement_final').value = versementFinal;
        }
    </script>

    <!-- PHOTO -->

    <!-- Required library for webcam -->
    <!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.24/webcam.js"></script>
       
    <script language="JavaScript">
         // Configure a few settings and attach camera 250x187
         Webcam.set({
          width: 350,
          height: 287,
          image_format: 'jpeg',
          jpeg_quality: 90
         });     
         Webcam.attach( '#my_camera' );
        
        function take_snapshot() {
         // play sound effect
         //shutter.play();
         // take snapshot and get image data
         Webcam.snap( function(data_uri) {
         // display results in page
         document.getElementById('results').innerHTML = 
          '<img class="after_capture_frame" src="'+data_uri+'"/>';
         $("#captured_image_data").val(data_uri);
         });     
        }

        function saveSnap(){
        var base64data = $("#captured_image_data").val();
         $.ajax({
                type: "POST",
                dataType: "json",
                url: "capture_image_upload.php",
                data: {image: base64data},
                success: function(data) { 
                    alert(data);
                }
            });
        }

    </script> -->


    <!-- SIGNATURE -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>

    <script type="text/javascript">
        var canvas = document.getElementById('signature-pad');
        
        // Assurez-vous que nous dessinons correctement sur le canvas en ajustant les dimensions pour les DPI de l'écran
        function resizeCanvas() {
            var ratio =  Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
        }

        window.onresize = resizeCanvas;
        resizeCanvas();

        // Créez une instance de SignaturePad
        var signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255, 255, 255, 0)', // Mettez un fond blanc pour la signature
            penColor: 'rgb(0, 0, 0)'
        });

        // Trouvez le bouton Effacer par son ID
        var clearButton = document.getElementById('clear-signature');

        // Ajoutez un gestionnaire d'événements pour le clic sur le bouton Effacer
        clearButton.addEventListener('click', function () {
            signaturePad.clear(); // Efface la zone de signature
        });

   
        function saveSignature() {
            var dataURL = signaturePad.toDataURL('image/png');
            document.getElementById('captured_signature_data').value = dataURL; 
        }

    </script>
    @endsection