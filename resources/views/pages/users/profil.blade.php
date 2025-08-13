@extends('layouts.template')
@section('title', 'Profil Utilisateur')
@section('content')

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

    <div class="col-md-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h4 class="card-title">Mon compte</h4>
          <button type="button" class="btn btn-dark btn-lg" data-id="{{ Auth::user()->id }}" data-bs-toggle="modal" data-bs-target="#change_password">
          <i class="bi bi-pencil"></i> Modifier Mot de Passe
          </button>
        </div>

              @if( session()->has('msg_success') )
              <div class="col-md-12">
                <div class="alert alert-success" style="font-size: 30px; text-align: center;">{{ session()->get('msg_success') }}</div>
              </div>
              @endif 

              @if( session()->has('msg_error') )
              <div class="col-md-12">
                <div class="alert alert-danger" style="font-size: 30px; text-align: center;">{{ session()->get('msg_error') }}</div>
              </div>
              @endif 
              <div class="card-content">
                <div class="card-body">
                    <form class="form" method="POST" action="{{ route('profil-user-edit') }}">

                            {{ csrf_field() }}
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nom" class="form-label">Nom</label>
                                        <input type="text" id="nom" class="form-control form-control-xl" name="nom" value="{{ Auth::user()->nom }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="prenom" class="form-label">Prénom(s)</label>
                                        <input type="text" id="prenom" class="form-control form-control-xl" name="prenom" value="{{ Auth::user()->prenom }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" class="form-control form-control-xl" name="email" value="{{ Auth::user()->email }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telephone" class="form-label">Téléphone</label>
                                        <input type="text" id="telephone" class="form-control form-control-xl" value="{{ Auth::user()->phone }}" name="telephone" required>
                                    </div>
                                </div>
                               
                               <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-pencil"></i> Modifier</button>
                                    </div>
                                </div>

                          </div>  
                           

                    </form>
                </div>
              </div>
            
      </div>
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

                <form class="" method="POST" action="{{ route('profil-change-password') }}">

                  {{ csrf_field() }}

                  <input type="hidden" name="user_id" id="id">

                  
                    <div class="form-group">
                      <label style="font-size: 18px;" class="mb-3">Nouveau mot de passe * </label>
                      <input type="password" name="password" class="form-control form-control-xl" required />
                    </div>

                  
                    <div class="form-group">
                      <label style="font-size: 18px;" class="mb-3">Confirmer mot de passe *  </label>
                      <input type="password" name="repassword" class="form-control form-control-xl" required />
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


@endsection

@section('js')

<script src="/assets/js/initTheme.js"></script>


<script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}" id="parsley"></script>

<script>







  $(document).ready(function() {



      $("#change_password").on('show.bs.modal', function(e){



          var button = $(e.relatedTarget);
          var id = button.data('id');
          var modal = $(this);
          modal.find('#id').val(id);



      });



  });



</script>

@endsection