console.log("masterSubDepartment.js loading");


$(document).ready(function () {

    $('#tbl_create_sub_department').DataTable({
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
    loadSubDepartments();

    $('#add_modal').on('shown.bs.modal', function() {
        $('#sub_department_name').focus();
    })

    $('#btnsave').on('click', function () {

        if($('#btnsave').text().trim()=='Save'){
           save_department();
        }
        else{
            update_department();
        }

    });


});


function add_sub_department(){
    $('#add_modal').modal('show');
    $('.modal-title').text('Create Serving Sub-Department');
    $('#btnsave').text('Save');
    resetModal();
}

function save_department(){

    var name = $('#sub_department_name').val();
    
    if (name === '') {
        name = "Not Applicable";
    }
        var formData = new FormData();
        formData.append('name', name);
        formData.append('sub_department_code',$('#sub_department_code').val());

        $.ajax({
            type: "POST",
            url: "/save_department",
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

                    loadSubDepartments();
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

function loadSubDepartments(){
    $.ajax({
        type: 'GET',
        url: '/get_all_departments',
        success: function(response){

            var dt = response.data;
            // console.log(dt);
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
                        "thstatus":'<label title="Status" class="form-check form-switch"><input type="checkbox"  class="form-check-input" name="switch_single" id="cbxDepartment" value="1" onclick="cbxDepartmentStatus('+ stringId + ',this)" required '+isChecked+'></lable>',
                     });

                }
                var table = $('#tbl_create_sub_department').DataTable();
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
    $('.modal-title').text('Update Serving Sub-Department');
    $('#btnsave').text('Update');
    $('#hidden_id').val(id);

    $.ajax({
        type: "GET",
        url: "/get_department_data/" + id,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        beforeSend: function () {

        },
        success: function (response) {
            // console.log(response.data);

            let name = response.data.name;

            if (response) {
                $('#sub_department_name').val(name); 
                $('#sub_department_code').val(code);
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

function update_department(){

    var isValid = true;
    var name = $('#sub_department_name').val();

    if (name === '') {
        $('#name_error').html('This is a required field.');
        isValid = false;
    }else{

        var formData = new FormData();

        formData.append('id', $('#hidden_id').val());
        formData.append('name', $('#sub_department_name').val());
        formData.append('sub_department_code',$('#sub_department_code').val());

        $.ajax({
            type: "POST",
            url: "/master_department/update",
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

                    loadSubDepartments();
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
            url: '/delete_department/'+id,
            
            success: function(response){
                console.log(response);
                if(response.status == "deleted"){
                    loadSubDepartments();

                    new Noty({
                        text: 'Data deleted!',
                        type: 'success',
                    }).show();

                }else if(response.status == "department_used"){
                    new Noty({
                        text: 'This data is currently in use and cannot be deleted!',
                        type: 'warning'
                    }).show();

                    loadSubDepartments();
                    
                }else if(response.status == "cannot"){
                    new Noty({
                        text: 'This cannot be deleted!',
                        type: 'warning'
                    }).show();

                    loadSubDepartments();
                    
                }else{
                    new Noty({
                        text: 'Saving process error!',
                        type: 'error'
                    }).show();
                }

                
            }, error: function(data){

            }
        });
    } else {
        loadSubDepartments();
    }
}


function cbxDepartmentStatus(id, event){

    var status = $(event).is(':checked') ? 1 : 0;

    $.ajax({
        url: '/departmentStatus/'+id,
        type: 'POST',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'status': status
        },
        success: function (response) {
            console.log(response);

            if(response.status == 'used'){

                new Noty({
                    text: 'This data is currently in use and cannot be changed!',
                    type: 'warning'
                }).show();

                loadSubDepartments();

            }else if(response.status == 'saved'){

                new Noty({
                    text: 'Status changed!',
                    type: 'success',
                    timeout: 2000,
                }).show();
    
                loadSubDepartments();
            }else{
                new Noty({
                    text: 'Saving process error!',
                    type: 'error'
                }).show();
            }

        },
        error: function (data) {
            console.log(data);
        }
    });
}


function resetModal(){
    $('#add_modal').find('input[type="text"]').val('');
}
