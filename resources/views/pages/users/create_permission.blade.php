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
        <h3>Autorisations</h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Autorisations
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
        <div class="card-header">Liste des autrisations

            <span class="d-flex justify-content-end">
              <a href="javascript(0);" data-bs-toggle="modal" data-bs-target="#create" class="btn btn-primary btn-lg">
                  <i class="bi bi-plus"></i> Ajouter une autorisation
              </a>
            </span>
        </div>
        <div class="card-body">
          @if( $permissions->isNotEmpty() )
          <table class="table table-striped" id="table1">
            <thead>
              <tr>
                <th class="text-center">N°</th>
                <th class="text-center">NOM</th>
                <th class="text-center">DESCRIPTION</th>
                <th class="text-center">GROUPE</th>
                <th class="text-center">ACTIONS</th>
              </tr>
            </thead>
            <tbody>
              @php
              $i = 1;
              @endphp
              @foreach( $permissions as $r )
              <tr>
                <td class="text-center">{{ $i++ }}</td>
                <td class="text-center"><b>{{ $r->name }}</b></td>
                <td class="text-center">{{ $r->description }}</td>
                <td class="text-center">{{ $r->groupe }}</td>
                
                <td class="text-center">
                  <a href="javascript(0);" data-id="{{ $r->id }}" data-nom="{{ $u->nom }}" data-name="{{ $r->name }}" data-description="{{ $r->description }}" data-groupe="{{ $r->groupe }}" data-bs-toggle="modal" data-bs-target="#edit" class="btn btn-dark">
                    <i class="bi bi-pencil"></i> Modifier </a>
                  <a href="javascript(0);" data-id="{{ $r->id }}" data-bs-toggle="modal" data-bs-target="#delete" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Supprimer </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @else
            <div class="card card-inverse-danger mb-5">
              <div class="card-body">
                <p class="mb-4"> Vous n'avez pas encore ajouté d'autorisation !</p>
              </div>
            </div>
          @endif
        </div>
      </div>
    </section>
    @include('pages.users._modals._modal_permission')
@endsection

@section('js')
<script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="/assets/js/data-table.js"></script>
@endsection