@extends('layouts.template')
@section('title', 'Edit-Plafonds')



@section('css')
<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
@endsection



@section('content')

<div class="page-heading">

    <div class="page-title">

      <div class="row">

        <div class="col-12 col-md-6 order-md-1 order-last">

          <h3 style="text-transform: uppercase;">Modication des plafonds</h3>

        </div>

        <div class="col-12 col-md-6 order-md-2 order-first">

          <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">

            <ol class="breadcrumb">

              <li class="breadcrumb-item">

                <a href="{{ route('dashboard') }}">Tableau de bord</a>

              </li>

              <li class="breadcrumb-item active" aria-current="page">

                Plafonds

              </li>

            </ol>

          </nav>

        </div>

      </div>

  </div>
</div>




  <div class="row">



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

    <div class="col-md-12 grid-margin stretch-card">

      <div class="card">

        <div class="card-header">

            <div class="d-flex justify-content-between align-items-center">

                <h3 class="card-title">Modifier le plafond</h3>

                <a href="{{ route('plafonds-index') }}" class="btn btn-primary">

                    <i class="bi bi-list"></i> Liste des plafonds

                </a>

            </div>

        </div>

        <div class="card-body">

          <form class="forms-sample" action="{{ route('plafonds-edit-valid') }}" method="POST">


            {{ csrf_field() }}

            <div class="row">
                <input type="hidden" value="{{ $plafonds->id }}" name="plafonds_id">

                <div class="col-md-12">
                    <div class="form-group">
                      <label>Type d'operation <span class="text-danger"> *</span></label>
                      <select class="form-control form-control-xl" name="type_operation" required="required">
                        @foreach( $type_operations as $t )
                        <option value="{{ $t->id }}" <?php if( $plafonds->type_operation == $t->id){ echo "selected"; } ?> >{{ $t->name }}</option>
                        @endforeach
                      </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="montant_min">Montant minimum<span class="text-danger"> *</span></label>
                        <input type="number" required class="form-control form-control-xl" value="{{ $plafonds->montant_min }}" id="montant_min" name="montant_min" autocomplete="0" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="montant_max">Montant maximum<span class="text-danger"> *</span></label>
                        <input type="number" class="form-control form-control-xl" value="{{ $plafonds->montant_max }}" id="montant_max" name="montant_max" autocomplete="0" />
                    </div>
                </div>

                
            </div>


            

            <button type="submit" class="btn btn-primary me-2"> Modifier </button>

            <button class="btn btn-danger" type="reset">Annuler</button>

          </form>

        </div>

      </div>

    </div>

  </div>

@endsection



@section('js')

<script src="/assets/extensions/jquery/jquery.min.js"></script>



<script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}" id="parsley"></script>



<script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>

<script src="/assets/js/pages/simple-datatables.js"></script>

@endsection