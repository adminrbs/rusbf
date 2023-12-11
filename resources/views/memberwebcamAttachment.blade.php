@section('content')
@extends('layouts.master')
@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.page-header')
@slot('title') Home @endslot
@slot('subtitle') Member Attachment @endslot
@endcomponent
<!-- Content area -->
<div class="content">

    <!-- Dashboard content -->
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Member Attachment</h5>
            <div class="d-inline-flex ms-auto"></div>
        </div>

        <form method="POST" id="Attachment">
            <div class="card-body border-top">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="col-md-12">
                            <select class="form-control select2" name="selectMember" id="selectMember">
                                <!-- Your options go here -->
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 mb-4">
                       
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <div class="row">
                            <div class="col-md-12">
                                <video autoplay="true" id="videoElement" class="img img-thumbnail" poster="/images/webcam.jpg" style="min-height: 250px; max-height: 250px; min-width: 100%;"></video>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary" id="btnTakePhoto" name="btnTakePhoto" style="min-width: 100%;" onclick="openWebCam()">Open Webcam</button>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-3 mb-3">
                        <div class="row">
                            <div class="col-md-12">
                                <div action="#" class="dropzone" id="dropzone_single" style="min-height: 250px; max-height: 250px;"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-1">
                                <button type="button" class="btn btn-success" id="saveAttachment" name="saveAttachment" style="min-width: 100%;" disabled>Save  Attachment</button>
                            </div>
                        </div>
                    </div>
{{-- 
                    <div class="col-md-9 d-flex justify-content-end">
                        <button class="btn btn-primary">Save</button>
                    </div> --}}
                  
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
<script src="{{URL::asset('assets/js/vendor/forms/selects/select2.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/uploaders/dropzone.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/notifications/noty.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/notifications/bootbox.min.js')}}"></script>

@endsection
@section('scripts')
<script src="{{URL::asset('assets/demo/pages/extra_noty.js')}}"></script>

<script src="{{URL::asset('assets/js/memberwebcamAttachment.js')}}"></script>
@endsection