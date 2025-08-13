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
        <h3>Utilisateurs</h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Utilisateurs
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
        <div class="card-header">Liste des utilisateurs

            <span class="d-flex justify-content-end">
              <a href="javascript(0);" data-bs-toggle="modal" data-bs-target="#create" class="btn btn-primary btn-lg">
                  <i class="bi bi-plus"></i> Ajouter un utilisateur
              </a>
            </span>
        </div>
        <div class="card-body">
          @if( $users->isNotEmpty() )
          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th class="text-center">N°</th>
                <th class="text-center">NOM ET PRENOM(S)</th>
                <th class="text-center">EMAIL</th>
                <th class="text-center">ROLE</th>
                <th class="text-center">AGENCE</th>
                <th class="text-center">ACTIONS</th>
              </tr>
            </thead>
            <tbody>
              @php
              $i = 1;
              @endphp
              @foreach( $users as $u )
              <tr>
                <td class="text-center">{{ $i++ }}</td>
                <td class="text-center">{{ $u->nom }} {{ $u->prenom }}</td>
                <td class="text-center">{{ $u->email }}</td>
                <td class="text-center"><b>{{ $u->role_name }}</b></td>
                <td class="text-center"><b>{{ $u->nom_agence }}</b></td>
                
                <td class="text-center">
                  <a href="javascript:void(0);" data-id="{{ $u->id }}" data-nom="{{ $u->nom }}" data-prenom="{{ $u->prenom }}" data-agence="{{ $u->id_agence }}" data-rolename="{{ $u->role_id }}" data-email="{{ $u->email }}" data-datenaissance="{{ $u->date_naissance }}" data-lieunaissance="{{ $u->lieu_naissance }}" data-sexe="{{ $u->sexe }}" data-typepiece="{{ $u->type_piece }}" data-numeropiece="{{ $u->numero_piece }}" data-adresse="{{ $u->adresse }}" data-superviseur="{{ $u->superviseur }}" data-statut="{{ $u->statut }}" data-gestionnaire="{{ $u->gestionnaire }}" data-bs-toggle="modal" data-bs-target="#edit" class="btn btn-dark">
                    <i class="bi bi-pencil"></i> Modifier </a>
                  <a href="javascript(0);" data-id="{{ $u->id }}" data-bs-toggle="modal" data-bs-target="#delete" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Supprimer </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @else
            <div class="card card-inverse-danger mb-5">
              <div class="card-body">
                <p class="mb-4"> Vous n'avez pas encore ajouté d'utilisateur !</p>
              </div>
            </div>
          @endif
        </div>
      </div>
    </section>

    @include('pages.users._modals.edit')
    @include('pages.users._modals.create')
@endsection

@section('js')
<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script>

  $(document).ready(function() {

    $("#edit").on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget);
        var id = button.data('id');
        var nom = button.data('nom');
        var prenom = button.data('prenom');
        var email = button.data('email');
        var agence = button.data('agence');
        var role_name = button.data('rolename');
        var date_naissance = button.data('datenaissance');
        var lieu_naissance = button.data('lieunaissance');
        var sexe = button.data('sexe');
        var type_piece = button.data('typepiece');
        var numero_piece = button.data('numeropiece');
        var adresse = button.data('adresse');
        var superviseur = button.data('superviseur');
        var statut = button.data('statut');
        var gestionnaire = button.data('gestionnaire');

        var modal = $(this);

        modal.find('#id').val(id);
        modal.find('#nom').val(nom);
        modal.find('#prenom').val(prenom);
        modal.find('#email').val(email);
        modal.find('#role').val(role_name);
        modal.find('#agence').val(agence);
        modal.find('#date_naissannce').val(date_naissance);
        modal.find('#lieu_naissance').val(lieu_naissance);
        modal.find('#sexe').val(sexe);
        modal.find('#type_piece').val(type_piece);
        modal.find('#numero_piece').val(numero_piece);
        modal.find('#adresse').val(adresse);
        modal.find('#superviseur').prop('checked', superviseur);
        modal.find('#statut').val(statut);
        modal.find('#gestionnaire').val(gestionnaire);
    });

    $("#delete").on('show.bs.modal', function(e){
        var button = $(e.relatedTarget);
        var id = button.data('id');
        var modal = $(this);

        modal.find('#id').val(id);
       
    });

  });
</script>

<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/assets/js/pages/simple-datatables.js"></script>
@endsection