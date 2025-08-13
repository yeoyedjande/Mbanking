@extends('layouts.template')

@section('title', $title)

@section('content')

<div class="page-heading">

  <div class="row">

      <div class="col-md-6">

        <h3>{{$title}} du: <?= date('d/m/Y'); ?></h3>

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

        <div class="text-center" style="padding: 20px; margin-bottom: 20px; border: 1px solid red;">
        	<h2 style="color: red;">{{ session()->get('msg_error') }}</h2>
        </div>

    </div>

    @endif



  <section class="row">

      <div class="card">

          <div class="card-header">



          </div>



          <div class="card-body">

              <form class="forms-sample" action="{{ route('caisse-cloture-verif') }}" method="POST">

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

                            <button type="submit" class="btn btn-danger btn-lg">Fermer la caisse</button>

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









@endsection



@section('js')

<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/assets/js/pages/simple-datatables.js"></script>


<script type="text/javascript">

  $(document).ready(function(){



      $("#result_10000").html("0 BIF");

      $("#result_5000").html("0 BIF");

      $("#result_2000").html("0 BIF");

      $("#result_1000").html("0 BIF");

      $("#result_500").html("0 BIF");

      $("#result_100").html("0 BIF");

      $("#result_50").html("0 BIF");

      $("#result_20").html("0 BIF");

      $("#result_10").html("0 BIF");

      $("#result_5").html("0 BIF");

      $("#result_1").html("0 BIF");



      $("#result").html("Total: 0 BIF");

      $("#result_final").val(0);



      $("#nb_10000, #nb_5000, #nb_2000, #nb_1000, #nb_500, #nb_100, #nb_50, #nb_20, #nb_10, #nb_5, #nb_1").keyup(function () {

          //console.log(" Change agence ");



          $nb_10000 = $("#nb_10000").val() * 10000;
          $nb_5000 = $("#nb_5000").val() * 5000;
          $nb_2000 = $("#nb_2000").val() * 2000;
          $nb_1000 = $("#nb_1000").val() * 1000;
          $nb_500 = $("#nb_500").val() * 500;
          $nb_100 = $("#nb_100").val() * 100;
          $nb_50 = $("#nb_50").val() * 50;
          $nb_20 = $("#nb_20").val() * 20;
          $nb_10 = $("#nb_10").val() * 10;
          $nb_5 = $("#nb_5").val() * 5;
          $nb_1 = $("#nb_1").val() * 1;



          $("#result_10000").html($nb_10000.toLocaleString('fr-FR')+" BIF");
          $("#result_5000").html($nb_5000.toLocaleString('fr-FR')+" BIF");
          $("#result_2000").html($nb_2000.toLocaleString('fr-FR')+" BIF");
          $("#result_1000").html($nb_1000.toLocaleString('fr-FR')+" BIF");
          $("#result_500").html($nb_500.toLocaleString('fr-FR')+" BIF");
          $("#result_100").html($nb_100.toLocaleString('fr-FR')+" BIF");

          $("#result_50").html($nb_50.toLocaleString('fr-FR')+" BIF");

          $("#result_20").html($nb_20.toLocaleString('fr-FR')+" BIF");

          $("#result_10").html($nb_10.toLocaleString('fr-FR')+" BIF");

          $("#result_5").html($nb_5.toLocaleString('fr-FR')+" BIF");
          $("#result_1").html($nb_1.toLocaleString('fr-FR')+" BIF");




          //Recuperation des montants cumules
          $som_result = $nb_10000 + $nb_5000 + $nb_2000 + $nb_1000 + $nb_500 + $nb_100 + $nb_50 + $nb_20 + $nb_10 + $nb_5 + $nb_1;

          $("#result_final").val($som_result);

          $som_result = $som_result.toLocaleString('fr-FR');

          $("#result").html("Total: "+$som_result+" BIF");

          //console.log("Je suis a l'interieur");

      });



  });

</script>
@endsection