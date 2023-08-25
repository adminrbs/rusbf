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
          { "data": "thcomno" },
          { "data": "thphone" },
          { "data": "actions" },
        ],
        "columnDefs": [
            {
                "targets": [0, 4, 6],
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
                    var com_no  = response.all_members[i]['computer_number'];
                    var member_no  = response.all_members[i]['member_number'];
                    var mobile_no  = response.all_members[i]['mobile_phone_number'];
                    var name  = response.all_members[i]['name_initials'];
                    var nic  = response.all_members[i]['national_id_number'];
                    var path  = response.all_members[i]['path'];

                    if(path == null){
                        path = "attachments/member_images/no_profile.png";
                    }

                    data.push({
                        "thmemimg": '<img src="' + path + '" class="rounded-circle" width="50" height="50" alt="">',
                        "thmemno": member_no,
                        "thname":name,
                        "thnic":nic,
                        "thcomno":com_no,
                        "thphone":mobile_no,
                        "actions": '<button class="btn btn-primary btn-icon" onclick="edit(' + id + ')"><i class="ph-pencil-simple" aria-hidden="true"></i></button> ' + 
                        '<button class="btn btn-success btn-icon" onclick="view(' + id + ')"><i class="ph-eye" aria-hidden="true"></i></button> ' +
                        '<button class="btn btn-danger btn-icon" onclick="_delete(' + id + ')" ' + 'disabled><i class="ph-trash" aria-hidden="true"></i></button>',
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

function view(id){

    location.href = "/member_form?" + id + "&view";

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
                        text: 'Member deleted successfully!',
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