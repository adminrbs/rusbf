@section('content')
@extends('layouts.master')
@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.page-header')
@slot('title') Home @endslot
@slot('subtitle') Member Details @endslot
@endcomponent
<!-- Content area -->
<div class="content">

<!-- Dashboard content -->
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h5 class="mb-0">Member Details</h5>
        <div class="d-inline-flex ms-auto"></div>
    </div>

    <form method="POST" id="member_reg_frm">
        <div class="card-body border-top">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <input type="hidden" class="form-control" name="hiddenid" id="hiddenmemberid">
                    <div>
                        <label class="col-form-label mb-0">Member No<span class="text-danger">*</span></label>
                        <input type="text" name="member_number" id="member_number" placeholder="Member No" class="form-control form-control-sm" required autocomplete="off">
                    </div>
                    
                    <div>
                        <label class="col-form-label mb-0">Native Language<span class="text-danger">*</span></label>
                        <select name="language_id" id="language_id" class="form-select form-control-sm custom-background" data-minimum-results-for-search="Infinity" required>
                            <option value="">-- Select--</option>
                            <option value="1">English</option>
                            <option value="2">Sinhala</option>
                            <option value="3">Tamil</option>
                        </select>
                    </div>
                    <div>
                        <label class="col-form-label mb-0">Email Address</label>
                        <input type="email" name="member_email" id="member_email" placeholder="Member's Email Address" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div>
                        <label class="col-form-label mb-0">NIC No<span class="text-danger">*</span></label>
                        <input type="text" name="national_id_number" id="national_id_number" placeholder="NIC No" class="form-control form-control-sm" required>
                    </div>
                    <div>
                        <label class="col-form-label mb-0">Date of Birth<span class="text-danger">*</span></label>
                        <input type="date" name="date_of_birth" id="date_of_birth" class="form-control form-control-sm" required>
                    </div>
                    <div>
                        <label class="col-form-label mb-0">WhatsApp Number</label>
                        <input type="text" name="member_whatsapp" id="member_whatsapp" placeholder="Member's WhatsApp Number" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1"></div>
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <!-- Single file upload -->
                    <div>
                        <label class="col-form-label mb-0">Image(Max size: 2MB) <span class="text-danger">*</span></label>
                        <div action="#" class="dropzone custom-dropzone" id="dropzone_single" required></div>
                    </div>
                    <!-- /Single file upload -->
                </div>
                
            </div>
            <div class="row">
                <div>
                    <label class="col-form-label mb-0">Full Name<span class="text-danger">*</span></label>
                    <input type="text" name="full_name" id="full_name" placeholder="Full Name" class="form-control form-control-sm" required autocomplete="off">
                </div>
                <div>
                    <label class="col-form-label mb-0">Name with Initials<span class="text-danger">*</span></label>
                    <input type="text" name="name_initials" id="name_initials" placeholder="Name with Initials" class="form-control form-control-sm" required autocomplete="off">
                </div>
                <div>
                    <label class="col-form-label mb-0">Full Name (<a href="https://www.eslims.gov.lk/eLand/lib/keyboard/t1.html" target="_blank">Sinhala</a>/<a href="https://www.eslims.gov.lk/eLand/lib/keyboard/t1.html" target="_blank">Tamil</a>)<span class="text-danger">*</span></label>
                    <input type="text" name="full_name_unicode" id="full_name_unicode" placeholder="Full Name" class="form-control form-control-sm" required autocomplete="off">
                </div>
                <div>
                    <label class="col-form-label mb-0">Name with Initials(<a href="https://www.eslims.gov.lk/eLand/lib/keyboard/t1.html" target="_blank">Sinhala</a>/<a href="https://www.eslims.gov.lk/eLand/lib/keyboard/t1.html" target="_blank">Tamil</a>)<span class="text-danger">*</span></label>
                    <input type="text" name="name_initials_unicode" id="name_initials_unicode" placeholder="Name with Initials" class="form-control form-control-sm" required autocomplete="off">
                </div>
                <div>
                    <label class="col-form-label mb-0">Personal Address<span class="text-danger">*</span></label>
                    <input type="text" name="personal_address" id="personal_address" placeholder="Personal Address" class="form-control form-control-sm" required autocomplete="off">
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-3">
                    <div>
                        <label class="col-form-label mb-0">Joined Date(Department)<span class="text-danger">*</span></label>
                        <input type="date" name="date_of_joining" id="date_of_joining" class="form-control form-control-sm" required>
                    </div>
                    <div>
                        <label class="col-form-label mb-0">Cabinet No<span class="text-danger">*</span></label>
                        <input type="text" name="cabinet_number" id="cabinet_number" placeholder="Cabinet No" class="form-control form-control-sm" required autocomplete="off">
                    </div>
                    <div>
                        <label class="col-form-label mb-0">Place of Work<span class="text-danger">*</span></label>
                        <select name="work_location_id" id="work_location_id" class="form-select form-control-sm custom-background" required>
                            <option value="">-- Select--</option>
                            <option value="1">work 1</option>
                            <option value="2">work 2</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div>
                        <label class="col-form-label mb-0">Phone Number(Home) <span class="text-danger">*</span></label>
                        <input type="number" name="home_phone_number" id="home_phone_number" placeholder="Phone Number" class="form-control form-control-sm" required>
                    </div>
                    <div>
                        <label class="col-form-label mb-0">Official No<span class="text-danger">*</span></label>
                        <input type="text" name="official_number" id="official_number" placeholder="Official No" class="form-control form-control-sm" required autocomplete="off">
                    </div>
                    <div>
                        <label class="col-form-label mb-0">Payroll No<span class="text-danger">*</span></label>
                        <input type="text" name="payroll_number" id="payroll_number" placeholder="Payroll No" class="form-control form-control-sm" required autocomplete="off">
                    </div>
                </div>
                <div class="col-lg-3">
                    <div>
                        <label class="col-form-label mb-0">Phone Number(Mobile) <span class="text-danger">*</span></label>
                        <input type="number" name="mobile_phone_number" id="mobile_phone_number" placeholder="Phone Number" class="form-control form-control-sm" required>
                    </div>
                    <div>
                        <label class="col-form-label mb-0">Designation<span class="text-danger">*</span></label>
                        <select name="designation_id" id="designation_id" class="form-control select2 form-control-sm"" required>
                            <option value="">-- Select--</option>
                            @if(!empty($get_designation_data))
                                @foreach ($get_designation_data as $val)
                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div>
                        <label class="col-form-label mb-0">Place of Payroll<span class="text-danger">*</span></label>
                        <select name="payroll_preparation_location_id" id="payroll_preparation_location_id" class="form-select form-control-sm custom-background" required>
                            <option value="">-- Select--</option>
                            <option value="1">payroll 1</option>
                            <option value="2">payroll 2</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div>
                        <label class="col-form-label mb-0">Serving Sub-department<span class="text-danger">*</span></label>
                        <select data-placeholder="Select Serving Sub-department" class="form-select form-control-sm custom-background" name="serving_sub_department_id" id="serving_sub_department_id" required>
                            <option value="">-- Select--</option>
                            <option value="1">department 1</option>
                            <option value="2">department 2</option>
                        </select>
                    </div>
                    <div>
                        <label class="col-form-label mb-0">Computer No<span class="text-danger">*</span></label>
                        <input type="text" name="computer_number" id="computer_number" placeholder="Computer No" class="form-control form-control-sm" required autocomplete="off">
                    </div>
                    <div>
                        <label class="col-form-label mb-0">Expected Amount(monthly)<span class="text-danger">*</span></label>
                        <input type="number" name="monthly_payment_amount" placeholder="Expected Amount(monthly)" id="monthly_payment_amount" class="form-control form-control-sm" required>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="d-flex align-items-center">
                    <h6 class="mb-0">Beneficiary Info</h6>
                    <div class="d-inline-flex ms-auto"></div>
                </div>
                <div>
                    <label class="col-form-label mb-0">Full Name<span class="text-danger">*</span></label>
                    <input type="text" name="beneficiary_full_name" id="beneficiary_full_name" placeholder="Beneficiary Full Name" class="form-control form-control-sm" required>
                </div>
                <div>
                    <label class="col-form-label mb-0">Relationship<span class="text-danger">*</span></label>
                    <input type="text" name="beneficiary_relationship" id="beneficiary_relationship" placeholder="Beneficiary Relationship" class="form-control form-control-sm" required autocomplete="off">
                </div>
                <div>
                    <label class="col-form-label mb-0">Private Address<span class="text-danger">*</span></label>
                    <input type="text" name="beneficiary_private_address" id="beneficiary_private_address" placeholder="Beneficiary Private Address" class="form-control form-control-sm" required autocomplete="off">
                </div>
                <div class="col-md-6">
                    <div>
                        <label class="col-form-label mb-0">Email Address</label>
                        <input type="email" name="beneficiary_email" id="beneficiary_email" placeholder="Beneficiary Email" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <label class="col-form-label mb-0">NIC No</label>
                        <input type="text" name="beneficiary_nic" id="beneficiary_nic" placeholder="Beneficiary NIC" class="form-control form-control-sm">
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-4">
                    <button type="submit" id="btnsave" class="btn btn-success form-btn" style="width: 6rem;">Save</button>
                    <button type="button" id="btnReset" class="btn btn-warning form-btn" style="width: 6rem;">Reset</button>
                </div>
            </div>
        </div>
    </form> 
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
<script src="{{URL::asset('assets/js/vendor/uploaders/fileinput/fileinput.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/uploaders/fileinput/plugins/sortable.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/notifications/noty.min.js')}}"></script>

@endsection
@section('scripts')
<script src="{{URL::asset('assets/demo/pages/form_validation_library.js')}}"></script>
<script src="{{URL::asset('assets/demo/pages/extra_noty.js')}}"></script>

<script src="{{URL::asset('assets/js/memberDetails.js')}}"></script>
<script src="{{URL::asset('assets/js/dateOfBirth.js')}}"></script>
@endsection