@section('content')
@extends('layouts.master')
@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.page-header')
@slot('title') Home @endslot
@slot('subtitle') Monthend Process  @endslot
@endcomponent
<!-- Content area -->
<div class="content">

    <!-- Dashboard content -->
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Monthend Process</h5>
            <div class="d-inline-flex ms-auto"></div>
        </div>

        <div class="card-body border-top">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <inpu id="lbl_year">Year:</label>
                    <input type="text" class="form-control" id="txt_year" disabled>
                </div>
                <div class="col-md-3 mb-3">
                    <label id="lbl_month">Month:</label>
                    <input type="text" class="form-control" id="txt_month" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                   <button id="btn_process" class="btn btn-primary">Process</button>
                </div>
            </div>

        </div>
        <hr>
    </div>
    <!-- /dashboard content -->

</div>
<!-- /content area -->

@endsection
@section('center-scripts')
<!-- Javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Theme JS files -->
<script src="{{URL::asset('assets/js/vendor/ui/moment/moment.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/notifications/noty.min.js')}}"></script>

@endsection
@section('scripts')
<script src="{{URL::asset('assets/demo/pages/form_validation_library.js')}}"></script>
<script src="{{URL::asset('assets/demo/pages/extra_noty.js')}}"></script>

<!-- dataTables -->
<script src="{{URL::asset('assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{URL::asset('assets/demo/pages/datatables_basic.js')}}"></script>


<script src="{{URL::asset('assets/js/monthend_process.js')}}?random=<?php echo uniqid(); ?>"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection