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
        <h5 class="mb-0">Create User</h5>
        <div class="d-inline-flex ms-auto"></div>
    </div>

    <form method="POST" id="user_form">
        <div class="card-body border-top">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3"></div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <input type="hidden" class="form-control" name="hiddenid" id="hiddenuserid">
                    <div>
                        <label class="col-form-label mb-0">Username<span class="text-danger">*</span></label>
                        <input type="text" name="username" id="username" placeholder="Username" class="form-control form-control-sm" required>
                    </div>
                    <div>
                        <label class="col-form-label mb-0">Email Address<span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" placeholder="Email Address" class="form-control form-control-sm" required>
                    </div>
                    <div>
                        <label class="col-form-label mb-0">Password<span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" placeholder="Password" class="form-control form-control-sm" required autocomplete="off">
                    </div>
                    <div>
                        <label class="col-form-label mb-0">Confirm Password<span class="text-danger">*</span></label>
                        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password" class="form-control form-control-sm" required autocomplete="off">
                    </div>
                    <div>
                        <label class="col-form-label mb-0">User Role<span class="text-danger">*</span></label>
                        <select name="userrole" id="userrole" class="form-control select2 form-control-sm" required>
                            <option value="">-- Select--</option>
                            @if(!empty($role_data))
                                @foreach ($role_data as $val)
                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div>
                        <label class="col-form-label mb-0">User Type<span class="text-danger">*</span></label>
                        <select name="usertype" id="usertype" class="form-select form-control-sm custom-background" required>
                            <option value="">-- Select--</option>
                            <option value="0">Guest</option>
                            <option value="1">Employee</option>
                        </select>
                    </div>
                    &nbsp;
                    <div>
                        <button type="submit" id="btnsave" class="btn btn-success form-btn" style="width: 6rem; float: right">Save</button>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3"></div>
            </div>
        </div>
    </form>
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
<script src="{{URL::asset('assets/js/vendor/forms/selects/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/ui/moment/moment.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/notifications/noty.min.js')}}"></script>

@endsection
@section('scripts')
<script src="{{URL::asset('assets/demo/pages/form_validation_library.js')}}"></script>
<script src="{{URL::asset('assets/demo/pages/extra_noty.js')}}"></script>

<!-- dataTables -->
<script src="{{URL::asset('assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{URL::asset('assets/demo/pages/datatables_basic.js')}}"></script>

<script src="{{URL::asset('assets/js/users.js')}}"></script>
@endsection