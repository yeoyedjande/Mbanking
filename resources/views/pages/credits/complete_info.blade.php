@extends('layouts.template')



@section('title', $title)



@section('css')

  <style>

    .form-section {

        display: none;

    }



    .form-section.current {

        display: block;

    }

</style>

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

    

  	<section id="multiple-column-form">

        <div class="row match-height">

            <div class="col-12">

                <div class="card">

                    

                    <div class="row">

                    

                    <div class="card-content">

                        <div class="card-body">



                           <form class="form" method="POST" action="{{ route('valid-credit-compete') }}">

                              @csrf

                              <!--ETAPE 1-->
                              
                                <div class="row">

                                    <h4 class="mb-4">Informations sur la demande</h4>
                                    <input type="hidden" name="dossier" value="{{ $demande_id }}">
                                  <!-- Page 1 -->

                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Montant de la demande (BIF)*</label>  
                                          <input type="text" style="color: green; font-weight: bold;" id="montant_demande" name="montant_demande" value="{{ number_format($demande->montant_demande, 0, 2, ' ') }}" class="form-control form-control-xl"  required readonly />
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Compte lié *</label>  
                                          <input id="num_account" type="text" name="num_account" value="{{ $demande->num_account }}" class="form-control form-control-xl"  required readonly />
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Client *</label>  
                                          <input type="text" name="client" value="{{ $demande->nom }}" class="form-control form-control-xl"  required readonly />
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Type de crédit *</label>  
                                          <input type="text" name="type_credit" value="{{ $demande->name }}" class="form-control form-control-xl"  required readonly />
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Date de la demande *</label>  
                                          <input type="text" name="date_demande" value="{{ $demande->date_demande }}" class="form-control form-control-xl"  required readonly />
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Date de déblocage</label>  
                                          <input type="date" name="date_deblocage" class="form-control form-control-xl"/>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Objet de la demande *</label>  
                                          <select name="objet" required class="form-control form-control-xl form-select">
                                            <option value="">Selectionner</option>
                                            @foreach( $objets as $o )
                                            <option value="{{ $o->id }}">{{ $o->libelle }}</option>
                                            @endforeach
                                          </select>
                                      </div>
                                    </div>

                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Durée (en mois) *</label>  
                                          <input type="number" min="1" name="duree" class="form-control form-control-xl" required />
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Prélèvement automatique *</label>  
                                          <select required name="preleve_auto" class="form-control form-control-xl form-select">
                                            <option value="">Selectionner</option>
                                            <option value="oui">Oui</option>
                                            <option value="non">Non</option>
                                          </select>
                                      </div>
                                    </div>

                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Commission *</label>  
                                          <input type="number" min="1" name="commission" class="form-control form-control-xl" required />
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Assurance *</label>  
                                          <input type="number" min="1" name="assurance" class="form-control form-control-xl" required />
                                      </div>
                                    </div>

                                    <div class="col-md-4">
                                      <div class="form-group">
                                        <label>Garantie Attendues *</label>  
                                          <input type="text" value="{{ number_format($demande->montant_demande, 0, 2, ' ') }}" min="1" name="garantie_attendue" class="form-control form-control-xl" required />
                                      </div>
                                    </div>

                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <label>Détails de la demande *</label>  
                                        <textarea rows="" class="form-control form-control-xl" required name="detail_demande" placeholder="Détails de la demande"></textarea>
                                      </div>
                                    </div> 

                                    <h4 class="mb-4">Mobilisation de la grantie</h4>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Type de la garantie *</label>  
                                          <select id="type_garantie" required name="type_garantie" class="form-control form-control-xl form-select">
                                            <option value="">Selectionner</option>
                                            <option value="numeraire">Numéraire</option>
                                            <option value="materiel">Matériel</option>
                                          </select>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label>Montant de la garantie *</label>  
                                          <input type="number" class="form-control form-control-xl" required name="mnt_garantie">
                                      </div>
                                    </div>
                                    <div class="col-md-4" id="type_bien">
                                      <div class="form-group">
                                        <label>Type de bien *</label>  
                                          <select required id="select_type_bien" name="type_bien" class="form-control form-control-xl form-select">
                                            <option value="">Selectionner</option>
                                            @foreach( $biens as $b )
                                            <option value="{{$b->id}}">{{$b->libelle}}</option>
                                            @endforeach
                                          </select>
                                      </div>
                                    </div>

                                    <div class="col-md-4" id="client_gar">
                                      <div class="form-group">
                                        <label>Client garant du matériel *</label>  
                                          <select required name="client_garant" class="form-control form-control-xl form-select" id="chp_client_materiel">
                                            <option value="">Selectionner</option>
                                            <option value="numéraire">Numéraire</option>
                                            <option value="matériel">Matériel</option>
                                          </select>
                                      </div>
                                    </div>
                                    
                                    <div class="col-md-4" id="etat_gar">
                                      <div class="form-group">
                                        <label>Etat de la garantie *</label>  
                                          <select required id="select_etat_gar" name="etat_gar" class="form-control form-control-xl form-select">
                                            <option value="">Selectionner</option>
                                            <option value="en_cours_mobilisation">En cours de mobilisation</option>
                                            <option value="prete">Prête</option>
                                          </select>
                                      </div>
                                    </div>

                                    <div class="col-md-12" id="description_mat">
                                      <div class="form-group">
                                        <label>Description du matériel *</label>  
                                        <textarea rows="" id="text_desc_mat" class="form-control form-control-xl" required name="description" placeholder="Description du matériel"></textarea>
                                      </div>
                                    </div> 

                                    <div class="col-md-12">
                                      <div class="form-group">
                                        <a href="{{ route('liste-demandes-assign') }}" class="btn btn-danger btn-lg">< Retour</a>
                                        <button type="submit" class="btn btn-primary btn-lg">Suivant ></button>
                                      </div>
                                    </div> 

                                    
                         			  </div>
                              <!--/ETAPE 1-->
                            </form>

                        </div>



                    </div>

                </div>

             </div>

        </div>

    </section>

  	

    

  </div>

@endsection



@section('js')

	<script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
  <script>
    $(document).ready(function() {
      
        $('#type_garantie').change(function(){

            $("#type_garantie option:selected").each(function () {

              var selectedValue = $(this).val();
              
              if( selectedValue == 'materiel' ){
                $('#type_bien').show();
                $('#client_gar').show();
                $('#etat_gar').show();
                $('#description_mat').show();
              }else if( selectedValue == 'numeraire' ){
                $('#type_bien').hide();
                $('#client_gar').hide();
                $('#etat_gar').hide();
                $('#description_mat').hide();
                $('#type_bien, #client_gar, #etat_gar, #description_mat').find(':input').removeAttr('required');

              }else{
                $('#type_bien').show();
                $('#client_gar').show();
                $('#etat_gar').show();
                $('#description_mat').show();
              }

          });


        });

    });
  </script>

@endsection