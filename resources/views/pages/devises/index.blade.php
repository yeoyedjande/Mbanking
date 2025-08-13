@extends('layouts.app')

@section('title', $title)

@section('css')
<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
@endsection

@section('content')
	<div class="page-header">
    <h3 class="page-title">Monnaies</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"> Monnaies </li>
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
          <h4 class="card-title mb-4">Créer une monnaie</h4>
          <form class="forms-sample" action="{{ route('devise-create-valid') }}" method="POST">

            {{ csrf_field() }}
            <div class="form-group">
              <label for="name">Symbole de la monnaie * </label>
              <input type="text" class="form-control" id="name" name="name" required placeholder="F CFA" autocomplete="0" />
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" id="description" rows="5" name="description"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary me-2"> Créer </button>
            <button class="btn btn-light" type="reset">Cancel</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-8 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4">Liste des devises</h4>
          <div class="row overflow-auto">
            <div class="col-12">
              @if( $devises->isNotEmpty() )
              <table id="order-listing" class="table" cellspacing="0" width="100%">
                <thead>
                  <tr class="bg-primary text-white">
                    <th>N°</th>
                    <th>Monnaie</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $i = 1;
                  @endphp
                  @foreach( $devises as $d )
                  <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td class="text-center"><b>{{ $d->name }}</b></td>
                    <td class="text-center">{{ $d->description }}</td>
                    <td class="text-center">
                      <button class="btn btn-info">
                        <i class="mdi mdi-pencil"></i>Modifier </button>
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
                      <p class="mb-4"> Vous n'avez pas encore ajouté de devise !</p>
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