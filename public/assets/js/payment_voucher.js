$(document).ready(function () {
    // Single picker
    $('.daterange-single').daterangepicker({
        parentEl: '.content-inner',
        singleDatePicker: true,
        locale: {
            format: 'YYYY-MM-DD',
        }
    });
    // End of Single picker
    $('.select2').select2();
    appendTotalAmount(true);
    $('#btnAdd').on('click', function () {
        addPayment();
    });

    $('#btnAction').on('click', function () {
        save();
    });

    $('#txtMemberNumber').on('change',function(){
        var name = getMemberName($(this).val());
        $('#txtName').val(name);
    });
    getMembers();
});

var total_amount = 0;
function addPayment() {
    $('#tblBody tr:last').remove();
    total_amount += parseFloat($('#txtAmount').val());
    var row = '<tr>';
    row += '<td>';
    row += $('#txtDiscription').val();
    row += '</td>';
    row += '<td style="width:100px;text-align:right;">';
    row += parseFloat($('#txtAmount').val()).toFixed(2);
    row += '</td>';
    row += '<td style="width:80px">';
    row += '<button class="btn btn-danger" style="height:30px;" type="button" onclick="removeAmount(this)">Remove</button>';
    row += '</td>';
    row += '</row>';
    $('#tblBody').append(row);

    appendTotalAmount(false);
}


function removeAmount(event) {

    var parent = $(event).parent();
    var row = $(parent).parent();
    var amount = $($($(row)[0]).children()[1]).html();
    total_amount -= parseFloat(amount);
    $(row).remove();
    appendTotalAmount(true);
}


function appendTotalAmount(isRemove) {

    if (isRemove) {
        $('#tblBody tr:last').remove();
    }
    var last_row = '<tr>';
    last_row += '<td style="font-weight:900">';
    last_row += 'Total = ';
    last_row += '</td>';
    last_row += '<td style="width:100px;text-align:right;font-weight:900;">';
    last_row += total_amount.toFixed(2);
    last_row += '</td>';
    last_row += '<td style="width:80px">';
    last_row += '';
    last_row += '</td>';
    last_row += '</row>';
    $('#tblBody').append(last_row);
}



function save() {


    var formData = new FormData();
    formData.append('voucher_number', $('#txtVoucherNumber').val());
    formData.append('voucher_date', $('#txtVoucherDate').val());
    formData.append('ledger_number', $('#txtLedgerNumber').val());
    formData.append('member_number', $('#txtMemberNumber').val());
    formData.append('cheque_number', $('#txtChqueNumber').val());
    formData.append('data', JSON.stringify(getTableData()));


    $.ajax({
        type: 'POST',
        url: '/payment_voucher/save',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {

        },
        success: function (response) {
            console.log(response);
            if (response.status) {
                new Noty({
                    text: 'Payment Voucher saved',
                    type: 'success'
                }).show();
                location.href = '/paymentVoucher';
            }
        },
        error: function (error) {

        },
        complete: function () {

        }

    });
}


function getTableData() {
    var dataArray = [];
    var table = document.getElementById('tblBody'),
        rows = table.getElementsByTagName('tr'),
        i, j, cells, id;

    for (i = 0, j = rows.length; i < (j - 1); ++i) {
        cells = rows[i].getElementsByTagName('td');
        if (!cells.length) {
            continue;
        }

        var valueData = [];
        var object0 = $(cells[0]);
        var object1 = $(cells[1]);
        valueData.push($(object0).text());
        valueData.push($(object1).text());
        dataArray.push(valueData);
    }
    return dataArray;
}




function getMembers() {
    $.ajax({
        type: 'GET',
        url: '/payment_voucher/getMembers',
        success: function (response) {
            var data = response.data;
            for (var i = 0; i < data.length; i++) {
                $('#txtMemberNumber').append('<option value="' + data[i].id + '">' + data[i].member_number + '</option>')
            }
        },
        error: function (data) {
            console.log(data);
        }, complete: function () {

        }
    });
    $('#txtMemberNumber').trigger('change');
}


function getMemberName($member_id) {
    var name = "";
    $.ajax({
        type: 'GET',
        async:false,
        url: '/payment_voucher/getMemberName/'+$member_id,
        success: function (response) {
            console.log(response.data.name_initials);
            name = response.data.name_initials;
        },
        error: function (data) {
            console.log(data);
        }, complete: function () {

        }
    });
    return name;
}