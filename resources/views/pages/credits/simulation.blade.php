@extends('layouts.template')



@section('title', $title)



@section('css')

  <link rel="stylesheet" href="/assets/css/pages/fontawesome.html" />

  <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css"/>

  <link rel="stylesheet" href="/assets/css/pages/simple-datatables.css" />

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

      

        <div class="card">

          <div class="card-header">

              Faire une simulation

          </div>

          <div class="card-body">

              <form class="forms-sample" action="{{ route('pret-simulation') }}" method="GET">

                {{ csrf_field() }}

                <input type="hidden" value="{{ $demande->typeCreditId }}" name="type_credit">
                <input type="hidden" value="{{ $demande->num_dossier }}" name="dossier">
                <div class="row">

                  <div class="col-md-6">

                    <div class="form-group">

                      <label for="num_account">Numéro de compte * </label>

                      <input type="text" value="{{ $demande->num_account }}" class="form-control form-control-xl" id="num_account" name="num_account" readonly required>

                    </div>

                  </div>



                  <div class="col-md-6">

                    <div class="form-group">

                      <label for="duree_credit">Durée du crédit * </label>

                      <select id="duree_credit" class="form-control form-control-xl" name="duree_credit" style="padding-top: 10px;" required>

                          <option value="">Selectionner</option>

                          <option data-taux = "0.15" value="3">3 mois</option>

                          <option data-taux = "0.18" value="6">6 mois</option>
                          <option data-taux = "0.14" value="12">12 mois</option>
                          <option data-taux = "0.24" value="24">24 mois</option>


                      </select>

                    </div>

                  </div>



                  <div class="col-md-6">

                    <div class="form-group">

                      <label for="date_deboursement">Date de déboursement * </label>

                      <input type="date"  class="form-control form-control-xl" id="date_deboursement" name="date_deboursement" required>

                    </div>

                  </div>



                  <div class="col-md-6">

                    <div class="form-group">

                      <label for="amount_frais">Montant des frais de dossier * </label>

                      <input type="amount_frais" min="1000" style="color: red; font-weight: bold;" class="form-control form-control-xl" id="amount_frais" name="amount_frais" required>

                    </div>

                  </div>

                  <div class="col-md-6">

                    <div class="form-group">

                      <label for="periode">Période de remboursement * </label>

                      <select class="form-control form-control-xl" name="periode" style="padding-top: 10px;" required>

                          <option value="">Selectionner</option>

                          <option value="jour">Par Jour</option>

                          <option value="semaine">Par Semaine</option>

                          <option value="mois">Par Mois</option>

                      </select>

                    </div>

                  </div>

                  <div class="col-md-6">

                    <div class="form-group">

                      <label for="amount">Montant de credit * </label>

                      <input type="text" id="amount" value="{{ number_format($demande->montant_demande, 0, 2, ' ') }}" style="color: green; font-weight: bold;" class="form-control form-control-xl" name="amount" required readonly>

                    </div>

                  </div>



                  <div class="col-md-4">

                    <div class="form-group">

                      <label for="amount_commission">Montant de la commission * </label>

                      <input type="text" id="amount_commission" class="form-control form-control-xl" name="amount_commission" required readonly>

                    </div>

                  </div>



                  <div class="col-md-4">

                    <div class="form-group">

                      <label for="amount_assurances">Montant des assurances * </label>

                      <input type="text" id="amount_assurances" class="form-control form-control-xl" name="amount_assurances" required readonly>

                    </div>

                  </div>



                  <div class="col-md-4">

                    <div class="form-group">

                      <label for="taux_interet">Taux d'intérêt * </label>

                      <input type="number" id="taux_interet" min="0" class="form-control form-control-xl" name="taux_interet" required>

                    </div>

                  </div>



                  <div class="col-md-12">

                    <div class="form-group">

                      <label for="description">Description du prêt * </label>

                      <textarea class="form-control" name="description" rows="10" placeholder="Ecrire une description du prêt" required></textarea>

                    </div>

                  </div>

                  

                  <div class="col-md-12">

                    <div class="form-group">
                      <a href="{{ route('liste-demandes-assign') }}" class="btn btn-danger btn-lg">< Retour</a>

                      <button type="submit" class="btn btn-primary btn-lg me-2"> <i class="mdi mdi-arrow-down"></i> &nbsp;&nbsp; Voir le resultat</button>

                    </div>

                  </div>

                </div>
              </form>

          </div>

        </div>

        

    </section>



@endsection



@section('js')

<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/assets/js/pages/simple-datatables.js"></script>


<script type="text/javascript">

    $("#duree_credit").change(function () {

          $("#duree_credit option:selected").each(function () {

              var duree = $("#duree_credit").val();
              var taux = $(this).data('taux');
              console.log(taux)

              var amount = $("#amount").val().replace(/\s+/g, '');              

              if ( amount ) {

                $('#amount_commission').val(Math.ceil(amount * 0.06));
                $('#amount_assurances').val(Math.ceil(amount * taux));

              }



          });



        });


</script>

@endsection