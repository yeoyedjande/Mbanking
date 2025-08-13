@extends('layouts.app_client')

@section('title', 'Annuler/Suspendre une carte bancaire')

@section('content')

    <div class="container">
        
         @if(session('success'))
            <div class="alert alert-danger">
                {{ session('success') }}
            </div>
        @endif

        <h1>Annuler/Suspendre une carte bancaire</h1>
        
        <p>Remplissez le formulaire ci-dessous pour annuler ou suspendre votre carte bancaire.</p>

        <form action="{{ route('annuler.carte.submit') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="numero_carte">Numéro de carte :</label>
                <input type="text" id="numero_carte" class="form-control" placeholder="Numéro de carte" name="numero_carte" required>
            </div>

            <div class="form-group">
                <label for="raison">Raison de l'annulation/suspension :</label>
                <textarea id="raison" class="form-control" placeholder="Raison de l'annulation/suspension" name="raison" required></textarea>
            </div>

            <button type="submit" class="btn btn-danger">Annuler/Suspendre la carte</button>
        </form>
    </div>
@endsection
