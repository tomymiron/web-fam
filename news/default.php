<?php
include('../private/database/db.php');
?>

<?php include('../public/pages/header.html'); ?>
<title>Noticias</title>
<style><?php include('../public/resources/css/homeNews.css')?></style>
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
    <section class="container-xxl">
        <div>
            <h1>Noticias</h1>
            <form method="GET" action="new.php" id="mainContent" class="row">
                <?php
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

<script><?php include('../public/resources/js/homeNews.js');?></script>
<?php include('../public/pages/footer.html'); ?>