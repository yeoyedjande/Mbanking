@extends('layouts.template')

@section('title', 'Journal')

@section('css')
  <link rel="stylesheet" href="/assets/css/pages/fontawesome.html" />
  <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css"/>
    <link rel="stylesheet" href="/assets/css/pages/simple-datatables.css" />
@endsection

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

	              Journal

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
	        		<h2>Le journal</h2>
		        </div>

		        <div class="card-body">

		        	<div class="col-12">

              

              <table id="" class="table table-bordered" cellspacing="0" width="100%">

                <thead>
                  <tr class="bg-primary text-white">
                    
                    <th class="text-center">Date</th>
                    <th class="text-center">N° Pièce</th>
                    <th class="text-center">Fonction</th>
                    <th class="text-center">Référence</th>
                    <th class="text-center">Opérations</th>
                    @if( $affichage == 'detail' )
                    <th class="text-center">Client</th>
                    <th class="text-center">Guichetier</th>
                    <th class="text-center">Agence</th>
                    @endif
                    <th class="text-center">Compte</th>
                    <th class="text-center">Intitulé de compte</th>
                    <th class="text-center">Débit</th>
                    <th class="text-center">Crédit</th>
                  </tr>
                </thead>

                <tbody>

                    @php

                    $i = 1;
                    $total_debit = 0;
                    $total_credit = 0;

                    
                    $previousRef = null;
                    $previousPiece = null;
                    $previousFonction = null;

                    @endphp

                    @if($journals->isNotEmpty())

                    @foreach( $journals as $m )

                    @php 
                      $total_debit = $total_debit + $m->debit;
                      $total_credit = $total_credit + $m->credit;
                    @endphp

                    <?php 
                      $compte = DB::table('compte_comptables')->where('numero', $m->compte)->first();
                    ?>
                      
                      <tr>
                        <td class="text-center">{{$m->date}}</td>

                        @if($m->numero_piece != $previousPiece)
                            <td class="text-center">{{ $m->numero_piece }}</td>
                            @php $previousPiece = $m->numero_piece; @endphp
                        @else
                            <td class="text-center"></td>
                        @endif

                        @if($m->libelle != $previousFonction)
                            <td class="text-center">{{ $m->libelle }}</td>
                            @php $previousFonction = $m->libelle; @endphp
                        @else
                            <td class="text-center"></td>
                        @endif

                        @if($m->reference != $previousRef)
                            <td class="text-center">{{ $m->reference }}</td>
                            @php $previousRef = $m->reference; @endphp
                        @else
                            <td class="text-center"></td>
                        @endif

                        <td class="text-center">{{ $m->description ?? '' }}</td>
                        @if( $affichage == 'detail' )
                        <td class="text-center">{{ $m->client_id ?? '' }}</td>
                        <td class="text-center">{{ $m->nom ?? '' }}</td>
                        <td class="text-center">{{ $m->name ?? '' }}</td>
                        @endif
                        <td class="text-center"><b>{{ $m->compte }}</b></td>
                        <td class="text-center"><b>{{ $compte->libelle }}</b></td>


                        <td class="text-center">
                          
                            @if( $m->debit > 0)  
                            <b>                        
                            {{ number_format($m->debit, 0, 2, ' ') }} BIF</b>
                            @endif
                          
                        </td>


                        <td class="text-center">
                          @if( $m->credit > 0)
                          <b>
                            {{ number_format($m->credit, 0, 2, ' ') }} BIF</b>
                           
                          </b>
                          @endif
                        </td>
                      </tr>

                    

                    @endforeach

                    @endif

                </tbody>

                <tfoot>
                  @if( $affichage == 'detail' )
                  <th colspan="10" class="">TOTAL</th>
                  @else
                  <th colspan="7" class="">TOTAL</th>
                  @endif
                  <th class="text-center">{{ number_format($total_debit, 0, 2, ' ') }} BIF</th>
                  <th class="text-center">{{ number_format($total_credit, 0, 2, ' ') }} BIF</th>
                </tfoot>
              </table>


            </div>
            <!-- Pagination links -->
            <div class="d-flex justify-content-center">
                {{ $journals->links('vendor.pagination.custom-pagination') }}
            </div>
		          	
		        </div>

	      	</div>
      	</div>
    	</div>
  	</section>
@endsection

@section('js')
<script src="/assets/extensions/jquery/jquery.min.js"></script>
<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
<script src="/assets/js/pages/simple-datatables.js"></script>
@endsection