let dropzoneSingle = undefined;
var formData = new FormData();
$(document).ready(function () {



    // Single files
    dropzoneSingle = new Dropzone("#dropzone_single", {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 1, // MB
        maxFiles: 1,
        dictDefaultMessage: 'Drop file to upload <span>or CLICK</span>',
        autoProcessQueue: false,
        addRemoveLinks: true,
        init: function () {
            this.on('addedfile', function (file) {
                formData.append("file", file);
                if (this.fileTracker) {
                    this.removeFile(this.fileTracker);
                }
                this.fileTracker = file;
            });
            this.on("success", function (file, responseText) {
                console.log(responseText); // console should show the ID you pointed to
            });
            this.on("complete", function (file) {

                this.removeAllFiles(true);
                console.log(file);
            });
        }
    });
    // End of Single files



    $('#form').submit(function (e) {
        e.preventDefault();

        // check if the input is valid using a 'valid' property
        if (!$(this).valid) {
            return;
        }
        dropzoneSingle.processQueue();
        saveCustomer();
    });

    $('#btnReset').on('click', function () {
        resetForm();
    });


    // Single picker
    $('.daterange-single').daterangepicker({
        parentEl: '.content-inner',
        singleDatePicker: true
    });
    // End of Single picker

    // Date Range Basic initialization
    $('.daterange-basic').daterangepicker({
        parentEl: '.content-inner'
    });
    // End of Date Range Basic initialization

    // Default initialization
    $('.select').select2();
    // End of Default initialization

    $('#tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });



});



function saveCustomer() {

    console.log(formData.get("file"));
    formData.append('customer_id', $('#customer_id').val());
    formData.append('customer_name', $('#customer_name').val());
    formData.append('credit_limit', $('#credit_limit').val());
    formData.append('customer_address', $('#customer_address').val());

    console.log(formData);
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: '/FormController/saveCustomer',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 800000,
        beforeSend: function () {

        },
        success: function (response) {
            console.log(response.file);
            if (response.status) {

                resetForm();
            } else {
            }

        },
        error: function (error) {
            console.log(error);

        },
        complete: function () {

        }

    });
}



function resetForm() {
    $('.validation-invalid-label').empty();
    $('#form').trigger('reset');
}




