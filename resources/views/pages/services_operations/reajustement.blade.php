@extends('layouts.template')

@section('title', $title)

@section('css')
  <link rel="stylesheet" href="/assets/css/pages/fontawesome.html" />
  <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css"/>
  <link rel="stylesheet" href="/assets/css/pages/simple-datatables.css" />
@endsection

@section('content')

<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3 style="text-transform: uppercase;">Fermetures de caisses echouées du <?= date('d/m/Y'); ?></h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Liste des fermetures de caisses echouées
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

    <div class="row mt-5">
        <div class="col-md-12">
          <div class="card">

            <div class="card-header">
              <h4>Liste des fermetures de caisses echouées</h4>
            </div>
            <div class="card-content text-center">
              <div class="card-body">
                @if( $mvts->isNotEmpty() )
                <table class="table table-striped" id="table1">
                  <thead>
                    <tr style="text-transform: uppercase;">
                      <th class="text-center">N°</th>
                      <th class="text-center">Caisse</th>
                      <th class="text-center">Guichetier</th>
                      <th class="text-center">Montant</th>
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    @php $i = 1; @endphp

                    @foreach( $mvts as $m )
                    <tr>
                      <td class="text-center">{{ $i++ }}</td>
                      <td class="text-center">{{ $m->name }}</td>
                      <td class="text-center">{{ $m->nom }} @if($m->prenom != 'NULL' ) {{ $m->prenom }} @endif</td>
                      <td class="text-center"><b>{{ number_format($m->solde_initial, 0, 2, ' ') }} BIF</b></td>
                      
                      <td class="text-center">

                        @if($m->verify === 'yes')

                        <button type="button" data-id = "{{ $m->id }}" data-name = "{{ $m->name }}" data-nom = "{{ $m->nom }}" data-prenom = "{{ $m->prenom }}" data-solde_initial = "{{ $m->solde_initial }}" data-solde_final = "{{ $m->solde_final }}" data-bs-toggle="modal" data-bs-target="#fermeture_caisse" class="btn btn-danger btn-xs">Fermer cette caisse</button>
                        @endif
                        
                        @if($m->verify === 'noferme')
                        <button class="btn btn-warning btn-xs">Fermeture Echouée</button>
                        <a href = "{{ route('caisse-reajuster', $m->id) }}" class="btn btn-primary btn-xs">Réajuster ></a>
                        @endif
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                @else
                <div class="alert alert-info">
                  <h4 class="alert-heading">Info</h4>
                  <p>Vous n'avez pas encore caisse échouée a cette date !</p>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
    </div>
    
</section>

<!--FERMETURE-->
<div class="modal fade text-left" id="fermeture_caisse" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger white">
          <sapn class="modal-title" id="myModalLabel150">
            Fermeture de cette caisse
          </sapn>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">
            
            <form class="" method="POST" action="{{ route('caisse-fermeture') }}">
                {{ csrf_field() }}

                <input type="hidden" class="" name="id" id="id">
                <input type="hidden" class="" name="solde_final" id="chp_solde_final">

                <div class="list-group mb-5" style="font-size: 25px;">
                </div>

                <p style="font-size: 20px;">Voulez-vous vraiment fermer cette caisse ?</p>

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
<!--/END FERMETURE-->


<!--ANNULATION-->
<div class="modal fade text-left" id="annulation_caisse" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger white">
          <sapn class="modal-title" id="myModalLabel150">
            Annulation de cette caisse
          </sapn>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">
            
            <form class="" method="POST" action="{{ route('caisse-annulation') }}">
                {{ csrf_field() }}

                <input type="hidden" class="" name="id" id="id">
                <input type="hidden" class="" name="solde_final" id="chp_solde_final">

                <div class="form-group"><span class="resume_annulation"></span></div>

                <hr class="mb-4">
                <div class="form-group">
                  <label>Mettez le motif de l'annulation *</label>
                  <textarea required class="form-control" rows="5" name="motif"></textarea>
                </div>

                <div class="form-group mt-4">
                  <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Retour</span>
                  </button>
                  <button type="submit" class="btn btn-danger">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Valider</span>
                  </button>
                </div>

            </form>

        </div>
      </div>
    </div>
</div>
<!--/END ANNULATION-->

