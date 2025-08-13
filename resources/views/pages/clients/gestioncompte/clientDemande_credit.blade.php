@extends('layouts.app_client')

@section('title', 'Demande de Crédit')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="container">
        <h1>Demande de Crédit</h1>
        
        <p>Remplissez le formulaire ci-dessous pour soumettre une demande de crédit.</p>

        <!-- Exemple de formulaire de demande de crédit -->
        <form action="{{ route('client_credit.submit') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="montant_demande">Montant de la demande :</label>
                        <input type="number" id="montant_demande" class="form-control" placeholder="Montant de la demande" name="montant_demande" required>
                    </div>

                    <!-- <div class="form-group">
                        <label for="type_demande">Type de demande :</label>
                        <input type="text" id="type_demande" class="form-control" placeholder="Type de demande" name="type_demande">
                    </div> -->

                    
                    <div class="form-group">
                        <label for="raison_demande">Raison :</label>
                        <input type="text" id="raison_demande" class="form-control" placeholder="Stratégies" name="raison_demande">
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label for="type_credit">Type de crédit :</label>
                        <select id="type_credit" class="form-control" name="type_credit" required>
                            @foreach ($typeCredits as $typeCredit)
                                <option value="{{ $typeCredit->id }}">{{ $typeCredit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="pieces_justificatives">Pièces justificatives :</label>
                        <input type="file" class="form-control" id="inputGroupFile02" name="doc_demande">
                    </div>

                </div>

            </div>

            <button type="submit" class="btn btn-primary">Soumettre la demande</button>
        </form>


    </div>
@endsection
