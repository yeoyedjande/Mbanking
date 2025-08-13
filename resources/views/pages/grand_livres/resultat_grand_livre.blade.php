@extends('layouts.template')

@section('title', 'Grand Livre')

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

	              Grand Livre

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
	        		<h2>Le Grand Livre</h2>
              <span class="d-flex justify-content-end">

              <a href="{{ route('grand-livre-pdf') }}" target="_blank" class="btn btn-primary btn-xs">
                   <i class="fa fa-print"></i> Exporter en PDF
              </a> &nbsp; &nbsp;
              <a href="#" class="btn btn-primary btn-xs">
                   <i class="fa fa-print"></i> Exporter en Excel
              </a>

            </span>
		        </div>

		        <div class="card-body">
		        	<div class="col-12">


              @foreach( $compteComptables as $c )

              <?php 

                  if ( isset($au_compte) && isset($du_compte) ) {
                    
                      $operations = DB::table('journals')
                      ->join('users', 'users.id', '=', 'journals.user_id')
                      ->join('agences', 'agences.id', '=', 'users.agence_id')
                      ->where('compte', $c->numero)
                      ->whereBetween('compte', [$du_compte, $au_compte])
                      ->orderBy('journals.id', 'DESC')->get();
                    
                  }

                  if ( isset($date_debut) && isset($date_fin) ) {
                    
                      $debut = $date_debut;

                      $debut = date_create($debut);
                      $debut = date_format($debut, 'd/m/Y');

                      $fin = $date_fin;

                      $fin = date_create($fin);
                      $fin = date_format($fin, 'd/m/Y');

                      //dd($debut, $fin);

                      $operations = DB::table('journals')
                      ->join('users', 'users.id', '=', 'journals.user_id')
                      ->join('agences', 'agences.id', '=', 'users.agence_id')
                      ->where('compte', $c->numero)
                      ->whereBetween('date', [$debut, $fin])
                      ->orderBy('journals.id', 'DESC')->get();
                  }

                  if ( isset($periode) ) {
                    
                  
                      $operations = DB::table('journals')
                      ->join('users', 'users.id', '=', 'journals.user_id')
                      ->join('agences', 'agences.id', '=', 'users.agence_id')
                      ->where('compte', $c->numero);


                      if ( $periode == "day" ) {

                          $NomPeriode = "d'Ajourd'hui";
                          $date = date('d/m/Y');
                          
                          $operations = $operations->Where('date', $date)
                          ->orderBy('journals.id', 'DESC')->get();

                      }else if( $periode == "month" ){

                          $NomPeriode = "du Mois";
                          //$date = date('Y-m-d');
                          $debut = '01/'.date('m').'/'.date('Y') ;    
                          $fin = '31/'.date('m').'/'.date('Y') ; 

                          $operations = $operations->whereBetween('date', [$debut, $fin])
                          ->orderBy('journals.id', 'DESC')->get();


                      }else{

                          $NomPeriode = "de la Semaine";
                          $date = date('d/m/Y');
                          $debut = date('d/m/Y', strtotime($date.'-7 days'));

                          $operations = $operations->whereBetween('date', [$debut, $date])
                          ->orderBy('journals.id', 'DESC')->get();

                      }
                  }

               ?>
              @if($operations->isNotEmpty())

                <h2>{{ $c->numero }} {{ $c->libelle }}</h2>

                <table id="table1" class="" width="100%">

                  <thead>

                    <tr class="bg-secondary text-white">

                      <th class="text-center">N°</th>
                      <th class="text-center">Date Opération</th>
                      @if( $affichage == 'detail' )
                      <th class="text-center">Client</th>
                      <th class="text-center">Guichetier</th>
                      <th class="text-center">Agence</th>
                      @endif
                      <th class="text-center">Libéllé</th>
                      <th class="text-center">Débit</th>
                      <th class="text-center">Crédit</th>
                      
                    </tr>

                  </thead>

                  <tbody>

                      @php
                        $i = 1;
                        $total_debit = 0;
                        $total_credit = 0;
                        $total_mvmt = 0;
                      @endphp

                      
                      @foreach( $operations as $m )

                      @php 
                        $total_debit = $total_debit + $m->debit;
                        $total_credit = $total_credit + $m->credit;
                      @endphp
                      <tr>

                          <td class="text-center">{{ $m->id }}</td>

                          <td class="text-center">{{$m->date}}</td>

                          @if( $affichage == 'detail' )
                          <td class="text-center">
                            <b>
                              {{ $m->account_id }}
                            </b>
                          </td>
                          <td class="text-center">
                            <b>
                              {{ $m->nom }}
                            </b>
                          </td>
                          <td class="text-center">
                            <b>
                              {{ $m->name }}
                            </b>
                          </td>
                          @endif

                          <td class="text-center">


                            {{$m->description}}

                          </td>






                          <td class="text-center"><b>
                            @if( $m->debit > 0 )
                              {{ number_format($m->debit, 0, 2, ' ') }} BIF</b>
                            @endif
                          </td>


                        <td class="text-center">
                          <b>
                            @if( $m->credit > 0 )
                              {{ number_format($m->credit, 0, 2, ' ') }} BIF</b>
                            @endif
                          </b>
                        </td>

                        
                      </tr>

                      @endforeach

                  </tbody>
                  <tfoot>

                    <tr style="border-top: 2px solid; padding: 25px;">
                      <th>
                          @if( $total_debit > $total_credit )
                            Solde Débiteur
                          @endif

                          @if( $total_debit < $total_credit )
                            Solde Créditeur
                          @endif

                          @if( $total_debit == $total_credit )
                            Solde
                          @endif
                      </th>
                      @if( $affichage == 'detail' )
                      <th class="" colspan="5"></th>
                      @else
                      <th class="" colspan="2"></th>
                      @endif
                      <th class="text-center">
                        <i>
                        @if( $total_debit < $total_credit )
                          {{ number_format($total_credit - $total_debit, 0, 2, ' ') }} BIF
                        @endif

                        @if( $total_debit == $total_credit )
                          0 BIF
                        @endif
                        </i>
                      </th>
                      <th class="text-center">
                        <i>
                        @if( $total_debit > $total_credit )
                          {{ number_format($total_debit - $total_credit, 0, 2, ' ') }} 
                          BIF


                        @endif

                        @if( $total_debit == $total_credit )
                          0 BIF
                        @endif
                        </i>
                      </th>
                    </tr>
                    <tr>
                      <th>TOTAL</th>
                      @if( $affichage == 'detail' )
                      <th colspan="5"></th>
                      @else
                      <th colspan="2"></th>
                      @endif
                      <th class="text-center">
                        @if( $total_debit < $total_credit )
                        {{ number_format($total_debit + $total_credit - $total_debit, 0, 2, ' ') }} BIF
                        @else
                        {{ number_format($total_debit, 0, 2, ' ') }} BIF
                        @endif
                      </th>
                      <th class="text-center">
                        @if( $total_debit > $total_credit )
                        {{ number_format($total_credit + $total_debit - $total_credit, 0, 2, ' ') }} BIF
                        @else
                        {{ number_format($total_credit, 0, 2, ' ') }} BIF
                        @endif
                      </th>
                    </tr>
                  </tfoot>
                </table>

                <br><br>
              @endif

              @endforeach
            </div>

		          	
		        </div>

	      	</div>
      	</div>
    	</div>
  	</section>
@endsection