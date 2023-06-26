<?php
session_start();
if(!isset($_SESSION['user'])){
	header('location: ../login');
}
if($_SESSION['user'] > 100){
	header('location: ../perfil');
}
?>
<?php
$conn = mysqli_connect(
    'localhost', 
    'root', 
    '', 
    'famdb'
);

$sql = " select * from  athletes where dni = " . $_SESSION['user'];
$query = mysqli_query($conn,$sql);
while($row = mysqli_fetch_array($query)){
    $user = $row;
}

?>

<?php

if(!isset($_GET["new"])){
	header('location: default.php');
}

$sql = "select *, date(news.publishDate) as 'date', time(news.publishDate) as 'time' from news where news.ID_new = '" . $_GET['new'] . "';";
$query = mysqli_query($conn,$sql);
if(mysqli_num_rows($query) > 0 or $_GET['new'] == 0){
    while($row = mysqli_fetch_array($query)){
        $new = $row;
    }
}else{
    header('location: default.php');
}

?>

<?php include('../../public/pages/header.html'); ?>
<title>Noticia</title>
<link rel="stylesheet" href="https://foliotek.github.io/Croppie/croppie.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.4.1/croppie.min.js"></script>
<style><?php include('../../public/resources/css/adminNewsSelected.css')?></style>
</head>
<body>
<nav>
    <button id="backButtonContainer" onclick="window.history.back()">
        <svg width="41" height="41" viewBox="0 0 47 47" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M27.4166 19.5835L19.5833 27.4168" stroke="#C6C4CC" stroke-width="2.9375" stroke-linecap="round"/>
            <path d="M27.4166 27.4168L19.5833 19.5835" stroke="#C6C4CC" stroke-width="2.9375" stroke-linecap="round"/>
            <path d="M41.6147 23.4998C41.6147 13.4954 33.5045 5.38525 23.5001 5.38525C13.4957 5.38525 5.3855 13.4954 5.3855 23.4998C5.3855 33.5042 13.4957 41.6144 23.5001 41.6144C33.5045 41.6144 41.6147 33.5042 41.6147 23.4998Z" stroke="#C6C4CC" stroke-width="2.9375"/>
        </svg>
    </button>
</nav>

<?php
echo '<script>var newImages = []; var newImagesIterator = 0; var deleteFromDB = [];var mainNewImg = "";</script>';

