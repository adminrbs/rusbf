<!DOCTYPE html>
<html lang="en" dir="ltr" data-color-theme="light" >
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EasywinBiz LMS</title>
    <link rel="icon" type="image/x-icon" href="{{URL::asset('assets/images/favicon.svg')}}">
    <link rel="stylesheet" type="text/css" href="/assets/css/new_styles.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
   @include('layouts.head-css')

</head>

<body>
    <!-- navbar -->
    @include('layouts.navbar')

    <!-- Page content -->
    <div class="page-content">

        <!-- sidebar -->
        @include('layouts.sidebar')

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                @yield('content')

                @include('layouts.footer')

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

    <!-- notification -->
    @include('layouts.notification')

    <!-- right-sidebar content -->
    @include('layouts.right-sidebar')

</body>
</html>
