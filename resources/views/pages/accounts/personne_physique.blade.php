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

    var step = 1;

    $('#form-pars fieldset:not(:first-child)').hide();

    // Fonction pour mettre à jour les champs de la quatrième étape
    function updateRecapFields() {
        // Page 1 Recap
        var numeroClientRecap = $('#numero').val();
        var ancienNumeroClientRecap = $('input[name="ancien_numeroclient"]').val();
        var typeCompteRecap = $('#compte').val();
        var dateOuvertureCompteRecap = $('#date').val();
        var langueCorrespondanceRecap = $('#lang').val();
        var nomRecap = $('#nom').val();
        var prenomRecap = $('#prenom').val();
        var dateNaissanceRecap = $('#date_naissance').val();
        var adresseRecap = $('#adresse').val();
        var lieuNaissanceRecap = $('#lieu_naissance').val();
        var paysNationaliteRecap = $('#pays_nationalite').val();
        var paysNaissanceRecap = $('#pays_naissance').val();
        var sexesRecap = $('#sexes').val();
        var matriculeRecap = $('#matricule').val();

        // Mettez à jour les champs de la première étape dans le récapitulatif
        $('#recap_numero_client').text(numeroClientRecap);
        $('#recap_ancien_numero_client').text(ancienNumeroClientRecap);
        $('#recap_type_compte').text(typeCompteRecap);
        $('#recap_date_ouverture_compte').text(dateOuvertureCompteRecap);
        $('#recap_lang').text(langueCorrespondanceRecap);
        $('#recap_nom').text(nomRecap);
        $('#recap_prenom').text(prenomRecap);
        $('#recap_date_naissance').text(dateNaissanceRecap);
        $('#recap_adresse').text(adresseRecap);
        $('#recap_lieu_naissance').text(lieuNaissanceRecap);
        $('#recap_pays_nationalite').text(paysNationaliteRecap);
        $('#recap_pays_naissance').text(paysNaissanceRecap);
        $('#recap_sexes').text(sexesRecap);
        $('#recap_matricule').text(matriculeRecap);

        // Page 2 Recap
        var typePieceRecap = $('#type_piece').val();
        var numeroCNIRecap = $('#numero_cni').val();
        var etatCivilRecap = $('#etat_civil').val();
        var nombreEnfantRecap = $('#nmbre_enfant').val();
        var villeRecap = $('#ville').val();
        var codePostalRecap = $('#code_postal').val();
        var paysRecap = $('#pays').val();
        var telephoneRecap = $('#telephone').val();
        var emailRecap = $('#email').val();
        var employeurRecap = $('#employeur').val();
        var fonctionEmployeurRecap = $('#fonction_employeur').val();
        var qualiteRecap = $('#qualite').val();

        // Mettez à jour les champs de la deuxième étape dans le récapitulatif
        $('#recap_type_piece').text(typePieceRecap);
        $('#recap_numero_cni').text(numeroCNIRecap);
        $('#recap_etat_civil').text(etatCivilRecap);
        $('#recap_nmbre_enfant').text(nombreEnfantRecap);
        $('#recap_ville').text(villeRecap);
        $('#recap_code_postal').text(codePostalRecap);
        $('#recap_pays').text(paysRecap);
        $('#recap_telephone').text(telephoneRecap);
        $('#recap_email').text(emailRecap);
        $('#recap_employeur').text(employeurRecap);
        $('#recap_fonction_employeur').text(fonctionEmployeurRecap);
        $('#recap_qualite').text(qualiteRecap);


        // Page 3 Recap
        var nomConjointRecap = $('#nom_conjoint').val();
        var nomPrenomSignataire1Recap = $('#nom_prenom_signataire1').val();
        var cniSignataire1Recap = $('#cni_signataire1').val();
        var telephoneSignataire1Recap = $('#telephone_signataire1').val();
        var nomPrenomSignataire2Recap = $('#nom_prenom_signataire2').val();
        var cniSignataire2Recap = $('#cni_signataire2').val();
        var telephoneSignataire2Recap = $('#telephone_signataire2').val();
        var nomPrenomSignataire3Recap = $('#nom_prenom_signataire3').val();
        var cniSignataire3Recap = $('#cni_signataire3').val();
        var telephoneSignataire3Recap = $('#telephone_signataire3').val();
        var pouvoirSignatairesRecap = $('#pouvoir_signataires').val();
        var nomHeritier1Recap = $('#nom_heritier1').val();
        var nomHeritier2Recap = $('#nom_heritier2').val();
        var nomHeritier3Recap = $('#nom_heritier3').val();

        // Mettez à jour les champs de la troisième étape dans le récapitulatif
        $('#recap_nom_conjoint').text(nomConjointRecap);
        $('#recap_nom_prenom_signataire1').text(nomPrenomSignataire1Recap);
        $('#recap_cni_signataire1').text(cniSignataire1Recap);
        $('#recap_telephone_signataire1').text(telephoneSignataire1Recap);
        $('#recap_nom_prenom_signataire2').text(nomPrenomSignataire2Recap);
        $('#recap_cni_signataire2').text(cniSignataire2Recap);
        $('#recap_telephone_signataire2').text(telephoneSignataire2Recap);
        $('#recap_nom_prenom_signataire3').text(nomPrenomSignataire3Recap);
        $('#recap_cni_signataire3').text(cniSignataire3Recap);
        $('#recap_telephone_signataire3').text(telephoneSignataire3Recap);
        $('#recap_pouvoir_signataires').text(pouvoirSignatairesRecap);
        $('#recap_nom_heritier1').text(nomHeritier1Recap);
        $('#recap_nom_heritier2').text(nomHeritier2Recap);
        $('#recap_nom_heritier3').text(nomHeritier3Recap);

        // Page 4 Recap
        var nomMandataireRecap = $('#nom_mandataire').val();
        var cniMandataireRecap = $('#cni_mandataire').val();
        var telephoneMandataireRecap = $('#telephone_mandataire').val();
        var niveauAgenceRecap = $('#niveau_agence').val();
        var niveauGuichetRecap = $('#niveau_guichet').val();
        var versementInitialRecap = $('#versement_initial').val();
        var montantEpargneRecap = $('#montant_epargne').val();
        var totalVerseRecap = $('#total_verse').val();
        var dateClotureCompteRecap = $('#date_cloture_compte').val();
        var versementFinalRecap = $('#versement_final').val();

        // Mettez à jour les champs de la quatrième étape dans le récapitulatif
        $('#recap_nom_mandataire').text(nomMandataireRecap);
        $('#recap_cni_mandataire').text(cniMandataireRecap);
        $('#recap_telephone_mandataire').text(telephoneMandataireRecap);
        $('#recap_niveau_agence').text(niveauAgenceRecap);
        $('#recap_niveau_guichet').text(niveauGuichetRecap);
        $('#recap_versement_initial').text(versementInitialRecap);
        $('#recap_montant_epargne').text(montantEpargneRecap);
        $('#recap_total_verse').text(totalVerseRecap);
        $('#recap_date_cloture_compte').text(dateClotureCompteRecap);
        $('#recap_versement_final').text(versementFinalRecap);

        // Mise à jour de la photo dans le récapitulatif
        var capturedImageData = $('#captured_image_data').val();
        $('#recap_captured_image').attr('src', capturedImageData);

        // Mise à jour de la signature dans le récapitulatif
        var capturedSignatureData = $('#captured_signature_data').val();
        $('#recap_captured_signature').attr('src', capturedSignatureData);


    }


    // Fonction pour gérer le bouton Suivant
    function handleNext() {
      var form = $('#form-pars');
      var current_fs = $(this).parent();
      var next_fs = $(this).parent().next();

      if (form.parsley().validate({ group: 'block' + step }) && step < 6) {
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
      if (form.parsley().validate({ group: 'block' + step }) && step === 6) {
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

    <style>
        .form-section {
            display: none;
        }

        .form-section.current {
            display: block;
        }
    </style>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3 style="text-transform: uppercase;">Ouverture personne physique</h3>
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
                            <form class="form" id="form-pars" method="POST" action="{{route('ComptePersonnePhysiqueValid')}}" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <input type="hidden" value="{{ $etat_juridique->id }}" name="id_personne_physique">

                                <input type="hidden" value="{{ $number_account }}" name="number_account">
                                

                                <!-- Page 1 -->
                                <div class="form-section current">
                                    <div class="row">


                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="numero_client" class="form-label">N° client<span class="text-danger"> *</span></label>
                                                <input type="text" id="numero" class="form-control form-control-xl" value="{{ $rander }}" name="numero_client" required data-parsley-group="block1">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="ancien_numeroclient" class="form-label">Ancien N° Client</label>
                                                <input class="form-control form-control-xl" type="number" name="ancien_numeroclient">
                                            </div>
                                        </div>

                                        <!-- <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="numero" class="form-label">Numéro de compte <span class="text-danger"> *</span></label>
                                                <input type="number" id="numero" class="form-control form-control-xl" value="{{ $rander }}" name="numero_compte" required data-parsley-group="block1">
                                            </div>
                                        </div> -->

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="compte" class="form-label">Type de compte <span class="text-danger"> *</span></label>
                                                <select class="form-select form-control form-control-xl" id="compte" name="type_compte" required data-parsley-group="block1">
                                                    <option value="">Selectionner</option>
                                                    @foreach($type_accounts as $tc)
                                                    <option value="{{$tc->id}}">{{$tc->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>                  

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="date" class="form-label">Date d'ouverture de compte <span class="text-danger"> *</span></label>
                                                <input type="text" value="<?= date('d/m/Y'); ?>" readonly id="date" class="form-control form-control-xl" name="date_ouverture_compte" required data-parsley-group="block1">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="lang" class="form-label">Langue de correspondance <span class="text-danger"> *</span></label>
                                                <select class="form-select form-control form-control-xl" id="lang" name="lang" required data-parsley-group="block1">
                                                    <option value="">Selectionner</option>
                                                    <option value="français">Français</option>
                                                    <option value="anglais">Anglais</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="matricule" class="form-label">Numéro matricule</label>
                                                <input type="text" id="matricule" class="form-control form-control-xl" name="matricule">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="nom" class="form-label">Nom <span class="text-danger"> *</span></label>
                                                <input type="text" id="nom" class="form-control form-control-xl" name="nom" required data-parsley-group="block1">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="prenom" class="form-label">Prénom(s) <span class="text-danger"> *</span></label>
                                                <input type="text" id="prenom" class="form-control form-control-xl" name="prenom" required data-parsley-group="block1">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                              <label for="date_naissance" class="form-label">Date de naissance <span class="text-danger"> *</span></label>
                                                <input type="date" id="date_naissance" class="form-control form-control-xl" name="date_naissance" required data-parsley-group="block1">
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
                                                <label for="lieu_naissance" class="form-label">Lieu de naissance <span class="text-danger"> *</span></label>
                                                <input type="text" id="lieu_naissance" class="form-control form-control-xl" name="lieu_naissance" required data-parsley-group="block1">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="pays_nationalite" class="form-label">Pays de nationalité</label>
                                                <select class="form-select form-control form-control-xl" id="pays_nationalite" name="pays_nationalite">
                                                    <option value="">Selectionner</option>
                                                    <option value="burundi">Burundi</option>
                                                    <option value="cote-d'ivoire">Côte d'Ivoie</option>
                                                    <option value="france">France</option>
                                                    <option value="mali">Mali</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="pays_naissance" class="form-label">Pays de naissance</label>
                                                <select class="form-select form-control form-control-xl" id="pays_naissance" name="pays_naissance">
                                                    <option value="">Selectionner</option>
                                                    <option value="burundi">Burundi</option>
                                                    <option value="cote-d'ivoire">Côte d'Ivoie</option>
                                                    <option value="france">France</option>
                                                    <option value="mali">Mali</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="sexes" class="form-label">Sexes <span class="text-danger"> *</span></label>
                                                <select class="form-select form-control form-control-xl" id="sexes" name="sexes" required data-parsley-group="block1">
                                                    <option value="">Selectionner</option>
                                                    @foreach($sexes as $s)
                                                    <option value="{{$s->id}}">{{$s->name}}</option>
                                                    @endforeach
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
                                                <label for="type_piece" class="form-label">Type de pièce d'identité <span class="text-danger"> *</span></label>
                                                <select class="form-select form-control form-control-xl" id="type_piece" name="type_piece" required data-parsley-group="block2">
                                                    <option value="">Selectionner</option>
                                                    <option value="cni">CNI</option>
                                                    <option value="attestation">Attestion</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="numero_cni" class="form-label">Numéro de pièce d'identité <span class="text-danger"> *</span></label>
                                                <input type="text" id="numero_cni" class="form-control form-control-xl" name="numero_cni" required data-parsley-group="block2">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="etat_civil" class="form-label">Etat- Civil <span class="text-danger"> *</span></label>
                                                <select class="form-select form-control form-control-xl" id="etat_civil" name="etat_civil" required data-parsley-group="block2">
                                                    <option value="">Selectionner</option>
                                                    <option value="Célibataire">Célibataire</option>
                                                    <option value="Marié">Marié(e)</option>
                                                    <option value="Divorcé">Divorcé(e)</option>
                                                    <option value="Veuf">Veuf(Veuve)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="nmbre_enfant" class="form-label">Nombre d'enfant</label>
                                                <input type="number" id="nmbre_enfant" class="form-control form-control-xl" name="nmbre_enfant">
                                            </div>
                                        </div>

                                        
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="ville" class="form-label">Ville </span></label>
                                                <input type="text" id="ville" class="form-control form-control-xl" name="ville">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="code_postal" class="form-label">Code postal </span></label>
                                                <input type="text" id="code_postal" class="form-control form-control-xl" name="code_postal">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="pays" class="form-label">Pays</label>
                                                <select class="form-select form-control form-control-xl" id="pays" name="pays">
                                                    <option value="">Selectionner</option>
                                                    <option value="burundi">Burundi</option>
                                                    <option value="cote-d'ivoire">Côte d'Ivoie</option>
                                                    <option value="france">France</option>
                                                    <option value="mali">Mali</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="telephone" class="form-label">Numéro téléphone</label>
                                                <input type="number" id="telephone" class="form-control form-control-xl" name="telephone">
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
                                                <label for="employeur" class="form-label">Employeur</label>
                                                <input type="text" id="employeur" class="form-control form-control-xl" name="employeur">
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="fonction_employeur" class="form-label">Fonction de l'employeur</label>
                                                <input type="text" id="fonction_employeur" class="form-control form-control-xl" name="fonction_employeur">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="nom_conjoint" class="form-label">Nom du Conjoint</label>
                                                 <input type="text" id="nom_conjoint" class="form-control form-control-xl" name="nom_conjoint">
                                            </div>
                                        </div>


                                    </div>

                                    <button type="button" class="previous btn btn-primary float-left">< Précédent</button>
                                    <button type="button" id="second-step" class="next btn btn-primary float-right">Suivant ></button>                                         
                                </div>

                                <!-- Page 3 -->
                                <div class="form-section">
                                      <div class="row">

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="qualite" class="form-label">Qualité <span class="text-danger"> *</span></label>
                                                <input type="text" id="qualite" class="form-control form-control-xl" name="qualite" readonly value="Auxilliaire" required data-parsley-group="block3">
                                            </div>
                                        </div>

                                       <div class="col-md-6 col-12">
                                           <div class="form-group">
                                               <label for="nom_prenom_signataire1" class="form-label">Nom et Prénoms du Signataire 1 <span class="text-danger"> *</span></label>
                                               <input type="text" id="nom_prenom_signataire1" class="form-control form-control-xl" name="nom_prenom_signataire1" required data-parsley-group="block3">
                                           </div>
                                       </div>

                                       <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="cni_signataire1" class="form-label">CNI Signataire 1 <span class="text-danger"> *</span></label>
                                                <input type="text" id="cni_signataire1" class="form-control form-control-xl" name="cni_signataire1" required data-parsley-group="block3">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="telephone_signataire1" class="form-label">Telephone Signataire 1 <span class="text-danger"> *</span></label>
                                                <input type="number" id="telephone_signataire1" class="form-control form-control-xl" name="telephone_signataire1" required data-parsley-group="block3">
                                            </div>
                                        </div>

                                          <div class="col-md-6 col-12">
                                              <div class="form-group">
                                                  <label for="nom_prenom_signataire2" class="form-label">Nom et Prénoms du Signataire 2</label>
                                                  <input type="text" id="nom_prenom_signataire2" class="form-control form-control-xl" name="nom_prenom_signataire2">
                                              </div>
                                          </div>

                                          <div class="col-md-6 col-12">
                                              <div class="form-group">
                                                <label for="cni_signataire2" class="form-label">CNI Signataire 2 </label>
                                                  <input type="text" id="cni_signataire2" class="form-control form-control-xl" name="cni_signataire2">
                                            </div>
                                          </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="telephone_signataire2" class="form-label">Telephone Signataire 2</label>
                                                    <input type="number" id="telephone_signataire2" class="form-control form-control-xl" name="telephone_signataire2">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                  <label for="nom_prenom_signataire3" class="form-label">Nom et Prénoms du Signataire 3</label>
                                                  <input type="text" id="nom_prenom_signataire3" class="form-control form-control-xl" name="nom_prenom_signataire3">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="cni_signataire3" class="form-label">CNI Signataire 3 </label>
                                                    <input type="text" id="cni_signataire3" class="form-control form-control-xl" name="cni_signataire3">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="telephone_signataire3" class="form-label">Telephone Signataire 3</label>
                                                    <input type="number" id="telephone_signataire3" class="form-control form-control-xl" name="telephone_signataire3">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="pouvoir_signataires" class="form-label">Pouvoir des signataires <span class="text-danger"> *</span></label>
                                                    <select class="form-select form-control form-control-xl" id="pouvoir_signataires" name="pouvoir_signataires" required data-parsley-group="block3">
                                                        <option value="">Selectionner</option>
                                                        <option value="Célibataire">Seul sans limite</option>
                                                        <option value="Deux à Deux">Deux à Deux</option>
                                                        <option value="Conjointement">Conjointement</option>
                                                        <option value="L'une des signatures">L'une des signatures</option>
                                                    </select>
                                                </div>
                                            </div>  

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="nom_heritier1" class="form-label">Nom de l'héritier 1 <span class="text-danger"> *</span></label>
                                                    <input type="text" id="nom_heritier1" class="form-control form-control-xl" name="nom_heritier1" required data-parsley-group="block3">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="nom_heritier2" class="form-label">Nom de l'héritier 2 </label>
                                                    <input type="text" id="nom_heritier2" class="form-control form-control-xl" name="nom_heritier2">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="nom_heritier3" class="form-label">Nom de l'héritier 3 </label>
                                                    <input type="text" id="nom_heritier3" class="form-control form-control-xl" name="nom_heritier3">
                                                </div>
                                            </div>

                                          
                                      </div>

                                        <button type="button" class="previous btn btn-primary float-left">< Précédent</button>
                                        <button type="button" id="third-step" class="next btn btn-primary float-right">Suivant ></button>                                         
                                </div>

                                <!-- Page 4 -->
                                <div class="form-section">
                                    <div class="row">

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="nom_mandataire" class="form-label">Nom du Mandataire <span class="text-danger"> *</span></label>
                                                <input type="text" id="nom_mandataire" class="form-control form-control-xl" name="nom_mandataire" required data-parsley-group="block4">
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="cni_mandataire" class="form-label">CNI du Mandataire <span class="text-danger"> *</span></label>
                                                  <input type="text" id="cni_mandataire" class="form-control form-control-xl" name="cni_mandataire"  required data-parsley-group="block4">
                                            </div>
                                        </div> 

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                 <label for="telephone" class="form-label">Telephone du Mandataire <span class="text-danger"> *</span></label>
                                                <input type="number" id="telephone" class="form-control form-control-xl" name="telephone_mandataire"  required data-parsley-group="block4">
                                            </div>
                                        </div> 

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="niveau_agence" class="form-label">Niveau agence <span class="text-danger"> *</span></label>
                                                <select class="form-select form-control form-control-xl" id="niveau_agence" name="niveau_agence" required data-parsley-group="block4">
                                                    <option value="">Selectionner</option>
                                                    <option value="Aucun">Aucun</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="niveau_guichet" class="form-label">Niveau guichet <span class="text-danger"> *</span></label>
                                                <select class="form-select form-control form-control-xl" id="niveau_guichet" name="niveau_guichet" required data-parsley-group="block4">
                                                    <option value="">Selectionner</option>
                                                    <option value="Aucun">Aucun</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="versement_initial" class="form-label">Versement initial <span class="text-danger"> *</span></label>
                                                    <input type="number" id="versement_initial" class="form-control form-control-xl" name="versement_initial" required data-parsley-group="block4" oninput="calculateVersementFinal()">
                                                </div>
                                            </div> 

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="montant_epargne" class="form-label">Montant epargne <span class="text-danger"> *</span></label>
                                                    <input type="number" id="montant_epargne" class="form-control form-control-xl" name="montant_epargne" required data-parsley-group="block4">
                                                </div>
                                            </div> 

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="total_verse" class="form-label">Total versé <span class="text-danger"> *</span></label>
                                                    <input type="number" id="total_verse" class="form-control form-control-xl" name="total_verse" required data-parsley-group="block4" oninput="calculateVersementFinal()">
                                                </div>
                                            </div> 

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="date_cloture_compte" class="form-label">Date de clôture de compte <span class="text-danger"> *</span></label>
                                                    <input type="date" id="date_cloture_compte" class="form-control form-control-xl" name="date_cloture_compte"  required data-parsley-group="block4">
                                                </div>
                                            </div> 

                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="versement_final" class="form-label">Versement final <span class="text-danger"> *</span></label>
                                                    <input type="number" id="versement_final" class="form-control form-control-xl" name="versement_final" required data-parsley-group="block4" readonly>
                                                </div>
                                            </div>

                                    </div>

                                    <button type="button" class="previous btn btn-primary float-left">< Précédent</button>
                                    <button type="button" id="fourth-step" class="next btn btn-primary float-right">Suivant ></button>
                            
                                </div>

                                <!-- Page 5 -->

                                <div class="form-section">
                                    <div class="row">

                                        <div class="col-lg-6 mb-4" align="center">
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
                                        </div>

                                        <div class="col-md-12 mb-4">
                                            <input type="hidden" name="captured_signature_data" id="captured_signature_data">
                                            <canvas style="border: 1px solid #cccccc;" id="signature-pad" class="signature-pad" width="400" height="200"></canvas>
                                            <button class="btn btn-danger mt-2" id="clear-signature">Effacer</button>
                                            <button class="btn btn-success mt-2" onclick="saveSignature()" id="signature">Enregistrer</button>
                                        </div>

                                    </div>

                                    <button type="button" class="previous btn btn-primary float-left">< Précédent</button>
                                        <button type="button" id="fifth-step" class="next btn btn-primary float-right">Suivant ></button>
                                    </div>

                                    <!-- Page 6 -->
                                    <div class="form-section">
                                        <h2 class="recap-title">Récapitulatif des informations</h2>

                                        <div class="recap-container">
                                            <div class="recap-column">
                                                <p><strong>N° client:</strong> <span id="recap_numero_client"></span></p>
                                                <p><strong>Ancien N° client:</strong> <span id="recap_ancien_numero_client"></span></p>
                                                <p><strong>Type de compte:</strong> <span id="recap_type_compte"></span></p>
                                                <p><strong>Date d'ouverture de compte:</strong> <span id="recap_date_ouverture_compte"></span></p>
                                                <p><strong>Langue:</strong> <span id="recap_lang"></span></p>
                                                <p><strong>Matricule:</strong> <span id="recap_matricule"></span></p>
                                                <p><strong>Nom:</strong> <span id="recap_nom"></span></p>
                                                <p><strong>Prénom(s):</strong> <span id="recap_prenom"></span></p>
                                                <p><strong>Date de naissance:</strong> <span id="recap_date_naissance"></span></p>
                                                <p><strong>Adresse:</strong> <span id="recap_adresse"></span></p>
                                                <p><strong>Lieu de naissance:</strong> <span id="recap_lieu_naissance"></span></p>
                                                <p><strong>Pays de nationalité:</strong> <span id="recap_pays_nationalite"></span></p>
                                                <p><strong>Pays de naissance:</strong> <span id="recap_pays_naissance"></span></p>
                                                <p><strong>Sexe:</strong> <span id="recap_sexes"></span></p>
                                                <p><strong>Type de pièce d'identité:</strong> <span id="recap_type_piece"></span></p>
                                                <p><strong>Numéro de pièce d'identité:</strong> <span id="recap_numero_cni"></span></p>
                                                <p><strong>État civil:</strong> <span id="recap_etat_civil"></span></p>
                                                <p><strong>Nombre d'enfant:</strong> <span id="recap_nmbre_enfant"></span></p>
                                                <p><strong>Ville:</strong> <span id="recap_ville"></span></p>
                                                <p><strong>Code postal:</strong> <span id="recap_code_postal"></span></p>
                                                <p><strong>Pays:</strong> <span id="recap_pays"></span></p>
                                                <p><strong>Numéro de téléphone:</strong> <span id="recap_telephone"></span></p>
                                                <p><strong>Photo:</strong></p>
                                                    <img id="recap_captured_image" style="width: 150px; height: 150px;" src="image_placeholder.jpg" alt="Photo du client">
                                            </div>
                                            <div class="recap-column">
                                                <p><strong>E-mail:</strong> <span id="recap_email"></span></p>
                                                <p><strong>Employeur:</strong> <span id="recap_employeur"></span></p>
                                                <p><strong>Fonction de l'employeur:</strong> <span id="recap_fonction_employeur"></span></p>
                                                <p><strong>Nom du Conjoint:</strong> <span id="recap_nom_conjoint"></span></p>
                                                <p><strong>Nom et Prénoms du Signataire 1:</strong> <span id="recap_nom_prenom_signataire1"></span></p>
                                                <p><strong>CNI Signataire 1:</strong> <span id="recap_cni_signataire1"></span></p>
                                                <p><strong>Téléphone Signataire 1:</strong> <span id="recap_telephone_signataire1"></span></p>
                                                <p><strong>Nom et Prénoms du Signataire 2:</strong> <span id="recap_nom_prenom_signataire2"></span></p>
                                                <p><strong>CNI Signataire 2:</strong> <span id="recap_cni_signataire2"></span></p>
                                                <p><strong>Téléphone Signataire 2:</strong> <span id="recap_telephone_signataire2"></span></p>
                                                <p><strong>Nom et Prénoms du Signataire 3:</strong> <span id="recap_nom_prenom_signataire3"></span></p>
                                                <p><strong>CNI Signataire 3:</strong> <span id="recap_cni_signataire3"></span></p>
                                                <p><strong>Téléphone Signataire 3:</strong> <span id="recap_telephone_signataire3"></span></p>
                                                <p><strong>Pouvoir des signataires:</strong> <span id="recap_pouvoir_signataires"></span></p>
                                                <p><strong>Nom de l'héritier 1:</strong> <span id="recap_nom_heritier1"></span></p>
                                                <p><strong>Nom de l'héritier 2:</strong> <span id="recap_nom_heritier2"></span></p>
                                                <p><strong>Nom de l'héritier 3:</strong> <span id="recap_nom_heritier3"></span></p>
                                                <p><strong>Nom du Mandataire:</strong> <span id="recap_nom_mandataire"></span></p>
                                                <p><strong>CNI du Mandataire:</strong> <span id="recap_cni_mandataire"></span></p>
                                                <p><strong>Téléphone du Mandataire:</strong> <span id="recap_telephone_mandataire"></span></p>
                                                <p><strong>Qualité:</strong> <span id="recap_qualite"></span></p>
                                                <p><strong>Niveau agence:</strong> <span id="recap_niveau_agence"></span></p>
                                                <p><strong>Niveau guichet:</strong> <span id="recap_niveau_guichet"></span></p>
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

        <!-- Required library for webcam -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.24/webcam.js"></script>
       
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
    </script>

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