@extends('layouts.template')

@section('title', 'Balance')

@section('content')

  <div class="page-heading">

	  <div class="page-title mb-5">

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

	              Balance

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
      <div class="row">
      	<div class="col-md-12">


      		<div class="card">

		        <div class="card-header">
              <?php if ( isset($dateDebut) && isset($dateFin) ) { ?>
	        		<h2>La balance du <?= $dateDebut; ?> au <?= $dateFin; ?></h2>
              <?php } ?>

              <?php 
                if ( isset($periode) ) { 

                  if ($periode == 'day') {
                    $periode = 'd\'aujourd\'hui';
                  }else if ($periode == 'month') {
                    $periode = 'du mois';
                  }else{
                    $periode = 'de l\'année';
                  }
              ?>


              <h2>La balance <?= $periode; ?></h2>
              <?php } ?>

              <span class="d-flex justify-content-end">

              <a href="#" class="btn btn-primary btn-lg">
                   <i class="fa fa-print"></i> Imprimer
              </a>

            </span>
		        </div>

		        <div class="card-body">

		        	<div class="col-12">

              @if($compteComptables->isNotEmpty())

                <table id="table1" class="table" cellspacing="0" width="100%">

                  <thead>

                    <tr class="bg-primary text-white">

                      <td class="" width="20%">Libéllé</td>
                      <td class="" style="border-right: 1px solid #ffffff;">N°</td>

                      <td class="text-center" style="border-right: 1px solid #ffffff;">
                        Solde Début 

                        <table width="100%" style="border-top: 1px solid #ffffff;">
                            <tr>
                              <td align="left">Débit</td>
                              <td align="right">Crédit</td>
                            </tr>
                        </table>
                      </td>

                      

                      <td class="text-center" style="border-right: 1px solid #ffffff;">
                        Mouvement 
                        <table width="100%" style="border-top: 1px solid #ffffff;">
                            <tr>
                              <td align="left">Débit</td>
                              <td align="right">Crédit</td>
                            </tr>
                        </table>
                      </td>

                      <td class="text-center" style="border-right: 1px solid #ffffff;">Total Période
                        <table width="100%" style="border-top: 1px solid #ffffff;">
                            <tr>
                              <td align="left">Débit</td>
                              <td align="right">Crédit</td>
                            </tr>
                        </table>
                      </td>
                      <td class="text-center" style="border-right: 1px solid #ffffff;">Solde Fin
                        <table width="100%" style="border-top: 1px solid #ffffff;">
                            <tr>
                              <td align="left">Débit</td>
                              <td align="right">Crédit</td>
                            </tr>
                        </table>
                      </td>
                      <td class="text-center">Variation</td>

                    </tr>
                    

                  </thead>

                  <tbody>

                    @php

                      $i = 1;

                      $total_debit_solde_debut_global = 0;
                      $total_credit_solde_debut_global = 0;
                      $total_debit_mouvements_global = 0;
                      $total_credit_mouvements_global = 0;
                      $total_debit_periode_global = 0;
                      $total_credit_periode_global = 0;
                      $total_debit_solde_fin_global = 0;
                      $total_credit_solde_fin_global = 0;
                      @endphp

                      

                      @foreach( $compteComptables as $m )

                      <?php 

                              $mouvement_debit_periode = 0;
                              $mouvement_credit_periode = 0;



                            if ( isset($dateDebut) && isset($dateFin) ) {
                                    

                                $fin = date_create($dateFin);
                                $fin = date_format($fin, 'd/m/Y');

                                $debut = date_create($dateDebut);
                                $debut = date_format($debut, 'd/m/Y');

                                

                                $req = DB::table('journals')
                                ->where('compte', $m->numero)
                                ->whereBetween('date', [$debut, $fin])
                                ->get();

                                $reqSoldeDebut = DB::table('journals')
                                ->where('compte', $m->numero)
                                ->where('date', '<', $debut)
                                ->selectRaw('SUM(debit) as totalDebit, SUM(credit) as totalCredit')
                                ->first();

                                $debit_solde_debut = $reqSoldeDebut->totalDebit;
                                $credit_solde_debut = $reqSoldeDebut->totalCredit;
                                    
                            }

                            if ( isset($periode) ) {                

                              //$periode = $request->periode;

                                if ( $periode == "day" ) {

                                    $NomPeriode = "d'Ajourd'hui";
                                    $date = date('d/m/Y');
                                    
                                    $req = DB::table('journals')
                                    ->where('compte', $m->numero)
                                    ->where('date', $date)
                                    ->get();

                                    $reqSoldeDebut = DB::table('journals')
                                  ->where('compte', $m->numero)
                                  ->where('date', '<', $date)
                                  ->selectRaw('SUM(debit) as totalDebit, SUM(credit) as totalCredit')
                                  ->first();

                                  $debit_solde_debut = $reqSoldeDebut->totalDebit;
                                  $credit_solde_debut = $reqSoldeDebut->totalCredit;

                                }else if( $periode == "month" ){

                                    $NomPeriode = "du Mois";
                                    //$date = date('Y-m-d');
                                    $debut = '01/'.date('m').'/'.date('Y') ;    
                                    $fin = '31/'.date('m').'/'.date('Y') ; 

                                    $req = DB::table('journals')
                                    ->where('compte', $m->numero)
                                    ->whereBetween('date', [$debut, $fin])
                                    ->get();

                                    $reqSoldeDebut = DB::table('journals')
                                    ->where('compte', $m->numero)
                                    ->where('date', '<', $debut)
                                    ->selectRaw('SUM(debit) as totalDebit, SUM(credit) as totalCredit')
                                    ->first();

                                    $debit_solde_debut = $reqSoldeDebut->totalDebit;
                                    $credit_solde_debut = $reqSoldeDebut->totalCredit;
                                }else{

                                    $NomPeriode = "de la Semaine";
                                    $date = date('d/m/Y');
                                    $debut = date('d/m/Y', strtotime($date.'-7 days'));

                                    $req = DB::table('journals')
                                    ->where('compte', $m->numero)
                                    ->whereBetween('date', [$debut, $date])
                                    ->get();

                                    $reqSoldeDebut = DB::table('journals')
                                    ->where('compte', $m->numero)
                                    ->where('date', '<', $debut)
                                    ->selectRaw('SUM(debit) as totalDebit, SUM(credit) as totalCredit')
                                    ->first();

                                    $debit_solde_debut = $reqSoldeDebut->totalDebit;
                                    $credit_solde_debut = $reqSoldeDebut->totalCredit;

                                }

                            }
                            

                             //Je suis pas en mesure de faire
                              foreach( $req as $r ){
                                $mouvement_debit_periode = $r->debit + $mouvement_debit_periode;
                                $mouvement_credit_periode = $r->credit + $mouvement_credit_periode;
                              }

                          ?>

                      <tr>

                          <td class="">{{ $m->libelle }}</td>
                          <td style="border-right: 1px solid; font-weight: bold;">{{$m->numero}}</td>
                          <td class="text-center" style="border-right: 1px solid; font-weight: bold;">

                            <table width="100%">
                                <tr>

                                  <td align="left">{{ number_format($debit_solde_debut, 0, 2, ' ') }}</td>
                                  <td align="right"> 
                                    {{ number_format($credit_solde_debut, 0, 2, ' ') }}
                                  </td>

                                </tr>
                            </table>
                            
                          </td>




                          

                          <td class="text-center" style="border-right: 1px solid;">
                            <table width="100%">
                                <tr>
                                  <td align="left">{{ number_format($mouvement_debit_periode, 0, 2, ' ') }}</td>
                                  <td align="right"> 
                                    {{ number_format($mouvement_credit_periode, 0, 2, ' ') }}
                                  </td>
                                </tr>
                            </table>
                          </td>


                        <td align="center" style="border-right: 1px solid;">

                          <table width="100%">
                                <tr>
                                  <td class="" align="left">
                                    @if( $mouvement_debit_periode > $mouvement_credit_periode)
                                    {{ number_format($mouvement_debit_periode - $mouvement_credit_periode, 0, 2, ' ') }}
                                    @else
                                      0
                                    @endif  
                                  </td>
                                  <td class="" align="right"> 
                                    @if( $mouvement_debit_periode < $mouvement_credit_periode)
                                    {{ number_format($mouvement_credit_periode - $mouvement_debit_periode, 0, 2, ' ') }}
                                    @else
                                      0
                                    @endif 
                                  </td>
                                </tr>
                            </table>
                        </td>

                        <td class="text-center" style="border-right: 1px solid;">
                          
                            <table width="100%">
                                <tr>
                                  <td class="" align="left">

                                    <?php 
                                      $total_debit_periode = $mouvement_debit_periode - $mouvement_credit_periode;
                                      $total_credit_periode = $mouvement_credit_periode - $mouvement_debit_periode;

                                      $total_debit_solde_fin = $mouvement_debit_periode + $mouvement_credit_periode;
                                      $total_credit_solde_fin = $mouvement_credit_periode + $mouvement_debit_periode;

                                      $solde_fin = $total_debit_solde_fin - $total_credit_solde_fin;
                                    ?>

                                    @if($solde_fin > 0)
                                        {{ number_format($solde_fin, 0, 2, ' ') }}
                                    @else
                                        0 
                                    @endif 

                                  </td>

                                  <td class="" align="right"> 
                                    @if($solde_fin < 0)
                                        {{ number_format(abs($solde_fin), 0, 2, ' ') }} 
                                    @else
                                        0 
                                    @endif
                                  </td>

                                </tr>
                            </table>

                        </td>


                        <td class="text-center">
                          <b>
                            &nbsp;
                          </b>
                        </td>

                      </tr>

                      @php
                        $total_debit_solde_debut_global += $debit_solde_debut;
                        $total_credit_solde_debut_global += $credit_solde_debut;
                        $total_debit_mouvements_global += $mouvement_debit_periode; 
                        $total_credit_mouvements_global += $mouvement_credit_periode; 
                        $total_debit_periode_global += $total_debit_periode;
                        $total_credit_periode_global += $total_credit_periode; 
                        $total_debit_solde_fin_global += ($solde_fin > 0) ? $solde_fin : 0;
                        $total_credit_solde_fin_global += ($solde_fin < 0) ? abs($solde_fin) : 0;
                      @endphp


                      @endforeach

                      <tr class="bg-primary text-white">
                      <td colspan="2" class="text-center" style="border-right: 1px solid #ffffff;">TOTAUX</td>
                      <td class="text-center" style="border-right: 1px solid #ffffff; font-weight: bold;">
                        
                        <table width="100%" >
                            <tr>
                              <td align="left">{{ number_format($total_debit_solde_debut_global, 0, 2, ' ') }}</td>
                              <td align="right">{{ number_format($total_credit_solde_debut_global, 0, 2, ' ') }}</td>
                            </tr>
                        </table>
                      </td>
                      <td class="text-center" style="border-right: 1px solid #ffffff; font-weight: bold;">
                        <table width="100%">
                            <tr>
                              <td align="left">{{ number_format($total_debit_mouvements_global, 0, 2, ' ') }}</td>
                              <td align="right">{{ number_format($total_credit_mouvements_global, 0, 2, ' ') }}</td>
                            </tr>
                        </table>
                      </td>
                      <td class="text-center" style="border-right: 1px solid #ffffff; font-weight: bold;">
                        <table width="100%">
                            <tr>
                              <td align="left">{{ number_format($total_debit_periode_global, 0, 2, ' ') }}</td>
                              <td align="right">{{ number_format($total_credit_periode_global, 0, 2, ' ') }}</td>
                            </tr>
                        </table>
                      </td>
                      <td class="text-center" style="font-weight: bold;">
                        <table width="100%">
                            <tr>
                              <td align="left">{{ number_format($total_debit_solde_fin_global, 0, 2, ' ') }}</td>
                              <td align="right">{{ number_format($total_credit_solde_fin_global, 0, 2, ' ') }}</td>
                            </tr>
                        </table>
                      </td>
                      <td class="text-center"></td>
                  </tr>
                  
                  </tbody>
                </table>

              @endif
            </div>

		          	
		        </div>

	      	</div>
      	</div>
    	</div>
  	</section>
@endsection