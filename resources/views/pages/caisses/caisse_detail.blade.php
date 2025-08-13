  <div class="row">

    <div class="col-md-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4">Liste des caisses du <?= date('d/m/Y'); ?></h4>
          <div class="row overflow-auto">
            <div class="col-12">
              @if( $caisses->isNotEmpty() )
              <table id="order-listing" class="table" cellspacing="0" width="100%">
                <thead>
                  <tr class="bg-primary text-white">
                    <th>N°</th>
                    <th>Caisse</th>
                    <th>Solde Initial</th>
                    <th>Solde Final</th>
                    <th>Guichetier</th>
                    <th>Statut</th>
                    
                  </tr>
                </thead>
                <tbody>
                  @php
                  $i = 1;
                  @endphp
                  @foreach( $caisses as $r )
                  
                  <tr>
                    <td class="">{{ $i++ }}</td>
                    <td class=""><b>{{ $r->name }}</b></td>
                    <td class=""><b>{{ number_format($r->solde_initial, 0, 2, ' ') }} BIF</b></td>
                    
                    <td class=""><b>{{ number_format($r->solde_final, 0, 2, ' ') }} BIF</b></td>
                    <td class=""><b>{{ $r->nom }} {{ $r->prenom }}</b></td>
                    <td class="">
                    	@if($r->verify === 'no')
                    	<span class="badge badge-danger">En attente de validation</span>
                    	@else
                    	<span class="badge badge-success">Ouvert</span>
                    	@endif
                    </td>
                    
                  </tr>
                  
                  @endforeach
                </tbody>
              </table>
              @else
                  <div class="card card-inverse-danger mb-5">
                    <div class="card-body">
                      <p class=""> Vous n'avez pas encore Ouvert de caisse aujourd'hui le <b><?= date('d/m/Y'); ?></b>!</p>
                    </div>
                  </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
</div>