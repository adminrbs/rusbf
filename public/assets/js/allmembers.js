console.log("allmembers.js loading");

$(document).ready(function () {

    $('#tbl_members').DataTable({
        responsive: true,
        "order": [],
        "columns": [
          { "data": "thmemimg" },
          { "data": "thmemno" },
          { "data": "thname" },
          { "data": "thnic" },
          { "data": "thphone" },
          { "data": "edit" },
          { "data": "delete" },
        ],
        "columnDefs": [
            {
                "targets": 0,
                "className": "text-center" 
            }
        ]
    });
    loadmembers();
});

function loadmembers(){
    $.ajax({
        type: 'GET',
        url: '/get_all_members',
        success: function(response){
            console.log(response.all_members);
            var data = [];
                for (i = 0; i < response.all_members.length; i++) {

                    var id  = response.all_members[i]['id'];
                    var member_no  = response.all_members[i]['member_number'];
                    var mobile_no  = response.all_members[i]['mobile_phone_number'];
                    var name  = response.all_members[i]['name_initials'];
                    var nic  = response.all_members[i]['national_id_number'];
                    var path  = response.all_members[i]['path'];

                    if(path == null){
                        path = "member_images/no_profile.png";
                    }

                    data.push({
                        "thmemimg": '<img src="' + path + '" class="rounded-circle" width="50" height="50" alt="">',
                        "thmemno": member_no,
                        "thname":name,
                        "thnic":nic,
                        "thphone":mobile_no,
                        "edit": '<button class="btn btn-success" onclick="edit(' + id + ')"><i class="ph-pencil-simple" aria-hidden="true"></i></button>',
                        "delete": '<button class="btn btn-danger" onclick="_delete(' + id + ')"><i class="ph-trash" aria-hidden="true"></i></button>',
                     });
                }

                var table = $('#tbl_members').DataTable();
                table.clear();
                table.rows.add(data).draw();
         
        }
    });
}

function edit(id){

    location.href = "/member_form?"+ id;
}

function _delete(id){
    
    if (confirm('Are you sure you want to delete this record?')) {
        $.ajax({
            type: 'DELETE',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/delete_member/'+id,
            
            success: function(response){
                console.log(response);

                if (response == "deleted") {
                    new Noty({
                        text: 'Member deleted successfully.',
                        type: 'success'
                    }).show();

                    loadmembers();
                }else{
                    new Noty({
                        text: 'Something went wrong.',
                        type: 'error'
                    }).show();
                }
            }, error: function(data){

            }
        });
    } else {
        loadmembers();
    }
}