

/* ----------data table---------------- */

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
        var table = $('#tbl_memeber_loan').DataTable({
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
                { "data": "number" },
                { "data": "name" },
                { "data": "year" },
                { "data": "month" },
                { "data": "amount" },
               


            ], "stripeClasses": ['odd-row', 'even-row'],
        }); 

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


/* --------------end of data table--------- */
var formData = new FormData();
$(document).ready(function () {
    // Default initialization
    $('.select2').select2();
    getFiltersData();
   getMemberloan();
    $('#cmb_number').on('change', function () {
        getFiltersData();
    });

    $('#cmb_name').on('change', function () {
        getFiltersData();
    });

    $('#cmb_year').on('change', function () {
        getFiltersData();
    });

    $('#cmb_month').on('change', function () {
        getFiltersData();
    });
    var currentYear = new Date().getFullYear();
    var yearDropdown = document.getElementById("cmb_year");

    // Add options for ten years backward and two years forward
    for (var i = currentYear - 10; i <= currentYear + 2; i++) {
        var option = document.createElement("option");
        option.value = i;
        option.text = i;
        yearDropdown.appendChild(option);
    }


    var monthDropdown = document.getElementById("cmb_month");

    // Create an array of month names
    var monthNames = [
        "January", "February", "March", "April", "May", "June", "July",
        "August", "September", "October", "November", "December"
    ];

    // Populate the month options
    for (var i = 0; i < monthNames.length; i++) {
        var option = document.createElement("option");
        option.value =i + 1; // Set the month name as the option value
        option.text = monthNames[i];
        monthDropdown.appendChild(option);
    }
    var currentMonth = monthNames[new Date().getMonth()];
    

});

function getMemberloan() {
    $.ajax({
        url: '/getMemberloan',
        type: 'get',
        dataType: 'json',
        // async: false,


        success: function (response) {
            var members = response.data;
            var membersOptions = "";
            var membersname = "";
            membersOptions += "<option value='0'>Any</option>";
            membersname += "<option value='0'>Any</option>";
        for (var i = 0; i < members.length; i++) {
            membersOptions += "<option value='" + members[i].member_number + "'>" + members[i].member_number + "</option>";
            membersname += "<option value='" + members[i].full_name + "'>" + members[i].full_name + "</option>";
        }

        $('#cmb_number').html(membersOptions);
        $('#cmb_name').html(membersname);
}
    });
}



function getFiltersData() {

formData.append('cmb_number',$('#cmb_number').val());
formData.append('cmb_name',$('#cmb_name').val());
formData.append('cmb_year',$('#cmb_year').val());
formData.append('cmb_month',$('#cmb_month').val());
    $.ajax({
       
        url: '/allmemberloanledgerdata',
        method: 'POST',
        enctype: 'multipart/form-data',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        timeout: 800000,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {

            var dt = response.data;
            console.log(dt);
            var data = [];
            for (i = 0; i < response.data.length; i++) {

                var dt = response.data;



                var data = [];
                for (var i = 0; i < dt.length; i++) {


                    data.push({
                        "number": dt[i].member_number,
                        "name": dt[i].full_name,
                        "year": dt[i].year,
                        "month":dt[i].month,
                        "amount": dt[i].amount,
                       
                    });
                }

               

            }
            var table = $('#tbl_memeber_loan').DataTable();
            table.clear();
            table.rows.add(data).draw();

        },
        error: function (data) {
            console.log(data);
        }, complete: function () {

        }
    });
}