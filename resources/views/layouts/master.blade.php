<!DOCTYPE html>
<html lang="en" dir="ltr" data-color-theme="light">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="assets/css/master.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EasywinBiz LMS</title>
    <link rel="icon" type="image/x-icon" href="{{URL::asset('assets/images/favicon.svg')}}">
    <link rel="stylesheet" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/master_styles.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.js" integrity="sha512-rn5JpU98RtYVMtZeQJfzmJ67rl4/dqDpGZ393z5f9WMYHXEU4+8Stm/PQAma2gbsLbpClmUHJzT0DaG32OmEyQ==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="{{URL::asset('assets/js/pdf/Page.js')}}"></script>
    <script src="{{URL::asset('assets/js/pdf/PDFViewer.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{URL::asset('assets/js/toast.min.js')}}?random=<?php echo uniqid(); ?>"></script>
    <link rel="stylesheet" href="../assets/font-awesome-4.7.0/css/font-awesome.min.css">
    <!-- Theme JS files -->
    <script src="{{ URL::asset('assets/js/vendor/notifications/noty.min.js') }}"></script>
    <!-- notification -->
    <script src="{{ URL::asset('assets/demo/pages/extra_noty.js') }}"></script>

    <script src="{{ URL::asset('assets/js/navbar.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tooltip.js') }}"></script>
    @include('layouts.head-css')

    <style>
        .right-align {
            text-align: right;
        }

        .nav-tabs .nav-link {
            background-color: #f1f1f1;
            border: none;
            color: #000;
            cursor: pointer;
        }


        /* Style for the active tab button */
        .nav-tabs .nav-link.active {
            background-color: #0080ff;
            /* Change this to your desired active background color */
            color: #fff;
            /* Set text color for the active tab */
        }

        /* Optional: Set styles for the tab content */
        .tab-content {
            padding: 10px;
            border: 1px solid #ddd;
        }

        #tab_page_demo {
            margin: 4px, 4px;
            padding: 4px;
            height: 400px;
            overflow-x: hidden;
            overflow-y: auto;
            text-align: justify;
        }
    </style>



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