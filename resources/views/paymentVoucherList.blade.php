@section('content')
@extends('layouts.master')
@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.page-header')
@slot('title') Home @endslot
@slot('subtitle') Payment Voucher List @endslot
@endcomponent
<!-- Content area -->
<div class="content">

    <!-- Dashboard content -->
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Payment Voucher List</h5>
            <div class="d-inline-flex ms-auto"></div>
        </div>

        <div class="card-body border-top">

            <div class="row">
                <div class="col-md-12" style="text-align: right;">
                    <button type="button" class="btn btn-primary" onclick="add_payment_voucher();" style="float:right;"><i class="ph-plus"></i>&nbsp;Add New</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3">
                    <table id="tbl_payment_voucher" class="table table-striped datatable-fixed-both-payment-voucher" role="grid" aria-describedby="example1_info">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Cheque No</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>


        </div>
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
<script src="{{URL::asset('assets/js/vendor/pickers/daterangepicker.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/pickers/datepicker.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/forms/selects/select2.min.js')}}"></script>

<script src="{{URL::asset('assets/js/payment_voucher_list.js')}}?random=<?php echo uniqid(); ?>"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection