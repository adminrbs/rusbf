@section('content')
@extends('layouts.master')
@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.page-header')
@slot('title') Home @endslot
@slot('subtitle') Payment Voucher @endslot
@endcomponent
<!-- Content area -->
<div class="content">

    <!-- Dashboard content -->
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Payment Voucher</h5>
            <div class="d-inline-flex ms-auto"></div>
        </div>

        <div class="card-body border-top">
            <div class="row">
                <div class="col-md-4">
                    <label>Voucher Number</label>
                    <input type="text" id="txtVoucherNumber" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Voucher Date</label>
                    <input type="text" id="txtVoucherDate" name="txtVoucherDate" class="form-control daterange-single">
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>Ledger P/Number</label>
                    <input type="text" id="txtLedgerNumber" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Member Number</label>
                    <select type="text" id="txtMemberNumber" class="form-control select2">
                        <option selected disabled>Select Member</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label>Cheque Number</label>
                    <input type="text" id="txtChqueNumber" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Name</label>
                    <input type="text" id="txtName" class="form-control" disabled>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <label>Discription</label>
                    <input type="text" class="form-control" id="txtDiscription">
                </div>
                <div class="col-md-2">
                    <label>Amount</label>
                    <input type="number" class="form-control" id="txtAmount" style="text-align: right;">
                </div>
                <div class="col-md-1 mt-3">
                    <button class="btn btn-primary" id="btnAdd" style="height: 35px;">Add</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 mt-3">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Discription</th>
                                <th style="width:100px">Amount</th>
                                <th style="width:80px"></th>
                            </tr>
                        </thead>
                        <tbody id="tblBody"></tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9" style="text-align: right;">
                    <button class="btn btn-primary" id="btnAction" style="width: 100px;">Save</button>
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

<script src="{{URL::asset('assets/js/payment_voucher.js')}}?random=<?php echo uniqid(); ?>"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection