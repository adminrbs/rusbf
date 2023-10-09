
const DatatableFixedColumnss = function () {


    //
    // Setup module components
    //

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
        var table = $('#tbl_attachment').DataTable({
            columnDefs: [
                {
                    orderable: false,
                    targets: 2
                },
                {
                    width: 200,
                    targets: 0
                },
                {
                    width: 100,
                    targets: [1]
                },
                {
                    width: '100%',
                    targets: 2
                },




            ],
            scrollX: true,
            /* scrollY: 350, */
            scrollCollapse: true,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            },
            "pageLength": 100,
            "order": [],
            "columns": [
                { "data": "id" },
                { "data": "description" },
                { "data": "attachment" },
                { "data": "action" },



            ], "stripeClasses": ['odd-row', 'even-row'],
        }); table.column(0).visible(false);


        //
        // Fixed column with complex headers
        //

    };


    //
    // Return objects assigned to module
    //

    return {
        init: function () {
            _componentDatatableFixedColumns();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function () {
    DatatableFixedColumnss.init();
});





let dropzoneSingle = undefined;
var ACTION = undefined;

var formData = new FormData();
$(document).ready(function () {
    getAttachment();
    dropzoneSingle = new Dropzone("#dropzone_single", {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 2, // MB
        maxFiles: 1,
        acceptedFiles: ".pdf, .docx, .xls, .xlsx, .pptx",
        dictDefaultMessage: 'Drop file to upload <span>or CLICK</span> (File formats: jpeg,jpg,png,pdf)',
        autoProcessQueue: false,
        addRemoveLinks: true,
        selectedImage: undefined,
        imageIcon: undefined,
        init: function () {
            this.on('addedfile', function (file) {
                console.log(file);
                this.selectedImage = file;

                const reader = new FileReader();
                reader.onload = () => {
                    const size = 40;
                    const base64 = reader.result; // This is the Data URL of the uploaded file
                    const image = new Image();
                    image.crossOrigin = 'anonymous';
                    image.src = base64;
                    image.onload = () => {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');
                        canvas.height = size;
                        canvas.width = size;
                        ctx.drawImage(image, 0, 0, size, size);
                        const dataUrl = canvas.toDataURL();
                        this.imageIcon = dataUrl;
                        //console.log(this.resizeImage);
                    }
                };
                if (ACTION == 'save') {
                    reader.readAsDataURL(file);
                }
                if (this.fileTracker) {
                    this.removeFile(this.fileTracker);
                }
                this.fileTracker = file;
            });
            this.on('removedfile', function (file) {
                //this.selectedImage = undefined;
            });
            this.on("success", function (file, responseText) {
                console.log(responseText); // console should show the ID you pointed to
            });
            this.on("complete", function (file) {

                this.removeAllFiles(true);
                console.log(file);
            });
            this.on('getSelectedImage', function () {
                return "file"
            });
        }
    });







    $('#btnApprove').hide();
    $('#btnReject').hide();
    $('#btnattach').hide();
    $('#tbl_attachment').hide();
    $('.table-responsive').hide();

    $('.select2').select2();
    memberShip();
    $('#btncontribution').on('click', function () {
        $('input[type="text"]').val('');
        $('input[type="number"]').val('');
        $('input[type="date"]').val('');
        $('input[type="textarea"]').val('');


    });



    $('#txtmembershipno').change(function () {
        var id = $(this).val();
        getalldetails(id);
    })
    $('#btnReset').on('click', function () {
        resetForm();
    });
    $('#btnattach').on('click', function () {
        $('#Attachment_modal').modal('show');
        $('#txtDescription').val('');
        var dropzoneSingle = Dropzone.forElement('#dropzone_single');
        dropzoneSingle.removeAllFiles();

    });
    $('#attachment_save').on('click', function () {
        saveattachment();

    });
    $('#attachmentclose').on('click', function () {
        $('#Attachment_modal').modal('hide');


    });


    var mid;
    if (window.location.search.length > 0) {
        var sPageURL = window.location.search.substring(1);
        var param = sPageURL.split('?');
        mid = param[0].split('=')[1].split('&')[0];
        action = param[0].split('=')[2].split('&')[0];
        if (action == 'approval') {
            $('#btnsave').hide();
            $('#btnReset').hide();
            $('#btnApprove').show();
            $('#btnReject').show();
            $('#btnattach').show();
            $('#tbl_attachment').show();
            $('.table-responsive').show();
           

        }
        else if (action == 'edit') {
            $('#btnsave').text('Update');
            $('#btnattach').show();
            $('#tbl_attachment').show();
            $('.table-responsive').show();

            //console.log(action);
        } else if (action == 'view') {
            $('#btnSave').hide();
            getcontributeview(mid);
          

        }

        getmemberlone(mid);

    }

    $('#btnsave').on('click', function (event) {

        bootbox.confirm({
            title: 'Save confirmation',
            message: '<div class="d-flex justify-content-center align-items-center mb-3"><i id="question-icon" class="fa fa-question fa-5x text-warning animate-question"></i></div><div class="d-flex justify-content-center align-items-center"><p class="h2">Are you sure?</p></div>',
            buttons: {
                confirm: {
                    label: '<i class="fa fa-check"></i>&nbsp;Yes',
                    className: 'btn-warning'
                },
                cancel: {
                    label: '<i class="fa fa-times"></i>&nbsp;No',
                    className: 'btn-link'
                }
            },
            callback: function (result) {
                console.log(result);
                if (result) {
                    if ($('#btnsave').text() == 'Save') {

                        save_memberlonrequest();
                    } else if ($('#btnsave').text() == 'Update') {
                        update_memberlonrequest();
                    }
                } else {

                }
            },
            onShow: function () {
                $('#question-icon').addClass('swipe-question');
            },
            onHide: function () {
                $('#question-icon').removeClass('swipe-question');
            }
        });

        $('.bootbox').find('.modal-header').addClass('bg-warning text-white');


    });

    // reject 

    $('#btnReject').on('click', function () {
        bootbox.confirm({
            title: 'Reject confirmation',
            message: '<div class="d-flex justify-content-center align-items-center mb-3"><i class="fa fa-times fa-5x text-danger" ></i></div><div class="d-flex justify-content-center align-items-center "><p class="h2">Are you sure?</p></div>',
            buttons: {
                confirm: {
                    label: '<i class="fa fa-check"></i>&nbsp;Yes',
                    className: 'btn-Danger'
                },
                cancel: {
                    label: '<i class="fa fa-times"></i>&nbsp;No',
                    className: 'btn-link'
                }
            },
            callback: function (result) {
                console.log(result);
                if (result) {
                    rejectRequest(mid);
                    closeCurrentTab()
                    window.opener.location.reload();
                } else {

                }
            }
        });
        $('.bootbox').find('.modal-header').addClass('bg-danger text-white');


    })


    //approve
    $('#btnApprove').on('click', function () {
        bootbox.confirm({
            title: 'Approval confirmation',
            message: '<div class="d-flex justify-content-center align-items-center mb-3"><i id="question-icon" class="fa fa-question fa-5x text-warning animate-question"></i></div><div class="d-flex justify-content-center align-items-center"><p class="h2">Are you sure?</p></div>',
            buttons: {
                confirm: {
                    label: '<i class="fa fa-check"></i>&nbsp;Yes',
                    className: 'btn-warning'
                },
                cancel: {
                    label: '<i class="fa fa-times"></i>&nbsp;No',
                    className: 'btn-link'
                }
            },
            callback: function (result) {
                //console.log('Confirmation result:', result);
                if (result) {
                    approveRequest(mid);
                    closeCurrentTab()
                    window.opener.location.reload();
                } else {

                }
            },
            onShow: function () {
                $('#question-icon').addClass('swipe-question');
            },
            onHide: function () {
                $('#question-icon').removeClass('swipe-question');
            }
        });

        $('.bootbox').find('.modal-header').addClass('bg-warning text-white');

    })




});


function save_memberlonrequest() {



    formData.append('txtmembershipno', $('#txtmembershipno').val());
    console.log($('#txtmembershipno').val());
    // formData.append('name', $('#name').val());
    //formData.append('txtDesignation', $('#txtDesignation').val());

    //formData.append('txtStaffno', $('#txtStaffno').val());
    //formData.append('txtmembershipno', $('#txtmembershipno').val());
    //formData.append('txtplaseemployment', $('#txtplaseemployment').val());

    // formData.append('txtStaffno', $('#txtbirthday').val());
    //.append('txtnic', $('#txtnic').val());
    //formData.append('txtpaysheetno', $('#txtpaysheetno').val());

    formData.append('txtcontactno', $('#txtcontactno').val());
    //formData.append('txtmembershipyear', $('#txtmembershipyear').val());
    formData.append('txtpriodofservice', $('#txtpriodofservice').val());

    formData.append('txtdateofenlistment', $('#txtdateofenlistment').val());
    formData.append('txtpresetmonthlybSalary', $('#txtpresetmonthlybSalary').val());
    //formData.append('txtcomputerno', $('#txtcomputerno').val());

    //formData.append('txtnicNo2', $('#txtnicNo2').val());
    formData.append('txtManageofrepayment', $('#txtManageofrepayment').val());
    formData.append('txtresontoobtain', $('#txtresontoobtain').val());

    formData.append('txtprivetAddress', $('#txtprivetAddress').val());
    formData.append('txtdate', $('#txtdate').val());


    console.log(formData);


    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: '/save_memberlonrequest',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 800000,
        beforeSend: function () {

        },
        success: function (response) {
            //suplyGroupAllData();
            // $('#modalmemberlonrequest').modal('hide');
            // allmemberlonrequest()
            resetForm();
            new Noty({
                text: 'Successfully saved',
                type: 'success'
            }).show();


        },
        error: function (error) {
            //showErrorMessage('Something went wrong');
            new Noty({
                text: 'Something went wrong',
                type: 'error'
            }).show();
            console.log(error);

        },
        complete: function () {

        }

    });


}

