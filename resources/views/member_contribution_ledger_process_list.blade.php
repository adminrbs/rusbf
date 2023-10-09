@section('content')
@extends('layouts.master')
@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection

@section('content')
@component('components.page-header')
@slot('title') Home @endslot
@slot('subtitle')Member Contribution Ledger List @endslot
@endcomponent
<!-- Content area -->
<div class="content">
    <style>
        .right-align {
            text-align: right;
        }
    </style>
    <!-- Dashboard content -->
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Member Contribution Ledger List</h5>
            <div class="d-inline-flex ms-auto"></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label>Number</label>
                                <select class="form-control select2" id="cmb_number">
                                    <option value="any">Any</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Name</label>
                                <select class="form-control select2" id="cmb_name">
                                    <option value="any">Any</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Year</label>
                                <select class="form-control" id="cmb_year">
                                    <option value="any">Any</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Month</label>
                                <select class="form-control" id="cmb_month">
                                    <option value="any">Any</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="tbl_memeber_contribution" class="table table-striped datatable-fixed-both-member-contribution" role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr>
                                        <th>Number</th>
                                        <th>Name</th>
                                        <th> Year</th>
                                        <th>Month</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
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

<!-- dataTables -->
<script src="{{URL::asset('assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{URL::asset('assets/demo/pages/datatables_basic.js')}}"></script>

<script src="{{URL::asset('assets/js/vendor/forms/selects/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/js/member_contribution_ledger_process_list.js')}}"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection