console.log("masterDesignation.js loading");

$(document).ready(function () {

    $('#tbl_create_designation').DataTable({
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
    loaddesignations();

    $('#add_modal').on('shown.bs.modal', function() {
        $('#designation_name').focus();
    })

    $('#btnsave').on('click', function () {

        if($('#btnsave').text().trim()=='Save'){
           save_designation();
        }
        else{
            update_designation();
        }

    });


});


function add_designation(){
    $('#add_modal').modal('show');
    $('.modal-title').text('Create Designation');
    $('#btnsave').text('Save');
    resetModal();
}

function save_designation(){

    var isValid = true;
    var name = $('#designation_name').val();

    if (name === '') {
        $('#name_error').html('This is a required field.');
        isValid = false;
    }else{

        var formData = new FormData();
        formData.append('name', $('#designation_name').val());

        $.ajax({
            type: "POST",
            url: "/save_designation",
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

                    loaddesignations();
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

function loaddesignations(){
    $.ajax({
        type: 'GET',
        url: '/get_all_designations',
        success: function(response){

            var dt = response.data;
            console.log(dt);
            var data = [];
                for (i = 0; i < response.data.length; i++) {

                    var id  = dt[i]['id'];
                    var name  = dt[i]['name'];
                    var isChecked = dt[i].status ? "checked" : "";

                    data.push({
                        "thname":name,
                        "thactions": '<button class="btn btn-primary btn-icon" onclick="edit(' + id + ')"><i class="ph-pencil-simple" aria-hidden="true"></i></button> ' + 
                        '<button class="btn btn-danger btn-icon" onclick="_delete(' + id + ')"><i class="ph-trash" aria-hidden="true"></i></button>',
                        "thstatus":'<label class="form-check form-switch"><input type="checkbox"  class="form-check-input" name="switch_single" id="cbxDesignationStatus" value="1"  onclick="cbxDesignationStatus('+ dt[i].id + ')" required '+isChecked+'></lable>',
                     });

                }
                var table = $('#tbl_create_designation').DataTable();
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
    $('.modal-title').text('Update Designation');
    $('#btnsave').text('Update');
    $('#hidden_id').val(id);

    $.ajax({
        type: "GET",
        url: "/get_designation_data/" + id,
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
                $('#designation_name').val(name); 
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

function update_designation(){

    var isValid = true;
    var name = $('#designation_name').val();

    if (name === '') {
        $('#name_error').html('This is a required field.');
        isValid = false;
    }else{

        var formData = new FormData();

        formData.append('id', $('#hidden_id').val());
        formData.append('name', $('#designation_name').val());

        $.ajax({
            type: "POST",
            url: "/master_designation/update",
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

                    loaddesignations();
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
            url: '/delete_designation/'+id,
            
            success: function(response){
                console.log(response);
                if(response.status == "deleted"){
                    loaddesignations();

                    new Noty({
                        text: 'Data deleted!',
                        type: 'success',
                    }).show();

                }else if(response.status == "designation_used"){
                    new Noty({
                        text: 'This designation is currently in use and cannot be deleted!',
                        type: 'warning'
                    }).show();

                    loaddesignations();
                    
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
        loaddesignations();
    }
}


function cbxDesignationStatus(id){
    
    var status = $('#cbxDesignationStatus').is(':checked') ? 1 : 0;

    $.ajax({
        url: '/designationStatus/'+id,
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
        },
        error: function (data) {
            console.log(data);
        }
    });
}


function resetModal(){
    $('#add_modal').find('input[type="text"]').val('');
}