function getmemberlone(id) {
    //$('#btnsave').text('Update');
    getAttachment();
    $.ajax({
        url: '/getmemberlone/' + id,
        method: 'get',

        success: function (response) {
            console.log(response);


            $('#id').val(response.members_loan_request_id);
            $("#txtmembershipno").val(response.membership_no).trigger('change');
            $('#txtcontactno').val(response.contact_no);
            $('#txtpriodofservice').val(response.service_period);

            $('#txtdateofenlistment').val(response.date_of_enlistment);
            $('#txtpresetmonthlybSalary').val(response.Monthly_basic_salary);
            //$('#txtcomputerno').val(response.computer_no);


            //$('#txtnicNo2').val(response.nic_no);
            $('#txtManageofrepayment').val(response.manner_of_repayment);
            $('#txtresontoobtain').val(response.reason);


            $('#txtprivetAddress').val(response.private_address);
            $('#txtdate').val(response.date);
            // $('#txtcomputerno').val(response.description);




        }
    });
}

function update_memberlonrequest() {
    var id = $('#id').val();



    formData.append('txtmembershipno', $('#txtmembershipno').val());
    console.log($('#txtmembershipno').val());
    // formData.append('name', $('#name').val());
    //formData.append('txtDesignation', $('#txtDesignation').val());

    //formData.append('txtStaffno', $('#txtStaffno').val());
    //formData.append('txtmembershipno', $('#txtmembershipno').val());
    //formData.append('txtplaseemployment', $('#txtplaseemployment').val());

    // formData.append('txtStaffno', $('#txtbirthday').val());
    //.append('txtnic', $('#txtnic').val());
    //formData.append('txtpaysheetno', $('#txtpaysheetno').val());

    formData.append('txtcontactno', $('#txtcontactno').val());
    //formData.append('txtmembershipyear', $('#txtmembershipyear').val());
    formData.append('txtpriodofservice', $('#txtpriodofservice').val());

    formData.append('txtdateofenlistment', $('#txtdateofenlistment').val());
    formData.append('txtpresetmonthlybSalary', $('#txtpresetmonthlybSalary').val());
    //formData.append('txtcomputerno', $('#txtcomputerno').val());

    //formData.append('txtnicNo2', $('#txtnicNo2').val());
    formData.append('txtManageofrepayment', $('#txtManageofrepayment').val());
    formData.append('txtresontoobtain', $('#txtresontoobtain').val());

    formData.append('txtprivetAddress', $('#txtprivetAddress').val());
    formData.append('txtdate', $('#txtdate').val());

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: '/update_memberlonrequest/' + id,
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 800000,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        timeout: 800000,
        beforeSend: function () {

        },
        success: function (response) {
            //suplyGroupAllData();
            // $('#modalmemberlonrequest').modal('hide');

            //allmemberlonrequest()
            closeCurrentTab()
            window.opener.location.reload();
            new Noty({
                text: 'Successfully updated',
                type: 'success',
            }).show();
        },
        error: function (error) {
            //showErrorMessage('Something went wrong');
            //$('#modalmemberlonrequest').modal('hide');
            console.log(error);

        },
        complete: function () {

        }

    });

}

