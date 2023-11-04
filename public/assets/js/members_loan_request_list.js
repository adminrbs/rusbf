


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
                    width: 100,
                    targets: 1
                },
                {
                    width: 200,
                    targets: [2]
                },
                
                {
                    width: '100%',
                    targets: 3
                },
                {
                    width: 100,
                    targets: 3
                },

            ],
            scrollX: true,
            //  scrollY: 350, 
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            },
            "pageLength": 100,
            "order": [],
            "columns": [
                { "data": "id" },
                { "data": "membeshipno" },
                { "data": "contactno" },
                //{ "data": "nic" },
                { "data": "paddress" },
                { "data": "approvalStatus" },
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


$(document).ready(function () {
    allmemberlonrequest();

});


function allmemberlonrequest() {
    $.ajax({
        type: 'GET',
        url: '/allmemberlonrequest',
        success: function (response) {

            var dt = response.data;
            console.log(dt);
            var data = [];
            for (i = 0; i < response.data.length; i++) {

                var dt = response.data;



                var data = [];
                for (var i = 0; i < dt.length; i++) {

                    var label_approval;
                    var disableButtons = false; 
                
                    if (dt[i].approval_status == 1) {
                        label_approval = '<label class="badge badge-pill bg-success">Approved</label>';
                        disableButtons = true; 
                    } else if (dt[i].approval_status == 2) {
                        label_approval = '<label class="badge badge-pill bg-danger">Rejected</label>';
                        disableButtons = true; 
                    } else {
                        label_approval = '<label class="badge badge-pill bg-warning">Pending</label>';
                    }

                    data.push({
                        "id": dt[i].members_loan_request_id,
                        "membeshipno": dt[i].membership_no,
                        "contactno": dt[i].contact_no,
                        //"nic": dt[i].nic_no,
                        "paddress": dt[i].private_address,
                        "approvalStatus": label_approval,
                        //"status": '<label class="form-check form-switch"><input type="checkbox"  class="form-check-input" name="switch_single" id="contribute" value="1" onclick="cbxcontribute(' + dt[i].members_loan_request_id + ')" required ' + isChecked + '></label>',
                        "action": '<button title="Edit" class="btn btn-primary btn-sm" onclick="edit(' + dt[i].members_loan_request_id + ')" ' + (disableButtons ? 'disabled' : '') + '><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>&#160<button title="View" class="btn btn-success btn-sm"  onclick="view(' + dt[i].members_loan_request_id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>&#160<button title="Delete" class="btn btn-danger btn-sm" onclick="_delete(' + dt[i].members_loan_request_id + ')" ' + (disableButtons ? 'disabled' : '') + '><i class="fa fa-trash" aria-hidden="true"></i></button>',
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

function edit(id) {

    var url = "/members_loan_form?id=" + id + "&action=edit";
    window.open(url, "_blank");

}

function view(id) {
    var url = "/members_loan_form?id=" + id + "&action=view";
    window.open(url, "_blank");
}


function Approval(id){
    
    url = "/members_loan_form?id=" + id +"&action=approval";
    window.open(url, "_blank");
   
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
                deletememberlone(id);
            } else {

            }
        }
    });
    $('.bootbox').find('.modal-header').addClass('bg-danger text-white');

}

function deletememberlone(id) {

    $.ajax({
        type: 'DELETE',
        url: '/deletememberlone/' + id,
        data: {
            _token: $('input[name=_token]').val()
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {

        }, success: function (response) {


            if (response.success) {
                $('#modalmemberlonrequest').modal('hide');

                new Noty({
                    text: 'Successfully deleted',
                    type: 'success',
                }).show();
                allmemberlonrequest()
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
