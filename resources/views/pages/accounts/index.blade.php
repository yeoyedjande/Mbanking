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
        <h3 style="text-transform: uppercase;">Liste des clients</h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Liste des clients
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
        <div class="card-header d-flex justify-content-end">
            
              <a href="{{ route('account-index') }}" class="btn btn-primary btn-lg">
                  <i class="bi bi-plus"></i> Ouvrir un compte
              </a>
            
        </div>
        <div class="card-body">
          @if( $membres->isNotEmpty() )
          <table class="table table-striped" id="table1">
            <thead>
              <tr style="text-transform: uppercase;">
                <th class="text-center">N°</th>
                <th class="text-center">Numéro de compte</th>
                <th class="text-center">Type de compte</th>
                <th class="text-center">Nom et Prénom(s)</th>
                <th class="text-center">Téléphone</th>
                <th class="text-center">Statut</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              @php
              $i = 1;
              @endphp
              @foreach( $membres as $m )
              <tr>
                <td class="text-center">{{ $i++ }}</td>
                <td class="text-center">{{ $m->number_account }}</td>
                <td class="text-center">{{ $m->type }}</td>
                <td class="text-center">{{ $m->nom }} @if($m->prenom != 'NULL') {{ $m->prenom }} @endif</td>
                <td class="text-center">{{ $m->telephone }}</td>
                <td class="text-center"><span class="badge bg-success">Actif</span></td>
                
                <td class="text-center">
                  <a href="javascript(0);" title="Details" data-id="{{ $m->id }}" data-nom="{{ $m->nom }}" data-prenom="{{ $m->prenom }}" data-bs-toggle="modal" data-bs-target="#edit" class="btn btn-info btn-lg">
                    <i class="bi bi-list"></i></a>
                  <a href="javascript(0);" title="Modifier" data-id="{{ $m->id }}" data-nom="{{ $m->nom }}" data-prenom="{{ $m->prenom }}" data-bs-toggle="modal" data-bs-target="#edit" class="btn btn-dark btn-lg">
                    <i class="bi bi-pencil"></i> </a>
                  <a href="javascript(0);" title="Supprimer" data-id="{{ $m->id }}" data-bs-toggle="modal" data-bs-target="#delete" class="btn btn-danger btn-lg">
                    <i class="bi bi-trash"></i> </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @else
            <div class="card card-inverse-danger mb-5">
              <div class="card-body">
                <p class="mb-4"> Vous n'avez pas encore ajouté de clients !</p>
              </div>
            </div>
          @endif
        </div>
      </div>
    </section>


 <div class="modal fade" id="addVersement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Faire un versement</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success">Submit</button>
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script>

  $(document).ready(function() {

    $("#edit").on('show.bs.modal', function(e){
        var button = $(e.relatedTarget);
        var id = button.data('id');
        var nom = button.data('nom');
        var prenom = button.data('prenom');
        var email = button.data('email');
        var agence = button.data('agence');
        var role_name = button.data('rolename');
        var modal = $(this);

        modal.find('#id').val(id);
        modal.find('#nom').val(nom);
        modal.find('#prenom').val(prenom);
        modal.find('#email').val(email);
        modal.find('#role').val(role_name);
        modal.find('#agence').val(agence);
        //modal.find('#id').val(id);
       
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