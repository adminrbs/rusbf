@section('content')
@extends('layouts.master')
@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
@component('components.page-header')
@slot('title') Home @endslot
@slot('subtitle') Dashboard @endslot
@endcomponent
<!-- Content area -->
<div class="content">
    <!-- Dashboard content -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="mb-0">Title</h5>
                    <div class="d-inline-flex ms-auto">
               
                    </div>
                </div>

                <div class="card-body d-sm-flex align-items-sm-center justify-content-sm-between flex-sm-wrap">
                    
                </div>
            </div>
        </div>
    </div>
    <!-- /dashboard content -->

</div>
<!-- /content area -->

@endsection
@section('center-scripts')
<!-- Theme JS files -->
<script src="{{URL::asset('assets/js/vendor/visualization/d3/d3.min.js')}}"></script>
<script src="{{URL::asset('assets/js/vendor/visualization/d3/d3_tooltip.js')}}"></script>
@endsection
@section('scripts')

@endsection
