@section('content')
@extends('layouts.master')
@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.page-header')
@slot('title') Home @endslot
@slot('subtitle') Master Data @endslot
@endcomponent
<!-- Content area -->
<div class="content">

<!-- Dashboard content -->
<div class="card">
    <div class="card-header d-flex align-items-center">
        <h5 class="mb-0">Designation Setup</h5>
        <div class="d-inline-flex ms-auto"></div>
    </div>

    <div class="card-body border-top">
        <div class="row mb-3">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary" onclick="add_designation();" style="float:right;"><i class="ph-plus"></i>&nbsp;Add New</button>
            </div>   
        </div>
        

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tbl_create_designation" class="table table-striped "
                                role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr>
                                        <th class="thname">Name</th>
                                        <th class="thactions"> Actions</th>
                                        <th class="thstatus">Status</th>
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
<div class="modal fade" id="add_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="register_form" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" class="form-control" id="hidden_id" name="hidden_id"/>
                    <div class="mb-3">
                        <label class="col-form-label">Designation Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="designation_name" name="designation_name" required/>
                        <div id="name_error" class="error" style="color: red"></div>
                    </div>
                    
                    <div>
                        <button type="button" class="btn btn-success" id="btnsave" style="float: right;">Save</button>
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


<script src="{{URL::asset('assets/js/masterDesignation.js')}}"></script>
@endsection