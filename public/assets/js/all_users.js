console.log("all_users.js loading");

$(document).ready(function () {

    $('#tbl_users').DataTable({
        responsive: true,
        "order": [[0, 'asc']], // Set the first column in ascending order
        "columns": [
          { "data": "thid" },
          { "data": "thusername" },
          { "data": "themail" },
          { "data": "throle" },
          { "data": "thtype" },
          { "data": "thactions" },
        ],
        "columnDefs": [
            {
                "targets": [],
                "className": "text-center" 
            }
        ]
    });
    loadusers();

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

function loadusers(){
    $.ajax({
        type: 'GET',
        url: '/load_users_list',
        success: function(response){
            var dt = response.userData;
            console.log(dt);
            var data = [];
                for (i = 0; i < dt.length; i++) {

                    var id  = dt[i]['id'];
                    var stringId = "'"+id+"'";
                    var username  = dt[i]['name'];
                    var email  = dt[i]['email'];
                    var role_name  = dt[i]['role_name'];
                    var user_type  = dt[i]['user_type'];

                    data.push({
                        "thid": id,
                        "thusername": username,
                        "themail":email,
                        "throle":role_name,
                        "thtype":user_type,
                        "thactions": '<button class="btn btn-primary btn-icon" onclick="edit(' + id + ')"' + 'disabled><i class="ph-pencil-simple" aria-hidden="true"></i></button> ' + 
                        '<button class="btn btn-danger btn-icon" onclick="_delete(' + id + ')"' + 'disabled><i class="ph-trash" aria-hidden="true"></i></button>',
                     });

                }
                var table = $('#tbl_users').DataTable();
                table.clear();
                table.rows.add(data).draw();      
        }
    });
}

function add_user(){
    $('#add_modal').modal('show');
    $('.modal-title').text('Create User');
    $('#btnsave').text('Save');
    $('#add_modal').on('shown.bs.modal', function() {
        $('#username').focus();
    })
    resetModal();

    // Fetch user types via AJAX and populate the select element
    $.ajax({
        type: 'GET',
        url: '/get_user_role', 
        success: function (data) {
            console.log(data);
            // Assuming the data is an array of user types with 'id' and 'name' properties
            var userRoles = data;

            var userRoleSelect = $('#userrole');
            userRoleSelect.empty(); // Clear existing options

            // Add the default option
            userRoleSelect.append($('<option>', {
                value: '',
                text: '-- Select --'
            }));

            // Populate the select with user types
            $.each(userRoles, function (index, userRole) {
                userRoleSelect.append($('<option>', {
                    value: userRole.id,
                    text: userRole.name
                }));
            });
        },
        error: function (error) {
            console.error('Error fetching user types:', error);
        }
    });

}

function resetModal(){
    $('#add_modal').find('input').val('');
    $('#add_modal').find('select').val('');
}

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

            $('#add_modal').modal('hide');
            console.log(response);
            new Noty({
                text: 'User created successfully!',
                type: 'success',
            }).show();

            loadusers();
            
        }
    });
}

function edit(id){

    $('#add_modal').modal('show');
    $('.modal-title').text('Update User');
    $('#btnsave').text('Update');
    $('#hidden_id').val(id);

    $.ajax({
        type: "GET",
        url: "/get_user_data/" + id,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        beforeSend: function () {

        },
        success: function (response) {

            var data = response[0];
            var data2 = response[1];
            console.log(response);
            if (response) {
                $('#hiddenuserid').val(data.id); 
                $('#username').val(data.name); 
                $('#email').val(data.email); 
                $('#password').val(data.password); 
                $('#confirmPassword').val(data.password); 
                $('#userrole').val(data2.id).trigger('change');; 
                $('#usertype').val(data.user_type); 
            }else{
                console.log('error');
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