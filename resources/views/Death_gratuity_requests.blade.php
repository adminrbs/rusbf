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

        <div class="card">
            <div class="card-body">
                <form class="needs-validation" id="memberform" novalidate>

                    <input type="hidden" class="form-control" id="id" name="hidden_id" />
                    <div>
                        <div class="row">
                            <div class="col-3">

                                <label class="col-form-label">Name In Full</label>

                                <select id="cmbnameinfull" class="form-select select2">

                                </select>
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Membership No</label>
                                <select id="txtmembreshipno" class="form-select select2">

                                </select>
                               
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Official Id</label>
                                <select id="cmbofficialid" class="form-select select2">

                                </select>
                               
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Date of Membership</label>
                                <select id="cmbdateofmembership" class="form-select select2">

                                </select>
                               
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Position</label>
                                <select id="txtPosition" class="form-select select2">

                                </select>
                                <!--<input type="text" class="form-control " id="txtPosition" name="memberage"  />-->
                               
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Department/Section</label>
                                <select id="txtdepartmentsection" class="form-select select2">

                                </select>
                               <!-- <input type="text" class="form-control " id="txtdepartmentsection" name="departmentsection"  />-->
                              
                            </div>
                            <div class="col-6">

                                <label class="col-form-label">Address In Full</label>
                                <input type="text" class="form-control " id="txtaddressinfull" name="addressinfull"  disabled/>
                              
                            </div>

                        </div>
                        <div class="row">

                            <div class="col-12">

                                <label class="col-form-label">Full name of the deceased person</label>
                                <input type="text" class="form-control " id="txtfullnameofthedeceasedperson" name="fullnameofthedeceasedperson" />
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-3">

                                <label class="col-form-label">Date and Place of death</label>
                                <input type="text" class="form-control " id="txtdateandplaseofdeath" name="dateandplaseofdeath"  />
                            </div>

                            <div class="col-3">

                                <label class="col-form-label">Relationship to the deceased person</label>
                                <input type="text" class="form-control " id="txtrelationshiptothedeceased" name="relationshiptothedeceased"
                                     />
                            </div>

                            <div class="col-3">

                                <label class="col-form-label">Age if the deceased was a child</label>
                                <input type="text" class="form-control " id="txtageifthedeceasedchildmember" name="ageifthedeceasedchildmember"/>
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Gender of deceased person</label>
                                <select id="txtGenderdeceasedperson" class="form-select select2">
                                    <option value="1">Male</option>
                                    <option value="2">Female</option>
                                    <option value="3">Other</option>
                                </select>
                                <!--<input type="text" class="form-control " id="txtGenderdeceasedperson" name="Genderdeceasedperson"
                                 />-->
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-3">

                                <label class="col-form-label">Death certificate No</label>
                                <input type="text" class="form-control " id="txtDeathcertificateNo" name="DeathcertificateNo"
                                     />
                            </div>

                            <div class="col-3">

                                <label class="col-form-label">Issued Date</label>
                                <input type="date" class="form-control " id="txtIssueddate" name="Issueddateplace" />
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Issued Place</label>
                                <input type="text" class="form-control " id="txtissuedplace" name="issuedplace" />
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Birth certificate No</label>
                                <input type="text" class="form-control " id="txtbirthcertificateno"
                                    name="membersponsebirthcertificateno" />
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Marriage certificate No</label>
                                <input type="text" class="form-control " id="txtmarriagecertificateeno"
                                    name="marriagecertificateeno" />
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">GS Date</label>
                                <input type="date" class="form-control " id="txtgsdate"
                                    name="gsdate" />
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Date of receipt OIC certificate</label>
                                <input type="date" class="form-control " id="txtreceiptofofficechargecertificate"
                                    name="receiptofofficechargecertificate" />
                            </div>
                            <div class="col-3">

                                <label class="col-form-label">Other details</label>
                                <input type="text" class="form-control " id="txtoutherdetails"
                                    name="outherdetails" />
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
<script src="{{URL::asset('assets/js/death_gratuity_requests.js')}}?random=<?php echo uniqid(); ?>"></script>

@endsection