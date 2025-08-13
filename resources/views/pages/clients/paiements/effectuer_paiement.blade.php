@extends('layouts.app_client')

@section('title', 'Effectuer-Paiement')

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 style="text-transform: uppercase;">Effectuer un Paiement</h3>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}">Tableau de bord</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Effectuer un Paiement
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="section">
        <div class="card">
            <div class="card-header">
                Formulaire pour Effectuer un Paiement
            </div>
        </div>
        <div class="card-body">
            @if( session()->has('msg_success') )

          <div class="col-md-12">

            <div class="alert alert-success">{{ session()->get('msg_success') }}</div>

          </div>

          @endif 
            <form class="forms-sample" action="{{route('effectuer-paiement-valid')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="recipient">Bénéficiaire <span class="text-danger">*</label>
                            <input type="text" class="form-control" id="recipient" name="beneficiaire" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">Montant à payer <span class="text-danger">*</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Effectuer le Paiement</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

    
