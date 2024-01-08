console.log("allmembers.js loading");
/*
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
                    width: 350,
                    targets: [2]
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
                },
                {
                    width: "100%",
                    targets: 8
                }
            ],
            scrollX: false,
            //scrollY: 500,
            scrollCollapse: false,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1,
            },
            pageLength: 100,
            order: [],
            columns: [
                { data: "id" },
                { data: "image" },
                { data: "no" },
                { data: "name" },
                { data: "nic" },
                { data: "com_num" },
                { data: "phone" },
                {data:"subdepsrtment"},
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
});*/


const DatatableFixedColumns = function () {

    // Setup module components

    // Basic Datatable examples
    const _componentDatatableFixedColumns = function () {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Setting datatable defaults
        $.extend($.fn.dataTable.defaults, {
            columnDefs: [{
                orderable: false,
                width: 100,
                targets: [2]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll datatable-scroll-wrap"t><"datatable-footer"ip>',
            language: {
                search: '<span class="me-3">Filter:</span> <div class="form-control-feedback form-control-feedback-end flex-fill">_INPUT_<div class="form-control-feedback-icon"><i class="ph-magnifying-glass opacity-50"></i></div></div>',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span class="me-3">Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': document.dir == "rtl" ? '&larr;' : '&rarr;', 'previous': document.dir == "rtl" ? '&rarr;' : '&larr;' }
            }


        });


        // Left and right fixed columns
        var table = $('.datatable-fixed-both-members').DataTable({
            columnDefs: [

                    {
                        orderable: false,
                        targets: 2
                    },
                    {
                        width:200,
                        targets: 0
                    },
                    {
                        width: '100%',
                        targets: 1
                    },
                    {
                        width:300,
                        targets: 2
                    },

            ],

            fixedColumns: true,
            scrollX: false,
            scrollY: "100%",
            scrollCollapse: false,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            },
           /*  "autoWidth": false, */
            "pageLength": 100,
            "order": [],
            "columns": [
                { data: "id" },
                { data: "image" },
                { data: "no" },
                { data: "name" },
                { data: "nic" },
                { data: "com_num" },
                { data: "phone" },
                {data:"subdepsrtment"},
                { data: "action" },


            ],
            "stripeClasses": ['odd-row', 'even-row']
        });table.column(0).visible(false);


    };

    // Return objects assigned to module

    return {
        init: function () {
            _componentDatatableFixedColumns();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function () {
    DatatableFixedColumns.init();
});


$(document).ready(function () {

   // getBranchDetails();
    loadmembers();

});



function loadmembers() {
    $.ajax({
        type: "GET",
        url: "/get_all_members",
        success: function (response) {
            console.log(response.data);

            var data = [];
            for (i = 0; i < response.data.length; i++) {
                var id = response.data[i]["id"];
                var com_no = response.data[i]["computer_number"];
                var member_no = response.data[i]["member_number"];
                var mobile_no = response.data[i]["mobile_phone_number"];
                var name = response.data[i]["name_initials"];
                var nic = response.data[i]["national_id_number"];
                var path = response.data[i]["path"];
                var subdepsrtment = response.data[i]["subname"];

                // var imageIcon_path = "attachments/member_icon_images/" + id + ".png";

                if (path == null || path == "") {
                    path = "attachments/member_images/no_profile.png";
                }

                data.push({
                    "id":"",
                    "image":'<img src="' + path + '" class="rounded-circle" width="50" height="50" alt="">',
                    "no": member_no,
                    "name": name,
                    "nic": nic,
                    "com_num": com_no,
                    "phone": mobile_no,
"subdepsrtment":subdepsrtment,
                    "action":
                        '<button title="Edit" class="btn btn-primary btn-icon" onclick="edit(' + id + ')"><i class="ph-pencil-simple" aria-hidden="true"></i></button> ' +
                        '<button title="View" class="btn btn-success btn-icon" onclick="view(' + id + ')"><i class="ph-eye" aria-hidden="true"></i></button> ' +
                        '<button title="Delete" class="btn btn-danger btn-icon" onclick="_delete(' + id + ')"><i class="ph-trash" aria-hidden="true"></i></button>',
                });
            }
            var table = $('#tableMembers').DataTable();
            table.clear();
            table.rows.add(data).draw();
           // MemberTable.refresh();
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
