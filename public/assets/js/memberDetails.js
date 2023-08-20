console.log('memberDetails.js');

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

    $('#member_reg_frm').submit(function (e) {
        e.preventDefault();

        // check if the input is valid using a 'valid' property
        if (!$(this).valid) {
            return;
        }
        // dropzoneSingle.processQueue();
        if($('#btnsave').text().trim()=='Save'){
            saveMember();
        }
        else{
            updateMember();
        }
       
        
    });

    loadMemberData();

    //Reset button
    $('#btnReset').on('click', function () {
        resetForm();
    });

    // Single picker
    $('.daterange-single').daterangepicker({
        parentEl: '.content-inner',
        singleDatePicker: true
    });
    // End of Single picker

    // Name initials
    const txtFullNameInput = document.getElementById("full_name");
    txtFullNameInput.addEventListener("input", function() {
        this.value = this.value.replace(/\s+/g, " ");
    });
    const fullNameInput = document.getElementById('full_name');
    const initNameInput = document.getElementById('name_initials');

    fullNameInput.addEventListener('blur', () => {
        const fullName = fullNameInput.value;
        const words = fullName.split(' ');
        //const initialsExceptLast = words.slice(0, -1).map(word => word.charAt(0)).join('.');
        const initialsExceptLast = words.slice(0, -1).map(word => word.charAt(0).toUpperCase()).join('.');
        const initialsExceptLast2 = words.slice(0, -2).map(word => word.charAt(0).toUpperCase()).join('.');
        const lastWord = words[words.length - 1];
        const lastWord2 = words[words.length - 2];
        
        if (lastWord.trim() === '') {
            initNameInput.value = initialsExceptLast2 + ' ' + lastWord2;
          
        } else {
            initNameInput.value = initialsExceptLast + ' ' + lastWord;
        }
    });
    // End Name initials

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

});


function saveMember() {   

    console.log(formData.get("file"));
    formData.append('member_number', $('#member_number').val());
    formData.append('national_id_number', $('#national_id_number').val());
    formData.append('date_of_birth', $('#date_of_birth').val());
    formData.append('language_id', $('#language_id').val());
    formData.append('full_name', $('#full_name').val());
    formData.append('name_initials', $('#name_initials').val());
    formData.append('full_name_unicode', $('#full_name_unicode').val());
    formData.append('name_initials_unicode', $('#name_initials_unicode').val());
    formData.append('personal_address', $('#personal_address').val());
    formData.append('date_of_joining', $('#date_of_joining').val());
    formData.append('cabinet_number', $('#cabinet_number').val());
    formData.append('work_location_id', $('#work_location_id').val());
    formData.append('home_phone_number', $('#home_phone_number').val());
    formData.append('official_number', $('#official_number').val());
    formData.append('payroll_number', $('#payroll_number').val());
    formData.append('mobile_phone_number', $('#mobile_phone_number').val());
    formData.append('designation_id', $('#designation_id').val());
    formData.append('payroll_preparation_location_id', $('#payroll_preparation_location_id').val());
    formData.append('serving_sub_department_id', $('#serving_sub_department_id').val());
    formData.append('computer_number', $('#computer_number').val());
    formData.append('monthly_payment_amount', $('#monthly_payment_amount').val());
    formData.append('beneficiary_full_name', $('#beneficiary_full_name').val());
    formData.append('beneficiary_relationship', $('#beneficiary_relationship').val());
    formData.append('beneficiary_private_address', $('#beneficiary_private_address').val());

    $.ajax({
        type: "POST",
        url: "/save_member",
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

            if (response.status == true) {

                new Noty({
                    text: 'Member details saved.',
                    type: 'success'
                }).show();

                resetForm();

            } else {
                new Noty({
                    text: 'Something went wrong.',
                    type: 'error'
                }).show();
            }
            

        }

    });

}

