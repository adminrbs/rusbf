console.log("masterPlace_of_work.js loading");

$(document).ready(function () {

    $('#tbl_create_place_of_work').DataTable({
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
    loadPlaceOfWorks();

    $('#add_modal').on('shown.bs.modal', function() {
        $('#work_name').focus();
    })

    $('#btnsave').on('click', function () {

        if($('#btnsave').text().trim()=='Save'){
            save_work();
        }
        else{
            update_work();
        }

    });


});


function add_place_of_work(){
    $('#add_modal').modal('show');
    $('.modal-title').text('Create Place of Work');
    $('#btnsave').text('Save');
    resetModal();
}


function save_work(){

    var name = $('#work_name').val();
    
    if (name === '') {
        name = "Not Applicable";
    }

        var formData = new FormData();
        formData.append('name', name);

        $.ajax({
            type: "POST",
            url: "/save_place_of_work",
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

                    loadPlaceOfWorks();
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


function loadPlaceOfWorks(){
    $.ajax({
        type: 'GET',
        url: '/get_all_place_of_work',
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
                        "thactions": '<button class="btn btn-primary btn-icon" onclick="edit(' + id + ')"><i class="ph-pencil-simple" aria-hidden="true"></i></button> ' + 
                        '<button class="btn btn-danger btn-icon" onclick="_delete(' + id + ')"><i class="ph-trash" aria-hidden="true"></i></button>',
                        "thstatus":'<label class="form-check form-switch"><input type="checkbox"  class="form-check-input" name="switch_single" id="cbxPlaceOfWorkStatus" value="1"  onclick="cbxPlaceOfWorkStatus('+ stringId + ',this)" required '+isChecked+'></lable>',
                     });

                }
                var table = $('#tbl_create_place_of_work').DataTable();
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
    $('.modal-title').text('Update Place of Work');
    $('#btnsave').text('Update');
    $('#hidden_id').val(id);

    $.ajax({
        type: "GET",
        url: "/get_place_of_work_data/" + id,
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
                $('#work_name').val(name); 
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


function update_work(){

    var isValid = true;
    var name = $('#work_name').val();

    if (name === '') {
        $('#name_error').html('This is a required field.');
        isValid = false;
    }else{

        var formData = new FormData();

        formData.append('id', $('#hidden_id').val());
        formData.append('name', $('#work_name').val());

        $.ajax({
            type: "POST",
            url: "/master_place_of_work/update",
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

                    loadPlaceOfWorks();
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
            url: '/delete_place_of_work/'+id,
            
            success: function(response){
                console.log(response);
                if(response.status == "deleted"){
                    loadPlaceOfWorks();

                    new Noty({
                        text: 'Data deleted!',
                        type: 'success',
                    }).show();

                }else if(response.status == "work_place_used"){
                    new Noty({
                        text: 'This data is currently in use and cannot be deleted!',
                        type: 'warning'
                    }).show();

                    loadPlaceOfWorks();
                    
                }else if(response.status == "cannot"){
                    new Noty({
                        text: 'This cannot be deleted!',
                        type: 'warning'
                    }).show();

                    loadPlaceOfWorks();
                    
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
        loadPlaceOfWorks();
    }
}

function cbxPlaceOfWorkStatus(id,event){
    
    var status = $(event).is(':checked') ? 1 : 0;

    $.ajax({
        url: '/place_of_workStatus/'+id,
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

            loadPlaceOfWorks();
        },
        error: function (data) {
            console.log(data);
        }
    });
}


function resetModal(){
    $('#add_modal').find('input[type="text"]').val('');
}
