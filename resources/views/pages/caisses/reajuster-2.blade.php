@extends('layouts.template')

@section('title', 'Reajuster la fermeture')

@section('content')

	<div class="page-heading">

	  <div class="row">

	      <div class="col-md-6">

	        <h3>Réajustement de caisse</h3>

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



  <section class="row">

      <div class="card">

          <div class="card-body">

              <div class="col-md-12 text-center mb-5">
                <h2>Montant système = {{ number_format($mvmt->solde_final, 0, 2, ' ') }} BIF<br> Montant en Cash = {{ number_format(session('solde_verify'), 0, 2, ' ') }} BIF <br>Différence = {{ number_format($mvmt->solde_final - session('solde_verify'), 0, 2, ' ') }} BIF</h2>
              </div>
              <form action="{{ route('caisse-reajuster-valid-end') }}" method="POST">

                {{ csrf_field() }}

                <input type="hidden" value="{{ session('solde_verify') }}" name="solde_verify">
                <input type="hidden" value="{{ $mvmt->id }}" name="mvmt_id">
                <input type="hidden" value="{{ $mvmt->solde_final }}" name="solde_final">

                <div class="form-group">
                  <label style="font-size: 25px;">Entrer le motif du Réajustement *</label>
                  <textarea rows="5" placeholder="Entrer pourquoi vous faite un reajustement" class="form-control form-control-xl" required name="motif_reajustement"></textarea>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-primary btn-lg">Fermer la caisse</button>
                </div>

              </form>

          </div>



      </div>

 </section>



@endsection

@section('js')
  <script src="/assets/extensions/jquery/jquery.min.js"></script>

@endsection
