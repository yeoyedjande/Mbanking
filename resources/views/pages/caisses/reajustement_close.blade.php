@extends('layouts.template')

@section('title', 'Fermeture de caisse')

@section('css')
  <link rel="stylesheet" href="/assets/printjs/print.css" />
@endsection

@section('content')

<div class="page-heading">

  <div class="row">

      <div class="col-md-12">

        <h3>Fermeture de caisse du: <?= date('d/m/Y'); ?></h3>

      </div>


  </div>
</div>



<section class="row">

      <div class="card">



          <div class="card-body text-center">

              <h2>

              <span class="bi bi-clock"></span></h2>

              <h3 class="mb-4" style="color: green;">

                Bravo <i class="bi bi-hand-thumbs-up-fill"></i>!!!  <br>

                Vous avez fermé la caisse de cette journée, <br>on se donne RDV demain pour une nouvelle caisse.

              </h3>   



            
          </div>


      </div>

  </section>
@endsection

@section('js')

<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script src="/assets/printjs/print.js"></script>
<script>
    function generatePdf() {
        printJS({
            printable: 'table1',
            type: 'html',
            css: '/assets/printjs/print.css',
            ignoreElements: ['.page-heading']
        })
    }
</script>

@endsection