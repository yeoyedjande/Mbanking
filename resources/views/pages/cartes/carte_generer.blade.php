@extends('layouts.template')
@section('title', $title)


@section('content')

<style type="text/css">

  .card-image-container {
      position: relative;
      display: inline-block; /* Assure que le conteneur n'est pas plus large que nécessaire */
  }

  .card-image-container img {
      width: 100%; /* Adapte l'image à la largeur de son conteneur */
      display: block; /* Élimine l'espace en dessous de l'image */
  }

  .card-image-container .nom {
      position: absolute;
      bottom: 10%; /* Ajustez selon l'emplacement souhaité sur l'image */
      left: 10%; /* Ajustez selon l'emplacement souhaité sur l'image */
      color: gold; /* Changez la couleur selon votre design */
      padding: 5px; /* Optionnel: ajoute un peu d'espace autour du texte */
      text-transform: uppercase;
      font-size: 25px;
  }

  .card-image-container .date {
      position: absolute;
      bottom: 20%; /* Ajustez selon l'emplacement souhaité sur l'image */
      left: 40%; /* Ajustez selon l'emplacement souhaité sur l'image */
      color: gold; /* Changez la couleur selon votre design */
      padding: 5px; /* Optionnel: ajoute un peu d'espace autour du texte */
      font-size: 25px;
  }

   .card-image-container .numero {
      position: absolute;
      bottom: 35%; /* Ajustez selon l'emplacement souhaité sur l'image */
      left: 20%; /* Ajustez selon l'emplacement souhaité sur l'image */
      color: gold; /* Changez la couleur selon votre design */
      padding: 5px; /* Optionnel: ajoute un peu d'espace autour du texte */
      font-size: 30px;
  }

  .card-image-container .qrcode {
      position: absolute;
      top: 7%; /* Ajustez selon vos besoins */
      left: 10%; /* Ajustez selon vos besoins */
      padding: 5px;
  }
</style>

<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3 style="text-transform: uppercase;">{{ $title }}</h3>
      </div>

      <div class="col-12 col-md-6 order-md-2 order-first">

        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">

          <ol class="breadcrumb">

            <li class="breadcrumb-item">

              <a href="{{ route('home') }}">Tableau de bord</a>

            </li>

            <li class="breadcrumb-item active" aria-current="page">

              {{$title}}

            </li>

          </ol>

        </nav>

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

    

  <section class="section">

      

      <div class="card">
        <div class="card-body">

            <div class="row" id="carteBancaire">
                <div class="col-md-6 card-image-container" id="card-image-container" style="padding: 0; margin: 0;">
                  <img src="/assets/images/carte_bancaire/recto.png" width="100%">

                  <div class="qrcode">
                      {{ $qrCode }}
                  </div>
                  <h4 class="numero">{{ $formattedCardNumber }}</h4>
                  <h4 class="date">{{$expirationDate}}</h4>
                  <h4 class="nom">{{ $verif->nom }}</h4>
                </div>

                <div class="col-md-6">
                  <img src="/assets/images/carte_bancaire/verso.png" width="100%">
                </div>

                <div class="col-md-12 text-center mt-5">
                  <button class="btn btn-primary" onclick="exporterCarte()">Exporter la carte</button>
                </div>

            </div>

        </div>

      </div>

      

  </section>




@endsection

@section('js')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

  <script type="text/javascript">

      var nomDuTitulaire = <?php echo json_encode(strtolower($verif->nom)); ?>;

      function exporterCarte() {
          html2canvas(document.querySelector("#card-image-container")).then(canvas => {
              let link = document.createElement('a');
              link.download = 'carte-bancaire-'+ nomDuTitulaire +'.png';
              link.href = canvas.toDataURL();
              link.click();
          });
      }


  </script>

@endsection