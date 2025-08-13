@extends('layouts.template')
@section('title', $title)


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

              <a href="{{ route('home') }}">Tableau de bord</a>

            </li>

            <li class="breadcrumb-item active" aria-current="page">

              {{$title}}

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

      <div class="card">

        <div class="card-body">

            <form method="GET" action="{{ route('editions-bancaire-check') }}">

              {{ csrf_field() }}
                <div class="form-group">
                  <label>Numéro de compte *</label>
                  <input type="text" name="flash" class="form-control form-control-xl" required>
                </div>

                <div class="form-group">
                  <button type="submit" class="btn btn-info"><i class="fa fa-print"></i> Générer sa carte</button>
                </div>
            </form>

        </div>

      </div>

      

  </section>




@endsection