@extends('layouts.template')

@section('title', 'Fermeture de caisse')

@section('css')
  <link rel="stylesheet" href="/assets/printjs/print.css" />
@endsection

@section('content')

<div class="page-heading">

  <div class="row">

      <div class="col-md-6">

        <h3>Fermeture de caisse du: <?= date('d/m/Y'); ?></h3>

      </div>

      <div class="col-md-6 d-flex justify-content-end">

        <span>

            <h4>Guichetier: {{ Auth()->user()->nom }} {{ Auth()->user()->prenom }}</h4>

            <b><i class="bi bi-clock"></i> Heure locale: <?= date('d/m/Y H:i'); ?></b>

        </span>

      </div>

  </div>
</div>



<section class="row">

      <div class="card">



          <div class="card-body text-center">

              <h2>

              <span class="bi bi-clock"></span></h2>

              <h3 class="mb-4" style="color: green;">

                Bravo <i class="bi bi-hand-thumbs-up-fill"></i>!!!  <br>

                Vous avez fermé la caisse de cette journée, <br>on se donne RDV demain pour une nouvelle caisse.

              </h3>   



              <table class="table table-striped" id="table1">
                  <thead>
                    <tr style="text-transform: uppercase;">
                      <th class="text-center">Montant à l'ouverture</th>
                      <th class="text-center">Montant de clôture</th>
                      <th class="text-center">Total retrait</th>
                      <th class="text-center">Total versement</th>
                      <th class="text-center">Montant en cash</th>
                      <th class="text-center">Caisse</th>
                      <th class="text-center">Caisse tenue par</th>
                      
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>

                    @php $i = 1; @endphp

                    <?php 
                      $versements = DB::table('operation_mouvements')->join('operations', 'operations.id', '=', 'operation_mouvements.operation_id')
                        ->join('users', 'users.id', '=', 'operations.user_id')
                        ->Where('operation_mouvements.mouvement_id', $data_fermeture->id)
                        ->Where('operations.type_operation_id', 3)
                        ->get();

                        $total_versement = 0;

                        foreach ($versements as $v) {
                          $total_versement = $total_versement + $v->montant;
                        }

                        $retraits = DB::table('operation_mouvements')->join('operations', 'operations.id', '=', 'operation_mouvements.operation_id')
                        ->join('users', 'users.id', '=', 'operations.user_id')
                        ->Where('operation_mouvements.mouvement_id', $data_fermeture->id)
                        ->Where('operations.type_operation_id', 2)
                        ->get();

                        $total_retrait = 0;

                        foreach ($retraits as $r) {
                          $total_retrait = $total_retrait + $r->montant;
                        }

                     ?>
                    <tr>
                      <td class="text-center"><b>{{ number_format($data_fermeture->solde_initial, 0, 2, ' ') }} BIF</b></td>
                      <td class="text-center"><b>{{ number_format($data_fermeture->solde_fermeture, 0, 2, ' ') }} BIF</b></td>
                      <td class="text-center"><b>{{ number_format($total_retrait, 0, 2, ' ') }} BIF</b></td>
                      <td class="text-center"><b>{{ number_format($total_versement, 0, 2, ' ') }} BIF</b></td>
                      <td class="text-center"><b>{{ number_format($data_fermeture->solde_fermeture, 0, 2, ' ') }} BIF</b></td>
                      <td class="text-center">{{ $data_fermeture->name }}</td>
                      <td class="text-center">{{ $data_fermeture->nom }} @if($data_fermeture->prenom != 'NULL' ) {{ $data_fermeture->prenom }} @endif</td>

                      <td class="text-center">
                        <a href="{{ route('caisse-cloture-print-End') }}" target="_blank" class="btn btn-primary btn-xs"><i class="bi bi-printer"></i> Imprimer</a>                        
                      </td>
                    </tr>
                    
                  </tbody>
                </table>

          </div>


      </div>

  </section>
@endsection

@section('js')

<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script src="/assets/printjs/print.js"></script>
<script>
    function generatePdf() {
        printJS({
            printable: 'table1',
            type: 'html',
            css: '/assets/printjs/print.css',
            ignoreElements: ['.page-heading']
        })
    }
</script>

@endsection