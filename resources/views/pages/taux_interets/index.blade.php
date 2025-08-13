@extends('layouts.app')

@section('title', $title)

@section('css')
<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
@endsection

@section('content')
	<div class="page-header">
    <h3 class="page-title">Taux d'interets</h3>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"> Taux d'interets </li>
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
          <h4 class="card-title mb-4">Créer un taux</h4>
          <form class="forms-sample" action="{{ route('taux-interet-create') }}" method="POST">

            {{ csrf_field() }}
            <div class="form-group">
              <label for="taux">Saisie le taux en pourcentage (%) * </label>
              <input type="number" class="form-control" id="taux" name="taux" required autocomplete="0" />
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
          <h4 class="card-title mb-4">Liste des taux d'interets</h4>
          <div class="row overflow-auto">
            <div class="col-12">
              @if( $taux->isNotEmpty() )
              <table id="order-listing" class="table" cellspacing="0" width="100%">
                <thead>
                  <tr class="bg-primary text-white">
                    <th>N°</th>
                    <th>Taux</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $i = 1;
                  @endphp
                  @foreach( $taux as $d )
                  <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td class="text-center"><b>{{ $d->taux * 100 }}%</b></td>
                    <td class="text-center">
                      <a href="{{ route('taux-interet-get', $d->id) }}" class="btn btn-info">
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
                      <p class="mb-4"> Vous n'avez pas encore ajouté de taux !</p>
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