@extends('layouts.template')

@section('title', 'Create-Clients')

@section('content')

<div class="container mt-5">

    @if($etat_juridique->slug === 'personne-morale')

        @include('pages.accounts.personne_moral')

    @elseif($etat_juridique->slug === 'personne-physique')

        @include('pages.accounts.personne_physique')

    @elseif($etat_juridique->slug === 'groupe-informel')

        @include('pages.accounts.groupe_formelle')

    @elseif($etat_juridique->slug === 'groupe-solidaire')

        @include('pages.accounts.groupe_solidaire')

    @endif

</div>

@endsection
