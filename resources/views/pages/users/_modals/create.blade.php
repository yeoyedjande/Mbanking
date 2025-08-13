
<!--EDIT-->
<div class="modal fade text-left" id="create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary white">
          <sapn class="modal-title" id="myModalLabel150">
            Ajouter un utilisateur
          </sapn>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">
            
            <form class="" method="POST" action="{{ route('addUser') }}">

                {{ csrf_field() }}

                <div class="form-group">
                  <label for="nom">Nom * </label>
                  <input type="text" class="form-control form-control-xl" value="{{ old('nom') }}" id="nom" name="nom" required placeholder="Nom *" autocomplete="0" />
                </div>

                <div class="form-group">
                  <label for="prenom">Prénoms *</label>
                  <input type="text" class="form-control form-control-xl" value="{{ old('prenom') }}" id="prenom" name="prenom" placeholder="Prénoms" autocomplete="0" />
                </div>

                <div class="form-group">
                  <label for="date_naissannce">Date de naissance *</label>
                  <input type="date" name="date_naissannce" class="form-control form-control-xl" value="{{ old('date_naissannce') }}" id="date_naissannce">
                </div>

                <div class="form-group">
                  <label for="lieu_naissance">Lieu de naissance *</label>
                  <input type="text" class="form-control form-control-xl" value="{{ old('lieu_naissance') }}" id="lieu_naissance" name="lieu_naissance" placeholder="Lieu de naissance" autocomplete="0" />
                </div>

                <div class="form-group">
                  <label for="sexe">Sexe *</label>
                  <select style="height: 50px;" class="form-control form-control-xl" value="{{ old('sexe') }}" id="sexe" name="sexe" required>
                      <option value="">Selectionner</option>
                      @foreach( $sexes as $s )
                      <option value="{{ $s->id }}">{{ $s->name }}</option>
                      @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label for="type_piece">Type de pièce *</label>
                  <input type="text" class="form-control form-control-xl" value="{{ old('type_piece') }}" id="type_piece" name="type_piece" placeholder="Type de pièce" autocomplete="0" />
                </div>

                <div class="form-group">
                  <label for="numero_piece">Numéro de pièce d'identité *</label>
                  <input type="numero_piece" name="numero_piece" value="{{ old('numero_piece') }}" required class="form-control form-control-xl" id="numero_piece" placeholder="Numéro de pièce d'identité" autocomplete="0" />
                </div>

                <div class="form-group">
                  <label for="numero_piece">Adresse *</label>
                  <textarea name="adresse" required value="{{ old('adresse') }}" class="form-control form-control-xl" id="adresse" placeholder="Adresse" autocomplete="0" /></textarea>
                </div>

                <div class="form-group">
                  <label for="telephone">N° de téléphone </label>
                  <input type="number" name="telephone" class="form-control form-control-xl" id="telephone" placeholder="N° de téléphone" autocomplete="0" />
                </div>

                <div class="form-group">
                  <label for="email">Email *</label>
                  <input type="email" name="email" value="{{ old('email') }}" required class="form-control form-control-xl" id="email" placeholder="Email" autocomplete="0" />
                </div>

                <div class="form-group">
                  <label for="password">Mot de passe *</label>
                  <input type="password" name="password" value="{{ old('password') }}" required class="form-control form-control-xl" id="password" placeholder="Mot de passe" autocomplete="0" />
                </div>

                <div class="form-group">
                  <label for="confirm_password">Confirmer mot de passe *</label>
                  <input type="password" name="confirm_password" value="{{ old('confirm_password') }}" required class="form-control form-control-xl" id="confirm_password" placeholder="Confirmation de mot de passe" autocomplete="0" />
                </div>


                <div class="form-group">
                    <label for="date_creation">Date de création *</label>
                    <input type="date" name="date_creation" class="form-control form-control-xl" value="{{ now()->format('Y-m-d') }}" id="date_creation" readonly>
                </div>

                <div class="form-group">
                    <label for="user_create">Utilisateur créateur *</label>
                    <input type="text" name="user_create" required class="form-control form-control-xl" id="user_create" value="{{ Auth::user()->nom }} {{ Auth::user()->prenom }}" readonly />
                </div>


                <div class="form-group">
                  <label for="statut">Statut *</label>
                  <select style="height: 50px;" class="form-control form-control-xl" value="{{ old('statut') }}" id="statut" name="statut" required>
                      <option value="">Selectionner</option>
                      <option value="inactif">Inactif</option>
                      <option value="actif">Actif</option>
                  </select>
                </div>


                <div class="form-group">
                  <label for="role">Agence</label>
                  <select style="height: 50px;" class="form-control form-control-xl" value="{{ old('agence') }}" id="agence" name="agence" required>
                      <option value="">Selectionner</option>
                      @foreach( $agences as $r )
                      <option value="{{ $r->id }}">{{ $r->name }}</option>
                      @endforeach
                  </select>
                </div>


                <div class="form-group">
                  <label for="role">Rôle</label>
                  <select style="height: 50px;" class="form-control form-control-xl" value="{{ old('role') }}" id="role" name="role" required>
                      <option value="">Selectionner</option>
                      @foreach( $roles as $r )
                      <option value="{{ $r->id }}">{{ $r->name }}</option>
                      @endforeach
                  </select>
                </div>

                <div class="form-group">
                  <label for="gestionnaire">L'utilisateur est-il gestionnaire ? *</label>
                  <select style="height: 50px;" class="form-control form-control-xl" value="{{ old('gestionnaire') }}" id="gestionnaire" name="gestionnaire" required>
                      <option value="">Selectionner</option>
                      <option value="non">Non</option>
                      <option value="oui">Oui</option>
                  </select>
                </div>

                <div class="form-group">
                    <label for="superviseur">Est un superviseur ? </label>
                    <input type="checkbox" name="superviseur" id="superviseur" value="1" />
                </div>

                <div class="form-group mt-4">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Fermer</span>
                  </button>
                  <button type="submit" class="btn btn-primary">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Ajouter</span>
                  </button>
                </div>

            </form>

        </div>
      </div>
    </div>
</div>
<!--/END EDIT-->