<!--REAJUSTEMENT-->
<div class="modal fade text-left" id="reajuster_caisse" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-dark white">
          <sapn class="modal-title" id="myModalLabel150">
            Reajustement de cette caisse
          </sapn>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">
            
            <div class="col-md-12 text-center">
              <h2 class="affiche_msg"></h2>
            </div>
            <form class="" method="GET" action="#">
                {{ csrf_field() }}

                <input type="hidden" class="" name="reajuster" id="id">

                <p style="font-size: 25px; text-align: center;">Voulez procéder quand même à la fermeture de la caisse ?</p>

                <div class="form-group mt-4">
                  <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Non</span>
                  </button>
                  <button type="submit" class="btn btn-success">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Oui</span>
                  </button>
                </div>

            </form>

        </div>
      </div>
    </div>
</div>
<!--/END REAJUSTEMENT-->

@endsection

@section('js')
<script src="/assets/extensions/jquery/jquery.min.js"></script>

<script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}" id="parsley"></script>

<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/assets/js/pages/simple-datatables.js"></script>

<script type="text/javascript">

    // Récupérer le champ de montant
    const montant = document.getElementById("amount");

    // Ajouter un écouteur d'événements pour l'événement input
    montant.addEventListener('input', function(e) {
      // Récupérer la valeur saisie dans le champ de montant
      let valeur = e.target.value;

      // Enlever tous les espaces de la valeur saisie
      valeur = valeur.replace(/\s+/g, '');

      // Formater le nombre en ajoutant des espaces tous les 3 chiffres
      valeur = valeur.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ');

      // Mettre à jour la valeur affichée dans le champ de montant
      e.target.value = valeur;
    });


    $(document).ready(function() {
        
      $("#reajuster_caisse").on('show.bs.modal', function(e){
        var button = $(e.relatedTarget);
        var id = button.data('id');
        var nom = button.data('nom');
        var prenom = button.data('prenom');
        var name = button.data('name');
        var solde_fermeture = button.data('solde_fermeture');
        var solde_final = button.data('solde_final');

        var diff = solde_fermeture-solde_final;
        
        

        var modal = $(this);

        modal.find('#id').val(id);
        modal.find('#chp_solde_final').val(solde_final);
        

        modal.find('.affiche_msg').html('Montant système = '+solde_final+' BIF.<br> Montant en Cash = '+solde_fermeture+' BIF <br>Différence = '+diff+' BIF.');

        //modal.find('#prenom').html(prenom);
        //modal.find('#name').html(name);
        //modal.find('#solde_initial').html(solde_initial);
        //modal.find('#id').val(id);
       
    });

      $("#fermeture_caisse").on('show.bs.modal', function(e){
        var button = $(e.relatedTarget);
        var id = button.data('id');
        var nom = button.data('nom');
        var prenom = button.data('prenom');
        var name = button.data('name');
        var solde_initial = button.data('solde_initial');
        var solde_final = button.data('solde_final');
        var modal = $(this);

        modal.find('#id').val(id);
        modal.find('#chp_solde_final').val(solde_final);
        

        modal.find('.list-group').html('<span class="list-group-item">Caisse: <b>'+name+'</b></span><span class="list-group-item">Guichetier: <b>'+nom+' '+prenom+'</b></span><span class="list-group-item">Solde Ouverture: <b> '+solde_initial+' BIF</b></span><span class="list-group-item">Solde à la fermeture: <b> '+solde_final+' BIF</b></span>');

        //modal.find('#prenom').html(prenom);
        //modal.find('#name').html(name);
        //modal.find('#solde_initial').html(solde_initial);
        //modal.find('#id').val(id);
       
    });

      $("#annulation_caisse").on('show.bs.modal', function(e){
        var button = $(e.relatedTarget);
        var id = button.data('id');
        var nom = button.data('nom');
        var prenom = button.data('prenom');
        var name = button.data('name');
        var solde_initial = button.data('solde_initial');
        var solde_final = button.data('solde_final');
        var modal = $(this);

        modal.find('#id').val(id);
        modal.find('#chp_solde_final').val(solde_final);
        
        modal.find('.resume_annulation').html('<h4>Caisse: '+name+'</h4><h4>Nom du guichetier: '+nom+' '+prenom+'</h4><h4>Montant: '+solde_initial+' BIF</h4>');
       
    });

      $("#num_account").change(function () {
                 
                 
          //console.log(" Numero Compte ");

            $("#num_account option:selected").each(function () {

                var num_account = $("#num_account").val();

               if (num_account) {
                    
                    console.log('Tu as trouver')

                    $.post("",{num_account:num_account},function(data){

                    $("#res_cent").html(data);
                   
                  });

                }else{
                  console.log("Veuillez saisir un num_account. ");
                }

            });

        })
      
        .trigger('change');

    });

</script>
@endsection