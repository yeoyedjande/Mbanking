

<!--EDIT-->

<div class="modal fade text-left" id="create" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">



      <div class="modal-content">



        <div class="modal-header bg-primary white">



          <sapn class="modal-title" id="myModalLabel150">



            Transfert vers une caisse principale 



          </sapn>



          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">



            <i data-feather="x"></i>



          </button>



        </div>



        <div class="modal-body">
          
            <form class="" method="POST" action="{{route('coffre-to-principal')}}">
                {{ csrf_field() }}
                <input type="hidden" name="compte_id" id="id">
                <input type="hidden" name="montant" id="montant">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nom">Saisir le Montant * </label>
                      <input type="number" class="form-control form-control-xl" id="amount" name="amount" min="0" required placeholder="Montant principal *" autocomplete="0" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">

                      <label for="nom">Caisse principale * </label>
                      <select class="form-control form-control-xl" name="caissier_principal" required>
                        <option>Selectionner</option>
                        @foreach( $compteComptable as $c )
                        <option value="{{ $c->numero }}">{{ $c->libelle }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group mt-4">



                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">



                    <i class="bx bx-x d-block d-sm-none"></i>



                    <span class="d-none d-sm-block">Fermer</span>



                  </button>



                  <button type="submit" class="btn btn-primary">



                    <i class="bx bx-check d-block d-sm-none"></i>



                    <span class="d-none d-sm-block">Transferer</span>



                  </button>



                </div>







            </form>







        </div>



      </div>



    </div>
</div>


<div class="modal fade text-left" id="edit" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">



      <div class="modal-content">



        <div class="modal-header bg-primary white">



          <sapn class="modal-title" id="myModalLabel150">



           Edition Transfert vers l'agence <span class="nom_agence"></span>



          </sapn>



          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">



            <i data-feather="x"></i>



          </button>



        </div>



        <div class="modal-body">

            <form class="" method="POST" action="{{route('transfert-vers-agence-edit')}}">

                {{ csrf_field() }}
                <input type="hidden" name="agence_id" id="id">

                <input type="hidden" name="name" id="name">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nom">Montant principal * </label>
                      <input type="number" class="form-control form-control-xl" id="solde_principal" name="amount" min="0" required placeholder="Montant principal *" autocomplete="0" />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nom">Caisse principale * </label>
                      <select class="form-control form-control-xl" name="caissier_principal" id="vers_numero" required>
                        <option>Selectionner</option>
                        @foreach( $compteComptable as $c )
                        <option value="{{ $c->numero }}">{{ $c->libelle }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>

                <div class="form-group mt-4">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Fermer</span>
                  </button>
                  <button type="submit" class="btn btn-primary">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Transferer</span>
                  </button>
                </div>
            </form>
        </div>
      </div>



    </div>

</div>
<!--/END EDIT-->