// save Attachment 

function saveattachment() {
    var id = $('#id').val();
    var Description = $('#txtDescription').val();
    var file = dropzoneSingle.selectedImage;

    formData.append('file', dropzoneSingle.selectedImage);

    formData.append('file', dropzoneSingle.selectedImage);
    formData.append('txtDescription', $('#txtDescription').val());

    if (Description !== "" && file !== undefined) {


        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: '/saveattachment/' + id,
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            timeout: 800000,
            beforeSend: function () {

            },
            success: function (response) {
                //suplyGroupAllData();
                $('#Attachment_modal').modal('hide');
                $('input[type="textarea"]').val('');
                getAttachment();
                //allmemberlonrequest()

                new Noty({
                    text: 'Successfully saved',
                    type: 'success',
                }).show();
            },
            error: function (error) {
                //showErrorMessage('Something went wrong');
                //$('#modalmemberlonrequest').modal('hide');
                console.log(error);

            },
            complete: function () {

            }

        });
    } else {
        new Noty({
            text: 'Something went wrong',
            type: 'error'
        }).show();

    }

}

function getAttachment() {
    var id = $('#id').val();
    $.ajax({
        type: 'GET',
        url: '/getAttachment/' + id,
        success: function (response) {
            console.log(response);
            var dt = response;
            console.log(dt);
            var data = [];
            for (i = 0; i < response.length; i++) {

                var dt = response;



                var data = [];
                for (var i = 0; i < dt.length; i++) {



                    data.push({
                        "id": dt[i].members_loan_request_attachment_id,
                        "description": dt[i].description,
                        "attachment": dt[i].attachment,
                        "action": '<button class="btn btn-success btn-sm" type="button"  onclick="view(' + dt[i].members_loan_request_attachment_id + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>&#160<button type="button" class="btn btn-danger btn-sm" id="attachmentdelete" onclick="_delete(' + dt[i].members_loan_request_attachment_id + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>&#160<button type="button" class="btn btn-primary btn-sm" onclick="download(' + dt[i].members_loan_request_attachment_id + ')"><i class="fa fa-download" aria-hidden="true"></i></button>',
                    });
                }



            }
            var table = $('#tbl_attachment').DataTable();
            table.clear();
            table.rows.add(data).draw();

        },
        error: function (data) {
            console.log(data);
        }, complete: function () {

        }
    });
}

