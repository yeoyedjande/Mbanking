<div class="page-heading">
  <div class="row">
      <div class="col-md-6">
        <h3>Ouverture de la caisse du: <?= date('d/m/Y'); ?></h3>
      </div>
      <div class="col-md-6 d-flex justify-content-end">
        <span>
            <h4>Guichetier: {{ Auth()->user()->nom }} {{ Auth()->user()->prenom }}</h4>
            <b><i class="bi bi-clock"></i> Heure locale: <?= date('d/m/Y H:i'); ?></b>
        </span>
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

  <section class="row">
      <div class="card">

          <div class="card-body text-center">
              <h2>
              <span class="bi bi-clock"></span></h2>
              <h3 class="mb-4" style="color: #af5a5a;">
                On ne vous a pas encore attribué de montant à ce jour. <br> Veuillez patienter ou rafraichir la page !
              </h3>   

              <a href="/dashboard" class="btn btn-danger"><i class="bi bi-arrow-clockwise"></i> Rafraichir</a>
          </div>

      </div>
  </section>
