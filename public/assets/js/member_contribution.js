
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
            "pageLength": 300,
            "order": [],
            "columns": [
                { "data": "id" },
                { "data": "code" },
                { "data": "name" },

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
    Fullname(0)
    memberNumber(0)
    imageloard(0);
    $('input[type="number"]').val('');

    $('#cmbmember').change(function () {
        memberid = $(this).val();
        Fullname(memberid)
        imageloard(memberid);
        allcontributedata(memberid)
        amountset(memberid)
    })

    $('#cmbName').change(function () {
        nameid = $(this).val();

        memberNumber(nameid)
        imageloard(nameid)
        allcontributedata(memberid)
        amountset(memberid)
    });
    $('input[type="checkbox"]').on('change', function () {
        if ($(this).is(':checked')) {
            var checkbox_id = $(this).attr('id');
            //cbxcontribution(checkbox_id)

        } else {
            var checkboxd_id = $(this).attr('id');
            // deleteMembercontribution(checkboxd_id)
        }
    });
    //allcontributedata(memberid);

});


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


//loading location
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
        url: "/membercontributedata/" + id,
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

                var isChecked = dt[i].member_id > 0 ? "checked" : "";
                var checkboxId = "contributionmember_" + dt[i].contribution_id;
                data.push({
                    "id": dt[i].contribution_id,
                    "code": dt[i].contribution_code,
                    "name": dt[i].contribution_title,
                    //"select": '<label class="form-check form-switch"><input type="checkbox"  id="' + dt[i].contribution_id + '"   required ' + isChecked + '  ></label>',
                    "select": '<label class=""><input type="checkbox" onclick="contribution(' + dt[i].contribution_id + ', this)" id="contributionmember" required ' + isChecked + '></label>',

                });
            }


            var table = $('#memberTable').DataTable();
            table.clear();
            table.rows.add(data).draw();

        },
        error: function (error) {
            console.log(error);
        },
        complete: function () { }
    })


}

function cbxcontribution(id) {

    var txtamount = $('#txtamount').val();
    var memberid = $('#cmbmember').val();
    formData.append('txtamount', $('#txtamount').val());
    formData.append('cmbmember', $('#cmbmember').val());


    if (memberid > 0) {
        if (txtamount == "") {
            $('input[type="checkbox"]').prop('checked', false);
            new Noty({
                text: 'Enter Amount',
                type: 'warning'
            }).show();
        } else {


            $.ajax({
                type: "POST",
                url: "/save_memberContribution/" + id,
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
                    //suplyGroupAllData();


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

            });
        }
    } else {
        //$('input[type="checkbox"]').prop('checked', false);
        new Noty({
            text: 'Select Member',
            type: 'error'
        }).show();

    }

}


function deleteMembercontribution(id) {
    var member_id = memberid
    $.ajax({
        type: 'post',
        url: '/deleteMembercontribution/' + id,
        data: {
            _token: $('input[name=_token]').val(),
            member_id: member_id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {

        }, success: function (response) {


            if (response.success) {


                new Noty({
                    text: 'Successfully deleted',
                    type: 'success',
                }).show();

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

function contribution(id, event) {


    var status = $(event).is(':checked') ? 1 : 0;

    if (status == 1) {
        //alert("save")
        cbxcontribution(id);
    } else {
        deleteMembercontribution(id);
        //alert("0kk")
    }

}

function amountset(id) {

    $.ajax({
        url: '/amountset/' + id,
        method: 'get',

        success: function (response) {
            if (response.length <= 0) {
                $('#txtamount').prop('disabled', false);
                $('#txtamount').val('');
            } else {



                if (Array.isArray(response) && response.length > 0) {
                    var firstObject = response[0];

                    if ('amount' in firstObject) {
                        var amountValue = firstObject.amount;

                        $('#txtamount').val(amountValue);
                        $('#txtamount').prop('disabled', true);






                        console.log(amountValue);
                    }
                }
            }


        }
    });
}