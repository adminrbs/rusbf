$(document).ready(function () {
    $('#btnSave').on('click', function (event) {
        //event.preventDefault();
        validate();
        saveCustomer();
    });
    $('form').on('submit', function (e) {
        e.preventDefault();
    });
    $('#btnReset').on('click', function () {
        validate();
        $('#form').trigger('reset');
    });
});



function saveCustomer() {
    //$("#form").submit();
    $.ajax({
        type: "POST",
        url: '/CustomerController/saveCustomer',
        data: {
            'customer_id': $('#customer_id').val(),
            'customer_name': $('#customer_name').val(),
            'credit_limit': $('#credit_limit').val(),
            'customer_address': $('#customer_address').val(),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 800000,
        beforeSend: function () {
            $("#form").submit();
        },
        success: function (response) {
            console.log(response);
            if (response.ValidationException) validate(response.ValidationException);

            if (response.status) {
                $('#form').trigger('reset');
                $("div.alert-success").show();
            } else {
                $("div.alert-danger").show();
            }

        },
        error: function (error) {
            console.log(error);

        },
        complete: function () {

        }

    });
}



function validate(ValidationException) {
    $('.error_validation').empty();
    if (ValidationException) {
        $('#error_validation_' + ValidationException.id).html(ValidationException.message);
    }
}