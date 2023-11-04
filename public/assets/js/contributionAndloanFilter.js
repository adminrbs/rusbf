

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
                search: '<span class="me-3"></span> <div style="display: none;" class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                //searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span style="display: none;" class="me-3">Show:</span>',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            }
        });



        // Left and right fixed columns
        var table = $('#tblContribution').DataTable({
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
                    width: 200,
                    targets: 1
                },
                {
                    width: '100%',
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
                { "data": "titel" },
                //{ "data": "month" },
                { "data": "amount" },
               


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

/////////////////////////////////////////   Loan Table        ////////////////////////////////////////////////////


/* ----------data table---------------- */

const DatatableFixedColumns = function () {


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
                search: '<span style="display: none;" class=""></span> <div style="display: none;" class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
               // searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span style="display: none;" class="me-1 mt-2"></span>',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            }
        });



        // Left and right fixed columns
        var table = $('#tblloan').DataTable({
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
                //{ "data": "month" },
                { "data": "amount" },
               


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
    DatatableFixedColumns.init();
});


/* --------------end of data table--------- */
var formData = new FormData();

var nameid = 0;
var memberid = 0;
var subserveid;
$(document).ready(function () {
    $('#tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
   
 
    Fullname(0)
    memberNumber(0);
    computerNumber(0);
    imageloard(0);
    servsubdepartment(0)
   

    $('#cmbmember').change(function () {
        memberid = $(this).val();
        Fullname(memberid);
        computerNumber(nameid);
        servsubdepartment(memberid)
        imageloard(memberid);
        getLoan();
        getcontribution()
       
       // amountset(memberid)
    })

    $('#cmbmembefullname').change(function () {
        nameid = $(this).val();
        servsubdepartment(nameid)
        memberNumber(nameid);
        imageloard(nameid);
        computerNumber(nameid);
        getLoan();
        getcontribution()
        //amountset(memberid);
        subserveid = $('#cmbservsubdepartment').val();
    });
    $('#cmbcomputernum').change(function () {
        nameid = $(this).val();
        servsubdepartment(nameid)
        memberNumber(nameid);
        Fullname(memberid);
        imageloard(memberid);
        getLoan();
        getcontribution()

        
        //amountset(memberid);
        subserveid = $('#cmbservsubdepartment').val();
    });
    






    getLoan()
    getcontribution() 


    // Default initialization
    $('.select2').select2();
    subserveid = $('#cmbservsubdepartment').val();

    $('#cmbservsubdepartment').on('change', function () {
        subserveid = $('#cmbservsubdepartment').val();
        $.ajax({
            url: '/subserveDepartmentmember/' + subserveid,
            type: 'get',
            async: false,
            success: function (response) {
           nameid = response[0].id

            }, error: function (response) {
                console.log(response)
            }
    
        })

        memberNumber(nameid);
        computerNumber(nameid);
        Fullname(nameid);
        imageloard(nameid);
        getcontribution()
        getLoan()
    });
  
    $('#btnleft').on('click', function () {
       //alert(subserveid)
       subserveid -= 1;
       $('#cmbservsubdepartment').val(subserveid).trigger('change');

       getLoan();
       getcontribution()
    });

    $('#btnright').on('click', function () {
        subserveid ++;

       $('#cmbservsubdepartment').val(subserveid).trigger('change');
       getLoan();
       getcontribution()
    });

    $('#cmb_year').on('change', function () {
        getcontribution()
        getLoan()
    });

    $('#cmb_month').on('change', function () {
        getcontribution()
        getLoan()
    });
    var currentYear = new Date().getFullYear();
    var yearDropdown = document.getElementById("cmb_year");

    // Add options for ten years backward and two years forward
    for (var i = currentYear - 5; i <= currentYear + 5; i++) {
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

//////  contribution table ////////////

function getcontribution() {
    formData.append('cmb_year',$('#cmb_year').val());
    formData.append('cmb_month',$('#cmb_month').val());
    $.ajax({
       
        url: "/getcontribution/"+ $('#cmbmember').val(),
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
            for (i = 0; i < dt.length; i++) {

                    data.push({
                        "id": dt[i].contribution_id,
                        "code": dt[i].contribution_code,
                        "titel": dt[i].contribution_title,
                      
                        "amount": dt[i].amount,
                       
                    });
                
               
               

            }
            var table = $('#tblContribution').DataTable();
            table.clear();
            table.rows.add(data).draw();

        },
        error: function (data) {
            console.log(data);
        }, complete: function () {

        }
    });
}


//////  Loan table ////////////

function getLoan() {
    formData.append('cmb_year',$('#cmb_year').val());
    formData.append('cmb_month',$('#cmb_month').val());
   
        $.ajax({
           
           // url: '/getLoan',
            url: "/getLoan/"+ $('#cmbmember').val(),
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
                for (i = 0; i < dt.length; i++) {
                  
                   
                        data.push({
                            "id": dt[i].member_loan_ledger_id,
                            "code": dt[i].loan_code,
                            "name": dt[i].loan_name,
                            "amount": dt[i].amount,
                           
                        });
                   
    
                }
                var table = $('#tblloan').DataTable();
                table.clear();
                table.rows.add(data).draw();
    
            },
            error: function (data) {
                console.log(data);
            }, complete: function () {
    
            }
        });
    }
    


function memberNumber(id) {
    $('#cmbmember').empty();
    $.ajax({
        url: '/memberNumber/' + id,
        type: 'get',
        async: false,
        success: function (data) {
            var htmlContent = "";


            $.each(data, function (key, value) {

                htmlContent += "<option value='" + value.id + "'>" + value.member_number + "</option>";
            });
            $('#cmbmember').html(htmlContent);


        }, error: function (data) {
            console.log(data)
        }

    })

}



function computerNumber(id) {
    $('#cmbcomputernum').empty();
    $.ajax({
        url: '/computerNumber/' + id,
        type: 'get',
        async: false,
        success: function (data) {
            var htmlContent = "";


            $.each(data, function (key, value) {

                htmlContent += "<option value='" + value.id + "'>" + value.computer_number + "</option>";
            });
            $('#cmbcomputernum').html(htmlContent);


        }, error: function (data) {
            console.log(data)
        }

    })

}



function Fullname(id) {

    $('#cmbmembefullname').empty();
    $.ajax({
        url: '/fullName/' + id,
        type: 'get',
        async: false,
        success: function (data) {
            console.log(data);
            var htmlContent = "";


            $.each(data, function (key, value) {

                htmlContent += "<option value='" + value.id + "'>" + value.full_name + "</option>";
            });
            $('#cmbmembefullname').html(htmlContent);

        },
    })
}

function servsubdepartment(id) {

  // $('#cmbservsubdepartment').empty(); 
    $.ajax({
        url: '/subdepartment/' + id,
        type: 'get',
        async: false,
        success: function (data) {
            console.log(data);
            var htmlContent = "";


            $.each(data, function (key, value) {

                htmlContent += "<option value='" + value.id + "'>" + value.name + "</option>";
            });
            $('#cmbservsubdepartment').html(htmlContent);

        },
    })
}




function imageloard(id) {


    if (id == 0 || id == null) {

        var defaultImageUrl = 'images/userimage.png';


        var imageElement = document.getElementById('loadedImage');

        // Set the src attribute to the default image URL
        imageElement.src = defaultImageUrl;
    } else {

        $.ajax({
            url: '/imageloard/' + id,
            type: 'get',
            async: false,
            success: function (response) {

                $.each(response, function (key, value) {

                    var imageElement = document.getElementById('loadedImage');


                    imageElement.src = value.path;
                });


            },
        })
    }

}

function tabalerefresh() {
    var table2 = $('#tblloan').DataTable();
    table2.columns.adjust().draw();
}
function tabalerefresh2() {
    var table2 = $('#tblContribution').DataTable();
    table2.columns.adjust().draw();
}