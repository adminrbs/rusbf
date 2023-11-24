
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
        var table = $('#memberTable').DataTable({
            columnDefs: [
                {
                    width: 50,
                    targets: 0
                },
                {
                    width: 100,
                    targets: 1
                },
                {
                    width: 200,
                    targets: 2
                },
                {
                    width: '100%',
                    targets: 3
                }





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
                { "data": "id" },
                { "data": "name" },
                { "data": "terms" },
                //{ "data": "amount", className: "editable right-align right-align", },
                { "data": "amount"},
                { "data": "percetage"},
                { "data": "select" },


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











var nameid = 0;
var memberid = 0;
var formData = new FormData();
$(document).ready(function () {
    $('.select2').select2();
    allcontributedata(0);
   /* Fullname(0)
    memberNumber(0);
    computerNumber(0);*/
    memberShip(0);
    imageloard(0);
    $('input[type="number"]').val('');

    $('#cmbmember').change(function () {
        memberid = $(this).val();

        /*Fullname(memberid);
        computerNumber(nameid);*/
        imageloard(memberid);
        allcontributedata(memberid)
        memberShip(memberid)
       // amountset(memberid)
    })

    $('#cmbName').change(function () {
        nameid = $(this).val();

        // memberNumber(nameid);
        // computerNumber(nameid);
        imageloard(nameid);
        allcontributedata(memberid);
        memberShip(nameid)
        //amountset(memberid);
    });
    $('#cmbcomputer').change(function () {
        nameid = $(this).val();
        memberShip(nameid)

        // memberNumber(nameid);
        // Fullname(memberid);
        imageloard(nameid);
        allcontributedata(memberid);
        //amountset(memberid);
    });
    

    $('.datatable-header').hide();
    $('.datatable-footer').hide();


});

/*
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
    $('#cmbcomputer').empty();
    $.ajax({
        url: '/computerNumber/' + id,
        type: 'get',
        async: false,
        success: function (data) {
            var htmlContent = "";


            $.each(data, function (key, value) {

                htmlContent += "<option value='" + value.id + "'>" + value.computer_number + "</option>";
            });
            $('#cmbcomputer').html(htmlContent);


        }, error: function (data) {
            console.log(data)
        }

    })

}



function Fullname(id) {

    $('#cmbName').empty();
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
            $('#cmbName').html(htmlContent);

        },
    })
}*/




function memberShip(id) {
    var mid = id
        $.ajax({
            url: '/memberNumber/' + id,
            type: 'get',
            dataType: 'json',
            // async: false,
    
    
            success: function (response) {

    if(mid>0){
       // $('#cmbnameinfull').html('');
        $('#cmbmember').html('');
        $('#cmbcomputer').html('');
        $('#cmbName').html('');
    
        var dt = response;
    
        for (var i = 0; i < dt.length; i++) {
    
           // $('#cmbnameinfull').append("<option value='" + dt[i].id + "'>" + dt[i].full_name + "</option>");
            $('#cmbmember').append("<option value='" + dt[i].id + "'>" + dt[i].member_number + "</option>");
            $('#cmbcomputer').append("<option value='" + dt[i].id + "'>" + dt[i].computer_number + "</option>");
             $('#cmbName').append("<option value='" + dt[i].id + "'>" + dt[i].full_name + "</option>");
    
        }
     
    
    }else{
    
    
        var dt = response
    
       // var cmbnameinfull = "<option value='0'>Select Name In Full</option>";
        var cmbmember = "<option value='0'>Select Member Number</option>";
        var cmbcomputer = "<option value='0'>Select Computer Number</option>";
        var cmbName = "<option value='0'>Select Full Name</option>";
    
    
        for (var i = 0; i < dt.length; i++) {
           // console.log(dt[i].full_name);
          ///  cmbnameinfull += "<option value='" + dt[i].id + "'>" + dt[i].full_name + "</option>";
          cmbmember += "<option value='" + dt[i].id + "'>" + dt[i].member_number + "</option>";
          cmbcomputer += "<option value='" + dt[i].id + "'>" + dt[i].computer_number + "</option>";
          cmbName += "<option value='" + dt[i].id + "'>" + dt[i].full_name + "</option>";
        }
    
        // Set the HTML content of the select elements after the loop
       // $('#cmbnameinfull').html(cmbnameinfull);
        $('#cmbmember').html(cmbmember);
        $('#cmbcomputer').html(cmbcomputer);
        $('#cmbName').html(cmbName);
    
    }     
               
    
            }, error: function (data) {
                console.log(data)
            }
    
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


function allcontributedata(id) {

    $.ajax({
        type: "GET",
        url: "/memberloandata/"+ $('#cmbmember').val(),
        cache: false,
        timeout: 800000,
        beforeSend: function () { },
        success: function (response) {

            var dt = response.data;
            console.log("table", dt);
            disabled = "disabled";

            var data = [];
            for (var i = 0; i < dt.length; i++) {
                //var memberidch = dt[i].member_id;

                // Check the condition and set the checkbox status accordingly

                var isChecked = dt[i].status == 1 ? "checked" : "";
                data.push({
                    "id": dt[i].member_loan_id ,
                    "name": dt[i].loan_name,
                    "terms": dt[i].no_of_terms,
                    "amount": dt[i].amount,
                    "percetage": dt[i].term_interest_precentage,
                    "select": '<label class="form-check form-switch"><input type="checkbox"  class="form-check-input" name="switch_single" id="cbxmemberloan" value="1" onclick="memberlonecbx(' + dt[i].member_loan_id  + ')" required ' + isChecked + '></label>',

                });
            }
        
            var table = $('#memberTable').DataTable();
            table.clear();
            table.rows.add(data).draw();
            $('.editable').attr('contenteditable', true);

        },
        error: function (error) {
            console.log(error);
        },
        complete: function () { }
    })


}


function memberlonecbx(id) {
    var status = $('#cbxmemberloan').is(':checked') ? 1 : 0;


    $.ajax({
        url: '/memberlonestatus/' + id,
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