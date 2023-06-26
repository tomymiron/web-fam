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

var ROW_HEIGHT = 1;
var scrollTop, offsetH;
var els = document.getElementsByTagName('textarea');
for (var i = 0; i < els.length; i++){
    els[i].style.height = 'auto';
    els[i].style.overflow = 'hidden';
    els[i].style.height = els[i].scrollHeight - ROW_HEIGHT + "px";
    els[i].addEventListener('input', fit, false);
}
function fit(){
    while(this.scrollHeight <= this.offsetHeight && this.offsetHeight > ROW_HEIGHT){
        this.style.height = this.offsetHeight - ROW_HEIGHT + "px";
    }
    this.style.height = this.scrollHeight + "px";
}

function update(dniClub){
    var password = $('#password').val();
    var inputDescription = $('#inputDescription').val();
    var inputPlace = $('#inputPlace').val();
    var inputPresident = $('#inputPresident').val();
    let validationFlag = true;

    if(inputDescription.length <= 0){
        $('#inputDescription').addClass('invalidInput');
        validationFlag = false;
    }if(inputPlace.length <= 0){
        $('#inputPlace').addClass('invalidInput');
        validationFlag = false;
    }if(inputPresident.length <= 0){
        $('#inputPresident').addClass('invalidInput');
        validationFlag = false;
    }

    if(validationFlag){
        $.ajax({
            url: 'updateClub.php',
            type:'POST',
            data:{
                'description': inputDescription,
                'place': inputPlace,
                'president': inputPresident,
                'dniClub': dniClub,
                'password': password
            },
            success: function($data){
                $data = JSON.parse($data);
                if($data.status == 'success'){
                    alertBox.style.opacity = "1";
                    $("#alert").html($data.message);
                    setTimeout(()=>{
                        alertBox.style.opacity = "0";
                    }, 2000);
                }else{
                    alertBox.style.opacity = "1";
                    $("#alert").html($data.message);
                    setTimeout(()=>{
                        alertBox.style.opacity = "0";
                    }, 2000);
                }
            },error: function(){
                console.log('ocurrio un error');
            }
        });
    }else{
        alertBox.style.opacity = "1";
        $("#alert").html('Completa todos los campos!');
        setTimeout(()=>{
            alertBox.style.opacity = "0";
        }, 2000);
    }
}