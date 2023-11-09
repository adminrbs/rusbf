
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
var memberid;


var formData = new FormData();
$(document).ready(function () {
    getdeathgratuityAttachment();
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

    $('input[type="text"]').val('');
    $('input[type="number"]').val('');
    $('input[type="date"]').val('');
    $('input[type="textarea"]').val('');
    $('input.select2').val('');

    $('#btnApprove').hide();
    $('#btnReject').hide();
    $('#btnattach').hide();
    $('#tbl_attachment').hide();
    $('.table-responsive').hide();

    $('.select2').select2();
    memberShip(0);
    getdepartmentsection();
    getPosition();

    /*$('#cbxgetdepartmentsection').on('change', function () {
        var lonId = $(this).val();
        getPosition(lonId);
    });*/
    $('#btncontribution').on('click', function () {
        $('input[type="text"]').val('');
        $('input[type="number"]').val('');
        $('input[type="date"]').val('');
        $('input[type="textarea"]').val('');
        $('input.select2').val('');


    });



    $('#cmbnameinfull').on('change', function () {
        memberid = $(this).val();


       // getalldetails(memberid, 1);
        memberShip(memberid);
    })
    $('#txtmembreshipno').on('change', function () {
        var memberid = $(this).val();

        memberShip(memberid);
    })
    $('#cmbofficialid').on('change', function () {
        var memberid = $(this).val();

        memberShip(memberid);
    })
    $('#cmbdateofmembership').on('change', function () {
        var memberid = $(this).val();

        memberShip(memberid);
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
           // getcontributeview(mid);
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

        }

        getdeathgratuityrequest(mid);

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

                        saveDeathgratuityrequests();
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


function saveDeathgratuityrequests() {

        formData.append('txtmembershipno',memberid )

        formData.append('txtPosition', $('#txtPosition').val());
        formData.append('txtfullnameofthedeceasedperson', $('#txtfullnameofthedeceasedperson').val());
        formData.append('txtdepartmentsection', $('#txtdepartmentsection').val());

        formData.append('txtdateandplaseofdeath', $('#txtdateandplaseofdeath').val());
        formData.append('txtrelationshiptothedeceased', $('#txtrelationshiptothedeceased').val());
        formData.append('txtageifthedeceasedchildmember', $('#txtageifthedeceasedchildmember').val());

        formData.append('txtGenderdeceasedperson', $('#txtGenderdeceasedperson').val());
        formData.append('txtDeathcertificateNo', $('#txtDeathcertificateNo').val());
        formData.append('txtIssueddate', $('#txtIssueddate').val());

        formData.append('txtissuedplace', $('#txtissuedplace').val());
        formData.append('txtbirthcertificateno', $('#txtbirthcertificateno').val());
        formData.append('txtmarriagecertificateeno', $('#txtmarriagecertificateeno').val());
        formData.append('txtreceiptofofficechargecertificate', $('#txtreceiptofofficechargecertificate').val());
        formData.append('txtoutherdetails', $('#txtoutherdetails').val());
        formData.append('txtgsdate',$('#txtgsdate').val());
      

        console.log(formData);


        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: '/saveDeathgratuityrequests',
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
             if( response.status == true)  {
                resetForm();
                new Noty({
                    text: 'Successfully saved',
                    type: 'success'
                }).show();
            }else{
                new Noty({
                    text: 'Something went wrong',
                    type: 'error'
                }).show();
}

            },
            error: function (error) {
                //showErrorMessage('Something went wrong');
                new Noty({
                    text: 'Something went wrong',
                    type: 'error'
                }).show();
                //console.log(error);

            },
            complete: function () {

            }

        });
    


}

