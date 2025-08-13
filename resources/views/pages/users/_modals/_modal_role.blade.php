<!--EDIT-->
<div class="modal fade text-left" id="edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-dark white">
          <sapn class="modal-title" id="myModalLabel150">
            Editer cet utilisateur
          </sapn>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">
            
            <form class="" method="POST" action="{{ route('role-edit-valid') }}">

                {{ csrf_field() }}

                <input type="hidden" name="edit_id" id="id">
                <div class="form-group">
                  <label for="nom">Nom du Rôle* </label>
                  <input type="text" class="form-control form-control-xl" value="{{ old('nom') }}" id="nom" name="nom" required placeholder="Nom *" autocomplete="0" />
                </div>
                
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea class="form-control" id="description" rows="5" name="description"></textarea>
                </div>

                <div class="form-group mt-4">
                  <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Fermer</span>
                  </button>
                  <button type="submit" class="btn btn-success btn-lg">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Modifier</span>
                  </button>
                </div>
            </form>

        </div>
      </div>
    </div>
</div>
<!--/END EDIT-->


<!--DELETE-->
<div class="modal fade text-left" id="delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger white">
          <sapn class="modal-title" id="myModalLabel150">
            Supprimer ce Rôle
          </sapn>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">
            
            <form class="" method="POST" action="{{ route('role-del-valid') }}">
                {{ csrf_field() }}

                <input type="hidden" class="" name="id" id="id">
                <p>Voulez-vous supprimer ce Rôle ?</p>

                <div class="form-group mt-4">
                  <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Non</span>
                  </button>
                  <button type="submit" class="btn btn-danger">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Oui</span>
                  </button>
                </div>

            </form>

        </div>
      </div>
    </div>
</div>
<!--/END DELETE-->

<!--CREATE-->
<div class="modal fade text-left" id="create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary white">
          <sapn class="modal-title" id="myModalLabel150">
            Ajouter un role
          </sapn>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">
            
            <form class="" method="POST" action="{{ route('role-create-valid') }}">

                {{ csrf_field() }}

                <div class="form-group">
                  <label for="nom">Nom du rôle * </label>
                  <input type="text" class="form-control form-control-xl" value="{{ old('nom') }}" id="nom" name="nom" required placeholder="Nom *" autocomplete="0" />
                </div>
                
                <div class="form-group">
                  <label for="description">Description</label>
                  <textarea class="form-control" id="description" rows="5" name="description"></textarea>
                </div>

                <div class="form-group mt-4">
                  <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Fermer</span>
                  </button>
                  <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Ajouter</span>
                  </button>
                </div>

            </form>

        </div>
      </div>
    </div>
</div>
<!--/END CREATE-->