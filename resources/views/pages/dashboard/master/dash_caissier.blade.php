<div class="page-heading">

  <div class="row">

      <div class="col-md-6">

        <h3>Tableau de bord</h3>

      </div>

      <div class="col-md-6 d-flex justify-content-end">

        <span>

            <h4>Guichetier: {{ Auth()->user()->nom }} {{ Auth()->user()->prenom }}</h4>

            <b><i class="bi bi-clock"></i> Heure locale: <?= date('d/m/Y H:i'); ?></b>

        </span>

      </div>

  </div>

  

</div>

<div class="page-content">



<section class="row">

  <div class="col-12 col-lg-12">

    <div class="row">

      <div class="col-md-6">

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

                  Solde en cours

                </h4>

                <h4 class="font-extrabold mb-0"><?php if (isset($verif_caisse)): ?>

              {{ number_format($verif_caisse->solde_final, 0, 2, ' ') }} BIF

              <?php else: ?>

                0 BIF

            <?php endif ?></h4>

              </div>

            </div>

          </div>

        </div>

      </div>

      <div class="col-md-6">

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

                <h4 class="text-muted font-semibold">Solde à l'ouverture</h4>

                <h4 class="font-extrabold mb-0"><?php if (isset($verif_caisse)): ?>

                @if( $verif_caisse->verify == 'ferme')
                 0 BIF 
                @else
                {{ number_format($verif_caisse->solde_initial, 0, 2, ' ') }} BIF
                @endif
              <?php else: ?>

                0 BIF

            <?php endif ?></h4>

              </div>

            </div>

          </div>

        </div>

      </div>

      <div class="col-md-6">

        <div class="card">

          <div class="card-body px-4 py-4-5">

            <div class="row">

              <div

                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"

              >

                <div class="stats-icon green mb-2">

                  <i class="iconly-boldAdd-User"></i>

                </div>

              </div>

              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">

                <h4 class="text-muted font-semibold">Versements</h4>

                <h4 class="font-extrabold mb-0">{{ number_format($som_versement, 0, 2, ' ') }} BIF</h4>

              </div>

            </div>

          </div>

        </div>

      </div>

      <div class="col-md-6">

        <div class="card">

          <div class="card-body px-4 py-4-5">

            <div class="row">

              <div

                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start"

              >

                <div class="stats-icon red mb-2">

                  <i class="iconly-boldBookmark"></i>

                </div>

              </div>

              <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">

                <h4 class="text-muted font-semibold">Retraits</h4>

                <h4 class="font-extrabold mb-0">{{ number_format($som_retrait, 0, 2, ' ') }} BIF</h4>

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

            <div id="bar"></div>

          </div>

        </div>

      </div>

    </div>

    <div class="row">

      <div class="col-12 col-xl-12">

        <div class="card">

          <div class="card-header">

            <h4>Listes des recentes transactions</h4>

            @if( $transactions_caissier->isNotEmpty() )

            <span class="d-flex justify-content-end">

              <a href="{{ route('all-operations') }}" class="btn btn-primary btn-lg">

                  <i class="bi bi-eye"></i> Voir toutes les transactions

              </a>

            </span>

            @endif

          </div>

          <div class="card-body">

            <div class="table-responsive">

              @if( $transactions_caissier->isNotEmpty() )

              <table class="table table-bordered table-lg">

                <thead>

                  <tr style="text-transform: uppercase;">

                    <th>N°</th>

                    <th>Date Opération</th>

                    <th>De</th>

                    <th>Vers</th>

                    <th>Type d'opération</th>

                    <th>Montant</th>

                    <th>Actions</th>

                  </tr>

                </thead>

                <tbody>



                  @php

                    $i = 1;

                    @endphp

                    

                    @foreach( $transactions_caissier as $m )

                    <tr>

                        <td>{{ $i++ }}</td>

                        <td>{{$m->date_op}}</td>



                        <td>



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



                        <td>



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



                        <td>{{ $m->name }}</td>

                        <td><b>{{ number_format($m->montant, 0, 2, ' ') }} BIF</b></td>



                        <td>

                          <a href="#" class="btn btn-success">

                          <i class="mdi mdi-eyes"></i>Détails </a>

                        </td>

                    </tr>

                    @endforeach

                  

                </tbody>

              </table>

              @else

              <div class="alert alert-info">

                <h4 class="alert-heading">Info</h4>

                <p>Il n'y a pas de transactions disponible en ce moment !</p>

              </div>

              @endif

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>





 <!-- <div class="col-12 col-lg-3">

    <div class="card">

      <div class="card-body py-4 px-4">

        <div class="d-flex align-items-center">

          <div class="avatar avatar-xl">

            <img src="assets/images/faces/1.jpg" alt="Face 1" />

          </div>

          <div class="ms-3 name">

            <h5 class="font-bold">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</h5>

            <h6 class="text-muted mb-0">Aujourd'hui le: <?= date('d/m/Y H:i:s'); ?></h6>

          </div>

        </div>

      </div>

    </div>

  </div>-->

</section>