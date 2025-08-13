@extends('layouts.template')

@section('title', $title)

@section('css')
  <link rel="stylesheet" href="/assets/css/pages/fontawesome.html" />
  <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css"/>
  <link rel="stylesheet" href="/assets/css/pages/simple-datatables.css" />
@endsection

@section('content')

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
              <a href="{{ route('dashboard') }}">Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              {{ $title }}
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
          
          <div class="row">

            <div class="col-md-7">
              <div class="card">
                <div class="card-body">
                  @if( $analystes->isNotEmpty() )
                  <table class="table table-striped" id="table1">
                    <thead>
                      <tr style="text-transform: uppercase;">
                        <th class="text-center">N°</th>
                        <th class="text-center">Analystes</th>
                        <th class="text-center">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @php
                      $i = 1;
                      @endphp
                      
                      @foreach( $analystes as $d )
                        <tr>
                            <td class="text-center">{{ $i++ }}</td>
                            <td class="text-center">{{$d->nom}} {{$d->prenom}}</td>

                            <td class="text-center">
                                
                                <a href="#" data-bs-toggle="modal" data-analyste="{{ $d->id}}" data-prenom="{{ $d->prenom}}" data-nom="{{ $d->nom}}" data-bs-target="#sendModal"  class="btn btn-secondary btn-sm">Attribuer > </a>
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  @else
                     <div class="card card-inverse-secondary mb-5">
                        <div class="card-body">
                          <p class="mb-4"> Cette demande a été déjà attribuée à un analyste. </p>
                          <a href="{{ route('liste-demandes') }}" class="btn btn-secondary mb-3 mb-xl-0">Ok</a>
                          <a href="{{ route('liste-demandes') }}" class="btn btn-light">Retour</a>
                        </div>
                      </div>
                  @endif

                  <a href="" class="btn btn-primary">< Retour</a>
                </div>
              </div>
            </div>

            <div class="col-md-5">
              <div class="card">
                <div class="card-body">
                    <div class="list-group" style="font-size: 25px;">
                      <h4 class="mb-5">{{ $demande->nom }} @if($demande->prenom != 'NULL') {{ $demande->prenom }} @endif</h4>
                      <span class="list-group-item">
                          Dossier: <b>{{$demande->num_dossier}}</b>
                      </span>
                      <span class="list-group-item">
                          Type de credit: <b>{{$demande->name}}</b>
                      </span>
                      <span class="list-group-item">
                          Montant demandé: <b>{{ number_format($demande->montant_demande, 0, 2, ' ') }} BIF</b>
                      </span>
                    </div>
                </div>
              </div>
            </div>
          </div>

      </section>


    <div class="modal fade" id="sendModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-dark white">
            <span class="modal-title" id="myModalLabel150">Assignation vers un analyste</span>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <form class="forms-sample" action="{{ route('send-demande-envoyer-valide') }}" method="POST">

            {{ csrf_field() }}
          <div class="modal-body">
              <input type="hidden" value="{{$demande->num_dossier}}" name="demande">
              <input type="hidden" id="analyste" name="analyste">
              <p style="font-size: 25px;" class="sms_label"></p>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success btn-lg">Oui</button>
            <button type="button" class="btn btn-light btn-lg" data-bs-dismiss="modal">Non</button>
          </div>
        </form>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('js')
<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/assets/js/pages/simple-datatables.js"></script>

<script>

  $(function () {

    $("#sendModal").on('show.bs.modal', function(e){
        var button = $(e.relatedTarget);
        var analyste = button.data('analyste');
        var nom = button.data('nom');
        var prenom = button.data('prenom');

        var modal = $(this);

        modal.find('#analyste').val(analyste);
        modal.find('.sms_label').html('Vous allez assigner cette demande à <b>'+nom+' '+prenom+'</b> ?');
        
    });

  });
</script>

@endsection