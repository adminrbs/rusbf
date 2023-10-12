
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
                    width: '100%',
                    targets: 2
                },
                {
                    width: 200,
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
                { "data": "code" },
                { "data": "name" },
                { "data": "amount", className: "editable right-align right-align", },
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
    memberNumber(0);
    computerNumber(0);
    imageloard(0);
    $('input[type="number"]').val('');

    $('#cmbmember').change(function () {
        memberid = $(this).val();
        Fullname(memberid);
        computerNumber(nameid);
        imageloard(memberid);
        allcontributedata(memberid)
        amountset(memberid)
    })

    $('#cmbName').change(function () {
        nameid = $(this).val();

        memberNumber(nameid);
        computerNumber(nameid);
        imageloard(nameid);
        allcontributedata(memberid);
        amountset(memberid);
    });
    $('#cmbcomputer').change(function () {
        nameid = $(this).val();

        memberNumber(nameid);
        Fullname(memberid);
        imageloard(nameid);
        allcontributedata(memberid);
        amountset(memberid);
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


    $('#btnSave').on('click', function () {
        updateContribution();
    });

    $('.datatable-header').hide();
    $('.datatable-footer').hide();

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
        url: "/membercontributedata/" + $('#cmbmember').val(),
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
                    "amount": dt[i].amount,
                    "select": '<label class=""><input data-id="' + dt[i].contribution_id + '" type="checkbox" id="contributionmember" required ' + isChecked + '></label>',

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

function updateContribution() {

    var collection = [];
    var table = document.getElementById("tbl_member_contribution"),
        rows = table.getElementsByTagName('tr'),
        i, j, cells, id;


    for (i = 0, j = rows.length; i < j; ++i) {
        cells = rows[i].getElementsByTagName('td');
        if (!cells.length) {
            continue;
        }

        var checkBox = $($($(cells[3]).children()[0]).children()[0]);

        var status = checkBox.is(':checked') ? 1 : 0;
        if (status == 1) {
            var contribution_id = checkBox.attr('data-id');
            collection.push(JSON.stringify({ "contribution_id": contribution_id, "amount": $(cells[2]).html() }));
        }
    }

    var member = $('#cmbmember option:selected').text();

    if (member == "Select Member Number") {
        new Noty({
            text: 'Select Member',
            type: 'error'
        }).show();
        return;
    }
    formData.append('data', JSON.stringify(collection));
    formData.append('cmbmember', $('#cmbmember').val());



    $.ajax({
        type: "POST",
        url: "/save_memberContribution",
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