function getcontributeview(id) {
   
    

    $('#btnsave').hide();
    $('#btnReset').hide();
    $('input[type="text"]').prop('disabled', true);
    $('input[type="number"]').prop('disabled', true);
    $('input[type="date"]').prop('disabled', true);
    $('textarea').prop('disabled', true);
    $('select').prop('disabled', true);
    $('#txtmembershipno').removeClass('form-select select2').addClass('form-control  select2');
    $('#tbl_attachment').show();
    $('.table-responsive').show();
   
    $.ajax({
        url: '/getmemberlone/' + id,
        method: 'get',


        success: function (response) {
            console.log(response);
           
            $('#id').val(response.members_loan_request_id);
            $("#txtmembershipno").val(response.membership_no).trigger('change');
            $('#txtcontactno').val(response.contact_no);
            $('#txtpriodofservice').val(response.service_period);

            $('#txtdateofenlistment').val(response.date_of_enlistment);
            $('#txtpresetmonthlybSalary').val(response.Monthly_basic_salary);

            $('#txtManageofrepayment').val(response.manner_of_repayment);
            $('#txtresontoobtain').val(response.reason);


            $('#txtprivetAddress').val(response.private_address);
            $('#txtdate').val(response.date);



        }
    });
}

/*
function cbxcontribute(id) {
    var status = $('#contribute').is(':checked') ? 1 : 0;


    $.ajax({
        url: '/cbxcontribute/'+id,
        type: 'POST',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'status': status
        },
        success: function (response) {
            new Noty({
                text: 'Successfully save',
                type: 'success',
            }).show();

            //allmemberlonrequest()
         console.log("data save");
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}*/


function memberShip() {

    $.ajax({
        url: '/memberShip',
        type: 'get',
        dataType: 'json',
        // async: false,


        success: function (data) {
            var dt = data.data
            var htmlContent;
            htmlContent += "<option value='0'>Select Membership No</option>";
            for (var i = 0; i < dt.length; i++) {
                htmlContent += "<option value='" + dt[i].id + "'>" + dt[i].member_number + "</option>";
            }

            // Set the HTML content of the select element after the loop
            $('#txtmembershipno').html(htmlContent);

        }, error: function (data) {
            console.log(data)
        }

    })

}
function getalldetails(id) {
    $.ajax({
        url: '/getalldetails/' + id,
        type: 'get',
        dataType: 'json',
        // async: false,


        success: function (response) {
            console.log(response);


            $('#txtcomputerno').val(response[0].computer_number);
            $('#name').val(response[0].name_initials);
            $('#txtDesignation').val(response[0].name);
            $('#txtStaffno').val(response[0].payroll_number);

            $("#txtplaseemployment").val(response[0].plase);
            $('#txtbirthday').val(response[0].date_of_birth);
            $('#txtnic').val(response[0].national_id_number);

            $("#txtpaysheetno").val(response[0].payroll_number);
            $('#txtmembershipyear').val(response[0].date_of_joining);



            //$('#txtnicNo2').val(response[0].nic_no);

        }, error: function (data) {
            console.log(data)
        }

    })
}

