

const DatatableFixedColumnss = function () {


    //
    // Setup module components
    //

    // Basic Datatable examples
    const _componentDatatableFixedColumns = function () {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Setting datatable defaults
        $.extend($.fn.dataTable.defaults, {
            columnDefs: [{
                orderable: false,
                width: 100,
                targets: [2]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            }
        });



        // Left and right fixed columns
        var table = $('#loneTable').DataTable({
            columnDefs: [
                {
                    orderable: false,
                    targets: 2
                },
                {
                    width: 200,
                    targets: 0
                },
                {
                    width: '100%',
                    targets: 1
                },
                {
                    width: 200,
                    targets: [2]
                }, {
                    width: 50,
                    targets: 3
                }, {
                    width: 50,
                    targets: 4
                }, {
                    width: 50,
                    targets: 5
                }, {
                    width: 50,
                    targets: 6
                },

            ],
            scrollX: true,
            /* scrollY: 350, */
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            },
            "pageLength": 100,
            "order": [],
            "columns": [
                { "data": "lone_id" },
                { "data": "code" },
                { "data": "name" },
                { "data": "description" },
                { "data": "amount" },
                { "data": "duration" },
                { "data": "remark" },
                { "data": "action" },



            ], "stripeClasses": ['odd-row', 'even-row'],
        }); table.column(0).visible(false);


        //
        // Fixed column with complex headers
        //

    };


    //
    // Return objects assigned to module
    //

    return {
        init: function () {
            _componentDatatableFixedColumns();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function () {
    DatatableFixedColumnss.init();
});








var formData = new FormData();
let loan_id;
$(document).ready(function () {
    loneAllData();
    $('#btnlone').on('click', function () {
        $('#btnloneSave').show();
        $('#btnUpdatelone').hide();
        $('#id').val('');
        $("#txtloneCode").val('');
        $("#txtname").val('');
        $("#txtdescription").val('');
        $("#txtamount").val('');
        $("#txtdurationofmember").val('');
        $("#txtremarks").val('');



    });

    $('#btnloneSave').on('click', function (e) {

        lonesave();
    });
    $(document).on('click', '.lonmodel', function (e) {
        loan_id = $(this).attr('id');

        getlone(loan_id);
       
    });
    $(document).on('click', '.loneview', function (e) {
        loan_id = $(this).attr('id');

        getloneview(loan_id);
       
    });
 $('#btnUpdatelone').on('click', function (e) {

            updatelone(loan_id);
        });
});



function lonesave() {

    formData.append('txtloneCode', $('#txtloneCode').val());
    formData.append('txtname', $('#txtname').val());
    formData.append('txtdescription', $('#txtdescription').val());
    formData.append('txtamount', $('#txtamount').val());
    formData.append('txtdurationofmember', $('#txtdurationofmember').val());
    formData.append('txtremarks', $('#txtremarks').val());


    console.log(formData);
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: '/loansave',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 800000,
        beforeSend: function () {

        },
        success: function (response) {

            $('#loneModel').modal('hide');
            loneAllData()
            if (response.status) {
                showSuccessMessage('Successfully saved');
                new Noty({
                    text: 'Successfully saved',
                    type: 'success'
                }).show();
    
                console.log(response);
            } else {
                showErrorMessage('Something went wrong');
                new Noty({
                    text: 'Something went wrong',
                    type: 'error'
                }).show();
                $('#loneModel').modal('hide');
            }

        },
        error: function (error) {
            showErrorMessage('Something went wrong');
            $('#loneModel').modal('hide');
            console.log(error);

        },
        complete: function () {

        }

    });

}


