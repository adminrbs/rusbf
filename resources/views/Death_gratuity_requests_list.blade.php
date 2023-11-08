@section('content')
@extends('layouts.master')
@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.page-header')
@slot('title') Home @endslot
@slot('subtitle')Donation @endslot
@endcomponent
<!-- Content area -->
<div class="content">

    <!-- Dashboard content -->
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Death Gratuity Requests</h5>
            <div class="d-inline-flex ms-auto"></div>
        </div>

        <div class="card-body border-top">
            <div class="row mb-3">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <a href="/Death_gratuity_requests" id="btncontribution" class="btn btn-primary">
                        <i class="ph-plus"></i>&nbsp;Add New
                </a>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tbl_create_deathgratuity" class="table table-striped " role="grid"
                                    aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Membership No</th>
                                            <th>Full Name</th>
                                           
                                            <th>GS Date</th>
                                            <th>Approval Status</th>
                                           
                                            <th>Action</th>
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
<script src="{{URL::asset('assets/js/toast.min.js')}}?random=<?php echo uniqid(); ?>"></script>
<script src="{{URL::asset('assets/js/vendor/forms/selects/select2.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/web-rd-fromValidation.js') }}"></script>
<script src="{{URL::asset('assets/js/vendor/notifications/bootbox.min.js')}}"></script>

<!-- Theme JS files -->
<script src="{{URL::asset('assets/js/vendor/ui/moment/moment.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/notifications/noty.min.js')}}"></script>

@endsection
@section('scripts')
<script src="{{URL::asset('assets/demo/pages/form_validation_library.js')}}"></script>
<script src="{{URL::asset('assets/demo/pages/extra_noty.js')}}"></script>

<!-- dataTables -->
<script src="{{URL::asset('assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/tables/datatables/extensions/fixed_columns.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/notifications/bootbox.min.js')}}"></script>
<script src="{{URL::asset('assets/js/Death_gratuity_requests_list.js')}}?random=<?php echo uniqid(); ?>"></script>

@endsection