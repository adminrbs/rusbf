@section('content')
@extends('layouts.master')
@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.page-header')
@slot('title') Home @endslot
@slot('subtitle') Members @endslot
@endcomponent
<!-- Content area -->
<div class="content">

<!-- Dashboard content -->
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h5 class="mb-0">Members</h5>
        <div class="d-inline-flex ms-auto"></div>
    </div>

    <div class="card-body border-top">
        <div class="row mb-3">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <a href="/member_form"><button type="button" class="btn btn-primary form-btn" style="float:right;"><i class="ph-plus"></i>&nbsp;Add Member</button></a>
            </div>   
        </div>
        

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tbl_members" class="table table-striped "
                                role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr>
                                        <th class="thmemimg">Member Image</th>
                                        <th class="thmemno">Member No</th>
                                        <th class="thname">Name with initials </th>
                                        <th class="thnic"> NIC</th>
                                        <th class="thphone"> Phone Number</th>
                                        <th class="edit"> Edit</th>
                                        <th class="delete"> Delete</th>
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
<script src="{{URL::asset('assets/js/vendor/visualization/d3/d3.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/visualization/d3/d3_tooltip.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/forms/validation/validate.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/forms/selects/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/ui/moment/moment.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/pickers/daterangepicker.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/pickers/datepicker.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/uploaders/dropzone.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/notifications/noty.min.js')}}"></script>

@endsection
@section('scripts')
<script src="{{URL::asset('assets/demo/pages/form_validation_library.js')}}"></script>
<script src="{{URL::asset('assets/demo/pages/extra_noty.js')}}"></script>

<!-- dataTables -->
<script src="{{URL::asset('assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{URL::asset('assets/demo/pages/datatables_basic.js')}}"></script>

<script src="{{URL::asset('assets/js/allmembers.js')}}"></script>
@endsection