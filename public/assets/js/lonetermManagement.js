

const DatatableFixedColumnsterm = function () {


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
        var table = $('#lonetermTable').DataTable({
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
                    width: 50,
                    targets: 1
                },
                {
                    width: 100,
                    targets: [2]
                }, {
                    width: 50,
                    targets: 3
                }, {
                    width: '100%',
                    targets: 4
                },




            ],
            scrollX: true,
            /* scrollY: 350, */
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            },
            "pageLength": 300,
            "order": [],
            "columns": [
                { "data": "loan_term_id" },
                //{ "data": "lone_id" },
                { "data": "nuofterm" },
                { "data": "termamount" },
                { "data": "terminterestamount" },
                { "data": "terminterestpresantage" },
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
    DatatableFixedColumnsterm.init();
});








var formData = new FormData();
let loanterm_id;
var lontr = undefined;
var loneamount;
$(document).ready(function () {
    //lonetermAllData();
    $('#btnaddTerm').on('click', function () {
        $('#btnSavetermlone').show();
        $('#btnUpdatetermlone').hide();
        $('#id').val('');
        $("#txtloneterm").val('');
        $("#txttermAmount").val('');
        $("#txtinteresttermAmount").val('');
        $("#txtrempresenttage").val('');
        $("#txttermremaks").val('');
    });


    $('#loneTable').on('click', 'tr', function (e) {
        $('#loneTable tr').removeClass('selected');

        $(this).addClass('selected');
        var hiddenValue = $(this).find('td:eq(0)');
        var childElements = hiddenValue.children(); // or hiddenValue.find('*');
        childElements.each(function () {

            lontr = $(this).attr('data-id');
            lonetermAllData(lontr);
            getloneAllData(lontr);




        });
    });



    $('#btnSavetermlone').on('click', function (e) {

        lonetermsave(lontr);
    });
    $(document).on('click', '.lonmtermodel', function (e) {
        loanterm_id = $(this).attr('id');

        getloneterm(loanterm_id);

    });
    $(document).on('click', '.lontermviewe', function (e) {

        loanterm_id = $(this).attr('id');

        getlonetermview(loanterm_id);
    });
    $('#btnUpdatetermlone').on('click', function (e) {

        updateloneterm(loanterm_id);
    });
    $('#btnlontermclose').on('click', function (e) {
        $('#loneTermModel').modal('hide');

    });
    $('#btnclose').on('click', function (e) {
        $('#loneModel').modal('hide');

    });




    $('#txttermAmount').on('input', function () {

        var typedAmount = $(this).val();
        //Term_Interest_amount/loan_amount) * 100
        // var interestpresent = (typedAmount / loneamount) * 100


        var interespresent = (typedAmount / loneamount) * 100
        var present = interespresent.toFixed(2);
        //$('#txtinteresttermAmount').val(interestamount);
        // $('#txtrempresenttage').val(present);

    });

    $('#txtinteresttermAmount').on('input', function () {
        if (loneamount == undefined) {
            new Noty({
                text: 'Select loan',
                type: 'warning'
            }).show();
            $('#txtinteresttermAmount').val('');
        } else {
            var typedInterestAmount = $(this).val();
            var interespresent = (typedInterestAmount / loneamount) * 100
            var present = interespresent.toFixed(2);
            //$('#txtinteresttermAmount').val(interestamount);
            $('#txtrempresenttage').val(present);
        }


        /*var amount = ( typedInterestAmount/loneamount)*100
  
        var inerespresent = (amount / loneamount) * 100
        var present =inerespresent.toFixed(2);
        $('#txttermAmount').val(amount);
        $('#txtrempresenttage').val(present);*/

    });


    $('#txtrempresenttage').on('input', function () {
        if (loneamount == undefined) {
            new Noty({
                text: 'Select loan',
                type: 'warning'
            }).show();
            $('#txtrempresenttage').val('');
        } else {
            var typedInterestpresentage = $(this).val();
            //(loan_amount/100)*Interest_percentage
            var interestamounv = (loneamount / 100) * typedInterestpresentage
            var inerestAmount = interestamounv.toFixed(2);
            $('#txtinteresttermAmount').val(inerestAmount);
        }


    });

});




function lonetermsave(id) {


    if (id == null || id == undefined) {
        showWarningMessage("Select loan")

        new Noty({
            text: 'Select loan',
            type: 'warning'
        }).show();
    } else {

        formData.append('txtloneterm', $('#txtloneterm').val());
        formData.append('txttermAmount', $('#txttermAmount').val());
        formData.append('txtinteresttermAmount', $('#txtinteresttermAmount').val());
        formData.append('txtrempresenttage', $('#txtrempresenttage').val());
        formData.append('txttermremaks', $('#txttermremaks').val());


        console.log(formData);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: '/lonetermsave/' + id,
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

                $('#loneTermModel').modal('hide');
                lonetermAllData(id)
                //lonetermAllData()
                if (response.status) {

                    new Noty({
                        text: 'Successfully saved',
                        type: 'success',
                    }).show();

                    console.log(response);
                } else {

                    new Noty({
                        text: 'Something went wrong',
                        type: 'error'
                    }).show();
                    $('#loneTermModel').modal('hide');
                }

            },
            error: function (error) {
                showErrorMessage('Something went wrong');
                $('#loneTermModel').modal('hide');
                console.log(error);

            },
            complete: function () {

            }

        });
    }

}


