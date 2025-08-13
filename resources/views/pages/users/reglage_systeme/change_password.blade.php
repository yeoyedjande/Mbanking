@extends('layouts.template')



@section('title', 'Change Password')

@section('link', 'change')



@section('content')

<!-- Content Header (Page header) -->

  <div class="page-heading">
      <div class="page-title">
        <div class="row">
          <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Changer le mot de passe</h3>
          </div>
          <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="{{ route('dashboard') }}">Tableau de bord</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Changer le mot de passe
                </li>
              </ol>
            </nav>
          </div>
        </div>
    </div>
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



          <div class="col-md-12">

            <div class="card card-danger">

              <!-- /.card-header -->



              <!-- form start -->

            <form role="form" action="{{ route('Change-Autre-Passe') }}" method="POST">

              {{ csrf_field() }}

              <div class="card-body">

                  <div class="row">

                      <div class="col-md-12">

                          <div class="form-group">
                            <label>Sélectionnez un utilisateur *</label>
                            <select name="selected_user" required class="form-control choices" required>
                                <option value=""></option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->nom }} {{ $user->prenom }}</option>
                                @endforeach
                            </select>
                        </div>

                      </div>

                      <div class="col-md-12">

                          <div class="form-group">
                              <label>Nouveau mot de passe *</label>
                              <input type="password" name="new_password" class="form-control form-control-lg" required>
                          </div>

                      </div>

                      @error('new_password')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror

                      <div class="col-md-12">

                          <div class="form-group">
                              <label>Confirmer le nouveau mot de passe *</label>
                              <input type="password" name="conf_password" class="form-control form-control-lg" required>
                          </div>

                      </div>

                      @error('conf_password')
                      <span class="text-danger">{{ $message }}</span>
                      @enderror

                  </div>

                  <!-- /.card-body -->

                  <div>
                      <button type="submit" id="CreateType_institution" class="btn btn-danger btn-lg"><i class="fa fa-plus"></i> Modifier</button>
                  </div>

              </div>

          </form>






            </div>

          </div>

          <!-- /.col -->

        </div>

        <!-- /.row -->



      </div><!--/. container-fluid -->

    </section>

    <!-- /.content -->


@endsection