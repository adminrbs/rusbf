console.log("userRoles.js loading");

$(document).ready(function () {

    $('#tbl_users_list').DataTable({
        responsive: true,
        "order": [],
        "columns": [
          { "data": "thname" },
          { "data": "thactions" },
          { "data": "thstatus" },
        ],
        "columnDefs": [
            {
                "targets": [],
                "className": "text-center" 
            },
            {
                width: '40%',
                targets: 0,

            },
            {
                width: '25%',
                targets: 1,


            },
            {
                width: '15%',
                targets: 2,


            },
        ]
    });
    loadUserRoles();

    $('#add_modal').on('shown.bs.modal', function() {
        $('#designation_name').focus();
    })

    $('#btnsave').on('click', function () {

        if($('#btnsave').text().trim()=='Save'){
           save_user_roles();
        }
        else{
            update_user_roles();
        }

    });


});

function add_user_roles (){
    $('#add_modal').modal('show');
    $('.modal-title').text('Create User Role');
    $('#btnsave').text('Save');
    resetModal();
}

function save_user_roles(){

    var isValid = true;
    var name = $('#role_name').val();

    if (name === '') {

        $('#name_error').html('This is a required field.');
        isValid = false;

    }else{

        var formData = new FormData();
        formData.append('role_name', $('#role_name').val());

        $.ajax({
            type: "POST",
            url: "/save_user_role",
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
    
                console.log(response);
                if(response.status == "succeed"){
                    $('#add_modal').modal('hide');

                    new Noty({
                        text: 'Data saved!',
                        type: 'success',
                    }).show();

                    loadUserRoles();
                }else{
                    new Noty({
                        text: 'Saving process error!',
                        type: 'error'
                    }).show();
     
                }
                
            }
            , error: function (data) {
                console.log(data)
            }, complete: function () {
            }
        });
    }
}

function loadUserRoles(){
    $.ajax({
        type: 'GET',
        url: '/get_user_roles',
        success: function(response){

            var dt = response.data;
            console.log(dt);
            var data = [];
                for (i = 0; i < response.data.length; i++) {

                    var id  = dt[i]['id'];
                    var stringId = "'"+id+"'";
                    var name  = dt[i]['name'];
                    var isChecked = dt[i].status ? "checked" : "";

                    data.push({
                        "thname":name,
                        "thactions": '<button title="Edit" class="btn btn-primary btn-icon" onclick="edit(' + id + ')"><i class="ph-pencil-simple" aria-hidden="true"></i></button> ' + 
                        '<button title="Delete" class="btn btn-danger btn-icon" onclick="_delete(' + id + ')"><i class="ph-trash" aria-hidden="true"></i></button>',
                        "thstatus":'<label title="Status" class="form-check form-switch"><input type="checkbox"  class="form-check-input" name="switch_single" id="cbxUserRoleStatus" value="1"  onclick="cbxUserRoleStatus('+ stringId + ',this)" required '+isChecked+'></lable>',
                     });

                }
                var table = $('#tbl_users_list').DataTable();
                table.clear();
                table.rows.add(data).draw();

        },
        error: function (data) {
            console.log(data);
        }, complete: function () {

        }
    });
}

function edit(id){

    $('#add_modal').modal('show');
    $('.modal-title').text('Update User Role');
    $('#btnsave').text('Update');
    $('#hidden_id').val(id);

    $.ajax({
        type: "GET",
        url: "/get_role_data/" + id,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        beforeSend: function () {

        },
        success: function (response) {

            let name = response.data.name;

            if (response) {
                $('#role_name').val(name); 
            }else{
                console.log('error');
            }

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

function update_user_roles(){

    var isValid = true;
    var name = $('#role_name').val();

    if (name === '') {
        $('#name_error').html('This is a required field.');
        isValid = false;
    }else{

        var formData = new FormData();

        formData.append('id', $('#hidden_id').val());
        formData.append('role_name', $('#role_name').val());

        $.ajax({
            type: "POST",
            url: "/user_role/update",
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

                console.log(response);
                if(response.status == "updated"){
                    $('#add_modal').modal('hide');

                    new Noty({
                        text: 'Data updated!',
                        type: 'success',
                    }).show();

                    loadUserRoles();
                }else{
                    new Noty({
                        text: 'Saving process error!',
                        type: 'error'
                    }).show();
                }

            }
            , error: function (data) {
                console.log(data)
            }, complete: function () {
            }
        });

    }

}

function _delete(id){

    if (confirm('Are you sure you want to delete this record?')) {
        $.ajax({
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/user_role/'+id,
            
            success: function(response){
                console.log(response);
                if(response.status == "deleted"){
                    loadUserRoles();

                    new Noty({
                        text: 'Data deleted!',
                        type: 'success',
                    }).show();

                }else if(response.status == "role_used"){
                    loadUserRoles();

                    new Noty({
                        text: 'This data is currently in use and cannot be deleted!!',
                        type: 'warning'
                    }).show();
                }else{
                    new Noty({
                        text: 'deleting process error!',
                        type: 'error'
                    }).show();
                }

                
            }, error: function(data){

            }
        });
    } else {
        loadUserRoles();
    }
}


function cbxUserRoleStatus(id, event){
    
    var status = $(event).is(':checked') ? 1 : 0;

    $.ajax({
        url: '/user_role_status/'+id,
        type: 'POST',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'status': status
        },
        success: function (response) {
            console.log(response);
            new Noty({
                text: 'Status changed!',
                type: 'success',
                timeout: 2000,
            }).show();

            loadUserRoles();
        },
        error: function (data) {
            console.log(data);
        }
    });
}


function resetModal(){
    $('#add_modal').find('input[type="text"]').val('');
}