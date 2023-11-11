@section('content')
@extends('layouts.master')
@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('content')
@component('components.page-header')
@slot('title') Home @endslot
@slot('subtitle') Loan Management @endslot
@endcomponent
<!-- Content area -->
<div class="content">
    <style>
        .right-align {
            text-align: right;
        }

        .card-s {
            display: inline-block;
            width: 48%;

        }

        .table-container {
            display: inline-block;
            width: 100%;
        }

        .icon-button {
            border: 0px solid;

            border-radius: 0px;
        }


        .icon-button i {
            color: #000;
            border-color: #000;
        }


        .icon-button {
            border-width: 2px;
        }
    </style>
    <!-- Dashboard content -->
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Contribution And Loan </h5>
            <div class="d-inline-flex ms-auto"></div>
        </div>

        <div class="row">
            <div class="">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-11 col-md-9 col-sm-6">
                                <input type="hidden" class="form-control" name="hiddenid" id="hiddenmemberid">

                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Year</label>
                                        <select class="form-control" id="cmb_year">
                                            <option value="any">Any</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Month</label>
                                        <select class="form-control" id="cmb_month">
                                            <option value="any">Any</option>
                                        </select>
                                    </div>
                      
                                    <div class="col-md-3">
                                        <label>Computer Number</label>
                                        <select class="form-control select2" id="cmbcomputernum">

                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Member</label>
                                        <select class="form-control select2" id="cmbmember">

                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Serve Sub Department</label>
                                        <select class="form-control select2" id="cmbservsubdepartment">

                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Full Name</label>
                                        <select class="form-control select2" id="cmbmembefullname">

                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-2 mt-2">
                                        <div class="row">
                                            <div class="col-md-6" style="padding-top:10px;">
                                                <button id="btnleft" style="background-color: transparent; border: none;" title="previous">
                                                    <img src="assets/images/icons/leftarrow-png-24.png" alt="Left Arrow" style="width: 40px; height: 40px; transform: rotate(180deg);">
                                                </button> &nbsp;
                                            </div>
                                            <div class="col-md-6" style="padding-top:10px;">
                                                <button id="btnright" style="background-color: transparent; border: none;" title="next">
                                                    <img src="assets/images/icons/leftarrow-png-24.png" alt="Left Arrow" style="width: 40px; height: 40px;">
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mt-2" style="text-align: right;padding-top:10px;">
                                        <button class="btn btn-success" id="btnsave" style="width: 120px">Save</button>
                                    </div>
  
                                    <div class="col-2 mt-2">
                                        <img id="loadedImage" src="images/userimage.png" alt="Loaded Image" style="width: 50px; height: 50px; object-fit: cover; border-radius: 100%; disply:block">

                                    </div>
                                </div>

                            </div>

                            <div class="col-1">
                                <div class="mb-8" style="width: 100px; height: 100px; text-align: left;">
                                    <label class="col-form-label mb-0"></label>
                                </div>
                            </div>

                        </div>

                        <hr>


                        <!--tabs -->
                        <ul class="nav nav-tabs mb-0" id="tabs">
                            <li class="nav-item rbs-nav-item">
                                <a id="contributhion" href="#Contribution" class="nav-link active" aria-selected="true">Contribution</a>
                            </li>

                            <li class="nav-item rbs-nav-item">
                                <a href="#loantab" class="nav-link" aria-selected="false">Loan</a>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="Contribution">
                                <div class="row">

                                    <div class="row">
                                        <h1>Contribution</h1>

                                        <div class="col-md-12 mb-4">


                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Contribution</th>
                                                        <th>Amount</th>
                                                        <th>Received</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tblContribution"></tbody>
                                            </table>


                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="loantab" onload="tabalerefresh()">
                                <div class="row">

                                    <div class="row">
                                        <h1>Loan</h1>

                                        <div class="col-md-12 mb-4">

                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Loan</th>
                                                        <th>Capital</th>
                                                        <th>Received</th>
                                                        <th>Interest</th>
                                                        <th>Received</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tblLoan"></tbody>
                                            </table>


                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

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
<script src="{{URL::asset('assets/js/vendor/notifications/bootbox.min.js')}}"></script>
<script src="{{ URL::asset('assets/demo/pages/components_buttons.js') }}"></script>
<!-- dataTables -->
<script src="{{URL::asset('assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{URL::asset('assets/demo/pages/datatables_basic.js')}}"></script>

<script src="{{URL::asset('assets/js/vendor/forms/selects/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/js/contributionAndloanFilter.js')}}?random=<?php echo uniqid(); ?>"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection