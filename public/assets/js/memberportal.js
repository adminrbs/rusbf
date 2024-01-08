

const DatatableFixedColumns = function () {


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
        var table = $('#tbl_memberportal').DataTable({
            columnDefs: [
                {
                    orderable: false,
                    targets: 2,


                },
                {
                    width: 200,
                    targets: 0,

                },
                {
                    width: '100%',
                    targets: 1,


                },
                {
                    width: 300,
                    targets: 2,


                },
                {
                    width: 300,
                    targets: 3,


                },



            ],

            scrollX: true,
            /*    scrollY: 350, */
            scrollCollapse: true,

            "pageLength": 100,
            "order": [],
            "columns": [
                { "data": "id" },
                { "data": "username" },
                { "data": "status" },
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
    DatatableFixedColumns.init();
});
//.............................Auto Complete.............



var formData = new FormData();
$(document).ready(function () {
    


    $('#btnsave').on('click', function () {
        if ($('#btnsave').text().trim() == 'Save') {
            savemembwrPortal();
        } else if ($('#btnsave').text().trim() == 'Update') {
            update_embwrPortal();
        }

    })
   
    $(".select2").select2({
        dropdownParent: $("#add_modal")

    });
    getallmembers();
    memberportalAllData();

});

function add_user() {
    $('#add_modal').modal('show');
    $('.modal-title').text('Member Portal');
    $('#btnsave').text('Save');

    $('#add_modal').on('shown.bs.modal', function () {
        $('#username').focus();
    })
    $('input[type="text"]').val('');
    $('input[type="password"]').val('');
    $('#cmbmemberprtal').prop('disabled', false);
  
    $('input[type="text"]').prop('disabled', false);
    $('input[type="password"]').prop('disabled', false);
    getallmembers(0)
}



function savemembwrPortal() {
    var password = $('#txtPassword').val();
    var confirm_pass = $('#txtConfirmPassword').val();
    var membername = $('#cmbmemberprtal').val();
    var username = $('#txtusername').val();
    if (password != confirm_pass) {

        new Noty({
            text: 'Please re-enter the confirm password',
            type: 'warning',
        }).show();
        return;
    }
    if (username == null || username == "") {

        new Noty({
            text: 'Please Enter User Name',
            type: 'warning',
        }).show();
        return;
    }
    if (membername == null || membername == "") {

        new Noty({
            text: 'Please Enter Member Name',
            type: 'warning',
        }).show();
        return;
    } else {
        if (password === "") {

            new Noty({
                text: 'Please Enter Password',
                type: 'warning',
            }).show();
            return;

        } else if (password.length < 6) {
            showWarningMessage("Minimum Charactors Of Password Should be 7");
            new Noty({
                text: 'Minimum Charactors Of Password Should be 7',
                type: 'warning',
            }).show();
        } else {

            formData.append('cmbmemberprtal', $('#cmbmemberprtal').val());
            formData.append('txtusername', $('#txtusername').val());
            formData.append('txtPassword', $('#txtPassword').val());
            formData.append('txtConfirmPassword', $('#txtConfirmPassword').val());


            console.log(formData);

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: '/savemembwrPortal',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 800000,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    // Perform any tasks before sending the request
                },
                success: function (response) {


                    if (response.message === true) {
                        $('#add_modal').modal('hide');
                        console.log(response);
                        new Noty({
                            text: 'Successfully Save',
                            type: 'success',
                        }).show();
                        memberportalAllData();
                    } else if (response.message === false) {

                        console.log(response);
                        new Noty({
                            text: 'Something went wrong',
                            type: 'error',
                        }).show();
                        memberportalAllData();
                    } else if (response.message === 'create_user') {
                        new Noty({
                            text: 'User Name can not be duplicated',
                            type: 'error',
                        }).show();

                    }else if (response.message === 'create_member') {
                        new Noty({
                            text: 'member can not be duplicated',
                            type: 'error',
                        }).show();

                    }

                    console.log(response);
                },
                error: function (error) {

                    console.log(error);
                }
            });
        }


    }
}


function memberportalAllData() {


    $.ajax({
        type: "GET",
        url: "/memberportalAllData",
        cache: false,
        timeout: 800000,
        beforeSend: function () { },
        success: function (response) {

            var dt = response;

            var data = [];
            for (var i = 0; i < dt.length; i++) {

                var isChecked = dt[i].status ? "checked" : "";

                data.push({

                    "id": dt[i].member_potal_id,
                    "username": dt[i].user_name,
                    "status": '<label class="form-check form-switch"><input type="checkbox"  class="form-check-input" name="switch_single" id="cbxmemberportal" value="0" onclick="cbxmemberportelStatus(' + dt[i].member_potal_id + ')" required ' + isChecked + '></lable>',
                    "action": '<button class="btn btn-primary btn-sm" onclick="editmemberportal(' + dt[i].member_potal_id + ')"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>&#160<button class="btn btn-success btn-sm" onclick="viewmemberportal(' + dt[i].member_potal_id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>&#160<button class="btn btn-danger btn-sm" onclick="memberportaldelete(' + dt[i].member_potal_id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>',
                });
            }


            var table = $('#tbl_memberportal').DataTable();
            table.clear();
            table.rows.add(data).draw();


        },
        error: function (error) {
            console.log(error);
        },
        complete: function () { }
    })

}

