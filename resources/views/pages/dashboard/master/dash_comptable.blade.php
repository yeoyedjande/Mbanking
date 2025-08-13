<div class="page-heading">

  <div class="row">

      <div class="col-md-6">

        <h3>Tableau de bord</h3>

      </div>

      <div class="col-md-6 d-flex justify-content-end">

        <span>

            <h4>Comptable: {{ Auth()->user()->nom }} {{ Auth()->user()->prenom }}</h4>

            <b><i class="bi bi-clock"></i> Heure locale: <?= date('d/m/Y H:i'); ?></b>

        </span>

      </div>

  </div>

  

</div>

<div class="page-content">



<section class="row">

  <div class="col-12 col-lg-12">

    <div class="row">

      <div class="col-6 col-lg-3 col-md-6">

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

                  Cpte Principal

                </h4>

                <h4 class="font-extrabold mb-0">{{ number_format($solde_principal, 0, 2, ' ') }} BIF</h4>

              </div>

            </div>

          </div>

        </div>

      </div>

      <div class="col-6 col-lg-3 col-md-6">

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

                <h4 class="text-muted font-semibold">Régularisation</h4>

                <h4 class="font-extrabold mb-0">0 BIF</h4>

              </div>

            </div>

          </div>

        </div>

      </div>

      <div class="col-6 col-lg-3 col-md-6">

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

                <h4 class="text-muted font-semibold">Soldes client</h4>

                <h4 class="font-extrabold mb-0">{{ number_format($solde_client, 0, 2, ' ') }} BIF</h4>

              </div>

            </div>

          </div>

        </div>

      </div>

      <div class="col-6 col-lg-3 col-md-6">

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

                <h4 class="text-muted font-semibold">Clients</h4>

                <h4 class="font-extrabold mb-0">{{ $accountCount }}</h4>

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