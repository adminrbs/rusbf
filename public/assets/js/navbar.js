console.log("loading navbar.js");

$(document).ready(function () {

    $('#pwd_changing_form').submit(function (e) {
        e.preventDefault();
        
        if($('#btnPwd').text().trim()=='Save'){
            save_password_data();
        }
        
    });

});


function change_pwd() {
    $('#pwd_modal').modal('show');
}


function save_password_data(){

    var id = user_id;
    
    var formData = new FormData();

    formData.append('current_pwd', $('#current_pwd').val());
    formData.append('new_pwd', $('#new_pwd').val());

    $.ajax({
        type: "POST",
        url: "/change_password/" + id,
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
            if(response.status == "success"){
                $('#pwd_modal').modal('hide');

                new Noty({
                    text: 'Password changed successfully!',
                    type: 'success',
                }).show();

            }else if(response.status == "incorrect_password"){
                new Noty({
                    text: 'You entered current password is incorrect!',
                    type: 'error'
                }).show();
    
            }else if(response.status == "failed"){
                new Noty({
                    text: 'User does not exist!',
                    type: 'error'
                }).show();
            }else{
                new Noty({
                    text: 'Error!',
                    type: 'error'
                }).show();
            }
            
        }
        , error: function (data) {
            console.log(data)
        }, complete: function () {
        }
    });

}