function editmemberportal(id) {

    $('#add_modal').modal('show');

    $('#hiddenuserid').val(id);
    $('#btnsave').text("Update");
   $('#cmbmemberprtal').prop('disabled', true);

  

   
    $('input[type="text"]').prop('disabled', false);
    $('input[type="password"]').prop('disabled', false);


    $.ajax({
        type: "GET",
        url: "/get_memberportel_data/" + id,

        success: function (response) {

console.log(response);

            $('#hiddenuserid').val(response.member_potal_id);
            $('#txtusername').val(response.user_name);
            $('#cmbmemberprtal').val(response.member_id).trigger('change');


        },
        error: function (error) {

        },
        complete: function () {

        }

    });

}

function viewmemberportal(id) {

    $('#add_modal').modal('show');
    $('#btnsave').hide();

   
    $('input[type="text"]').prop('disabled', true);
    $('input[type="password"]').prop('disabled', true);
   $('#cmbmemberprtal').prop('disabled', true);

    $.ajax({
        type: "GET",
        url: "/get_memberportel_data/" + id,

        success: function (response) {

console.log(response);

            $('#hiddenuserid').val(response.member_potal_id);
            $('#txtusername').val(response.user_name);
            $('#cmbmemberprtal').val(response.member_id).trigger('change');


        },
        error: function (error) {

        },
        complete: function () {

        }

    });

}


function update_embwrPortal() {

    var id = $('#hiddenuserid').val();
    var password = $('#txtPassword').val();
    var confirm_pass = $('#txtConfirmPassword').val();
    var membername = $('#cmbmemberprtal').val();
    var username = $('#txtusername').val();


    if (password != confirm_pass) {

        new Noty({
            text: 'Please re-enter the confirm password',
            type: 'warning',
        }).show();
        return;
    }
    if (username == null || username == "") {

        new Noty({
            text: 'Please Enter User Name',
            type: 'warning',
        }).show();
        return;
    }
    if (membername == null || membername == "") {

        new Noty({
            text: 'Please Enter Member Name',
            type: 'warning',
        }).show();
        return;
    } else {
        if (password === "") {

            new Noty({
                text: 'Please Enter Password',
                type: 'warning',
            }).show();
            return;

        } else if (password.length < 6) {
            showWarningMessage("Minimum Charactors Of Password Should be 7");
            new Noty({
                text: 'Minimum Charactors Of Password Should be 7',
                type: 'warning',
            }).show();
        } else {


            formData.append('cmbmemberprtal', $('#cmbmemberprtal').val());
            formData.append('txtusername', $('#txtusername').val());
            formData.append('txtPassword', $('#txtPassword').val());
            formData.append('txtConfirmPassword', $('#txtConfirmPassword').val());


            console.log(formData);
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: '/update_embwrPortal/' + id,
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
                    $('#add_modal').modal('hide');
                    console.log(response);
                    new Noty({
                        text: 'Successfully updated',
                        type: 'success',
                    }).show();
                    memberportalAllData();

                }, error: function (error) {

                    $('#add_modal').modal('hide');
                    console.log(response);
                    new Noty({
                        text: 'Something went wrong!',
                        type: 'error',
                    }).show();
                    //$('#modalCustomerApp').modal('hide');
                    console.log(error);
                }
            });
        }

    }
}



function memberportaldelete(id) {

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
                deletememberporatal(id);
            } else {

            }
        }
    });
    $('.bootbox').find('.modal-header').addClass('bg-danger text-white');

}

function deletememberporatal(id) {

    $.ajax({
        type: 'DELETE',
        url: '/deletememberpotal/' + id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            new Noty({
                text: 'deleted successfully!',
                type: 'success',
            }).show();
            memberportalAllData();
        }, error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}


function getallmembers(memberid) {

    $.ajax({
        type: "get",
        dataType: 'json',
        url: "/getallmembers/"+ memberid,

        success: function (data) {
            var htmlContent = "";
            htmlContent += "<option value=''>Select Member</option>";

            $.each(data, function (key, value) {

                htmlContent += "<option value='" + value.id + "'>" + value.full_name + "</option>";
            });


            $('#cmbmemberprtal').html(htmlContent);



        }

    });

}


function cbxmemberportelStatus(memberid) {
    var status = $('#cbxmemberportal').is(':checked') ? 1 : 0;


    $.ajax({
        url: '/cbxmemberportelStatus/' + memberid,
        type: 'POST',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'status': status
        },
        success: function (response) {
            console.log("data save");
            new Noty({
                text: 'saved',
                type: 'success',
            }).show();
           
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}


