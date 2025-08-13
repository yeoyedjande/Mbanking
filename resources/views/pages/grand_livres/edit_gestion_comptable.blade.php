@extends('layouts.template')

@section('title', 'Modification du plan comptable')
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

	              Modification du plan comptable

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
		        	<h2>Edition du plan comptable</h2>
		        </div>

		        <div class="card-body">

		          	<form class="form_compte_comptable" method="POST" action="{{ route('gestion-comptable-valid') }}">

		          			{{ csrf_field() }}
		          			<div class="row">
		          			<input type="hidden" id="compte_id" value="{{ $gestion_comptable->numero }}" name="numero">
		          			<div class="form-group col-md-6">
				             	<label>Libellé *</label>
				             	<input type="text" value="{{ $gestion_comptable->libelle }}" id="libelle" required class="form-control form-control-xl" name="libelle" autocomplete="0">
				            </div>

		          			<div class="form-group col-md-6">
				             	<label>Compartiment *</label>
				             	<select class="form-control form-control-xl" name="num_account" id="compte" required>
				             		<option value="Actif" <?php if ($gestion_comptable->compartiment == 'Actif') {
				             			echo "selected";
				             		} ?>>Actif</option>
				             		<option value="Passif"<?php if ($gestion_comptable->compartiment == 'Passif') {
				             			echo "selected";
				             		} ?>>Passif</option>
				             		<option value="Charge"<?php if ($gestion_comptable->compartiment == 'Charge') {
				             			echo "selected";
				             		} ?>>Charge</option>
				             		<option value="Produit"<?php if ($gestion_comptable->compartiment == 'Produit') {
				             			echo "selected";
				             		} ?>>Produit</option>
				             		<option value="Actif-Passif" <?php if ($gestion_comptable->compartiment == 'Actif-Passif') {
				             			echo "selected";
				             		} ?>>Actif-Passif</option>
				             		
				             	</select>
				            </div>

				            <div class="form-group">
				             	<label>Sens naturel *</label>
				             	<select class="form-control form-control-xl" name="sens" id="sens" required>
				             		<option value="Débiteur" <?php if ($gestion_comptable->compartiment == 'Débiteur') {
				             			echo "selected";
				             		} ?>>Débiteur</option>
				             		<option value="Créditeur"<?php if ($gestion_comptable->compartiment == 'Créditeur') {
				             			echo "selected";
				             		} ?>>Créditeur</option>
				             		<option value="Mixte"<?php if ($gestion_comptable->compartiment == 'Mixte') {
				             			echo "selected";
				             		} ?>>Mixte</option>
				             	</select>
				            </div>

				            <div class="form-group">
				              <button type="submit" id="btn_compte" class="btn btn-primary btn-lg">Editer</button>
				            </div>

				            </div>

		          	</form>

		        </div>

		      </div>

      	</div>
	      

    	</div>

  	</section>
@endsection