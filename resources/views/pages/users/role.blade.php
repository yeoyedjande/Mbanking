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
        <h3>Roles</h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Roles
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
        <div class="card-header">Liste des roles

            <span class="d-flex justify-content-end">
              <a href="javascript(0);" data-bs-toggle="modal" data-bs-target="#create" class="btn btn-primary btn-lg">
                  <i class="bi bi-plus"></i> Ajouter un role
              </a>
            </span>
        </div>
        <div class="card-body">
          @if( $roles->isNotEmpty() )
              <table id="table1" class="table table-striped">
                <thead>
                  <tr class="">
                    <th class="text-center">N°</th>
                    <th class="text-center">NOM DU ROLE</th>
                    <th class="text-center">ACTIONS</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $i = 1;
                  @endphp
                  @foreach( $roles as $r )
                  @if( $r->id != 1 )
                  <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td class="text-center"><b>{{ $r->name }}</b></td>
                    <td class="text-center">
                      
                      <button data-bs-toggle="modal" data-description="{{ $r->guard_name }}" data-nom="{{ $r->name }}" data-id="{{ $r->id }}" data-bs-target="#edit" class="btn btn-dark" title="Modifier">
                        <i class="bi bi-pencil"></i> </button>
                      <button data-bs-toggle="modal" data-id="{{ $r->id }}" data-bs-target="#delete" class="btn btn-danger" title="Supprimer">
                        <i class="bi bi-trash"></i> </button>
                      

                    </td>
                  </tr>
                  @endif
                  @endforeach
                </tbody>
              </table>
              @else
                  <div class="card card-inverse-danger mb-5">
                    <div class="card-body">
                      <p class="mb-4"> Vous n'avez pas encore ajouté de Rôle !</p>
                    </div>
                  </div>
              @endif
        </div>
      </div>
    </section>

    @include('pages.users._modals._modal_role')
@endsection

@section('js')

<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script>

  $(document).ready(function() {

    $("#edit").on('show.bs.modal', function(e){
        var button = $(e.relatedTarget);
        var id = button.data('id');
        var nom = button.data('nom');
        var description = button.data('description');
        var modal = $(this);

        modal.find('#id').val(id);
        modal.find('#nom').val(nom);
        modal.find('#description').val(description);
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