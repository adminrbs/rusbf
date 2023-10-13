$(document).ready(function () {

    membersreport();
    $('.select2').select2();

});



function membersreport() {

    $.ajax({
        url: '/getmembersreport',
        type: 'get',
        dataType: 'json',
        // async: false,


        success: function (response) {
            console.log(response);

            // Access data directly from the response object
            var members = response.members;
            var subDepartments = response.subDepartments;
            var designations = response.designations;
            var placeWorks = response.placeWorks;

            
            for (var i = 0; i < members.length; i++) {
                subDepartments += "<option value='" + members[i].id + "'>" + members[i].member_number + "</option>";
                designations += "<option value='" + members[i].id + "'>" + members[i].Designation + "</option>";
                members += "<option value='" + members[i].id + "'>" + members[i].computernumber + "</option>";
                placeWorks += "<option value='" + members[i].id + "'>" + members[i].bworklocation + "</option>";
            }
            
            // Set the HTML content of the select elements after the loop
            $('#cmbsavingDepartment').html(subDepartments);
            $('#cmbDesignation').html(designations);
            $('#cmbcomputernumber').html(members);
            $('#cmbworklocation').html(placeWorks);

        }, error: function (data) {
            console.log(data)
        }

    })

}
