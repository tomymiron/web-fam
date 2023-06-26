<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700;800;900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,400&display=swap" rel="stylesheet">
    <link rel="icon" href="/public/img/famLogo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://foliotek.github.io/Croppie/croppie.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.1/croppie.min.js"></script>
    <title>Auxiliar</title>  
    <style>
           
        .modal-content{
            background-color: #1e1f25 !important;
        }.modal-header{
            border-bottom: none;
            border-bottom: 2px solid #34495E;
        }.modal-footer{
            border-top: none;
            border-top: 2px solid #34495E;
        }.modal button{
            border: none;
            padding: .4rem 1rem;
            border-radius: calc(.25rem + .075vw);
            background-color: #00c7e3;
            color: #000;
            margin: .5rem 0;
            outline: none;
            margin-right: 1rem;
        }.modal .closeButton{
            background-color: #6c757d;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: .45rem;
            font-weight: bolder;
            width: 30px;
            height: 30px;
        }.modal h3{
            color: #f2f2f2;
        }
        .file{
            position: relative;
            width: 100%;
        }
        .file label {
            background: #34495E;
            padding: 5px 20px;
            color: #fff;
            font-weight: bold;
            font-size: .9em;
            width: 100%;
            transition: all .4s;
        }
        .file input {
            color: #34495E;
            position: absolute;
            display: inline-block;
            left: 0;
            top: 0;
            opacity: 0.01;
            width: 100%;
            cursor: pointer;
        }
        .file input:hover + label,
        .file input:focus + label {
            color: #34495E;
            background: #39D2B4;
        }
        .cr-slider-wrap{
            margin-bottom: 0;
        }
        #image_demo{
            display: none;
        }
        #image_demo.visible{
            display: block;
        }
    </style>
</head>  
<body>  
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Cambiar Foto</button>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="exampleModalLabel">Cambiar Foto de Perfil</h3>
                    <button type="button" class="closeButton" data-bs-dismiss="modal">&#x2715</button>
                </div>
                <div class="modal-body">
                    <p class="file">
                        <input type="file" name="insert_image" id="insert_image" accept="image/*" />
                        <label for="file">Upload your image</label>
                    </p>
                    <div id="image_demo"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn crop_image">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="store_image"></div>

</div>
</body>  
</html>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
<script>  
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
                    console.log('jQuery bind complete');
                });
                $('#image_demo').addClass('visible');
                $('.cr-slider').addClass('form-range');
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('.crop_image').click(function(event){
            $image_crop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
            }).then(function(response){
                $.ajax({
                    url:'upload.php',
                    type:'POST',
                    data:{"image":response},
                    success:function(data){
                        alert(data);
                    }
                })
            });
        });
    });  
</script>