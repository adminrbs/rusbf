console.log("allmembers.js loading");

const MemberTable = (function () {
    var member_table = undefined;
    const _componentDatatableFixedColumnsBnk = function () {
        if (!$().DataTable) {
            console.warn("Warning - datatables.min.js is not loaded.");
            return;
        }

        // Setting datatable defaults
        $.extend($.fn.dataTable.defaults, {
            columnDefs: [
                {
                    orderable: false,
                    width: 100,
                    targets: [2],
                },
            ],
            dom: '<"datatable-header"fl><"datatable-scroll datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: "Type to filter...",
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: {
                    first: "First",
                    last: "Last",
                    next: document.dir == "rtl" ? "&larr;" : "&rarr;",
                    previous: document.dir == "rtl" ? "&rarr;" : "&larr;",
                },
            },
        });

        // Left and right fixed columns
        member_table = $(".datatable-fixed-both-members").DataTable({
            columnDefs: [
                {
                    width: 50,
                    targets: 0
                },
                {
                    width: 100,
                    targets: 1
                },
                {
                    width: 250,
                    targets: 2
                },
                {
                    width: 200,
                    targets: 3
                },
                {
                    width: 150,
                    targets: 4
                },
                {
                    width: 100,
                    targets: 5
                }
                ,
                {
                    width: "100%",
                    targets: 5
                }
            ],
            scrollX: false,
            //scrollY: 500,
            scrollCollapse: false,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 0,
            },
            pageLength: 100,
            order: [],
            columns: [
                { data: "image" },
                { data: "no" },
                { data: "name" },
                { data: "nic" },
                { data: "com_num" },
                { data: "phone" },
                { data: "action" },
            ],
        });

        // Adjust columns on window resize
        setTimeout(function () {
            $(window).on("resize", function () {
                member_table.columns.adjust();
            });
        }, 100);
    };

    return {
        init: function () {
            _componentDatatableFixedColumnsBnk();
        },
        refresh: function () {
            if (member_table != undefined) {
                member_table.columns.adjust();
            }
        },
    };
})();

document.addEventListener("DOMContentLoaded", function () {
    MemberTable.init();
});

$(document).ready(function () {
    loadmembers();
});

function loadmembers() {
    $.ajax({
        type: "GET",
        url: "/get_all_members",
        success: function (response) {
            console.log(response.all_members);

            var data = [];
            for (i = 0; i < response.all_members.length; i++) {
                var id = response.all_members[i]["id"];
                var com_no = response.all_members[i]["computer_number"];
                var member_no = response.all_members[i]["member_number"];
                var mobile_no = response.all_members[i]["mobile_phone_number"];
                var name = response.all_members[i]["name_initials"];
                var nic = response.all_members[i]["national_id_number"];
                var path = response.all_members[i]["path"];

                // var imageIcon_path = "attachments/member_icon_images/" + id + ".png";

                if (path == null || path == "") {
                    path = "attachments/member_images/no_profile.png";
                }

                data.push({
                    
                    "image":'<img src="' + path + '" class="rounded-circle" width="50" height="50" alt="">',
                    "no": member_no,
                    "name": name,
                    "nic": nic,
                    "com_num": com_no,
                    "phone": mobile_no,
                    "action":
                        '<button title="Edit" class="btn btn-primary btn-icon" onclick="edit(' + id + ')"><i class="ph-pencil-simple" aria-hidden="true"></i></button> ' +
                        '<button title="View" class="btn btn-success btn-icon" onclick="view(' + id + ')"><i class="ph-eye" aria-hidden="true"></i></button> ' +
                        '<button title="Delete" class="btn btn-danger btn-icon" onclick="_delete(' + id + ')"><i class="ph-trash" aria-hidden="true"></i></button>',
                });
            }
            var table = $('#tableMembers').DataTable();
            table.clear();
            table.rows.add(data).draw();
            MemberTable.refresh();
        },
    });
}

function edit(id) {
    location.href = "/member_form?id=" + id + "&action=edit";
}

function view(id) {
    location.href = "/member_form?id=" + id + "&action=view";
}

function _delete(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        $.ajax({
            type: "DELETE",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/delete_member/" + id,

            success: function (response) {
                console.log(response);

                if (response == "deleted") {
                    new Noty({
                        text: "Member deleted successfully!",
                        type: "success",
                    }).show();

                    loadmembers();
                } else {
                    new Noty({
                        text: "Something went wrong.",
                        type: "error",
                    }).show();
                }
            },
            error: function (data) {},
        });
    } else {
        loadmembers();
    }
}