function getdeathgratuityrequest(id) {
    //$('#btnsave').text('Update');
    getdeathgratuityAttachment();
    $.ajax({
        url: '/getdeathgratuityrequest/' + id,
        method: 'get',

        success: function (response) {
            console.log("deathgratuity", response);
            //getPosition(response.loan_id);

            $('#id').val(response.death_gratuity_requestss_id );
            $("#cmbnameinfull").val(response.member_id).trigger('change');
            $('#txtPosition').val(response.designation_id).trigger('change');
            $('#txtdepartmentsection').val(response.serving_sub_department_id).trigger('change');

            $('#txtfullnameofthedeceasedperson').val(response.full_name_of_the_deceased_person);
            $('#txtdateandplaseofdeath').val(response.date_and_place_of_death);
            $('#txtrelationshiptothedeceased').val(response.relationship_to_the_deceased_person);


            $('#txtageifthedeceasedchildmember').val(response.age_of_deceased);
            $('#txtGenderdeceasedperson').val(response.gender_of_deceased_person).trigger('change');
            $('#txtDeathcertificateNo').val(response.death_certificate_No);


            $('#txtIssueddate').val(response.issued_date);
            $('#txtissuedplace').val(response.issued_place);
             $('#txtbirthcertificateno').val(response.birth_certificate_no);
            $('#txtmarriagecertificateeno').val(response.marriage_certificate_no);
            $('#txtgsdate').val(response.gs_date);
            $('#txtreceiptofofficechargecertificate').val(response.date_of_oic);
            $('#txtoutherdetails').val(response.note);

            getdeathgratuityAttachment()




        }
    });
}

