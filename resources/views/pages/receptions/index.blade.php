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

    @if( session()->has('msg_info') )
    <div class="col-md-12">
        <div class="alert alert-info">{{ session()->get('msg_info') }}</div>
    </div>
    @endif


    <section class="section">
      
        <div class="card">
          <div class="card-header">
              <span class="d-flex justify-content-end">
                <a href="javascript(0);" data-bs-toggle="modal" data-bs-target="#numberAccount" class="btn btn-primary btn-lg">
                     Faire une demande
                </a>
              </span>
          </div>
          <div class="card-body">
            @if( $demandes->isNotEmpty() )
            <table id="order-listing" class="table" cellspacing="0" width="100%">
                <thead>
                  <tr class="" style="text-transform: uppercase;">
                    <th class="text-center">N°</th>
                    <th class="text-center">Dossier</th>
                    <th class="text-center">Type de credit</th>
                    <th class="text-center">Compte lié</th>
                    <th class="text-center">Client</th>
                    <th class="text-center">Montant demandé</th>
                    <th class="text-center">Date de la demande</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $i = 1;
                    @endphp
                    
                    @foreach( $demandes as $d )

                    <?php 
                      $assign = DB::table('analyste_demandes')
                      ->Where('demande', $d->id)
                      ->first();
                    ?>
                    <tr>
                        <td class="text-center">{{ $i++ }}</td>
                        <td class="text-center">{{$d->num_dossier}}</td>
                        <td class="text-center">{{$d->name}}</td>
                        <td class="text-center">{{$d->num_account}}</td>

                        <td class="text-center">

                            {{ $d->nom }} @if($d->prenom != 'NULL') {{ $d->prenom }} @endif
                            
                        </td>


                        <td class="text-center"><b>{{ number_format($d->montant_demande, 0, 2, ' ') }} BIF</b></td>
                        <td class="text-center"><b>
                          {{ $d->date_demande }}
                        </b></td>

                        
                        <td class="text-center">
                            <a href="#" style="padding: 15px;" class="btn btn-dark btn-sm"><i class="bi bi-pencil"></i> </a>
                            <a href="#" style="padding: 15px;" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> </a>
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            @else
                <div class="alert alert-info">
                  <h4 class="alert-heading">Info</h4>
                  <p>Il n'y a pas de demandes de credits disponible en ce moment !</p>
                </div>
            @endif
          </div>
        </div>
        
    </section>
  
<!--BEGIN DEMANDES DE CREDITS-->
<div class="modal fade text-left" id="numberAccount" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-dark white">
          <sapn class="modal-title" id="myModalLabel150">
            Demande de credit
          </sapn>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <i data-feather="x"></i>
          </button>
        </div>
        <div class="modal-body">
            
            <h2 class="mb-4">Commencer la demande de credit</h2>
            <form class="" method="GET" action="{{ route('demande-credit-step-2') }}">

                {{ csrf_field() }}

                <div class="form-group">
                  <label class="mb-4" style="font-size: 18px;" for="num_account">Entrer le numéro de compte du client * </label>
                  <input type="text" required data-parsley-group="block1" class="form-control form-control-xl" value="" id="num_account" name="flash" autocomplete="off" autofocus>
                </div>

                <div class="form-group mt-4">
                  <button type="button" class="btn btn-dark btn-lg" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Fermer</span>
                  </button>
                  <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bx bx-check d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Commencer ></span>
                  </button>
                </div>
            </form>

        </div>
      </div>
    </div>
</div>
<!--/END BEGIN DEMANDES DE CREDITS-->
@endsection

@section('js')
<script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="/assets/js/data-table.js"></script>
<script src="/assets/vendors/select2/select2.min.js"></script>
<script src="/assets/js/select2.js"></script>

<script type="text/javascript">
  $(window).on('load', function() {
    $('#waitVersement').modal('show');
  });
</script>

<script type="text/javascript">

		$(document).ready(function() {
			$("#waitVersement").modal({ backdrop: 'static', keyboard: false });

			$("#num_account").change(function () {
                 
                 
         	//console.log(" Numero Compte ");

            $("#num_account option:selected").each(function () {

                var num_account = $("#num_account").val();

               if (num_account) {
                    
                    console.log('Tu as trouver')

                    $.post("",{num_account:num_account},function(data){

                	 	$("#res_cent").html(data);
                   
                	});

                }else{
                  console.log("Veuillez saisir un num_account. ");
                }

            });

        })
      
        .trigger('change');
		});

</script>
@endsection