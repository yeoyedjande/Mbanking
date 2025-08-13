@extends('layouts.app_client')

@section('title', 'Change Password')
@section('link', 'change')

@section('content')

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

          
      <div class="container">

        <h1>Changer de mot de passe</h1>

        <form role="form" action="{{route('password.update')}}" method="POST">

          {{ csrf_field() }}
          <div class="card-body">
            <div class="row">

              <div class="col-md-12">
                <div class="form-group">
                  <label>Ancien mot de passe*</label>
                  <input type="password" name="old_password" class="form-control form-control-lg">
                </div>
                @error('old_password')
                <span  class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="col-md-12">
                <div class="form-group">
                  <label>Nouveau mot de passe *</label>
                  <input type="password" name="new_password" class="form-control form-control-lg">
                </div>
              </div>

              @error('new_password')
              <span class="text-danger">{{ $message }}</span>
              @enderror

              <div class="col-md-12">
                <div class="form-group">
                  <label>Confirmer le nouveau mot de passe *</label>
                  <input type="password" name="conf_password" class="form-control form-control-lg">
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
        </form>


      </div>

@endsection