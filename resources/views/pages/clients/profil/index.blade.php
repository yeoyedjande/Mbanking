@extends('layouts.template')

@section('title', 'Profil Utilisateur')

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


  .profile-pic {
    border: 2px solid #ccc;
    border-radius: 50%;
    cursor: pointer;
    transition: opacity 0.2s ease-in-out;
  }
  .profile-pic:hover {
    opacity: 0.7;
  }
  .profile-pic-container {
    position: relative;
    display: inline-block;
  }
  .camera-icon {
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    background-color: #fff;
    border-radius: 50%;
    padding: 5px;
    display: none;
  }
  .profile-pic-container:hover .camera-icon {
    display: block;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
  }

  td, th {
    border: 0px solid #ddd;
    padding: 8px;
    text-align: left;
  }

  td:first-child, th:first-child {
    width: 50%;
  }

  .btn-container {
    display: flex;
    justify-content: flex-end;

  }

  .btn {
    margin-left: 10px;
  }

</style>



<script src="assets/js/initTheme.js"></script>


      <section id="multiple-column-form">
        <div class="row match-height">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <span>Profil</span>
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#change_password">
                <i class="bi bi-pencil"></i> Modifier Mot de Passe
                </button>
              </div>
              <div class="card-body">
                <section class="section">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-header">
                          <div class="profile-pic-container">
                            <img class="profile-pic" src="assets/images/faces/2.jpg" alt="Photo de profil" width="250" height="250">
                            <div class="camera-icon">
                              <i class="bi bi-camera" aria-hidden="true"></i>
                            </div>
                          </div>
                          <h6><br>Modifier la photo de profil</h6>
                        </div>
                        <input type="file" id="profile-pic-input" style="display:none">
                      </div>
                    </div>
                    @foreach ($client as $client)
                    @if ($client->prenom == 'Romuald')
                    <div class="col-md-6">
                      <div class="card">
                        <div class="card-header">
                          <h1 class="card-title">{{ $client->nom }} {{ $client->prenom }}</h1>
                        </div>
                        <div class="card-body">
                          <div class="col-md-9">
                            <h4>{{ $client->nom }} {{ $client->prenom }}</h4>
                            <p><strong>Email:</strong> {{ $client->email }}</p>
                            <p><strong>Type de compte:</strong> {{ $client->type_compte }}</p>
                            <p><strong>Date d'ouverture du compte:</strong> {{ $client->date_ouverture_compte }}</p>
                            <hr>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
              </div>
            </div>
          </div>
        </div>
      </section>


      <div class="page-heading">
          <section class="section">
            <div class="row">
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Informations personnelles du client</h4>
                  </div>
                  <div class="card-body">
                    <table>
                      <tbody>
                        <tr>
                          <td>Nom:</td>
                          <td>{{ $client->nom }}</td>
                        </tr>
                        <tr>
                          <td>Prénom:</td>
                          <td>{{ $client->prenom }}</td>
                        </tr>
                        <tr>
                          <td>Nationalité:</td>
                          <td>{{ $client->nationalite }}</td>
                        </tr>
                        <tr>
                          <td>CNI:</td>
                          <td>{{ $client->cni_client }}</td>
                        </tr>
                        <tr>
                          <td>Date de naissance:</td>
                          <td>{{ $client->date_naissance }}</td>
                        </tr>
                        <tr>
                          <td>Lieu de naissance:</td>
                          <td>{{ $client->lieu_naissance }}</td>
                        </tr>
                        <tr>
                          <td>Etat- Civil:</td>
                          <td>{{ $client->etat_civil }}</td>
                        </tr>
                        <tr>
                          <td>Téléphone:</td>
                          <td>{{ $client->telephone }}</td>
                        </tr>
                        <tr>
                          <td>Adresse:</td>
                          <td>{{ $client->adresse }}</td>
                        </tr>
                        <tr>
                          <td>Résidence:</td>
                          <td>{{ $client->residence }}</td>
                        </tr>
                        <tr>
                          <td>Ville:</td>
                          <td>{{ $client->ville }}</td>
                        </tr>
                        <tr>
                          <td>Commune:</td>
                          <td>{{ $client->commune }}</td>
                        </tr>
                        <tr>
                          <td>Quartier:</td>
                          <td>{{ $client->quartier }}</td>
                        </tr>
                      </tbody>
                    </table>

                      <div class="btn-container">
                        <a href="javascript(0);" class="btn icon icon-left btn-primary btn-lg"  data-bs-toggle="modal" data-bs-target="#edit_info"><i data-feather="edit"></i> Modifier</a>
                      </div>
                  </div>
      
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Informations complémentaires sur le client</h4>
                  </div>
                  <div class="card-body">
                    <table>
                        <tbody>
                            <tr>
                                <td>Profession:</td>
                                <td>{{ $client->profession }}</td>
                            </tr>
                            <tr>
                                <td>Employeur:</td>
                                <td>{{ $client->employeur }}</td>
                            </tr>
                            <tr>
                                <td>Lieu d'activité:</td>
                                <td>{{ $client->lieu_activite }}</td>
                            </tr>                        
                            <tr>
                                <td>Raison sociale:</td>
                                <td>{{ $client->raison_social }}</td>
                            </tr>
                            <tr>
                                <td>Nom de l'Association:</td>
                                <td>{{ $client->nom_association }}</td>
                            </tr>
                            <tr>
                                <td>Nombre de membres de l'Association:</td>
                                <td>{{ $client->nombre_membres }}</td>
                            </tr>
                            <tr>
                                <td>Nom du Conjoint:</td>
                                <td>{{ $client->nom_conjoint }}</td>
                            </tr>
                            <tr>
                                <td>Nom de l'héritier 1:</td>
                                <td>{{ $client->nom_heritier1 }}</td>
                            </tr>
                            <tr>
                                <td>Nom de l'héritier 2:</td>
                                <td>{{ $client->nom_heritier2 }}</td>
                            </tr>
                            <tr>
                                <td>Nom de l'héritier 3:</td>
                                <td>{{ $client->nom_heritier3 }}</td>
                            </tr>
                        </tbody>
                    </table>
                  
                      <div class="btn-container">
                          <a href="#" class="btn icon icon-left btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#edit_info_compl"><i data-feather="edit"></i> Modifier</a>
                      </div>
                  </div>

                </div>
              </div>
            </div>
          </section>
          
      </div>

      <!--login form Modal Password -->
        <div class="modal fade text-left" id="change_password" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header bg-primary white">
                  <sapn class="modal-title" id="myModalLabel150">
                    Changer mon mot de passe
                  </sapn>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                  </button>
                </div>
                <div class="modal-body">
    
                    <form class="" method="POST" action="">

                        {{ csrf_field() }}

                      <label>Nouveau mot de passe : </label>
                        <div class="form-group">
                          <input type="password" placeholder="Nouveau mot de passe" class="form-control form-control-xl" required />
                        </div>

                      <label>Confirmer mot de passe : </label>
                        <div class="form-group">
                          <input type="password" placeholder="Confirmer mot de passe" class="form-control form-control-xl" required />
                        </div>

                        <div class="form-group mt-4">
                          <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Fermer</span>
                          </button>
                          <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Changer</span>
                          </button>
                        </div>
                    </form>

                </div>
              </div>
            </div>
        </div>
      <!--/END login form Modal Password -->


      <!--login form Modal Informations personnelles du client -->
        <div class="modal fade text-left" id="edit_info" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header bg-primary white">
                    <sapn class="modal-title" id="myModalLabel150">
                     Modifier mes informations
                    </sapn>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <i data-feather="x"></i>
                    </button>
                  </div>
                  <div class="modal-body">
                      
                      <form class="" method="POST" action="">
                          {{ csrf_field() }}

                        <div class="form-group">
                          <label for="nom">Nom :</label>
                          <input type="text" class="form-control form-control-xl" id="nom" name="nom" value="{{ $client->nom }}" required>
                        </div>
                        <div class="form-group">
                          <label for="prenom">Prénom :</label>
                          <input type="text" class="form-control form-control-xl" id="prenom" name="prenom" value="{{ $client->prenom }}" required>
                        </div>
                        <div class="form-group">
                          <label for="nationalite ">Nationalité :</label>
                          <input type="text" class="form-control form-control-xl" id="nationalite" name="nationalite" value="{{ $client->nationalite  }}" required>
                        </div>
                        <div class="form-group">
                          <label for="cni_client ">CNI :</label>
                          <input type="text" class="form-control form-control-xl" id="cni_client" name="cni_client" value="{{ $client->cni_client  }}" required>
                        </div>
                        <div class="form-group">
                          <label for="date_naissance ">Date de naissance :</label>
                          <input type="text" class="form-control form-control-xl" id="date_naissance" name="date_naissance" value="{{ $client->date_naissance  }}" required>
                        </div>
                        <div class="form-group">
                          <label for="lieu_naissance ">Lieu de naissance:</label>
                          <input type="text" class="form-control form-control-xl" id="lieu_naissance" name="lieu_naissance" value="{{ $client->lieu_naissance }}" required>
                        </div>
                        <div class="form-group">
                          <label for="etat_civil ">Etat-Civil :</label>
                          <input type="text" class="form-control form-control-xl" id="etat_civil" name="etat_civil" value="{{ $client->etat_civil }}" required>
                        </div>
                        <div class="form-group">
                          <label for="telephone">Téléphone :</label>
                          <input type="text" class="form-control form-control-xl" id="telephone" name="telephone" value="{{ $client->telephone }}" required autocomplete="0">
                        </div>
                        <div class="form-group">
                          <label for="residence">Résidence :</label>
                          <input type="text" class="form-control form-control-xl" id="residence" name="residence" value="{{ $client->residence }}" required>
                        </div>
                        <div class="form-group">
                          <label for="adresse">Adresse :</label>
                          <input type="text" class="form-control form-control-xl" id="adresse" name="adresse" value="{{ $client->adresse }}" required>
                        </div>
                        <div class="form-group">
                          <label for="ville">Ville :</label>
                          <input type="text" class="form-control form-control-xl" id="ville" name="ville" value="{{ $client->ville }}" required>
                        </div>
                        <div class="form-group">
                          <label for="commune">Commune :</label>
                          <input type="text" class="form-control form-control-xl" id="commune" name="commune" value="{{ $client->commune }}" required>
                        </div>
                        <div class="form-group">
                          <label for="quartier">Quartier :</label>
                          <input type="text" class="form-control form-control-xl" id="quartier" name="quartier" value="{{ $client->quartier }}" required>
                        </div>
                        <div class="form-group mt-4">
                          <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Fermer</span>
                          </button>
                          <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Modifier</span>
                          </button>
                        </div>

                      </form>
                  </div>
                </div>
              </div>
        </div>
      <!--/END login form Modal Informations personnelles du client -->

        <!--Informations complémentaires sur le client-->
          <div class="modal fade text-left" id="edit_info_compl" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header bg-primary white">
                      <sapn class="modal-title" id="myModalLabel150">
                        Informations complémentaires
                      </sapn>
                      <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                      </button>
                    </div>
                    <div class="modal-body">
                        
                      <form class="" method="POST" action="">

                        {{ csrf_field() }}

                          <div class="form-group">
                            <label for="profession">Profession :</label>
                            <input type="text" class="form-control form-control-xl" id="profession" name="profession" value="{{ $client->profession }}" required>
                          </div>
                          <div class="form-group">
                            <label for="employeur">Employeur :</label>
                            <input type="text" class="form-control form-control-xl" id="employeur" name="employeur" value="{{ $client->employeur }}" required>
                          </div>
                          <div class="form-group">
                            <label for="lieu_activite ">Lieu d'activité :</label>
                            <input type="text" class="form-control form-control-xl" id="lieu_activite" name="lieu_activite" value="{{ $client->lieu_activite  }}" required>
                          </div>
                          <div class="form-group">
                            <label for="raison_social ">Raison sociale :</label>
                            <input type="text" class="form-control form-control-xl" id="raison_social" name="raison_social" value="{{ $client->raison_social  }}" required>
                          </div>
                          <div class="form-group">
                            <label for="nom_association ">Nom de l'Association :</label>
                            <input type="text" class="form-control form-control-xl" id="nom_association" name="nom_association" value="{{ $client->nom_association  }}" required>
                          </div>
                          <div class="form-group">
                            <label for="nombre_membres ">Nombre de membres de l'Association :</label>
                            <input type="text" class="form-control form-control-xl" id="nombre_membres" name="nombre_membres" value="{{ $client->nombre_membres }}" required>
                          </div>
                          <div class="form-group">
                            <label for="nom_conjoint ">Nom du Conjoint :</label>
                            <input type="text" class="form-control form-control-xl" id="nom_conjoint" name="nom_conjoint" value="{{ $client->nom_conjoint }}" required>
                          </div>
                          <div class="form-group">
                            <label for="nom_heritier1  ">Nom de l'héritier 1 :</label>
                            <input type="text" class="form-control form-control-xl" id="nom_heritier1" name="nom_heritier1" value="{{ $client->nom_heritier1 }}" required autocomplete="0">
                          </div>
                          <div class="form-group">
                            <label for="nom_heritier2 ">Nom de l'héritier 2 :</label>
                            <input type="text" class="form-control form-control-xl" id="nom_heritier2" name="nom_heritier2" value="{{ $client->nom_heritier2 }}" required>
                          </div>
                          <div class="form-group">
                            <label for="nom_heritier3 ">Nom de l'héritier 3 :</label>
                            <input type="text" class="form-control form-control-xl" id="nom_heritier3" name="nom_heritier3" value="{{ $client->nom_heritier3 }}" required>
                          </div>
                          <div class="form-group mt-4">
                            <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">
                              <i class="bx bx-x d-block d-sm-none"></i>
                              <span class="d-none d-sm-block">Fermer</span>
                            </button>
                            <button type="submit" class="btn btn-primary btn-lg">
                              <i class="bx bx-check d-block d-sm-none"></i>
                              <span class="d-none d-sm-block">Modifier</span>
                            </button>
                          </div>

                      </form>

                </div>
              </div>
            </div>
          </div>
        <!--/END Informations complémentaires sur le client-->
  
      @endif 
      @endforeach




<script>
  const profilePic = document.querySelector('.profile-pic');
  const profilePicInput = document.querySelector('#profile-pic-input');
  const cameraIcon = document.querySelector('.camera-icon');
  const clickText = "Cliquez ici pour changer l'image";

  profilePic.addEventListener('click', () => {
    profilePicInput.click();
  });

  profilePicInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    const reader = new FileReader();

    reader.onload = (e) => {
      // Mettre à jour l'image de profil avec la nouvelle image téléchargée
      profilePic.src = e.target.result;
    }

    reader.readAsDataURL(file);
  });

  profilePic.addEventListener('mouseover', () => {
    cameraIcon.style.display = "block";
    profilePic.title = clickText;
  });


</script>
@endsection