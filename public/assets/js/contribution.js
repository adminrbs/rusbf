


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
        var table = $('#tbl_create_contribution').DataTable({
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
                }

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
                { "data": "id" },
                { "data": "code" },
                { "data": "name" },
                { "data": "contribute" },
                { "data": "acount" },
                { "data": "status" },
                { "data": "action" },
               


            ], "stripeClasses": ['odd-row', 'even-row'],
        });table.column(0).visible(false);


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
$(document).ready(function () {

    $('#btncontribution').on('click', function () {
        $('input[type="text"]').val('');


    });
    allcontributedata();
    $('#btnsave').on('click', function () {

        if ($('#btnsave').text().trim() == 'Save') {
            save_contribution();
        }
        else {
            update_contribution();
        }

    });
});


function save_contribution() {

    formData.append('code', $('#code').val());
    formData.append('txtNamecontribution', $('#txtNamecontribution').val());
    formData.append('txtDescription', $('#txtDescription').val());
    formData.append('txtContribute', $('#txtContribute').val());
    formData.append('txtglaccount', $('#txtglaccount').val());

    console.log(formData);
    if (formData.txtNamecontribution == '' && formData.txtContribute == '') {

        return false;
    } else {

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: '/save_contribution',
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
                //suplyGroupAllData();
                $('#modalcontribution').modal('hide');
                allcontributedata()
                new Noty({
                    text: 'Successfully saved',
                    type: 'success'
                }).show();
    

            },
            error: function (error) {
                //showErrorMessage('Something went wrong');
                new Noty({
                    text: 'Something went wrong',
                    type: 'error'
                }).show();
                console.log(error);

            },
            complete: function () {

            }

        });
    }

}

function allcontributedata(){
    $.ajax({
        type: 'GET',
        url: '/allcontributedata',
        success: function(response){

            var dt = response.data;
            console.log(dt);
            var data = [];
                for (i = 0; i < response.data.length; i++) {

                    var dt = response.data;
                   
                   
      
                    var data = [];
                    for (var i = 1; i < dt.length; i++) {
                       

                        var isChecked = dt[i].status==1? "checked" : "";
                        var contribute = dt[i].contribute_on_every == 1 ? "Annualy" : "Monthly";

                        data.push({
                            "id": dt[i].contribution_id ,
                            "code": dt[i].contribution_code   ,
                            "name": dt[i].contribution_title,
                            "contribute": contribute,
                            "acount": dt[i].gl_account_no,
                            "status": '<label class="form-check form-switch"><input type="checkbox"  class="form-check-input" name="switch_single" id="contribute" value="1" onclick="cbxcontribute(' + dt[i].contribution_id + ')" required ' + isChecked + '></label>',
                            "action": '<button class="btn btn-primary  btn-sm lonmodel" data-bs-toggle="modal" data-bs-target="#modalcontribution" onclick="edit(' + dt[i].contribution_id  + ')"><i class="ph-pencil-simple" aria-hidden="true"></i></button>&#160<button class="btn btn-success btn-sm loneview" data-bs-toggle="modal" data-bs-target="#modalcontribution"  onclick="getcontributeview(' + dt[i].contribution_id  + ')"><i class="ph-eye" aria-hidden="true"></i></button>&#160<button class="btn btn-danger btn-sm" onclick="_delete(' + dt[i].contribution_id  + ')"><i class="ph-trash" aria-hidden="true"></i></button>',
                        });
                    }

                    
                   
                }
                var table = $('#tbl_create_contribution').DataTable();
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
    $('#btnsave').text('Update');
    $.ajax({
        url: '/getcontribute/' + id,
        method: 'get',
        data: {
            //id: id,
            _token: '{{ csrf_token() }}'
        },

        success: function (response) {
            console.log(response);
           

            $('#id').val(response.contribution_id);
            $("#code").val(response.contribution_code );
            $('#txtNamecontribution').val(response.contribution_title);
            $('#txtDescription').val(response.description);
            $('#txtContribute').val(response.contribute_on_every);
            $('#txtglaccount').val(response.gl_account_no);
          


        }
    });
}

function update_contribution(){
    var id = $('#id').val();
    formData.append('code', $('#code').val());
    formData.append('txtNamecontribution', $('#txtNamecontribution').val());
    formData.append('txtDescription', $('#txtDescription').val());
    formData.append('txtContribute', $('#txtContribute').val());
    formData.append('txtglaccount', $('#txtglaccount').val());

    console.log(formData);
    if (formData.txtNamecontribution == '' && formData.txtContribute == '') {

        return false;
    } else {

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: '/update_contribution/'+ id,
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
                //suplyGroupAllData();
                $('#modalcontribution').modal('hide');
              
                allcontributedata()
                new Noty({
                    text: 'Successfully updated',
                    type: 'success',
                }).show();
            },
            error: function (error) {
                //showErrorMessage('Something went wrong');
                $('#modalcontribution').modal('hide');
                console.log(error);

            },
            complete: function () {

            }

        });
    }
}


function getcontributeview(id) {
    $('#btnsave').hide();
    $.ajax({
        url: '/getcontribute/' + id,
        method: 'get',
        data: {
            //id: id,
            _token: '{{ csrf_token() }}'
        },

        success: function (response) {
            console.log(response);
           

            $('#id').val(response.contribution_id);
            $("#code").val(response.contribution_code );
            $('#txtNamecontribution').val(response.contribution_title);
            $('#txtDescription').val(response.description);
            $('#txtContribute').val(response.contribute_on_every);
            $('#txtglaccount').val(response.gl_account_no);
          


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
                deletecontribute(id);
            } else {

            }
        }
    });
    $('.bootbox').find('.modal-header').addClass('bg-danger text-white');

}

function deletecontribute(id) {

    $.ajax({
        type: 'DELETE',
        url: '/deletecontribute/' + id,
        data: {
            _token: $('input[name=_token]').val()
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {

        }, success: function (response) {


            if (response.success) {
                $('#modalcontribution').modal('hide');
               
                new Noty({
                    text: 'Successfully deleted',
                    type: 'success',
                }).show();
                allcontributedata()
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


function cbxcontribute(id) {
    var status = $('#contribute').is(':checked') ? 1 : 0;


    $.ajax({
        url: '/cbxcontribute/'+id,
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