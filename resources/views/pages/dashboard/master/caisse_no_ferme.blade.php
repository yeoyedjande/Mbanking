<div class="page-heading">

  <div class="row">

      <div class="col-md-6">

        <h3>Fermeture de caisse du: <?= date('d/m/Y'); ?></h3>

      </div>

      <div class="col-md-6 d-flex justify-content-end">

        <span>

            <h4>Guichetier: {{ Auth()->user()->nom }} {{ Auth()->user()->prenom }}</h4>

            <b><i class="bi bi-clock"></i> Heure locale: <?= date('d/m/Y H:i'); ?></b>

        </span>

      </div>

  </div>
</div>



<section class="row">

      <div class="card">



          <div class="card-body text-center">

              <h2>

              <span class="bi bi-clock"></span></h2>

              <h3 class="mb-4" style="color: red;">

               <i class="bi bi-exclamation-triangle-fill"></i> Echec de fermeture   <br>

                Solde des opérations enregistrés dans le système = {{ number_format($solde_final, 0, 2, ' ') }} BIF <br>
                Solde en cash déclaré = {{ number_format($solde_cash, 0, 2, ' ') }} BIF <br>
                Différence = {{ number_format($diff, 0, 2, ' ') }} BIF <br>

                Veuillez contacter le caissier principal pour justification et régularisation

              </h3>   


          </div>


      </div>

  </section>