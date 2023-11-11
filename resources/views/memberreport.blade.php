@section('content')
@extends('layouts.master')
@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.page-header')
@slot('title') Home @endslot
@slot('subtitle') Report @endslot
@endcomponent
<style>
    tr.highlighted {
        background-color: #E2F7FB !important;
        font-weight: bold;
    }

    input[type="radio"] {
        width: 18px;
        height: 18px;
    }

    /* Style the label for the radio buttons (optional) */
    label {
        margin-right: 10px;

        /* Add some spacing between the label and the radio button */
    }

    ul.list-group li {
        border: none;
    }
</style>
<!-- Content area -->
<div class="content">

    <!-- Dashboard content -->
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Report</h5>
            <div class="d-inline-flex ms-auto"></div>
        </div>
       
            <div class="mt-2">
                <button class="btn btn-link mb-2" id="btn-collapse-search"  onclick="dataclear()">
                    <i class="bi bi-gear" style="margin-right: 5px"></i>Report
                </button>
            </div>
       
        <div class="card-body border-top">
            <div class="row" id="row1">

                <div class="col-4 mt-2" style="margin-left: 2rem;" >
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Reports</h5>
                            <ul class="list-group">
                               
                                <li class="list-group-item">
                                    <label style="display: flex; align-items: center;">
                                        <input class="form-check-input" type="radio" name="option1"
                                            value="Customer's Ledger" id="adviceofdeducation" style="margin-right: 10px;">
                                        <i class="bi bi-folder2 fa-lg"></i>&nbsp;
                                       Advice of deduction
                                    </label>
                                </li>

                                <br>
                               
                                
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-sm-6 mt-2 ml-2" style="margin-left: 2rem;">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Filters</h5>
                            <div class="row">
                                <div class="row">
                                  <!--  <div class="col-md-5">
                                        <label style="font-weight: bold;">From</label>
                                        <input id="txtFromDate" type="date" class="form-control daterange-single">
                                    </div>
    
                                    <div class="col-md-4">
                                        <label class="tx-bold" style="font-weight: bold;">To</label>
                                        <input id="txtToDate" type="date" class="form-control daterange-single">
                                    </div>
    
                                    <div class="col-md-1">
    
                                        <input id="chkdate" type="checkbox" style="margin-top: 30px;">
                                    </div>
                                -->
                                <div class="col-md-9 mb-3 mt-1">
                                    <label style="font-weight: bold;">year</label>
                                    <select class="form-select validate select2" id="year">
                                        <!-- JavaScript will populate options here -->
                                    </select>
                                </div>

                                <div class="col-md-1 mt-2">

                                    <input id="chkyear" type="checkbox" style="margin-top: 30px;">
                                </div>


                                <div class="col-md-9 mb-3 mt-1">
                                    <label style="font-weight: bold;">Month</label>
                                    <select class="form-select validate select2" id="month">
                                        <!-- JavaScript will populate options here -->
                                    </select>
                                </div>

                                <div class="col-md-1 mt-2">

                                    <input id="chkMonth" type="checkbox" style="margin-top: 30px;">
                                </div>


                                    <div class="col-md-9 mb-3 mt-2">
                                        <label style="font-weight: bold;">Serving Sub Department</label>
                                    <select class="form-control validate select2" id="cmbsavingDepartment"></select>
                                    </div>

                                    <div class="col-md-1 mt-2">

                                        <input id="chksavingDepartment" type="checkbox" style="margin-top: 30px;">
                                    </div>

                                    <div class="col-md-9 mb-3 mt-1">
                                        <label style="font-weight: bold;">Designation</label>
                                        <select class="form-control validate select2" id="cmbDesignation"></select>
                                    </div>

                                    <div class="col-md-1 mt-2">

                                        <input id="chkdesignation" type="checkbox" style="margin-top: 30px;">
                                    </div>

                                    <div class="col-md-9 mb-3 ">
                                        <label style="font-weight: bold;"> computer Number</label>
                                        <select class="form-control validate select2" id="cmbcomputernumber"></select>
                                    </div>

                                    <div class="col-md-1 mt-1">

                                        <input id="chkcomputernumber" type="checkbox" style="margin-top: 30px;">
                                    </div>
                                    <div class="col-md-9 mb-3 ">
                                        <label style="font-weight: bold;"> Work Location</label>
                                        <select class="form-control validate select2" id="cmbworklocation"></select>
                                    </div>

                                    <div class="col-md-1">
    
                                        <input id="cbxworklocation" type="checkbox" style="margin-top: 30px;">
                                    </div>



                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-9 mb-3" style="text-align: right;margin-right: 100px;">
                            <button id="viewReport" data-bs-toggle="collapse" href="#moh_division" role="button"
                                aria-expanded="false" aria-controls="collapseExample"
                                class="btn btn-primary">Preview</button>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <iframe id="pdfContainer" src="" style="min-width: 100%; min-height: 1750px;"></iframe>
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
<script src="{{URL::asset('assets/js/vendor/forms/selects/select2.min.js')}}"></script>
<!-- dataTables -->
<script src="{{URL::asset('assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{URL::asset('assets/demo/pages/datatables_basic.js')}}"></script>


<script src="{{URL::asset('assets/js/members_report.js')}}?random=<?php echo uniqid(); ?>"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection