const menuIcon = document.getElementById("menuIcon");                                    
const closeArrow = document.getElementById("closeArrow");
const menu = document.getElementById("menu");
const alertBox = document.getElementById("alert");
menuIcon.addEventListener("click", ()=>{
    menu.classList.add("active");
});
closeArrow.addEventListener("click", ()=>{
    menu.classList.remove("active");
});

$(document).ready(function(){
    $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'circle'
        },
        boundary: {height:300}    
    });
    $image_crop.croppie('result', {
        size: {width: 250, height: 250},
        circle: true
    })

    $('#insert_image').on('change', function(){
        var reader = new FileReader();
        reader.onload = function (event) {
            $image_crop.croppie('bind', {
                url: event.target.result
            }).then(function(){
                console.log('ok');
            });
            $('#image_demo').addClass('visible');
            $('.cr-slider').addClass('form-range');
        }
        reader.readAsDataURL(this.files[0]);
    });

    $('.crop_image').click(function(event){
        var ID_athlete = document.getElementById('ID_athlete').value;
        var password = document.getElementById('password').value;
        $image_crop.croppie('result', {
        type: 'canvas',
        size: 'viewport'
        }).then(function(response){
            $.ajax({
                url:'../private/modules/uploadProfilePhoto.php',
                type:'POST',
                data:{
                    "image":response, 
                    "ID_athlete": ID_athlete,
                    "password": password
                },
                success: function($data){
                    $('#imgContainer').load(document.URL +  ' #imgContainerAux');
                    $('#imgContainer2').load(document.URL +  ' #imgContainerAux2');
                    alertBox.style.opacity = "1";
                    $("#alert").html($data);
                    setTimeout(()=>{
                        alertBox.style.opacity = "0";
                    }, 2000);
                }
            });
        });
    });

});