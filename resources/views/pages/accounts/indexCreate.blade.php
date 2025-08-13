@extends('layouts.template')



    @section('title', 'Ouverture de compte')



    @section('content')


  <div class="page-heading">

	  <div class="page-title mb-5">

	    <div class="row">

	      <div class="col-12 col-md-6 order-md-1 order-last">

	        

	      </div>

	      <div class="col-12 col-md-6 order-md-2 order-first">

	        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">

	          <ol class="breadcrumb">

	            <li class="breadcrumb-item">

	              <a href="{{ route('dashboard') }}">Tableau de bord</a>

	            </li>

	            <li class="breadcrumb-item active" aria-current="page">

	              Ouverture de compte

	            </li>

	          </ol>

	        </nav>

	      </div>

	    </div>

		</div>


    <div class="container mt-5">
    <h2 class="mb-4">Types de Comptes</h2>
    
    <div class="row">

        @foreach( $etat_juridiques as $e )
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $e->name }}</h5>
                    <p class="card-text">{{ $e->description }}</p>
                    <a href="{{ route('account-create', $e->slug) }}" class="btn btn-primary btn-lg">Ouvrir un compte</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

    @endsection

    @section('js')
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
              
              if (form.parsley().validate({group: 'block' + step}) && step < 4) {
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
            if (form.parsley().validate({group: 'block' + step}) && step == 4) {
              return true;
            }


            });
        </script>

        <script>

            $(document).ready(function(){


                $('#affiche_raison').hide();
                $('#affiche_nom_association').hide();
                $('#affiche_nb_membre_association').hide();

                $(document).on('change', '#etat_juridique', function() {
                    var selectedValue = $(this).val();

                    if (selectedValue == 1) {
                        $('#affiche_nom').show();
                        $('#affiche_prenom').show();
                        $('#affiche_raison').hide();
                        $('#affiche_nom_association').hide();
                        $('#affiche_nb_membre_association').hide();

                    }
                    if (selectedValue == 2) {
                        $('#affiche_nom').hide();
                        $('#affiche_prenom').hide();
                        $('#affiche_raison').show();
                        //console.log('Morale')
                    }
                    if (selectedValue == 3) {
                        $('#affiche_nom').hide();
                        $('#affiche_prenom').hide();
                    }

                    if (selectedValue == 4) {
                        $('#affiche_nom').hide();
                        $('#affiche_prenom').hide();
                        $('#affiche_nom_association').show();
                        $('#affiche_nb_membre_association').show();
                    }
                });

            });
        </script>

    @endsection



    

