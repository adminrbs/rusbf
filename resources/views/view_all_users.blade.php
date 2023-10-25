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
        <h5 class="mb-0">Users</h5>
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
                            <table id="tbl_users" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="thid">#</th>
                                        <th class="thusername">Username</th>
                                        <th class="themail">Email </th>
                                        <th class="throle"> User Role</th>
                                        <th class="thtype">User Type</th>
                                        <th class="thactions"> Actions</th>
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
                <form method="POST" id="user_form">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-1 col-md-1 col-sm-1"></div>
                            <div class="col-lg-10 col-md-10 col-sm-10">
                                <div>
                                    <label class="col-form-label mb-0">Username<span class="text-danger">*</span></label>
                                    <input type="text" name="username" id="username" placeholder="Username" class="form-control form-control-sm" autofocus required>
                                </div>
                                <div>
                                    <label class="col-form-label mb-0">Email Address<span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" placeholder="Email Address" class="form-control form-control-sm" required>
                                </div>
                                <div>
                                    <label class="col-form-label mb-0">Password<span class="text-danger">*</span></label>
                                    <input type="password" name="password" id="password" placeholder="Password" class="form-control form-control-sm"  autocomplete="off">
                                </div>
                                <div>
                                    <label class="col-form-label mb-0">Confirm Password<span class="text-danger">*</span></label>
                                    <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" class="form-control form-control-sm"  autocomplete="off">
                                </div>
                                <div>
                                    <label class="col-form-label mb-0">User Role<span class="text-danger">*</span></label>
                                    <select name="userrole" id="userrole" class="form-control select2 form-control-sm" required>
                                        <option value="">-- Select--</option>
                                        
                                    </select>
                                </div>
                                <div>
                                    <label class="col-form-label mb-0">User Type<span class="text-danger">*</span></label>
                                    <select name="usertype" id="usertype" class="form-select form-control-sm select2" required>
                                        <option value="">-- Select--</option>
                                        <option value="0">Guest</option>
                                        <option value="1">Employee</option>
                                    </select>
                                </div>
                                &nbsp;
                                <input type="hidden" class="form-control" name="hiddenuserid" id="hiddenuserid">
                                <div>
                                    <button type="submit" id="btnsave" class="btn btn-success form-btn" style="width: 6rem; float: right">Save</button>
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

<!-- Theme JS files -->
<script src="{{URL::asset('assets/js/vendor/visualization/d3/d3.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/visualization/d3/d3_tooltip.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/forms/selects/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/ui/moment/moment.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/notifications/noty.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/vendor/notifications/bootbox.min.js') }}"></script>

@endsection
@section('scripts')
<script src="{{URL::asset('assets/demo/pages/form_validation_library.js')}}"></script>
<script src="{{URL::asset('assets/demo/pages/extra_noty.js')}}"></script>

<!-- dataTables -->

<script src="{{URL::asset('assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{URL::asset('assets/demo/pages/datatables_basic.js')}}"></script>

<script src="{{URL::asset('assets/js/all_users.js')}}"></script>
@endsection