function loneAllData() {

    $.ajax({
        type: "GET",
        url: "/loneallData",
        cache: false,
        timeout: 800000,
        beforeSend: function () { },
        success: function (response) {

            var dt = response.data;
            console.log(dt);
            disabled = "disabled";

            var data = [];
            for (var i = 1; i < dt.length; i++) {



                data.push({
                    "lone_id": dt[i].loan_id,
                    "code": '<div data-id = "' + dt[i].loan_id + '">' + dt[i].loan_code + '</div>',
                    "name": dt[i].loan_name,
                    "description": dt[i].description,
                    "amount": dt[i].amount,
                    "duration": dt[i].duration_of_membership,
                    "remark": dt[i].remarks,
                    "action": '<button class="btn btn-primary  btn-sm lonmodel" data-bs-toggle="modal" data-bs-target="#loneModel" id="' + dt[i].loan_id + '"><i class="ph-pencil-simple" aria-hidden="true"></i></button>&#160<button class="btn btn-success btn-sm loneview" data-bs-toggle="modal" data-bs-target="#loneModel" id="' + dt[i].loan_id + '"><i class="ph-eye" aria-hidden="true"></i></button>&#160<button class="btn btn-danger btn-sm" onclick="_delete(' + dt[i].loan_id + ')"><i class="ph-trash" aria-hidden="true"></i></button>',
                });
            }


            var table = $('#loneTable').DataTable();
            table.clear();
            table.rows.add(data).draw();

        },
        error: function (error) {
            console.log(error);
        },
        complete: function () { }
    })


}
function getlone(id) {
    $.ajax({
        url: '/getlone/' + id,
        method: 'get',
        data: {
            //id: id,
            _token: '{{ csrf_token() }}'
        },

        success: function (response) {
            console.log(response);
            $('#btnloneSave').hide();
            $('#btnUpdatelone').show();

            $('#id').val(response.loan_id);
            $("#txtloneCode").val(response.loan_code);
            $('#txtname').val(response.loan_name);
            $('#txtdescription').val(response.description);
            $('#txtamount').val(response.amount);
            $('#txtdurationofmember').val(response.duration_of_membership);
            $('#txtremarks').val(response.remarks);


        }
    });
}

function updatelone(id) {


    formData.append('txtloneCode', $('#txtloneCode').val());
    formData.append('txtname', $('#txtname').val());
    formData.append('txtdescription', $('#txtdescription').val());
    formData.append('txtamount', $('#txtamount').val());
    formData.append('txtdurationofmember', $('#txtdurationofmember').val());
    formData.append('txtremarks', $('#txtremarks').val());


    console.log(formData);
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: '/getloneupdate/' + id,
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 800000,
        beforeSend: function () {

        },
        success: function (response) {

            $('#loneModel').modal('hide');
            loneAllData()
            new Noty({
                text: 'Successfully saved',
                type: 'success',
            }).show();
           

        },
        error: function (error) {
            showErrorMessage('Something went wrong');
            $('#loneModel').modal('hide');
            console.log(error);

        },
        complete: function () {

        }

    });

}
function getloneview(id) {
    $.ajax({
        url: '/getlone/' + id,
        method: 'get',
        data: {
            //id: id,
            _token: '{{ csrf_token() }}'
        },

        success: function (response) {
            console.log(response);
            $('#btnloneSave').hide();
            $('#btnUpdatelone').hide();



            $('#id').val(response.loan_id);
            $("#txtloneCode").val(response.loan_code);
            $('#txtname').val(response.loan_name);
            $('#txtdescription').val(response.description);
            $('#txtamount').val(response.amount);
            $('#txtdurationofmember').val(response.duration_of_membership);
            $('#txtremarks').val(response.remarks);


        }
    });
}


function _delete(id) {

    bootbox.confirm({
        title: 'Delete confirmation',
        message: '<div class="d-flex justify-content-center align-items-center mb-3"><i class="fa fa-times fa-5x text-danger" ></i></div><div class="d-flex justify-content-center align-items-center "><p class="h2">Are you sure?</p></div>',
        buttons: {
            confirm: {
                label: '<i class="fa fa-check"></i>&nbsp;Yes',
                className: 'btn-Danger'
            },
            cancel: {
                label: '<i class="fa fa-times"></i>&nbsp;No',
                className: 'btn-info'
            }
        },
        callback: function (result) {
            console.log(result);
            if (result) {
                deletelone(id);
            } else {

            }
        }
    });
    $('.bootbox').find('.modal-header').addClass('bg-danger text-white');

}

function deletelone(id) {

    $.ajax({
        type: 'DELETE',
        url: '/deletelone/' + id,
        data: {
            _token: $('input[name=_token]').val()
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {

        }, success: function (response) {


            if (response.success) {
                $('#loneModel').modal('hide');
               
                new Noty({
                    text: 'Successfully deleted',
                    type: 'success',
                }).show();
                loneAllData()
            } else {
                
                new Noty({
                    text: 'Uneble to Delete',
                    type: 'error'
                }).show();
            }


        }, error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

