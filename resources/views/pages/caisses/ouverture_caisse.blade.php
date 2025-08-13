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

          <div class="card-header">



          </div>



          <div class="card-body">

              <form class="forms-sample" action="{{ route('caisse-ouverture-verif') }}" method="POST">

                  {{ csrf_field() }}

                  <div class="row">

                      

                      <div class="col-md-12">

                        <table class="table">

                          <thead>

                            <th>Billet</th>

                            <th>Nombre de billet</th>

                            <th>Total</th>

                          </thead>

                          <tbody>

                            @foreach( $billets as $b )

                            <tr>

                              <td><h4>{{ $b->montant }}</h4></td>

                              <td>

                                <input type="number" style="font-size: 18px;" min="0" class="form-control form-control-xl" id="nb_{{ $b->montant }}" name="nb_{{ $b->montant }}">



                                <input type="hidden" value="{{ $b->id }}" name="billet_id_{{ $b->montant }}">

                              </td>

                              <td>

                                <h4 id="result_{{ $b->montant }}"></h4>

                              </td>

                            </tr>

                            @endforeach

                          </tbody>
                        </table>

                      </div>



                      <input type="hidden" id="result_final" name="result_verif">



                      <div class="col-md-6 mt-5">

                        <div class="form-group">

                            <button type="submit" class="btn btn-dark btn-lg">Ouvrir la caisse</button>

                        </div>

                      </div>

                      <div class="col-md-6 mt-5" style="text-align: center; color: red;">

                        <h4 id="result"></h4>

                      </div>

                  </div>

            </form>

          </div>

      </div>

  </section>

