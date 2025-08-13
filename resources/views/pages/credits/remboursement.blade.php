@extends('layouts.template')
@section('title', $title)

@section('content')

<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3 style="text-transform: uppercase;">{{ $title }}</h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">

              {{ $title }}

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

          <div class="card-body">

              <table class="table table-bordered">
                  <thead>
                    <tr>
                    <td colspan="6" class="text-center bg-secondary"><h4 style="color: white;">Première échéance non remboursée</h4></td>
                    </tr>
                    <th class="text-center">Numéro</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Capital Attendu</th>
                    <th class="text-center">Interêt Attendus</th>
                    <th class="text-center">Garantie Attendue</th>
                    <th class="text-center">Total Attendu</th>
                  </thead>
                  <tbody>

                      <tr>
                          <td class="text-center">{{ $echeancier->numero }}</td>
                          <td class="text-center">{{ $echeancier->date_echeance }}</td>
                          <td class="text-center">{{ number_format($echeancier->capital_attendu, 0, 2, ' ') }} BIF</td>
                          <td class="text-center">{{ number_format($echeancier->interet_attendu, 0, 2, ' ') }} BIF</td>
                          <td class="text-center">0</td>
                          <td class="text-center">{{ number_format($echeancier->capital_attendu + $echeancier->interet_attendu + $echeancier->garantie_attendu + $echeancier->penalite_attendu, 0, 2, ' ') }} BIF</td>
                      </tr>

                  </tbody>
              </table>
          </div>

        </div>

        <div class="card">


          <div class="card-body">

              <table class="table table-bordered">
                  
                  <thead>
                    <tr>
                    <td colspan="4" class="text-center bg-secondary"><h4 style="color: white;">Solde restant dû pour l'échéance</h4></td>
                    </tr>
                    <th class="text-center">Capital Restant dûs</th>
                    <th class="text-center">Interêt Restant dûs</th>
                    <th class="text-center">Garantie Restant dûes</th>
                    <th class="text-center">Total Attendu</th>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-center">{{ number_format($echeancier->capital_attendu, 0, 2, ' ') }} BIF</td>
                          <td class="text-center">{{ number_format($echeancier->interet_attendu, 0, 2, ' ') }} BIF</td>
                          <td class="text-center">0</td>
                          <td class="text-center">{{ number_format($echeancier->capital_attendu + $echeancier->interet_attendu + $echeancier->garantie_attendu + $echeancier->penalite_attendu, 0, 2, ' ') }} BIF</td>
                    </tr>
                  </tbody>
              </table>
              <form method="POST" action="{{ route('process-remboursement-valid') }}" class="mt-5">

                  {{ csrf_field() }}

                  <input type="hidden" name="numero_dossier" value="{{ $echeancier->dossier }}">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Date du Remboursement *</label>
                        <input type="text" name="date_remboursement" value="<?= date('d/m/Y'); ?>" class="form-control form-control-xl">
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Montant Total Dû (BIF) *</label>
                        <input readonly type="text" name="montant_du" value="{{ $echeancier->capital_attendu + $echeancier->interet_attendu + $echeancier->penalite_attendu + $echeancier->garantie_attendu}}" class="form-control form-control-xl">
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Numéro de compte lié *</label>
                        <input type="text" readonly name="numero_lie" value="{{ $credit->num_account }}" class="form-control form-control-xl">
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Solde compte lié (BIF) *</label>
                        <input type="text" readonly name="solde" readonly value="{{ $account->solde }}" class="form-control form-control-xl">
                      </div>
                    </div>

                    <div class="col-md-5">
                      <div class="form-group">
                        <label>Capital Attendus (BIF) *</label>
                        <input type="text" readonly name="capital_attendu" value="{{ $echeancier->capital_attendu }}" class="form-control form-control-xl">
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <label>Interêt Attendus (BIF) *</label>
                        <input type="text" readonly name="interet_attendu" value="{{ $echeancier->interet_attendu }}" class="form-control form-control-xl">
                      </div>
                    </div>

                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Numéro Echéance *</label>
                        <select class="form-control form-control-xl" name="num_echeance">
                          @foreach( $numero_echeances as $n )
                            <option value="{{ $n->numero }}" <?php if($n->numero == $echeancier->numero) ?>>{{ $n->numero }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Pénalité dû (BIF) *</label>
                        <input type="text" name="penalite_du" value="{{ $echeancier->penalite_attendu }}" class="form-control form-control-xl">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Garantie dûe (BIF) *</label>
                        <input type="text" name="garantie_du" value="{{ $echeancier->garantie_attendu }}" class="form-control form-control-xl">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Montant du remboursement (BIF) *</label>
                        <input type="text" style="color: green; font-weight: bold;" name="montant_remboursement" value="{{ $echeancier->capital_attendu + $echeancier->interet_attendu + $echeancier->penalite_attendu + $echeancier->garantie_attendu}}" class="form-control form-control-xl">
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="form-group">
                        <button class="btn btn-primary btn-lg" type="submit">Valider</button>
                      </div>
                    </div>

                  </div>
              </form>
              
          </div>

        </div>

        

    </section>



@endsection