function getloneAllData(id) {

    $.ajax({
        type: "GET",
        url: "/getloneAllData/" + id,
        cache: false,
        timeout: 800000,
        beforeSend: function () { },
        success: function (response) {

            loneamount = response.amount



        },
        error: function (error) {
            console.log(error);
        },
        complete: function () { }
    })


}
function lonetermAllData(id) {

    $.ajax({
        type: "GET",
        url: "/lonetermAllData/" + id,
        cache: false,
        timeout: 800000,
        beforeSend: function () { },
        success: function (response) {

            var dt = response.data;
            console.log(dt);
            disabled = "disabled";

            var data = [];
            for (var i = 0; i < dt.length; i++) {



                data.push({
                    "loan_term_id": dt[i].loan_term_id,
                    // "lone_id": dt[i].loan_code,
                    "nuofterm": dt[i].no_of_terms,
                    "termamount": dt[i].term_amount,
                    "terminterestamount": dt[i].term_interest_amount,
                    "terminterestpresantage": dt[i].term_interest_precentage,
                    "remark": dt[i].remarks,
                    "action": '<button title="Edit" class="btn btn-primary  btn-sm lonmtermodel" data-bs-toggle="modal" data-bs-target="#loneTermModel" id="' + dt[i].loan_term_id + '"><i class="ph-pencil" aria-hidden="true"></i></button>&#160<button title="View" class="btn btn-success btn-sm lontermviewe" data-bs-toggle="modal" data-bs-target="#loneTermModel" id="' + dt[i].loan_term_id + '"><i class="ph-eye" aria-hidden="true"></i></button>&#160<button title="Delete" class="btn btn-danger btn-sm" onclick="_deleteterm(' + dt[i].loan_term_id + ')"><i class="ph-trash" aria-hidden="true"></i></button>',
                });
            }


            var table = $('#lonetermTable').DataTable();
            table.clear();
            table.rows.add(data).draw();

        },
        error: function (error) {
            console.log(error);
        },
        complete: function () { }
    })


}
function getloneterm(id) {

    $.ajax({
        url: '/getloneterm/' + id,
        method: 'get',
        data: {
            //id: id,
            _token: '{{ csrf_token() }}'
        },

        success: function (response) {

            $('#btnSavetermlone').hide();
            $('#btnUpdatetermlone').show();

            $('#id').val(response.loan_term_id);
            $("#txtloneterm").val(response.no_of_terms);
            $('#txttermAmount').val(response.term_amount);
            $('#txtinteresttermAmount').val(response.term_interest_amount);
            $('#txtrempresenttage').val(response.term_interest_precentage);
            $('#txttermremaks').val(response.remarks);


        }
    });
}



function getlonetermview(id) {

    $.ajax({
        url: '/getloneterm/' + id,
        method: 'get',
        data: {
            //id: id,
            _token: '{{ csrf_token() }}'
        },

        success: function (response) {

            $('#btnSavetermlone').hide();
            $('#btnUpdatetermlone').hide();

            $('#id').val(response.loan_term_id);
            $("#txtloneterm").val(response.no_of_terms);
            $('#txttermAmount').val(response.term_amount);
            $('#txtinteresttermAmount').val(response.term_interest_amount);
            $('#txtrempresenttage').val(response.term_interest_precentage);
            $('#txttermremaks').val(response.remarks);


        }
    });
}
function updateloneterm(id) {


    formData.append('txtloneterm', $('#txtloneterm').val());
    formData.append('txttermAmount', $('#txttermAmount').val());
    formData.append('txtinteresttermAmount', $('#txtinteresttermAmount').val());
    formData.append('txtrempresenttage', $('#txtrempresenttage').val());
    formData.append('txttermremaks', $('#txttermremaks').val());



    console.log(formData);
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: '/updateloneterm/' + id,
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

            $('#loneTermModel').modal('hide');
            lonetermAllData(id)


            new Noty({
                text: 'Successfully saved',
                type: 'success',
            }).show();


        },
        error: function (error) {
            showErrorMessage('Something went wrong');

            console.log(error);

        },
        complete: function () {

        }

    });

}


function _deleteterm(id) {

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
                deleteloneterm(id);
            } else {

            }
        }
    });
    $('.bootbox').find('.modal-header').addClass('bg-danger text-white');

}

function deleteloneterm(id) {

    $.ajax({
        type: 'DELETE',
        url: '/deleteloneterm/' + id,
        data: {
            _token: $('input[name=_token]').val()
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {

        }, success: function (response) {


            if (response.success) {
                $('#loneTermModel').modal('hide');

                new Noty({
                    text: 'Successfully deleted',
                    type: 'success',
                }).show();
                lonetermAllData(id)
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

