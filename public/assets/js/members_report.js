var selectedepartment = null;
var selectedelocation = null;
var selectedecomputernumber = null;
var selectedesignation = null;
var selecteyear = null;
var selectemonth = null;
var report;
$(document).ready(function () {
    var currentYear = new Date().getFullYear();

    // Select the year dropdown
    var yearDropdown = document.getElementById("year");

    // Add options for ten years backward and two years forward
    for (var i = currentYear - 10; i <= currentYear + 2; i++) {
        var option = document.createElement("option");
        option.value = i;
        option.text = i;
        yearDropdown.appendChild(option);
    }


    yearDropdown.value = currentYear;


    var monthDropdown = document.getElementById("month");

    // Create an array of month names
    var monthNames = [
        "January", "February", "March", "April", "May", "June", "July",
        "August", "September", "October", "November", "December"
    ];

    // Populate the month options
    for (var i = 0; i < monthNames.length; i++) {
        var option = document.createElement("option");
        option.value = i + 1; // Set the month name as the option value
        option.text = monthNames[i];
        monthDropdown.appendChild(option);
    }
    var currentMonth = new Date().getMonth() + 1;
    monthDropdown.value = currentMonth;



    membersreport();
    $('.select2').select2();
    $('input[type="checkbox"]').prop('checked', false);

    //click checkbox set the value
    $('#chksavingDepartment').on('change', function () {
        if (this.checked) {
            selectedepartment = $('#cmbsavingDepartment').val();
        } else {
            selectedepartment = null

        }

    });
    $('#chkyear').on('change', function () {
        if (this.checked) {
            selecteyear = $('#year').val();

        } else {
            selecteyear = null

        }

    });
    $('#chkMonth').on('change', function () {
        if (this.checked) {

            selectemonth = $('#month').val();
            // alert(selectemonth)
        } else {
            selectemonth = null

        }

    });
    $('#chkdesignation').on('change', function () {
        if (this.checked) {
            selectedesignation = $('#cmbDesignation').val();
        } else {
            selectedesignation = null

        }

    });
    $('#chkcomputernumber').on('change', function () {
        if (this.checked) {
            selectedecomputernumber = $('#cmbcomputernumber').val();
        } else {
            selectedecomputernumber = null

        }

    });
    $('#cbxworklocation').on('change', function () {
        if (this.checked) {
            selectedelocation = $('#cmbworklocation').val();
        } else {
            selectedelocation = null

        }

    })

    // select report
    $("#adviceofdeducation").prop("checked", true);
    var isChecked = $("#adviceofdeducation").prop("checked");

    if (isChecked == true) {
        $("#adviceofdeducation").prop("checked", false);
    }

    $('#btn-collapse-search').on('click', function () {
        $('input[type="checkbox"]').prop('checked', false);
        if (report = "undefined") {
            $('#row1').show();
        }
    });

    $('#viewReport').on('click', function () {

        if (report == "undefined") {
            $('#row1').show();

            new Noty({
                text: 'Select Report',
                type: 'warning',
            }).show();
        } else {
            $('#row1').hide();
            if (report == 'adviceofdeducation') {


                var requestData = [
                    { selectedepartment: selectedepartment },
                    { selectedesignation: selectedesignation },
                    { selectedecomputernumber: selectedecomputernumber },
                    { selectedelocation: selectedelocation },
                    { selecteyear: selecteyear },
                    { selectemonth: selectemonth }
                ];
                $('#pdfContainer').attr('src', '/adviceofdeductionReport/' + JSON.stringify(requestData));
            }
            if (report == null || report == undefined) {
                new Noty({
                    text: 'Select Report',
                    type: 'warning',
                }).show();
            }
        }



    });
    $('#btn-collapse-search').on('click', function () {

        $('#pdfContainer').attr('src', '');
    });
    $("input[type='radio']").click(function () {
        $('input[type="checkbox"]').prop('checked', false);
        report = this.id;
        jsonData = {
            year: "1",
            month: "2",
            subDepartments: "3",
            designation: "4",
            computernumber: "5",
            worklocation: "6",
        };
        console.log(jsonData);
        $.ajax({
            type: "post",
            dataType: 'json',
            url: "/filterhidden/" + report,
            data: JSON.stringify(jsonData),
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (typeof response.year === 'undefined') {

                    $('#year').prop('disabled', false);
                    $('#chkyear').prop('disabled', false);
                } else {

                    $('#year').prop('disabled', true);
                    $('#chkyear').prop('disabled', true);
                }

                if (typeof response.month === 'undefined') {

                    $('#month').prop('disabled', false);
                    $('#chkMonth').prop('disabled', false);
                } else {

                    $('#month').prop('disabled', true);
                    $('#chkMonth').prop('disabled', true);
                }



                if (typeof response.subDepartments === 'undefined') {

                    $('#cmbsavingDepartment').prop('disabled', false);
                    $('#chksavingDepartment').prop('disabled', false);
                } else {

                    $('#cmbsavingDepartment').prop('disabled', true);
                    $('#chksavingDepartment').prop('disabled', true);
                }


                if (typeof response.designation === 'undefined') {

                    $('#cmbDesignation').prop('disabled', false);
                    $('#chkdesignation').prop('disabled', false);
                } else {

                    $('#cmbDesignation').prop('disabled', true);
                    $('#chkdesignation').prop('disabled', true);
                }


                if (typeof response.computernumber === 'undefined') {

                    $('#cmbcomputernumber').prop('disabled', false);
                    $('#chkcomputernumber').prop('disabled', false);
                } else {

                    $('#cmbcomputernumber').prop('disabled', true);
                    $('#chkcomputernumber').prop('disabled', true);
                }

                if (typeof response.worklocation === 'undefined') {

                    $('#cmbworklocation').prop('disabled', false);
                    $('#cbxworklocation').prop('disabled', false);
                } else {

                    $('#cmbworklocation').prop('disabled', true);
                    $('#cbxworklocation').prop('disabled', true);
                }

            }
        });
    });
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

            // Create HTML strings for select options
            var subDepartmentsOptions = "";
            var designationsOptions = "";
            var membersOptions = "";
            var placeWorksOptions = "";

            for (var i = 0; i < members.length; i++) {
                membersOptions += "<option value='" + members[i].id + "'>" + members[i].computer_number + "</option>";

            }
            for (var i = 0; i < subDepartments.length; i++) {
                subDepartmentsOptions += "<option value='" + subDepartments[i].id + "'>" + subDepartments[i].name + "</option>";
            }
            for (var i = 0; i < designations.length; i++) {
                designationsOptions += "<option value='" + designations[i].id + "'>" + designations[i].name + "</option>";
            }
            for (var i = 0; i < placeWorks.length; i++) {
                placeWorksOptions += "<option value='" + placeWorks[i].id + "'>" + placeWorks[i].name + "</option>";
            }
            // Set the HTML content of the select elements
            $('#cmbsavingDepartment').html(subDepartmentsOptions);
            $('#cmbDesignation').html(designationsOptions);
            $('#cmbcomputernumber').html(membersOptions);
            $('#cmbworklocation').html(placeWorksOptions);

        }, error: function (data) {
            console.log(data)
        }

    })

}

function dataclear() {
    $('input[type="radio"]').prop('checked', false);
    selectedepartment = null;
    selectedelocation = null;
    selectedecomputernumber = null;
    selectedesignation = null;
    selecteyear = null;
    selectemonth = null;
}