function updateMember(){
    
    // console.log(formData.get("file"));
    formData.append('id', $('#hiddenmemberid').val());
    formData.append('member_number', $('#member_number').val());
    formData.append('national_id_number', $('#national_id_number').val());
    formData.append('date_of_birth', $('#date_of_birth').val());
    formData.append('language_id', $('#language_id').val());
    formData.append('full_name', $('#full_name').val());
    formData.append('name_initials', $('#name_initials').val());
    formData.append('full_name_unicode', $('#full_name_unicode').val());
    formData.append('name_initials_unicode', $('#name_initials_unicode').val());
    formData.append('personal_address', $('#personal_address').val());
    formData.append('date_of_joining', $('#date_of_joining').val());
    formData.append('cabinet_number', $('#cabinet_number').val());
    formData.append('work_location_id', $('#work_location_id').val());
    formData.append('home_phone_number', $('#home_phone_number').val());
    formData.append('official_number', $('#official_number').val());
    formData.append('payroll_number', $('#payroll_number').val());
    formData.append('mobile_phone_number', $('#mobile_phone_number').val());
    formData.append('designation_id', $('#designation_id').val());
    formData.append('payroll_preparation_location_id', $('#payroll_preparation_location_id').val());
    formData.append('serving_sub_department_id', $('#serving_sub_department_id').val());
    formData.append('computer_number', $('#computer_number').val());
    formData.append('monthly_payment_amount', $('#monthly_payment_amount').val());
    formData.append('beneficiary_full_name', $('#beneficiary_full_name').val());
    formData.append('beneficiary_relationship', $('#beneficiary_relationship').val());
    formData.append('beneficiary_private_address', $('#beneficiary_private_address').val());

    $.ajax({
        type: "POST",
        url: "/member_form/update",
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

            console.log(response);
            if(response == 'true'){
                new Noty({
                    text: 'Member details updated.',
                    type: 'success'
                }).show();

            }else{
                new Noty({
                    text: 'Something went wrong.',
                    type: 'error'
                }).show();
            }
        }

    });
}

function loadMemberData(){
    
    if (window.location.search.length > 0) {
        var sPageURL = window.location.search.substring(1);
        var param = sPageURL.split('&');
        var id = param[0];

        $('#btnsave').text('Update');
    }
    $.ajax({
        type: "GET",
        url: "/get_member_data/" + id,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        beforeSend: function () {

        },
        success: function (response) {
            // console.log(response);
            var data = response[0];
            var pathData = response[1]

            if (response) {
                $('#hiddenmemberid').val(data.id);
                $('#member_number').val(data.member_number);
                $('#national_id_number').val(data.national_id_number);
                $('#date_of_birth').val(data.date_of_birth);
                $('#language_id').val(data.language_id);
                $('#full_name').val(data.full_name);
                $('#name_initials').val(data.name_initials);
                $('#full_name_unicode').val(data.full_name_unicode);
                $('#name_initials_unicode').val(data.name_initials_unicode);
                $('#personal_address').val(data.personal_address);
                $('#date_of_joining').val(data.date_of_joining);
                $('#home_phone_number').val(data.home_phone_number);
                $('#mobile_phone_number').val(data.mobile_phone_number);
                $('#serving_sub_department_id').val(data.serving_sub_department_id);
                $('#cabinet_number').val(data.cabinet_number);
                $('#official_number').val(data.official_number);
                $('#designation_id').val(data.designation_id);
                $('#computer_number').val(data.computer_number);
                $('#work_location_id').val(data.work_location_id);
                $('#payroll_number').val(data.payroll_number);
                $('#payroll_preparation_location_id').val(data.payroll_preparation_location_id);
                $('#monthly_payment_amount').val(data.monthly_payment_amount);
                $('#beneficiary_full_name').val(data.beneficiary_full_name);
                $('#beneficiary_relationship').val(data.beneficiary_relationship);
                $('#beneficiary_private_address').val(data.beneficiary_private_address);

            }

        },
        error: function (error) {
            new Noty({
                text: 'Something went wrong.',
                type: 'error'
            }).show();

        },
        complete: function () {

        }

    });
}

function resetForm() {
    $('.validation-invalid-label').empty();
    $('#member_reg_frm').trigger('reset');

    // Reset the Dropzone upload box
    var dropzoneSingle = Dropzone.forElement("#dropzone_single");
    if (dropzoneSingle) {
        dropzoneSingle.removeAllFiles();
    }
}


