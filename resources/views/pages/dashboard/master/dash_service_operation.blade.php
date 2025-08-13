<div class="page-heading">
  <div class="row">
      <div class="col-md-6">
        <h3>Tableau de bord</h3>
      </div>
      <div class="col-md-6 d-flex justify-content-end">
        <span>
            <h4>Service Opérations: {{ Auth()->user()->nom }} {{ Auth()->user()->prenom }}</h4>
            <b><i class="bi bi-clock"></i> Heure locale: <?= date('d/m/Y H:i'); ?></b>
        </span>
      </div>
  </div>
  
</div>
<div class="page-content">

<section class="row">
  <div class="col-12 col-lg-12">
    <div class="row">
      <div class="col-6 col-lg-6 col-md-6">
        <div class="card">
          <div class="card-body px-4 py-4-5">
            <div class="row">
              <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                <div class="stats-icon purple mb-2">
                  <i class="iconly-boldShow"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <h4 class="text-muted font-semibold">
                  Transactions En attente
                </h4>
                <h4 class="font-extrabold mb-0">{{ $nb_client }} </h4>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-6 col-md-6">
        <div class="card">
          <div class="card-body px-4 py-4-5">
            <div class="row">
              <div
                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"
              >
                <div class="stats-icon blue mb-2">
                  <i class="iconly-boldProfile"></i>
                </div>
              </div>
              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <h4 class="text-muted font-semibold">Transactions Valides</h4>
                <h4 class="font-extrabold mb-0">{{ $nb_demande }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Affichage graphique</h4>
          </div>
          <div class="card-body">
            <div id="area"></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-xl-12">
        <div class="card">
          <div class="card-header">
            <h4>Listes des transactions</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              @if( $transactions->isNotEmpty() )
              <table id="table1" class="table" cellspacing="0">
                <thead>
                  <tr class="bg-primary text-white">
                    <th class="text-center">N°</th>
                    <th class="text-center">Date Opération</th>
                    <th class="text-center">De</th>
                    <th class="text-center">Vers</th>
                    <th class="text-center">Type d'opération</th>
                    <th class="text-center">Montant</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $i = 1;
                    @endphp
                    
                    @foreach( $transactions as $m )
                    <tr>
                        <td class="text-center">{{ $i++ }}</td>
                        <td class="text-center">{{$m->date_op}}</td>

                        <td class="text-center">

                            @if( $m->name == 'Versement' )
                            Compte principal
                            @elseif( $m->name == 'Retrait' )
                            {{ $m->nom }} @if($m->prenom != 'NULL') {{ $m->prenom }} @endif

                            @else

                            <?php 
                              $exp = DB::table('operations')
                              ->join('accounts', 'accounts.number_account', '=', 'operations.account_id')
                              ->join('clients', 'clients.id', '=', 'accounts.client_id')
                              ->Where('operations.account_id', $m->account_id)
                              ->first();

                              //var_dump($dest->nom);
                            ?>

                            {{ $exp->nom }} @if($exp->prenom != 'NULL') {{ $exp->prenom }} @endif

                            @endif
                          
                        </td>

                        <td class="text-center">

                          @if( $m->name == 'Versement' )
                            {{ $m->nom }} @if($m->prenom != 'NULL') {{ $m->prenom }} @endif
                            @elseif( $m->name == 'Retrait' )
                            
                            Compte principal
                            @else

                            <?php 
                              $dest = DB::table('operations')
                              ->join('accounts', 'accounts.number_account', '=', 'operations.account_dest')
                              ->join('clients', 'clients.id', '=', 'accounts.client_id')
                              ->Where('operations.account_dest', $m->account_dest)
                              ->first();

                              //var_dump($dest->nom);
                            ?>
                            {{ $dest->nom }} @if($dest->prenom != 'NULL') {{ $dest->prenom }} @endif
                            
                            @endif

                        </td>

                        <td class="text-center">{{ $m->name }}</td>
                        <td class="text-center"><b>{{ number_format($m->montant, 0, 2, ' ') }} BIF</b></td>

                        <td class="text-center">
                          <a href="#" class="btn btn-primary btn-xs">
                          <i class="bi bi-printer"></i> Imprimer le reçu</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
              @else
                <div class="alert alert-danger">
                  <h4 class="alert-heading">Info</h4>
                  <p>Il n'y a pas de transactions disponible en ce moment</b>!</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>