@section('content')
@extends('layouts.master')
@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.page-header')
@slot('title') Home @endslot
@slot('subtitle')Loan Management @endslot
@endcomponent
<!-- Content area -->
<div class="content">

    <!-- Dashboard content -->
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Contribution</h5>
            <div class="d-inline-flex ms-auto"></div>
        </div>

        <div class="card-body border-top">
            <div class="row mb-3">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button id="btncontribution" type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalcontribution">
                        <i class="ph-plus"></i>&nbsp;Add New
                    </button>

                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="tbl_create_contribution" class="table table-striped " role="grid"
                                    aria-describedby="example1_info">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Code</th>
                                            <th>Name of contribution</th>
                                            <th>Amount</th>
                                            <th>Contribute on Every</th>
                                            <th>Gl Account No</th>
                                            <th>status</th>
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
    <!--Designation Modal -->
    <div class="modal fade" id="modalcontribution" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Contribution</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>

                        <input type="hidden" class="form-control" id="id" name="hidden_id" />
                        <div class="mb-3">
                            <label class="col-form-label">Code</label>
                            <input type="text" class="form-control" id="code" name="designation_name" />

                            <label class="col-form-label">Name of contribution<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="txtNamecontribution" name="Namecontribution"
                                required />

                            <label class="col-form-label">Description</label>
                            <input type="text" class="form-control" id="txtDescription" name="Description" />

                            <label class="col-form-label">Contribute on every</label>
                            <select type="text" class="form-select" id="txtContribute" name="Description">

                                <option value="0">Monthly</option>
                                <option value="1">Annualy</option>
                            </select>

                            <label class="col-form-label">G/L Account</label>
                            <input type="text" class="form-control" id="txtglaccount" name="glaccount" />
                        </div>

                        <div>
                            <button type="button" class="btn btn-success" id="btnsave"
                                style="float: right;">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Designation Modal -->

</div>
<!-- /content area -->

@endsection

@section('center-scripts')
<!-- Javascript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{URL::asset('assets/js/toast.min.js')}}?random=<?php echo uniqid(); ?>"></script>

<script src="{{ URL::asset('assets/js/web-rd-fromValidation.js') }}"></script>

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
<script src="{{URL::asset('assets/js/contribution.js')}}?random=<?php echo uniqid(); ?>"></script>

@endsection