

/* ----------data table---------------- */
const PaymentVoucherFixedColumns = function () {

    // Basic Datatable examples
    const _componentDatatablePaymentVoucherFixedColumns = function () {
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
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': document.dir == "rtl" ? '&larr;' : '&rarr;',
                    'previous': document.dir == "rtl" ? '&rarr;' : '&larr;'
                }
            }

        });

        // Left and right fixed columns
        var table = $('.datatable-fixed-both-payment-voucher').DataTable({
            "createdRow": function (row, data, dataIndex) {
                $(row).css("height", "20px");
            },
            columnDefs: [
                {
                    width: 100,
                    height: 20,
                    targets: 0
                },
                {
                    width: '100%',
                    height: 20,
                    targets: 1,

                },
                {
                    width: 100,
                    height: 20,
                    targets: 2,

                },
                {
                    width: 50,
                    height: 20,
                    targets: 3,

                },
                {
                    width: 100,
                    targets: [4]
                },
                {
                    "targets": '_all',
                    "createdCell": function (td, cellData, rowData, row, col) {
                        $(td).css('padding', '5px');
                    }
                },


            ],
            autoWidth: false,
            scrollX: true,
            scrollY: 400,
            scrollCollapse: false,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 0
            },
            "pageLength": 100,
            "order": [],
            "columns": [
                {
                    "data": "date"
                },
                {
                    "data": "name"
                },
                {
                    "data": "cheque"
                },
                {
                    "data": "amount",
                    className: "right-align",
                },
                {
                    "data": "action",

                }

            ],
            "stripeClasses": ['odd-row', 'even-row'],
        });

        // Adjust columns on window resize
        setTimeout(function () {
            $(window).on('resize', function () {
                table.columns.adjust();
            });
        }, 100);

    };

    return {
        init: function () {
            _componentDatatablePaymentVoucherFixedColumns();
        }
    }
}();

// Initialize module
document.addEventListener('DOMContentLoaded', function () {
    PaymentVoucherFixedColumns.init();
});
/* --------------end of data table--------- */


$(document).ready(function () {
    allVouchers();
});


function allVouchers() {

    $.ajax({
        type: "GET",
        url: "/payment_voucher/all_vouchers",
        cache: false,
        timeout: 800000,
        beforeSend: function () { },
        success: function (response) {
            console.log(response);
            var dt = response.data;
            var data = [];
            for (var i = 0; i < dt.length; i++) {

                data.push({
                    "date": dt[i].voucher_date,
                    "name": dt[i].name_initials,
                    "cheque": dt[i].cheque_number,
                    "amount": dt[i].amount,
                    "action": '<button class="btn btn-warning"><i class="fa fa-print" aria-hidden="true"></i></button>',
                });
            }

            var table = $('#tbl_payment_voucher').DataTable();
            table.clear();
            table.rows.add(data).draw();

        },
        error: function (error) {
            console.log(error);
        },
        complete: function () { }
    })


}


function add_payment_voucher(){
    location.href = '/paymentVoucher';
}

