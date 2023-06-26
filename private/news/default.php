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

<?php include('../../public/pages/header.html'); ?>
<title>News</title>
<style><?php include('../../public/resources/css/adminNews.css')?></style>
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
    <section class="row">
        <div class='col-12 col-md-11 col-lg-10'>
            <h1>Noticias</h1>
            <form method="GET" action="news.php" class="row">
                <?php
                    echo("<button type='submit' name='new' value='0' class='newsItem create col-6 col-sm-4 col-lg-3 col-xl-2'>
                            <div class='newsItemContainer'>
                                <svg width='45' height='45' viewBox='0 0 45 45' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                    <circle cx='22.5' cy='22.5' r='21.375' stroke='#36B9CC' stroke-width='2.25'/>
                                    <path d='M23 32L23 14M14 23L32 23' stroke='#36B9CC' stroke-width='2.25' stroke-linecap='round' stroke-linejoin='round'/>
                                </svg>
                                <p class='newsTitle'>Nueva Noticia</p>
                            </div>
                        </button>");
                    $query = "select *, date(news.publishDate) as 'date', time(news.publishDate) as 'time' from news order by news.publishDate DESC;";
                    $result = $conn->query($query);
                    while($row = $result->fetch_assoc()){
                        $imageAux = "<img src='data:image/png;base64,". base64_encode($row['mainImg']). "' />";

                        echo("<button type='submit' name='new' value='" . $row['ID_new'] . "' class='newsItem col-6 col-sm-4 col-lg-3 col-xl-2'>
                            <div class='newsItemContainer'>
                                <div class='newsImage'>$imageAux</div>
                                <p class='newsTitle'>" . $row['title'] . "</p>
                                <p class='newsDate'>" . $row['date'] . "</p>
                            </div>
                        </button>");
                    }
                ?>
            </form>
        </div>
    </section>
</main>

<?php include('../../public/pages/footer.html'); ?>