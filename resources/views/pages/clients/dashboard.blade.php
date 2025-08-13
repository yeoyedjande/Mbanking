@extends('layouts.app_client')



@section('title', 'Tableau de bord')



@section('content')



<div class="page-heading">

  <div class="row">

      <div class="col-md-6">

        <h3>Tableau de bord</h3>

      </div>

      <div class="col-md-6 d-flex justify-content-end">

        <span>

            <h4>Client: {{ Auth()->user()->nom }} @if(Auth()->user()->prenom != 'NULL' ) {{ Auth()->user()->prenom }} @endif</h4>

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

          <img style="border-radius: 15px; width: 100%; margin-bottom: 20px;" src="/assets/images/carte_bancaire/carte_bc.jpg">

      </div>

      <div class="col-6 col-lg-6 col-md-6">

        

        <div class="row mb-8">

          <div class="col-md-12">

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

                        Mon solde

                      </h4>

                      <h4 class="font-extrabold mb-0">{{ number_format($soldeClient->solde, 0, 2, ' ') }} BIF</h4>

                    </div>

                  </div>

                </div>

              </div>

          </div>

        </div>



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

                        Revenues

                      </h4>

                      <h4 class="font-extrabold mb-0">0 BIF</h4>

                    </div>

                  </div>

                </div>

              </div>

          </div>

          

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

                      Dépenses

                    </h4>

                    <h4 class="font-extrabold mb-0">0 BIF</h4>

                  </div>

                </div>

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

            <div id="chart-profile-visit"></div>

          </div>

        </div>

      </div>

    </div>







  </div>



</section>



@endsection



@section('js')

<!-- Need: Apexcharts -->

  <script src="/assets/extensions/apexcharts/apexcharts.min.js"></script>

  <script src="/assets/js/pages/dashboard.js"></script>

@endsection

