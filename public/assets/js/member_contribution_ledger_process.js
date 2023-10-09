$(document).ready(function () {
    getCurrentYearMonth();


    $('#btn_process').on('click', function () {
        process();
    });

});


function getCurrentYearMonth() {
    $.ajax({
        type: 'GET',
        url: '/getCurrentYearMonth',
        success: function (response) {
            var data = response.data;
            $('#txt_year').val(data.current_year);
            $('#txt_month').val(data.current_month);
        },
        error: function (data) {
            console.log(data);
        }, complete: function () {

        }
    });
}


function process() {
    $.ajax({
        type: "POST",
        url: '/member_contribution_ledger_process',
        data: {
            'current_year': $('#txt_year').val(),
            'current_month': $('#txt_month').val(),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 800000,
        beforeSend: function () {

        },
        success: function (response) {
            console.log(response);
            if (response.status) {
                new Noty({
                    text: 'Successfully saved',
                    type: 'success'
                }).show();
            } else {
                new Noty({
                    text: 'Something went wrong',
                    type: 'error'
                }).show();
            }

        },
        error: function (error) {
            console.log(error);
            new Noty({
                text: 'Something went wrong',
                type: 'error'
            }).show();
        },
        complete: function () {
            getCurrentYearMonth();
        }

    });
}