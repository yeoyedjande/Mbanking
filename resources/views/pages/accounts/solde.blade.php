@extends('layouts.app')

@section('title', $title)

@section('css')
<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
@endsection

@section('content')
	<div class="page-header">
    <h3 class="page-title">Soldes des clients</h3>
    <div class="header-right d-flex flex-wrap  mt-md-2 mt-lg-0">
      
      <h3>Total des soldes: <span style="color: green;">{{ number_format($total_solde, 0, 2, ' ') }} BIF</span></h3>
    </div>
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
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4">Liste des soldes</h4>
          <div class="row overflow-auto">
            <div class="col-12">
              
              <table id="order-listing" class="table" cellspacing="0" width="100%">
                <thead>
                  <tr class="bg-primary text-white">
                    <th class="text-center">N°</th>
                    <th class="text-center">Numero de compte</th>
                    <th class="text-center">Client</th>
                    <th class="text-center">Solde</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $i = 1;
                  @endphp
                  
                  @foreach( $soldes as $v )
                  <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td class="text-center">{{ $v->number_account }}</td>
                    <td class="text-center"><b>{{ $v->nom }} @if( $v->prenom != 'NULL') {{ $v->prenom }} @endif</b></td>
                    <td class="text-center"><b>{{ number_format($v->solde, 0, 2, ' ') }} BIF</b></td>
                    
                  </tr>
                  @endforeach
                </tbody>
              </table>
              
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