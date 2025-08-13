@extends('layouts.app_client')

@section('title', 'Demander-Paiement')

@section('content')

<div class="page-heading">

  <div class="page-title">

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


      <div class="col-12 col-md-6 order-md-1 order-last">

        <h3 style="text-transform: uppercase;">Demander Paiement</h3>

      </div>

      <div class="col-12 col-md-6 order-md-2 order-first">

        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">

          <ol class="breadcrumb">

            <li class="breadcrumb-item">

              <a href="{{ route('dashboard') }}">Tableau de bord</a>

            </li>

            <li class="breadcrumb-item active" aria-current="page">

              Demander Paiement

            </li>

          </ol>

        </nav>

      </div>

    </div>

</div>
<div class="section">
    <div class="card">
        <div class="card-header">
            Formulaire de Demande de Paiement
        </div>
        <div class="card-body">
            <form class="forms-sample" action="{{route('demander-paiement-valid')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="amount">Montant à demander <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="description">Description de la demande <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Demander le Paiement</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
