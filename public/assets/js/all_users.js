console.log("all_users.js loading");

$(document).ready(function () {

    $('#tbl_users').DataTable({
        responsive: true,
        "order": [],
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
                    var username  = dt[i]['name'];
                    var email  = dt[i]['email'];
                    var role_id  = dt[i]['role_id'];
                    var user_type  = dt[i]['user_type'];

                    data.push({
                        "thid": id,
                        "thusername": username,
                        "themail":email,
                        "throle":role_id,
                        "thtype":user_type,
                        "thactions": '<button class="btn btn-primary btn-icon" onclick="edit(' + id + ')"><i class="ph-pencil-simple" aria-hidden="true"></i></button> ' + 
                        '<button class="btn btn-danger btn-icon" onclick="_delete(' + id + ')"><i class="ph-trash" aria-hidden="true"></i></button>',
                     });

                }
                var table = $('#tbl_users').DataTable();
                table.clear();
                table.rows.add(data).draw();      
        }
    });
}