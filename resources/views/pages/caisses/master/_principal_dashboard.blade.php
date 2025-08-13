<div class="row mb-5">
    <div class="col-12 col-sm-6 col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <i class="mdi mdi-plus-circle icon-lg text-primary d-flex align-items-center"></i>
            <div class="d-flex flex-column ms-4">
              <div class="d-flex flex-column">
                <h3 class="mb-2" style="color: #27367f;">Créer une caisse</h3>
                <!--<h4 class="font-weight-bold">3 025 000 BIF</h4>-->
              </div>
              <a href="{{ route('caisse-create') }}" class="btn btn-primary">Commencer</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12 col-sm-6 col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <i class="mdi mdi-coin icon-lg text-primary d-flex align-items-center"></i>
            <div class="d-flex flex-column ms-4">
              <div class="d-flex flex-column">
                <h3 class="mb-2" style="color: #27367f;">Recharger une caisse</h3>
                <!--<h4 class="font-weight-bold">3 025 000 BIF</h4>-->
              </div>
              <a href="{{ route('caisse-rechargement') }}" class="btn btn-primary">Commencer</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-6 col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <i class="mdi mdi-close icon-lg text-success d-flex align-items-center"></i>
            <div class="d-flex flex-column ms-4">
              <div class="d-flex flex-column">
                <h3 class="mb-2" style="color: #27367f;">Fermer une caisse</h3>
                <!--<h4 class="font-weight-bold">100 000 895 BIF</h4>-->
              </div>
              <a href="#" class="btn btn-primary">Commencer </a>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row mb-5">

  <div class="col-md-6 grid-margin">
      <div class="card card-stat stretch-card mb-3">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div class="text-white">
              <h3 class="font-weight-bold mb-0">{{ number_format($som_solde_ouverture, 0, 2, ' ') }} BIF</h3>
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
            <h6 class="text-muted">Montant envoyé ce jour</h6>
          </div>
          <h3 class="text-success font-weight-bold">{{ number_format($som_solde_ouverture, 0, 2, ' ') }} BIF</h3>
        </div>
      </div>
      <div class="card stretch-card mb-3">
        <div class="card-body d-flex flex-wrap justify-content-between">
          <div>
            <h4 class="font-weight-semibold mb-1 text-black">Versements</h4>
            <h6 class="text-muted">Montant total des versments en cours</h6>
          </div>
          <h3 class="text-success font-weight-bold">{{ number_format($som_versement_global, 0, 2, ' ') }} BIF</h3>
        </div>
      </div>
      <div class="card mt-3">
        <div class="card-body d-flex flex-wrap justify-content-between">
          <div>
            <h4 class="font-weight-semibold mb-1 text-black">Retraits</h4>
            <h6 class="text-muted">Montant total des retraits</h6>
          </div>
          <h3 class="text-danger font-weight-bold">{{ number_format($som_retrait_global, 0, 2, ' ') }} BIF</h3>
        </div>
      </div>
  </div>

  <div class="col-md-6 stretch-card grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between flex-wrap">
          <div>
            <div class="card-title mb-0">Comptes</div>
            <h3 class="font-weight-bold mb-0">182 000 000 BIF</h3>
          </div>
          <div>
            <div class="d-flex flex-wrap pt-2 justify-content-between sales-header-right">
              <div class="d-flex me-5">
                <button type="button" class="btn btn-social-icon btn-outline-sales"><i class="mdi mdi-inbox-arrow-down"></i></button>
                <div class="ps-2">
                  <h4 class="mb-0 font-weight-semibold head-count">585 000 000 BIF</h4>
                  <span class="font-10 font-weight-semibold text-muted">COMPTE DE CREDIT</span>
                </div>
              </div>
              <div class="d-flex me-3 mt-2 mt-sm-0">
                <button type="button" class="btn btn-social-icon btn-outline-sales profit"><i class="mdi mdi-cash text-info"></i></button>
                <div class="ps-2">
                  <h4 class="mb-0 font-weight-semibold head-count">-275 000 000 BIF</h4>
                  <span class="font-10 font-weight-semibold text-muted">COMPTE DE DEBIT</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <p class="text-muted font-13 mt-2 mt-sm-0">Vous avez de façon épurée une vue graphique des comptes de débit et de crédit.  <a class="text-muted font-13" href="#"><u>Voir les détails</u></a></p>
        <div class="flot-chart-wrapper">
          <div id="flotChart" class="flot-chart">
            <canvas class="flot-base"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>