@section('content')
@extends('layouts.master')
@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.page-header')
@slot('title') Home @endslot
@slot('subtitle') Dashboard @endslot
@endcomponent
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Content area -->
<div class="content">

    <!-- Dashboard content -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">Customer</h5>
                    <div class="d-inline-flex ms-auto"></div>
                </div>

                <form id="form" class="was-validated">
                    <div class="card-body border-top">
                        <div class="row">

                            <label class="col-md-2 col-form-label">Customer ID:</label>

                            <div class="col-md-4 mb-2">
                                <input class="form-control form-control-sm validate" type="text" id="customer_id" placeholder="Customer ID" required>
                                <div id="error_validation_customer_id" class="w-4/8 m-auto text-left text-danger error_validation"></div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Customer Name:</label>
                            <div class="col-md-4 mb-2">
                                <input class="form-control form-control-sm" type="text" id="customer_name" placeholder="Customer Name" required>
                                <div id="error_validation_customer_name" class="w-4/8 m-auto text-left text-danger error_validation"></div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Credit Limit:</label>
                            <div class="col-md-4 mb-2">
                                <input class="form-control form-control-sm" type="text" id="credit_limit" placeholder="Credit Limit" required>
                                <div id="error_validation_credit_limit" class="w-4/8 m-auto text-left text-danger error_validation"></div>
                            </div>
                        </div>
                        <div class="row">

                            <label class="col-md-2 col-form-label">Customer ID:</label>

                            <div class="col-md-4 mb-2">
                                <input class="form-control form-control-sm validate" type="text" id="customer_id" placeholder="Customer ID" required>
                                <div id="error_validation_customer_id" class="w-4/8 m-auto text-left text-danger error_validation"></div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Customer Name:</label>
                            <div class="col-md-4 mb-2">
                                <input class="form-control form-control-sm" type="text" id="customer_name" placeholder="Customer Name" required>
                                <div id="error_validation_customer_name" class="w-4/8 m-auto text-left text-danger error_validation"></div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Credit Limit:</label>
                            <div class="col-md-4 mb-2">
                                <input class="form-control form-control-sm" type="text" id="credit_limit" placeholder="Credit Limit" required>
                                <div id="error_validation_credit_limit" class="w-4/8 m-auto text-left text-danger error_validation"></div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-2 col-form-label">Customer Address:</label>
                            <div class="col-md-4 mb-2">
                                <Textarea class="form-control" id="customer_address" required></Textarea>
                                <div id="error_validation_customer_address" class="w-4/8 m-auto text-left text-danger error_validation"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4 mb-2">
                                <button type="button" id="btnSave" class="btn btn-primary form-btn btn-sm">Save</button>
                                <button type="button" id="btnReset" class="btn btn-warning form-btn btn-sm">Reset</button>
                            </div>

                        </div>
                    </div>

                </form>
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
<script src="{{URL::asset('assets/js/vendor/visualization/d3/d3.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/visualization/d3/d3_tooltip.js')}}"></script>
<script src="{{URL::asset('assets/js/customer.js')}}"></script>
@endsection
@section('scripts')

@endsection