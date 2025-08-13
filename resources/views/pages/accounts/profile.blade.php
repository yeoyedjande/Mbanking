@extends('layouts.template')



@section('title', 'Information client')


@section('css')
  <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css"/>
  <link rel="stylesheet" href="/assets/css/pages/simple-datatables.css" />
@endsection

@section('content')

<div class="page-heading">
  <div class="page-title">
    <div class="row">

        <div class="col-12 col-md-6 order-md-1 order-last">
          <h3><span style="color: green;">@if($verif->juridique === 1)
            {{ $verif->nom }} {{ $verif->prenom }}
            @elseif($verif->juridique === 2)
              {{ $verif->nom_entreprise }}
            @else
                {{ $verif->nom_groupe }}
            @endif
          </span></h3>
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
              <div class="list-group list-group-horizontal-sm mb-1 text-center" role="tablist">
                <a class="list-group-item list-group-item-action active" id="resume-list" data-bs-toggle="list" href="#resume" role="tab">Resumé de compte</a>
                @if( $credits->isNotEmpty() )
                <a class="list-group-item list-group-item-action" id="credit-list" data-bs-toggle="list" href="#credit" role="tab">Suivi de crédit</a>
                <a class="list-group-item list-group-item-action" id="credit-remboursement" data-bs-toggle="list" href="#remboursement_credit" role="tab">Remboursement crédit</a>
                @endif
                <a class="list-group-item list-group-item-action" id="info-personnelle-list" data-bs-toggle="list" href="#info-personnelle" role="tab">Informations personnelles</a>
              </div>

              <div class="tab-content text-justify mb-5">


                <div class="tab-pane fade show active" id="resume" role="tabpanel" aria-labelledby="resume-list">
                    <table class="table table-bordered mt-5" id="">
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

                    <table class="table table-bordered table-striped" id="table1">
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

                            @foreach( $operations as $d )
                              <tr>
                                  <td class="text-center"> {{ $d->reference }} </td>
                                  <td class="text-center"> <?= date("d/m/Y", strtotime($d->date)); ?></td>
                                  <td class="text-center">  </td>
                                  <td class="text-center">
                                    @if($d->credit != 0)
                                    {{ number_format($d->credit, 0, 2, ' ') }} BIF
                                    @endif
                                    @if($d->debit != 0)
                                    {{ number_format($d->debit, 0, 2, ' ') }} BIF
                                    @endif
                                  </td>
                                  <td class="text-center">

                                      {{ $d->libelle }}
                                      
                                  </td>
                              </tr>
                              
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="tab-pane fade" id="remboursement_credit" role="tabpanel" aria-labelledby="credit-list">

                    <div class="row mt-5">

                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title">Commencer le remboursement du crédit</h4>
                          </div>
                          <div class="card-content">
                            <div class="card-body">
                              <form method="GET" action="{{ route('process-remboursement') }}">

                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Dossier du crédit *</label>
                                        <select class="form-control form-control-xl" id="numDossierSelect" name="dossier" required>
                                            <option value="">Selectionner</option>
                                            @foreach( $credits as $d )
                                            <option value="{{ $d->num_dossier }}"> {{ $d->num_dossier }} </option>
                                            @endforeach                                    
                                        </select>
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Type de produit *</label>
                                        <select id="typeCreditSelect" class="form-control form-control-xl" name="type" required>
                                            <option value="">Selectionner</option>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Mode de remboursement *</label>
                                        <select id="modeRemboursement" class="form-control form-control-xl" name="modeRemboursement" required>
                                            <option value="">Selectionner</option>
                                            <option value="remboursement echeance">Remboursement d'une échéance</option>
                                            <option value="remboursement montant">Remboursement d'un montant</option>
                                        </select>
                                      </div>
                                    </div>

                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Origine *</label>
                                        <input type="text" value="" name="num_account" class="form-control form-control-xl" readonly>
                                      </div>
                                    </div>

                                    <div class="form-group">
                                      <div class="col-md-12">
                                        <button type="submit" class="btn btn-secondary btn-lg">Suivant</button>
                                      </div>
                                    </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>

                    </div>

                    
                </div>

                <div class="tab-pane fade" id="credit" role="tabpanel" aria-labelledby="credit-list">

                    <div class="row mt-5">

                      @foreach( $credits as $d )
                      <div class="col-lg-6 col-md-12">
                        <div class="card">
                          <div class="card-header">
                            <h4 class="card-title">Dossier: {{ $d->num_dossier }}</h4>
                          </div>
                          <div class="card-content">
                            <div class="card-body">
                              <ul class="list-group">
                                <li
                                  class="list-group-item d-flex justify-content-between align-items-center">
                                  <span>Montant capital octroyé</span>
                                  <span class="badge bg-success badge-pill badge-round ml-1">{{ number_format($d->montant_octroye, 0, 2, ' ') }} BIF</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  <span> Date</span>
                                  <b>{{ $d->date }}</b>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  <span> Durée</span>
                                  <b>{{ $d->duree }}</b>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  <span> Capital remboursé</span>
                                  <b>{{ number_format($d->capital_rembourse, 0, 2, ' ') }} BIF</b>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  <span> Intérêts remboursés</span>
                                  <b>{{ number_format($d->interet_rembourse, 0, 2, ' ') }} BIF</b>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  <span> Penalités remboursées</span>
                                  <b>{{ number_format($d->penalite_rembourse, 0, 2, ' ') }} BIF</b>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  <span> Total remboursé</span>
                                  <b>{{ number_format($d->total_rembourse, 0, 2, ' ') }} BIF</b>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  <span> Capital dû</span>
                                  <b>{{ number_format($d->capital_du, 0, 2, ' ') }} BIF</b>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  <span> Intérêt restant dû</span>
                                  <b>{{ number_format($d->interet_restant_du, 0, 2, ' ') }} BIF</b>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  <span> Montant provision</span>
                                  <b>{{ number_format($d->montant_provision, 0, 2, ' ') }} BIF</b>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  <span> Type de crédit</span>
                                  <b>{{ $d->name }}</b>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                  <span>Etat crédit</span>
                                  <b class="badge bg-danger badge-pill badge-round ml-1">{{ $d->etat_credit }}</b>
                                </li>
                              </ul>
                              <a href="{{ route('detail-dossier', $d->num_dossier) }}" class="btn btn-primary btn-lg mt-3"> Voir détails du dossier: {{ $d->num_dossier }}</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endforeach
                    </div>

                    
                </div>
                
                <div class="tab-pane fade" id="info-personnelle" role="tabpanel" aria-labelledby="info-personnelle-list">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Informations personnelles</h4>
                                </div>
                                <div class="card-body">
                                    @if($verif->juridique === 1)
                                        <div class="mb-3">
                                            <strong>Nom:</strong> {{ $verif->nom }}
                                        </div>
                                        <div class="mb-3">
                                            <strong>Prénom:</strong> {{ $verif->prenom }}
                                        </div>
                                    @elseif($verif->juridique === 2)
                                        <div class="mb-3">
                                            <strong>Nom de l'entreprise:</strong> {{ $verif->nom_entreprise }}
                                        </div>
                                    @else
                                        <div class="mb-3">
                                            <strong>Nom du groupe:</strong> {{ $verif->nom_groupe }}
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <strong>Adresse:</strong> {{ $verif->adresse }}
                                    </div>
                                    <div class="mb-3">
                                        <strong>Téléphone:</strong> {{ $verif->telephone }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Photo ou Logo</h4>
                                </div>
                                <div class="card-body text-center">
                                    @if($verif->juridique == 1)
                                        <img src="{{ asset('/assets/images/photo-profil/' . $verif->photo) }}" alt="Photo du client" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">
                                    @else
                                        <img src="{{ asset('/assets/images/logo/' . $verif->logo) }}" alt="Logo du client" class="img-fluid" style="width: 150px; height: 150px;">
                                    @endif
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h4 class="card-title">Signature</h4>
                                </div>
                                <div class="card-body text-center">
                                    <img src="{{ asset('/assets/images/signature/' . $verif->signature) }}" alt="Signature du client" class="img-fluid" style="width: 150px; height: 150px;">
                                </div>
                            </div> 
                        </div>

                    </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



</section>

@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/assets/js/pages/simple-datatables.js"></script>
<script>
$(document).ready(function() {
    $('#numDossierSelect').change(function() {
        var numDossier = $(this).val(); // Récupère le numéro de dossier sélectionné
        if(numDossier) {
            $.ajax({
                url: '/get-type-credit-by-num-dossier/' + numDossier, // Ajustez l'URL selon votre route
                type: "GET",
                success: function(data) {
                    // Mettez à jour le champ de type de crédit
                    $('#typeCreditSelect').empty(); // Vide le select avant de le remplir
                    if(data.typeCreditId && data.typeName) {
                        $('#typeCreditSelect').append('<option value="'+ data.typeCreditId +'">'+ data.typeName +'</option>');
                    }

                    // Mettez à jour le champ de numéro de compte
                    if(data.numAccount) {
                        $('input[name="num_account"]').val(data.numAccount);
                    } else {
                        $('input[name="num_account"]').val(''); // Vide le champ si aucun compte n'est trouvé
                    }
                }
            });
        } else {
            $('#typeCreditSelect').empty();
            $('input[name="num_account"]').val(''); // Vide les champs si aucun dossier n'est sélectionné
        }
    });
});
</script>

@endsection

