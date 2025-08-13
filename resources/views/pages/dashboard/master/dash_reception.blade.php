<div class="page-heading">
  <div class="row">
      <div class="col-md-6">
        <h3>Tableau de bord</h3>
      </div>
      <div class="col-md-6 d-flex justify-content-end">
        <span>
            <h4>Receptionniste: {{ Auth()->user()->nom }} {{ Auth()->user()->prenom }}</h4>
            <b><i class="bi bi-clock"></i> Heure locale: <?= date('d/m/Y H:i'); ?></b>
        </span>
      </div>
  </div>
  
</div>
<div class="page-content">

<section class="row">
  <div class="col-12 col-lg-12">
    <div class="row">
      <div class="col-6 col-lg-4 col-md-6">
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
                  Clients
                </h4>
                <h4 class="font-extrabold mb-0">{{ number_format($nb_client, 0, 2, ' ') }} </h4>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-4 col-md-6">
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
                <h4 class="text-muted font-semibold">Montage de credits</h4>
                <h4 class="font-extrabold mb-0">{{ $nb_demande }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-6 col-lg-4 col-md-6">
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
                <h4 class="text-muted font-semibold">Correspondance</h4>
                <h4 class="font-extrabold mb-0">2</h4>
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
            <h4>Listes des demandes</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              @if( $demandes->isNotEmpty() )
              <table id="order-listing" class="table" cellspacing="0" width="100%">
              <thead>
                <tr class="" style="text-transform: uppercase;">
                  <th class="text-center">N°</th>
                  <th class="text-center">Type de credit</th>
                  <th class="text-center">Client</th>
                  <th class="text-center">Montant</th>
                  <th class="text-center">Date de la demande</th>
                  <th class="text-center">Actions</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $i = 1;
                  @endphp
                  
                  @foreach( $demandes as $d )

                  <?php 
                    $assign = DB::table('analyste_demandes')
                    ->Where('demande', $d->id)
                    ->first();
                  ?>
                  <tr>
                      <td class="text-center">{{ $i++ }}</td>
                      <td class="text-center">{{$d->type_credit}}</td>

                      <td class="text-center">

                          {{ $d->nom }} @if($d->prenom != 'NULL') {{ $d->prenom }} @endif
                          
                      </td>


                      <td class="text-center"><b>{{ number_format($d->montant_demande, 0, 2, ' ') }} BIF</b></td>
                      <td class="text-center"><b>
                        {{ $d->created_at }}
                      </b></td>

                      
                      <td class="text-center">
                          <a href="#" style="padding: 15px;" class="btn btn-dark btn-sm"><i class="bi bi-pencil"></i> </a>
                          <a href="#" style="padding: 15px;" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> </a>
                          
                      </td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
              @else
                <div class="alert alert-danger">
                  <h4 class="alert-heading">Info</h4>
                  <p>Il n'y a pas de demandes disponible en ce moment</b>!</p>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</section>