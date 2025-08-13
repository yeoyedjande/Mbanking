@extends('layouts.template')

@section('title', $title)

@section('css')
<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
@endsection

@section('content')
<div class="page-heading">
  <div class="page-title">
    <div class="row">
      <div class="col-12 col-md-6 order-md-1 order-last">
        <h3>Autorisations</h3>
      </div>
      <div class="col-12 col-md-6 order-md-2 order-first">
        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('dashboard') }}">Tableau de bord</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              Autorisations
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
        <div class="card-header">
          <h4>Liste des utilisateurs</h4>
        </div>
        <div class="card-body">

          <form class="forms-sample" action="{{ route('permission-assign') }}" method="POST">

            {{ csrf_field() }}
            <div class="form-group">
              <div class="input-group">
                <select class="form-control form-control-lg" name="role_id" id="role_id" required>
                  <option value="">Selectionner</option>
                  @foreach($roles as $r)
                  <option value="{{ $r->id }}">{{ $r->name }}</option>
                  @endforeach
                </select>
                <div class="input-group-append">
                  <button class="btn btn-lg btn-primary" type="submit"><i class="mdi mdi mdi-arrange-bring-to-front"></i> Attribuer les permissions</button>
                </div>
              </div>
              
            </div>
            
             @if( $permissions->isNotEmpty() )
              <div class="mt-5">
                  <input type="button"  id="select-all" class="btn btn-info" value="Coucher Tout" />
                  <input type="button"  id="deselect-all" class="btn btn-danger" value="Decoucher Tout"/>

                  <div class="pt-5">
                      <?php $order =""; ?>
                        @foreach($permissions as $item )

                            <?php
                                
                                if ($order == $item->groupe) {
                                    # code.
                            ?>
                                
                            <?php

                                } else {
                                    echo " </div>";
                                    $order = $item->groupe;
                                    echo "<h3 class='mt-3'> $order  </h3> <br>";
                                    echo " <div class='d-flex flex-wrap align-items-start' >"; 
                                }
                                
                            ?>

                            <div class="form-check p-4 #flex-fill">
                                <input type="checkbox" class="form-check-input" value="{{$item->id}}" name="permissions[]" id="{{$item->name}}">
                                <label class="form-check-label ml-5" for="{{$item->name}}">{{$item->guard_name}} </label>
                            </div>

                            

                        @endforeach
                  </div>
              </div>    

              @else
                  <div class="card card-inverse-danger mb-5">
                    <div class="card-body">
                      <p class="mb-4"> Vous n'avez pas encore ajouté de permissions !</p>
                    </div>
                  </div>
              @endif

          </form>
        </div>
      </div>
    </section>

@endsection

@section('js')
<script src="/assets/extensions/jquery/jquery.min.js"></script>

<script>
  $(document).ready(function(){

      $("#select-all").on("click",function(){
          $("input[type='checkbox'] ").attr("checked", "checked");
      });

      $("#deselect-all").on("click",function(){
          $("input[type='checkbox'] ").removeAttr("checked");
      });

      $("#role_id").on("change",function(){

          var role_id = $("#role_id").val();
          $.get( "/permission_role/" + role_id , function(data, status){
              $("input[type='checkbox'] ").removeAttr("checked");
              list = JSON.parse (data)
              $.each(list, function(index, elt) {
                  console.log(elt)
                  $(":checkbox[value='"+ elt+"'] ").attr("checked", "checked");
              });

          });

      });

  });
</script>
@endsection