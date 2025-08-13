@extends('layouts.app')

@section('title', $title)

@section('css')
<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
@endsection
@section('content')
	<div class="page-header">
    <h3 class="page-title">Edition de permission</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"> Edition de permission </li>
      </ol>
    </nav>
  </div>

  <div class="row">

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
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4">Editer une permission</h4>
          <form class="forms-sample" action="{{ route('permission-edit-valid') }}" method="POST">

            {{ csrf_field() }}
            <input type="hidden" value="{{ $permission->id }}" name="permission_id">
            <div class="form-group">
              <label for="nom">Name* </label>
              <input type="text" class="form-control" id="nom" name="nom" required placeholder="Nom de la permission *" value="{{ $permission->name }}" autocomplete="0" />
            </div>
            <div class="form-group">
              <label for="groupe">Groupe * </label>
              <input type="text" style="text-transform: uppercase;" value="{{ $permission->groupe }}" class="form-control" id="groupe" name="groupe" required placeholder="UTILISATEURS *" autocomplete="0" />
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" id="description" rows="5" name="description">{{ $permission->description }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary me-2"> Editer </button>
            <button class="btn btn-light" type="reset">Cancel</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-8 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4">Liste des Permissions</h4>
          <div class="row overflow-auto">
            <div class="col-12">
              @if( $permissions->isNotEmpty() )
              <table id="order-listing" class="table" cellspacing="0" width="100%">
                <thead>
                  <tr class="bg-primary text-white">
                    <th>N°</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Groupe</th>
                    <th>Actions</th>
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
                      <a href="{{ route('permission-edit', $r->id) }}" class="btn btn-info">
                        <i class="mdi mdi-pencil"></i>Modifier </a>
                      <button class="btn btn-danger">
                        <i class="mdi mdi-delete"></i>Supprimer </button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
              @else
                  <div class="card card-inverse-danger mb-5">
                    <div class="card-body">
                      <p class="mb-4"> Vous n'avez pas encore ajouté de permission !</p>
                    </div>
                  </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
<script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="/assets/js/data-table.js"></script>
@endsection