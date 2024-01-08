
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










var element;
var nameid = 0;
var memberid = 0;
var formData = new FormData();
$(document).ready(function () {
    $('.select2').select2();
    var mi = $('#cmbmember').val()


    // Fullname(0)
    memberNumber(0);
    //  computerNumber(0);
    imageloard(0);
    $('input[type="number"]').val('');

    $('#cmbmember').change(function () {
        memberid = $(this).val();
        memberNumber(memberid);
        // Fullname(memberid);
        // computerNumber(memberid);
        imageloard(memberid);
        allcontributedata(memberid)
        amountset(memberid)
    })

    $('#cmbName').change(function () {
        nameid = $(this).val();

        memberNumber(nameid);
        // computerNumber(nameid);
        imageloard(nameid);
        allcontributedata(nameid);
        amountset(nameid);
    });
    $('#cmbcomputer').change(function () {
        var computre = $(this).val();

        memberNumber(computre);
        // Fullname(computre);
        imageloard(computre);
        allcontributedata(computre);
        amountset(computre);
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

    // $('#cmbmember').empty();
    $.ajax({
        url: '/computerNumber/' + id,
        type: 'get',
        async: false,
        success: function (data) {

            var dt = data


            allcontributedata(dt[0].id);
            var htmlContent;
            var htmlContent1;
            var htmlContent2;


            $.each(data, function (key, value) {

                htmlContent += "<option value='" + value.id + "'>" + value.member_number + "</option>";
                htmlContent1 += "<option value='" + value.id + "'>" + value.computer_number + "</option>";
                htmlContent2 += "<option value='" + value.id + "'>" + value.full_name + "</option>";
            });
            $('#cmbmember').html(htmlContent);
            $('#cmbcomputer').html(htmlContent1);
            $('#cmbName').html(htmlContent2);


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
                var amountDivId = "amountDiv_" + dt[i].contribution_id;

                data.push({
                    "id": dt[i].contribution_id,
                    "code": dt[i].contribution_code,
                    "name": dt[i].contribution_title,
                    "amount": `<div id="${amountDivId}" onclick="typeamount(this, '${dt[i].contribution_id}', '${dt[i].amount}')" class="amountDiv">${dt[i].amount}</div>`,

                    "select": `<label class=""><input data-id="${dt[i].contribution_id}" type="checkbox" id="${checkboxId}" required ${isChecked} onchange="checkboxChanged(this)"></label>`,

                });//dt[i].amount
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

function typeamount(element, contributionId, typamount) {
    element = element
    $(element).dblclick();

    // Select the text content inside the element
    if (window.getSelection) {
        var range = document.createRange();
        range.selectNodeContents(element);
        var selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
    } else if (document.body.createTextRange) {
        var range = document.body.createTextRange();
        range.moveToElementText(element);
        range.select();
    }
}
function checkboxChanged(checkbox) {
    var contributionId = checkbox.getAttribute("data-id");
    var amount = parseFloat($("#amountDiv_" + contributionId).text());

    if (amount === 0) {
        // If the amount is zero, uncheck the checkbox
        $('#' + checkbox.id).prop('checked', false);
    }

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
            if (response.massage == "notsave") {
                new Noty({
                    text: '0 not saved',
                    type: 'success'
                }).show();
            } else {
                new Noty({
                    text: 'Successfully saved',
                    type: 'success'
                }).show();
            }




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