if($_GET['new'] == 0){ ?>
    <main>
        <section class="container-lg">
            <p id="alert"></p>
            <h1>Crear noticia</h1>
            <div id="mainContent" class="row container-fluid">
                <div id="leftSide" class="col-12 col-lg-5">
                    <div id="box1" class="box">
                        <h2>Titulo</h2>
                        <input spellcheck="false" id="inputTitle" placeholder="Ingrese un titulo" type="text" maxlength="255">
                    </div>

                    <div id="box2" class="box">
                        <h2>Foto de portada</h2>
                        <img id='mainNewImg' src=''>
                        <button id="changeMainImg" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Seleccionar Foto</button>

                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title fs-5" id="exampleModalLabel">Subir Foto</h3>
                                        <button type="button" class="closeButton" data-bs-dismiss="modal">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18 6L6 18" stroke="#000" stroke-width="1.5" stroke-linecap="round"/>
                                                <path d="M18 18L6 6" stroke="#000" stroke-width="1.5" stroke-linecap="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="file">
                                            <input type="file" name="insert_image" id="insert_image" accept="image/*" />
                                            <label for="file">Ingresa la imagen</label>
                                        </p>
                                        <div id="image_demo"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-bs-dismiss="modal">Cancelar</button>
                                        <button class="crop_image" data-bs-dismiss="modal">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="box3" class="box">
                        <h2>Sub titulo</h2>
                        <textarea id="inputSubTitle" spellcheck="false" placeholder="Ingrese un sub titulo" rows='1' data-min-rows='1' class="autoExpand"></textarea>
                    </div>
                </div>
                <div id="rightSide" class="col-12 col-lg-7">
                    <div id="box4" class="box">
                        <h2>Cuerpo</h2>
                        <textarea id="inputBody" spellcheck="false" placeholder="Ingrese la noticia" rows='1' data-min-rows='1' class="autoExpand"></textarea>
                    </div>
                    <div id="box5" class="box">
                        <h2>Fotos (opcional)</h2>
                        <div id="indexedImgsContainer">
                            <div id="indexedImgsAuxiliar" class="row container-fluid">
                            </div>
                        </div> 
                        <button id="changeMainImg2" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal2">Subir Foto</button>
                        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title fs-5" id="exampleModalLabel">Subir Foto</h3>
                                        <button type="button" class="closeButton" data-bs-dismiss="modal">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18 6L6 18" stroke="#000" stroke-width="1.5" stroke-linecap="round"/>
                                                <path d="M18 18L6 6" stroke="#000" stroke-width="1.5" stroke-linecap="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="file">
                                            <input type="file" name="insert_image2" id="insert_image2" accept="image/*" />
                                            <label for="file">Ingresa la imagen</label>
                                        </p>
                                        <div id="image_demo2"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-bs-dismiss="modal">Cancelar</button>
                                        <button class="crop_image2" data-bs-dismiss="modal">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="box6" class="box">
                        <h2>Publicar noticia</h2>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal3">Publicar</button>
                        <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title fs-5" id="exampleModalLabel">Confirmar publicacion</h3>
                                        <button type="button" class="closeButton" data-bs-dismiss="modal">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18 6L6 18" stroke="#000" stroke-width="1.5" stroke-linecap="round"/>
                                                <path d="M18 18L6 6" stroke="#000" stroke-width="1.5" stroke-linecap="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" data-bs-dismiss="modal">Cancelar</button>
                                        <button onclick="publishNew()" data-bs-dismiss="modal">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php }else{ 
    echo '<script> mainNewImg = "data:image/png;base64,'. base64_encode($new['mainImg']) .'"</script>';
    ?>
    <main>
        <section class="container-lg">
            <p id="alert"></p>
            <h1>Crear noticia</h1>
            <div id="mainContent" class="row container-fluid">
                <div id="leftSide" class="col-12 col-lg-5">
                    <div id="box1" class="box">
                        <h2>Titulo</h2>
                        <input id="inputTitle" placeholder="Ingrese un titulo" value="<?php echo($new['title']);?>" type="text" maxlength="255">
                    </div>
                    <div id="box2" class="box">
                        <h2>Foto de portada</h2>
                        <?php echo '<img id="mainNewImg" src="data:image/png;base64,'.base64_encode($new['mainImg']).'" />';?>
                        <button id="changeMainImg" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Cambiar Foto</button>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title fs-5" id="exampleModalLabel">Cambiar Foto de Perfil</h3>
                                        <button type="button" class="closeButton" data-bs-dismiss="modal">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18 6L6 18" stroke="#000" stroke-width="1.5" stroke-linecap="round"/>
                                                <path d="M18 18L6 6" stroke="#000" stroke-width="1.5" stroke-linecap="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="file">
                                            <input type="file" name="insert_image" id="insert_image" accept="image/*" />
                                            <label for="file">Ingresa la imagen</label>
                                        </p>
                                        <div id="image_demo"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-bs-dismiss="modal">Cancelar</button>
                                        <button class="crop_image" data-bs-dismiss="modal">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="box3" class="box">
                        <h2>Sub titulo</h2>
                        <textarea spellcheck="false" id="inputSubTitle" placeholder="Ingrese un sub titulo" rows='3' data-min-rows='3' class="autoExpand"><?php echo($new['subTitle']);?></textarea>
                    </div>

                    <div id="box7" class="box">
                        <h2>Eliminar noticia</h2>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal4">Eliminar</button>
                        <div class="modal fade" id="exampleModal4" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title fs-5" id="exampleModalLabel">Confirmar eliminacion</h3>
                                        <button type="button" class="closeButton" data-bs-dismiss="modal">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18 6L6 18" stroke="#000" stroke-width="1.5" stroke-linecap="round"/>
                                                <path d="M18 18L6 6" stroke="#000" stroke-width="1.5" stroke-linecap="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" data-bs-dismiss="modal">Cancelar</button>
                                        <button onclick="deleteNew(<?php echo($new['ID_new'])?>)" data-bs-dismiss="modal">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="rightSide" class="col-12 col-lg-7">
                    <div id="box4" class="box">
                        <h2>Cuerpo</h2>
                        <textarea spellcheck="false" id="inputBody" placeholder="Ingrese la noticia" rows='' data-min-rows='' class="autoExpand"><?php echo($new['body']);?></textarea>
                    </div>
                    
                    <div id="box5" class="box">
                        <h2>Fotos (opcional)</h2>
                        <div id="indexedImgsContainer">
                            <div id="indexedImgsAuxiliar" class="row container-fluid">
                                <?php
                                $sql = "select * from newsimg where newsimg.ID_new = '" . $new['ID_new'] . "';";
                                $query = mysqli_query($conn,$sql);
                                $auxiliarIterator = 0;
                                while($row = mysqli_fetch_array($query)){
                                    echo '<div class="col-6 col-lg-4 item">
                                            <button onclick="this.parentNode.remove();; deleteFromDB.push(' . $row['ID_newImg'] . ')" type="button" class="deleteButton">
                                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="15" cy="15" r="13.875" stroke="#E74A3B" stroke-width="2.25"/>
                                                    <path d="M19.2427 19.2426L10.7574 10.7574M10.7574 19.2426L19.2427 10.7574" stroke="#E74A3B" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>                                        
                                            </button>
                                            <a href="data:image/png;base64,'.base64_encode($row['image']).'" data-lightbox="photos">
                                                <img class="img-fluid newImages" src="data:image/png;base64,'.base64_encode($row['image']).'">
                                            </a>
                                        </div>';
                                }
                                ?>
                            </div>
                        </div>
                        <button id="changeMainImg2" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal2">Subir Foto</button>
                        <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title fs-5" id="exampleModalLabel">Subir Foto</h3>
                                        <button type="button" class="closeButton" data-bs-dismiss="modal">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18 6L6 18" stroke="#000" stroke-width="1.5" stroke-linecap="round"/>
                                                <path d="M18 18L6 6" stroke="#000" stroke-width="1.5" stroke-linecap="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="file">
                                            <input type="file" name="insert_image2" id="insert_image2" accept="image/*" />
                                            <label for="file">Ingresa la imagen</label>
                                        </p>
                                        <div id="image_demo2"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-bs-dismiss="modal">Cancelar</button>
                                        <button class="crop_image2" data-bs-dismiss="modal">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="box6" class="box">
                        <h2>Editar noticia</h2>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal3">Editar</button>
                        <div class="modal fade" id="exampleModal3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title fs-5" id="exampleModalLabel">Confirmar edicion</h3>
                                        <button type="button" class="closeButton" data-bs-dismiss="modal">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18 6L6 18" stroke="#000" stroke-width="1.5" stroke-linecap="round"/>
                                                <path d="M18 18L6 6" stroke="#000" stroke-width="1.5" stroke-linecap="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" data-bs-dismiss="modal">Cancelar</button>
                                        <button onclick="updateNew(<?php echo($new['ID_new'])?>)" data-bs-dismiss="modal">Aceptar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php } ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
<script><?php include('../../public/resources/js/adminNewsSelected.js'); ?></script>
<?php include('../../public/pages/footer.html'); ?>