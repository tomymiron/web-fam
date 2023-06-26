const alertBox = document.getElementById("alert");

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

function deleteImg(num){
    const element = document.getElementById('deleteImg' + num);
    newImages[num] = '';
    element.remove();
}


$(document).ready(function(){

    $image_crop = $('#image_demo').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'square'
        },
        boundary:{height: 300}    
    });
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
        $image_crop.croppie('result', {
        type: 'canvas',
        size: {width: 800, height: 800}
        }).then(function(response){
            mainNewImg = response;
            $('#changeMainImg').attr("style", "background-color: #00c7e3; font-weight: 400;");
            $('#mainNewImg').attr('style', 'border: 0.15rem solid #0dcaf0;');
            $('#mainNewImg').attr('src', response);
            $('#changeMainImg').text('Seleccionar otra foto');
        });
    });
    // --------------------------------------------------------------- //
    
    $image_crop2 = $('#image_demo2').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'square'
        },
        boundary:{height: 300}    
    });
    $('#insert_image2').on('change', function(){
        var reader2 = new FileReader();
        reader2.onload = function (event) {
            $image_crop2.croppie('bind', {
                url: event.target.result
            }).then(function(){
                console.log('ok');
            });
            $('#image_demo2').addClass('visible');
            $('.cr-slider').addClass('form-range');
        }
        reader2.readAsDataURL(this.files[0]);
    });
    $('.crop_image2').click(function(event){
        $image_crop2.croppie('result', {
        type: 'canvas',
        size: {width: 800, height: 800}
        }).then(function(response){
            newImages[newImagesIterator] = response;
            $('#indexedImgsAuxiliar').append('<div id="deleteImg' + newImagesIterator + '" class="col-6 col-lg-4 item"><button onclick="deleteImg(' + newImagesIterator + ')" type="button" class="deleteButton"><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="15" cy="15" r="13.875" stroke="#E74A3B" stroke-width="2.25"/><path d="M19.2427 19.2426L10.7574 10.7574M10.7574 19.2426L19.2427 10.7574" stroke="#E74A3B" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/></svg></button><a href="' + response + '" data-lightbox="photos"><img class="newImages img-fluid" src="' + response + '"></a></div>');
            newImagesIterator++;
        });
    });
});

function publishNew(){
    let inputTitle = $('#inputTitle').val();
    let inputSubTitle = $('#inputSubTitle').val();
    let inputBody = $('#inputBody').val();
    let newImagesAux = [];
    for(let i = 0; i < newImages.length; i++){
        if(newImages[i] != ''){
            newImagesAux.push(newImages[i]);
        }
    }
    let validationFlag = true;
    if(inputTitle.length <= 0){
        $('#inputTitle').addClass('invalidInput');
        validationFlag = false;
    }if(mainNewImg.length <= 0){
        $('#changeMainImg').attr("style", "background-color: #E74A3B; font-weight: 600;");
        validationFlag = false;
    }if(inputSubTitle.length <= 0){
        $('#inputSubTitle').addClass('invalidInput');
        validationFlag = false;
    }if(inputBody.length <= 0){
        $('#inputBody').addClass('invalidInput');
        validationFlag = false;
    }

    if(validationFlag){
        $.ajax({
            url: 'createNews.php',
            type:'POST',
            data:{
                'title': inputTitle,
                'mainNewImg': mainNewImg,
                'subTitle': inputSubTitle,
                'body': inputBody,
                'newImages': JSON.stringify(newImagesAux)
            },
            success: function($data){
                $data = JSON.parse($data);
                if($data.status == 'success'){
                    window.location.href = 'news.php?new=' + $data.message;
                }else{
                    alertBox.style.opacity = "1";
                    $("#alert").html($data.message);
                    setTimeout(()=>{
                        alertBox.style.opacity = "0";
                    }, 2000);
                }
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

function updateNew(id_new){
    let inputTitle = $('#inputTitle').val();
    let inputSubTitle = $('#inputSubTitle').val();
    let inputBody = $('#inputBody').val();
    let newImagesAux = [];
    for(let i = 0; i < newImages.length; i++){
        if(newImages[i] != ''){
            newImagesAux.push(newImages[i]);
        }
    }
    console.log(inputTitle, inputSubTitle, inputBody, newImages, deleteFromDB, mainNewImg);
    let validationFlag = true;
    if(inputTitle.length <= 0){
        $('#inputTitle').addClass('invalidInput');
        validationFlag = false;
    }if(mainNewImg.length <= 0){
        $('#changeMainImg').attr("style", "background-color: #E74A3B; font-weight: 600;");
        validationFlag = false;
    }if(inputSubTitle.length <= 0){
        $('#inputSubTitle').addClass('invalidInput');
        validationFlag = false;
    }if(inputBody.length <= 0){
        $('#inputBody').addClass('invalidInput');
        validationFlag = false;
    }

    if(validationFlag){
        $.ajax({
            url: 'updateNews.php',
            type:'POST',
            data:{
                'title': inputTitle,
                'mainNewImg': mainNewImg,
                'subTitle': inputSubTitle,
                'body': inputBody,
                'newImages': JSON.stringify(newImagesAux),
                'deleteImages': JSON.stringify(deleteFromDB),
                'id_new': id_new
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

function deleteNew(id_new){
    if(id_new != ''){
        $.ajax({
            url: 'deleteNew.php',
            type:'POST',
            data:{
                'id_new': id_new
            },
            success: function($data){
                $data = JSON.parse($data);
                if($data.status == 'success'){
                    window.location.href = 'default.php';
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
    }
}