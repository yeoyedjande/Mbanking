@extends('layouts.template')

@section('title', 'Ajout Frais Dossier')

@section('link', 'ajout frais dossier')

@section('content')



<div class="page-heading">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>Ajouter des frais de dossier</h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Tableau de bord</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                Ajouter des frais de dossier
              </li>
            </ol>
          </nav>
        </div>
      </div>
  </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Alerts for success or error messages -->
        @if(session()->has('msg'))
            <div class="col-md-12">
                <div class="alert alert-success">{{ session()->get('msg') }}</div>
            </div>
        @endif
        @if(session()->has('msg_error'))
            <div class="col-md-12">
                <div class="alert alert-danger">{{ session()->get('msg_error') }}</div>
            </div>
        @endif

        <!-- Form for adding fees -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ajouter le montant de frais de dossier</h3>
                    </div>
                    <div class="card-body">
                        <!-- Your form elements go here -->
                        <!-- Example: -->
                        <form action="{{ route('ajout.frais.dossier.valid') }}" method="post">
                            @csrf
                            <!-- Your form fields go here -->
                            <div class="form-group">
                                <label for="amount">Montant du frais :</label>
                                <input type="number" name="amount" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter Frais</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/. container-fluid -->
</section>
<!-- /.content -->

@endsection
