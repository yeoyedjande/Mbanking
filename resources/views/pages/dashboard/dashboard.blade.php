@extends('layouts.template')
@section('title', 'Dashboard')

@section('content')

  @can('is-admin')

    @include('pages.dashboard.master.dash_admin')

  @endcan



   @can('is-caissier-principal')

    @include('pages.dashboard.master.dash_caissier_principal')

  @endcan



  @can('is-analyste-credit')

    @include('pages.dashboard.master.dash_analyste_credit')

  @endcan



  @can('is-receptioniste')

    @include('pages.dashboard.master.dash_reception')

  @endcan



  @can('is-chef-service-credit')

    @include('pages.dashboard.master.dash_chef_service_credit')

  @endcan

  @can('is-service-operation')

    @include('pages.dashboard.master.dash_service_operation')

  @endcan

  @can('is-comptable')

    @include('pages.dashboard.master.dash_comptable')

  @endcan

  @can('is-direction')

    @include('pages.dashboard.master.dash_direction')

  @endcan

  @can('is-caissier')



    <?php if ( isset($verif_caisse) ): ?>



      <?php if ( $verif_caisse->verify == 'no' ): ?>

          @include('pages.caisses.ouverture_caisse')
         
        <?php elseif ( $verif_caisse->verify == 'noferme' ): ?>
          @include('pages.dashboard.master.caisse_no_ferme')

        <?php elseif ( $verif_caisse->verify == 'ferme' ): ?>
          @include('pages.dashboard.master.caisse_ferme')
        <?php else: ?>

          @include('pages.dashboard.master.dash_caissier')

      <?php endif ?>

      <?php else: ?>

        @include('pages.caisses.pending_caisse')

    <?php endif ?>

    





  @endcan



@endsection



@section('js')

<!-- Need: Apexcharts -->



  <script src="/assets/extensions/jquery/jquery.min.js"></script>



  <script src="/assets/extensions/apexcharts/apexcharts.min.js"></script>

  <script src="/assets/js/pages/dashboard.js"></script>



  <script src="/assets/extensions/dayjs/dayjs.min.js"></script>

  <script src="/assets/extensions/apexcharts/apexcharts.min.js"></script>

  <script src="/assets/js/pages/ui-apexchart.js"></script>







<script src="/assets/js/_bil.js"></script>



@endsection

