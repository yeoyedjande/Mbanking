@extends('layouts.template')

@section('title', $title)


@section('content')
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>Edit Utilisateur</h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Edit Utilisateur
            </li>
          </ol>
        </nav>
      </div>
    </div>
</div>
  
    @if( session()->has('msg_success') )
    <div class="col-md-12">
        <div class="alert alert-success">{{ session()->get('msg_success') }}</div>
    </div>
    @endif

    @if( session()->has('msg_error') )
    <div class="col-md-12">
        <div class="alert alert-danger">{{ session()->get('msg_error') }}</div>
    </div>
    @endif
    
    <section class="section">
      <div class="card">
        <div class="card-header">Editer un utilisateur

            <span class="d-flex justify-content-end">
              <a href="{{ route('users') }}" class="btn btn-primary btn-lg">
                  <i class="bi bi-plus"></i> Liste utilisateur
              </a>
            </span>
        </div>
        <div class="card-body">
            
            <form class="" method="POST" action="{{ route('editUser') }}">

                {{ csrf_field() }}
                <input type="hidden" name="edit_id" value="{{ $user->id }}">
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="nom">Nom * </label>
                        <input type="text" class="form-control form-control-xl" value="{{ $user->nom }}" id="nom" name="nom" required placeholder="Nom *" autocomplete="off" />
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="prenom">Prénoms *</label>
                        <input type="text" class="form-control form-control-xl" value="{{ $user->prenom }}" id="prenom" name="prenom" placeholder="Prénoms" autocomplete="off" />
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" name="email" value="{{ $user->email }}" required class="form-control form-control-xl" id="email" placeholder="Email" autocomplete="off" />
                      </div>
                    </div>
                    
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="role">Agence *</label>
                        <select style="height: 50px;" class="form-control form-control-xl" id="agence" name="agence" required>
                            <option value="">Selectionner</option>
                            @foreach( $agences as $r )
                            <option value="{{ $r->id }}" <?php if( $user->agence_id == $r->id ){ echo "selected"; } ?>>{{ $r->name }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="role">Rôle *</label>
                        <select style="height: 50px;" class="form-control form-control-xl" id="role" name="role" required>
                            <option value="">Selectionner</option>
                            @foreach( $roles as $r )
                            <option value="{{ $r->id }}" <?php if( $user->role_id == $r->id ){ echo "selected"; } ?>>{{ $r->name }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group compte" style="display: none;">
                        <label for="role">Compte associé *</label>
                        <select style="height: 50px;" class="form-control form-control-xl" id="compte_comptable" name="numero" required>
                            <option value="">Selectionner</option>
                            @foreach( $compteComptables as $r )
                            <option value="{{ $r->numero }}" <?php if( $user->compte_comptable_id == $r->numero ){ echo "selected"; } ?>>{{ $r->libelle }}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                        <button type="reset" class="btn btn-danger btn-lg">
                          Annuler
                        </button>
                        <button type="submit" class="btn btn-primary btn-lg">
                          Modifier
                        </button>
                      </div>
                    </div>
                </div>

            </form>

        </div>
      </div>
    </section>
@endsection

@section('js')
<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script>

  $(document).ready(function() {

    $('#role').change(function() {

       $("#role option:selected").each(function () {

          // Récupère la valeur sélectionnée
          var selectedValue = $(this).val();
          
          if ( selectedValue == 5 ) {
            $('.compte').show();
          }else if(selectedValue == 4){
            $('.compte').show();
            //$('#compte_comptable').setAttribute('required', '');
          }else{
            $('.compte').hide();
          }

      });

     })
    .trigger('change');

  });
</script>
@endsection