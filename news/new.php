<?php
include('../private/database/db.php');
?>

<?php

if(!isset($_GET["new"])){
	header('location: default.php');
}

$sql = "select *, date(news.publishDate) as 'date', time(news.publishDate) as 'time' from news where news.ID_new = '" . $_GET['new'] . "';";
$query = mysqli_query($conn,$sql);
if(mysqli_num_rows($query) > 0){
    while($row = mysqli_fetch_array($query)){
        $new = $row;
    }
}else{
    header('location: default.php');
}

?>

<?php include('../public/pages/header.html'); ?>
<title>Noticia</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<style><?php include('../public/resources/css/homeNewSelected.css')?></style>
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

<main>
    <section class="container-lg">
        <h1><?php echo($new['title']);?></h1>
        <div id="mainContent" class="row container-fluid">
            <div id="leftSide" class="col-12 col-lg-5">

                <div id="box2" class="box">
                    <?php echo '<img id="mainNewImg" src="data:image/png;base64,'.base64_encode($new['mainImg']).'" />';?>
                    <p id="dateIndicator"><?php echo($new['date']); ?></p>
                </div>

                <div id="box3" class="box">
                <p><?php echo($new['subTitle']);?></p>
                </div>
            </div>
            <div id="rightSide" class="col-12 col-lg-7">
                <div id="box4" class="box">
                    <p><?php echo($new['body']);?></p>
                </div>

                <?php
                $sql = "select * from newsimg where newsimg.ID_new = '" . $new['ID_new'] . "';";
                $query = mysqli_query($conn,$sql);
                if(mysqli_num_rows($query) > 0){
                    echo '<div id="box5" class="box">
                            <h2>Fotos</h2>
                            <div id="indexedImgsContainer">
                                <div id="indexedImgsAuxiliar" class="row container-fluid">';
                    while($row = mysqli_fetch_array($query)){
                        echo '<div class="col-6 col-lg-4 item">
                                <a href="data:image/png;base64,'.base64_encode($row['image']).'" data-lightbox="photos">
                                    <img class="img-fluid newImages" src="data:image/png;base64,'.base64_encode($row['image']).'">
                                </a>
                            </div>';
                    }
                    echo '      </div>
                            </div>
                        </div>';
                }
                
                ?>
            </div>
        </div>
    </section>
</main>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox.min.js"></script>
<script><?php include('../public/resources/js/homeNewSelected.js'); ?></script>
<?php include('../public/pages/footer.html'); ?>