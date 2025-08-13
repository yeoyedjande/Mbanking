@extends('layouts.app_client')

@section('title', 'Changement de Code PIN')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Afficher les erreurs de validation -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="container">
        <h1>Changer le Code PIN</h1>
        
        <p>Sur cette page, vous avez la possibilité de changer votre code PIN personnel.</p>

        <form action="{{ route('codepin.submit') }}" method="post">
            @csrf
            <!-- <div class="form-group">
                <label for="ancien_codepin">Ancien Code PIN :</label>
                <input type="text" id="ancien_codepin" class="form-control" placeholder="Ancien Code PIN" name="ancien_codepin">
            </div> -->

            <div class="form-group">
                <label for="nouveau_codepin">Nouveau Code PIN :</label>
                <input type="text" id="nouveau_codepin" class="form-control" placeholder="Nouveau Code PIN" name="nouveau_codepin" required>
            </div>

            <div class="form-group">
                <label for="confirmer_codepin">Confirmer le nouveau Code PIN :</label>
                <input type="text" id="confirmer_codepin" class="form-control" placeholder="Confirmer le nouveau Code PIN" name="confirmer_codepin" required>
            </div>

            <button type="submit" class="btn btn-primary">Changer le Code PIN</button>
        </form>
    </div>
@endsection
