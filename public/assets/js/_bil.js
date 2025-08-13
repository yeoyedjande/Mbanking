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
