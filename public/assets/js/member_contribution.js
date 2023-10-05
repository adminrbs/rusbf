
var nameid = 0;
var memberid = 0;
$(document).ready(function () {
    $('.select2').select2();

    Fullname(memberid)
    memberNumber(nameid)
    imageloard(memberid);

    $('#cmbmember').change(function () {
        memberid = $(this).val();
        Fullname(memberid)
        imageloard(memberid);

    })

    $('#cmbName').change(function () {
        nameid = $(this).val();

        memberNumber(nameid)
        imageloard(nameid)
    })

});


function memberNumber(id) {
    $('#cmbmember').empty();
    $.ajax({
        url: '/memberNumber/' + id,
        type: 'get',
        async: false,
        success: function (data) {
            var htmlContent = "";
           

            $.each(data, function (key, value) {

                htmlContent += "<option value='" + value.id + "'>" + value.member_number + "</option>";
            });
            $('#cmbmember').html(htmlContent);
           

        }, error: function (data) {
            console.log(data)
        }

    })

}


//loading location
function Fullname(id) {

    $('#cmbName').empty();
    $.ajax({
        url: '/fullName/' + id,
        type: 'get',
        async: false,
        success: function (data) {
console.log(data);
            var htmlContent = "";
           

            $.each(data, function (key, value) {

                htmlContent += "<option value='" + value.id + "'>" + value.full_name + "</option>";
            });
            $('#cmbName').html(htmlContent);
          
        },
    })
}


function imageloard(id) {

    if (id == 0 || id==null) {
      
        var defaultImageUrl = 'images/userimage.png';

       
        var imageElement = document.getElementById('loadedImage');

        // Set the src attribute to the default image URL
        imageElement.src = defaultImageUrl;
    }else{

    $.ajax({
        url: '/imageloard/' + id,
        type: 'get',
        async: false,
        success: function (response) {

            $.each(response, function (key, value) {
             
                var imageElement = document.getElementById('loadedImage');

               
                imageElement.src = value.path;
            });


        },
    })
    }

}