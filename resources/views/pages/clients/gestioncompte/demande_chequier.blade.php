@extends('layouts.app_client')

@section('title', 'Demande de Chéquier')

@section('content')
    <div class="container">
        <h1>Demande de Chéquier</h1>
            @if( session()->has('msg_success') )

          <div class="col-md-12">

            <div class="alert alert-success">{{ session()->get('msg_success') }}</div>

          </div>

          @endif 
        <!-- Ajoutez ici le contenu de votre page -->
        <p>Remplissez le formulaire ci-dessous pour soumettre une demande de chéquier.</p>

        <!-- Exemple de formulaire de demande de chéquier -->
        <form action="{{route('submit.client.chequier')}}" method="post">
            @csrf
            <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="type_chequier">Type de Chéquier :</label>
                            <select id="type_chequier" class="form-control" name="type_chequier" required>
                                <option value="chequier_ordinaire">Chéquier Ordinaire</option>
                                <option value="chequier_talon">Chéquier avec Talon</option>
                                <!-- Ajoutez d'autres options selon vos besoins -->
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="adresse_livraison">Adresse de Livraison :</label>
                            <input type="text" id="adresse_livraison" class="form-control" placeholder="Adresse de Livraison" name="adresse_livraison" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="motif_demande">Motif de la demande :</label>
                            <textarea id="motif_demande" class="form-control" placeholder="Motif de la demande" name="motif_demande" required></textarea>
                        </div>
                    </div>
                </div>


            <button type="submit" class="btn btn-primary">Soumettre la demande</button>
        </form>
    </div>
@endsection
