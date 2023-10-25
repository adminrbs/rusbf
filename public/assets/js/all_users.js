console.log("all_users.js loading");


const DatatableFixedColumns = function () {


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
        var table = $('#tbl_users').DataTable({


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
                    width: 400,
                    targets: 1
                },
                {
                    width: 400,
                    targets: [2]
                },
                {
                    width: "100%",
                    targets: 3
                },


            ],
            scrollX: true,
            //scrollY: 350,
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            },
            "pageLength": 100,
            "order": [],
            "columns": [
                { "data": "thid" },
                { "data": "thusername" },
                { "data": "themail" },
                { "data": "throle" },
                { "data": "thtype" },
                { "data": "thactions" },

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



$(document).ready(function () {
    userRoles();

    loadusers();

    $('#user_form').submit(function (e) {
        e.preventDefault();

        if ($('#btnsave').text().trim() == 'Save') {
            save_user();
        } else if ($('#btnsave').text().trim() == 'Update') {
            update_user();
        }

    });


    // Default initialization
    $('.select2').select2();
    // End of Default initialization
});

function loadusers() {
    $.ajax({
        type: 'GET',
        url: '/load_users_list',
        success: function (response) {
            var dt = response.userData;
            console.log(dt);
            var data = [];
            for (i = 1; i < dt.length; i++) {

                var id = dt[i]['id'];
                var stringId = "'" + id + "'";
                var username = dt[i]['name'];
                var email = dt[i]['email'];
                var role_name = dt[i]['role_name'];
                var user_type = dt[i]['user_type'];

                data.push({
                    "thid": id,
                    "thusername": username,
                    "themail": email,
                    "throle": role_name,
                    "thtype": user_type === 1 ? "Employee" : "Guest",
                    "thactions": '<button title="Edit" class="btn btn-primary btn-icon" onclick="edit(' + id + ')"><i class="ph-pencil-simple" aria-hidden="true"></i></button> ' +
                        '<button title="Delete" class="btn btn-danger btn-icon" onclick="_delete(' + id + ')"><i class="ph-trash" aria-hidden="true"></i></button>',
                });

            }
            var table = $('#tbl_users').DataTable();
            table.clear();
            table.rows.add(data).draw();
        }
    });
}

function userRoles() {
    $.ajax({
        type: "get",
        dataType: 'json',
        url: "/get_user_role",

        success: function (response) {
            var data = response

            $.each(data, function (index, value) {

                $('#userrole').append('<option value="' + value.id + '">' + value.name + '</option>');

            })

        },

    });
}

function add_user() {
    $('#add_modal').modal('show');
    $('.modal-title').text('Create User');
    $('#btnsave').text('Save');

    $('#add_modal').on('shown.bs.modal', function () {
        $('#username').focus();
    })
    resetUserModal();

    // Fetch user types via AJAX and populate the select element

}

function resetUserModal() {
    $('#add_modal').find('input').val('');
    $('#add_modal').find('select').val('');
}

function save_user() {

    var password = $('#password').val();
    var confirmPassword = $('#confirmPassword').val();

    // Check if the password and confirm password fields match

    if (password == "" && confirmPassword == "") {
        new Noty({
            text: 'Password and Confirm Password do not match!',
            type: 'error'
        }).show();
        return;
    } else {

        if (password !== confirmPassword) {

            new Noty({
                text: 'Password and Confirm Password do not match!',
                type: 'error'
            }).show();
            return;

        }

        var formData = new FormData();

        formData.append('username', $('#username').val());
        formData.append('email', $('#email').val());
        formData.append('password', password); // Use the password variable
        formData.append('userrole', $('#userrole').val());
        formData.append('usertype', $('#usertype').val());

        $.ajax({
            type: "POST",
            url: "/save_user",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            beforeSend: function () {

            },
            success: function (response) {

                $('#add_modal').modal('hide');
                console.log(response);
                new Noty({
                    text: 'User created successfully!',
                    type: 'success',
                }).show();

                loadusers();

            }
        });
    }
}

function edit(id) {

    $('#add_modal').modal('show');
    $('.modal-title').text('Update User');
    $('#hiddenuserid').val(id);
    $('#btnsave').text("Update");


    $.ajax({
        type: "GET",
        url: "/get_user_data/" + id,

        success: function (response) {

            /* console.log(response);
 
             $('#hiddenuserid').val(response.id); 
             $('#edit_username').val(response.name); 
             $('#edit_email').val(response.email); 
             $('#userrole').val(response.role_id);
 
             $('#usertype').val(response.user_type);*/
            console.log(response);

            console.log(userRoles);
            $('#hiddenuserid').val(response[0].id);
            $('#username').val(response[0].name);
            $('#email').val(response[0].email);
            //console.log(response.userRoles[0].role_id);
            $('#userrole').val(response[0].role_id).trigger('change');
            $('#usertype').val(response[0].user_type).trigger('change');
            /*if (user) {
                $('#hiddenuserid').val(user.id); 
                $('#edit_username').val(user.name); 
                $('#edit_email').val(user.email); 
$('#userrole').val();

$('#usertype').val();

                var userRoleSelect = $('#edit_userrole');
                userRoleSelect.empty(); // Clear existing options

                userRoleSelect.append($('<option>', {
                    value: '',
                    text: '-- Select --'
                }));

                $.each(userRoles, function (index, userRole) {
                    userRoleSelect.append($('<option>', {
                        value: userRole.role_id,
                        text: userRole.role_name
                    }));
                });

                // Set the selected user role
                userRoleSelect.val(userRoles[0].role_id).trigger('change');

                $('#edit_usertype').val(user.user_type).trigger('change');
            } else {
                console.log('User not found');
            }*/

        },
        error: function (error) {
            new Noty({
                text: 'Something went wrong.',
                type: 'error'
            }).show();

        },
        complete: function () {

        }

    });

}

function update_user() {
    var formData = new FormData();
    var password = $('#password').val();
    var confirmPassword = $('#confirmPassword').val();

    if (password != "" && confirmPassword != "") {

        if (password !== confirmPassword) {

            new Noty({
                text: 'Password and Confirm Password do not match!',
                type: 'error'
            }).show();
            return;

        }
        var id = $('#hiddenuserid').val();

        formData.append('username', $('#username').val());
        formData.append('email', $('#email').val());
        formData.append('password', password); // Use the password variable
        formData.append('userrole', $('#userrole').val());
        formData.append('usertype', $('#usertype').val());



        $.ajax({
            type: "POST",
            url: "/update_user/" + id,
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            beforeSend: function () {

            },
            success: function (response) {

                $('#add_modal').modal('hide');
                console.log(response);
                new Noty({
                    text: 'User created successfully!',
                    type: 'success',
                }).show();

                loadusers();

            }
        });

    } else {
        var id = $('#hiddenuserid').val();


        formData.append('username', $('#username').val());
        formData.append('email', $('#email').val());
        //formData.append('password', password); // Use the password variable
        formData.append('userrole', $('#userrole').val());
        formData.append('usertype', $('#usertype').val());



        $.ajax({
            type: "POST",
            url: "/update_user/" + id,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            beforeSend: function () {

            },
            success: function (response) {

                $('#add_modal').modal('hide');
                console.log(response);
                new Noty({
                    text: 'User created successfully!',
                    type: 'success',
                }).show();

                loadusers();

            }
        });

    }

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
                deleteUser(id);
            } else {

            }
        }
    });
    $('.bootbox').find('.modal-header').addClass('bg-danger text-white');

}

function deleteUser(id) {
    $.ajax({
        type: 'DELETE',
        url: '/deleteusers/' + id,
        data: {
            _token: $('input[name=_token]').val()
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {

        }, success: function (response) {
            console.log(response);
            loadusers()
            new Noty({
                text: 'User created successfully!',
                type: 'success',
            }).show();

        }, error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

