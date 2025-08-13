@extends('admin.layouts.admin')



@section('title', 'Change Type Crédit')

@section('link', 'change type credit')



@section('content')

<!-- Content Header (Page header) -->

    <div class="content-header">

      <div class="container-fluid">

        <div class="row mb-2">

          <div class="col-sm-6">

            <h1 class="m-0 text-dark">Changer le type de crédit</h1>

          </div><!-- /.col -->

          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">

              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de Bord</a></li>

              <li class="breadcrumb-item active">Changer le type de crédit</li>

            </ol>

          </div><!-- /.col -->

        </div><!-- /.row -->

      </div><!-- /.container-fluid -->

    </div>

    <!-- /.content-header -->



    <!-- Main content -->

    <section class="content">

      <div class="container-fluid">

        <!-- Info boxes -->



        <div class="row">

          @if( session()->has('msg') )

          <div class="col-md-12">

            <div class="alert alert-success">{{ session()->get('msg') }}</div>

          </div>

          @endif 



        @if(session()->has('msg_error'))

        <div class="col-md-12">

            <div class="alert alert-danger">{{ session()->get('msg_error') }}</div>

        </div>

        @endif

          <!-- Code ici -->

        </div>

        <!-- /.row -->



      </div><!--/. container-fluid -->

    </section>

    <!-- /.content -->



@endsection