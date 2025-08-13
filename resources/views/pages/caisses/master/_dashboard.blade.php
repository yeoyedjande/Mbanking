<div class="row mb-5">
    <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <i class="mdi mdi-coin icon-lg text-primary d-flex align-items-center"></i>
            <div class="d-flex flex-column ms-4">
              <div class="d-flex flex-column">
                <h3 class="mb-2" style="color: #27367f;">Faire un retrait</h3>
                <!--<h4 class="font-weight-bold">3 025 000 BIF</h4>-->
              </div>
              <a href="{{ route('retrait-new') }}" class="btn btn-primary">Commencer</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <i class="mdi mdi-magnet icon-lg text-success d-flex align-items-center"></i>
            <div class="d-flex flex-column ms-4">
              <div class="d-flex flex-column">
                <h3 class="mb-2" style="color: #27367f;">Faire un versement</h3>
                <!--<h4 class="font-weight-bold">100 000 895 BIF</h4>-->
              </div>
              <a href="{{ route('versement-new') }}" class="btn btn-primary">Commencer </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <i class="mdi mdi-undo icon-lg text-warning d-flex align-items-center"></i>
            <div class="d-flex flex-column ms-4">
              <div class="d-flex flex-column">
                <h3 class="mb-2" style="color: #27367f;">Faire un virement</h3>
                <!--<h4 class="font-weight-bold">200 080 795 BIF</h4>-->
              </div>
              <a href="{{ route('virement-new') }}" class="btn btn-primary">Commencer </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <i class="mdi mdi-account-plus icon-lg text-danger d-flex align-items-center"></i>
            <div class="d-flex flex-column ms-4">
              <div class="d-flex flex-column">
                <h3 class="mb-2" style="color: #27367f;">Consultation de compte</h3>
                <!--<h4 class="font-weight-bold">10 000 Membres</h4>-->
              </div>
              <a href="{{ route('accounts-consultation') }}" class="btn btn-primary">Commencer </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <i class="mdi mdi-account icon-lg text-danger d-flex align-items-center"></i>
            <div class="d-flex flex-column ms-4">
              <div class="d-flex flex-column">
                <h3 class="mb-2" style="color: #27367f;">Payer un fournisseur</h3>
                <!--<h4 class="font-weight-bold">10 000 Membres</h4>-->
              </div>
              <a href="#" class="btn btn-primary">Commencer </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <i class="mdi mdi-file icon-lg text-danger d-flex align-items-center"></i>
            <div class="d-flex flex-column ms-4">
              <div class="d-flex flex-column">
                <h3 class="mb-2" style="color: #27367f;">Imprimer un relevé</h3>
                <!--<h4 class="font-weight-bold">10 000 Membres</h4>-->
              </div>
              <a href="#" class="btn btn-primary">Commencer </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <i class="mdi mdi-cash text-info icon-lg text-danger d-flex align-items-center"></i>
            <div class="d-flex flex-column ms-4">
              <div class="d-flex flex-column">
                <h3 class="mb-2" style="color: #27367f;">Rapport de caisse</h3>
                <!--<h4 class="font-weight-bold">10 000 Membres</h4>-->
              </div>
              <a href="{{ route('caisse-rapport') }}" class="btn btn-primary">Commencer </a>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>


<div class="row">

  <div class="col-md-6 grid-margin">
      <div class="card card-stat stretch-card mb-3">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="text-white">
              <h3 class="font-weight-bold mb-0"><?php if (isset($verif_caisse)): ?>
              {{ number_format($verif_caisse->solde_final, 0, 2, ' ') }} BIF
              <?php else: ?>
                0 BIF
            <?php endif ?></h3>
              <h6>Solde en cours</h6>
              <div class="badge badge-danger">23%</div>
            </div>
            <div class="flot-bar-wrapper">
              <div id="column-chart" class="flot-chart"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="card stretch-card mb-3">
        <div class="card-body d-flex flex-wrap justify-content-between">
          <div>
            <h4 class="font-weight-semibold mb-1 text-black">Solde à ouverture</h4>
            <h6 class="text-muted">Montant reçu ce jour</h6>
          </div>
          <h3 class="text-success font-weight-bold">
            <?php if (isset($verif_caisse)): ?>
              {{ number_format($verif_caisse->solde_initial, 0, 2, ' ') }} BIF
              <?php else: ?>
                0 BIF
            <?php endif ?>
            
          </h3>
        </div>
      </div>
      <div class="card stretch-card mb-3">
        <div class="card-body d-flex flex-wrap justify-content-between">
          <div>
            <h4 class="font-weight-semibold mb-1 text-black">Versements</h4>
            <h6 class="text-muted">Montant total des versments en cours</h6>
          </div>
          <h3 class="text-success font-weight-bold">{{ number_format($som_versement, 0, 2, ' ') }} BIF</h3>
        </div>
      </div>
      <div class="card mt-3">
        <div class="card-body d-flex flex-wrap justify-content-between">
          <div>
            <h4 class="font-weight-semibold mb-1 text-black">Retraits</h4>
            <h6 class="text-muted">Montant total des retraits</h6>
          </div>
          <h3 class="text-danger font-weight-bold">{{ number_format($som_retrait, 0, 2, ' ') }} BIF</h3>
        </div>
      </div>
  </div>
<!--
  <div class="col-md-6 stretch-card grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between flex-wrap">
          <div>
            <div class="card-title mb-0">Sales Revenue</div>
            <h3 class="font-weight-bold mb-0">$32,409</h3>
          </div>
          <div>
            <div class="d-flex flex-wrap pt-2 justify-content-between sales-header-right">
              <div class="d-flex me-5">
                <button type="button" class="btn btn-social-icon btn-outline-sales"><i class="mdi mdi-inbox-arrow-down"></i></button>
                <div class="ps-2">
                  <h4 class="mb-0 font-weight-semibold head-count">$8,217</h4>
                  <span class="font-10 font-weight-semibold text-muted">TOTAL SALES</span>
                </div>
              </div>
              <div class="d-flex me-3 mt-2 mt-sm-0">
                <button type="button" class="btn btn-social-icon btn-outline-sales profit"><i class="mdi mdi-cash text-info"></i></button>
                <div class="ps-2">
                  <h4 class="mb-0 font-weight-semibold head-count">2,804</h4>
                  <span class="font-10 font-weight-semibold text-muted">TOTAL PROFIT</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <p class="text-muted font-13 mt-2 mt-sm-0">Your sales monitoring dashboard template. <a class="text-muted font-13" href="#"><u>Learn more</u></a></p>
        <div class="flot-chart-wrapper">
          <div id="flotChart" class="flot-chart">
            <canvas class="flot-base"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
-->
</div>