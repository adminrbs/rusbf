@section('content')
@extends('layouts.master')
@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.page-header')
@slot('title') Home @endslot
@slot('subtitle') Settings @endslot
@endcomponent
<!-- Content area -->
<div class="content">

<!-- Dashboard content -->
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h5 class="mb-0">Member Portal</h5>
        <div class="d-inline-flex ms-auto"></div>
    </div>

    <div class="card-body border-top">
        <div class="row mb-3">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary" onclick="add_user();" style="float:right;"><i class="ph-plus"></i>&nbsp;Add New</button>
            </div>   
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tbl_memberportal" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>User Name</th>
                                        <th>Status</th>
                                        <th> Actions</th>
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
</div>
<!-- /dashboard content -->
<!--User Create Modal -->
<div class="modal fade" id="add_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"> {{-- style="max-height: 80vh; overflow-y: auto;" --}}
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="user_form">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-sm-1"></div>
                            <div class="col-lg-10 col-md-10 col-sm-10">
                                <div>
                                    <label for="member"><i class="fa fa-address-card-o fa-lg text-info" aria-hidden="true">&#160</i>Member Name<span
                                        class="text-danger">*</span></label>
                                       
                                <select id="cmbmemberprtal" class="form-control select2"> </select>
                                <span class="text-danger font-weight-bold "></span>
                                </div>
                                <div>
                                    <label class="col-form-label mb-0">User Name/Phone Numbers<span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="txtusername" placeholder="User Name or Phone Numbers" class="form-control form-control-sm"  autocomplete="off">
                                </div>

                                <div>
                                    <label for="txtPassword"><i class="fa fa-address-card-o fa-lg text-info" aria-hidden="true">&#160</i>Password<span
                                        class="text-danger">*</span></label>
                                <input type="password" id="txtPassword" class="form-control validate"
                                    required autocomplete="off">
                                <span class="text-danger font-weight-bold "></span>
                                </div>
                               
                                <div>
                                    <label for="txtConfirmPassword"><i class="fa fa-address-card-o fa-lg text-info" aria-hidden="true">&#160</i>Confirm Password<span
                                        class="text-danger">*</span></label>
                                <input type="password" id="txtConfirmPassword" class="form-control validate"
                                    required autocomplete="off">
                                <span class="text-danger font-weight-bold "></span>
                                </div>
                               
                                &nbsp;
                                <input type="hidden" class="form-control" name="hiddenuserid" id="hiddenuserid">
                                <div>
                                    <button type="button" id="btnsave" class="btn btn-success form-btn" style="width: 6rem; float: right">Save</button>
                                </div>

                              
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--User Create Modal -->



</div>
<!-- /content area -->

@endsection
@section('center-scripts')
<!-- Javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="{{URL::asset('assets/js/vendor/forms/selects/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/ui/moment/moment.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/notifications/noty.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/vendor/notifications/bootbox.min.js') }}"></script>

@endsection
@section('scripts')

<script src="{{URL::asset('assets/demo/pages/extra_noty.js')}}"></script>

<!-- dataTables -->

<script src="{{URL::asset('assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{URL::asset('assets/demo/pages/datatables_basic.js')}}"></script>

<script src="{{URL::asset('assets/js/memberportal.js')}}"></script>
@endsection