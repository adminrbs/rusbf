var dropzoneSingle = undefined;
var print_list = [];
$(document).ready(function () {
    $('.select2').select2();
    initDropzone();
    membername();

});

function initDropzone() {

    // Single files
    dropzoneSingle = new Dropzone("#dropzone_single", {
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: 2, // MB
        maxFiles: 1,
        acceptedFiles: ".jpeg,.jpg,.png",
        dictDefaultMessage: 'Drop file to upload <span>or CLICK</span> (File formats: jpeg,jpg,png)',
        autoProcessQueue: false,
        addRemoveLinks: true,
        selectedImage: undefined,
        imageIcon: undefined,
        status: "new",
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

                    }
                };

                if (file.name != 'image') {
                    reader.readAsDataURL(file);
                }

                if (this.fileTracker) {
                    this.removeFile(this.fileTracker);
                }
                this.fileTracker = file;
            });
            this.on('removedfile', function (file) {
                $('.dz-default').remove();
                $('.dz-clickable').append('<div class="dz-default dz-message"><button class="dz-button" type="button">Drop file to upload <span>or CLICK</span> (File formats: jpeg,jpg,png)</button></div>');
                // this.selectedImage = undefined;
                this.status = "new";
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
    // End of Single files
}

function openWebCam() {

    if ($('#btnTakePhoto').text() == 'Take a photo') {
        stopWebCam();
        return;
    }
    $('#imgWebCam').hide();
    $('#videoTag').show();

    var video = document.querySelector("#videoElement");

    if (navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function (stream) {
                $('#btnTakePhoto').text('Take a photo');
                video.srcObject = stream;
            })
            .catch(function (err0r) {
                console.log("Something went wrong!");
            });
    }
}


function stopWebCam() {

    var video = document.querySelector("#videoElement");
    var stream = video.srcObject;
    var tracks = stream.getTracks();
    console.log(tracks);

    var canvas = document.createElement("canvas");
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    var ctx = canvas.getContext("2d");
    ctx.drawImage(videoElement, 0, 0, video.videoWidth, video.videoHeight + 30);
    var dataURL = canvas.toDataURL();

    var mockFile = { name: 'image', size: 12345, type: 'image/png' };
    dropzoneSingle.emit("addedfile", mockFile);
    dropzoneSingle.emit("thumbnail", mockFile, dataURL);
    dropzoneSingle.emit("success", mockFile);
    dropzoneSingle.processQueue();

    $('.dz-default').remove();

    for (var i = 0; i < tracks.length; i++) {
        var track = tracks[i];
        track.stop();
        $('#btnTakePhoto').text('Open Webcam');
    }

    video.srcObject = null;

}

function membername() {

    $.ajax({
        url: '/selectMember',
        type: 'get',
        async: false,
        success: function (response) {
            console.log(response);
            var htmlContent = "";


            $.each(response, function (key, value) {

                htmlContent += "<option value='" + value.id + "'>" + value.full_name + "</option>";
            });
            $('#selectMember').html(htmlContent);

        },
    })
}