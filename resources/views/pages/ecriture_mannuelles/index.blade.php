@extends('layouts.template')

@section('title', 'Ecritres manuelles')

@section('css')
<link
      rel="stylesheet"
      href="/assets/extensions/choices.js/public/assets/styles/choices.css"
    />
@endsection
@section('content')

  <div class="page-heading">

    <div class="page-title mb-5">

      <div class="row">

        <div class="col-12 col-md-6 order-md-1 order-last">

          <h3 style="text-transform: uppercase;">{{ $title }}</h3>

        </div>

        <div class="col-12 col-md-6 order-md-2 order-first">

          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">

            <ol class="breadcrumb">

              <li class="breadcrumb-item">

                <a href="{{ route('dashboard') }}">Tableau de bord</a>

              </li>

              <li class="breadcrumb-item active" aria-current="page">

                Ecritres manuelles

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

    @if( session()->has('msg_info') )
    <div class="col-md-12">
        <div class="alert alert-info">{{ session()->get('msg_info') }}</div>
    </div>
    @endif



    <section class="section">
      

        <form method="POST" action="{{ route('ecritures-mannuelle-save') }}">
          <div class="row justify-content-center">
        <!--Recherche par intervalle-->
        <div class="col-md-10">

          <div class="card">

            <div class="card-header">
              <h2>Faire une nouvelle écriture</h2>
            </div>

            <div class="card-body">

                  {{ csrf_field() }}
                  <div class="row">
                    
                    <div class="col-12">
                      <div class="form-group">
                        <label>Libellé Opération *</label>
                        <input type="text" class="form-control form-control-xl" name="libelle">                      
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label>Nombre de comptes utilisés dans l'écriture *</label>
                        <input type="number" min="2" class="form-control form-control-xl" name="nombre">                      
                      </div>
                    </div>

                    <div class="col-6">
                      <div class="form-group">
                        <label>Choisir la date *</label>
                        <input type="date" value="<?= date('d/m/Y'); ?>" class="form-control form-control-xl" name="date">                      
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group">
                          <button type="button" id="add_btn" class="btn btn-primary btn-lg">Ajouter</button>
                      </div>
                    </div>
                  </div>
              
                
            </div>

          </div>
        </div>
        <!--Fin Recherche par Intervalle-->

        <!--Recherche par période-->
        <div class="col-md-10" id="form_complete" style="display: none;">

          <div class="card">

            <div class="card-header">
              <h2>Ecritures manuelles</h2>
            </div>

            <div class="card-body">

                <div class="col-12"><div class="alert alert-danger" id="error_message" style="display: none;">Le total au débit et le total au crédit diffèrent. Merci de vérifier les montants!</div></div>
                <table class="table table-bordered">
                  <thead>
                      <th class="text-center">Compte</th>
                      <th class="text-center">Client</th>
                      <th class="text-center">Débit</th>
                      <th class="text-center">Crédit</th>
                      <th class="text-center">Guichetier</th>
                  </thead>

                  <tbody id="ligne">
                    <tr>
                      <td width="10%"></td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>

                <div class="col-12 text-center">

                  <button type="submit" class="btn btn-success btn-lg" id="verif">Enregistrer et terminer</button>
                  <button type="button" class="btn btn-danger btn-lg" id="cancel_btn">Annuler</button>
                </div>
            </div>


          </div>
        </div>
        <!--Fin Recherche par période-->
        </div>
        </form>
    </section>
@endsection

@section('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
  $(document).ready(function() {

    $('#add_btn').click(function() {

      var comptes = @json($compteComptables);
      var clients = @json($clients);
      var guichetiers = @json($guichetiers);

      var nombreOperations = $('input[name="nombre"]').val(); // Obtient le nombre d'opérations

      /*if (nombreOperations % 2 !== 0) {
        $('#error_message').show(); // Affiche le message d'erreur
        $('#form_complete').hide(); // Cache le tableau
        return; // Arrête l'exécution supplémentaire du script
      } else {
        $('#error_message').hide(); // Cache le message d'erreur
      }*/

      var lignes = '';

      for (var i = 0; i < nombreOperations; i++) {

        var optionsComptes = '<option value="">Sélectionner</option>';
          comptes.forEach(function(compte) {
            optionsComptes += '<option value="' + compte.numero + '">'+ compte.numero +' ' + compte.libelle + '</option>';
          });

        var optionsClients = '<option value="">Sélectionner</option>';
          clients.forEach(function(client) {
            optionsClients += '<option value="' + client.id + '">'+ client.nom +'</option>';
          });

        var optionsGuichetiers = '<option value="">Sélectionner</option>';
          guichetiers.forEach(function(guichetier) {
            optionsGuichetiers += '<option value="' + guichetier.id + '">'+ guichetier.nom +'</option>';
          });

        lignes += '<tr>' +
                    '<td><select class="form-control choices form-select form-control-xl compte-select" name="compte[]" required>'+ optionsComptes +'</select></td>' +
                    '<td width="20%"><select class="form-control form-control-xl client-select" name="client[]" disabled required>'+ optionsClients +'</select></td>' +
                    '<td><input type="number" class="form-control form-control-xl" name="debit[]" id="debit" min="1"></td>' +
                    '<td><input type="number" id="credit" class="form-control form-control-xl" name="credit[]" min="1"></td>' +
                    '<td width="10%"><select class="form-control form-control-xl" name="guichetier[]" required>'+ optionsGuichetiers +'</select></td>' +
                  '</tr>';

      }

      $('#ligne').html(lignes);
      $('#form_complete').show(); // Affiche la table
    });

    $('#cancel_btn').click(function() {
      $('#form_complete').hide(); // Affiche la table
    });

    $('#verif').click(function(e) {

        e.preventDefault(); //Je desactive la soumission du bouton

        //Preparer le contenu de vérification

        var totalDebit = 0;
        var totalCredit = 0;

        //Calcul le total des débits
        $('input[name="debit[]"]').each(function(){
          totalDebit += parseFloat($(this).val()) || 0;
        });

        //Calcul le total des crédits
        $('input[name="credit[]"]').each(function(){
          totalCredit += parseFloat($(this).val()) || 0;
        });

        if ( totalDebit != totalCredit ) {
          $('#error_message').show();
        }else{
          $('form').submit();
        }
        //$debit = $('#debit').val();
        //$debit = $('#credit').val();
    });


    $(document).on('change', '.compte-select', function() {
        var selectedValue = $(this).val();
        var clientSelect = $(this).closest('tr').find('.client-select');

        if (selectedValue === '2.2.1.1') {
            clientSelect.prop('disabled', false);
        } else {
            clientSelect.prop('disabled', true);
            clientSelect.val(''); // Réinitialise la sélection du client
        }
    });

  }); 
</script>

<script src="/assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
<script src="/assets/extensions/static/form-element-select.js"></script>

@endsection