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

                <form id="form" class="form-validate-jquery">
                    <div class="card-body border-top">
                        <div class="mb-4">

                            <!-- Customer ID field -->
                            <div class="row mb-1">
                                <label class="col-form-label col-md-2 mb-0">Customer ID <span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" name="customer_id" id="customer_id" class="form-control form-control-sm" required placeholder="ID" autocomplete="off">
                                </div>

                                <label class="col-form-label col-md-2 mb-0">Single Date Picker<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" name="date_single" id="date_single" class="form-control daterange-single" required value="03/18/2020">
                                </div>
                            </div>
                            <!-- /Customer ID field -->


                            <!-- Customer Name field -->
                            <div class="row mb-1">
                                <label class="col-form-label col-md-2 mb-0">Customer Name <span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" name="customer_name" id="customer_name" class="form-control form-control-sm" required placeholder="Name" autocomplete="off">
                                </div>

                                <label class="col-form-label col-md-2 mb-0">Date Range Picker <span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" name="date_range" id="date_range" class="form-control daterange-basic" required value="01/01/2020 - 01/31/2020">
                                </div>
                            </div>
                            <!-- /Customer Name field-->


                            <!-- Credit Limit field -->
                            <div class="row mb-1">
                                <label class="col-form-label col-md-2 mb-0">Credit Limit <span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" name="numbers" id="credit_limit" class="form-control form-control-sm" required placeholder="Number only" autocomplete="off">
                                </div>
                                <label class="col-md-2 mb-0 col-form-label pt-0">Swichery single <span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <label class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" name="switch_single" required>
                                        <span class="form-check-label">Accept our terms</span>
                                    </label>
                                </div>
                            </div>
                            <!-- /Credit Limit field-->

                            <!-- Customer Address field -->
                            <div class="row mb-1">
                                <label class="col-form-label col-md-2 mb-0">Customer Address <span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <textarea name="customer_address" id="customer_address" class="form-control form-control-sm" required placeholder="Address"></textarea>
                                </div>
                            </div>
                            <!-- /Customer Address field-->


                            <!-- Select With Search field -->
                            <div class="row mb-1">
                                <div class="mb-3 row mb">
                                    <label class="col-form-label col-md-2 mb-0">Select with search <span class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <select class="form-control  form-control-sm select" data-placeholder="Select Here...." required>
                                            <optgroup label="Mountain Time Zone">
                                                <option value="" disabled selected></option>
                                                <option value="AZ">Arizona</option>
                                                <option value="CO">Colorado</option>
                                                <option value="ID">Idaho</option>
                                                <option value="WY">Wyoming</option>
                                            </optgroup>
                                            <optgroup label="Central Time Zone">
                                                <option value="AL">Alabama</option>
                                                <option value="IA">Iowa</option>
                                                <option value="KS">Kansas</option>
                                                <option value="KY">Kentucky</option>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /Select With Search field -->

                            <!-- Single file upload -->
                            <div class="row mb-1">
                                <label class="col-form-label col-md-2 mb-0">Single File <span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <div action="#" class="dropzone" id="dropzone_single" required></div>
                                </div>

                            </div>
                            <!-- /Single file upload -->

                        </div>

                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-4 mb-2">
                                <button type="submit" id="btnSave" class="btn btn-primary form-btn btn-sm">Save</button>
                                <button type="button" id="btnReset" class="btn btn-warning form-btn btn-sm">Reset</button>
                            </div>

                        </div>
                    </div>

                </form>
                <hr>
                <!-- Solid tabs -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card card-body">
                            <h6 class="fw-semibold"></h6>

                            <ul class="nav nav-tabs nav-tabs-solid nav-justified mb-3" id="tabs">
                                <li class="nav-item">
                                    <a href="#tb1" class="nav-link active" aria-selected="true">Tab1</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#tb2" class="nav-link" aria-selected="false">Tab2</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#tb3" class="nav-link" aria-selected="false">Tab3</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tb1">
                                    <div class="row">
                                        <h1>Tab1</h1>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tb2">
                                    <h1>Tab2</h1>
                                </div>
                                <div class="tab-pane fade" id="tb3">
                                    <h1>Tab3</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /solid tabs -->
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
<script src="{{URL::asset('assets/js/vendor/forms/validation/validate.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/forms/selects/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/ui/moment/moment.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/pickers/daterangepicker.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/pickers/datepicker.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/uploaders/dropzone.min.js')}}"></script>

@endsection
@section('scripts')
<script src="{{URL::asset('assets/demo/pages/form_validation_library.js')}}"></script>
<script src="{{URL::asset('assets/js/form.js')}}"></script>
@endsection