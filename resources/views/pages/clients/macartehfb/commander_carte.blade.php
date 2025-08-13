@extends('layouts.app_client')

@section('title', 'Commander une carte')

@section('content')

  @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    <div class="container">
        <h1>Commander une nouvelle carte</h1>
        
        <p>Remplissez le formulaire ci-dessous pour commander votre nouvelle carte bancaire.</p>

        <!-- Exemple de formulaire de commande de carte -->
        <form action="{{ route('commande.carte.submit') }}" method="post">
            @csrf
            <div class="form-group">
	            <label for="prix">Prix de la carte :</label>
	            <input type="text" id="prix" class="form-control" value="10.000 US" name="prix" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Commander la carte</button>
        </form>
    </div>
@endsection
