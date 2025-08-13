@extends('layouts.template')
@section('title', 'Opérations')

@section('content')

<div class="page-heading">
  <div class="page-title">
    <div class="row">

        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3><span style="color: green;">{{ $verif->nom }}  {{ $verif->prenom }}</span></h3>
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
            <h4 class="card-title">Opérations du compte #{{ $number_account }}</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <div class="list-group list-group-horizontal-sm mb-1 text-center" role="tablist">
                <a class="list-group-item list-group-item-action active" id="op-list" data-bs-toggle="list" href="#op" role="tab">Opérations</a>
                <a class="list-group-item list-group-item-action" id="resume-list" data-bs-toggle="list" href="#resume" role="tab">Resumé de compte</a>
                <a class="list-group-item list-group-item-action" id="credit-list" data-bs-toggle="list" href="#credit" role="tab">Suivi de crédit</a>
                <a class="list-group-item list-group-item-action" id="info-personnelle-list" data-bs-toggle="list" href="#info-personnelle" role="tab">Informations personnelles</a>
              </div>

              <div class="tab-content text-justify mb-5">
                <div class="tab-pane fade show active" id="op" role="tabpanel" aria-labelledby="op-list">
                    <table class="table table-bordered mt-5" id="table1">
                        <thead>
                          <tr style="text-transform: uppercase;">
                            <th class="text-center">REFERENCE</th>
                            <th class="text-center">Date Opérations</th>
                            <th class="text-center">Guichetier</th>
                            <th class="text-center">Montant</th>
                            <th class="text-center">Type Opération</th>
                          </tr>
                        </thead>

                        <tbody>

                            @php $i = 1; @endphp

                            @foreach( $detail_transaction as $d )
                              <tr>
                                  <td class="text-center"> {{ $d->ref }} </td>
                                  <td class="text-center"> {{ $d->date_op }} </td>
                                  <td class="text-center"> {{ $d->matricule }} </td>
                                  <td class="text-center">{{ number_format($d->montant, 0, 2, ' ') }} BIF</td>
                                  <td class="text-center">

                                      @if( $d->type_operation_id == '2' )

                                      Retrait

                                      @elseif( $d->type_operation_id == '3' )

                                      Versement

                                      @else

                                      Virement

                                      @endif
                                      
                                  </td>
                              </tr>
                              <?php 

                                  $f = DB::table('operations')->join('type_frais', 'type_frais.id', '=', 'operations.frais')->Select('type_frais.*')->Where('operations.id', $d->id)->first();

                                  //var_dump($d->id);
                                  if ( $f ) {
                                  
                              ?>

                              <tr>
                                  <td class="text-center"> {{ $f->reference }} </td>
                                  <td class="text-center"> {{ $d->date_op }} </td>
                                  <td class="text-center"> {{ $d->matricule }} </td>
                                  <td class="text-center">{{ number_format($f->montant, 0, 2, ' ') }} BIF</td>
                                  <td class="text-center">

                                      {{ $f->name }}
                                      
                                  </td>
                              </tr>
                              <?php } ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="tab-pane fade" id="resume" role="tabpanel" aria-labelledby="resume-list">
                    <table class="table table-bordered mt-5" id="table1">
                        <thead>
                          <tr style="text-transform: uppercase;">
                            <th class="text-center">TYPE DE COMPTE</th>
                            <th class="text-center">NUMÉRO DE COMPTE</th>
                            <th class="text-center">DATE DE CRÉATION</th>
                            <th class="text-center">SOLDE</th>
                          </tr>
                        </thead>

                        <tbody>

                            @php $i = 1; @endphp

                            @foreach( $info_accounts as $d )
                              <tr>
                                  <td class="text-center"> {{ $d->name }} </td>
                                  <td class="text-center"> <a href="{{ route('accounts-operation', $d->number_account) }}" title="Liste des opérations">{{ $d->number_account }}</a> </td>
                                  <td class="text-center"> {{ $d->date_ouverture_compte }} </td>
                                  <td class="text-center"><b>{{ number_format($d->solde, 0, 2, ' ') }} BIF</b></td>
                                  
                              </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <h4 class="card-title mt-5">Opérations récentes</h4>
                    <table class="table table-bordered" id="table1">
                        <thead>
                          <tr style="text-transform: uppercase;">
                            <th class="text-center">REFERENCE</th>
                            <th class="text-center">Date Opérations</th>
                            <th class="text-center">Guichetier</th>
                            <th class="text-center">Montant</th>
                            <th class="text-center">Type Opération</th>
                          </tr>
                        </thead>

                        <tbody>

                            @php $i = 1; @endphp

                            @foreach( $detail_transaction as $d )
                              <tr>
                                  <td class="text-center"> {{ $d->ref }} </td>
                                  <td class="text-center"> {{ $d->date_op }} </td>
                                  <td class="text-center"> {{ $d->matricule }} </td>
                                  <td class="text-center">{{ number_format($d->montant, 0, 2, ' ') }} BIF</td>
                                  <td class="text-center">

                                      @if( $d->type_operation_id == '2' )

                                      Retrait

                                      @elseif( $d->type_operation_id == '3' )

                                      Versement

                                      @else

                                      Virement

                                      @endif
                                      
                                  </td>
                              </tr>
                              <?php 

                                  $f = DB::table('operations')->join('type_frais', 'type_frais.id', '=', 'operations.frais')->Select('type_frais.*')->Where('operations.id', $d->id)->first();

                                  //var_dump($d->id);
                                  if ( $f ) {
                                  
                              ?>

                              <tr>
                                  <td class="text-center"> {{ $f->reference }} </td>
                                  <td class="text-center"> {{ $d->date_op }} </td>
                                  <td class="text-center"> {{ $d->matricule }} </td>
                                  <td class="text-center">{{ number_format($f->montant, 0, 2, ' ') }} BIF</td>
                                  <td class="text-center">

                                      {{ $f->name }}
                                      
                                  </td>
                              </tr>
                              <?php } ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="credit" role="tabpanel" aria-labelledby="credit-list">
                    <table class="table table-bordered mt-5" id="table1">
                        <thead>
                          <tr style="text-transform: uppercase;">
                            <th class="text-center">REFERENCE</th>
                            <th class="text-center">Date Opérations</th>
                            <th class="text-center">Guichetier</th>
                            <th class="text-center">Montant</th>
                            <th class="text-center">Type Opération</th>
                          </tr>
                        </thead>

                        <tbody>

                            @php $i = 1; @endphp

                            @foreach( $detail_transaction as $d )
                              <tr>
                                  <td class="text-center"> {{ $d->ref }} </td>
                                  <td class="text-center"> {{ $d->date_op }} </td>
                                  <td class="text-center"> {{ $d->matricule }} </td>
                                  <td class="text-center">{{ number_format($d->montant, 0, 2, ' ') }} BIF</td>
                                  <td class="text-center">

                                      @if( $d->type_operation_id == '2' )

                                      Retrait

                                      @elseif( $d->type_operation_id == '3' )

                                      Versement

                                      @else

                                      Virement

                                      @endif
                                      
                                  </td>
                              </tr>
                              <?php 

                                  $f = DB::table('operations')->join('type_frais', 'type_frais.id', '=', 'operations.frais')->Select('type_frais.*')->Where('operations.id', $d->id)->first();

                                  //var_dump($d->id);
                                  if ( $f ) {
                                  
                              ?>

                              <tr>
                                  <td class="text-center"> {{ $f->reference }} </td>
                                  <td class="text-center"> {{ $d->date_op }} </td>
                                  <td class="text-center"> {{ $d->matricule }} </td>
                                  <td class="text-center">{{ number_format($f->montant, 0, 2, ' ') }} BIF</td>
                                  <td class="text-center">

                                      {{ $f->name }}
                                      
                                  </td>
                              </tr>
                              <?php } ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="tab-pane fade" id="info-personnelle" role="tabpanel" aria-labelledby="info-personnelle-list">
                  Ut ut do pariatur aliquip aliqua aliquip exercitation
                  do nostrud commodo reprehenderit aute ipsum voluptate.
                  Irure Lorem et laboris nostrud amet cupidatat
                  cupidatat anim do ut velit mollit consequat enim
                  tempor. Consectetur est minim nostrud nostrud
                  consectetur irure labore voluptate irure. Ipsum id
                  Lorem sit sint voluptate est pariatur eu ad cupidatat
                  et deserunt culpa sit eiusmod deserunt. Consectetur et
                  fugiat anim do eiusmod aliquip nulla laborum elit
                  adipisicing pariatur cillum. Lorem ipsum dolor sit
                  amet consectetur adipisicing elit. Molestias,
                  inventore!
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



</section>

@endsection

