
const DatatableFixedColumns = function () {

    // Setup module components

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
        var table = $('#tbldonation').DataTable({
            columnDefs: [

                    {
                        orderable: false,
                        targets: 2
                    },
                    {
                        width:200,
                        targets: 0
                    },
                    {
                        width: '100%',
                        targets: 1
                    },
                    {
                        width:300,
                        targets: 2
                    },

            ],

            fixedColumns: true,
            scrollX: false,
            scrollY: "100%",
            scrollCollapse: false,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            },
           /*  "autoWidth": false, */
            "pageLength": 100,
            "order": [],
            "columns": [
                { data: "id" },

                { data: "donetion" },
               
              
                { data: "action" },
                { data: "status" },


            ],
            "stripeClasses": ['odd-row', 'even-row']
        });table.column(0).visible(false);


    };

    // Return objects assigned to module

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

    $('#btnsave').on('click', function () {
        if ($('#btnsave').text() === 'Save') {
            save_donation();
        } else {
            update_donation();
        }
    });
    
   

get_donetion();

});

function add_donetion(){
    $('#add_modal').modal('show');
    $('.modal-title').text('Create Donation');
    $('#btnsave').text('Save');
    resetModal();
}

function save_donation(){
    var formData = new FormData();
  
    formData.append('txtdonation', $('#txtdonation').val());

        $.ajax({
            type: "POST",
            url: "/save_donetion",
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
                if(response.status == true){
                    $('#add_modal').modal('hide');

                    new Noty({
                        text: 'Data saved!',
                        type: 'success',
                    }).show();

                    get_donetion();
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

function get_donetion(){
    $.ajax({
        type: 'GET',
        url: '/get_donetion',
        success: function(response){

            var dt = response.data;
         
                var data = [];
                for (var i = 0; i < dt.length; i++) {


                    var isChecked = dt[i].is_active == 1 ? "checked" : "";
                   

                    data.push({
                        "id": dt[i].donation_id ,
                        "donetion": dt[i].donation,
                        "status": '<label class="form-check form-switch"><input type="checkbox"  class="form-check-input" name="switch_single" id="donationid" value="1" onclick="cbxdonation(' + dt[i].donation_id  + ')" required ' + isChecked + '></label>',
                        "action": '<button title="Edit" class="btn btn-primary  btn-sm lonmodel" onclick="edit(' + dt[i].donation_id  + ')"><i class="ph-pencil-simple" aria-hidden="true"></i></button>&#160<button class="btn btn-danger btn-sm" onclick="_delete(' + dt[i].donation_id  + ')" title="Delete"><i class="ph-trash" aria-hidden="true"></i></button>',
                    });
                }

                var table = $('#tbldonation').DataTable();
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
    $('.modal-title').text('Update Donation');
    $('#btnsave').text('Update');
    $('#hidden_id').val(id);

    $.ajax({
        type: "GET",
        url: "/get_donetion_data/" + id,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        beforeSend: function () {

        },
        success: function (response) {
            // console.log(response.data);

let id =response.donation_id;
            let name = response.donation;

            if (response) {
                $('#hidden_id').val(id); 
                $('#txtdonation').val(name); 
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

function update_donation(){

        var formData = new FormData();

        formData.append('id', $('#hidden_id').val());
        formData.append('txtdonation', $('#txtdonation').val());

        $.ajax({
            type: "POST",
            url: "/update_donetion",
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
                if(response.status == true){
                    $('#add_modal').modal('hide');

                    new Noty({
                        text: 'Data updated!',
                        type: 'success',
                    }).show();

                    get_donetion();
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

function _delete(id){

    if (confirm('Are you sure you want to delete this record?')) {
        $.ajax({
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/delete_donetion/'+id,
            
            success: function(response){
                console.log(response);
              
                    get_donetion();

                    new Noty({
                        text: 'Data deleted!',
                        type: 'success',
                    }).show();

                
                 
                

                
            }, error: function(response){

            }
        });
    } else {
        get_donetion();
    }
}


function cbxdonation(id) {
    var status = $('#donationid').is(':checked') ? 1 : 0;


    $.ajax({
        url: '/cbxdonation/' + id,
        type: 'POST',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'status': status
        },
        success: function (response) {
            new Noty({
                text: 'Successfully save',
                type: 'success',
            }).show();

            //allcontributedata()
            console.log("data save");
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}

function resetModal(){
    $('#add_modal').find('input[type="text"]').val('');
}
