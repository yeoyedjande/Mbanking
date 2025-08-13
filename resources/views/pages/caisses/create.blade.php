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
        <h3>Caisses</h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Caisses
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
        <div class="card-header">Liste des caisses

            <span class="d-flex justify-content-end">
              <a href="javascript(0);" data-bs-toggle="modal" data-bs-target="#create" class="btn btn-primary btn-lg">
                  <i class="bi bi-plus"></i> Ajouter une caisse
              </a>
            </span>
        </div>
        <div class="card-body">
          @if( $caisses->isNotEmpty() )
              <table id="table1" class="table table-striped">
                <thead>
                  <tr class="">
                    <th class="text-center">N°</th>
                    <th class="text-center">CAISSE</th>
                    <th class="text-center">AGENCE</th>
                    <th class="text-center">ACTION</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $i = 1;
                  @endphp
                  @foreach( $caisses as $r )
                  
                  <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td class="text-center"><b>{{ $r->name }}</b></td>
                    <td class="text-center"><b>{{ $r->nom_agence }}</b></td>
                    <td class="text-center">
                      

                      <a href="javascript(0);" data-nomagence="{{ $r->nom_agence }}" data-nom="{{ $r->name }}" data-id="{{ $r->id }}" data-bs-toggle="modal" data-bs-target="#edit" class="btn btn-dark">
                        <i class="mdi mdi-pencil"></i> Modifier </a>
                      <button data-id="{{ $r->id }}" data-bs-toggle="modal" data-bs-target="#delete" class="btn btn-danger">
                        <i class="mdi mdi-delete"></i> Supprimer </button>
                      

                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              @else
                  <div class="card card-inverse-danger mb-5">
                    <div class="card-body">
                      <p class="mb-4"> Vous n'avez pas encore ajouté de caisse !</p>
                    </div>
                  </div>
              @endif
        </div>
      </div>
    </section>

    @include('pages.caisses.master._caisse_modal')
@endsection

@section('js')

<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script>

  $(document).ready(function() {

    $("#edit").on('show.bs.modal', function(e){
        var button = $(e.relatedTarget);
        var id = button.data('id');
        var nom = button.data('nom');
        var modal = $(this);

        modal.find('#id').val(id);
        modal.find('#nom').val(nom);
       
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