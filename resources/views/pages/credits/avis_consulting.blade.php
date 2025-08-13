@extends('layouts.template')
@section('title', $title)

@section('css')
  <link rel="stylesheet" href="/assets/css/pages/fontawesome.html" />
@endsection



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

        <div class="row">
          @can('is-analyste-credit')
            <?php if ( isset($avis) ): ?>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <h2 class="card-title">Avis Agent de crédit</h2>

                    
                      <div id="dragula-right" class="content">
                          <div class="rounded border mb-2">
                              <div class="card-body p-3">
                                <div class="media">
                                  <i class="bi bi-users icon-sm align-self-center me-3"></i>
                                  <div class="media-body">
                                    <h4 class="mb-1">Avis</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">{{ $avis->avis }}
                                    </p>

                                    <h4 class="mb-1">Montant Proposé</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">{{ $avis->montant_propose }} BIF
                                    </p>

                                    <h4 class="mb-1">Type de crédit </h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis->name }}
                                    </p>

                                    <h4 class="mb-1">Taux</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis->taux }}
                                    </p>

                                    <h4 class="mb-1">Garantie</h4>
                                    <p class="mb-4 text-muted" style="font-size: 18px;">
                                      {{ $avis->garantie_attendu }}
                                    </p>

                                    <h4 class="mb-1">Assurance</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis->assurance }}
                                    </p>

                                    <h4 class="mb-1">Versement initial</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis->versement_initial_avis }}
                                    </p>

                                    <h4 class="mb-1">Durée</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis->duree }}
                                    </p>

                                    <h4 class="mb-1">Périodicité</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      Mensuel
                                    </p>

                                    <h4 class="mb-1">Période de grace</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis->periode_de_grace_avis }}
                                    </p>

                                    <h4 class="mb-1">Commentaire</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis->commentaire_avis }}
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    

                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <h2 class="card-title">Avis du comité de direction</h2>
                    <div id="dragula-right" class="content">
                        <div class="rounded border mb-2">
                            <div class="card-body p-3">
                              <div class="media">
                                <i class="bi bi-users icon-sm align-self-center me-3"></i>
                                <div class="media-body">
                                  <h1 class="mb-1 text-center">
                                    En attente de l'avis de la Direction...
                                  </h1>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                </div>
              </div>
            </div>
            <?php else: ?>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <h2 class="card-title">Analyse en cours de son avis</h2>

                      <form action="{{ route('avis-send') }}" method="POST">
                          {{ csrf_field() }}

                          <input type="hidden" value="{{ $id }}" name="dossier">

                          <li class="d-inline-block me-2 mb-1">

                            <div class="form-check">

                              <div class="checkbox">

                               <label for="checkbox2"> Accepté</label>

                                 <input
                                  type="radio"
                                  class="form-check-input"
                                       name="proposition_agent_credit"
                                       required data-parsley-group="block4"
                                     id="checkbox2"
                              value="Accepté"

                                     />

                               </div>

                              </div>

                          </li>

                          <li class="d-inline-block me-2 mb-1">

                            <div class="form-check">

                               <div class="checkbox">

                                 <input

                                  type="radio"
                                  class="form-check-input"
                                    name="proposition_agent_credit"
                                  id="checkbox2"
                                  value="Ajourné"
                              />

                                 <label for="checkbox2"> Ajourné</label>
                                 

                               </div>

                             </div>

                          </li>



                         <li class="d-inline-block me-2 mb-1">

                            <div class="form-check">

                               <div class="checkbox">

                                 <label for="checkbox2">  Refusé</label>

                                   <input

                                   type="radio"
                                   class="form-check-input"
                                      name="proposition_agent_credit"
                                   id="checkbox2"
                                    value="refusé"
                                   />

                                </div>

                             </div>

                         </li>

                         <div class="row">
                          <div class="form-group col-md-6">

                              <label for="montant_demande" class="form-label">Montant demandé :</label>

                              <input type="text" id="montant_demande" class="form-control form-control-xl" name="montant_demande" value="{{ $credit->montant_demande }}" readonly  required data-parsley-group="block4">
                           </div>
                           <div class="form-group col-md-6">

                              <label for="montant_propose" class="form-label">Proposé votre montant :</label>

                              <input type="number" id="montant_propose" class="form-control form-control-xl" name="montant_propose_agent_credit"  required data-parsley-group="block4">
                           </div>
                          </div>
                          <div class="row">
                              <div class="form-group col-md-4">

                                  <label for="type_credit" class="form-label">Type de crédit  :</label>

                                  <input type="text" value="{{ $credit->name }}" name="type_credit_agent_credit" class="form-control form-control-xl" readonly>
                                  

                              </div>

                              <div class="form-group col-md-4">

                                  <label for="nantissement" class="form-label">Nantissement: </label>

                                  <input type="text" id="nantissement" class="form-control form-control-xl" name="nantissement_agent_credit">

                              </div>

                              <div class="form-group col-md-4">

                                  <label for="taux" class="form-label">Taux: </label>
                                  <input type="text" id="taux" class="form-control form-control-xl" name="taux" required>

                              </div>
                          </div>

                          <div class="row">
                              <div class="form-group col-md-6">

                                  <label for="garantie" class="form-label">Garantie(s) :

                                  </label>

                                  <input type="text" id="garantie" class="form-control form-control-xl" readonly value="{{ $credit->gar_tot_mobilise }}" name="garantie_agent_credit"  required>

                              </div>

                              <div class="form-group col-md-6">

                                  <label for="assurance" class="form-label">Assurance : </label>

                                  <input type="text" id="assurance" class="form-control form-control-xl" value="{{ $credit->assurance }}" name="assurance_agent_credit"  required>

                              </div>
                          </div>

                          <div class="row">
                            <div class="form-group col-md-6">

                                <label for="versement_initial" class="form-label">Versement initial</label>

                                <input type="number" id="versement_initial" class="form-control form-control-xl" name="versement_initial_agent_credit" required>

                            </div>

                            <div class="form-group col-md-6">

                                <label for="duree" class="form-label">Durée :</label>

                                <input type="text" id="duree" value="{{ $credit->duree }}" class="form-control form-control-xl" readonly name="duree_agent_credit"  required>

                            </div>
                          </div>

                          <div class="row">
                              <div class="form-group col-md-6">

                                  <label for="periodicite" class="form-label">Périodicité :</label>

                                  <input type="text" class="form-control form-control-xl" name="periodicite_agent_credit" value="mensuel" readonly required>

                              </div>
                              <div class="form-group col-md-6">

                                  <label for="versement_initial" class="form-label">Période de grâce  :</label>

                                  <input type="text" id="periode_de_grace_agent_credit" class="form-control form-control-xl" name="periode_de_grace_agent_credit">

                              </div>
                          </div>
                          <div class="form-group">

                              <label for="versement_initial" class="form-label">Commentaire :</label>

                              <textarea class="form-control form-control-xl" id="Commentaire_agent_credit" name="commentaire_agent_credit"></textarea>
                          </div>

                          <div class="form-group">
                            <button type="submit" class="btn-primary btn">Donnez mon avis</button>
                          </div>
                      </form>

                </div>
              </div>
            </div>

            <?php endif ?>

          @endcan

          @can('is-direction')

          <?php 
            //$avis2 = DB::table('avis')->where()
            $avis2 = DB::table('credits')->Join('avis', 'avis.dossier', '=', 'credits.num_dossier')
                ->join('type_credits', 'type_credits.id', '=', 'credits.type_credit_id')
                ->join('users', 'users.id', '=', 'avis.user_id')
                ->where('credits.num_dossier', $id)
                ->where('users.role_id', 7)
                ->first();
          ?>

          <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <h2 class="card-title">Avis Agent de crédit</h2>

                    
                      <div id="dragula-right" class="content">
                          <div class="rounded border mb-2">
                              <div class="card-body p-3">
                                <div class="media">
                                  <i class="bi bi-users icon-sm align-self-center me-3"></i>
                                  <div class="media-body">
                                    <h4 class="mb-1">Avis</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">{{ $avis2->avis }}
                                    </p>

                                    <h4 class="mb-1">Montant Proposé</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">{{ $avis2->montant_propose }} BIF
                                    </p>

                                    <h4 class="mb-1">Type de crédit </h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis2->name }}
                                    </p>

                                    <h4 class="mb-1">Taux</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis2->taux }}
                                    </p>

                                    <h4 class="mb-1">Garantie</h4>
                                    <p class="mb-4 text-muted" style="font-size: 18px;">
                                      {{ $avis2->garantie_attendu }}
                                    </p>

                                    <h4 class="mb-1">Assurance</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis2->assurance }}
                                    </p>

                                    <h4 class="mb-1">Versement initial</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis2->versement_initial_avis }}
                                    </p>

                                    <h4 class="mb-1">Durée</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis2->duree }}
                                    </p>

                                    <h4 class="mb-1">Périodicité</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      Mensuel
                                    </p>

                                    <h4 class="mb-1">Période de grace</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis2->periode_de_grace_avis }}
                                    </p>

                                    <h4 class="mb-1">Commentaire</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis2->commentaire_avis }}
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    

                </div>
              </div>
            </div>
          <?php if ( isset($avis) ): ?>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <h2 class="card-title">Avis Direction</h2>

                    
                      <div id="dragula-right" class="content">
                          <div class="rounded border mb-2">
                              <div class="card-body p-3">
                                <div class="media">
                                  <i class="bi bi-users icon-sm align-self-center me-3"></i>
                                  <div class="media-body">
                                    <h4 class="mb-1">Avis</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">{{ $avis->avis }}
                                    </p>

                                    <h4 class="mb-1">Montant à accordé</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">{{ $avis->montant_propose }} BIF
                                    </p>

                                    <h4 class="mb-1">Type de crédit </h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis->name }}
                                    </p>

                                    <h4 class="mb-1">Taux</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis->taux }}
                                    </p>

                                    <h4 class="mb-1">Garantie</h4>
                                    <p class="mb-4 text-muted" style="font-size: 18px;">
                                      {{ $avis->garantie_attendu }}
                                    </p>

                                    <h4 class="mb-1">Assurance</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis->assurance }}
                                    </p>

                                    <h4 class="mb-1">Versement initial</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis->versement_initial_avis }}
                                    </p>

                                    <h4 class="mb-1">Durée</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis->duree }}
                                    </p>

                                    <h4 class="mb-1">Périodicité</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      Mensuel
                                    </p>

                                    <h4 class="mb-1">Période de grace</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis->periode_de_grace_avis }}
                                    </p>

                                    <h4 class="mb-1">Commentaire</h4>
                                    <p class="mb-3 text-muted" style="font-size: 18px;">
                                      {{ $avis->commentaire_avis }}
                                    </p>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                    

                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <h2 class="card-title">Avis du comité de crédit/CA</h2>
                    <div id="dragula-right" class="content">
                        <div class="rounded border mb-2">
                            <div class="card-body p-3">
                              <div class="media">
                                <i class="bi bi-users icon-sm align-self-center me-3"></i>
                                <div class="media-body">
                                  <h1 class="mb-1 text-center">
                                    En attente de l'avis comité de crédit/CA...
                                  </h1>
                                </div>
                              </div>
                            </div>
                          </div>
                      </div>
                </div>
              </div>
            </div>
            <?php else: ?>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <h2 class="card-title">Direction en cours de son avis</h2>

                      <form action="{{ route('avis-send') }}" method="POST">
                          {{ csrf_field() }}

                          <input type="hidden" value="{{ $id }}" name="dossier">

                          <li class="d-inline-block me-2 mb-1">

                            <div class="form-check">

                              <div class="checkbox">

                               <label for="checkbox2"> Accepté</label>

                                 <input
                                  type="radio"
                                  class="form-check-input"
                                       name="proposition_agent_credit"
                                       required data-parsley-group="block4"
                                     id="checkbox2"
                              value="Accepté"

                                     />

                               </div>

                              </div>

                          </li>

                          <li class="d-inline-block me-2 mb-1">

                            <div class="form-check">

                               <div class="checkbox">

                                 <input

                                  type="radio"
                                  class="form-check-input"
                                    name="proposition_agent_credit"
                                  id="checkbox2"
                                  value="Ajourné"
                              />

                                 <label for="checkbox2"> Ajourné</label>
                                 

                               </div>

                             </div>

                          </li>



                         <li class="d-inline-block me-2 mb-1">

                            <div class="form-check">

                               <div class="checkbox">

                                 <label for="checkbox2">  Refusé</label>

                                   <input

                                   type="radio"
                                   class="form-check-input"
                                      name="proposition_agent_credit"
                                   id="checkbox2"
                                    value="refusé"
                                   />

                                </div>

                             </div>

                         </li>

                         <div class="row">
                          <div class="form-group col-md-6">

                              <label for="montant_demande" class="form-label">Montant demandé :</label>

                              <input type="text" id="montant_demande" class="form-control form-control-xl" name="montant_demande" value="{{ $credit->montant_demande }}" readonly  required data-parsley-group="block4">
                           </div>
                           <div class="form-group col-md-6">

                              <label for="montant_propose" class="form-label">Montant à accorder :</label>

                              <input type="number" id="montant_propose" class="form-control form-control-xl" name="montant_propose_agent_credit"  required data-parsley-group="block4">
                           </div>
                          </div>
                          <div class="row">
                              <div class="form-group col-md-4">

                                  <label for="type_credit" class="form-label">Type de crédit  :</label>

                                  <input type="text" value="{{ $credit->name }}" name="type_credit_agent_credit" class="form-control form-control-xl" readonly>
                                  

                              </div>

                              <div class="form-group col-md-4">

                                  <label for="nantissement" class="form-label">Nantissement: </label>

                                  <input type="text" id="nantissement" class="form-control form-control-xl" name="nantissement_agent_credit">

                              </div>

                              <div class="form-group col-md-4">

                                  <label for="taux" class="form-label">Taux: </label>
                                  <input type="text" id="taux" class="form-control form-control-xl" name="taux" required>

                              </div>
                          </div>

                          <div class="row">
                              <div class="form-group col-md-6">

                                  <label for="garantie" class="form-label">Garantie(s) :

                                  </label>

                                  <input type="text" id="garantie" class="form-control form-control-xl" readonly value="{{ $credit->gar_tot_mobilise }}" name="garantie_agent_credit"  required>

                              </div>

                              <div class="form-group col-md-6">

                                  <label for="assurance" class="form-label">Assurance : </label>

                                  <input type="text" id="assurance" class="form-control form-control-xl" value="{{ $credit->assurance }}" name="assurance_agent_credit"  required>

                              </div>
                          </div>

                          <div class="row">
                            <div class="form-group col-md-6">

                                <label for="versement_initial" class="form-label">Versement initial</label>

                                <input type="number" id="versement_initial" class="form-control form-control-xl" name="versement_initial_agent_credit" required>

                            </div>

                            <div class="form-group col-md-6">

                                <label for="duree" class="form-label">Durée :</label>

                                <input type="text" id="duree" value="{{ $credit->duree }}" class="form-control form-control-xl" readonly name="duree_agent_credit"  required>

                            </div>
                          </div>

                          <div class="row">
                              <div class="form-group col-md-6">

                                  <label for="periodicite" class="form-label">Périodicité :</label>

                                  <input type="text" class="form-control form-control-xl" name="periodicite_agent_credit" value="mensuel" readonly required>

                              </div>
                              <div class="form-group col-md-6">

                                  <label for="versement_initial" class="form-label">Période de grâce  :</label>

                                  <input type="text" id="periode_de_grace_agent_credit" class="form-control form-control-xl" name="periode_de_grace_agent_credit">

                              </div>
                          </div>
                          <div class="form-group">

                              <label for="versement_initial" class="form-label">Commentaire :</label>

                              <textarea class="form-control form-control-xl" id="Commentaire_agent_credit" name="commentaire_agent_credit"></textarea>
                          </div>

                          <div class="form-group">
                            <button type="submit" class="btn-primary btn">Donnez mon avis</button>
                          </div>
                      </form>

                </div>
              </div>
            </div>

            <?php endif ?>
          @endcan
        </div>

    </section>



@endsection



@section('js')

<script src="/assets/extensions/jquery/jquery.min.js"></script>





<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>

<script src="/assets/js/pages/simple-datatables.js"></script>



@endsection