function update_memberlonrequest() {
    var id = $('#id').val();

    formData.append('txtmembershipno',memberid )

    formData.append('txtPosition', $('#txtPosition').val());
    formData.append('txtfullnameofthedeceasedperson', $('#txtfullnameofthedeceasedperson').val());
    formData.append('txtdepartmentsection', $('#txtdepartmentsection').val());

    formData.append('txtdateandplaseofdeath', $('#txtdateandplaseofdeath').val());
    formData.append('txtrelationshiptothedeceased', $('#txtrelationshiptothedeceased').val());
    formData.append('txtageifthedeceasedchildmember', $('#txtageifthedeceasedchildmember').val());

    formData.append('txtGenderdeceasedperson', $('#txtGenderdeceasedperson').val());
    formData.append('txtDeathcertificateNo', $('#txtDeathcertificateNo').val());
    formData.append('txtIssueddate', $('#txtIssueddate').val());

    formData.append('txtissuedplace', $('#txtissuedplace').val());
    formData.append('txtbirthcertificateno', $('#txtbirthcertificateno').val());
    formData.append('txtmarriagecertificateeno', $('#txtmarriagecertificateeno').val());
    formData.append('txtreceiptofofficechargecertificate', $('#txtreceiptofofficechargecertificate').val());
    formData.append('txtoutherdetails', $('#txtoutherdetails').val());
    formData.append('txtgsdate',$('#txtgsdate').val());

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: '/update_deathgratuity/' + id,
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
            url: '/deathgratuitysaveattachment/' + id,
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
                getdeathgratuityAttachment();
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

function getdeathgratuityAttachment() {
    var id = $('#id').val();

    $.ajax({
        type: 'GET',
        url: '/getdeathgratuityAttachment/' + id,
        success: function (response) {
            console.log(response);
            var dt = response;
            console.log(dt);
           
                var data = [];
                for (var i = 0; i < dt.length; i++) {
                    var attachment = dt[i].attachment;
                    var parts = attachment.split('.');
                    var Attachment = parts[1];



                    data.push({
                        "id": dt[i].death_gratuity_requests_attachments_id ,
                        "description": dt[i].description,
                        "attachment": Attachment,
                        "action": '<button title="View" class="btn btn-success btn-sm" type="button"  onclick="view(' + dt[i].death_gratuity_requests_attachments_id  + ')"><i class="fa fa-eye" aria-hidden="true"></i></button>&#160<button title="Delete" type="button" class="btn btn-danger btn-sm" id="attachmentdelete" onclick="_delete(' + dt[i].death_gratuity_requests_attachments_id  + ')"><i class="fa fa-trash" aria-hidden="true"></i></button>&#160<button title="Download" type="button" class="btn btn-primary btn-sm" onclick="download(' + dt[i].death_gratuity_requests_attachments_id  + ')"><i class="fa fa-download" aria-hidden="true"></i></button>',
                    });
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


function memberShip(id) {
var mid = id
    $.ajax({
        url: '/alldatamemberShip/' + id,
        type: 'get',
        dataType: 'json',
        // async: false,


        success: function (response) {
if(mid>0){
    $('#cmbnameinfull').html('');
    $('#txtmembreshipno').html('');
    $('#cmbofficialid').html('');
    $('#cmbdateofmembership').html('');

    var dt = response.data;

    for (var i = 0; i < dt.length; i++) {

        $('#cmbnameinfull').append("<option value='" + dt[i].id + "'>" + dt[i].full_name + "</option>");
        $('#txtmembreshipno').append("<option value='" + dt[i].id + "'>" + dt[i].member_number + "</option>");
        $('#cmbofficialid').append("<option value='" + dt[i].id + "'>" + dt[i].official_number + "</option>");
         $('#cmbdateofmembership').append("<option value='" + dt[i].id + "'>" + dt[i].date_of_joining + "</option>");

    }
    $('#txtaddressinfull').val(dt[0].personal_address);

}else{


    var dt = response.data

    var cmbnameinfull = "<option value='0'>Select Name In Full</option>";
    var txtmembreshipno = "<option value='0'>Select Membership No</option>";
    var cmbofficialid = "<option value='0'>Select Official Id</option>";
    var cmbdateofmembership = "<option value='0'>Select Date of Membership</option>";


    for (var i = 0; i < dt.length; i++) {
       // console.log(dt[i].full_name);
        cmbnameinfull += "<option value='" + dt[i].id + "'>" + dt[i].full_name + "</option>";
        txtmembreshipno += "<option value='" + dt[i].id + "'>" + dt[i].member_number + "</option>";
        cmbofficialid += "<option value='" + dt[i].id + "'>" + dt[i].official_number + "</option>";
        cmbdateofmembership += "<option value='" + dt[i].id + "'>" + dt[i].date_of_joining + "</option>";
    }

    // Set the HTML content of the select elements after the loop
    $('#cmbnameinfull').html(cmbnameinfull);
    $('#txtmembreshipno').html(txtmembreshipno);
    $('#cmbofficialid').html(cmbofficialid);
    $('#cmbdateofmembership').html(cmbdateofmembership);

}     
           

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



    formData.append('txtmembershipno', memberid);

    $.ajax({
        url: '/approvedeathgratuityRequest/' + id,
        type: 'get',
      
        beforeSend: function () {
            /* $('#btnSave').prop('disabled', true); */
        }, success: function (response) {
            /*   $('#btnSave').prop('disabled', false);*/
            var status = response.status
            // console.log(status);
            if (status) {
                showSuccessMessage("Request approved");

                $('#btnApprove').prop('disabled', true);
                $('#btnReject').prop('disabled', true);

                //window.opener.location.reload();

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
        url: '/rejectdeathgratuityRequest/' + id,
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
        url: '/viewdeathgratuityAttachment/' + id,
        type: 'get',
        dataType: 'json',
        // async: false,


        success: function (response) {
            console.log(response);
var filepath =response.attachment;



            var fileUrl = filepath ;

           
            window.open(fileUrl, '_blank');
        }

    })
    // Open a new tab or window with the PDF URL
    //window.open(id, '_blank');
}


function _delete(id) {
    



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

function deletattachment(id) {

    $.ajax({
        type: 'DELETE',
        url: '/deletadeathgratuityttachment/' + id,
        data: {
            _token: $('input[name=_token]').val()
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {

        }, success: function (response) {


            if (response == "deleted") {

                getdeathgratuityAttachment();
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
        url: '/viewdeathgratuityAttachment/' + attachmentId,
        type: 'get',
        dataType: 'json',
        // async: false,


        success: function (response) {
           
            var attachmentData = response.attachment;
           
            var blob = new Blob([attachmentData], { type: 'pdf' });
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.style.display = 'flex';
            a.href = url;
            a.download = attachmentData; 

            document.body.appendChild(a);
            a.click();
        },
        error: function (data) {
            console.log(data);
        }

    })
}


function getdepartmentsection() {

    $.ajax({
        url: '/getdepartmentsection',
        type: 'get',
        dataType: 'json',
        // async: false,


        success: function (data) {
            var dt = data.data
            var htmlContent;
           
            for (var i = 0; i < dt.length; i++) {
                htmlContent += "<option value='" + dt[i].id + "'>" + dt[i].name + "</option>";
            }

            // Set the HTML content of the select element after the loop
            $('#txtdepartmentsection').html(htmlContent);

        }, error: function (data) {
            console.log(data)
        }

    })

}


function getPosition() {
   
    $.ajax({
        url: '/getPosition',
        type: 'get',
        //dataType: 'json',
        async: false,
        success: function (data) {

            var dt = data.data

            var htmlContent;
           
            for (var i = 0; i < dt.length; i++) {
                htmlContent += "<option value='" + dt[i].id + "'>" + dt[i].name + "</option>";
            }

            // Set the HTML content of the select element after the loop
            $('#txtPosition').html(htmlContent);



        }, error: function (response) {
            console.log(response)
        }

    })

}

