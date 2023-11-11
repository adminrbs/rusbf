@section('content')
@extends('layouts.master')
@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.page-header')
@slot('title') Home @endslot
@slot('subtitle')Loan @endslot
@endcomponent
<!-- Content area -->
<div class="content">

    <!-- Dashboard content -->
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Loan Request</h5>
            <div class="d-inline-flex ms-auto"></div>
        </div>

        <div class="card">
            <div class="card-body">
                <form class="needs-validation" id="memberform" novalidate>

                    <input type="hidden" class="form-control" id="id" name="hidden_id" />
                    <div>
                        <div class="row">
                            <div class="col-3">

                                <label class="col-form-label">Membership No</label>

                                <select id="txtmembershipno" class="form-select select2">

                                </select>
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Nic no</label>
                                <select id="txtnic" class="form-select select2">

                                </select>
                               
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Computer no</label>
                                <select id="txtcomputerno" class="form-select select2">

                                </select>
                               
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Membership (Age)</label>
                                <input type="text" class="form-control " id="memberage" name="memberage" disabled />
                              
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-12">

                                <label class="col-form-label">Name with initial</label>
                                <input type="text" class="form-control " id="name" name="designation_name" disabled />
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-3">

                                <label class="col-form-label">Staff no</label>
                                <input type="text" class="form-control " id="txtStaffno" name="Staffno" disabled />
                            </div>

                            <div class="col-3">

                                <label class="col-form-label">Place of employment</label>
                                <input type="text" class="form-control " id="txtplaseemployment" name="plaseemployment"
                                    disabled />
                            </div>

                            <div class="col-3">

                                <label class="col-form-label">Date of birth</label>
                                <input type="text" class="form-control " id="txtbirthday" name="birthday" disabled />
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Paysheet no</label>
                                <input type="text" class="form-control " id="txtpaysheetno" name="paysheetno"
                                    disabled />
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-3">

                                <label class="col-form-label">Designation</label>
                                <input type="text" class="form-control " id="txtDesignation" name="designation_name"
                                    disabled />
                            </div>

                            <div class="col-3">

                                <label class="col-form-label">Contact No</label>
                                <input type="number" class="form-control " id="txtcontactno" name="contactno" />
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">date of enlistment to the fund</label>
                                <input type="date" class="form-control " id="txtdateofenlistment"
                                    name="dateofenlistment" />
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Date</label>
                                <input type="date" class="form-control " id="txtdate" name="date" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">

                                <label class="col-form-label">Loan</label>

                                <select id="cbxlone" class="form-select select2">

                                </select>
                            </div>
                            <div class="col-6">

                                <label class="col-form-label">Term</label>

                                <select id="cbxloneterm" class="form-select select2">

                                </select>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">

                                <label class="col-form-label">Reason to obtain the loan</label>
                                <input type="text" class="form-control " id="txtresontoobtain" name="resontoobtain" />
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">

                                <label class="col-form-label">Private address</label>
                                <input type="text" class="form-control" id="txtprivetAddress" name="privetAddress" />
                            </div>

                        </div>

                        <div class="row">

                            <div class="col-3">

                                <label class="col-form-label">Period of service ( years )</label>
                                <input type="number" class="form-control" id="txtpriodofservice"
                                    name="priodofservice" />
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Monthly basic salary Rs.</label>
                                <input type="number" class="form-control " id="txtpresetmonthlybSalary"
                                    name="presetmonthlybSalary" />
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Manner of repayment</label>
                                <input type="number" class="form-control " id="txtManageofrepayment"
                                    name="Manageofrepayment" />
                            </div>

                        </div>
                        <div class="col-3 mt-2">
                            <button type="button" id="btnattach" class="btn btn-primary" data-toggle="modal"
                                data-target="#Attachment_modal">
                               Attachment
                            </button>

                        </div>

                        <div class="table-responsive">
                            <table id="tbl_attachment" class="table table-striped " role="grid"
                                aria-describedby="example1_info">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Description</th>
                                        <th>Attachment</th>                   
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <button type="button" id="btnsave" class="btn btn-success form-btn"
                                style="width: 6rem;">Save</button>

                            <button type="button" id="btnReject" class="btn btn-danger form-btn"
                                style="width: 6rem;">Reject</button>
                            <button type="button" id="btnApprove" class="btn btn-success form-btn"
                                style="width: 6rem;">Approve</button>

                            <button type="button" id="btnReset" class="btn btn-warning form-btn"
                                style="width: 6rem;">Reset</button>

                        </div>
                    </div>
            </div>
        </div>
        </form>

    </div>
    <!-- /dashboard content -->

<!--Attachement model-->

<div class="modal fade" id="Attachment_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                
            </div>
            <div class="modal-body">
               <form action="">
                <label class="col-form-label">Description</label>
                <textarea type="textarea" class="form-control" id="txtDescription" rows="3"></textarea>

                <label class="col-form-label">Attachment</label>
                <div action="#" class="col-12 dropzone custom-dropzone" id="dropzone_single"></div>


            </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="attachmentclose" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="attachment_save">Save</button>
            </div>
        </div>
    </div>
</div>

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
<script src="{{URL::asset('assets/js/vendor/notifications/bootbox.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/tables/datatables/datatables.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/tables/datatables/extensions/fixed_columns.min.js')}}"></script>

@endsection
@section('scripts')
<script src="{{URL::asset('assets/demo/pages/form_validation_library.js')}}"></script>
<script src="{{URL::asset('assets/demo/pages/extra_noty.js')}}"></script>
<script src="{{URL::asset('assets/js/members_loan_request.js')}}?random=<?php echo uniqid(); ?>"></script>

@endsection