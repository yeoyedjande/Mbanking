@extends('layouts.template')



@section('title', 'Détails du dossier')



@section('content')

<div class="page-heading">
  <div class="page-title">
    <div class="row">

        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3><span style="color: green;">Dossier N° {{ $dossier }}</span></h3>
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
</div>

<section class="section">

   <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Détails sur le compte</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
             
                <table class="table table-bordered">
                        <tr>
                          <td colspan="2"></td>
                          <td colspan="4" style="font-weight: bold; text-align: center;">Attendu</td>
                          <td colspan="4" style="font-weight: bold; text-align: center;">Remboursé</td>
                        </tr>

                        <tr style="">

                          <td class="text-center">N°</td>
                          <td class="text-center">Date</td>
                          <td class="text-center">Capital Attendus</td>
                          <td class="text-center">Intérêts Attendus</td>
                          <td class="text-center">Garantie Attendus</td>
                          <td class="text-center">Capital Remb</td>
                          <td class="text-center">Intérêts Remb</td>
                          <td class="text-center">Garantie Remb</td>
                          <td class="text-center">Pénalité Remb</td>
                          <td class="text-center">Total</td>
                          <td class="text-center">Jour retard</td>
                          <td class="text-center">Clôturé</td>

                        </tr>
                      

                        @foreach( $echeances as $e )

                        <tr>

                          <td class="text-center">
                            <a href="javascript(0);" data-bs-toggle="modal" data-bs-target="#detail" class="btn btn-secondary">{{ $e->numero }}</a>
                          </td>

                          <td class="text-center">
                              {{ $e->date_echeance }}
                          </td>



                          <td class="text-center">

                            {{ number_format($e->capital_attendu, 0, 2, ' ') }} BIF
                          </td>

                          <td class="text-center">{{ number_format($e->interet_attendu, 0, 2, ' ') }} BIF</td>

                          <td class="text-center">{{ number_format($e->garantie_attendu, 0, 2, ' ') }} BIF</td>

                          <td class="text-center">

                            {{ number_format($e->capital_remb, 0, 2, ' ') }} BIF
                            
                          </td>



                          <td class="text-center">{{ number_format($e->interet_remb, 0, 2, ' ') }} BIF</td>

                          <td class="text-center">{{ number_format($e->garantie_remb, 0, 2, ' ') }} BIF</td>

                          <td class="text-center">{{ number_format($e->penalite_remb, 0, 2, ' ') }} BIF</td>

                          <td class="text-center">{{ number_format($e->montant_total_remb, 0, 2, ' ') }} BIF</td>
                          <td class="text-center">{{ $e->nbr_jour_retard }}</td>
                          <td class="text-center"><?php echo strtoupper($e->echeance_cloture); ?></td>
                        </tr>

                        @endforeach

                    </table>

            </div>
          </div>
        </div>
      </div>
    </div>
</section>

<div class="modal fade text-left w-100" id="detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <sapn class="modal-title" id="myModalLabel16">
            DETAILS ECHEANCE NUMERO 
          </sapn>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">
            
            <table class="table table-bordered">
              <thead>
                <tr>
                    <td class="text-center">N°</td>
                    <td class="text-center">Date Remboursement</td>
                    <td class="text-center">Capital Remb</td>
                    <td class="text-center">Intérêts Remb</td>
                    <td class="text-center">Pénalité Remb</td>
                </tr>

              </thead>

              <tbody>
                <tr>

                </tr>
              </tbody>
            </table>

        </div>
      </div>
    </div>
</div>
@endsection

