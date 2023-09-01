console.log("createUser.js loading");

$(document).ready(function () {

    $('#user_form').submit(function (e) {
        e.preventDefault();
        
        if($('#btnsave').text().trim()=='Save'){
            save_user();
        }
        
    });

    // Default initialization
    $('.select2').select2();
    // End of Default initialization
});

function save_user(){

    var password = $('#password').val();
    var confirmPassword = $('#confirmPassword').val();

    // Check if the password and confirm password fields match
    if (password !== confirmPassword) {

        new Noty({
            text: 'Password and Confirm Password do not match!',
            type: 'error'
        }).show();
        return;

    }

    var formData = new FormData();

    formData.append('username', $('#username').val());
    formData.append('email', $('#email').val());
    formData.append('password', password); // Use the password variable
    formData.append('userrole', $('#userrole').val());
    formData.append('usertype', $('#usertype').val());

    $.ajax({
        type: "POST",
        url: "/save_user",
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
            new Noty({
                text: 'User created successfully!',
                type: 'success',
            }).show();
            
        }
    });
}