function resetForm() {
    //$('.validation-invalid-label').empty();
    $('#memberform').trigger('reset');
    $('#txtmembershipno').val(0);
}
function closeCurrentTab() {
    window.close(); // This will close the current tab or window
}

//approve
function approveRequest(id) {
    $.ajax({
        url: '/approveRequest/' + id,
        type: 'post',
        enctype: 'multipart/form-data',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        timeout: 800000,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            /* $('#btnSave').prop('disabled', true); */
        }, success: function (response) {
            /*   $('#btnSave').prop('disabled', false);*/
            var status = response.status
            console.log(status);
            if (status) {
                showSuccessMessage("Request approved");

                $('#btnApprove').prop('disabled', true);
                $('#btnReject').prop('disabled', true);

                window.opener.location.reload();

            } else {

                showErrorMessage("Something went wrong");
            }

        }, error: function (data) {
            console.log(data.responseText)
        }, complete: function () {

        }

    })
}

//reject
function rejectRequest(id) {
    $.ajax({
        url: '/rejectRequest/' + id,
        type: 'post',
        enctype: 'multipart/form-data',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        timeout: 800000,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
            /* $('#btnSave').prop('disabled', true); */
        }, success: function (response) {
            /*   $('#btnSave').prop('disabled', false);*/
            var status = response.status
            console.log(status);
            if (status) {
                showSuccessMessage("Request rejected");

                $('#btnApprove').prop('disabled', true);
                $('#btnReject').prop('disabled', true);

               

            } else {

                showErrorMessage("Something went wrong");
            }

        }, error: function (data) {
            console.log(data.responseText)
        }, complete: function () {

        }

    })
}
function view(id) {

    $.ajax({
        url: '/viewAttachment/' + id,
        type: 'get',
        dataType: 'json',
        // async: false,


        success: function (response) {
            console.log(response);
            window.open(response.attachment, '_blank');

          
            console.log(data)
        }

    })
    // Open a new tab or window with the PDF URL
    //window.open(id, '_blank');
}


function _delete(id) {
    if (action == 'view'){

}else{




    bootbox.confirm({
        title: 'Delete confirmation',
        message: '<div class="d-flex justify-content-center align-items-center mb-3"><i class="fa fa-times fa-5x text-danger" ></i></div><div class="d-flex justify-content-center align-items-center "><p class="h2">Are you sure?</p></div>',
        buttons: {
            confirm: {
                label: '<i class="fa fa-check"></i>&nbsp;Yes',
                className: 'btn-Danger'
            },
            cancel: {
                label: '<i class="fa fa-times"></i>&nbsp;No',
                className: 'btn-info'
            }
        },
        callback: function (result) {
            console.log(result);
            if (result) {
                deletattachment(id);
            } else {

            }
        }
    });
    $('.bootbox').find('.modal-header').addClass('bg-danger text-white');
}

}

function deletattachment(id) {

    $.ajax({
        type: 'DELETE',
        url: '/deletattachment/' + id,
        data: {
            _token: $('input[name=_token]').val()
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {

        }, success: function (response) {


            if (response.success) {

                getAttachment();
                new Noty({
                    text: 'Successfully deleted',
                    type: 'success',
                }).show();
                allmemberlonrequest()
            } else {

                new Noty({
                    text: 'Uneble to Delete',
                    type: 'error'
                }).show();
            }


        }, error: function (xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
}
function download(attachmentId) {
    $.ajax({
        url: '/viewAttachment/' + attachmentId,
        type: 'get',
        dataType: 'json',
        // async: false,


        success: function (response) {
           // var fileName = response.attachment;

            var attachmentData = response.attachment;
           // var fileName = response.filename;

            // Create a Blob object from the attachment data
            var blob = new Blob([attachmentData], { type: 'pdf' });

            // Create a temporary URL for the Blob
            var url = window.URL.createObjectURL(blob);

            // Create an anchor element for downloading
            var a = document.createElement('a');
            a.style.display = 'flex';
            a.href = url;
            a.download = attachmentData; // Set the desired file name

            // Trigger a click event on the anchor element to initiate the download
            document.body.appendChild(a);
            a.click();
            
            // Clean up the temporary URL
            //window.URL.revokeObjectURL(url);
        },
        error: function (data) {
            console.log(data);
        }

    })
}