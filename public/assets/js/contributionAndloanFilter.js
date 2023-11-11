
var formData = new FormData();

var nameid = 0;
var memberid = 0;
var subserveid;
var COMPUTER_NUMBER = [];
var MEMBER_NUMBER = [];
var FULL_NAME = [];

$(document).ready(function () {
    $('#tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    // Default initialization
    $('.select2').select2();


    $('#cmbmember').change(function () {
        var id = $(this).val();
        servsubdepartment(id);
        computerNumber(id);
        Fullname(id);
        imageloard(id);
        loadContribution();
        loadLoan();

    })


    $('#cmbcomputernum').change(function () {
        var id = $(this).val();
        memberNumber(id);
        servsubdepartment(id);
        Fullname(id);
        imageloard(id);
        loadContribution();
        loadLoan();
    });


    $('#cmbservsubdepartment').on('change', function () {
        var id = $(this).val();
        computerNumber(id);
        memberNumber(id);
        Fullname(id);
        imageloard(id);
        loadContribution();
        loadLoan();

    });


    $('#cmbmembefullname').change(function () {
        var id = $(this).val();
        computerNumber(id);
        memberNumber(id);
        servsubdepartment(id);
        imageloard(id);
        loadContribution();
        loadLoan();
    });

    $('#btnleft').on('click', function () {

        var row = $('#tblContribution').find('tr');
        for (var i = 0; i < row.length; i++) {

            var cell = $(row[i]).find('td');
            var settlement = $($(cell[2]).children()[0]);
            if (settlement.attr('data-edited') == "true") {
                showConfirmation("Previous");
                return;
            }

        }

        var row = $('#tblLoan').find('tr');
        for (var i = 0; i < row.length; i++) {

            var cell = $(row[i]).find('td');
            var settlement1 = $($(cell[2]).children()[0]);
            var settlement2 = $($(cell[4]).children()[0]);
            if (settlement1.attr('data-edited') == "true" || settlement2.attr('data-edited') == "true") {
                showConfirmation("Previous");
                return;
            }

        }


        previous($('#cmbservsubdepartment').val(), $('#cmbmember').val());


    });

    $('#btnright').on('click', function () {
        var row = $('#tblContribution').find('tr');
        for (var i = 0; i < row.length; i++) {

            var cell = $(row[i]).find('td');
            var settlement = $($(cell[2]).children()[0]);
            if (settlement.attr('data-edited') == "true") {
                showConfirmation("Next");
                return;
            }

        }


        var row = $('#tblLoan').find('tr');
        for (var i = 0; i < row.length; i++) {

            var cell = $(row[i]).find('td');
            var settlement1 = $($(cell[2]).children()[0]);
            var settlement2 = $($(cell[4]).children()[0]);
            if (settlement1.attr('data-edited') == "true" || settlement2.attr('data-edited') == "true") {
                showConfirmation("Next");
                return;
            }

        }

        next($('#cmbservsubdepartment').val(), $('#cmbmember').val());


    });

    $('#cmb_year').on('change', function () {
        loadContribution();
        loadLoan();
    });

    $('#cmb_month').on('change', function () {
        loadContribution();
        loadLoan();
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
        option.value = i + 1; // Set the month name as the option value
        option.text = monthNames[i];
        monthDropdown.appendChild(option);
    }
    var currentMonth = monthNames[new Date().getMonth()];




    $('#btnsave').on('click', function () {
        var is_edited_contribution = false;
        var contribution_row = $('#tblContribution').find('tr');
        for (var i = 0; i < contribution_row.length; i++) {

            var cell = $(contribution_row[i]).find('td');
            var settlement = $($(cell[2]).children()[0]);
            if (settlement.attr('data-edited') == "true") {
                is_edited_contribution = true;
                break;
            }

        }
        if (is_edited_contribution) {
            saveContribution();
        }


        var is_edited_loan = false;
        var loan_row = $('#tblLoan').find('tr');
        for (var i = 0; i < loan_row.length; i++) {

            var cell = $(loan_row[i]).find('td');
            var settlement1 = $($(cell[2]).children()[0]);
            var settlement2 = $($(cell[4]).children()[0]);
            if (settlement1.attr('data-edited') == "true" || settlement2.attr('data-edited') == "true") {
                is_edited_loan = true;
                break;
            }

        }

        if (is_edited_loan) {
            saveLoan();
        }
    });


    getGlobalYearMonth();
    servsubdepartment(null);
    computerNumber(null);
    memberNumber(null);
    Fullname(null);
    loadContribution();
    loadLoan();

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





function memberNumber(member_id) {

    $('#cmbmember').empty();
    $.ajax({
        url: '/memberNumber/' + $('#cmbservsubdepartment').val(),
        type: 'get',
        async: false,
        success: function (data) {
            MEMBER_NUMBER = data;
            appendMemberNumber(MEMBER_NUMBER);
            if (member_id != null && member_id != 0) {
                $('#cmbmember').val(member_id);
            }


        }, error: function (data) {
            console.log(data)
        }

    })

}

function appendMemberNumber(data) {
    if (data.length > 0) {
        var htmlContent = "";
        $.each(data, function (key, value) {
            htmlContent += "<option value='" + value.id + "'>" + value.member_number + "</option>";
        });
        $('#cmbmember').html(htmlContent);
    }
}



function computerNumber(member_id) {

    $.ajax({
        url: '/computerNumber/' + $('#cmbservsubdepartment').val(),
        type: 'get',
        async: false,
        success: function (data) {
            COMPUTER_NUMBER = data;
            appendComputerNumber(COMPUTER_NUMBER);
            if (member_id != null && member_id != 0) {
                $('#cmbcomputernum').val(member_id);
            }
        }, error: function (data) {
            console.log(data)
        }

    })

}

function appendComputerNumber(data) {
    if (data.length > 0) {
        var htmlContent = "";
        $.each(data, function (key, value) {

            htmlContent += "<option value='" + value.id + "'>" + value.computer_number + "</option>";
        });
        $('#cmbcomputernum').html(htmlContent);
    }
}



function Fullname(member_id) {

    $.ajax({
        url: '/fullName/' + $('#cmbservsubdepartment').val(),
        type: 'get',
        async: false,
        success: function (data) {
            console.log(data);
            FULL_NAME = data;
            appendFullName(FULL_NAME);
            if (member_id != null && member_id != 0) {
                $('#cmbmembefullname').val(member_id);
            }

        },
    })
}


function appendFullName(data) {
    if (data.length > 0) {
        var htmlContent = "";
        $.each(data, function (key, value) {
            htmlContent += "<option value='" + value.id + "'>" + value.full_name + "</option>";
        });
        $('#cmbmembefullname').html(htmlContent);
    }
}

function servsubdepartment(member_id) {

    $('#cmbservsubdepartment').empty();
    $.ajax({
        url: '/member_subdepartment',
        type: 'get',
        async: false,
        success: function (data) {
            console.log(data);
            var htmlContent = "";


            $.each(data, function (key, value) {

                htmlContent += "<option value='" + value.id + "'>" + value.name + "</option>";
            });
            $('#cmbservsubdepartment').html(htmlContent);
            if (member_id != null && member_id != 0) {
                $('#cmbservsubdepartment').val(member_id);
            }
        },
    })
}




function imageloard(id) {

    var defaultImageUrl = 'images/userimage.png';


    $('#loadedImage').attr('src', defaultImageUrl);
    if (id == 0 || id == null) {

       
    } else {

        $.ajax({
            url: '/imageloard/' + id,
            type: 'get',
            async: false,
            success: function (response) {

                $('#loadedImage').attr('src', response.path);


            },
        })
    }

}



function getGlobalYearMonth() {
    $.ajax({
        type: "GET",
        url: '/getGlobalYearMonth',
        async: false,
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {

        },
        success: function (response) {
            console.log(response);
            $('#cmb_year').val(response.year);
            $('#cmb_month').val(response.month);

        },
        error: function (error) {
            console.log(error);

        },
        complete: function () {

        }

    });
}


function loadContribution() {
    $.ajax({
        type: "GET",
        url: '/loadContribution/' + $('#cmb_year').val() + "/" + $('#cmb_month').val() + "/" + $('#cmbmember').val(),
        async: false,
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {

        },
        success: function (response) {
            console.log(response);
            $('#tblContribution').empty();
            if (response.status) {
                var data = response.data;
                for (var i = 0; i < data.length; i++) {
                    var row = '<tr>';
                    row += '<td>';
                    row += data[i].contribution_name;
                    row += '</td>';
                    row += '<td>';
                    row += parseFloat(data[i].amount).toFixed(2);
                    row += '</td>';
                    row += '<td>';
                    row += '<input data-id="' + data[i].member_contribution_ledger_id + '" data-edited="false" type="text" class="form-control" style="max-width:100px;text-align:right;" oninput="isEdited(this)" value="' + parseFloat(data[i].paid_amount).toFixed(2) + '">';
                    row += '</td>';
                    row += '</tr>';
                    $('#tblContribution').append(row);
                }
            }


        },
        error: function (error) {
            console.log(error);

        },
        complete: function () {

        }

    });
}



function loadLoan() {
    $.ajax({
        type: "GET",
        url: '/loadLoan/' + $('#cmb_year').val() + "/" + $('#cmb_month').val() + "/" + $('#cmbmember').val(),
        async: false,
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {

        },
        success: function (response) {
            console.log(response);
            $('#tblLoan').empty();
            if (response.status) {
                var data = response.data;
                for (var i = 0; i < data.length; i++) {
                    var row = '<tr>';
                    row += '<td>';
                    row += data[i].loan_name;
                    row += '</td>';
                    row += '<td>';
                    row += parseFloat(data[i].amount).toFixed(2);
                    row += '</td>';
                    row += '<td>';
                    row += '<input data-id="' + data[i].member_loan_ledger_id + '"  data-edited="false" type="text" class="form-control "  style="max-width:100px;text-align:right;" oninput="isEdited(this)" value="' + parseFloat(data[i].paid_amount).toFixed(2) + '">';
                    row += '</td>';
                    row += '<td>';
                    row += parseFloat(data[i].interest_amount).toFixed(2);
                    row += '</td>';
                    row += '<td>';
                    row += '<input data-id="' + data[i].member_loan_ledger_id + '"  data-edited="false" type="text" class="form-control"  style="max-width:100px;text-align:right;" oninput="isEdited(this)"  value="' + parseFloat(data[i].paid_interest).toFixed(2) + '">';
                    row += '</td>';
                    row += '</tr>';
                    $('#tblLoan').append(row);
                }
            }


        },
        error: function (error) {
            console.log(error);

        },
        complete: function () {

        }

    });
}

function isEdited(event) {

    $(event).attr("data-edited", false);
    if ($(event).val().trim().length > 0) {
        $(event).attr("data-edited", true);
    }
}


function saveContribution() {

    var collection = [];
    var row = $('#tblContribution').find('tr');
    for (var i = 0; i < row.length; i++) {

        var cell = $(row[i]).find('td');
        var settlement = $($(cell[2]).children()[0]);
        if (settlement.attr('data-edited') == "true") {
            collection.push(JSON.stringify({ "id": settlement.attr('data-id'), "value": settlement.val() }));
        }

    }
    var formData = new FormData();
    formData.append("data", JSON.stringify(collection));
    $.ajax({
        url: '/saveContribution',
        method: 'post',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {

        }, success: function (response) {
            console.log(response);

            if (response.status) {
                resetContributionTable();
                new Noty({
                    text: 'Contribution Saved!',
                    type: 'success'
                }).show();
            } else {
                new Noty({
                    text: 'Something went wrong.',
                    type: 'error'
                }).show();
            }


        }, error: function (data) {
            console.log(data.responseText);
            new Noty({
                text: 'Something went wrong.',
                type: 'error'
            }).show();
        }, complete: function () {

        }
    });
}


function saveLoan() {

    var collection = [];
    var row = $('#tblLoan').find('tr');
    for (var i = 0; i < row.length; i++) {

        var cell = $(row[i]).find('td');
        var settlement1 = $($(cell[2]).children()[0]);
        var settlement2 = $($(cell[4]).children()[0]);
        if (settlement1.attr('data-edited') == "true" || settlement2.attr('data-edited') == "true") {
            collection.push(JSON.stringify({ "id": settlement1.attr('data-id'), "value1": settlement1.val(), "value2": settlement2.val() }));
        }

    }
    var formData = new FormData();
    formData.append("data", JSON.stringify(collection));
    $.ajax({
        url: '/saveLoan',
        method: 'post',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {

        }, success: function (response) {
            console.log(response);

            if (response.status) {
                resetLoanTable();
                new Noty({
                    text: 'Loan Saved!',
                    type: 'success'
                }).show();
            } else {
                new Noty({
                    text: 'Something went wrong.',
                    type: 'error'
                }).show();
            }


        }, error: function (data) {
            console.log(data.responseText);
            new Noty({
                text: 'Something went wrong.',
                type: 'error'
            }).show();
        }, complete: function () {

        }
    });
}


function resetContributionTable() {

    var contribution_row = $('#tblContribution').find('tr');
    for (var i = 0; i < contribution_row.length; i++) {

        var cell = $(contribution_row[i]).find('td');
        var settlement = $($(cell[2]).children()[0]);
        settlement.attr('data-edited', "false");

    }

}


function resetLoanTable() {

    var loan_row = $('#tblLoan').find('tr');
    for (var i = 0; i < loan_row.length; i++) {

        var cell = $(loan_row[i]).find('td');
        var settlement1 = $($(cell[2]).children()[0]);
        var settlement2 = $($(cell[4]).children()[0]);
        settlement1.attr('data-edited', "false");
        settlement2.attr('data-edited', "false");

    }
}


function showConfirmation(title) {
    bootbox.confirm({
        title: title + ' confirmation',
        message: '<div class="d-flex justify-content-center align-items-center mb-3"><i id="question-icon" class="fa fa-question fa-5x text-warning animate-question"></i></div><div class="d-flex justify-content-center align-items-center"><p class="h2">Are you sure? to discard change</p></div>',
        buttons: {
            confirm: {
                label: '<i class="fa fa-check"></i>&nbsp;Yes',
                className: 'btn-warning'
            },
            cancel: {
                label: '<i class="fa fa-times"></i>&nbsp;No',
                className: 'btn-link'
            }
        },
        callback: function (result) {
            //console.log('Confirmation result:', result);
            if (result) {
                resetContributionTable();
                resetLoanTable();
                if (title == "Previous") {
                    previous($('#cmbservsubdepartment').val(), $('#cmbmember').val());
                } else if (title == "Next") {
                    next($('#cmbservsubdepartment').val(), $('#cmbmember').val());
                }
            } else {

            }
        },
        onShow: function () {
            $('#question-icon').addClass('swipe-question');
        },
        onHide: function () {
            $('#question-icon').removeClass('swipe-question');
        }
    });

    $('.bootbox').find('.modal-header').addClass('bg-warning text-white');
}


function next(dept_id, member_id) {

    $.ajax({
        type: "GET",
        url: '/next/' + dept_id + "/" + member_id,
        async: false,
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {

        },
        success: function (response) {
            console.log(response);
            if (response.status) {
                var id = response.data;
                appendComputerNumber(COMPUTER_NUMBER);
                $('#cmbcomputernum').val(id);
                appendMemberNumber(MEMBER_NUMBER);
                $('#cmbmember').val(id);
                appendFullName(FULL_NAME);
                $('#cmbmembefullname').val(id);
                imageloard(id);
                loadContribution();
                loadLoan();

            }

        },
        error: function (error) {
            console.log(error);

        },
        complete: function () {

        }

    });

    loadContribution();
    loadLoan();
}


function previous(dept_id, member_id) {

    $.ajax({
        type: "GET",
        url: '/previous/' + dept_id + "/" + member_id,
        async: false,
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {

        },
        success: function (response) {
            console.log(response);
            if (response.status) {
                var id = response.data;
                appendComputerNumber(COMPUTER_NUMBER);
                $('#cmbcomputernum').val(id);
                appendMemberNumber(MEMBER_NUMBER);
                $('#cmbmember').val(id);
                appendFullName(FULL_NAME);
                $('#cmbmembefullname').val(id);
                imageloard(id);
                loadContribution();
                loadLoan();

            }

        },
        error: function (error) {
            console.log(error);

        },
        complete: function () {

        }

    });
    loadContribution();
    loadLoan();
}

