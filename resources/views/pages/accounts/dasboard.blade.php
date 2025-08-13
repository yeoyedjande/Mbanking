@extends('layouts.app')

@section('title', $title)

@section('css')
<link rel="stylesheet" href="/assets/css/demo_3/style.css">

<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
@endsection

@section('content')

<div class="page-header flex-wrap">
  <div class="header-right d-flex flex-wrap mt-md-2 mt-lg-0">
    <div class="d-flex align-items-center">
      <a href="#">
        <p class="m-0 pe-3">Dashboard</p>
      </a>
      <a class="ps-3 me-4" href="#">
        <p class="m-0">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</p>
      </a>
    </div>
  </div>
</div>


<div class="row">
</div>


@endsection