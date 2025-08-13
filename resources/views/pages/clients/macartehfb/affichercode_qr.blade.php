@extends('layouts.app_client')

@section('title', 'Afficher le code QR')

@section('content')
    <div class="container">
        <h1>Code QR </h1>
        <p>Sur cette page, vous pouvez afficher votre code QR personnel.</p>

         <div id="qrcode" class="text-center">
            <!-- <img src="{{ asset('assets/images/faces/codeQr.png') }}" alt="Code QR" style="width: 150px;"> -->
        </div>
        <p class="mt-3">N'oubliez pas de protéger votre code QR et de ne le partager qu'avec des personnes de confiance.</p>
    </div>

    <!-- Script pour générer le code QR -->
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script>
        // Remplacez le texte ci-dessous par les informations que vous souhaitez inclure dans le code QR
        var contenuCodeQR = "Vos informations ici";

        // Générer le code QR avec qrcode.js
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: contenuCodeQR,
            width: 128,
            height: 128,
        });
    </script>
@endsection
