
    <!-- Dashboard content -->
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="mb-0">Lone Management</h5>
            <div class="d-inline-flex ms-auto"></div>
        </div>

        <div class="card">

            <div class="row">

                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <ul class="nav nav-tabs mb-0" id="tabs">
                                <li class="nav-item rbs-nav-item">
                                    <a href="#general" class="nav-link active" aria-selected="true">General</a>
                                </li>
                            </ul>
                            <div>

                                <button id="btnlone" type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                                data-bs-target="#loneModel">
                                    Add Lone
                                </button>

                            </div>
                            <div class="table-responsive">
                                <!-- Required for Responsive -->
                                <table id="loneTable" class="table datatable-fixed-both table-striped">
                                    <thead>
                                        <tr>
                                            <th class="id">ID</th>
                                            <th >Code</th>
                                            <th>Name Of Loan</th>
                                            <th>Description</th>
                                            <th >Amount</th>
                                            <th >Duration of Membership	</th>
                                            <th >Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="col-12">

                       
                            <ul class="nav nav-tabs mb-0" id="tabs">
                                <li class="nav-item rbs-nav-item">
                                    <a href="#general" class="nav-link active" aria-selected="true">General</a>
                                </li>
                            </ul>
                            <div class="card-body">
                                <button id="btnaddTerm" type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#loneTermModel">
                                    Add Term
                                </button>
                                <table class="table datatable-fixed-both table-striped" id="lonetermTable">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Lone</th>
                                            <th>No of Term</th>
                                            <th>Term Amount</th>
                                            <th>Term interest Amount</th>
                                            <th>Term interest %</th>
                                            <th>Remarks</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>

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
    

</div>
<!-- /content area -->
<!-- /lone model -->

<div class="modal fade" id="loneModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Lone</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
            </div>
            <div class="modal-body">


                <div class="modal-body p-4 bg-white">
                    <form id="" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-lg">
                                <label for="fname"><i class="fa fa-address-card-o fa-lg text-info" aria-hidden="true">&#160</i>Code<span class="text-danger">*</span></label>

                                <input type="text" name="loneCode" id="txtloneCode"
                                class="form-control validate" required>
                                <span class="text-danger font-weight-bold category2"></span>


                                <label for="fname"><i class="fa fa-address-card-o fa-lg text-info" aria-hidden="true">&#160</i>Name Of Loan</label>
                                <input type="text" class="form-control" id="txtname">

                                <label for="fname"><i class="fa fa-address-card-o fa-lg text-info" aria-hidden="true">&#160</i>Description</label>
                                <input type="text" class="form-control" id="txtdescription">

                                <label for="fname"><i class="fa fa-address-card-o fa-lg text-info" aria-hidden="true">&#160</i>Amount</label>
                                <input type="number" class="form-control" id="txtamount">

                                <label for="fname"><i class="fa fa-address-card-o fa-lg text-info" aria-hidden="true">&#160</i>Duration of Membership	</label>
                                <input type="text" class="form-control" id="txtdurationofmember">

                                <label for="fname"><i class="fa fa-address-card-o fa-lg text-info" aria-hidden="true">&#160</i>Remarks</label>
                                <input type="text" class="form-control" id="txtremarks">
                            </div>
                        </div>


                </div>


            </div>
            <div class="modal-footer">
                <input type="hidden" id="id">
                <button type="button" id="btnclose" class="btn btn-secondary" >Close</button>
                <button type="button" id="btnloneSave"

                    class="btn btn-primary btnSaveBank">Save</button>
                <button type="button" id="btnUpdatelone"
                    class="btn btn-primary ">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /lone term -->

<div class="modal fade" id="loneTermModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-white">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Lone</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
            </div>
            <div class="modal-body">


                <div class="modal-body p-4 bg-white">
                    <form id="" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-lg">
                                <label for="fname"><i class="fa fa-address-card-o fa-lg text-info" aria-hidden="true">&#160</i>No of Term</label>

                                <input type="number" name="loneterm" id="txtloneterm"
                                class="form-control validate">
                                <span class="text-danger font-weight-bold "></span>


                                <label for="fname"><i class="fa fa-address-card-o fa-lg text-info" aria-hidden="true">&#160</i>Term Amount</label>
                                <input type="number" class="form-control" id="txttermAmount">

                                <label for="fname"><i class="fa fa-address-card-o fa-lg text-info" aria-hidden="true">&#160</i>Term interest Amount</label>
                                <input type="number" class="form-control form-control-sm validate" id="txtinteresttermAmount">

                                <label for="fname"><i class="fa fa-address-card-o fa-lg text-info" aria-hidden="true">&#160</i>Term interest %</label>
                                <input type="number" class="form-control form-control-sm validate" id="txtrempresenttage" name="numbers">


                                <label for="fname"><i class="fa fa-address-card-o fa-lg text-info" aria-hidden="true">&#160</i>Remarks</label>
                                <input type="text" class="form-control" id="txttermremaks">
                            </div>
                        </div>


                </div>


            </div>
            <div class="modal-footer">
                <input type="hidden" id="id">
                <button type="button" id="btnBankclose" class="btn btn-secondary" >Close</button>
                <button type="button" id="btnSavetermlone"

                    class="btn btn-primary btnSaveBank">Save</button>
                <button type="button" id="btnUpdatetermlone"
                    class="btn btn-primary ">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- /End model -->

@endsection
<link rel="stylesheet" href="assets/css/master.css">
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
<script src="{{URL::asset('assets/js/loneManagment.js')}}?random=<?php echo uniqid(); ?>"></script>
<script src="{{URL::asset('assets/js/lonetermManagement.js')}}?random=<?php echo uniqid(); ?>"></script>
@endsection
