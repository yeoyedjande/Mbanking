@extends('layouts.app_client')

@section('title', 'Contactez nous')

@section('content')

    <div class="container">
         @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <h1>Contactez-nous</h1>
        <p>Vous pouvez nous contacter en utilisant les informations suivantes :</p>

        <ul>
            <li>Email : info@hopefundburundi.com</li>
            <li>Téléphone : (+257)22 25 18 71</li>
            <!-- Ajoutez d'autres informations de contact au besoin -->
        </ul>

        <p>Ou utilisez le formulaire de contact ci-dessous :</p>

        <form action="{{ route('submit.contact.form') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="name">Nom :</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="message">Message :</label>
                <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
@endsection
