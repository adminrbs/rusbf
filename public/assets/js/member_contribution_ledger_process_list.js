

/* ----------data table---------------- */
const DatatableDeliveryPlanFixedColumns = function () {

    // Basic Datatable examples
    const _componentDatatableDeliveryPlanFixedColumns = function () {
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
        $('.datatable-fixed-both-member-contribution').DataTable({
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
                    width: 50,
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
                    "data": "member_number"
                },
                {
                    "data": "full_name"
                },
                {
                    "data": "year",
                    className: "right-align",

                },
                {
                    "data": "month",
                },
                {
                    "data": "amount",
                    className: "right-align",

                }

            ],
            "stripeClasses": ['odd-row', 'even-row'],
        });

    };

    return {
        init: function () {
            _componentDatatableDeliveryPlanFixedColumns();
        }
    }
}();

// Initialize module
document.addEventListener('DOMContentLoaded', function () {
    DatatableDeliveryPlanFixedColumns.init();
});
/* --------------end of data table--------- */


$(document).ready(function () {
    // Default initialization
    $('.select2').select2();
    // End of Default initialization

    getFiltersData();
    getMemberContributions();

    $('#cmb_number').on('change', function () {
        getMemberContributions();
    });

    $('#cmb_name').on('change', function () {
        getMemberContributions();
    });

    $('#cmb_year').on('change', function () {
        getMemberContributions();
    });

    $('#cmb_month').on('change', function () {
        getMemberContributions();
    });
});


function getFiltersData() {

    $.ajax({
        type: 'GET',
        url: '/getMembers',
        success: function (response) {
            var members = response.data.members;
            for (var i = 0; i < members.length; i++) {
                $('#cmb_number').append('<option value="' + members[i].id + '">' + members[i].member_number + '</option>');
                $('#cmb_name').append('<option value="' + members[i].id + '">' + members[i].full_name + '</option>');
            }
            var date = response.data.date;
            for (var i = 2020; i <= date; i++) {
                $('#cmb_year').append('<option value="' + i + '">' + i + '</option>');

            }

            var MONTH_NAME_EN = {
                1: 'january',
                2: 'February',
                3: 'March',
                4: 'April',
                5: 'May',
                6: 'June',
                7: 'July',
                8: 'August',
                9: 'September',
                10: 'October',
                11: 'November',
                12: 'December',
            }
            for (var i = 1; i <= 12; i++) {
                $('#cmb_month').append('<option value="' + i + '">' + MONTH_NAME_EN[i] + '</option>');

            }

        },
        error: function (data) {
            console.log(data);
        }, complete: function () {

        }
    });
}






function getMemberContributions() {
    var filters =
    {
        "member_id": $('#cmb_number').val(),
        "year": $('#cmb_year').val(),
        "month": $('#cmb_month').val()
    };
    $.ajax({
        type: 'GET',
        url: '/getMemberContributions/' + JSON.stringify(filters),
        success: function (response) {
            var result = response.data;


            var table = $('#tbl_memeber_contribution').DataTable();
            table.clear();
            table.rows.add(result).draw();
            $('.editable').attr('contenteditable', true);
        },
        error: function (data) {
            console.log(data);
        }, complete: function () {

        }
    });
}