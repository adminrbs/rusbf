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
            <h5 class="mb-0">Member Contribution</h5>
            <div class="d-inline-flex ms-auto"></div>
        </div>

       
            <div class="card-body border-top">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-4">
                        <input type="hidden" class="form-control" name="hiddenid" id="hiddenmemberid">
                        <div class="col-md-6">
                            <label class=" col-form-label mb-0">Member's Number</label>
                            <select class="form-control validate select2" id="cmbmember"></select>
                        </div>
                        <div>
                            <label class="col-form-label mb-0">Full Name</label>
                            <select class="form-control validate select2" id="cmbName"></select>
                        </div>

                        
                    </div>
                  
                    <div class="col-lg-1 col-md-1 col-sm-1"></div>
                    <div class="col-lg-4 col-md-3 col-sm-3">
                        <!-- Single file upload 
                        <div>
                            <label class="col-form-label mb-0"></label>
                            <img id="loadedImage" src="" alt="Loaded Image" style="max-width: 100%; max-height: 100%; display: block;">
                        </div>-->

                        <div class="mb-4" style="width: 200px; height: 200px;">
                            <label class="col-form-label mb-0"></label>
                            <img id="loadedImage" src="" alt="Loaded Image" style="max-width: 100%; max-height: 100%; display: block; border-radius: 20%;">
                        </div>
                        
                        <!-- /Single file upload -->
                    </div>

                </div>
                

            </div>

    </div>
   
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

<script src="{{URL::asset('assets/js/member_contribution.js')}}"></script>

@endsection